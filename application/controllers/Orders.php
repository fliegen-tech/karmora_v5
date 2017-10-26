<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends karmora {

    public $data;
    public $page = 'orders';

    public function __construct() {

        parent::__construct();
        $this->load->library('email');
        $this->data['themeUrl'] = $this->themeUrl;
        $this->header = $this->load->view('frontend/layout/header_home', $this->data, TRUE);
        $this->footer = $this->load->view('frontend/layout/footer_home', $this->data, TRUE);
        $this->load->model('cartmodel');
        $this->load->model('commonmodel');
        require_once('authNet.php');
        if (!$this->session->userdata('front_data')) {
            redirect(base_url());
            exit;
        }
    }

    public function index($username = NULL) {
        $data = array();
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $data['mainsummery'] = $this->commonmodel->getuser_main_summary($detail['userid']);
        $userOrder = $this->commonmodel->getUserorders($detail['userid']);
        $data['userOrder'] = $userOrder;
        $data['page_active'] = 'order';
        $this->loadLayout($data, 'frontend/orders/myorder');
    }

    public function detail($order_no, $username = NULL) {
        $data = array();
        if ($order_no == '') {
            redirect(base_url('my-orders'));
        }
        $this->verifyUser($username);
        $detail = $this->currentUser;
        $data['mainsummery'] = $this->commonmodel->getuser_main_summary($detail['userid']);
        $data['exectivesummery'] = $this->commonmodel->getuser_exective_summary($detail['userid']);

        $data['userOrder'] = $this->cartmodel->getOrderDetailById($order_no, $detail['userid']);
        if (empty($data['userOrder'])) {
            redirect(base_url());
        }
        $data['Orderproduct'] = $this->cartmodel->getOrderProduct($data['userOrder']->pk_order_id);
        if (empty($data['Orderproduct'])) {
            redirect(base_url());
        }
        if (isset($_POST['submit'])) {
            $data['paymentresponce'] = false;
            $responce = $this->processpayment($detail, $data['userOrder'], $username);
            if (isset($responce['transaction_id']) && $responce['transaction_id'] != '') {
                $dataLog1 = array(
                    'user_account_log_status' => 'Inactive'
                );
                $this->db->where('fk_user_id', $detail['userid']);
                $this->db->update('tbl_user_to_user_account_type_log', $dataLog1);
                
                $dataLog = array(
                    'fk_user_id' => $detail['userid'],
                    'fk_user_account_type_id' => 5,
                    'user_account_log_status' => 'Active',
                    'user_account_log_create_date' => date("Y-m-d")
                );

                $this->db->insert('tbl_user_to_user_account_type_log', $dataLog);
                // insert rank
                $dataRank = array(
                    'fk_user_id' => $detail['userid'],
                    'user_rank_alias' => 'premier_shopper'
                );
                $this->db->insert('tbl_user_rank_log', $dataRank);
                $data['paymentresponce'] = true;
            }else{
                $data['paymentresponceMsg'] = 'error';
            }
        }
        $data['Ordercoupon'] = $this->cartmodel->getOrdercoupon($detail['userid'], $data['userOrder']->pk_order_id);
        $orderTotalDetail = !empty($data['userOrder']) ? $this->cartmodel->getOrderDetailTotalsSummery_row($data['userOrder']->pk_order_id) : FALSE;
        $data['orderTotalDetail'] = $orderTotalDetail;
        $data['orderDetailTotalsSummary'] = ''; //!is_array($orderTotalDetail)? redirect(base_url()) : $this->sortOrderTotalSummary($orderTotalDetail);
        $data['page_active'] = 'order';
        $this->loadLayout($data, 'frontend/orders/order_detail');
    }

    private function sortOrderTotalSummary($summaryData) {
        //echo '<pre>';        print_r($summaryData); die;

        $localSummary = array();
        $summaryElements = array(
            'order_upgrade_cost' => array('title' => 'Premire Shopper Upgrade', 'sortOrder' => 1),
            'order_shiping_cost' => array('title' => 'Shipping & Handling', 'sortOrder' => 2),
            'total' => array('title' => 'Total', 'sortOrder' => 3),
            'order_karmora_cash_price' => array('title' => 'Karmora Cash', 'sortOrder' => 4),
            'order_tax_cost' => array('title' => 'Tax', 'sortOrder' => 5),
            'order_commsion_price' => array('title' => 'Available Funds', 'sortOrder' => 6),
            'order_total_price' => array('title' => 'Total Charged', 'sortOrder' => 7)
        );
        foreach (reset($summaryData) as $key => $value) {
            foreach ($summaryElements as $eleKey => $eleValue) {
                if (!strcmp($eleKey, $key)) {
                    $localSummary[$eleValue['title']]['value'] = $value;
                    $localSummary[$eleValue['title']]['sortOrder'] = $eleValue['sortOrder'];
                }
            }
        }
        //$localSummary['Tax'] =array('value'=> 'pending fix', 'sortOrder' => 5) ;
        //$localSummary['Total'] = array('value'=> 'pending fix', 'sortOrder' => 3) ;
        //echo '<pre>';        print_r($localSummary); die;
        return $localSummary;
    }

    public function processpayment($detail, $userOrder, $username) {
        $this->verifyUser($username);
        $UserData = $this->commonmodel->getuserdetail($detail['userid']);
        $card_number = $this->input->post('card_number');
        $card_code = $this->input->post('card_code');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $exp_date = $month . '-' . $year;
        $auth = new authNet();
        $amount = $userOrder->order_cal_total;
        if ($userOrder->order_cal_total == '') {
            $amount = round($userOrder->amount - $userOrder->order_commsion_price + 0.0001, 2);
        }
        $auth->transectionProps = array(
            #order detail
            "po_num" => $userOrder->order_no,
            "amount" => $amount,
            "freight" => $userOrder->order_shiping_cost,
            "tax" => $userOrder->order_tax_cost,
            "description" => "Order Placed number = $userOrder->order_no",
            # cc Info
            "card_num" => "'$card_number'",
            "card_code" => "'$card_code'",
            "exp_date" => "'$exp_date'",
            #Customer Details
            "cust_id" => $detail['userid'],
            "customer_ip" => $_SERVER['REMOTE_ADDR'],
            "first_name" => $UserData->user_first_name,
            "last_name" => $UserData->user_first_name,
            "email" => $UserData->user_email,
            #ship to address
            "ship_to_first_name" => $UserData->user_first_name,
            "ship_to_last_name" => $UserData->user_first_name,
            "ship_to_address" => $userOrder->shipping_address_street,
            "ship_to_city" => $userOrder->shipping_address_city,
            "ship_to_state" => $userOrder->shipping_address_state,
            "ship_to_zip" => $userOrder->billing_address_zipcode,
            "ship_to_country" => 'US',
            "phone" => $userOrder->shipping_address_street,
        );
        $responce = $auth->processCCtransection();
        if ($responce['success'] == '' || !isset($responce['transaction_id'])) {
            $dataTran = array(
                'order_auth_net_transection_id' => '',
                'order_status' => 'declined',
                'oder_payment_status' => 'No'
            );
        }
        if (isset($responce['transaction_id']) && $responce['transaction_id'] != '') {
            $dataTran = array(
                'order_auth_net_transection_id' => $responce['transaction_id'],
                'order_status' => 'pending',
                'oder_payment_status' => 'Yes'
            );
        }
        $this->db->where('pk_order_id', $userOrder->pk_order_id);
        $this->db->update('tbl_oders', $dataTran);
        return $responce;
    }

    

}

/* Location: ./application/controllers/product.php */