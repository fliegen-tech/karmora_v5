<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Core class of project
 *
 * @author Usman
 */
class karmora extends CI_Controller {

    public $themeUrl;
    public $uploadUrl;
    public $current_affiliate = '';
    public $currentSubid = '525659344c44e';
    public $userId = 2;
    private $founder = 2;
    protected $alertMessages;
    protected $active = 'active';
    protected $site_url = 'http://staging5.karmora.com/';
    protected $signupPromo = 2;
    private $authObj;

    /*
     * $currentUser contain below information for the current user
     * 1) pk_user_id as userid
     * 2) user_subid as subid
     * 3) user_username as username
     */
    public $currentUser;

    public function __construct() {
        parent::__construct();
        //echo CI_VERSION;exit;
        $this->setThemeUrl();
        $this->load->helper(array('url', 'security'));
        $this->load->model(array('commonmodel'));
        $this->load->library(array('email', 'cart', 'Authorizenet')); //
        $this->data['themeUrl'] = $this->themeUrl;
        $this->data['currentSubid'] = $this->currentSubid;
        $this->data['modals'] = array('best-cash-back-guarantee', 'video-popup');
        $this->data['video_link'] = 'https://www.youtube.com/embed/ewb-yREptvg?rel=0';
        $this->currentUser = $this->commonmodel->getFounder($this->founder);
//        $this->currentUser = $this->commonmodel->getFounder($this->founder);
        $this->setAlertMessages();
        $this->setUploadUrl();
    }

    private function setThemeUrl() {
        $this->themeUrl = base_url('public');
    }

    private function setUploadUrl() {
        $this->uploadUrl = APPPATH . '../public/upload/';
    }

    private function setAlertMessages() {
        $this->alertMessages = array(
            'str_replace' => '{{message}}',
            'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            {{message}}</div>',
            'info' => '<div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            {{message}}</div>',
            'warning' => '<div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            {{message}}</div>',
            'danger' => '<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            {{message}}</div>'
        );
    }

    public function verifyUser($username = NULL) {
//        check if user is logged in set baseURL for signed in user else set baseURL for username passed in URLs
        $userVerifySuccess = !$this->checkUserLogin() ?
                /*
                 * check if username is not null, if username is empty set user global vars to default values
                 */
                (is_null($username) ? TRUE : $this->checkUsername($username) ) :
                /*
                 * if user is logged in user is verified already, set value to TRUE
                 */
                TRUE;
        // echo base_url(); die;
        //echo $userVerifySuccess; die;
        $this->setBaseUrl($userVerifySuccess);
        if (isset($this->session->userdata['front_data']['id']) && $username != $this->currentUser['username']) {
            redirect(base_url());
        } elseif (!$userVerifySuccess) {
            redirect(base_url());
        }
        return $userVerifySuccess;
    }

// set new baseURL and redirect to it
    private function setBaseUrl($verify) { //echo $verify; die;
        if ($verify && $this->currentUser['userid'] != $this->founder) {
            $this->config->set_item('base_url', base_url($this->currentUser['username']));
        }
        return;
    }

