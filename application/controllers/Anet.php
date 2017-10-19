<?php

class Anet extends karmora {

    private $authObj;
    public function __construct() {
        parent::__construct();
        $this->load->library('authorizenet');
        $this->authObj = new authorizenet;
    }

    public function index() {
        $this->authObj->activateSandboxMode(TRUE);
        echo '<pre>';
//        var_dump($this->authObj->chargeCC(199));
        $this->authObj->creditCard['card_number'] = '4111111111111111';
        $this->authObj->creditCard['exp_date'] = '2038-12';
        $this->authObj->creditCard['cvc_code'] = '123';
        $this->authObj->amountToProcess = rand(10, 20);
        var_dump($this->authObj->runAuthorization());
        echo '</pre>';
        exit;
    }
    
    public function arbCreate() {
        echo '<pre>';
        var_dump($this->authObj->arbCreate());
        echo '</pre>';
        exit;
    }

}