<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tresurechest extends karmora {

    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('commonmodel', 'tresurechestmodel'));
    }
    public function index($username=NULL) {
		
        $this->verifyUser($username);
        /// Win Cold Hard Cash
        $Win_Cold_Hard_Cash = 1;
        $this->data['Win_Cold_Hard_Cash'] = $this->tresurechestmodel->getTresures($Win_Cold_Hard_Cash);
        
        /// Win Gift Cards
        $Win_Gift_Cards = 2;
        $this->data['Win_Gift_Cards'] = $this->tresurechestmodel->getTresures($Win_Gift_Cards);
        
        /// Win Exclusive Products
        $Win_Exclusive_Products = 3;
        $this->data['Win_Exclusive_Products'] = $this->tresurechestmodel->getTresures($Win_Exclusive_Products);
        
        /// Win Exclusive Products
        $Win_karmora_cash = 4;
        $this->data['Win_karmora_cash'] = $this->tresurechestmodel->getTresures($Win_karmora_cash);
        
        $winnerArray = $this->tresurechestmodel->getWinner();
        $this->data['winner'] = $winnerArray;
        $this->data['product_id']    =  54; //for karmora clickto win reviews set 53 product
        $this->data['product_desc_review']       =  'About Click2Win'; //for karmora Home Page reviews set First product
        $this->loadLayout($this->data,'frontend/tresurechest/content');
    }

}