    private function checkUsername($username) {
        // echo '<br> checking uesrname in checkUaw'.$username; //die;
        /*
         * check if username is valid and is active in database also check if return is false.
         * if not false remove the top array from the returned value.
         */
        $userDetail = is_null($username) ? FALSE : $this->getUserDetails($username);
        //echo '<pre>'; print_r($userDetail); echo '</pre>';
        $this->currentUser = $userDetail !== FALSE ? $this->setGlobalValArrayFromUserDetail($userDetail) : $this->setDefaultValues();
        // echo $this->currentUser; die;
        return $userDetail == FALSE ? FALSE : TRUE;
    }

//    set values from user detail array
    private function setGlobalValArrayFromUserDetail($data) {
        $vals = $data;
        //echo '<pre>';        print_r($vals); die;
        $response = array(
            'userid' => $vals ['pk_user_id'],
            'subid' => $vals ['user_subid'],
            'user_first_name' => $vals ['user_first_name'],
            'user_last_name' => $vals ['user_last_name'],
            'user_email' => $vals ['user_email'],
            'username' => $vals ['user_username'],
            'user_phone_no' => $vals ['user_phone_no'],
            'user_account_type_id' => $vals ['fk_user_account_type_id'],
            'user_account_type_title' => $vals ['user_account_type_title'],
        );
        return $response;
    }

//    function to set defaul values for user global variables
    private function setDefaultValues() {
        return $this->commonmodel->getFounder($this->founder);
    }

// function to check if user is logged in
    private function checkUserLogin() {
        if (isset($this->session->userdata['front_data'])) {
            $this->session->userdata['front_data']['grace_period'] = $this->commonmodel->checkGrace($this->session->userdata['front_data']['id']);
            $response = TRUE;
            $this->currentUser = array(
                'userid' => $this->session->userdata['front_data']['id'],
                'subid' => $this->session->userdata['front_data']['subid'],
                'username' => $this->session->userdata['front_data']['username'],
                'user_email' => $this->session->userdata['front_data']['email'],
                'user_phone_no' => $this->session->userdata['front_data']['user_phone_no'],
                'user_first_name' => $this->session->userdata['front_data']['user_first_name'],
                'user_last_name' => $this->session->userdata['front_data']['user_last_name'],
                'user_account_type_id' => $this->session->userdata['front_data']['user_account_type_id'],
                'user_account_type_title' => $this->session->userdata['front_data']['user_account_type_title'],
            );
        } else {
            $response = FALSE;
        }
        return $response;
    }

    public function getUserDetails($username) {
        $user_detail = $this->commonmodel->getUserDetails($username);
        return $user_detail;
    }

    // this function check user_account type id
    public function checkUserAccounttype($user_id) {
        $row = $this->commonmodel->getAccounttype($user_id);
        if (!empty($row)) {
            $fk_user_account_type_id = $row->fk_user_account_type_id;
            return $fk_user_account_type_id;
        } else {
            show_404();
        }
    }

    public function prepURL($affiliateNetworkId = null, $url = null) {
        $subIdElement = $this->commonmodel->getAffiliateNetworkSubidElement($affiliateNetworkId);

        $element = explode('=', $subIdElement->url_var);
        $element[1] = $this->currentUser['subid'];
        $elementWithSubid = implode('=', $element);
        // check url have parameter or not
        $checkParam = parse_url($url);
        if (isset($checkParam['query'])) {
            //Has query params
            $response = $url . $elementWithSubid;
        } else {
            //Has no query params
            $newUrl = str_replace('&', '?', $elementWithSubid);
            $response = $url . $newUrl;
        }
        return $response;
    }

