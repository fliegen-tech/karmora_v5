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
        $this->load->model(array('usermodel', 'cartmodel', 'productmodel' ,'Loginmodel','ordermodel'));
        $this->upgrade_amount  =  19.95;
        $this->load->library(array('form_validation'));
        $this->load->helper(array('form'));
        $this->userObj = new Usermodel;
        $this->cartObj = new Cartmodel;
        $this->loginObj = new Loginmodel;
        $this->prdObj = new Productmodel;
        $this->orderObj = new Ordermodel;
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
            $post['user_data']  = $this->saveUser($post);
            $user_id            = $post['user_data']['user_id'];
        }else{
            $user_id            = $this->session->userdata('front_data')['id'];
        }
        $post['user_save_info'] = $this->saveAddress($user_id,$post);
        $this->processCheckoutSignup($post,$user_id);
    }
    // for validation
    public function validatecheckoutPost(){
        return true;
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
    private function getrefrer($post){
        $referrer = $this->userObj->getUserDetails($post['referrer']);
        $post['ref_id'] = !$referrer ? $this->currentUser['userid'] : $referrer['pk_user_id'];
        return $post;
    }
    private function getaccount_type(){
        if(isset($this->session->userdata['front_data'])){
            $detail = $this->currentUser;
            $post['acc_type'] = $detail['user_account_type_id'];
        }else{
            $post['acc_type']  = ($this->checkupgradecart)? 5:3;
        }
        return $post;
    }
    // for save user
    private function saveUser($data) {
        $userData = $this->setUserData($data);
        $newUser = $this->userObj->insertUserBasic($userData);
        $userData['user_id'] = $newUser['user_id'];
        $userData['username'] = 1000 + $newUser['user_id'];
        $this->userObj->updateUsername($userData['user_id'], $userData['username']);
        return $userData;
    }
    // for set data user for insert
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
    // for save address
    private function saveAddress($user_id,$data) {
        $arrData['shipping_id'] = $this->userObj->InsertAddress($user_id, $data['shipping_address']);
        $arrData['billing_id']  = $data['same_as_shipping'] ? $arrData['shipping_id'] : $this->userObj->InsertAddress($user_id, $data['billing_address']);
        return $arrData;
    }



    private function processCheckoutSignup($userData,$user_id) {
        $arrData = array(
            'user_id' => $user_id,
            'acc_type' => $userData['acc_type'],
            'card' => $this->setCardInfo($userData),
            'userData' => $this->setUserInfoForARB($userData),
            'subscription' => $this->userObj->getSubscriptionInfowithId(1),
            'premierPromo' => $this->userObj->getSignupPromo($this->signupPromo),
            'orderData' => $userData['product'],
            'shippingAddress' => $userData['shipping_address'],
            'same_as_shipping' => $userData['same_as_shipping'],
            'billingAddress' => $userData['same_as_shipping'] ?  $userData['shipping_address'] : $userData['billing_address'],
        );

        $this->saveOrder($arrData);
        if($this->checkcartupgrade()) {
            $this->processARB($arrData);
        }else{
            (!isset($this->session->userdata['front_data']))?$this->insertbounce(3,$user_id,'signup'):'';
        }
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
        $response['shipping_id'] = $userData['user_save_info']['shipping_id']['address_id'];
        $response['billing_id']  = $userData['user_save_info']['billing_id']['address_id'];
        $response['user_id']     = $userData['user_id'];
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
        if(isset($this->session->userdata['front_data'])) {
            $detail = $this->currentUser;
            $response['firstName'] = $detail['user_first_name'];
            $response['lastName'] = $detail['user_last_name'];
            $response['email']    = $detail['user_email'];
        }
        return $response;
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
    private function saveOrder($arrData) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $arrData['shipping_id'] = $arrData['userData']['shipping_id'];
        $arrData['billing_id']  = $arrData['userData']['billing_id'];
        $arrData['shipping_amount'] = $arrData['premierPromo']['promo_shipping'];
        $arrData['comm_amount'] = $this->input->post('karmora_commission_use');
        $arrData['taxAmount']   = $this->input->post('tax_price');
        $arrData['kash_amount'] = $this->input->post('karmora_kash_use');
        $arrData['upgrade_amount'] = ($this->checkcartupgrade())?$arrData['premierPromo']['promo_price']:0;
        $arrData['totalAmount'] = $this->cart->total() + $arrData['upgrade_amount'] + $arrData['premierPromo']['promo_shipping'] + $arrData['taxAmount'];
        $arrData['order_number'] = hexdec(uniqid());
        $arrData['resultOrder'] = $this->orderObj->insertOrderBeforeAuthorization($arrData);
        if ($arrData['resultOrder']['query_status']) {
            $message .= str_replace($this->alertMessages['str_replace'], 'Order# ' . $arrData['order_number'] . ' saved.', $this->alertMessages['success']);
            $billingAddress = $arrData['same_as_shipping'] ? $arrData['shippingAddress'] : $arrData['billingAddress'];
            $arrData['billingAddress_cc'] = $this->setAddressForOrder($billingAddress);
            $arrData['ccCharged'] = $this->chargeCC($arrData);
            $this->updateOrderAuthId($arrData['resultOrder']['order_id'], $arrData['ccCharged']['transaction_id']);
            $this->updateusedvalue($arrData['order_number'],$arrData['user_id']);
            $this->saveOrderLine($arrData);
        } else {
            $message .= str_replace($this->alertMessages['str_replace'], 'Could not save order.', $this->alertMessages['danger']);
        }
        $this->session->set_flashdata($this->data['flashKey'], $message);
        return $arrData;
    }

    private function processARB($data) {
        $acc_type_id = 5;
        (!isset($this->session->userdata['front_data']))?$this->insertbounce($acc_type_id,$data['user_id'],'signup'):$this->insertbounce($acc_type_id,$data['user_id'],'upgrade');
        $message = $this->session->flashdata($this->data['flashKey']);
        $result = $this->createARB($data['userData'],  $data['subscription'],$data['card']);
        if ($result['transaction_status']) {
            $message .= str_replace($this->alertMessages['str_replace'], "Recurring billing has been setup", $this->alertMessages['success']);
            $authSubidUpdate = $this->userObj->updateAuthId($data['userData']['user_id'], $result['subscription_id']);
            $this->userObj->updateUserAccountType(array('user_id' => $data['user_id'],  'status' => 'Inactive'));
            $this->userObj->insertUserAccountType(array('user_id' => $data['user_id'], 'acc_type_id' => $acc_type_id, 'status' => 'active'));
            $message .= $authSubidUpdate['query_status'] ? '' : str_replace($this->alertMessages['str_replace'], 'Subscription Id update failed. Send email to support@karmora.com with username:' . $data['userData']['username'] . ', email:' . $data['userData']['email'] . ' and subsctription ID:' . $data['subscription']['subscription_id'] . ' to update your record.', $this->alertMessages['danger']);
        } else {
            $message .= str_replace($this->alertMessages['str_replace'], $result['error_code'] . ' : ' . $result['error_message'], $this->alertMessages['danger']);
        }
        $this->session->set_flashdata($this->data['flashKey'], $message);
        return $result;
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
        $increment = 10;
        foreach ($this->cart->contents() as $items) {
            $line1 = array(
                'fk_order_id' => $lineData['resultOrder']['order_id'],
                'oder_line_number' => $increment,
                'fk_product_id' => $items['id'],
                'order_line_price' => $items['price'],
                'order_line_qty' => $items['qty'],
                'order_line_notes' => 'From Checkout',
                'order_line_status' => 'active'
            );
            $this->db->insert('tbl_order_line', $line1);
            $increment + 10;
            $this->orderObj->insertOrderLine($line1);
        }
    }

    private function updateOrderAuthId($orderId, $authId) {
        $message = $this->session->flashdata($this->data['flashKey']);
        $result = $this->orderObj->updateOrderAuthId($orderId, $authId);
        $message .= !$result ? '' : str_replace($this->alertMessages['str_replace'], $result, $this->alertMessages['warning']);
        return;
    }

    private function userSignupSuccessful($newUser) {
        $this->cart->destroy();
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

    private function calculate_karmora_cash_back($detail) {
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

    private function updateusedvalue($order_number,$user_id){
        (($this->input->post('karmora_kash_use') > 0))?$this->usedkarmorakash($user_id, $order_number, $this->input->post('karmora_kash_use')): '';
        (($this->input->post('karmora_commission_use') > 0))?$this->usedkarmoracommsion($user_id, $order_number, $this->input->post('karmora_commission_use')): '';
    }
    private function usedkarmorakash($user_id, $orderNumber, $karmorakash) {
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
    private function usedkarmoracommsion($user_id, $orderNumber, $karmoracommsion) {
        $dataLog = array(
            'fk_user_id' => $user_id,
            'fk_user_id_from' => $user_id,
            'dollar_amount' => -$karmoracommsion,
            'dollar_type' => 'Withdraw',
            'dollar_description' => 'Redeemed against order#: <a href="' . base_url('my-orders/' . $orderNumber) . '" target="_blank">' . $orderNumber . '</a>'
        );
        $this->db->insert('tbl_karmora_dollar_account', $dataLog);
    }

}

/* Location: ./application/controllers/checkout.php */