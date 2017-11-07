<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajaxcallz extends karmora {

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('usermodel','commonmodel'));
    }
    function authrioze($username = null){
            //$this->session->unset_userdata('landing_data'); // unset your sessions
        $postLim = $this->input->post();
        echo '<pre>';print_r($postLim); die;
        $responce = $this->runauthrioze($postLim);
        if($responce === FALSE){
            echo 'error'; die;
        }else{
            echo $responce->trans_id; die;
        }
    }

    public function congrats($shopper_program, $username = null, $orde_number = null) {
        $this->verifyUser($username);
        $this->cart->destroy(); // Destroy all cart data
        $data['oderdetail'] = '';
        $data['themeUrl'] = $this->themeUrl;
        $detail = $this->getUserDetails($this->session->userdata('front_data')['username']);
        if ($orde_number != NULL) {
            $data['oderdetail'] = $this->commonmodel->getorderdetail($orde_number);
        }
        $data['detail'] = reset($detail);
        $refree = $this->commonmodel->getaccountInfo($data['detail']['fk_user_id_referrer']);
        $data['refree'] = $refree;
        $data['orde_number'] = $orde_number;
        $data['karmora_cash'] = '50';
        $data['karmora_cash'] = '20';
        $data['type'] = 'Premier';
        if($shopper_program == 'orderWithout'){
           $this->loadLayout($data, 'frontend/signup/premier_signup_congrats_order_without');
        }else{
            $this->loadLayout($data, 'frontend/signup/premier_signup_congrats_order');
        }
    }
    
    function coupon($coupon) {
        if ($coupon != '') {
            $row = $this->usermodel->getuserCouponDetail($coupon);
            if (!empty($row)) {
                $price = $row->coupons_price;
                echo $price;
                die;
            } else {
                echo 'error';
                die;
            }
        } else {
            echo 'error';
            die;
        }
    }
    
    
    function emailexisetcall($user_name = NULL) {
       $email = $_POST['email'];
       $row = $this->usermodel->getalreadyemail($email);
       if(!empty($row)){
           echo 'already'; die;
        }else{
            echo 'sucess';die;
        }
            
    }

    function calculatetax($user_name = NULL) {
        $posts              = $this->input->post();
        $sameshipaddress    = $posts['sameshipaddress'];
        $address_post       = ($sameshipaddress == 1 ? $posts['shipping_address'] : $posts['billing_address']);
        $state_detail       = $this->usermodel->getstatename($address_post['state']);
        $address_state_code = $state_detail->user_address_state_code;
        $karmora_cash       = str_replace(',', '', $posts['karmora_kash_use']);
        $ordertotal         = str_replace(',', '', $posts['ordertotal']);
        $amount             = ($posts['karmora_kash_checkBox'] == 1 ? ($ordertotal - $karmora_cash) : $ordertotal);
        $DocType            = "SalesOrder";
        $number = 'Karma-' . date('i-s') . '-' . rand();
        $fields = array(
            //"CompanyCode" => 'karmora',//live
            "CompanyCode" => '	karmora',//staging
            "CustomerCode" => $number,
            "DocCode" => $number,
            "DocType" => $DocType,
            "DocDate" => date('Y-m-d'),
            "Addresses" => array(array(
                "AddressCode" => "01",
                "Line1" => $address_post['address1'],
                "City" => $address_post['city'],
                "Region" => $address_state_code,
                "Country" => "US",
                "PostalCode" => $address_post['zip_code'],
            )),
            "Lines" => array(array(
                "LineNo" => "1",
                "DestinationCode" => "01",
                "OriginCode" => "02",
                "Qty" => "1",
                "Amount" => $amount,
            ))
        );
        $jason = json_encode($fields);
        $headers = array();
        $headers[] = 'authorization=> Basic MjAwMDAwMzk2Nzo2MUQyRDFCRTlBRTg0RkQw';//live
        //$headers[] = 'authorization=> Basic MjAwMDE2NjgxODpFMkU0NDBFQ0YxM0U4NjMy';//staging
        $ch = curl_init('https://avatax.avalara.net/1.0/tax/get');//live
        //$ch = curl_init('https://development.avalara.net/1.0/tax/get');//staging
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jason);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'authorization : Basic MjAwMDAwMzk2Nzo2MUQyRDFCRTlBRTg0RkQw', //live
                //'authorization : Basic MjAwMDE2NjgxODpFMkU0NDBFQ0YxM0U4NjMy',//staging
                'Content-Length: ' . strlen($jason))
        );
        $result = curl_exec($ch);
        $resultArray = json_decode($result);
        if (!empty($resultArray)) {
            if ($resultArray->ResultCode == 'Success') {
                echo $resultArray->TotalTaxCalculated; exit();
            } else {
                echo 'error'; exit();
            }
        } else {
            echo 'error'; exit();
        }
    }

}
