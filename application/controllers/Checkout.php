<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checkout extends karmora {

    public $data = array();
    private $userObj;
    private $cartObj;
    private $prdObj;

    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->data = array(
            'themeUrl' => $this->themeUrl,
            'view' => 'frontend/signup/',
            'viewForm' => 'frontend/forms/',
            'flashKey' => 'message_signup',
            'shipping_cost' => 0
        );
        $this->load->model(array('usermodel', 'cartmodel', 'productmodel'));
        $this->load->library(array('form_validation'));
        $this->load->helper(array('form'));
        $this->userObj = new Usermodel;
        $this->cartObj = new Cartmodel;
        $this->prdObj = new Productmodel;
        $this->load->library('form_validation');
    }

    public function index($username = NULL) {
        if (!$this->cart->contents()) {
            redirect(base_url());
        }
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['productList'] = $this->prdObj->getproducts($this->active);
        $this->data['statesList']  = $this->userObj->getStatesofCountry(1);
        $this->data['countryList'] = $this->userObj->getCountries();
        $this->data['signupPromo'] = $this->userObj->getSignupPromo($this->signupPromo);
        $this->data['cart_info'] = $this->getproducttotal();
        $this->getLoginData($detail);
        if (isset($_POST['submit'])) {
            $this->savedata($username);
        }
        $this->loadLayout($this->data, 'frontend/cart/checkout');
    }

    /**
     * @return string
     */
    public function getproducttotal(){
        $exclusiveProductTotal = 0;
        $actualCost            = number_format($this->cart->total() + $this->data['shipping_cost'] , 2, '.', ',');
        foreach ($this->cart->contents() as $items) {
            $exclusiveProductTotal = $exclusiveProductTotal + ($items['qty'] * $items['price']) ;
        }
                $return_array = array(
                                'exclusiveProductTotal'=> $exclusiveProductTotal,
                                'shipping_cost'        => $this->data['shipping_cost'],
                                'actualCost'           => $actualCost,
                                'cartAmount'           => $this->cart->total()
                                );
        return $return_array;
    }

    /**
     * @return string
     */
    public function getLoginData($detail){
        if ($this->session->userdata('front_data')) {
            $mainsummery = $this->userObj->getuser_main_summary($detail['userid']);
            $this->data['available_commsion'] = $mainsummery->available_cash;
            $this->data['available_karmora_cash'] = $mainsummery->available_karmora_kash;
            $commsion_array = $this->calculate_karmora_cash_back($detail);
            $KarmoracashArray = explode('==', $commsion_array);
            $this->data['redum_value'] = $KarmoracashArray[0];
            if ($KarmoracashArray[1] == 0) {
                $this->data['commsion_value'] = $KarmoracashArray[1];
            } else {
                $total_for_commsion = $this->data['shipping_cost'] + $this->cart->total();
                if($KarmoracashArray[1] > $total_for_commsion){
                    $this->data['commsion_value'] = $KarmoracashArray[1] + $this->data['shipping_cost']; //die;
                }else{
                    $this->data['commsion_value'] = $KarmoracashArray[1] ; //die;
                }
            }
            $userAddress = $this->userObj->getMemberCurrentAddress($detail['userid']);
            $this->data['address'] = $userAddress['address'];
            $this->data['countryList'] = $userAddress['countriesList'];
            $this->data['statesList'] = $userAddress['statesOfCurrentAddressCountry'];
        }
    }

    public function savedata() {
        
        $detail = $this->currentUser;
        $user_id = $detail['userid'];
        $karmorakash_commsion = $this->getkarmorakash_commsion();
        $region  = $this->input->post('region');
        $shiiping_cost = $this->input->post('order_shipping_cost');
        $order_tax_cost = 1;//$this->calculateTaxCheckout($region, $user_id);
        $upgrade_price = $this->getupgradeprice();
        $karmorakash_commsion = $this->getkarmorakash_commsion();
        $KashCommsionArray = explode('==', $karmorakash_commsion);
        $order_commsion_price = $KashCommsionArray[0];
        $karmorakash = $KashCommsionArray[1];

        $total_price = ($this->cart->total() + $shiiping_cost + $order_tax_cost + $upgrade_price - $karmorakash) + 0.0001;
        $mytotal_for_commsion = ($this->cart->total() + $upgrade_price - $karmorakash) + 0.0001;
        $order_cal_total = round($total_price - $order_commsion_price, 2);
        $sameshipaddress = $this->input->post('sameshipaddress');
        //echo $order_tax_cost = $this->input->post('tax_price_hidden'); 
        if ($sameshipaddress != 1 || !isset($sameshipaddress)) {
            $this->form_validation->set_rules('biling_detail[street_address]', 'Billing Address', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[city]', 'Billing City', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[state]', 'Billing State', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[country]', 'Billing Country', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[zipcode]', 'Billing Zip Code', 'required|trim|htmlspecialchars|xss_clean');
        }
            $this->form_validation->set_rules('shipping_detail[street_address]', 'Address', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('shipping_detail[city]', 'City', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('shipping_detail[state]', 'State', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('shipping_detail[country]', 'Country', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('shipping_detail[zipcode]', 'Zip Code', 'required|trim|htmlspecialchars|xss_clean');
        if($order_cal_total > 0){
            $this->form_validation->set_rules('card_number', 'Card Number', 'required|numeric|min_length[13]|max_length[16]|xss_clean');
            $this->form_validation->set_rules('card_code', 'CVC', 'required|numeric|exact_length[3]|xss_clean');
            $this->form_validation->set_rules('month', 'Month', 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[12]|xss_clean');
            $this->form_validation->set_rules('year', 'Year', 'required|numeric|xss_clean');
        }
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() === FALSE) {
            //echo 'usman'.validation_errors(); die;
        } else {
            $call_back = $this->security->xss_clean($_POST['thecallback']);
            if($call_back != ''){
                $this->Voidauthrioze($call_back);
            }
            if ($order_tax_cost == 'error') {
                echo 'errorontex';
                die;
            }
            $billing_ids = $this->update_address_function($user_id);
            $billingArray = explode('==', $billing_ids);
            $billing_id = $billingArray[1];
            $shipping_id = $billingArray[0];
            $order_numbr = mt_rand();
            $name = $this->input->post('username');
            $datas = array(
                'order_numbr' => $order_numbr,
                'fk_user_id' => $user_id,
                'fk_shipping_address_id' => $shipping_id,
                'fk_billing_address_id' => $billing_id,
                'order_user_name' => $name,
                'order_total_price' => $total_price,
                'order_cal_total' => $order_cal_total,
                'order_shiping_cost' => $shiiping_cost,
                'order_commsion_price' => $order_commsion_price,
                'order_tax_cost' => $order_tax_cost,
                'order_karmora_cash_price' => $karmorakash,
                'order_upgrade_cost' => $upgrade_price,
                'order_status' => 'pending',
                'order_create_date' => date("Y-m-d H:i:s")
            );
            $this->db->insert('tbl_oders', $datas);
            $order_id = $this->db->insert_id();
            $UserData = $this->commonmodel->getuserdetail($user_id);
            $userOrder = $this->cartmodel->getOrderDetailById($order_numbr, $user_id);
            if ($karmorakash != 0) {
                $this->usedkarmorakash($user_id, $order_id, $karmorakash + 0.000001);
            }
            if ($order_commsion_price != 0) {
                $this->usedkarmoracommsion($user_id, $order_id, $order_commsion_price);
            }
            if ($order_cal_total > 0) {
                $posts = $this->input->post();
                $responce  = $this->CCtransection($order_cal_total, $userOrder, $user_id, $posts, 'checkout');
                $this->checkrespoce($responce, $user_id, $order_id,$userOrder,$UserData);
                $this->updateorderAccountType($user_id, $order_id,$userOrder,$UserData);
                $this->redirectLast($responce,$userOrder,$mytotal_for_commsion);
            } else {
                $dataTran = array(
                    'oder_payment_status' => 'WithoutCard'
                );
                $this->db->where('pk_order_id', $order_id);
                $this->db->update('tbl_oders', $dataTran);
                $this->updateorderAccountType($user_id, $order_id,$userOrder,$UserData);
                $this->sendordermail($user_id, $order_numbr);
                $this->usermodel->set_kk_on_personal_exclusive_purchase($order_id);
                $this->sendrefrealcommsionmail($user_id);
            }
            $this->redirectLast('witoutcard',$userOrder,$mytotal_for_commsion);
        }
    }

    public function update_address_function($user_id) {
        $posts = $this->input->post();
        $post = $posts['shipping_detail'];
        $arState = explode('-.-', $post['state']);
        $arCity = $post['city'];
        $address['countryId'] = $post['country'];
        $address['stateId'] = end($arState);
        $address['city'] = $arCity;
        $address['zipCode'] = $post['zipcode'];
        $address['streetAddress'] = $post['street_address'];
        $address['streetAddress_2'] = NULL;
        $phone = $post['phone'];
        if (isset($post['street_address_2'])) {
            $address['streetAddress_2'] = $post['street_address_2'];
        }
        $address['userId'] = $user_id;
        $validatecsc = $this->usermodel->validateCountryStateCity($address);
        $this->usermodel->updatePhone($address['userId'], $phone);
        $shipping_address_id = $this->redirect_address($address, $validatecsc);
        if ($posts['sameshipaddress'] == 1) {
            $billing_address_id = $shipping_address_id;
        } else {
            $billing_address_id = $this->insertShippingaddress($user_id);
        }
        return $shipping_address_id . '==' . $billing_address_id;
    }

    public function insertShippingaddress($user_id) {
        $posts = $this->input->post();
        $shipping_post = $posts['biling_detail'];
        $arState = explode('-.-', $shipping_post['state']);
        $arCity = $shipping_post['city'];
        $address['countryId'] = $shipping_post['country'];
        $address['stateId'] = end($arState);
        $address['city'] = $arCity;
        $address['zipCode'] = $shipping_post['zipcode'];
        $address['streetAddress'] = $shipping_post['street_address'];
        $address['streetAddress_2'] = NULL;
        if (isset($shipping_post['street_address_2'])) {
            $address['streetAddress_2'] = $shipping_post['street_address_2'];
        }
        $address['userId'] = $user_id;
        $phone = $shipping_post['phone'];
        $validatecsc = $this->usermodel->validateCountryStateCity($address);
        $this->usermodel->updatePhone($address['userId'], $phone);

        $address['cityId'] = $validatecsc['city_id'];
        $shipping_address_id = $this->redirect_shipping_address($address, $validatecsc);
        return $shipping_address_id;
    }

    public function redirect_address($address, $validatecsc) {
        //echo '<pre>';        print_r($address);print_r($validatecsc); die;
        if ($validatecsc === false) {
            $address['cityId'] = $validatecsc['city_id'];
            $billing_address_id = $this->usermodel->updateAddress($address);
            return $billing_address_id;
        } else {
            $single_array = reset($validatecsc);
            return $single_array['address_id'];
        }
    }

    public function redirect_shipping_address($address, $validatecsc) {

        if ($validatecsc === false) {
            $address['cityId'] = $validatecsc['city_id'];
            $billing_address_id = $this->usermodel->insertShiipingAddress($address);
            return $billing_address_id;
        } else {
            return $validatecsc['address_id'];
        }
    }

    public function order_conframtion($username = NULL) {
        $data = array();
        $this->cart->destroy();
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $userOrder = $this->usermodel->getUserordernumber($detail['userid']);
        $data['userOrder'] = $userOrder;
        //echo '<pre>';        print_r($userOrder); die;
        $this->loadLayout($data, 'frontend/cart/checkout_confirm');
    }

    public function calculate_karmora_cash_back($detail) {
        $prensatage = $this->usermodel->getuser_persantage_summary($detail['user_account_type_id']);
        if (empty($prensatage)) {
            $perstange = 50;
        } else {
            $perstange = $prensatage->user_acc_kash_settings_get_on_redemption_purchases_amount;
        }
        $mainsummery = $this->usermodel->getuser_main_summary($detail['userid']);
        $commsion = $mainsummery->available_cash;
        $karmora_cash_amount = $mainsummery->available_karmora_kash;
        $shiiping_cost = 0; //$this->data['shipping_cost'];
        // for every product - 10
        $price_qty_total = 0;
        foreach ($this->cart->contents() as $item) {
             $price_qty_total = $item['subtotal'];
        }
        $total_price = $this->cart->total() + $shiiping_cost;// + $upgrade_price; //100
        $karmora_price = $price_qty_total + $shiiping_cost;// + $upgrade_price; //100
        //$karmora_cash_val = ($karmora_price-10) * 100;
        $karmora_cash_val = ($karmora_price) * 100;
        $karmora_cash = $karmora_cash_val / 100; // 80
        ($karmora_cash_amount > $karmora_cash ? $karmora_cash = $karmora_cash : $karmora_cash = $karmora_cash_amount);
        $karmora_commsion = $total_price; //- $karmora_cash; // 20
        if ($commsion > $karmora_commsion) {
            $commsion_amount = $karmora_commsion;
        } else {
            $commsion_amount = $commsion;
        }
        return $return_varibale = ($karmora_cash) . '==' . ($commsion_amount);
    }

    public function getupgradeprice() {
        $upgrade_price = 0;
        foreach ($this->cart->contents() as $items) {

            if (($items['shopper_account_type'] == 'premier_shopper_one_time' || $items['shopper_account_type'] == 'premier_shopper_auto_delvery') && $this->session->userdata['front_data']['user_account_type_id'] != 5) {
                $upgrade_price = $this->data['upgrade_cost'];
            }
        }
        return $upgrade_price;
    }

    public function updateorderAccountType($user_id, $order_id,$userOrder,$UserData) {
        $increment = 10;
        foreach ($this->cart->contents() as $items) {
            if ($items['shopper_recurning_time'] != '') {
                $this->insertproductrecuring($user_id, $order_id, $items['id'], $items['shopper_recurning_time'],$items['price'],$userOrder,$UserData);

            }
            $datas = array(
                'fk_order_id' => $order_id,
                'oder_line_number' => $increment,
                'fk_product_id' => $items['id'],
                'order_line_price' => $items['price'],
                'order_line_qty' => $items['qty'],
                'order_line_notes' => '',
                'order_line_status' => 'active'
            );
            $this->db->insert('tbl_order_line', $datas);
            $increment + 10;
        }
    }

    public function getkarmorakash_commsion() {
        $karmora_cash = 0;
        $karmora_commsion = 0;
        $karmora_cash_check = $this->input->post('karmora_cash_check'); //die;
        $karmora_commsion_check = $this->input->post('karmora_commsion_check'); //die;
        if ($karmora_cash_check == 1) {
            $karmora_cash = $this->input->post('karmora_cash'); //die;
        }
        if ($karmora_commsion_check == 1) {
            $karmora_commsion = $this->input->post('karmora_commsion_used_final'); //die;
        }
        $return_val = $karmora_commsion . '==' . $karmora_cash;
        return $return_val;
    }
    public function usedkarmorakash($user_id, $order_id, $karmorakash) {
        $orderNumber = $this->commonmodel->getOrderNumber($order_id);
        $dataLog = array(
            'fk_user_id' => $user_id,
            'fk_user_id_from' => $user_id,
            'kash_amount' => -$karmorakash,
            'kash_type' => 'Withdraw',
            'kash_description' => 'Redeemed against order#: <a href="' . base_url('my-orders/' . $orderNumber) . '" target="_blank">' . $orderNumber . '</a>'
        );
        $this->db->insert('tbl_karmora_kash_account', $dataLog);
        //echo $this->db->last_query(); die;
    }
    public function usedkarmoracommsion($user_id, $order_id, $karmoracommsion) {
        $orderNumber = $this->commonmodel->getOrderNumber($order_id);
        $dataLog = array(
            'fk_user_id' => $user_id,
            'fk_user_id_from' => $user_id,
            'dollar_amount' => -$karmoracommsion,
            'dollar_type' => 'Withdraw',
            'dollar_description' => 'Redeemed against order#: <a href="' . base_url('my-orders/' . $orderNumber) . '" target="_blank">' . $orderNumber . '</a>'
        );
        $this->db->insert('tbl_karmora_dollar_account', $dataLog);
        //echo $this->db->last_query(); die;
    }
    public function redirectLast($responce,$userOrder,$total_price) {
        
            $userAccount = $this->commonmodel->getAccounttype($userOrder->fk_user_id);
            
            if($responce == 'witoutcard'){
                $this->sendordermail($userOrder->fk_user_id, $userOrder->order_no);
                $commsion_data = $this->commonmodel->insert_retail_commission($userAccount->fk_user_account_type_id);
                $perstange = $commsion_data->user_rank_permissions_value;
                $karmora_cash_amount = ($total_price*$perstange)/100;
                $this->db->query("CALL stored_proc_insert_retail_commission()");
                $this->cart->destroy();
                redirect(base_url('premier_shopper_congrats_orderWithout/' . $userOrder->order_no));
            }
            if ($responce['success'] == '' || !isset($responce['transaction_id'])) {
                $this->cart->destroy();
                exit();
            }else{
                $this->db->query("CALL stored_proc_insert_retail_commission()");
                $this->sendordermail($userOrder->fk_user_id, $userOrder->order_no);
                $commsion_data = $this->commonmodel->insert_retail_commission($userAccount->fk_user_account_type_id);
                $perstange = $commsion_data->user_rank_permissions_value;
                $karmora_cash_amount = ($total_price*$perstange)/100;
                $this->commonmodel->insert_retail_commission($userAccount->fk_user_account_type_id);
                $this->sendrefrealcommsionmail($userOrder->fk_user_id);
                $this->cart->destroy();
                redirect(base_url('premier_shopper_congrats_orderWithout/' . $userOrder->order_no));
            }
    }

}

/* Location: ./application/controllers/checkout.php */