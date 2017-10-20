<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Share extends karmora
{


    public $data = array();

    public function __construct() {

        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('sharemodel','commonmodel' , 'storemodel'));
        $this->load->library('form_validation');
    }

    public function index($username = NULL){
        $this->verifyUser($username); //die;
        $this->loadLayout($this->data, 'frontend/share/homepage');

    }

    public function karmora_videos($username = NULL){
        $this->verifyUser($username); //die;
        $this->data['videos'] = $this->sharemodel->getVideos(58);
        $this->loadLayout($this->data, 'frontend/share/good_karmora_videos');
    }

    public function email($username = NULL){
        $data = array();
        $this->verifyUser($username); //die;
        $detail = $this->currentUser;


        if (!empty($_POST)) {
            $friends_name = $this->input->post('friends_name');
            $friends_emails = $this->input->post('friends_email');
            //$this->form_validation->set_rules('friends_email', 'To Share Enter Atleast one Email', 'callback_atleast_one');
            //$this->form_validation->set_error_delimiters('', '');

            $query = array();
            $error_data = array();
            $i = 0;
            foreach ($friends_emails as $key => $value) {
                $user = $this->check_email($value, $detail['userid']);

                if ($user) {
                    $query[] = '("' . $value . '",' . $detail['userid'] . ',"others")';
                    $this->sendsharemail($detail['userid'],$value,$friends_name[$key]);
                    //echo 'insert into email_contacts (email,sender_id,email_type) values '.implode(',', $data);
                } else {
                    $error_data[] = $value . ' is already invited.';
                }
                $i++;
            }
            $msg = '';


            if (!empty($query)) {
                $queryStr = "INSERT
                                    INTO
                                        tbl_email_contacts(email,sender_id,email_type)
                                        VALUES " . implode(',', $query);
                $this->db->query($queryStr);
                $data['msg'] = '<div class="alert alert-success" role="alert">Email add successfully.</div>';
                
            }
            if (!empty($error_data)) {

                $msg = '<div class="alert alert-warning" role="alert">';

                foreach ($error_data as $key => $value) {
                    $msg .= '<p>' . $value . '</p>';
                }
                $msg .= '</div>';
                $data['msg'] = $msg;
            }


        }

        $automated_list = $this->sharemodel->get_auto_list($detail['userid']);
        $data['automated_list'] = $automated_list;
        // echo "<pre>";print_r($automated_list);die;
        if (isset($this->session->userdata['front_data']['id'])) {
            $data['yahoo_circle'] = $this->yahoo_circle();
            $data['hotmail_circle'] = $this->hotmail_circle();
            $data['gmail_circle'] = $this->gmail_circle();

            $data['ShopperInvited'] = $this->sharemodel->getShopperInvited($detail['userid']);
            $data['ShopperCommunity'] = $this->sharemodel->getShopperCommunity($detail['userid']);
            $data['aboutJoining'] = $this->sharemodel->getaboutJoiningCommunity($detail['userid']);
        }
        $this->loadLayout($data, 'frontend/share/good_karmora_emails');
    }

    public function good_karmora_ads($username = NULL){
        $data = array();
        //echo $username ;
        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        $this->loadLayout($data, 'frontend/share/good_karmora_ads');
    }
    
    public function tripple_karmora_kash($username = NULL){
        $data = array();
        //echo $username ;
        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        $data['description'] = 'Casual Shoppers earn 3X Matching Karmora Kash and Premier Shoppers 6X Matching Karmora Kash when shopping with any of our Triple Tremendous Cash Back Stores during the month of September, 2016!';
        $data['tripplekarmorastore'] = $this->homemodel->gettripplekarmoracash($detail['user_account_type_id'], '');
        $this->loadLayout($data, 'frontend/share/tripplekarmorastore_ad');
    }

    public function cash_back_ads($username = NULL){
        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        $categories = $this->storemodel->getATCategory($detail['user_account_type_id']);
        $this->data['categories'] = $categories;
        $store_alias = NULL;
        if (isset($this->session->userdata['front_data']['id']) && ($store_alias === 'favourtie')) {
            $this->data['category_all_stores'] = $this->storemodel->GetfavourtieStore($detail['userid']);
            $alias = 'favourtie';
        } else {
            $alias = $this->storemodel->CheckCatAlias($store_alias);
            $this->data['category_all_stores'] = $this->storemodel->GetStore($detail['user_account_type_id'], $alias, $detail['userid']);
        }
        if (!empty($data['category_all_stores'])) {
            $this->data['StoreArry'] = $this->data['category_all_stores'];
            foreach ($this->data['StoreArry'] as $store) {
                $store_title = $store['store_title'] . "<br />";
                $curr = current(str_split($store_title));

                if (!preg_match("/^[a-zA-Z]$/", $curr)) {
                    $storeArray['0-9'][$store_title] = $store;
                } else {
                    $storeArray[strtoupper($curr)][$store_title] = $store;
                }
            }
            $this->data['storeArray'] = $storeArray;
        }
        $this->loadLayout($this->data, 'frontend/share/cash_back_ads');
    }

    public function cash_o_palooza_ads($username = NULL){
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['deals'] = $this->storemodel->getSpecialStores($detail['user_account_type_id'], 'cash_o_palooza');
        $this->data['description'] = 'Karmora Cash-O-Palooza Deals are special cash back deals on name brand advertisers.  You won’t find higher cash back anytime, anywhere, ever!  Join Karmora for FREE and get cash back on over 1,700 stores!';
        $this->loadLayout($this->data, 'frontend/share/cash_o_palooza_ads');
    }

    public function smokin_hot_deal_ads($username = NULL){
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['deals'] = $this->storemodel->getSpecialStores($detail['user_account_type_id'], 'smokin_hot_deals');
        $this->data['description'] = 'Karmora Smokin Hot Deals make ya jump back and want to kiss yoself!  Check out these great deals combined with special online coupons for extra savings!  Join Karmora for FREE and get cash back on over 1,700 stores!';
        $this->loadLayout($this->data, 'frontend/share/smokin_hot_deal_ads');
    }

    public function custom_ads( $ad_type,$username = NULL){
        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        $this->data['type'] = $ad_type;
        $this->data['b3_supplements'] = $this->sharemodel->getCategoryList(119);
        $this->data['flawless_product'] = $this->sharemodel->getCategoryList(120);
        $type = $ad_type;
        $asc = 'banner_ads_position';
        $this->db->where('banner_ads_status', 1);
        $this->db->where('banner_ads_banner_type', $type);
        $this->db->order_by($asc, 'asc');
        $query = $this->db->get('tbl_banner_ads');
        $data['custom_ads'] = array();
	    if ( count( $query->result() ) > 0 ) {
            $this->data['custom_ads'] = $query->result();
	    }
        $this->loadLayout($this->data, 'frontend/share/' . $ad_type);
    }


    /*PHP Run time generated karmora ad*/
    public function generateAdImage($store_id, $username = NULL)
    {

        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        $acc_type_id = $detail['user_account_type_id'];
        $this->db->where(array('store_id' => $store_id, 'acc_type_id' => $acc_type_id));
        $query = $this->db->get('view_stores_list_stores')->row();

        $store_logo = $this->themeUrl . '/images/' . $query->store_image;

        // Or open as a string
        $data = file_get_contents($store_logo);
        $log_info = getimagesizefromstring($data);

        //print_r($size_info2);
        header("Content-type: image/png");
        $im = imagecreatetruecolor(258, 248);

        $deal_image = $this->themeUrl . '/images/store/share-ad-new.jpg';
        $src_img = imagecreatefromjpeg($deal_image);
        if ($log_info['mime'] == 'image/jpeg') {
            $logo_image = imagecreatefromjpeg($store_logo);
        }

        if ($log_info['mime'] == 'image/png') {
            $logo_image = imagecreatefrompng($store_logo);
        }

        if ($log_info['mime'] == 'image/gif') {
            $logo_image = imagecreatefromgif($store_logo);
        }
        $x = 0;
        if ($log_info[0] < 258) {
            $x = (258 - $log_info[0]) / 2;
        }

        imagecopy($im, $src_img, 0, 0, 0, 0, 258, 248);
        imagecopy($im, $logo_image, $x, 65, 0, 0, $log_info[0], $log_info[1]);
        /*$textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 90, 'Lorem Ipsum has been the', $textcolor);
        $textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 110, 'Lorem Ipsum has been the', $textcolor);
        $textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 130, 'Lorem Ipsum has been the', $textcolor);*/
        imagepng($im);


    }

    /*PHP Run time generated karmora ad*/
    public function generateCashoPaloozaAdImage($store_id, $username = NULL)
    {

        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        if ($this->session->userdata('front_data')) {

        }else{
            $detail['user_account_type_id']    = 0;
        }
        $acc_type_id = $detail['user_account_type_id'];
        $this->db->where(array('store_id' => $store_id, 'acc_type_id' => $acc_type_id));
        $query = $this->db->get('view_stores_list_special_deals')->row();
        //echo "<pre>";
        //print_r($this->db->last_query());
         $store_logo = $this->themeUrl . '/images/' . $query->deal_banner;

        // Or open as a string
        $data = file_get_contents($store_logo);
        $log_info = getimagesizefromstring($data);

        //print_r($log_info);die;
        header("Content-type: image/png");
        $im = imagecreatetruecolor(258, 248);

        $deal_image = $this->themeUrl . '/images/special_deals/cash-o-palooza-ad.jpg';
        $src_img = imagecreatefromjpeg($deal_image);
        if ($log_info['mime'] == 'image/jpeg') {
            $logo_image = imagecreatefromjpeg($store_logo);
        }

        if ($log_info['mime'] == 'image/png') {
            $logo_image = imagecreatefrompng($store_logo);
        }

        if ($log_info['mime'] == 'image/gif') {
            $logo_image = imagecreatefromgif($store_logo);
        }
        $x = (258 - $log_info[0])/2;
        $y = 55;
        if($log_info[1]>45){
            $y = 41;
        }
        //$x = 50;
        imagecopy($im, $src_img, 0, 0, 0, 0, 258, 248);
        imagecopy($im, $logo_image, $x, $y, 0, 0, $log_info[0], $log_info[1]);
        /*$textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 90, 'Lorem Ipsum has been the', $textcolor);
        $textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 110, 'Lorem Ipsum has been the', $textcolor);
        $textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 130, 'Lorem Ipsum has been the', $textcolor);*/
        imagepng($im);


    }

    /*PHP Run time generated karmora ad*/
    public function generateCashoPaloozaAdImageShare($store_id, $username = NULL)
    {

        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        if ($this->session->userdata('front_data')) {

        }else{
            $detail['user_account_type_id']    = 0;
        }
        $acc_type_id = $detail['user_account_type_id'];
        $this->db->where(array('store_id' => $store_id, 'acc_type_id' =>5));
        $query = $this->db->get('view_stores_list_special_deals')->row();
        //echo "<pre>";
        //print_r($this->db->last_query());
        $store_logo = $this->themeUrl . '/images/' . $query->deal_banner;

        // Or open as a string
        $data = file_get_contents($store_logo);
        $log_info = getimagesizefromstring($data);

        //print_r($log_info);die;
        header("Content-type: image/png");
        $im = imagecreatetruecolor(258, 248);

        $deal_image = $this->themeUrl . '/images/special_deals/cash-o-palooza-ad.jpg';
        $src_img = imagecreatefromjpeg($deal_image);
        if ($log_info['mime'] == 'image/jpeg') {
            $logo_image = imagecreatefromjpeg($store_logo);
        }

        if ($log_info['mime'] == 'image/png') {
            $logo_image = imagecreatefrompng($store_logo);
        }

        if ($log_info['mime'] == 'image/gif') {
            $logo_image = imagecreatefromgif($store_logo);
        }
        $x = (258 - $log_info[0])/2;
        $y = 55;
        if($log_info[1]>45){
            $y = 41;
        }
        //$x = 50;
        imagecopy($im, $src_img, 0, 0, 0, 0, 258, 248);
        imagecopy($im, $logo_image, $x, $y, 0, 0, $log_info[0], $log_info[1]);
        /*$textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 90, 'Lorem Ipsum has been the', $textcolor);
        $textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 110, 'Lorem Ipsum has been the', $textcolor);
        $textcolor = imagecolorallocate($im, 204,50,110);
        imagestring($im, 5, 20, 130, 'Lorem Ipsum has been the', $textcolor);*/
        imagepng($im);


    }
    /*PHP Run time generated karmora ad*/
    public function generateSmokinHotDealAdImage($store_id, $username = NULL)
    {

        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        if ($this->session->userdata('front_data')) {

        }else{
            $detail['user_account_type_id']    = 0;
        }
        $acc_type_id = $detail['user_account_type_id'];
        $this->db->where(array('store_id' => $store_id, 'acc_type_id' => $acc_type_id));
        $query = $this->db->get('view_stores_list_special_deals')->row();

        $store_logo = $this->themeUrl . '/images/' . $query->deal_banner;

        // Or open as a string
        $data = file_get_contents($store_logo);
        $log_info = getimagesizefromstring($data);

        //print_r($log_info);die;
        header("Content-type: image/png");
        $im = imagecreatetruecolor(258, 248);

        $deal_image = $this->themeUrl . '/images/special_deals/smokin_hot_deal_ad.jpg';
        $src_img = imagecreatefromjpeg($deal_image);
        if ($log_info['mime'] == 'image/jpeg') {
            $logo_image = imagecreatefromjpeg($store_logo);
        }

        if ($log_info['mime'] == 'image/png') {
            $logo_image = imagecreatefrompng($store_logo);
        }

        if ($log_info['mime'] == 'image/gif') {
            $logo_image = imagecreatefromgif($store_logo);
        }

        $x = 0;
        if ($log_info[0] < 258) {
            $x = (258 - $log_info[0]) / 2;
        }
        imagecopy($im, $src_img, 0, 0, 0, 0, 258, 248);
        imagecopy($im, $logo_image, $x, 50, 0, 0, $log_info[0], $log_info[1]);
        $textcolor = imagecolorallocate($im, 204,50,110);

        $str1 = substr($query->store_description,0,24);
        imagestring($im, 5, 20, 100, $str1, $textcolor);
        if(strlen($query->store_description)>24){
            $textcolor = imagecolorallocate($im, 204,50,110);
            $str2 = substr($query->store_description,25,24);
            imagestring($im, 5, 20, 120, $str2, $textcolor);
        }
        if(strlen($query->store_description)>48){
            $str3 = substr($query->store_description,49,24);
            $textcolor = imagecolorallocate($im, 204,50,110);
            imagestring($im, 5, 20, 140, $str3, $textcolor);
        }

        imagepng($im);
    }

    public function yahoo_circle()
    {
        $callback = base_url() . "share/yahoo_callback";
        $ret_arr = get_request_token('dj0yJmk9VkVnM2xYeE0wUUs3JmQ9WVdrOU9WQTVlV0ZpTlRZbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1lZQ--', 'f082018a980ab72c08dc8c75193bc541270b9c1c', $callback, false, true, true);
        $data = array();

        if (!empty($ret_arr)) {
            list($info, $headers, $body, $body_parsed) = $ret_arr;
            if ($info['http_code'] == 200 && !empty($body)) {
                $_SESSION['request_token'] = $body_parsed['oauth_token'];
                $_SESSION['request_token_secret'] = $body_parsed['oauth_token_secret'];
                $_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
                $data['list_link'] = '<a href="' . urldecode($body_parsed['xoauth_request_auth_url']) . '" class="circle">
                                        <div class="icon"><div class="image aa"></div></div><div id="icon-title">Yahoo</div></a>';

            }
            return $data['list_link'];
        }
    }

    public function hotmail_circle()
    {


        $hotmail_client_id = '000000004412591F';
        $hotmail_client_secret = 'wnU2QIY5fFliOPxlvNoiEnXGMz81Rz44';
        $hotmail_redirect_uri = 'https://www.karmora.com/share/hotmail_callback'; //'http://iteyesolutions.com/hotmail/oauth-hotmail.php';
        $urls_ = 'https://login.live.com/oauth20_authorize.srf?client_id=' . $hotmail_client_id . '&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri=' . $hotmail_redirect_uri;
                
        $data['msn_link'] = '<a href="' . $urls_ . '" class="circle"><div class="icon"><div class="image bb"></div></div><div id="icon-title">MSN</div></a>';

        return $data['msn_link'];
    }

    public function gmail_circle()
    {
        $callback_url = 'https://accounts.google.com/o/oauth2/auth?client_id=547205366887-d87j8aho511g29q9g45kbpf63kas5jg9.apps.googleusercontent.com&redirect_uri=https://www.karmora.com/share/gmail_callback&scope=https://www.google.com/m8/feeds/&response_type=code';
        $data['gmail_link'] = '<a href="' . $callback_url . '" class="circle"><div class="icon"><div class="image ff"></div></div><div id="icon-title">Gmail</div></a>';
        return $data['gmail_link'];
    }

    public function yahoo_callback($username = NULL)
    {
        ob_start();
        $request_token = $_SESSION['request_token'];
        $request_token_secret = $_SESSION['request_token_secret'];
        $oauth_verifier = $_GET['oauth_verifier'];
        $userId = $this->session->userdata['front_data']['id'];
        // Get the access token using HTTP GET and HMAC-SHA1 signature
        $retarr = get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $request_token, $request_token_secret, $oauth_verifier, false, true, true);
        if (!empty($retarr)) {
            list($info, $headers, $body, $body_parsed) = $retarr;
            if ($info['http_code'] == 200 && !empty($body)) {
                $guid = $body_parsed['xoauth_yahoo_guid'];
                $access_token = rfc3986_decode($body_parsed['oauth_token']);
                $access_token_secret = $body_parsed['oauth_token_secret'];
                // Call Contact API
                $retarrs = callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $guid, $access_token, $access_token_secret, false, true);
                $rzlt = explode(',', $retarrs);
                foreach ($rzlt as $savedD) {
                    if (filter_var($savedD, FILTER_VALIDATE_EMAIL)) {
                        if ($savedD != '') {
                            // for alredy contact check
                            $contact_list = $this->sharemodel->get_alredy_contact($userId, $savedD);
                            if (empty($contact_list)) {
                                $datas = array(
                                    'email' => $savedD,
                                    'sender_id' => $userId,
                                    'email_type' => 'yahoo'
                                );
                                $this->db->insert('tbl_email_contacts', $datas);
                            }
                        }
                    }
                }

                $this->session->set_flashdata('alert_invited_msg', '<div class="alert alert-success" role="alert">All your Yahoo friends have been invited.</div>');
                redirect(base_url($username . '/share/good-karmora-emails'));
                die;
                //$this->index(); die;
                //print_r($retarrs->contacts); die;
            }
        }
        ob_flush();
    }

    public function curl_file_get_contents($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function hotmail_callback()
    {
        ob_start();
        $hotmail_client_id = '000000004412591F';
        $hotmail_client_secret = 'wnU2QIY5fFliOPxlvNoiEnXGMz81Rz44';
        $hotmail_redirect_uri = 'https://www.karmora.com/share/hotmail_callback';
        $auth_code = $this->input->get('code', TRUE);
        

        $fields = array(
            'code' => urlencode($auth_code),
            'client_id' => urlencode($hotmail_client_id),
            'client_secret' => urlencode($hotmail_client_secret),
            'redirect_uri' => urlencode($hotmail_redirect_uri),
            'grant_type' => urlencode('authorization_code')
        );
        $post = '';
        foreach ($fields as $key => $value) {
            $post .= $key . '=' . $value . '&';
        }
        $post = rtrim($post, '&');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://login.live.com/oauth20_token.srf');
        curl_setopt($curl, CURLOPT_POST, 5);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($result);

        $accesstoken = $response->access_token;
        $url = 'https://apis.live.net/v5.0/me/contacts?access_token=' . $accesstoken . '&limit=100';
        $xmlresponse = $this->curl_file_get_contents($url);
        $xml = json_decode($xmlresponse, true);
        $msn_email = "";
        $emailAdd = array();
        $count = 0;
        foreach ($xml['data'] as $emails) {
            if ($emails['emails']['preferred'] != "") {
                $emailAdd[$count]['email'] = $emails['emails']['preferred'];
                $count++;
            } elseif ($emails['emails']['account'] != "") {
                $emailAdd[$count]['email'] = $emails['emails']['account'];
                $count++;
            } elseif ($emails['emails']['personal'] != "") {
                $emailAdd[$count]['email'] = $emails['emails']['personal'];
                $count++;
            } elseif ($emails['emails']['business'] != "") {
                $emailAdd[$count]['email'] = $emails['emails']['business'];
                $count++;
            } elseif ($emails['emails']['other'] != "") {
                $emailAdd[$count]['email'] = $emails['emails']['other'];
                $count++;
            }
            // echo $emails['name'];
            //$email_ids = implode(",",array_unique($emails['emails'])); //will get more email primary,sec etc with comma separate
            //$msn_email .= "<div><span>".$emails['name']."</span> &nbsp;&nbsp;&nbsp;<span>". rtrim($email_ids,",")."</span></div>";
        }
        $userId = $this->session->userdata['front_data']['id'];
        foreach ($emailAdd as $title) {
            if (filter_var($title['email'], FILTER_VALIDATE_EMAIL)) {
                if ($title['email'] != '') {
                    // for alredy contact check
                    $contact_list = $this->sharemodel->get_alredy_contact($userId, $title['email']);
                    if (empty($contact_list)) {
                        $datas = array(
                            'email' => $title['email'],
                            'sender_id' => $userId,
                            'email_type' => 'hotmail'
                        );
                        $this->db->insert('tbl_email_contacts', $datas);
                    }
                }
            }
        }

        //echo "<pre>";
        //print_r($emailAdd);
        $this->session->set_flashdata('alert_invited_msg', '<div class="alert alert-success" role="alert">All your Hotmail friends have been invited.</div>');
        $url = base_url() . $this->session->userdata['front_data']['username'];
        redirect($url . '/share/good-karmora-emails');

        die;
        ob_flush();
    }

    public function curl_file_gmail_contents($url)
    {

        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

        curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.

        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //To stop cURL from verifying the peer's certificate.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

    public function gmail_callback()
    {
        ob_start();

        $client_id = '547205366887-d87j8aho511g29q9g45kbpf63kas5jg9.apps.googleusercontent.com';
        $client_secret = '_YAITqhqySMhs5vGmW2Gts-j';
        $redirect_uri = base_url() . 'share/gmail_callback';
        $max_results = 25;
        //$auth_code = $_GET["code"];
        $auth_code = $this->input->get('code', TRUE);

        $fields = array(
            'code' => urlencode($auth_code),
            'client_id' => urlencode($client_id),
            'client_secret' => urlencode($client_secret),
            'redirect_uri' => urlencode($redirect_uri),
            'grant_type' => urlencode('authorization_code')
        );
        $post = '';
        foreach ($fields as $key => $value) {
            $post .= $key . '=' . $value . '&';
        }

        $post = rtrim($post, '&');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, 5);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($result);
        $accesstoken = $response->access_token;

        $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&oauth_token=' . $accesstoken;
        $xmlresponse = $this->curl_file_gmail_contents($url);
        if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) {
            echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
            exit();
        }
        //echo "<h3>Email Addresses:</h3>";
        $xml = new SimpleXMLElement($xmlresponse);

        $xml->registerXPathNamespace('gd', 'https://schemas.google.com/g/2005');

        $result = $xml->xpath('//gd:email');
        //echo '<pre>';            print_r($result); die;
            
        //echo '<pre>'; var_dump($array); die;
        $userId = $this->session->userdata['front_data']['id'];
        foreach ($result as $title) {
            $email = json_decode(json_encode($title->attributes()->address), 1);
            if (filter_var($email[0], FILTER_VALIDATE_EMAIL)) {
                if ($email[0] != '') {
                    // for alredy contact check
                    $contact_list = $this->sharemodel->get_alredy_contact($userId, $email[0]);
                    if (empty($contact_list)) {
                        $datas = array(
                            'email' => $email[0],
                            'sender_id' => $userId,
                            'email_type' => 'gmail'
                        );
                        $this->db->insert('tbl_email_contacts', $datas);
                    }
                }
            }
        }
        $this->session->set_flashdata('alert_invited_msg', '<div class="alert alert-success" role="alert">All your Gmail friends have been invited.</div>');
        $url = base_url() . $this->session->userdata['front_data']['username'];
        redirect($url . '/share/good-karmora-emails');
        die;
        ob_flush();
    }

    public function check_email($email, $senderId)
    {


        $invitedUser = $this->checkInvitedUser($email, $senderId);
        return $invitedUser;
    }

