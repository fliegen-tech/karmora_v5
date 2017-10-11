<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends karmora{

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        //$this->load->model(array('homemodel','storemodel','commonmodel'));
    }

	public function index(){
        if ($this->session->userdata('front_data')) {
            $this->loadLayout($this->data, 'frontend/home/login_home_page');
        } else {
            $this->loadLayout($this->data, 'frontend/home/notlogin_home_page');
        }
	}
}