    public function checklogin() {
        if (!isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url());
        }
    }

    public function checknotlogin() {
        if (isset($this->session->userdata['front_data']['id'])) {
            redirect(base_url());
        }
    }

    public function insertbounce($accounttype, $user_id, $type) {
        $bounsamount = $this->usermodel->getbounckarmoracash($type, $accounttype);
        if (!empty($bounsamount)) {
            $dataLog = array(
                'fk_user_id' => $user_id,
                'fk_user_id_from' => $user_id,
                'kash_amount' => $bounsamount->bonus_karmora_cash_amount,
                'kash_type' => 'Deposit',
                'kash_description' => $bounsamount->bonus_title
            );
            $this->db->insert('tbl_karmora_kash_account', $dataLog);
            return true;
        } else {
            return FALSE;
        }
    }

    /**
     * @return string
     */
    public function InsertRank($user_id,$type ){
        $dataRank = array(
            'fk_user_id' => $user_id,
            'user_rank_alias' => $type//'casual_shopper'
        );
        $this->db->insert('tbl_user_rank_log', $dataRank);
    }

    /* ------------Load Layout Functions start------------------ */

    public function loadLayout($data, $content_path) {
        $html['header'] = $this->load->view('frontend/template/partials/header', $data, TRUE);
        $html['footer'] = $this->load->view('frontend/template/partials/footer', $data, TRUE);
        $html['content'] = $this->load->view($content_path, $data, TRUE);
        $this->load->view('frontend/template/template', $html);
    }

    /* ------------Load Layout Functions end ------------------ */

    public function set_session_login($row) {
        $this->cart->destroy();
        $userSessionData = array();
        $user_detail = $this->commonmodel->getFounder($row[0]['pk_user_id']);
        // echo '<pre>';print_r($user_detail);//die;
        foreach ($row as $userData) {
            $userSessionData['id'] = $userData['pk_user_id'];
            $userSessionData['user_account_type_id'] = $user_detail[0]['user_account_type_id'];
            $userSessionData['user_account_type_title'] = $user_detail[0]['user_account_type_title'];
            $userSessionData['username'] = $userData['user_username'];
            $userSessionData['email'] = $userData['user_email'];
            $userSessionData['user_phone_no'] = $userData['user_phone_no'];
            $userSessionData['status'] = $userData['user_status'];
            $userSessionData['user_first_name'] = $userData['user_first_name'];
            $userSessionData['user_last_name'] = $userData['user_last_name'];
            $userSessionData['subid'] = $userData['user_subid'];
        }
        return $userSessionData;
    }

    private function setupAuthLib() {
        $this->authObj = new Authorizenet;
        $this->authObj->activateSandboxMode(TRUE);
    }

    protected function createARB($userData, $subscription, $card) {
        $this->setupAuthLib();
        $this->authObj->creditCardInfo['card_number'] = $card['number'];
        $this->authObj->creditCardInfo['exp_date'] = $card['exp_date'];
        $this->authObj->creditCardInfo['cvc_code'] = $card['cvv'];

        $this->authObj->billingAddressInfo = array(
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
            'address' => $userData['address'],
            'city' => $userData['city'],
            'state' => $userData['state'],
            'zip' => $userData['zip'],
            'country' => $userData['country']
        );
        $this->authObj->subscriptionInfo = array(
            'title' => $subscription['user_account_billing_properties_title'],
            'descp' => $subscription['user_account_billing_properties_title'],
            'amount' => $subscription['user_account_billing_properties_amount'],
            'trialAmount' => $subscription['user_account_billing_properties_trial_amount'],
            'startDate' => date('Y-m-d'), //format YYYY-MM-DD
            'intervalLength' => 1,//$subscription['user_account_billing_properties_interval_length'],
            'intervalUnit' => $subscription['user_account_billing_properties_arb_type'],
            'totalOccurence' => 9999,
            'trialOccurence' => $subscription['user_account_billing_properties_trial_occurance']
        );
        return $this->authObj->arbCreate();
    }

    public function CCtransection($data) {
        $this->setupAuthLib();

        $this->authObj->creditCardInfo['card_number'] = $data['card']['number'];
        $this->authObj->creditCardInfo['exp_date'] = $data['card']['exp_date'];
        $this->authObj->creditCardInfo['cvc_code'] = $data['card']['cvv'];

        $this->authObj->billingAddressInfo = array(
            'firstName' => $data['fname'],
            'lastName' => $data['lname'],
            'address' => $data['billing_address'],
            'city' => $data['billing_city'],
            'state' => $data['billing_state'],
            'zip' => $data['billing_zip'],
            'country' => $data['billing_country']
        );

        $this->authObj->shippingAddressInfo = array(
            'firstName' => $data['fname'],
            'lastName' => $data['lname'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'country' => $data['country']
        );

        $this->authObj->customerInfo = array(
            'custType' => 'individual',
            'custId' => $data['user_id'],
            'custEmail' => $data['email']
        );

        $this->authObj->orderNumber = $data['order_number'];
        $this->authObj->amountToProcess = $data['totalAmount'];

        return $this->authObj->chargeCreditCard();
    }

    function runauthrioze($data) {
        $this->setupAuthLib();
        $this->authObj->creditCardInfo['card_number'] = $data['number'];
        $this->authObj->creditCardInfo['exp_date'] = $data['exp_date'];
        $this->authObj->creditCardInfo['cvc_code'] = $data['cvv'];

        $this->authObj->amountToProcess = 0.01;
        $this->authObj->amountTrial = 0;
        return $this->authObj->runAuthorization();
    }

    function Voidauthrioze($trans_id) {
        $this->setupAuthLib();
        return $this->authObj->voidTransaction($trans_id);
    }

    public function checkcartupgrade() {
        if (isset($this->session->userdata['front_data']) && $this->session->userdata['front_data']['user_account_type_id'] == 3) {
            return $this->checkupgradecart();
        } elseif (isset($this->session->userdata['front_data']) && $this->session->userdata['front_data']['user_account_type_id'] == 5) {
            return false;
        } else {
            return $this->checkupgradecart();
        }
    }

    public function checkupgradecart() {
        if (!$this->cart->contents()) {
            return false;
        } else {
            foreach ($this->cart->contents() as $cart_d) {
                if ($cart_d['shopper_account_type'] == 5 && $cart_d['price'] != 9.95 ) {
                    return true;
                }
            }
        }
    }
    public function checkupgradecartcheckout() {
        if (!$this->cart->contents()) {
            return false;
        } else {
            foreach ($this->cart->contents() as $cart_d) {
                if ($cart_d['shopper_account_type'] == 5) {
                    return true;
                }
            }
        }
    }

    /* ------------Start Email Functions------------------ */

    public function prepareEmailInfo($newUser, $email_id, $image, $click_link) {
        $email_data = $this->commonmodel->getemailInfo($email_id);
        $link = '<a href="' . base_url() . $click_link . '">Click Here</a>';
        $tags = array("{First-Name}", "{referrer-name}", "{img-src}", "{user_username}", "{user_email}", "{password}", "{Click-Here}", "{live-chat}", "{image-link}", "{current-date}");
        $replace = array($newUser['fname'] . ' ' . $newUser['lname'], '', $image, $newUser['username'], $newUser['email'], $newUser['password'], $link, '<a href="https://staging3.karmora.com/liveSupport/">Live chat</a>', $image, date('m-d-Y', strtotime("+30 days")));
        $subject = $email_data->email_title;
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
        $to = $newUser['email'];
        $result = $this->send_mail($to, $subject, $message);
        return $result;
    }

    function sendrefrermail($id, $accounttype) {
        $result = '';
        $leval = $this->commonmodel->get_all_allowed_levels_exclusive('max');
        for ($i = 1; $i <= $leval->allowed_levels; $i++) {
            $user_id_refer_level = $this->commonmodel->get_user_referrer_for_lvl($id, $i);
            if ($user_id_refer_level->ref_no != 0) {
                $LoginData = $this->commonmodel->getuserdetailById($id);
                $userData = $this->commonmodel->getuserdetailById($user_id_refer_level->ref_no);
                $email_data = $this->commonmodel->getemailInfo(3);
                $complete_name = $LoginData->user_first_name . ' ' . $LoginData->user_last_name;
                $base = $userData->user_username;
                $upgrade_link = $this->site_url . $base . '/karmora-upgrade/';
                $upgrade_link = '<a href="' . $upgrade_link . '">Clicking Here</a>';
                $tags = array("{Full-Name}", "{First-Name}", "{Membership-Level}", "{upgrade-link}", "{live-chat}");
                $replace = array($complete_name, $userData->user_first_name, $accounttype, $upgrade_link, '<a href="' . $this->site_url . 'liveSupport/" style="color: #cc0066;text-decoration:none;">Click here</a>');
                $subject = $email_data->email_title;
                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
                $to = $userData->user_email;
                $result = $this->send_mail($to, $subject, $message);
            }
        }
        return $result;
    }

    function sendrefrealcommsionmail($id) {
        $leval = $this->commonmodel->get_all_allowed_levels_exclusive('max');
        for ($i = 1; $i <= $leval->allowed_levels; $i++) {
            $user_id_refer_level = $this->commonmodel->get_user_referrer_for_lvl($id, $i);
            if ($user_id_refer_level->ref_no != 0) {
                $email_data = $this->commonmodel->getemailInfo(8);
                $reffer_data = $this->commonmodel->getuserdetailById($user_id_refer_level->ref_no);
                $complete_name = $reffer_data->user_first_name . ' ' . $reffer_data->user_last_name;
                $base = $reffer_data->user_username;
                $ewaletlink = $this->site_url . $base . '/my-ewallet/';
                $ewaletlink = '<a href="' . $ewaletlink . '">Click Here</a>';
                $cashlink = $this->site_url . $base . '/my-karmora-kash/';
                $cashlink = '<a href="' . $cashlink . '" >Click Here</a>';
                $tags = array("{First-Name}", "{ewallet-link}", "{cash-link}");
                $replace = array($complete_name, $ewaletlink, $cashlink);
                $subject = $email_data->email_title;
                $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
                $to = $reffer_data->user_email;
                $result = $this->send_mail($to, $subject, $message);
            }
        }
        return $result;
    }

    function sendordermail($id, $order_id) {
        $userData = $this->commonmodel->getuserdetailById($id);
        $email_data = $this->commonmodel->getemailInfo(4);
        $complete_name = $userData->user_first_name . ' ' . $userData->user_last_name;
        $base = $userData->user_username;
        $link = $this->site_url . $base . '/my-orders/' . $order_id;
        $order_link = '<a href="' . $link . '" >Clicking Here</a>';
        $refund = $this->site_url . $base . '/karmora-return-policy';
        $tags = array("{First-Name}", "{link}", "{refund-policy}", "{image-link}");
        $replace = array($complete_name, $order_link, $refund, $this->themeUrl . 'images/money-back-100.png');
        $subject = $email_data->email_title;
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description);
        $to = $userData->user_email;
        $result = $this->send_mail($to, $subject, $message);
        return $result;
    }

    public function prepEmailContent($tags, $replace, $title, $content) {
        $header = $this->load->view('frontend/email/emailheader', '', TRUE);
        $footer = $this->load->view('frontend/email/emailfooter', '', TRUE);
        $message = $header;
        $message .= str_replace($tags, $replace, $content);
        return $message .= $footer;
    }

    public function send_mail($to, $subject, $message, $from = "noreply@karmora.com") {
        $config = array();
        $config['mailtype'] = 'html';
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $from_title = $from != 'noreply@karmora.com' ? $from : 'Karmora';
        $this->email->from($from, $from_title);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        //echo 'in_email'.$this->email->print_debugger(); die;
    }

    /*
     *
     * OLD KARMORA FUNCTIONS
     *
     */

    public function create_queue($recipient_emails, $subject, $message, $from) {

        foreach ($recipient_emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $data = array(
                    'email_queue_recipient' => $email,
                    'email_queue_from' => $from,
                    'email_queue_subject' => $subject,
                    'email_queue_message' => $message
                );

                $this->db->insert('tbl_email_queue', $data);
            }
        }
    }

    public function karmoraenotfiationmail($userData, $email_id, $reffer_data = NULL, $order_id = NULL) {
        $html = '';
        if ($order_id != '') {
            $user_username = $userData->user_username;
            $order_detail = $this->cartmodel->getOrderDetailById($order_id, $userData->userid);
            $Orderproduct = $this->cartmodel->getOrderProduct($order_detail->pk_order_id);
            $orderTotalDetail = !empty($order_detail->pk_order_id) ? $this->cartmodel->getOrderDetailTotalsSummery_row($order_detail->pk_order_id) : FALSE;
            $html .= '<table style="width: 100%; max-width: 100%; border: 1px solid #ccc; padding: 10px 0px;height: auto; overflow: hidden; border-bottom: none;">
                    <tbody>
                        <tr style="padding:0px; overflow: hidden; clear: both;">
                            <td class="col-md-6 col-xs-6" style="width: 45%; position: relative; min-height: 1px; padding-left: 15px;">
                                <h2 style="font-size: 20px; ">Order Detail:</h2>
                            </td>
                            <td class="col-md-6 col-xs-6" style="text-align: right; width: 48%; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;">
                                <h2 style="font-size: 20px; margin: 0px;"> #' . $order_detail->order_no . ' </h2>
                                <h2 class="date-order-fa" style="font-size: 16px; margin: 0px;">' . $order_detail->order_date . '</h2>
                            </td>
                        </tr>
                        <tr style="border-top:1px solid #ccc;">
                            <span class="line-spc"></span>
                            <span class="clearfix"></span>
                            <td style="width: 45%; position: relative; min-height: 1px; padding-right: 0px; padding-left: 15px;">
                                <h3 style="font-size: 20px; font-weight: 600 !important; display: block; text-transform: uppercase; margin: 0px 0 20px;">Billing Address</h3>
                                <table><tbody>
                                    <tr style="width: 100%;">
                                        <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">Street:</b>' . $order_detail->billing_address_street . '</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">City:</b>' . $order_detail->billing_address_city . '</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">State:</b>' . $order_detail->billing_address_state . '</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">Zip Code:</b>' . $order_detail->billing_address_zipcode . '</td>
                                    </tr>
                                    <tr style="width: 100%;">
                                        <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">Phone Number:</b>' . $order_detail->billing_address_phone_number . '</td>
                                    </tr>
                                </tbody></table>
                            </td>
                            <td style="width: 45%; position: relative; min-height: 1px; text-align: right; padding-right: 15px; padding-left: 0px;">
                                <h3 style="font-size: 20px; font-weight: 600 !important; display: block; text-transform: uppercase; margin: 0px 0 20px;">Shipping Address</h3>
                                <table><tbody>
                                    <tr style="width: 100%;">
                                        <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">Street:</b>' . $order_detail->shipping_address_street . '</td>
                                        </tr>
                                        <tr style="width: 100%;">
                                            <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">City:</b>' . $order_detail->shipping_address_city . '</td>
                                        </tr>
                                        <tr style="width: 100%;">
                                            <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">State:</b>' . $order_detail->shipping_address_state . '</td>
                                        </tr>
                                        <tr style="width: 100%;">
                                            <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">Zip Code:</b>' . $order_detail->shipping_address_zipcode . '</td>
                                        </tr>
                                        <tr style="width: 100%;">
                                            <td style="margin-bottom: 10px; width: 100%; font-size: 12px;"><b style="margin-right: 15px;">Phone Number:</b>' . $order_detail->shipping_address_phone_number . '</td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>';
            $html .= '<table style="width: 100%; max-width: 100%; margin-bottom: 20px;" border="1" cellspacing="0">
                            <thead style="text-align: left; padding: 0; margin: 0;">
                                <tr style="text-align: left; padding: 0; margin: 0;">
                                    <th style="text-align: left; padding: 10px; margin: 0;"><b>Product Description</b></th>
                                    <th style="text-align: left; padding: 10px; margin: 0;"><b>Qty</b></th>
                                    <th style="text-align: left; padding: 10px; margin: 0;"><b>Extended Price</b></th>
                                </tr>
                            </thead><tbody>';
            $total_amount = 0;
            foreach ($Orderproduct as $pr) {
                if ($pr['order_line_notes'] == 'Free Gifts') {
                    $qty = 1;
                } else {
                    $qty = $pr['order_line_qty'];
                }
                if ($pr['order_line_notes'] == 'Free Gifts') {
                    $price = 19.95 . ' (Limted time offer)';
                } elseif ($pr['order_line_notes'] == 'coupon_used') {
                    $price = 5.95 . ' (Coupon Used)';
                } else {
                    $price = number_format($pr['order_line_price'] * $pr['order_line_qty'], 2, ".", ",");
                }
                $html .= '<tr style="text-align: left; padding: 0; margin: 0;">';
                $html .= '<td style="text-align: left; padding: 5px 10px; margin: 0;">' . $pr['product_title'] . '</td>';
                $html .= '<td style="text-align: left; padding: 5px 10px; margin: 0;">' . $qty . '</td>';
                $html .= '<td style="text-align: left; padding: 5px 10px; margin: 0;">' . $price . '</td>';
                $html .= '</tr>';
                $sum_total = number_format($pr['order_line_price'] * $pr['order_line_qty'], 2, ".", ",");
                $total_amount = $sum_total + $total_amount;
                if ($pr['order_line_notes'] == 'Free Gifts') {
                    $total_amount = 19.95;
                } elseif ($pr['order_line_notes'] == 'coupon_used') {
                    $total_amount = 0;
                }
            }
            $html .= '</tbody></table>';
            $total_amount = $total_amount + 0.0001;
        }
        $totalnumber = $total_amount - $orderTotalDetail->order_karmora_cash_price + $orderTotalDetail->order_shiping_cost + $orderTotalDetail->order_tax_cost + $orderTotalDetail->order_upgrade_cost;
        $charged = $totalnumber - $orderTotalDetail->order_commsion_price;
        $html .= '<table class="col-md-12" id="main-order" style="width: 100%; max-width: 100%; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; border: 1px solid #ccc;"><tbody>
            <tr>
                <td class="col-md-6 pull-left col-sm-6 col-xs-12" style="float: left!important; width: 35%; position: relative;min-height: 1px; padding-right: 15px; padding-left: 15px;" >
                    <span class="thanku-bussiness">
                        <h4><strong>Thank you for your purchase!</strong></h4>
                        <span class="clearfix"></span>
                        <span class="line-spc"></span>
                        <span class="clearfix"></span>
                        <ul style="list-style-type: none;">
                            <li>Every order comes with our 30 Day – No Questions Asked – Money Back Guarantee!</li>
                            <li><a href="https://www.karmora.com/' . $user_username . '/compensation-plan" class="karmora-color-pink">Click Here</a> to learn how to build a Shopping Community and get paid!</li>
                            <li><a href="https://www.karmora.com/' . $user_username . '/profit-sharing-program" class="karmora-color-pink">Click Here</a> to learn how to participate in our company Profit Sharing Program!</li>
                            <!--<li>Remember… You can earn up to $50 Karmora Kash for reviewing every Exclusive Product you purchase! </li>-->
                            <li>As always, we wish you <strong>Good Luck</strong>, <strong>Good Fortune</strong> and <strong>Good Karmora</strong>!</li>
                        </ul>
                    </span>
                </td>
                <td class="col-md-4 pull-right col-sm-6 col-xs-12" id="mypinkdiv" style="width:40%; position: relative; margin-left: 25%; min-height: 1px; padding-right: 15px; padding-left: 15px; float: right;">
                        <table style="float: right;">
                                <tbody>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Exclusive Product Total</td>
                                        <td style="text-align: right; width: 20%;">' . number_format($total_amount, 2, '.', ',') . '</td>
                                    </tr>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Karmora Kash</td>
                                        <td style="text-align: right; width: 20%;">-' . number_format($orderTotalDetail->order_karmora_cash_price, 2, '.', ',') . '</td>
                                    </tr>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Subtotal</td>
                                        <td style="text-align: right; width: 20%;">$' . number_format(($total_amount + $orderTotalDetail->order_upgrade_cost) - $orderTotalDetail->order_karmora_cash_price, 2, '.', ',') . '</td>
                                    </tr>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Shipping &amp; Handling</td>
                                        <td style="text-align: right; width: 20%;">$' . number_format($orderTotalDetail->order_shiping_cost, 2, '.', ',') . '</td>
                                    </tr>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Tax</td>
                                        <td style="text-align: right; width: 20%;">$' . number_format($orderTotalDetail->order_tax_cost, 2, '.', ',') . '</td>
                                    </tr>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Order Total</td>
                                        <td style="text-align: right; width: 20%;">$' . number_format($totalnumber, 2, '.', ',') . '</td>
                                    </tr>
                                     <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">eWallet Funds Applied</td>
                                        <td style="text-align: right; width: 20%; color:red;">-$' . number_format($orderTotalDetail->order_commsion_price, 2, '.', ',') . '</td>
                                    </tr>
                                    <tr style="margin-bottom: 2px; padding: 5px 10PX; background-color: #f9f9f9; border-radius: 2px; list-style-type: none; ">
                                        <td style="width: 79%;">Total Charged</td>
                                        <td style="text-align: right; width: 20%; color:red;">$' . number_format($charged, 2, '.', ',') . '</td>
                                    </tr>

                                </tbody>
                            </table>
                </td>
            </tr>
        </tbody></table>';
        $email_data = $this->commonmodel->getemailInfo($email_id);
        $address_data = $this->commonmodel->getMemberCurrentAddress($userData->userid);
        $complete_name = $userData->user_first_name . ' ' . $userData->user_last_name;
        $user_username = $userData->user_username;
        $user_email = $userData->user_email;
        $user_phone_no = $userData->user_phone_no;
        $address = $address_data->street_address . ' ' . $address_data->city . ' ' . $address_data->state . ' ' . $address_data->zipcode;
        $tags = array("{First-Name}", "{referrer-name}", "{phone_no}", "{user_username}", "{user_email}", "{address}", "{street_address}", "{city}", "{state}", "{product_detail}");
        $replace = array($complete_name, $reffer_data->user_first_name, $user_phone_no, $user_username, $user_email, $address, $address_data->street_address, $address_data->city, $address_data->state, $html);
        $subject = $email_data->email_title;
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, '', $email_data->email_header_text, 'withoutheader');
        $this->send_mail('faizana@karmora.com', $subject, $message); //notifications@Karmora.com
    }

}
