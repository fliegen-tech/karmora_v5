<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mycharities extends karmora {

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->checklogin();
        $this->load->model(array('commonmodel','mycharitiesmodel','usermodel','homemodel'));
        $this->load->library('form_validation');
    }

    public function index($username = NULL) {
        $this->verifyUser($username); //die;
        $detail= $this->currentUser;
        if(isset($_POST['saveraise'])){
            $this->data['msg'] = $this->savedata();
        }
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($detail['userid']);
        $this->data['active_page'] = 'charities';
        $this->data['allstate'] = $this->homemodel->getstate(1);
        $this->data['myContribution'] = isset($detail['userid']) ? $this->mycharitiesmodel->getMyContribution($detail['userid']) : FALSE;
        $this->data['totalContribution'] = $this->mycharitiesmodel->getTotalContribution();
        
        $this->loadLayout($this->data,'frontend/dashboard/mycharities');
        
    }
    public function savedata() {
        $detail= $this->currentUser;
        $this->form_validation->set_rules('charity_name', 'Organzation Name', 'required');
        $this->form_validation->set_rules('charity_email_adrress', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('charity_street_address', 'Street Address', 'required');
        $this->form_validation->set_rules('fk_state_id', 'State', 'required');
        $this->form_validation->set_rules('charity_first_name', 'First Name', 'required');
        $this->form_validation->set_rules('charity_zip_code', 'Zip Code', 'required');
        $this->form_validation->set_rules('charity_socail_link', 'Socail Address', 'required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() === FALSE) {
            print_r(validation_errors());die;
        } else {
            $user_id = $this->session->userdata['front_data']['id'];
            $charity_name        = $this->input->post('charity_name');
            $charity_street_address        = $this->input->post('charity_street_address');
            $charity_street_address_2        = $this->input->post('charity_street_address_2');
            $charity_city_name        = $this->input->post('charity_city_name');
            $fk_state_id        = $this->input->post('fk_state_id');
            $charity_zip_code        = $this->input->post('charity_zip_code');
            $charity_first_name        = $this->input->post('charity_first_name');
            $charity_last_name        = $this->input->post('charity_last_name');
            $charity_phone_no        = $this->input->post('charity_phone_no');
            $charity_email_adrress        = $this->input->post('charity_email_adrress');
            $charity_socail_link        = $this->input->post('charity_socail_link');
            
            $dataLogI = array(
                    'fk_user_id' => $user_id,
                    'fk_state_id' => $fk_state_id,
                    'charity_zip_code' => $charity_zip_code,
                    'charity_street_address' => $charity_street_address,
                    'charity_street_address_2' => $charity_street_address_2,
                    'charity_city_name' => $charity_city_name,
                    'charity_name' => $charity_name,
                    'charity_first_name' => $charity_first_name,
                    'charity_last_name' => $charity_last_name,
                    'charity_phone_no' => $charity_phone_no,
                    'charity_email_adrress' => $charity_email_adrress,
                    'charity_socail_link' => $charity_socail_link,
                    'charity_status' => 'Inactive',
                    'charity_creation_time' => date("Y-m-d")
                );
                
            $this->db->insert('tbl_charity', $dataLogI);
            //$this->sendchairtymail($detail['userid']);
            return 'Charity Created Sucefully';
        
        }
    }
    
    function sendchairtymail($id) {
            $detail     = '';
            $statedata   = $this->commonmodel->getstatename($_POST['fk_state_id']);
            $userData   = $this->commonmodel->getuserdetail($id);
            $email_data = $this->commonmodel->getemailInfo(14);
            $complete_name  = $userData->user_first_name.' '.$userData->user_last_name;
            $address =  $_POST['charity_street_address'] .' '.$_POST['charity_city_name'].' '.$statedata->user_address_state_title .''.$_POST['charity_zip_code'];
            // $detail.= '<table><tr><th>Charity Name</th><th>Address</th><th>Full Name</th><th>Phone No</th><th>Email Address</th><th>Socail Link</th></tr>'; 
            $detail.= '<table align="center" border="1" cellspacing="0" cellpadding="10" style="text-align: left; border="1px solid #333333;"><tr><td><b>Charity Name</b></td><td>"'.$_POST['charity_name'].'"</td></tr><tr><td><b>Address</b></td><td>"'.$address.' "</td></tr><tr><td><b>Full Name</b></td><td>"'.$_POST['charity_first_name'].' '.$_POST['charity_last_name'].'"</td></tr><tr><td><b>Phone No.</b></td><td>"'.$_POST['charity_phone_no'].'"</td></tr><tr><td><b>Email Address</b></td><td>"'.$_POST['charity_email_adrress'].'"</td></tr><tr><td><b>Social Link</b></td><td>"'.$_POST['charity_socail_link'].'"</td></tr></table>';
            $tags           = array("{First-Name}", "{Name-of-FO}" ,"{charirty-detail}" ,"{fundrasing-program}");
            $replace        = array($complete_name, $_POST['charity_name'],$detail,'<a href ="https://www.karmora.com/liveSupport/">Click here </a>');
            $subject = $email_data->email_title;
            $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, $id,$email_data->email_header_text);
            $to = $userData->user_email;
            $result = $this->send_mail($to, $subject, $message); 
            return $result;
    }
    
    
}
