<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends karmora {

    /**
     * Constructor of a login 
     */
    public $data = array();
    public function __construct(){
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('loginmodel','commonmodel'));
        $this->load->library('form_validation');
    }

    /**
     * This is the default function of a controller 
     */
    public function index($username = null) {
        $this->checknotlogin();
        $this->verifyUser($username);
        if (isset($_POST['signin'])) {
            $this->form_validation->set_rules('user_email', 'Email', 'required');
            $this->form_validation->set_rules('user_password', 'Password', 'required');
            $this->form_validation->set_error_delimiters('', '');
            $username = $this->input->post('user_email');
            $password = $this->input->post('user_password');
            $pervious_url = $this->input->post('pervious_url'); 
            if ($this->form_validation->run() == FALSE) {
            } else {
                $hpassword = md5($password);
                $row = $this->loginmodel->frontendVerifyUser($username, $hpassword);
                if ($row) {
                    $this->cart->destroy();
                    $username = $row[0]['user_username'];
                    $this->config->set_item('base_url', base_url() . "$username");
                    $userSessionData = $this->set_session_login($row);
                    $this->session->set_userdata('front_data', $userSessionData);
                    if($pervious_url == ''){
                        redirect(base_url());
                    }else{
                        redirect($pervious_url);
                    }
                }else{
                    $this->data['message'] = 'Invalid Username Or Password .';
                }
            }
        }
         $this->loadLayout($this->data, 'frontend/login/content');
    }
    
    function logout() {
        $this->cart->destroy();
        $this->session->unset_userdata('front_data'); // unset your sessions
        $this->session->unset_userdata('landing_data'); // unset your sessions
        $this->session->sess_destroy();
        //$this->tank_auth->logout(); // Destroys session
        redirect(base_url());
    }

    function searchrefreal($search_value,$search_option){
        $html = '';
        $response = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
        $RefrealusersArray = $this->loginmodel->GetsearchRefreal($search_value,$search_option);
        if (!empty($RefrealusersArray)) {
            $html .= '<ul class="list-auto-search">';
            foreach ($RefrealusersArray as $search) {
                $user_name =  $search['_name'].' '.$search['_member_location'];
                $html .= '<li><a href= "javascript:void(0)" onclick="selectthisuser('.$search['pk_user_id'].','."'$user_name'".')"> '.$search['_name'].'</a></li>';
            }
            $html .= '</ul>';
        } else {
            $html .= "No member found";
        }
        $response['html'] = $html;
        echo json_encode($response); die;
    }

}
