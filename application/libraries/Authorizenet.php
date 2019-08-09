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

    public $amountToProcess;
    public $amountTrial;
    public $orderNumber;
    public $creditCardInfo = array(
        'card_number',
        'exp_date',
        'cvc_code'
    );
    public $billingAddressInfo = array(
        'firstName',
        'lastName',
        'address',
        'city',
        'state',
        'zip',
        'country'
    );
    public $shippingAddressInfo = array(
        'firstName',
        'lastName',
        'address',
        'city',
        'state',
        'zip',
        'country'
    );
    public $subscriptionInfo = array(
        'title',
        'descp',
        'amount',
        'trialAmount',
        'startDate', //format YYYY-MM-DD
        'intervalLength',
        'intervalUnit',
        'totalOccurence',
        'trialOccurence',
        'order',
        'customer',
        'billTo',
        'shipTo',
        'profile'
    );
    public $customerInfo = array(
        'custType',
        'custId',
        'custEmail'
    );
//    Auth Variables
    private $transactionType = array(
        'authorize' => 'authOnlyTransaction',
        'voidTransaction' => 'voidTransaction',
        'authCapture' => 'authCaptureTransaction'
    );
    private $authBillTo;
    private $authCreditCard;
    private $authInterval;
    private $authOrder;
    private $authPayment;
    private $authPaymentSchedule;
    private $authRequest;
    private $authShipTo;
    private $authSubscription;
    private $authTransactionRequestType;
    private $authCustomerData;

    public function __construct() {

        $this->activateSandboxMode();
        $this->setEnvoirnment();
        $this->refId = 'ref' . time();
        $this->setMerchantLogin();
    }

    private function setEnvoirnment() {
        !$this->sandBox ?
                        $this->environment = APIconstant\ANetEnvironment::PRODUCTION :
                        $this->environment = APIconstant\ANetEnvironment::SANDBOX;
        return;
    }

    private function setMerchantLogin() {
        switch ($this->environment) {
            case APIconstant\ANetEnvironment::PRODUCTION:
                $this->MERCHANT_LOGIN_ID = '';
                $this->MERCHANT_TRANSACTION_KEY = '';
                break;
            case APIconstant\ANetEnvironment::SANDBOX :
            default :
                $this->MERCHANT_LOGIN_ID = "3wX3X2gs2b";
                $this->MERCHANT_TRANSACTION_KEY = "3D9KntkY3SM29t36";
                break;
        }

        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName($this->MERCHANT_LOGIN_ID);
        $this->merchantAuthentication->setTransactionKey($this->MERCHANT_TRANSACTION_KEY);
        return;
    }

    public function activateSandboxMode($mode = TRUE) {
        $this->sandBox = $mode;
        return;
    }

    public function voidTransaction($transactionId) {
        //create a transaction
        $this->authTransactionRequestType = new AnetAPI\TransactionRequestType();
        $this->authTransactionRequestType->setTransactionType($this->transactionType['voidTransaction']);
        $this->authTransactionRequestType->setRefTransId($transactionId);

        $this->setRequest();

        $controller = new AnetController\CreateTransactionController($this->authRequest);
        $response = $controller->executeWithApiResponse($this->environment);

        return $this->responseCCTransaction($response);
    }

    public function runAuthorization() {
        // Create the payment data for a credit card
        $this->setCreditCard();

        // Add the payment data to a paymentType object
        $this->setPayment();

        // Create a TransactionRequestType object and add the previous objects to it
        $this->setTransationType($this->transactionType['authorize']);

        // Assemble the complete transaction request
        $this->setRequest();

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($this->authRequest);
        $authResponse = $controller->executeWithApiResponse($this->environment);

        return $this->responseCCTransaction($authResponse);
    }

    public function chargeCreditCard() {

        $this->setCreditCard();
        $this->setPayment();

        // Create order information
        $this->authOrder = new AnetAPI\OrderType();
        $this->authOrder->setInvoiceNumber($this->orderNumber);

        // Set the customer's Bill & Ship To address
        $this->authBillTo = $this->setCustomerAddress($this->billingAddressInfo);
        $this->authShipTo = $this->setCustomerAddress($this->shippingAddressInfo);

        // Set the customer's identifying information
        $this->setCustomer();

        // Create a TransactionRequestType object and add the previous objects to it
        $this->setTransationType($this->transactionType['authCapture']);

        // Assemble the complete transaction request
        $this->setTransactionRequest();

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($this->authRequest);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        return $this->responseCCTransaction($response);
    }

    public function arbCreate() {

        $this->setInterval();
        $this->setPaymentSchedule();
        $this->setCreditCard();
        $this->setPayment();
        $this->authBillTo = $this->setAddress($this->billingAddressInfo);
        $this->authOrder = new AnetAPI\OrderType();
        $this->authOrder->setInvoiceNumber($this->refId);
        $this->authOrder->setDescription($this->subscriptionInfo['descp']);
        // Subscription Type Info
        $this->setSubscription();
        $this->setSubscriptionRequest();
        $controller = new AnetController\ARBCreateSubscriptionController($this->authRequest);
        $response = $controller->executeWithApiResponse($this->environment);

        return $this->responseARBsubscription($response);
    }

    public function arbUpdateCC($subscriptionId) {

        $this->setCreditCard();
        $this->setPayment();

        $subscription = new AnetAPI\ARBSubscriptionType();

        $this->setARBupdateReqeuest($subscriptionId, $subscription->setPayment($this->authPayment));

        $controller = new AnetController\ARBUpdateSubscriptionController($this->authRequest);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        return $this->responseARBsubscription($response, FALSE);
    }

    private function setSubscription() {
        $this->authSubscription = new AnetAPI\ARBSubscriptionType();
        $this->authSubscription->setName($this->subscriptionInfo['title']);
        $this->authSubscription->setPaymentSchedule($this->authPaymentSchedule);
        $this->authSubscription->setAmount($this->subscriptionInfo['amount']);
        $this->authSubscription->setTrialAmount($this->subscriptionInfo['trialAmount']);
        $this->authSubscription->setPayment($this->authPayment);
        $this->authSubscription->setOrder($this->authOrder);
        $this->authSubscription->setBillTo($this->authBillTo);
        return;
    }

    private function setPaymentSchedule() {
        $this->authPaymentSchedule = new AnetAPI\PaymentScheduleType();
        $this->authPaymentSchedule->setInterval($this->authInterval);
        $this->authPaymentSchedule->setStartDate(new DateTime($this->subscriptionInfo['startDate']));
        $this->authPaymentSchedule->setTotalOccurrences($this->subscriptionInfo['totalOccurence']);
        $this->authPaymentSchedule->setTrialOccurrences($this->subscriptionInfo['trialOccurence']);
        return;
    }

    private function setInterval() {
        $this->authInterval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $this->authInterval->setLength($this->subscriptionInfo['intervalLength']);
        $this->authInterval->setUnit($this->subscriptionInfo['intervalUnit']);
        return;
    }

    private function setCreditCard() {
        $this->authCreditCard = new AnetAPI\CreditCardType();
        $this->authCreditCard->setCardNumber($this->creditCardInfo['card_number']);
        $this->authCreditCard->setExpirationDate($this->creditCardInfo['exp_date']);
        $this->authCreditCard->setCardCode($this->creditCardInfo['cvc_code']);
        return;
    }

    private function setCustomer() {
        $this->authCustomerData = new AnetAPI\CustomerDataType();
        $this->authCustomerData->setType($this->customerInfo['custType']);
        $this->authCustomerData->setId($this->customerInfo['custId']);
        $this->authCustomerData->setEmail($this->customerInfo['custEmail']);
        return;
    }

    private function setPayment() {
        $this->authPayment = new AnetAPI\PaymentType();
        $this->authPayment->setCreditCard($this->authCreditCard);
        return;
    }

    private function setTransationType($transactionType) {
        $this->authTransactionRequestType = new AnetAPI\TransactionRequestType();
        $this->authTransactionRequestType->setTransactionType($transactionType);
        $this->authTransactionRequestType->setAmount($this->amountToProcess);
        $this->authTransactionRequestType->setPayment($this->authPayment);

        if ($transactionType == $this->transactionType['authCapture']) {
            $this->authTransactionRequestType->setOrder($this->authOrder);
            $this->authTransactionRequestType->setBillTo($this->authBillTo);
            $this->authTransactionRequestType->setShipTo($this->authShipTo);
            $this->authTransactionRequestType->setCustomer($this->authCustomerData);
        }

        return;
    }

    private function setSubscriptionRequest() {
        $this->authRequest = new AnetAPI\ARBCreateSubscriptionRequest();
        $this->setMerchantAuth();
        $this->authRequest->setSubscription($this->authSubscription);
        return;
    }

    private function setARBupdateReqeuest($subscriptionId, $subscription) {
        $this->authRequest = new AnetAPI\ARBUpdateSubscriptionRequest();
        $this->setMerchantAuth();
        $this->authRequest->setSubscriptionId($subscriptionId);
        $this->authRequest->setSubscription($subscription);
    }

    private function setTransactionRequest() {
        $this->authRequest = new AnetAPI\CreateTransactionRequest();
        $this->authRequest->setMerchantAuthentication($this->merchantAuthentication);
        $this->authRequest->setRefId($this->refId);
        $this->authRequest->setTransactionRequest($this->authTransactionRequestType);
    }

    private function setRequest() {
        $this->authRequest = new AnetAPI\CreateTransactionRequest();
        $this->setMerchantAuth();
        $this->authRequest->setTransactionRequest($this->authTransactionRequestType);
        return;
    }

    private function setMerchantAuth() {
        $this->authRequest->setMerchantAuthentication($this->merchantAuthentication);
        $this->authRequest->setRefId($this->refId);
        return;
    }

    private function setAddress($addressInfo) {
        $address = new AnetAPI\NameAndAddressType();
        $address->setFirstName($addressInfo['firstName']);
        $address->setLastName($addressInfo['lastName']);
        $address->setAddress($addressInfo['address']);
        $address->setCity($addressInfo['city']);
        $address->setState($addressInfo['state']);
        $address->setZip($addressInfo['zip']);
        $address->setCountry($addressInfo['country']);
        return $address;
    }

    private function setCustomerAddress($addressInfo) {
        $address = new AnetAPI\CustomerAddressType();
        $address->setFirstName($addressInfo['firstName']);
        $address->setLastName($addressInfo['lastName']);
        $address->setAddress($addressInfo['address']);
        $address->setCity($addressInfo['city']);
        $address->setState($addressInfo['state']);
        $address->setZip($addressInfo['zip']);
        $address->setCountry($addressInfo['country']);
        return $address;
    }

    private function responseCCTransaction($authResponse) {
        if ($authResponse != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($authResponse->getMessages()->getResultCode() == APIconstant\ANetEnvironment::RESPONSE_OK) {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $authResponse->getTransactionResponse();

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
                } elseif ($tresponse->getErrors() != null) {
                    $returnResponse = array(
                        'transaction_status' => FALSE,
                        'error_code' => $tresponse->getErrors()[0]->getErrorCode(),
                        'error_message' => $tresponse->getErrors()[0]->getErrorText()
                    );
                } else {
                    $returnResponse = array(
                        'transaction_status' => FALSE,
                        'error_code' => '----',
                        'error_message' => 'Unknow Error.'
                    );
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $tresponse = $authResponse->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $returnResponse = array(
                        'transaction_status' => FALSE,
                        'error_code' => $tresponse->getErrors()[0]->getErrorCode(),
                        'error_message' => $tresponse->getErrors()[0]->getErrorText()
                    );
                } else {
                    $returnResponse = array(
                        'transaction_status' => FALSE,
                        'error_code' => $authResponse->getMessages()->getMessage()[0]->getCode(),
                        'error_message' => $authResponse->getMessages()->getMessage()[0]->getText()
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
    
    private function responseARBsubscription($response, $newSubscription = TRUE) {
        if (($response != null) && ($response->getMessages()->getResultCode() == APIconstant\ANetEnvironment::RESPONSE_OK)) {
            $message = $response->getMessages()->getMessage();
            $returnResponse = array(
                'transaction_status' => TRUE,
                'subscription_id' => $newSubscription ? $response->getSubscriptionId() : '',
                'ref_id' => $response->getRefId(),
                'message_code' => $message[0]->getCode(),
                'description' => $message[0]->getText()
            );
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $returnResponse = array(
                'transaction_status' => FALSE,
                'error_code' => $errorMessages[0]->getCode(),
                'error_message' => $errorMessages[0]->getText()
            );
        }
        return $returnResponse;
    }

}
