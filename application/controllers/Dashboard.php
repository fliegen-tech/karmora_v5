<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author Usman
 */
class Dashboard extends karmora {

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->checklogin();
        $this->load->model(array('commonmodel','reportingmodel','usermodel','mycharitiesmodel','cashmeoutmodel'));
    }

    public function index($username = null) {
        $this->verifyUser($username);
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->session->userdata('front_data')['id']);
        $this->loadLayout($this->data,'frontend/dashboard/dashboard');

    }
    public function mycommunity($username = null) {
        $this->verifyUser($username);
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->session->userdata('front_data')['id']);
        $detail = $this->currentUser; //$detail['userid']
        $this->data['community'] = $this->reportingmodel->getUserShoppingCommunity($detail['userid']);
        $this->data['active_page'] = 'community';
        $this->loadLayout($this->data,'frontend/dashboard/mycommunity');

    }
    public function myewallet($username = null) {
        $this->verifyUser($username);
        $userData = $this->session->userdata('front_data');
        if (isset($_POST['submit'])) {
            $this->data['selected_month'] = $this->input->post('month');
            $this->data['selected_year'] = $this->input->post('year');
        } else {
            $this->data['selected_month'] = '';
            $this->data['selected_year'] = '';
        }
        if(isset($_POST['downloadAllData'])){
            $this->downloadAllData($username);
        }
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($userData['id']);
        $this->data['exectivesummery'] = $this->usermodel->getuser_exective_summary($userData['id']);
        $this->data['cashback'] = $this->reportingmodel->getUsermycashback($userData['id'],$this->data['selected_month'], $this->data['selected_year']);
        $this->data['commsion'] = $this->reportingmodel->getuserexclusivecommissions($userData['id'],$this->data['selected_month'], $this->data['selected_year']);
        $this->data['CashMeMember'] = $this->cashmeoutmodel->getUserCashMeOutRequests(array('userId' => $userData['id']));
        $this->data['myContribution'] = $this->mycharitiesmodel->getMyContribution($userData['id']);
        $this->data['active_page'] = 'E Vallet';
        $this->loadLayout($this->data,'frontend/dashboard/myewallet');
    }

    public function myKarmoraKash($username = NULL){
        $this->verifyUser($username);
        $userData = $this->session->userdata('front_data');
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($userData['id']);
        $this->data['exectivesummery'] = $this->usermodel->getuser_exective_summary($userData['id']);
        $detail = $this->currentUser; //$detail['userid']
        $this->data['karmoraKash'] = $this->reportingmodel->getUserKarmoraKash($detail['userid']);
        $this->data['active_page'] = 'karmora_kash';
        $this->loadLayout($this->data,'frontend/dashboard/mykarmorakash');
    }

    public function profitSharing($username){
        $this->verifyUser($username);
        $userData = $this->session->userdata('front_data');
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($userData['id']);
        $this->data['exectivesummery'] = $this->usermodel->getuser_exective_summary($userData['id']);
        $detail = $this->currentUser; //$detail['userid']
        $this->data['req'] = $this->reportingmodel->getPoolShareStats($userData['id']);
        $this->data['shareTable'] = $this->reportingmodel->getPoolShare($userData['id']);
        $this->data['profitsharing'] = $this->reportingmodel->getUserKarmoraKash($detail['userid']);
        $this->data['active_page'] = 'profit_sharing';
        $this->loadLayout($this->data,'frontend/dashboard/profitsharing');
    }

    public function adTracker($username){
        $this->verifyUser($username);
        $userData = $this->session->userdata('front_data');
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($userData['id']);
        $this->data['exectivesummery'] = $this->usermodel->getuser_exective_summary($userData['id']);
        $this->data['adtracker'] = $this->usermodel->getuser_trackingdetail($userData['id']);
        $this->data['active_page'] = 'ad_tracker';
        $this->loadLayout($this->data,'frontend/dashboard/adtracker');
    }

    public function orders($username = null) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($detail['userid']);
        $this->data['userOrder']   = $this->usermodel->getUserorders($detail['userid']);
        $this->data['active_page'] = 'order';
        $this->loadLayout($this->data, 'frontend/dashboard/myorder');
    }
    public function order_detail($order_no,$username = null) {
        $this->verifyUser($username);
        $detail = $this->currentUser;
        echo 'no html yet'; die;
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($detail['userid']);
        $this->data['userOrder']   = $this->usermodel->getUserorders($detail['userid']);
        $this->data['active_page'] = 'order';
        $data['userOrder'] = $this->cartmodel->getOrderDetailById($order_no, $detail['userid']);
        if (empty($data['userOrder'])) {
            redirect(base_url());
        }
        $data['Orderproduct'] = $this->cartmodel->getOrderProduct($data['userOrder']->pk_order_id);
        if (empty($data['Orderproduct'])) {
            redirect(base_url());
        }$this->loadLayout($this->data, 'frontend/dashboard/myorder');
    }




    public function downloadAllData($username){
        $this->verifyUser($username);
        $detail = $this->currentUser;
        //if (isset($_POST['submit'])) {
        $data['selected_month'] = $this->input->post('month');
        $data['selected_year'] = $this->input->post('year');
        //} else {
        //$data['selected_month'] = '';
        //$data['selected_year'] = '';
        //}
        $mycashback = $this->reportingmodel->getUserdownloadmycashback($detail['userid'],$data['selected_month'], $data['selected_year']);
        $this->cashbackcsv($mycashback);
        $mycommsion = $this->reportingmodel->getuserexclusivecommissions($detail['userid'],$data['selected_month'], $data['selected_year']);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=commission.csv');

        // create a file pointer connected to the output stream
        $outputz = fopen('php://output', 'w');

        // output the column headings
        fputcsv($outputz, array('User Id', 'Date', 'Description' , 'Shopper' ,'Floor' , 'Order Detail', 'Purchase Price' ,'Commission' ,'Status'));
        if(!empty($mycommsion)){
            foreach ($mycommsion as $com){
                fputcsv($outputz, $com);
            }

        }else{
            'No Record Found';
        }
        exit;

    }
    public function cashbackcsv($mycashback){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=cashback.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array('Date', 'Merchant', 'Purchase Price' , 'Floor' ,'Cash Back' , 'Premier Shopper 10% Bonus', 'CashBack %' ,'Status'));
        if(!empty($mycashback)){
            foreach ($mycashback as $da){
                fputcsv($output, $da);
            }
        }else{
            'No Record Found';
        }
        fputcsv($output, array("\r\n"));
        fputcsv($output, array("\r\n"));
        fputcsv($output, array('Commsion Data Stared ================================================ Commsion Data Stared'));
        fputcsv($output, array("\r\n"));

    }
}
