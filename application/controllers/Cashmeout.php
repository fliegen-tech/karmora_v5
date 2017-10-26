<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cashmeout extends karmora {

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->checklogin();
        $this->load->library('form_validation');
        $this->load->model(array('commonmodel','cashmeoutmodel','mycharitiesmodel','usermodel'));
    }

    public function index($username) {
        $userDetail = $this->session->userdata('front_data');
        $userDetailDum = $this->commonmodel->getUserDetails($username);
        $userDetailA = reset($userDetailDum);
        $this->data['userData']['phone_no'] = $userDetailA['user_phone_no'];
        $this->data['TotalAvailable'] = $this->cashmeoutmodel->getMemberAccountBalance($userDetail['id']);
        $this->data['w9_form_check'] = $this->cashmeoutmodel->getuser_exclusive_commissions($userDetail['id']);
        $this->data['w9_form_check_sales'] = $this->cashmeoutmodel->getuser_exclusive_commissions_from_sales($userDetail['id']);
        $this->data['W9formdetail']   = $this->cashmeoutmodel->userW9formdetail($userDetail['id']);
        $this->data['userData']['fullName'] = $this->cashmeoutmodel->getUserFullNameWithId($userDetail['id']);
        $this->data['userData']['userAddress'] = $this->cashmeoutmodel->getMemberCurrentAddress($userDetail['id']);
        $this->data['minCashout'] = $this->cashmeoutmodel->getMinCashoutAmount($userDetail['id']);
        $this->data['CashMeMember'] = $this->cashmeoutmodel->getUserCashMeOutRequests(array('userId' => $userDetail['id']));
        $this->data['charityList'] = $this->cashmeoutmodel->getAllActiveCharities();
        $this->data['state'] = $this->cashmeoutmodel->getstate();
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($userDetail['id']);
        $this->data['active_page'] = 'Cashmeout';
        $this->data['myContribution'] = isset($userDetail['id']) ? $this->mycharitiesmodel->getMyContribution($userDetail['id']) : FALSE;
        $this->processCashout($userDetail, $this->data);
        $this->loadLayout($this->data, 'frontend/cashmeout/content');
    }

    private function processCashout($userDetail, $data) {
        $message = '';
        if (isset($this->input->post()['submit'])) {
          if (isset($_POST['amount']) && $_POST['amount'] != '') {
               $message = $message.  $this->processGift($userDetail, $data);
            }
            $data['TotalAvailable'] = $this->cashmeoutmodel->getMemberAccountBalance($userDetail['id']);

            $this->form_validation->set_rules('member_name', 'Member Name', 'required|min_length[5]|max_length[50]|trim');
            $this->form_validation->set_rules('street_address', 'Street Address', 'required|trim');
            $this->form_validation->set_rules('city', 'CIty', 'required|min_length[5]|trim');
            $this->form_validation->set_rules('state', 'State', 'required|trim');
            $this->form_validation->set_rules('zipcode', 'Zip Code', 'required|exact_length[5]|numeric|trim');
            $this->form_validation->set_rules('phone_no', 'Phone Number', 'required|min_length[7]|trim');
            $this->form_validation->set_rules('check_out_amount', 'Check out Amount', 'required|greater_than_equal_to['.$data['minCashout'].']|less_than_equal_to[' . $data['TotalAvailable'] . ']|trim');

            $post = $this->input->post();

            if ($this->form_validation->run()) {

                $state_name = $this->cashmeoutmodel->getStateName($post['state']);

                $dataArray['payee'] = $post['member_name'];
                $dataArray['amount'] = $post['check_out_amount'];
                $dataArray['acct_name'] = $post['member_name'];
                $dataArray['address'] = $post['street_address'];
                $dataArray['city'] = $post['city'];
                $dataArray['trans_id'] = $userDetail['subid'];
                $dataArray['state'] = $state_name['user_address_state_title'];
                $dataArray['zip'] = $post['zipcode'];

//                $webCheque = $this->processWebcheque($dataArray);
                $webCheque = 'fixthis';
//                var_dump($webCheque);exit;
                if ($webCheque != FALSE) {

                    $withdrawRequest = array(
                        'user_id' => $userDetail['id'],
                        'ref_user' => $userDetail['id'],
                        'amount' => -1 * $post['check_out_amount'],
                        'type' => 'Withdraw',
                        'description' => 'Reuqest Cheque of amount: $' . number_format($post['check_out_amount'], 2),);
                    $withdrawId = $this->cashmeoutmodel->insertDollarAccountWithdraw($withdrawRequest);
//                    $withdrawId = 2;
                    if ($withdrawId != FALSE) {
                        $cashOutRequest = array(
                            'requestAmount' => $post['check_out_amount'],
                            'userId' => $userDetail['id'],
                            'name' => $post['member_name'],
                            'streetAddress' => $post['street_address'],
                            'city' => $post['city'],
                            'stateId' => $post['state'],
                            'zipCode' => $post['zipcode'],
                            'phone' => $post['phone_no'],
                            'status' => 'Requested',
                            'dollarAccountId' => $withdrawId,
                            'webChequeId' => $webCheque);
                        $cashOutRequestId = $this->cashmeoutmodel->insertCashoutRequest($cashOutRequest);
//                        echo $cashOutRequestId; exit;
                        if ($cashOutRequestId != FALSE) {
                            $message = $message . '<div class="col-md-12 alert alert-success">
                                <div class=row>
                                    <div class=col-md-12>
                                    <h4>Summery</h4>
                                    <p>Name: ' . $post['member_name'] . '</p>
                                    <p>Address: ' . $post['street_address'] . '<br>' . $post['city'] . ', ' . $post['zipcode'] . ', ' . $post['user_address_state_title'] . '</p>
                                    <p>Check out Amount: $ ' . $post['check_out_amount'] . '</p>                                    
                                    </div>
                                </div>
                                    </div>';
                            /// send email for karmora check
            
                                /*$email_dataKC    = $this->commonmodel->getemailInfo(32);
                                $tagKC           = array("{Name-of-Shopper}","{Address-1}","{City}","{Zip}","{Amount-of-Gift}", "{Name-of-Charity}","{Date}", "{plu-seven-days}", "{status-or}");
                                $replaceKC       = array($userDetail['user_first_name'],$post['street_address'],$post['city'],$post['zipcode'],'$'.$post['check_out_amount'], $post['member_name'], date('Y-m-d') , date('m-d-Y', strtotime("+7 days")),'Submitted');
                                $subjectKC       = $email_dataKC->email_title;
                                $messageKC       = $this->prepEmailContent($tagKC, $replaceKC, $subjectKC, $email_dataKC->email_description, '',$email_dataKC->email_header_text);
                                $toKC            = $userDetail['user_email'];
                                $this->send_mail($toKC, $subjectKC, $messageKC);
            */
                        } else {
                            $message = $message . '<div class="col-md-12 alert alert-danger">Could not process the transection. Please try again.</div>';
                            $this->db->delete('tbl_karmora_dollar_account', array('pk_dollar_account_id' => $withdrawId));
                        }
                    } else {
                        $message = $message . '<div class="col-md-12 alert alert-danger">Could not process the transection. Please try again.</div>';
                    }
                    $this->session->set_flashdata('checkout', $message);
                    $data['TotalAvailable'] = $this->cashmeoutmodel->getMemberAccountBalance($userDetail['id']);
                    redirect(base_url('cashmeout'));
                }
            }
        }
        return;
    }

    public function gift() {
        $userDetail = $this->session->userdata('front_data');
        $this->data['TotalAvailable'] = $this->cashmeoutmodel->getMemberAccountBalance($userDetail['id']);
        $this->data['userData']['fullName'] = $this->cashmeoutmodel->getUserFullNameWithId($userDetail['id']);
        $this->data['charityList'] = $this->cashmeoutmodel->getAllActiveCharities();
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($userDetail['id']);
        $this->data['donation'] = $this->cashmeoutmodel->getUserDonations(array('userId' => $userDetail['id']));

        if (isset($this->input->post()['cashout'])) {
            $message = $this->processGift($userDetail, $this->data);
            $this->session->set_flashdata('donation', $message);
            redirect(base_url('cashmeout/gift'));
        }
        $this->data['page_active'] = 'Cashmeout';
        $this->loadLayout($this->data, 'frontend/cashmeout/gift');
    }

    private function processGift($userDetail, $data) {
        $message = '';
        $this->form_validation->set_rules('charity', 'Organization', 'required|numeric|trim');
        $this->form_validation->set_rules('amount', 'Gift amount', 'required|numeric|less_than_equal_to[' . $data['TotalAvailable'] . ']|trim');
        if ($this->form_validation->run()) {
            $post = $this->input->post();
            $charityDetail  = $this->cashmeoutmodel->getCharityDetail($post['charity']);
            $charityName    = is_array($charityDetail) ? $charityDetail['charity_name'] : '';
            /// send email to user for donation thanks
            /*
            $email_data     = $this->commonmodel->getemailInfo(30);
            $link           = base_url().'karmora-my-charities';
            $gift_link      = '<a href="'.$link.'" style="color: #cc0066;">Click here</a>';
            $tags           = array("{Shopper-FirstName}","{Amount-of-Gift}", "{Name-of-Charity}","{Date}", "{gift-link}");
            $replace        = array($userDetail['user_first_name'],$post['amount'], $charityName, date('m-d-Y') , $gift_link);
            $subject        = $email_data->email_title;
            $messageE        = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, '',$email_data->email_header_text);
            $to             = $userDetail['email'];
            $this->send_mail($to, $subject, $messageE); 
            */
            /// send email to chairty
            
            /*
            $email_dataC    = $this->commonmodel->getemailInfo(31);
            $link           = base_url().'karmora-my-charities';
            $gift_link      = '<a href="'.$link.'" style="color: #cc0066;">Click here</a>';
            $tagC           = array("{Name-of-Shopper}","{Address-1}","{Address-2}","{City}","{Zip}","{Amount-of-Gift}", "{Name-of-Charity}","{Date}", "{gift-link}");
            $replaceC       = array($userDetail['user_first_name'],$charityDetail['charity_street_address'],$charityDetail['charity_street_address_2'],$charityDetail['charity_city_name'],$charityDetail['charity_zip_code'],'$'.$post['amount'], $charityName, date('m-d-Y') , $gift_link);
            $subjectC       = $email_dataC->email_title;
            $messageC       = $this->prepEmailContent($tagC, $replaceC, $subjectC, $email_dataC->email_description, '',$email_dataC->email_header_text);
            $toC            = $userDetail['email'];
            $this->send_mail($toC, $subjectC, $messageC);
            */
            
            
            ///////////////
            
            
            
            $withdraw = array(
                'user_id' => $userDetail['id'],
                'ref_user' => $post['charity'],
                'amount' => -1 * $post['amount'],
                'type' => 'Withdraw',
                'description' => 'Gift to Charity: ' . $charityName,);
                $withdrawId = $this->cashmeoutmodel->insertDollarAccountWithdraw($withdraw);
                //echo $withdrawId.'usman'; die;
            if ($withdrawId != FALSE) {
                $donate = array(
                    'charity' => $post['charity'],
                    'user_id' => $userDetail['id'],
                    'fname' => $post['fname'],
                    'amount' => $post['amount'],
                    'status' => 'Submitted',
                    'type' => 'Cash me out'
                );
                $donation = $this->cashmeoutmodel->insertGiftToCharity($donate);
                if ($donation) {
                    $message = $message . '<div class="col-md-12 alert alert-success">Thank you for your Gift, Karmora will deliver your best wishes.</div>';
                    $this->karmoraKashAward(array('user_id' => $donate['user_id'], 'donated_amount' => $donate['amount']));
                } else {
                    $message = $message.'<div class="col-md-12 alert alert-danger">because of nature fury unable to send your gift. Please try again.</div>';
                    $this->db->delete('tbl_karmora_dollar_account', array('pk_dollar_account_id' => $withdrawId));
                }
            } else {
                $message = $message . '<div class="col-md-12 alert alert-danger">Could not process the transection. Please try again.</div>';
            }
        }else{
             //echo validation_errors(); die;
        }
        return $message;
    }

    private function karmoraKashAward($param) {

        $this->cashmeoutmodel->insertKarmoraKashAward($param);
        return;
    }

    
    private function addNewAddress($data) {

        $key = array(
            "fk_users_id" => $data['userId'],
            "user_address_street_address" => $data['co_address'],
            "user_address_city_name" => $data['co_city'],
            "user_address_zip_code" => $data['co_zipCode'],
            "fk_user_address_state_id" => $data['co_stateId'],
            "fk_user_address_country_id" => $data['countryId'],
            "user_address_current" => 'true'
        );

        $address = $this->db->select("pk_user_address_id AS addressId")->from('tbl_user_address')->where($key)->get();
        if (isset($address->row()->addressId)) {
            $response = $address->row()->addressId;
        } else {
            //set all previous address for user to false
            $setAllAddressInactiveQuery = "UPDATE tbl_user_address AS uadd SET uadd.user_address_current = 'false' WHERE uadd.fk_users_id = " . $data['userId'];
            $statement = $this->db->conn_id->prepare($setAllAddressInactiveQuery);
            $statement->execute();

            $insertAddressQuery = "INSERT INTO tbl_user_address
                                    SET fk_users_id = :userId,
                                        user_address_street_address = :streeAddress,
                                        user_address_city_name = :city,
                                        user_address_zip_code = :zipCode,
                                        fk_user_address_state_id = :stateId,
                                        fk_user_address_country_id = :countryId,
                                        user_address_create_date = NOW(),
                                        user_address_current = 'true'";
            $insertStatement = $this->db->conn_id->prepare($insertAddressQuery);
            $insertStatement->bindParam(':userId', $data['userId'], PDO::PARAM_STR);
            $insertStatement->bindParam(':streeAddress', $data['co_address'], PDO::PARAM_STR);
            $insertStatement->bindParam(':city', $data['co_city'], PDO::PARAM_STR);
            $insertStatement->bindParam(':zipCode', $data['co_zipCode'], PDO::PARAM_STR);
            $insertStatement->bindParam(':stateId', $data['co_stateId'], PDO::PARAM_STR);
            $insertStatement->bindParam(':countryId', $data['countryId'], PDO::PARAM_STR);
            $insertStatement->execute();
            $response = $this->db->insert_id();
        }
        return $response;
    }

    private function insertCashoutRequest($data) {

        $cashoutStatus = 'Requested';

        $insertCashoutRequest = "INSERT INTO tbl_user_cashout_request
                                    SET user_cashout_request_amount = :user_cashout_request_amount,
                                        fk_user_address_id = :fk_user_address_id,
                                        fk_user_id = :fk_user_id,
                                        user_cashout_request_status = :user_cashout_request_status,
                                        user_cashout_request_create_date = NOW()";
        $insertStatement = $this->db->conn_id->prepare($insertCashoutRequest);
        $insertStatement->bindParam(':user_cashout_request_amount', $data['co_totalCashout'], PDO::PARAM_STR);
        $insertStatement->bindParam(':fk_user_address_id', $data['addressId'], PDO::PARAM_STR);
        $insertStatement->bindParam(':fk_user_id', $data['userId'], PDO::PARAM_STR);
        $insertStatement->bindParam(':user_cashout_request_status', $cashoutStatus, PDO::PARAM_STR);
        $insertStatement->execute();
        $cashoutId = $this->db->insert_id();

        foreach ($data['availableAmount'] as $payment) {
            $Casdata = array('fk_user_cashout_request_id' => $cashoutId, 'user_cash_back_status' => 'Cashed out');
            $this->db->where(array('fk_user_id ' => $data['userId'], 'fk_sales_id ' => $payment['fk_sales_id']));
            $this->db->update('tbl_user_cash_back', $Casdata);
        }
        return $cashoutId;
    }

    private function insertWithDraw($data) {
        $datas = array('fk_withdraw_type_id' => $data['withdrawTypeId'],
            'fk_cash_out_request_id' => $data['cashoutId'],
            'amount' => $data['amount'],
            'pay_to_id' => $data['pay_to_id']);
        $this->db->insert('tbl_amount_withdraw', $datas);

        if ($data['withdrawTypeId'] == 2) {
            $detailUser = $this->commonmodel->getUserDeta($data['pay_to_id']);
            $user_subid = $detailUser->user_subid;
            $contributerData = $this->commonmodel->getUserDeta($data['contributorId']);

            $datas = array('sales_tracking_id' => $user_subid,
                'sales_transection_id' => $data['cashoutId'] . '_' . $data['pay_to_id'],
                'fk_user_id' => $data['pay_to_id'],
                'sales_product_description' => 'Gift from Karmora Family',
                'sales_sale_amount' => $data['amount'],
                'sales_kash_back_percentage' => 0,
                'sales_total_amount' => $data['amount'],
                'sales_advertiser_name' => $contributerData->user_first_name . " " . $contributerData->user_last_name,
                'sale_date' => date('Y-m-d'),
                'sales_create_date' => date('Y-m-d H-i-s'),
                'sales_processing_status' => 'pending',
                'sales_cashback_payment_status' => 'available',
                'sales_payment_type' => 'gift');
            $this->db->insert('tbl_sales', $datas);
        }

        return;
    }

    // function to process webcheck
    private function processWebcheque($dataArray) {

        // making data array for webchecks

        $api_url = "http://api.webmasterchecks.com/payments/add";
        $client_id = "306";
        $api_key = "mDS1rpRB2ymmcK8rZ8oouLXL+zjJRSJJbeiAIw7R0B7KnYVg+uc4Jmv21yrJR2KY8HWPVm0GhjwyvjkjpZ5hhxsDUcQ6L2YD/voctUfVKYx+rFveHj8eCeUym3P5ta25";

        $dataArray['client_id'] = $client_id;
        $dataArray['akey'] = $api_key;
        $dataArray['method_id'] = '2';
        $dataArray['acct_class'] = 'Personal';
        $dataArray['acct_route'] = '122101706';
        $dataArray['acct_type'] = 'Savings';
        $dataArray['bank_name'] = 'Bank of America';
        $dataArray['country'] = 'US';
        $dataArray['reference'] = 'Karmora';

        //echo '<pre>';
        $post_data = http_build_query($dataArray);

        //echo '<pre>';


        $xml = new DOMDocument();
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return xml
        curl_setopt($ch, CURLOPT_HEADER, false); //we only need the body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $loadedXml = $xml->loadXML(curl_exec($ch));
        curl_close($ch);
        $savedXml = $xml->saveXML();
        //echo "<pre>";
        $newXml = new SimpleXMLElement($savedXml);
        //print_r($newXml);
        $payment_id = (array) $newXml->payment->payment_id;

        //var_dump($payment_id);
        //exit;
        return $payment_id[0];
    }

    private function confirmPayment($paymentId) {
        //var_dump( $paymentId); exit;
        $api_url = "http://api.webmasterchecks.com/payments/confirm";
        $client_id = "306";
        $api_key = "mDS1rpRB2ymmcK8rZ8oouLXL+zjJRSJJbeiAIw7R0B7KnYVg+uc4Jmv21yrJR2KY8HWPVm0GhjwyvjkjpZ5hhxsDUcQ6L2YD/voctUfVKYx+rFveHj8eCeUym3P5ta25";
//        $dataArray['item'] = $paymentId;
//        $dataArray['client_id'] = $client_id;
//        $dataArray['akey'] = $api_key;
        //$post_data = http_build_query($dataArray);
        $data = array(
            'client_id' => $client_id,
            'akey' => $api_key,
            'item' => 'single-' . $paymentId
        );
//         $xml = new DOMDocument();
//        $ch = curl_init('https://apisb.webmasterchecks.com/payments/confirm');
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$s = curl_exec($ch);

        $xml = new DOMDocument();
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return xml
        curl_setopt($ch, CURLOPT_HEADER, false); //we only need the body
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $loadedXml = $xml->loadXML(curl_exec($ch));
        curl_close($ch);
        $savedXml = $xml->saveXML();
        //echo "<pre>";
        $newXml = new SimpleXMLElement($savedXml);
        //print_r($newXml);
    }
  
    public function savew9form() {
        $userDetail = $this->session->userdata('front_data');
        if(isset($_FILES["file"]["type"])){
            $validextensions = array("pdf");
            $temporary = explode(".", $_FILES["file"]["name"]);
            $file_extension = end($temporary);
            if ((($_FILES["file"]["type"] == "application/pdf")) && in_array($file_extension, $validextensions)) {
            if ($_FILES["file"]["error"] > 0){
                echo "<div class='alert alert-danger'>" . $_FILES["file"]["error"] . "</div>"; die;
            }else{
                $temp = explode(".", $_FILES["file"]["name"]);
                $newfilename = round(microtime(true)).'_'.$userDetail['id'] . '.' . end($temp);
                move_uploaded_file($_FILES["file"]["tmp_name"], "./public/images/user_w9_form/" . $newfilename); 
                $data = array(
                        'fk_user_id' => $userDetail['id'],
                        'w9_form_file' => $newfilename,
                        'w9_form_status' => 'Awating'
                );
                $this->db->insert('tbl_user_w9_form', $data);
                echo "<div class='alert alert-success'>Image Uploaded Successfully...!!</div>";die;
            }}else{
                    echo "<div class='alert alert-danger'>Invalid file Size or Type<div>"; die;
                }
            }
    }   

}
