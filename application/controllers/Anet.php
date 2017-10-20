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

        $this->authObj->amountToProcess = rand(10, 20);
        
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
