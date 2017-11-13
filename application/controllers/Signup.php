<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends karmora {

    /**
     * Constructor of a login
     */
    public $data = array();
    private $userObj;
    private $loginObj;
    private $prdObj;
    private $orderObj;

    function __construct() {
        parent::__construct(); //call to parent constructor

        $this->checknotlogin();

        $this->data = array(
            'themeUrl' => $this->themeUrl,
            'view' => 'frontend/signup/',
            'viewForm' => 'frontend/forms/',
            'flashKey' => 'message_signup'
        );

        $this->load->model(array('usermodel', 'Loginmodel', 'productmodel' ,'ordermodel'));

        $this->load->library(array('form_validation'));
        $this->load->helper(array('form'));

        $this->userObj = new Usermodel;
        $this->loginObj = new Loginmodel;
        $this->prdObj = new Productmodel;
        $this->orderObj = new Ordermodel;
    }

    public function index($username = NULL) {
        $this->verifyUser($username);
        $this->loadLayout($this->data, $this->data['view'] . 'join_today');
    }

    public function casualSignup($username = NULL) {
        $this->verifyUser($username);
        $this->data['username'] = $username;
        $this->loadLayout($this->data, $this->data['view'] . 'join_today_casual');
    }

    public function casualPost($username = NULL) {
        $this->verifyUser($username);
        if ($this->input->post('submit')) {
            $this->validateCasualPost();
            $post = $this->input->post();
            $referrer = $this->userObj->getUserDetails($post['referrer']);
            $post['ref_id'] = !$referrer ? $this->currentUser['userid'] : $referrer['pk_user_id'];
            $post['acc_type'] = 3;
            $this->saveUser($post);
        } else {
            $message = str_replace($this->alertMessages['str_replace'], 'Something went wrong. Please try again', $this->alertMessages['warning']);
            $this->session->set_flashdata($this->data['flashKey'], $message);
            return redirect(base_url('join-today-casual'));
        }
    }

    private function validateCasualPost() {
//        set validation rules here for casual signup.
        return TRUE;
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
            return redirect(base_url('join-today-premier'));
        } else {
            $message = str_replace($this->alertMessages['str_replace'], $newUser['error_info'], $this->alertMessages['warning']);
            $this->session->set_flashdata($this->data['flashKey'], $message);
            return redirect(base_url('join-today-casual'));
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

    public function primierSignup($username = NULL) {
        $this->verifyUser($username);
        $this->data['username'] = $username;
        $this->getPrimierSignupData();
        $this->loadLayout($this->data, $this->data['view'] . 'join_today_premier');
    }

    private function getPrimierSignupData() {
        $this->data['productList'] = $this->prdObj->getproducts($this->active);
        $this->data['statesList'] = $this->userObj->getStatesofCountry(1);
        $this->data['countryList'] = $this->userObj->getCountries();
        $this->data['signupPromo'] = $this->userObj->getSignupPromo($this->signupPromo);
    }

    public function primierPost($username = NULL) {
        $this->verifyUser($username);
        if ($this->input->post('submit')) {
            $this->validatePremierPost();
            $this->checkCard($this->input->post());
            $post = $this->input->post();
            $referrer = $this->userObj->getUserDetails($post['referrer']);
            $post['ref_id'] = !$referrer ? $this->currentUser['userid'] : $referrer['pk_user_id'];
            $post['acc_type'] = 5;
            $post['user_data'] = $this->saveUser($post);
            $this->processPremierSignup($post);
        } else {
            $message = str_replace($this->alertMessages['str_replace'], 'Something went wrong. Please try again', $this->alertMessages['warning']);
            $this->session->set_flashdata($this->data['flashKey'], $message);
            return redirect(base_url('join-today-premier'));
        }
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
            redirect(base_url('join-today-premier'));
        }
        return;
    }

    private function processPremierSignup($userData) {
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
        $arrData['upgrade_amount'] = $arrData['premierPromo']['promo_price'];
        $arrData['comm_amount'] = 0;
        $arrData['taxAmount']   = 0;
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

    private function validatePremierPost() {
//        write valiadte for premier signup;
        return TRUE;
    }

    private function updateUsername($userId, $username) {
        return $this->userObj->updateUsername($userId, $username);
    }

    private function userSignupSuccessful($newUser) {
//        send email to user and referral pending.
//        
//        try login
        $userDetail = $this->loginObj->frontendVerifyUser($newUser['username'], md5($newUser['password']));
        if ($userDetail) {
            $this->cart->destroy();
            $this->insertbounce($userDetail[0]['account_type_id'],$userDetail[0]['pk_user_id'],'signup');
            $userSessionData = $this->set_session_login($userDetail);
            $this->session->set_userdata('front_data', $userSessionData);
            $this->session->set_flashdata('first_login', $newUser);
            //$message = str_replace($this->alertMessages['str_replace'], 'Signup Successful', $this->alertMessages['success']);
            $redirectUrl = 'welcome';
        } else {
            //$message = str_replace($this->alertMessages['str_replace'], 'Invalid Username Or Password', $this->alertMessages['warning']);
            $redirectUrl = 'login';
        }
        //$this->session->set_flashdata($this->data['flashKey'], $message);
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

}
