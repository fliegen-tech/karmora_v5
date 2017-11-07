<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checkout extends karmora {

    public $data = array();
    private $userObj;
    private $cartObj;
    private $prdObj;
    private $loginObj;
    public $upgrade_amount = '';

    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->data = array(
            'themeUrl' => $this->themeUrl,
            'view' => 'frontend/checkout/',
            'viewForm' => 'frontend/forms/',
            'flashKey' => 'message_signup',
            'shipping_cost' => 0
        );
        $this->load->model(array('usermodel', 'cartmodel', 'productmodel' ,'Loginmodel'));
        $this->upgrade_amount  =  99;
        $this->load->library(array('form_validation'));
        $this->load->helper(array('form'));
        $this->userObj = new Usermodel;
        $this->cartObj = new Cartmodel;
        $this->loginObj = new Loginmodel;
        $this->prdObj = new Productmodel;
        $this->load->library('form_validation');
    }

    public function index($username = NULL) {
        if (!$this->cart->contents()) {
            redirect(base_url());
        }
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['username'] = $username;
        $this->data['productList'] = $this->prdObj->getproducts($this->active);
        $this->data['statesList']  = $this->userObj->getStatesofCountry(1);
        $this->data['countryList'] = $this->userObj->getCountries();
        $this->data['signupPromo'] = $this->userObj->getSignupPromo($this->signupPromo);
        $this->data['cart_info'] = $this->getproducttotal();
        $this->data['upgrde_data'] = $this->checkcartupgrade();
        $this->data['upgrade_amount'] = ($this->data['upgrde_data'])?$this->upgrade_amount:0;
        $this->getLoginData($detail);
        if (isset($_POST['submit'])) {
            $this->savedata($username);
        }
        $this->loadLayout($this->data, 'frontend/cart/checkout');
    }

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

    private function getLoginData($detail){
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
        $this->validatecheckoutPost();
        $this->checkCard($this->input->post());
        $post = $this->input->post();
        $this->getrefrer($post);
        $this->getaccount_type();
        if(!isset($this->session->userdata['front_data'])) {
            $post['user_data'] = $this->saveUser($post);
        }
        $this->processCheckoutSignup($post);
    }

    public function validatecheckoutPost(){
        return true;
    }
    public function getaccount_type(){
        if(isset($this->session->userdata['front_data'])){
            $detail = $this->currentUser;
            $post['acc_type'] = $detail['user_account_type_id'];
        }else{
            $post['acc_type']  = ($this->checkupgradecart)? 5:3;
        }
        return $post;
    }
    public function getrefrer($post){
        $referrer = $this->userObj->getUserDetails($post['referrer']);
        $post['ref_id'] = !$referrer ? $this->currentUser['userid'] : $referrer['pk_user_id'];
        return $post;
    }
    private function checkCard($data) {
        $cart_data = $data['payment_detail'];
        $exp_date = $cart_data['year'].'-'.$cart_data['month'];
        $cart_data = array_merge($cart_data, array('exp_date' => $exp_date));
        $runAuth = $this->runauthrioze($cart_data);
        if ($runAuth['transaction_status']) {
            $this->Voidauthrioze($runAuth['transaction_id']);
        } else {
            $message = str_replace($this->alertMessages['str_replace'], $runAuth['error_message'], $this->alertMessages['danger']);
            $this->session->set_flashdata($this->data['flashKey'], $message);
            redirect(base_url('checkout'));
        }
        return;
    }
    public function saveUser($data) {
        $userData = $this->setUserData($data);
        $newUser = $this->userObj->insertUserBasic($userData);
        if ($newUser['query_status']) {
            //$message = str_replace($this->alertMessages['str_replace'], 'Signup successful', $this->alertMessages['success']);
            //$this->session->set_flashdata($this->data['flashKey'], $message);
            $userData['user_id'] = $newUser['user_id'];
            $userData['username'] = 1000 + $newUser['user_id'];
            $this->userObj->updateUsername($userData['user_id'], $userData['username']);
            in_array($userData['acc_type'], array(3)) ? $this->userSignupSuccessful($userData) : '';
        } elseif (!$newUser['query_status'] && in_array($data['acc_type'], array(5))) {
            $message = str_replace($this->alertMessages['str_replace'], $newUser['error_info'], $this->alertMessages['warning']);
            $this->session->set_flashdata($this->data['flashKey'], $message);
            return redirect(base_url('checkout'));
        } else {
            $message = str_replace($this->alertMessages['str_replace'], $newUser['error_info'], $this->alertMessages['warning']);
            $this->session->set_flashdata($this->data['flashKey'], $message);
            return redirect(base_url('checkout'));
        }
        return $userData;
    }
    private function setUserData($data) {
        $fullName = isset($data['fullname']) ? explode(' ', $data['fullname']) : '';
        return array(
            'username' => uniqid('temp-'),
            'fname' => isset($fullName[0]) ? $fullName[0] : $data['fullname'],
            'lname' => isset($fullName[1]) ? $fullName[1] : $data['fullname'],
            'email' => $data['email'],
            'password' => $this->generatePassword(),
            'ip_address' => $this->input->ip_address(),
            'status' => 'active',
            'acc_type' => isset($data['acc_type']) ? $data['acc_type'] : 3,
            'subid' => uniqid(),
            'referr_id' => $data['ref_id']
        );
    }

    private function processCheckoutSignup($userData) {
        $arrData = array(
            'user_id' => $userData['user_data']['user_id'],
            'acc_type' => $userData['acc_type'],
            'card' => $this->setCardInfo($userData),
            'userData' => $this->setUserInfoForARB($userData),
            'subscription' => $this->userObj->getSubscriptionInfowithId(1),
            'premierPromo' => $this->userObj->getSignupPromo($this->signupPromo),
            'orderData' => $userData['product'],
            'shippingAddress' => $userData['shipping_address'],
            'same_as_shipping' => $userData['same_as_shiping'],
            'billingAddress' => $userData['same_as_shipping'] ?  $userData['shipping_address'] : FALSE,
        );

        $this->processARB($arrData);
        $this->saveOrder($arrData);
        $this->userSignupSuccessful($userData['user_data']);
    }

    private function setCardInfo($userData) {
        return array(
            'number' => $userData['payment_detail']['number'],
            'exp_date' => $userData['payment_detail']['year'] . '-' . $userData['payment_detail']['month'],
            'cvv' => $userData['payment_detail']['cvv']
        );
    }

    private function setUserInfoForARB($userData) {
        $response = $userData['same_as_shipping'] ?
            $this->setAddressForOrder($userData['shipping_address']):
            $this->setAddressForOrder($userData['billing_address']);
        $response['user_id'] = $userData['user_data']['user_id'];
        if($userData['same_as_shipping']){
            $fname = $userData['user_data']['fname'];
            $lname = $userData['user_data']['lname'];
        }else{
            $fullname = $userData['billing_address']['name'];
            $fname = (isset(explode(' ',$fullname)[0]))?explode(' ',$fullname)[0]:$fullname;
            $lname = (isset(explode(' ',$fullname)[1]))?explode(' ',$fullname)[1]:$fullname;
        }
        $response['firstName'] = $fname;
        $response['lastName'] = $lname;
        $response['email'] = $userData['user_data']['email'];
        return $response;
    }

    private function processARB($data) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $result = $this->createARB($data['userData'],  $data['subscription'],$data['card']);

        if ($result['transaction_status']) {
            $message .= str_replace($this->alertMessages['str_replace'], "Recurring billing has been setup", $this->alertMessages['success']);
            $authSubidUpdate = $this->userObj->updateAuthId($data['userData']['user_id'], $result['subscription_id']);
            $this->userObj->insertUserAccountType(array('user_id' => $data['user_id'], 'acc_type_id' => $data['acc_type'], 'status' => 'active'));
            $message .= $authSubidUpdate['query_status'] ? '' : str_replace($this->alertMessages['str_replace'], 'Subscription Id update failed. Send email to support@karmora.com with username:' . $data['userData']['username'] . ', email:' . $data['userData']['email'] . ' and subsctription ID:' . $data['subscription']['subscription_id'] . ' to update your record.', $this->alertMessages['danger']);
        } else {
            $message .= str_replace($this->alertMessages['str_replace'], $result['error_code'] . ' : ' . $result['error_message'], $this->alertMessages['danger']);
        }

        $this->session->set_flashdata($this->data['flashKey'], $message);
        return $result;
    }

    private function saveOrder($arrData) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $arrData['shipping_id'] = $this->saveAddress($arrData['userData']['user_id'], $arrData['shippingAddress'], 'shipping');
        $arrData['billing_id'] = !$arrData['billingAddress'] ? $arrData['shippingAddress']['id'] : $this->saveAddress($arrData['userData']['user_id'], $arrData['billing_address'], 'billing');
        $arrData['shipping_amount'] = $arrData['premierPromo']['promo_shipping'];
        $arrData['upgrade_amount']  = $arrData['premierPromo']['promo_price'];
        $arrData['comm_amount'] = 0;
        $arrData['taxAmount']   = $_POST['tax_price'];
        $arrData['kash_amount'] = 0;
        $arrData['totalAmount'] = $arrData['premierPromo']['promo_price'] + $arrData['premierPromo']['promo_shipping'] + $arrData['taxAmount'];
        $arrData['order_number'] = hexdec(uniqid());
        $arrData['resultOrder'] = $this->orderObj->insertOrderBeforeAuthorization($arrData);
        if ($arrData['resultOrder']['query_status']) {
            $message .= str_replace($this->alertMessages['str_replace'], 'Order# ' . $arrData['order_number'] . ' saved.', $this->alertMessages['success']);
            $billingAddress = $arrData['same_as_shipping'] ? $arrData['shippingAddress'] : $arrData['billingAddress'];
            $arrData['billingAddress_cc'] = $this->setAddressForOrder($billingAddress);
            $arrData['ccCharged'] = $this->chargeCC($arrData);
            $this->updateOrderAuthId($arrData['resultOrder']['order_id'], $arrData['ccCharged']['transaction_id']);
            $this->saveOrderLine($arrData);
        } else {
            $message .= str_replace($this->alertMessages['str_replace'], 'Could not save order.', $this->alertMessages['danger']);
        }
        $this->session->set_flashdata($this->data['flashKey'], $message);
        return $arrData;
    }

    private function chargeCC($data) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $data['billing_address'] = $data['billingAddress_cc']['address'];
        $data['billing_city'] = $data['billingAddress_cc']['city'];
        $data['billing_state'] = $data['billingAddress_cc']['state'];
        $data['billing_zip'] = $data['billingAddress_cc']['zip'];
        $data['billing_country'] = $data['billingAddress_cc']['country'];
        $transResult = $this->CCtransection($data);
        if ($transResult['transaction_status']) {
            $message .= str_replace($this->alertMessages['str_replace'], 'Card charged for amount $' . number_format($data['totalAmount'], 2, '.', ','), $this->alertMessages['success']);
        } else {
            $message .= str_replace($this->alertMessages['str_replace'], $transResult['error_message'], $this->alertMessages['danger']);
        }
        $this->session->set_flashdata($this->data['flashKey'], $message);
        return $transResult;
    }

    private function saveOrderLine($lineData) {
        $line1 = array(
            'order_id' => $lineData['resultOrder']['order_id'],
            'line_number' => 10,
            'product_id' => $lineData['product'],
            'acc_type_id' => $lineData['acc_type'],
            'line_price' => 0,
            'qty' => 1
        );
        return $this->orderObj->insertOrderLine($line1);
    }

    private function setAddressForOrder($address) {
        $addressState = $this->userObj->getStateWithId($address['state']);
        $addressCountry = $this->userObj->getCountryWithId($address['country']);
        return array(
            'address' => $address['address1'],
            'city' => $address['city'],
            'state' => $addressState['user_address_state_code'],
            'zip' => $address['zip_code'],
            'country' => $addressCountry['user_address_country_code'],
        );
    }

    private function saveAddress($userId, $data, $addressType) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $addResult = $this->userObj->InsertAddress($userId, $data);
        $message .= $addResult['query_status'] ?
            str_replace($this->alertMessages['str_replace'], $addressType . ' address saved.', $this->alertMessages['success']) :
            str_replace($this->alertMessages['str_replace'], $addressType . ' address save failed.', $this->alertMessages['warning']);
        $this->session->set_flashdata($this->data['flashKey'], $message);
        return $addResult['query_status'] ? $addResult['address_id'] : FALSE;
    }

    private function updateOrderAuthId($orderId, $authId) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $result = $this->orderObj->updateOrderAuthId($orderId, $authId);
        $message .= !$result ? '' : str_replace($this->alertMessages['str_replace'], $result, $this->alertMessages['warning']);
        return;
    }

    private function userSignupSuccessful($newUser) {
        $message = '';

//        send email to user and referral pending.
//
//        try login
        $userDetail = $this->loginObj->frontendVerifyUser($newUser['username'], md5($newUser['password']));
        if ($userDetail) {
            $this->cart->destroy();
            $userSessionData = $this->set_session_login($userDetail);
            $this->session->set_userdata('front_data', $userSessionData);
            $this->session->set_flashdata('first_login', $newUser);
            //$message = str_replace($this->alertMessages['str_replace'], 'Signup Successful', $this->alertMessages['success']);
            $redirectUrl = 'welcome';
        } else {
            //$message = str_replace($this->alertMessages['str_replace'], 'Invalid Username Or Password', $this->alertMessages['warning']);
            $redirectUrl = 'login';
        }
        $this->session->set_flashdata($this->data['flashKey'], $message);
        return redirect(base_url($redirectUrl));
    }

    private function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public function welcome($username) {
        if ($this->session->flashdata('first_login')) {
            $this->verifyUser($username);
            $this->data['userDetail'] = $this->session->flashdata('first_login');
            $this->loadLayout($this->data, $this->data['view'] . 'welcome');
        } else {
            redirect(base_url());
        }
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
        $price_price_total = $this->cart->total();
        $total_price = $this->cart->total() + $shiiping_cost;// + $upgrade_price; //100
        $karmora_price = $price_price_total + $shiiping_cost;// + $upgrade_price; //100
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