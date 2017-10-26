<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajaxcallz extends karmora {

    public $data;
    function __construct() {
        parent::__construct(); //call to parent constructor
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->helper('url');
        $this->load->model('commonmodel');
        $this->load->model('usermodel');
        require_once('AuthNet.php');
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

    function calculateTaxCheckout($user_name = NULL) {
        ($var > 2 ? true : false);
        $street_adrees = $_POST['shipping_detail']['street_address'];
        $city = $_POST['shipping_detail']['city'];
        $zipcode = $_POST['shipping_detail']['zipcode'];


        $karmora_cash = str_replace(',', '', $_POST['karmora_cash']);
        $total_payed = str_replace(',', '', $_POST['total_payed']);
        if (isset($_POST['karmora_cash_check']) && $_POST['karmora_cash_check'] == 1) {
            $amount = $total_payed - $karmora_cash;
        } else {
            $amount = $total_payed;
        }
        $condation = "SalesOrder";
        $number = 'Karma-' . date('i-s') . '-' . rand();
        $fields = array(
            "CompanyCode" => 'karmora',//live
            //"CompanyCode" => 'karma',//staging
            "CustomerCode" => $number,
            "DocCode" => $number,
            "DocType" => $condation,
            "DocDate" => date('Y-m-d'),
            "Addresses" => array(array(
                "AddressCode" => "01",
                "Line1" => $street_adrees,
                "City" => $city,
                "Region" => $Region,
                "Country" => "US",
                "PostalCode" => $zipcode,
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
            if ($resultArray->ResultCode == 'Error') {
                if ($type == 'ajax') {
                    echo 'erroronaddress';
                    die;
                } else {
                    return 'error';
                }
            }
            if ($resultArray->ResultCode == 'Success') {
                if ($type == 'ajax') {
                    echo $resultArray->TotalTaxCalculated;
                    die;
                } else {
                    return $resultArray->TotalTaxCalculated;
                }
            } else {
                if ($type == 'ajax') {
                    echo 0;
                    die;
                } else {
                    return 0;
                }
            }
        } else {
            if ($type == 'ajax') {
                echo 0;
                die;
            } else {
                return 0;
            }
        }
    }

}
