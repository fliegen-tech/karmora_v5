<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class karmora_cash_back extends karmora {


    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('homemodel','commonmodel' ,'storemodel'));
    }

    public function index($username = NULL) {
            $this->verifyUser($username); //die;
            $detail = $this->currentUser;
            $this->data['sliders']           = $this->getslider($detail['user_account_type_id'],  '/karmora-cash-back');
            $this->data['categories']        = $this->GetCategories($detail['user_account_type_id']);
            $categories_top_stores = $this->homemodel->getTopCategoryStores($detail['user_account_type_id']);
            //echo ' - categories loaded';exit;
            if (empty($categories_top_stores)) {
                $this->data['top_stores'] = false;
            } else {
                $this->data['top_stores'] = $this->sortStoreByCategory($categories_top_stores);
            }
            $this->data['cash_o_palooza']      = $this->storemodel->getSpecialStores($detail['user_account_type_id'], 'cash_o_palooza');
            $this->data['smokin_hot_deals']    = $this->storemodel->getSpecialStores($detail['user_account_type_id'], 'smokin_hot_deals');
            $this->loadLayout($this->data,'frontend/karmora_cash_back/content');
            
    }
    public function getslider($fk_user_account_type_id, $location){
        
        $sliders = $this->homemodel->getACSliders($fk_user_account_type_id, $location);

        $first = true;
        if(!empty($sliders)){
        foreach ($sliders as $slide) {
            if ($first === true) {
                reset($sliders);
                $first = false;
            }

            if ($sliders[key($sliders)]['use_sid'] === 'Yes' && $sliders[key($sliders)]['affiliate_network_id'] !== '0') {
                $sliders[key($sliders)]['url'] = $this->prepURL($slide['affiliate_network_id'], $slide['url']);
            }
            next($sliders);
        }
      }
        
        return $sliders;
    }
    public function manageBannerDetail($detail){
      $user_banner_array = array(); 
      $user_banner_array['username']               = $detail['username'];
      $user_banner_array['userid']                 = $detail['userid'];
      $user_banner_array['user_account_type']      = $detail['user_account_type_title'];
      $user_banner_loc   = $this->commonmodel->getuser_location($detail['userid']);
      $user_banner_image = $this->homemodel->checkimage($detail['userid']);
      if(!empty($user_banner_loc)){
        $user_banner_array['member_location']  = $user_banner_loc->_member_location;
      }else{
        $user_banner_array['member_location']  = 'Scottsdale, Az';  
      }
      if(!empty($user_banner_image)){
        $user_banner_array['profile_pic']      = $user_banner_image->profile_pic;
      }
      return $user_banner_array;
    }
    public function scribeUser(){
      $email = $_POST['email'];
      $error = 0 ;
      //email null check
      if($email=='' || $email=='Type Your Email Here'){
          echo 'Please Enter Email';
          $error=1 ;
          die;
      }
      //valid email check
      if($email!=''){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
              echo 'Please Enter Valid Email';
              $error=1;
              die;
        }
      }
      
      if($error==0){
        $ScAr  = $this->homemodel->getScirber($email);
          if(!empty($ScAr) && $ScAr!=''){
            echo 'You Have Already Scribed This Site';
            die;
          }else{
            
            $datas = array(
                    'subscriber_email'                  => $email,
                    'subscriber_status'                 => 1,
                    'subscriber_creation_date_time'     => date("Y-m-d H:i:s"),
                    'subscriber_last_updated_date_time' => date("Y-m-d H:i:s")
                 );
            $this->db->insert('tbl_subscribers', $datas);
              echo 2;
              die;
            }
          }
       }
    public function sortStoreByCategory($storesArray) {
        $sortedStoreArray = array();
        foreach ($storesArray as $store) {
            if (!isset($sortedStoreArray[$store['category_alias']])) {
                $sortedStoreArray[$store['category_alias']] = array();
            }

            array_push($sortedStoreArray[$store['category_alias']], $store);
        }

        return $sortedStoreArray;
    }
    
    public function getajaxtripplestore($store_id,$username = NULL){
        
        $this->verifyUser($username); //die;
        $detail = $this->currentUser;
        $html = '';
        $tripple_karmora = $this->homemodel->gettripplekarmoracash_ajax($detail['user_account_type_id'], '' , 0);
        $count = 0;
        $myalltotal = $tripple_karmora;
        if(isset($_SESSION['tripple_karmora'])){
            $tripple_karmora = $_SESSION['tripple_karmora'];
        }
        foreach ($tripple_karmora as $slide=>$value) { 
            if ($store_id ==  $value['store_id']){
                unset($tripple_karmora[$slide]);
                    $_SESSION['tripple_karmora'] = $tripple_karmora;
                }else{
                    $_SESSION['tripple_karmora'] = $tripple_karmora;
                }
        }
        
        if(count($_SESSION['tripple_karmora']) < 2){
            $_SESSION['tripple_karmora'] = $myalltotal;
        }
        foreach ($_SESSION['tripple_karmora'] as $slide) { $count++;
        if($count<=5){
                        $image = $this->themeUrl.'/images/'.$slide['triple_karmora_kash_image'];
                        if ($this->session->userdata('front_data')) {
                        $link = base_url().'/store-visit/'.$slide['store_id'];
                        }else{
                        $link = base_url().'/store-detail/'.$slide['store_id'];
                            
                        }
                        $pass_varibale =  $slide['store_id'];
                        $id = 'hide_id_'.$slide['store_id'];
                        $onclick = 'onclick="shownext('.$pass_varibale.')" class="banner-close-btn"> <i class="fa fa-times"></i> </a>';
                                $html.="<li id=".$id." <div class='slide'>
                                        <a href='$link' target='_blank'>
                                            <img src='$image'>
                                        </a>
                                        <a href='javascript:void(0)' $onclick
                                        </div></li>";
        } }
        echo $html ;  die;
            
    }
}

/* Location: ./application/controllers/welcome.php */