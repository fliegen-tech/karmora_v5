<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product extends karmora {

    public $data = array();
    public $upgrade_amount = '';

    public function __construct() {

        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->upgrade_amount  =  9.95;
        $this->load->model(array('productmodel','commonmodel'));
        $this->load->library('form_validation');
    }

    public function index() {
            redirect(base_url());
    }

    public function product_detail($pk_product_id, $username = NULL) {
        $this->verifyUser($username);
        $this->data['detail'] = $this->currentUser;
        $this->data['upgrade_amount'] =  $this->upgrade_amount;
        if(is_array($this->data['detail'][0])){
            $this->data['detail'] = reset($this->data['detail']);
        }
        $this->data['product_detail'] = $this->productmodel->getproductdetail_withAccountType($pk_product_id);
        if (empty($this->data['product_detail'])) {
            redirect(base_url());
        }
        $this->data['product_price_cart_casual']  = $this->productmodel->getproduct_price_account_type($pk_product_id, 3);
        $this->data['product_price_cart_premier'] = $this->productmodel->getproduct_price_account_type($pk_product_id, 5);
        $this->data['product_album'] = $this->productmodel->getproductAlbum($pk_product_id);
        $this->data['perfect_paring'] = $this->productparing($pk_product_id);
	    $this->data['modals'][] = 'supplements-popup';
	    $this->data['popup_image'] = $pk_product_id;
        $this->data['atttocart'] = $this->disableaddtocart($pk_product_id);
        $this->loadLayout($this->data, 'frontend/product/product_detail');
    }

    public function flawless_product($username = NULL) {

        $this->verifyUser($username);
        $this->data['products'] = $this->productmodel->getproductsBycat(99,100);
        $this->loadLayout($this->data, 'frontend/product/flawless_listing');
    }

    public function supplements($username = NULL) {
        $this->verifyUser($username);
        $this->data['products'] = $this->productmodel->getproductsBycat(114,100);
        $this->loadLayout($this->data, 'frontend/product/supplement_listing');
    }


    public function weightLossIndex($username = NULL) {

        $data = array();
        $this->verifyUser($username);

        $this->loadLayout($data, 'frontend/product/weight_loss_index');
    }

    public function weightLossCalculation($username = NULL) {
        $this->verifyUser($username);
        if (isset($_POST)) {
            if ($this->wlcFormValidate()) {
                $return_data = $this->wlcCalculation();
                $this->session->set_userdata('loose_weight', $return_data);
            }
            echo json_encode($return_data); die;
        }
    }
    
    public function weightLossContinue($username = NULL){
        $data = array();
        $this->verifyUser($username);
        if($this->session->userdata('loose_weight')){
            $data['loose_weight'] = $this->session->userdata('loose_weight');
            $this->session->unset_userdata('loose_weight');
        }
        $this->loadLayout($data, 'frontend/product/weight_loss_continue');
    }

    public function weightLossTips($username = NULL){
        $data = array();
        $this->verifyUser($username);
        if($this->session->userdata('loose_weight')){
            $data['loose_weight'] = $this->session->userdata('loose_weight');
            $this->loadLayout($data, 'frontend/product/weight_loss_tips');
        }else{
            redirect(base_url('weight-loss'));
        } 
    }

    private function wlcFormValidate() {
        return TRUE;
    }

    private function wlcCalculation() {
        $post = $this->input->post();
//        $valArr = array(
//            'measurment' => $post['measurment'],
//            'gender' => $post['gender'],
//            'weight' => $post['weight'],
//            'height' => $post['measurment'] == 1 ? 0 : $post['height'],
//            'height_ft' => $post['measurment'] == 1 ? $post['height_ft'] : 0,
//            'height_in' => $post['measurment'] == 1 ? $post['height_in'] : 0,
//            'age' => $post['age'],
//            'activity' => $post['activity']
//        );
        return $this->calculateBMRandTDEE($post);
    }

    private function calculateBMRandTDEE($parms) {
        //gender male = 1, female = 0
        //measurment decimal = 1, metric = 0
        //
        $deci = 2;
        $weight = $parms['measurment'] ? number_format($parms['weight'] * 0.45, $deci) : number_format($parms['weight'], $deci);
        $height = $parms['measurment'] ? number_format((($parms['height_ft'] * 12) + $parms['height_in']) * 2.54, $deci) : number_format($parms['height'], $deci);
        
//        var_dump('weight:',$weight, 'height:',$height);exit;

        $activityFactor = array(1.2, 1.375, 1.55, 1.725, 1.99);

//        Women BMR = 655 + (9.6 X weight in kg) + (1.8 x height in cm) – (4.7 x age in yrs)
//        Men BMR = 66 + (13.7 X weight in kg) + (5 x height in cm) – (6.8 x age in yrs)
        
        $weightFactor = $parms['gender'] ? 13.7 : 9.6;
        $heightFactor = $parms['gender'] ? 5 : 1.8 ;
        $ageFactor = $parms['gender'] ? 6.8 : 4.7 ;
        $someFactor = $parms['gender'] ? 66 : 655 ;

        $response['bmr'] = ceil($someFactor + ($weightFactor * $weight) + ($heightFactor * $height) - ($ageFactor * $parms['age']));        
        $response['tdee'] = ceil($response['bmr'] * $activityFactor[$parms['activity']]);
        $response['loose_weight'] = $this->calculateLooseWeight($response);
        return $response;
    }

    private function calculateLooseWeight($param) {
        $post = $this->input->post();
        $weightFactor = 3500;
        $deci = 2;

        $targetWeightLoss = $post['measurment'] ? number_format($post['weight_loss_target'], $deci) : number_format($post['weight_loss_target'] * 2.2047, $deci) ;
        $minCalReq = $post['gender'] ? 1000 : 1000;

        $startDate = $this->dateFunction($post['date_start']);
        $finishDate = $this->dateFunction($post['date_finish']);
        $targettime = abs(strtotime($finishDate) - strtotime($startDate));
//        $years = floor($targettime / (365*60*60*24));
//        $months = floor(($targettime - ($years * 365*60*60*24)) / (30*60*60*24));
//        $targetDays = floor(($targettime - ($years * 365*60*60*24) - ($months*30*60*60*24))/ (60*60*24));
        $targetDays = floor(($targettime)/ (60*60*24));
        
//        var_dump($targettime, $years, $months, $targetDays);
//        exit;
        $targetCals = ceil($param['tdee'] - (($targetWeightLoss * $weightFactor) / $targetDays));
        $looseWeight = array(
            'a_pound_a_week' => $minCalReq < $param['tdee'] - 500 ? $param['tdee'] - 500 .' <span>calories</span>' : '<span>Impractical results </span>',            
            'two_pound_a_week' => $minCalReq < $param['tdee'] - 1000 ? $param['tdee'] - 1000 . ' <span>calories</span>'  : '<span>Impractical results </span>',
            'weight_loss_goal' => $minCalReq < $targetCals ? $targetCals .' <span>calories</span>': '<span>Impractical results </span>',
            'practical' => $minCalReq < $targetCals ? TRUE : FALSE,
            'target_days' => $targetDays,
            'target_weight' => $targetWeightLoss
        );
        
        return $looseWeight;
    }

    private function dateFunction($date) {
        $dateSep = '-';
        $findSep = '/';
        $dateChange = str_replace($dateSep, $findSep, $date);
        $newDate = date('d-m-Y', strtotime($dateChange));
        return $newDate;
    }
    private function productparing($product_id){
        $product_array = array(
            56 => array(
                "B3 Trim" => $this->productmodel->getproductdetail_withAccountType(58),
                "B3 Healthy" => $this->productmodel->getproductdetail_withAccountType(55)
            ),
            58 => array(
                "B3 Slim" => $this->productmodel->getproductdetail_withAccountType(56),
                "B3 Healthy" => $this->productmodel->getproductdetail_withAccountType(55)
            ),
            55 => array(
                "B3 Trim" => $this->productmodel->getproductdetail_withAccountType(58),
                "B3 Slim" => $this->productmodel->getproductdetail_withAccountType(56)
            ),
            57 => array(
                "B3 Trim" => $this->productmodel->getproductdetail_withAccountType(58),
                "B3 Slim" => $this->productmodel->getproductdetail_withAccountType(56)
            ),
            4 => array(
                "Simply Flawless" => $this->productmodel->getproductdetail_withAccountType(7),
                "Flawless Nights" => $this->productmodel->getproductdetail_withAccountType(6)
            ),
            6 => array(
                "Simply Flawless" => $this->productmodel->getproductdetail_withAccountType(7),
                "Flawless Days" => $this->productmodel->getproductdetail_withAccountType(4)
            ),
            7 => array(
                "Flawless Days" => $this->productmodel->getproductdetail_withAccountType(4),
                "Flawless Mist" => $this->productmodel->getproductdetail_withAccountType(8)
            ),
            8 => array(
                "Flawless Nights" => $this->productmodel->getproductdetail_withAccountType(6),
                "Simply Flawless" => $this->productmodel->getproductdetail_withAccountType(7)
            )
        );
        return $product_array[$product_id];
    }

    /**
     * @return string
     */
    public function disableaddtocart($product_id){
        if(!empty($this->cart->contents())) {
            foreach ($this->cart->contents() as $cart_d) {
                if ($cart_d['id'] == $product_id && !isset($this->session->userdata['front_data'])) {
                    return true;
                }
            }
        }else{
            return false;
        }
    }

}

/* Location: ./application/controllers/product.php */