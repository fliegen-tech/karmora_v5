<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends karmora {

    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('usermodel','commonmodel'));
        $this->load->library('form_validation');
    }

    public function profile($username = NULL) {
        $this->verifyUser($username);
        $this->data['userData'] = $this->commonmodel->getUserDetails($username);
        $this->data['email_types'] = $this->usermodel->getUserEmails($this->data['userData']['pk_user_id']);
        $userAddress = $this->usermodel->getMemberCurrentAddress($this->data['userData']['pk_user_id']);
        $this->data['pic'] = $this->usermodel->checkProfilePic($this->data['userData']['pk_user_id']);
        $this->data['address'] = $userAddress['address'];
        $this->data['countriesList'] = $userAddress['countriesList'];
        $this->data['statesList'] = $userAddress['statesOfCurrentAddressCountry'];
        $this->data['mainsummery'] = $this->usermodel->getuser_main_summary($this->data['userData']['pk_user_id']);
        $this->data['active_page'] = 'profile';
        $this->loadLayout($this->data, 'frontend/user/profile');
    }

    public function manageSubscription($username) {
        $this->verifyUser($username);
        $this->data['page_title'] = 'Karmora - Update Subscription';

        if (isset($_POST['submit'])) {
            $this->validateSubscritpoinForm($username);
        }
        $this->load->view('frontend/layout/header_basic', $this->data);
        $this->load->view('frontend/user/pay_subscription', $this->data);
        $this->load->view('frontend/layout/footer_empty', $this->data);
    }

    private function validateSubscritpoinForm($username) {
        $this->form_validation->set_rules('card_number', 'Card Number', 'required|numeric|min_length[13]|max_length[16]|trim');
        $this->form_validation->set_rules('month', 'Month', 'required||numeric|exact_length[2]|trim');
        $this->form_validation->set_rules('year', 'Year', 'required|numeric|exact_length[4]|trim');
        $this->form_validation->set_rules('card_code', 'CVV', 'required|numeric|trim');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() === FALSE) {
        } else {
            $this->subscriptionUpdate($this->input->post(), $username);
        }
    }

    private function subscriptionUpdate($param, $username) {
//      run penny authroization
        $authorization = $this->runauthrioze($param);
        if ($authorization == FALSE) {
            $this->session->set_flashdata('subscription', '<div class="alert alert-danger" role="alert"> Card Declined.</div>');
            redirect(base_url('profile/subscription'));
            exit;
//          TODO :: send error to subscription page
        } else {
//          void auhorization
            $this->Voidauthrioze($authorization->trans_id);
//          authorize and capture
            $param['amount'] = $this->upgrade_cost;
            $transection = $this->authAndCapture($param);
            if (isset($transection['transaction_id']) && $transection['transaction_id'] != '') {
                $this->usermodel->updateRecurringBillingDeclinedRecord(array('transaction_id' => $transection['transaction_id'], 'user_id' => $this->session->userdata['front_data']['id']));
                $this->updateSubscription($username);
                redirect(base_url('profile'));
            } else {
//                TODO :: send error to subscription page
                $this->session->set_flashdata('subscription', '<div class="alert alert-danger" role="alert"> Your Request did not proceed successfully.</div>');
                redirect(base_url('profile/subscription'));
            }
        }
        return;
    }

    private function authAndCapture($param) {
        $userid = $this->session->userdata['front_data']['id'];
        $UserData = $this->commonmodel->getuserdetail($userid);
        $post = $this->security->xss_clean($param);
        $card_code = $post['card_code'];
        $month = $post['month'];
        $year = $post['year'];
        $exp_date = $month . '-' . $year;
        $card_number = str_replace(' ', '', $post['card_number']);
        $auth = new authNet();
        $auth->transectionProps = array(
            #order detail
            "po_num" => "MembershipFee-" . $userid,
            "amount" => $param['amount'],
//            "freight" => $userOrder->order_shiping_cost,
//            "tax" => $userOrder->order_tax_cost,
            "description" => "Payment for recurring membership fee user " . $UserData->user_first_name,
            # cc Info
            "card_num" => "'$card_number'",
            "card_code" => "'$card_code'",
            "exp_date" => "'$exp_date'",
            #Customer Details
            "cust_id" => $userid,
            "customer_ip" => $_SERVER['REMOTE_ADDR'],
            "first_name" => $UserData->user_first_name,
            "last_name" => empty($UserData->user_last_name) ? $UserData->user_first_name : $UserData->user_last_name,
            "email" => $UserData->user_email,
        );
        $responce = $auth->processCCtransection();
        return $responce;
    }

    public function updateSubscriptionAction($username) {
        $this->verifyUser($username);
        $this->form_validation->set_rules('card_number', 'Card Number', 'required|numeric|min_length[13]|max_length[16]|trim');
        $this->form_validation->set_rules('month', 'Month', 'required||numeric|exact_length[2]|trim');
        $this->form_validation->set_rules('year', 'Year', 'required|numeric|exact_length[4]|trim');
        $this->form_validation->set_rules('card_code', 'CVV', 'required|numeric|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('subscription', '<div class="alert alert-danger" role="alert">' . $this->form_validation->error_string() . '</div>');
        } else {
            $subUpdate = $this->updateSubscription($username);
            if ($subUpdate['success']) {
                redirect(base_url('profile'));
            } else {
//                TODO :: show error returned in $subUpdate on subscription page 
                echo 'error';
                exit;
                redirect(base_url('profile/subscription'));
            }
        }
        exit;
        return;
    }

    private function updateSubscription($username) {
        $userDetailA = $this->commonmodel->getUserDetails($username);
        $userDetail = reset($userDetailA);
        $pk_user_id = $userDetail['pk_user_id'];
        $this->db->from('tbl_upgrade_request');
        $this->db->where('fk_user_id', $pk_user_id);
        $this->db->order_by('upgrade_request_create_date', 'desc');
        $this->db->limit(1);
        $subProps1 = $this->db->get();
        $subProps = reset($subProps1->result());
        $authObj = new authNet();
        $authObj->subscriptionProps['subscriptionId'] = $subProps->upgrade_request_auth_sub_id;
        $authObj->subscriptionProps['cc_number'] = $this->input->post('card_number');
        $authObj->subscriptionProps['cvc'] = $this->input->post('card_code');
        $authObj->subscriptionProps['expiration_date'] = $this->input->post('month') . '-' . $this->input->post('year');

        $result['success'] = !is_null($authObj->subscriptionProps['subscriptionId']) ? $authObj->updateARB() : FALSE;

        if ($result['success']) {
            $this->session->set_flashdata('subscription', '<div class="alert alert-success" role="alert">Subscription update successful.</div>');
        } else {
            $result['message'] = isset($result['message']) ? $result['message'] : 'No record found.';
            $this->session->set_flashdata('subscription', '<div class="alert alert-danger" role="alert">' . $result['message'] . '</div>');
        }
        return $result;
    }

    public function uploadPicture($username = NULL) {
        $this->verifyUser($username);
        $userData = $this->commonmodel->getUserDetails($username);
        $pk_user_id = $userData[0]['pk_user_id'];
        $uploadpath = './public/images/profile-pic/' . $pk_user_id;
        @mkdir($uploadpath, 755);
        $filename = $userData[0]['user_username'] . rand(0, 3);

        $config['file_name'] = $filename;
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upl')) {
        } else {
            $this->uploadExtra($pk_user_id);
        }
    }

    public function uploadExtra($pk_user_id) {

        $upload_data = $this->upload->data();

        $user_pic = $this->usermodel->checkProfilePic($pk_user_id);

        if ($user_pic) {
            //echo "pic exists";
            $this->db->where('fk_user_id', $pk_user_id);
            $this->db->update('tbl_user_profile_picture', array('profile_user_picture_status' => 'Inactive'));
            $data = array(
                'picname' => $upload_data['file_name']
            );
            $this->usermodel->setProfilePic($pk_user_id, $data);
        } else {
            // inserting user picture into database
            $data = array(
                'picname' => $upload_data['file_name']
            );
            $this->usermodel->setProfilePic($pk_user_id, $data);
        }
        echo '{"status":"success"}';
        exit;
        redirect(base_url() . 'profile');
        exit;
    }

    public function manageemail($username = NULL) {
        $this->verifyUser($username);
        $userId = $this->input->post('userId');
        if (!empty($_POST['emails'])) {
            $string = implode(",", $_POST['emails']);
            $this->usermodel->changeEmailSub($string, $userId);
        } else {
            $this->usermodel->changeEmailAll($userId);
        }
        $this->session->set_flashdata('email_succ', 'Changes Saved');
        redirect(base_url() . 'profile');
    }

    public function editProfile($username = NULL) {
        $this->verifyUser($username);
        $userDetail = $this->commonmodel->getUserDetails($username);
        $current_password = $userDetail[0]['user_password'];
        if ($_POST) {
            if (isset($_POST['action']) && $_POST['action'] === "edit_profile") {
                $this->action_edit_profile();
            } elseif (isset($_POST['action']) && $_POST['action'] === "change_password") {
                $this->action_change_password($userDetail, $current_password);
            } elseif (isset($_POST['action']) && $_POST['action'] === "address_update") {
                $this->action_address_update();
            } elseif (isset($_POST['action']) && $_POST['action'] === "savew9form") {
                $this->action_savew9form();
            }
        }
    }

    public function action_edit_profile() {
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('profile_err', $this->form_validation->error_string());
            redirect(base_url() . "profile");
        } else {
            $this->usermodel->editprofile($this->input->post());
            $this->session->set_flashdata('success', 'Basic Information Updated');
            redirect(base_url() . "profile");
        }
    }

    public function action_change_password($userDetail, $current_password) {
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() === FALSE || md5($this->input->post('curr_password')) !== $current_password) {
            // echo validation_errors();exit;
            $this->session->set_flashdata('pass_err', 'Password missmatch');
            redirect(base_url() . "profile");
        } else {
            $this->usermodel->changePassword($this->input->post(), $userDetail[0]['pk_user_id']);
            $this->session->set_flashdata('pass_succ', 'Password Changed');
            redirect(base_url() . "profile");
        }
    }

    public function action_address_update() {
        $this->form_validation->set_rules('street_address', 'Street Address', 'required|trim');
        $this->form_validation->set_rules('street_address_2', 'Street Address', 'trim');
        $this->form_validation->set_rules('country', 'Country', 'required|trim');
        $this->form_validation->set_rules('state', 'State', 'required|trim');
        $this->form_validation->set_rules('city', 'City', 'required|trim');
        $this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone No', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('address_err', $this->form_validation->error_string());
            redirect(base_url() . "profile");
        } else {
            $this->update_address_function();
        }
    }

    public function update_address_function() {
        $post = $this->input->post();
        $arState = explode('-.-', $post['state']);
        $arCity = $post['city'];
        $address['countryId'] = $post['country'];
        $address['stateId'] = end($arState);
        $address['city'] = $arCity;
        $address['zipCode'] = $post['zipcode'];
        $address['streetAddress'] = $post['street_address'];
        $address['streetAddress_2'] = NULL;
        $phone = $post['phone'];
        if (isset($post['street_address_2'])) {
            $address['streetAddress_2'] = $post['street_address_2'];
        }
        $address['userId'] = $post['userId'];
        $validatecsc = $this->usermodel->validateCountryStateCity($address);
        $this->usermodel->updatePhone($address['userId'], $phone);
        $this->redirect_address($address, $validatecsc);
    }

    public function redirect_address($address, $validatecsc) {
        if ($validatecsc === false) {
            $address['cityId'] = $validatecsc['city_id'];
            $this->usermodel->updateAddress($address);
            $this->session->set_flashdata('address_success', 'Address updated successfully.');
            redirect(base_url('profile'));
        } else {
            $this->session->set_flashdata('address_err', 'No change in address.');
            redirect(base_url('profile'));
        }
    }

    public function savew9form($username = NULL) {
        $this->verifyUser($username);
        $userDetail = $this->session->userdata('front_data');
        if (isset($_FILES["w9form"]["name"])) {

            $validextensions = array("pdf");
            $temporary = explode(".", $_FILES["w9form"]["name"]);
            $file_extension = end($temporary);
            if ($_FILES["w9form"]["type"] == "application/pdf" && in_array($file_extension, $validextensions)) {
                if ($_FILES["w9form"]["error"] > 0) {
                    $this->session->set_flashdata('w9form_err', $this->form_validation->error_string());
                    redirect(base_url() . "profile");
                } else {
                    $temp = explode(".", $_FILES["w9form"]["name"]);
                    $newfilename = round(microtime(true)) . '_' . $userDetail['id'] . '.' . end($temp);
                    move_uploaded_file($_FILES["w9form"]["tmp_name"], "./public/images/user_w9_form/" . $newfilename);
                    $data = array(
                        'fk_user_id' => $userDetail['id'],
                        'w9_form_file' => $newfilename,
                        'w9_form_status' => 'Awating'
                    );
                    $this->db->insert('tbl_user_w9_form', $data);
                    $this->session->set_flashdata('w9form_sucess', 'File Upload Sucefully');
                    redirect(base_url() . "profile");
                }
            } else {
                $this->session->set_flashdata('w9form_err', 'Invalid file Size or Type');
                redirect(base_url() . "profile");
            }
        }
    }

    public function autornized($username = NULL) {
        $this->loadLayout($this->data, 'frontend/user/autornized');
    }

}

/* Location: ./application/controllers/welcome.php */