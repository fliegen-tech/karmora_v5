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

    /*
     * Old singup controller start
     */

    public function Oldindex($username = NULL) {
        $data = '';
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $data['refree'] = $detail['user_first_name'] . ' ' . $detail['user_last_name'];
        $data['refreal_check'] = FALSE;
        if ($username == NULL) {
            $data['refreal_check'] = true;
            $data['refree'] = $detail['user_first_name'] . ' ' . $detail['user_last_name'];
        }
        $data['address'] = '';
        $data['countriesList'] = $this->usermodel->getCountrieslistAll();
        $data['statesList'] = $this->usermodel->getStatesofCountry(1);
        $data['address']['state_id'] = '';
        $data['address']['country_id'] = '';
        $data['falwes'] = $this->productmodel->getproductsBycat(99);
        $data['supplements'] = $this->productmodel->getproductsBycat(114);
        if (isset($_POST['submit'])) {
            $this->savedata();
        }
        $this->loadLayout($data, 'frontend/signup/premier_signup');
    }

    public function savedata() {

        $sameshipaddress = $this->input->post('sameshipaddress');
        if ($sameshipaddress != 1 || !isset($sameshipaddress)) {
            $this->form_validation->set_rules('biling_detail[street_address]', 'Billing Address', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[city]', 'Billing City', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[state]', 'Billing State', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[country]', 'Billing Country', 'required|trim|htmlspecialchars|xss_clean');
            $this->form_validation->set_rules('biling_detail[zipcode]', 'Billing Zip Code', 'required|trim|htmlspecialchars|xss_clean');
        }
        $gift_product = array_filter($this->input->post('gift_product'));
        $this->form_validation->set_rules('username', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|htmlspecialchars|xss_clean|is_unique[tbl_users.user_email]');
        $this->form_validation->set_rules('shipping_detail[street_address]', 'Address', 'required|trim|htmlspecialchars|xss_clean');
        $this->form_validation->set_rules('shipping_detail[city]', 'City', 'required|trim|htmlspecialchars|xss_clean');
        $this->form_validation->set_rules('shipping_detail[state]', 'State', 'required|trim|htmlspecialchars|xss_clean');
        $this->form_validation->set_rules('shipping_detail[country]', 'Country', 'required|trim|htmlspecialchars|xss_clean');
        $this->form_validation->set_rules('shipping_detail[zipcode]', 'Zip Code', 'required|trim|htmlspecialchars|xss_clean');
        $this->form_validation->set_rules('card_number', 'Card Number', 'required|trim|htmlspecialchars|numeric|min_length[13]|max_length[16]|xss_clean');
        $this->form_validation->set_rules('card_code', 'CVC', 'required|trim|htmlspecialchars|numeric|exact_length[3]|xss_clean');
        $this->form_validation->set_rules('month', 'Month', 'required|trim|htmlspecialchars|numeric|greater_than_equal_to[1]|less_than_equal_to[12]|xss_clean');
        $this->form_validation->set_rules('year', 'Year', 'required|trim|htmlspecialchars|numeric|xss_clean');

        if ($this->form_validation->run() === FALSE) {
            //print_r(validation_errors()); echo 11;die;
        } else {
            $user_id = $this->singupprocess();
            $coupon_result = $this->couponcode($user_id);
            $region = $this->input->post('region');
            $order_tax_cost = $this->calculateTax($region, $user_id);
            if ($order_tax_cost == 'error') {
                echo 'Tax Problem' . $order_tax_cost;
                die;
            }
            $call_back = $this->security->xss_clean($this->input->post('thecallback'));
            if ($call_back != '') {
                $this->Voidauthrioze($call_back);
            }
            $billing_ids = $this->update_address_function($user_id);
            if (!empty($gift_product)) {
                $order_id = $this->giftprocess($user_id, $billing_ids, $order_tax_cost, $coupon_result);
            }
            $this->db->query("CALL stored_proc_insert_retail_commission()");
            $userDeatil = $this->commonmodel->getaccountInfo($user_id);
            $password = md5($userDeatil->user_temp_data);
            $username_db = 1000 + $user_id;
            $this->config->set_item('base_url', base_url() . "$username_db");
            $row = $this->loginmodel->frontendVerifyUser($username_db, $password);
            $userSessionData = $this->set_session_login($row);
            $this->session->set_userdata('front_data', $userSessionData);
            $this->sendsignupmail($user_id, 5);
            $this->sendrefrermail($user_id, 'Premier');
            $this->sendrefrealcommsionmail($user_id);
            $this->sendordermail($user_id, $order_id);
            $this->insertbounce(5, $user_id);

            redirect(base_url() . 'premier_shopper_congrats_orders/' . $order_id);
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
        $address['streetAddress'] = trim($post['street_address']);
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

        if ($validatecsc === false) {
            $address['cityId'] = $validatecsc['city_id'];
            $billing_address_id = $this->usermodel->updateAddressLimted($address);
            //$billing_address_id = $this->db->insert_id();
            return $billing_address_id;
        } else {
            return $validatecsc['address_id'];
        }
    }

    public function redirect_shipping_address($address, $validatecsc) {

        if ($validatecsc === false) {
            $address['cityId'] = $validatecsc['city_id'];
            $this->usermodel->insertShiipingAddress($address);
            $billing_address_id = $this->db->insert_id();
            return $billing_address_id;
        } else {
            return $validatecsc['address_id'];
        }
    }

    public function giftprocess($user_id, $billing_ids, $tax_cost, $coupon_result) {
        $billingArray = explode('==', $billing_ids);
        $billing_id = $billingArray[1];
        $shipping_id = $billingArray[0];
        if ($coupon_result != FALSE) {
            $get_price = $this->data['upgrade_cost_limted'] - $coupon_result;
            if ($get_price <= 0) {
                $total_pricez = 0;
                $tax_cost = 0;
            } else {
                $total_pricez = $get_price;
            }
        } else {
            $total_pricez = $this->data['upgrade_cost_limted'];
        }
        $total_price = $total_pricez + $this->data['shipping_cost_limted'] + $tax_cost + 0.0001;
        $order_numbr = mt_rand();
        $name = $this->input->post('username');
        $datas = array(
            'order_numbr' => $order_numbr,
            'fk_user_id' => $user_id,
            'fk_shipping_address_id' => $shipping_id,
            'fk_billing_address_id' => $billing_id,
            'order_total_price' => $total_price,
            'order_cal_total' => $total_price,
            'order_shiping_cost' => $this->data['shipping_cost_limted'],
            'order_upgrade_cost' => 0,
            'order_tax_cost' => $tax_cost,
            'order_user_name' => $name,
            'order_status' => 'pending',
            'order_create_date' => date("Y-m-d H:i:s")
        );
        $this->db->insert('tbl_oders', $datas);
        $order_id = $this->db->insert_id();
        //echo '<br>'.$this->db->last_query();  die;
        //check autrize net
        $UserData = $this->commonmodel->getuserdetail($user_id);
        $postLim = $this->security->xss_clean($this->input->post());

        $userOrder = $this->cartmodel->getOrderDetailById($order_numbr, $user_id);
        $responce = $this->CCtransection($total_price, $userOrder, $user_id, $postLim);
        $this->checkrespoce($responce, $user_id, $order_id, $userOrder, $UserData);
        $gift_product = $this->input->post('gift_product');
        foreach ($gift_product as $value) {
            $quntity = 'Free Gifts';
            $array_gift = explode('==', $value);
            $product_price = $array_gift[1];
            $product_id = $array_gift[0];
            if ($coupon_result != FALSE) {
                $quntity = 'coupon_used';
            }
            $dataso = array(
                'fk_order_id' => $order_id,
                'oder_line_number' => 10,
                'fk_product_id' => $product_id,
                'fk_account_type_id' => 5,
                'order_line_price' => $product_price,
                'order_line_qty' => 1,
                'order_line_notes' => $quntity,
                'order_line_status' => 'active'
            );
            $this->db->insert('tbl_order_line', $dataso);
            //echo '<br>'.$this->db->last_query();  die;
            //insert into gift option
            $datagift = array(
                'fk_user_id' => $user_id,
                'fk_product_id' => $product_id,
                'quntity_of_gift' => 1,
                'fk_order_number' => $order_numbr
            );
            $this->db->insert('tbl_user_upgrade_gift', $datagift);
        }
        $this->Upgradecurrentaccounttype($user_id, $responce, $userOrder);
        return $order_numbr;
    }

    public function singupprocess() {
        $detail = $this->currentUser;
        if (isset($_POST['refreal_member_id']) && $_POST['refreal_member_id'] != '') {
            $refreal_member_id = $this->input->post('refreal_member_id');
        } else {
            $refreal_member_id = $detail['userid'];
        }
        $name = $this->input->post('username'); //die;
        $email = $this->input->post('email');
        $exp_name = explode(" ", $name);
        $f_name = $name;
        $l_name = '';
        if (count($exp_name) > 1) {
            $f_name = $exp_name[0];
            $l_name = $exp_name[1];
        }
        $password = $this->generatePassword();
//        $webiner = $this->usermodel->getwebinar_registration($email);
//        if(!empty($webiner)){
//           $refreal_member_id = $webiner->fk_user_id_referrer;
//        }

        $data = array(
            'user_first_name' => $f_name,
            'user_last_name' => $l_name,
            'user_username' => uniqid() . '' . $name,
            'user_email' => $email,
            'user_password' => md5($password),
            'user_temp_data' => $password,
            'user_registration_ip_address' => '',
            'user_subid' => uniqid(),
            'user_status' => 'Active',
            'fk_user_id_referrer' => $refreal_member_id,
            'user_login_path' => 'Landing Page Signup',
            'user_registration_date' => date("Y-m-d")
        );

        $this->db->insert('tbl_users', $data);
        $user_id = $this->db->insert_id();

        // update username
        $username_db = 1000 + $user_id;
        $dataUpdate = array('user_username' => $username_db);
        $this->db->where('pk_user_id', $user_id);
        $this->db->update('tbl_users', $dataUpdate);


        $dataLog = array(
            'fk_user_id' => $user_id,
            'fk_user_account_type_id' => 3,
            'user_account_log_status' => 'Active',
            'user_account_log_create_date' => date("Y-m-d")
        );

        $this->db->insert('tbl_user_to_user_account_type_log', $dataLog);
        // insert rank
        $dataRank = array(
            'fk_user_id' => $user_id,
            'user_rank_alias' => 'casual_shopper'
        );
        $this->db->insert('tbl_user_rank_log', $dataRank);
        return $user_id;
    }

    function couponcode($user_id) {
        if ($_POST['coupon_code'] != '') {
            $coupon = trim($_POST['coupon_code'], " ");
            $row = $this->usermodel->getuserCouponDetail($coupon);
            if (!empty($row)) {
                $dataCUpdate = array('coupon_used_user_id' => $user_id, 'coupons_status' => 'InActive');
                $this->db->where('coupons_code', $coupon);
                $this->db->update('tbl_coupon_users', $dataCUpdate);
                $price = $row->coupons_price;
                return $price;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /*
     * Old Controller end
     */
}
