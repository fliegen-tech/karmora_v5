<?php

if (!defined('BASEPATH'))
    exit('no direct script access allowed');

include './vendor/autoload.php';

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use net\authorize\api\constants as APIconstant;

class authorizenet {

    public $merchantAuthentication;
    public $refId;
    private $environment;
    public $MERCHANT_LOGIN_ID;
    public $MERCHANT_TRANSACTION_KEY;
    public $sandBox;
    
//    info variables
    
    public $creditCard = array(
        'card_number',
        'exp_date',
        'cvc_code'
    );
    
    public $amountToProcess;

    public function __construct() {

        $this->activateSandboxMode();

        $this->refId = 'ref' . time();
        $this->sandBox ? $this->environment = APIconstant\ANetEnvironment::SANDBOX : $this->environment = APIconstant\ANetEnvironment::PRODUCTION;

        switch ($this->environment) {
            case APIconstant\ANetEnvironment::SANDBOX:
                $this->MERCHANT_LOGIN_ID = "3wX3X2gs2b";
                $this->MERCHANT_TRANSACTION_KEY = "3D9KntkY3SM29t36";
                break;
            case APIconstant\ANetEnvironment::PRODUCTION:
                $this->MERCHANT_LOGIN_ID = '';
                $this->MERCHANT_TRANSACTION_KEY = '';
                break;
        }

        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName($this->MERCHANT_LOGIN_ID);
        $this->merchantAuthentication->setTransactionKey($this->MERCHANT_TRANSACTION_KEY);
    }

    public function activateSandboxMode($mode = TRUE) {
        $this->sandBox = $mode;
        return;
    }

    public function arbCreate() {
        $intervalLength = 1;
        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName("Sample Subscription");

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength($intervalLength);
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new DateTime('2017-10-05'));
        $paymentSchedule->setTotalOccurrences("12");
        $paymentSchedule->setTrialOccurrences("1");

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount(rand(1, 99999) / 12.0 * 12);
        $subscription->setTrialAmount("0.00");

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber("4111111111111111");
        $creditCard->setExpirationDate("2038-12");

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);
        $subscription->setPayment($payment);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber("1234354");
        $order->setDescription("Description of the subscription");
        $subscription->setOrder($order);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName("John");
        $billTo->setLastName("Smith");

        $subscription->setBillTo($billTo);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);

        $response = $controller->executeWithApiResponse($this->environment);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";
        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
        }

        return $response;
    }

    public function runAuthorization() {
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($this->creditCard['card_number']);
        $creditCard->setExpirationDate($this->creditCard['exp_date']);
        $creditCard->setCardCode($this->creditCard['cvc_code']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        /*
         * not required

          // Create order information
          $order = new AnetAPI\OrderType();
          $order->setInvoiceNumber("10101");
          $order->setDescription("Golf Shirts");

          // Set the customer's Bill To address
          $customerAddress = new AnetAPI\CustomerAddressType();
          $customerAddress->setFirstName("Ellen");
          $customerAddress->setLastName("Johnson");
          $customerAddress->setCompany("Souveniropolis");
          $customerAddress->setAddress("14 Main Street");
          $customerAddress->setCity("Pecan Springs");
          $customerAddress->setState("TX");
          $customerAddress->setZip("44628");
          $customerAddress->setCountry("USA");

          // Set the customer's identifying information
          $customerData = new AnetAPI\CustomerDataType();
          $customerData->setType("individual");
          $customerData->setId("99999456654");
          $customerData->setEmail("EllenJohnson@example.com");

          // Add values for transaction settings
          $duplicateWindowSetting = new AnetAPI\SettingType();
          $duplicateWindowSetting->setSettingName("duplicateWindow");
          $duplicateWindowSetting->setSettingValue("60");

          // Add some merchant defined fields. These fields won't be stored with the transaction,
          // but will be echoed back in the response.
          $merchantDefinedField1 = new AnetAPI\UserFieldType();
          $merchantDefinedField1->setName("customerLoyaltyNum");
          $merchantDefinedField1->setValue("1128836273");

          $merchantDefinedField2 = new AnetAPI\UserFieldType();
          $merchantDefinedField2->setName("favoriteColor");
          $merchantDefinedField2->setValue("blue");
         */
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authOnlyTransaction");
        $transactionRequestType->setAmount($this->amountToProcess);
//        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
//        $transactionRequestType->setBillTo($customerAddress);
//        $transactionRequestType->setCustomer($customerData);
//        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
//        $transactionRequestType->addToUserFields($merchantDefinedField1);
//        $transactionRequestType->addToUserFields($merchantDefinedField2);
        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse($this->environment);


        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == APIconstant\ANetEnvironment::RESPONSE_OK) {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $returnResponse = array(
                        'transaction_status' => TRUE,
                        'transaction_id' => $tresponse->getTransId(),
                        'ref_id' => $this->refId,
                        'transaction_response_code' => $tresponse->getResponseCode(),
                        'message_code' => $tresponse->getMessages()[0]->getCode(),
                        'auth_code' => $tresponse->getAuthCode(),
                        'description' => $tresponse->getMessages()[0]->getDescription()
                    );
                } else {
                    if ($tresponse->getErrors() != null) {
                        $returnResponse = array(
                            'transaction_status' => FALSE,
                            'error_code' => $tresponse->getErrors()[0]->getErrorCode(),
                            'error_message' => $tresponse->getErrors()[0]->getErrorText()
                        );
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $returnResponse = array(
                        'transaction_status' => FALSE,
                        'error_code' => $tresponse->getErrors()[0]->getErrorCode(),
                        'error_message' => $tresponse->getErrors()[0]->getErrorText()
                    );
                } else {
                    $returnResponse = array(
                        'transaction_status' => FALSE,
                        'error_code' => $response->getMessages()->getMessage()[0]->getCode(),
                        'error_message' => $response->getMessages()->getMessage()[0]->getText()
                    );
                }
            }
        } else {
            $returnResponse = array(
                'transaction_status' => FALSE,
                'error_code' => '-',
                'error_message' => 'No response returned'
            );
        }
        return $returnResponse;
    }

}
