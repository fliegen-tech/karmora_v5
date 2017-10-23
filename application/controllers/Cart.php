<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends karmora {


    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('cartmodel','commonmodel' , 'productmodel'));
    }

    public function product_cart($username = NULL) {
            $this->verifyUser($username);
            $response = array(
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash(),
                'html'     => false
            );
            if($this->cartmodel->validate_add_cart_item() == TRUE){
                // Check if user has javascript enabled
                if($this->input->post('ajax') != '1'){
                    redirect(base_url().'cart/show_cart');// If javascript is not enabled, reload the page with new data
                }else{
                    $response['html'] =  'true';
                    // If javascript is enabled, return true, so the cart gets updated
                }
            }
            echo json_encode($response); die;
        //echo '<pre>';            print_r($_POST); die;
    }
    public function deal_cart($username = NULL) {
            $this->verifyUser($username);
            if($this->cartmodel->validate_add_cart_item() == TRUE){
                // Check if user has javascript enabled
                if($this->input->post('ajax') != '1'){
                    redirect(base_url().'cart/show_cart');// If javascript is not enabled, reload the page with new data
                }else{
                    echo 'true'; die; // If javascript is enabled, return true, so the cart gets updated
                }
            }
            //echo '<pre>';            print_r($_POST); die;
    }
    function show_cart($username = NULL){
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['cate_array'] = array();
        $this->loadLayout($this->data,'frontend/cart/product_cart');
    }
    function cart_message($username = NULL){
        $this->verifyUser($username);
        $this->load->view('frontend/cart/cart_sucess_message');
    }
    // Updated the shopping cart

    function update_cart($username = NULL){
        $this->cartmodel->validate_update_cart();
        $this->verifyUser($username);
        redirect(base_url().'cart/show_cart');
    }
    function empty_cart($username = NULL){
        $this->verifyUser($username);
        $this->cart->destroy(); // Destroy all cart data
        redirect(base_url().'cart/show_cart');
    }
    function remove($rowid,$username = NULL){
       //$this->verifyUser($username);
       $data = array();
       foreach($this->cart->contents() as $items){
           if($items['rowid'] != $rowid){
               $data[] = array('id' => $items['id'],
                               'qty' => $items['qty'],
                               'price' => $items['price'],
                               'name' => $items['name'],
                               'shopper_account_type'   => $items['shopper_account_type'],
                               'shopper_account_type_price'     => $items['shopper_account_type_price'],
                               'shopper_recurning_time' =>$items['shopper_recurning_time'],
                               'pic'      => $items['pic'],                
                    );
           }
       }

       $this->cart->destroy();
       $this->cart->insert($data);
       redirect(base_url().'cart/show_cart');
} 
    

  
    
   
}

/* Location: ./application/controllers/product.php */