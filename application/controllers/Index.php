<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends karmora{

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('homemodel','commonmodel'));
    }

	public function index($username = NULL){
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['sliders'] = $this->getslider($detail['user_account_type_id']);
        if ($this->session->userdata('front_data')) {
            $this->loadLayout($this->data, 'frontend/home/login_home_page');
        } else {
            $this->loadLayout($this->data, 'frontend/home/notlogin_home_page');
        }
	}
    public function getslider($fk_user_account_type_id){
        $sliders = $this->homemodel->getACSliders($fk_user_account_type_id);
        $first = true;
        if (!empty($sliders)) {
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
}