//    public function automated_email($frequency = NULL, $username = NULL){
//        //echo 123; die;
//        $userId = $this->session->userdata['front_data']['id'];
//        $user_data = $this->commonmodel->getUserDetails($username);
//        
//        $email_data = $this->commonmodel->getemailInfo(7);
//        $complete_name  = $user_data->user_first_name.' '.$user_data->user_last_name;
//        $link           = base_url(); 
//        $user_link     = '<a href="'.$link.'">Clicking Here</a>';
//        $tags           = array("{Nameofreferral}", "{urllink}", "{url}", "{First-Name}");
//        $replace        = array(' ', $user_link,$link,$complete_name);
//        $subject = $email_data->email_title;
//        $message = $this->prepShareEmailContent($tags, $replace, $subject, $email_data->email_description); //
//        $next_date = date('Y-m-d', strtotime("+$frequency days"));
//        $datas = array(
//            'email_user_id' => $userId,
//            'email_subject' => $subject,
//            'email_body' => $message,
//            'email_frequency' => $frequency,
//            'email_last_run_time' => date('Y-m-d'),
//            'email_next_run_time' => $next_date
//        );
//        $this->db->insert('tbl_email_automated', $datas);
//        die;
//        //echo $this->db->last_query(); die;
//    }

    public function automated_email_delete($username = NULL)
    {
        $userId = $this->session->userdata['front_data']['id'];
        $where = array('email_user_id ' => $userId);
        $this->db->where($where);
        $this->db->delete('tbl_email_automated');
        redirect(base_url('share'));
    }

    public function preview($username = NULL, $campaignId = NULL){
            $this->verifyUser($username); //die;
            $detail = $this->currentUser;

            $userData = $this->commonmodel->getuserdetail($detail['userid']);
            $email_data = $this->commonmodel->getemailInfo(7);
            $complete_name  = $userData->user_first_name.' '.$userData->user_last_name;
            $link           = base_url(); 
            $user_link     = '<a href="'.$link.'">Clicking Here</a>';
            $tags           = array("{Nameofreferral}", "{urllink}", "{url}", "{First-Name}");
            $replace        = array(' ', $user_link,$link,$complete_name);
            $subject = $email_data->email_title;
            echo $message = $this->prepEmailContent_without_top($tags, $replace, $subject, $email_data->email_description, $detail['userid'],$email_data->email_header_text);
            die;
        

    }
    
    public function shareadd($type, $username = NULL){
        $this->verifyUser($username); //die;
        $this->db->where('banner_ads_status', 1);
	    if($type == "supplements"){
		    $this->data["main_heading"] = "B3 Supplement Ads";
		    $cat_ids = array('119','120','121','122','123');
	    }else{
		    $this->data["main_heading"] = "Flawless Skincare Ads";
		    $cat_ids = array('127','128','129','130','131');
	    }
        $this->db->where_in('banner_cat_id', $cat_ids);
        $this->db->order_by('pk_banner_ads_id', 'asc');
        $query = $this->db->get('tbl_banner_ads');
	    
        $this->data['custom_ads'] = array();
	    if ( count( $query->result() ) > 0 ) {
		    $this->data['custom_ads'] = $query->result();
	    }
	    
        $this->loadLayout($this->data, 'frontend/share/exclusive_product_ads_detail');
}
    
//    public function sendsharemail($id,$friend_email_address,$friends_name=NULL) {
//        //$checkCommunityEmail = $this->commonmodel->checkEmailType($id, 1);
//        //if ($checkCommunityEmail) {
//            if($friends_name == NULL){
//                $friends_name = ' ';
//            }
//            $userData = $this->commonmodel->getuserdetail($id);
//            $email_data = $this->commonmodel->getemailInfo(7);
//            $complete_name  = $userData->user_first_name.' '.$userData->user_last_name;
//            $link           = base_url(); 
//            $user_link     = '<a href="'.$link.'">Clicking Here</a>';
//            $tags           = array("{Nameofreferral}", "{urllink}", "{url}", "{First-Name}");
//            $replace        = array($friends_name, $user_link,$link,$complete_name);
//            $subject = $email_data->email_title;
//            $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $id,$email_data->email_header_text);
//            $to      = $friend_email_address;
//            $result  = $this->send_mail($to, $subject, $message); 
//            return $result;
//        //}
//    }
}



/* Location: ./application/controllers/share.php */
