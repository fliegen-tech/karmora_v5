<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class KarmoraCashBack extends karmora {


    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('homemodel','commonmodel' ,'storemodel'));
    }

    public function index($username = NULL) {
            $this->verifyUser($username); //die;
            $detail = $this->currentUser;
            $detail = reset($detail);
            $this->data['sliders']           = $this->getslider($detail['user_account_type_id']);
            $this->data['categories']        = $this->storemodel->getATCategory($detail['user_account_type_id']);
            $categories_top_stores           = $this->homemodel->getTopCategoryStores($detail['user_account_type_id']);
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
    public function getslider($fk_user_account_type_id){
        $sliders = $this->homemodel->getACSliders($fk_user_account_type_id);
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

}

/* Location: ./application/controllers/welcome.php */