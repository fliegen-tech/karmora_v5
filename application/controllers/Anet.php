<?php

class Anet extends karmora {

    private $authObj;

    public function __construct() {
        parent::__construct();
        $this->load->library('authorizenet');
        $this->authObj = new authorizenet;
        $this->authObj->activateSandboxMode(TRUE);
    }

    public function index() {
        echo '<pre>';

        $this->authObj->creditCardInfo['card_number'] = '4111111111111111';
        $this->authObj->creditCardInfo['exp_date'] = '2038-12';
        $this->authObj->creditCardInfo['cvc_code'] = '123';

        var_dump($this->authObj->arbUpdateCC('4794875'));
        echo '</pre>';
        exit;
    }

    public function chargeCC() {
        echo '<pre>';

        $this->authObj->creditCardInfo['card_number'] = '4111111111111111';
        $this->authObj->creditCardInfo['exp_date'] = '2038-12';
        $this->authObj->creditCardInfo['cvc_code'] = '123';

        $this->authObj->billingAddressInfo = array(
            'firstName' => 'Ellen',
            'lastName' => 'Johnson',
            'address' => '14 Main Street',
            'city' => 'Pecan Springs',
            'state' => 'TX',
            'zip' => '44628',
            'country' => 'USA'
        );

        $this->authObj->shippingAddressInfo = array(
            'firstName' => 'Ellen',
            'lastName' => 'Johnson',
            'address' => '14 Main Street',
            'city' => 'Pecan Springs',
            'state' => 'TX',
            'zip' => '44628',
            'country' => 'USA'
        );

        $this->authObj->customerInfo = array(
            'custType' => 'individual',
            'custId' => uniqid('dummyId'),
            'custEmail' => uniqid() . '@yopmial.com'
        );

        $this->authObj->orderNumber = uniqid('order#');
        $this->authObj->amountToProcess = rand(10, 20);

        var_dump($this->authObj->chargeCreditCard());
        echo '</pre>';
        exit;
    }

    public function createARB() {
        echo '<pre>';
        $this->authObj->creditCardInfo['card_number'] = '4111111111111111';
        $this->authObj->creditCardInfo['exp_date'] = '2038-12';
        $this->authObj->creditCardInfo['cvc_code'] = '123';

        $this->authObj->billingAddressInfo = array(
            'firstName' => 'David',
            'lastName' => 'Mathew',
            'address' => 'Suit 101',
            'city' => 'Carson',
            'state' => 'IL',
            'zip' => '12345',
            'country' => 'US'
        );
        $this->authObj->subscriptionInfo = array(
            'title' => 'Monthly Subscrtiption',
            'descp' => 'Monthly Subscrtiption',
            'amount' => rand(10, 20),
            'trialAmount' => 0,
            'startDate' => date('Y-m-d'), //format YYYY-MM-DD
            'intervalLength' => 1,
            'intervalUnit' => 'months',
            'totalOccurence' => 9999,
            'trialOccurence' => 1
        );
        var_dump($this->authObj->arbCreate());
        echo '</pre>';
        exit;
    }

    public function voidTransaction() {

        echo '<pre>';
        var_dump($this->authObj->voidTransaction('60032345282'));
        echo '</pre>';
        exit;
    }

    public function runAuthorization() {
        echo '<pre>';

        $this->authObj->creditCardInfo['card_number'] = '4111111111111111';
        $this->authObj->creditCardInfo['exp_date'] = '2038-12';
        $this->authObj->creditCardInfo['cvc_code'] = '123';

        $this->authObj->amountToProcess = rand(10, 20);
        $this->authObj->amountTrial = 0;
        var_dump($this->authObj->runAuthorization());
        echo '</pre>';
        exit;
    }

}
