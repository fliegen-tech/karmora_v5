<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends karmora {

    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->data['themeUrl'] = $this->themeUrl;
        $this->load->model(array('commonmodel', 'postmodel'));
    }
    public function index($username = NULL) {
        $this->verifyUser($username); //die;
        $this->data['resent_blog'] = $this->postmodel->getPostList('all',3);
        $this->data['category'] = $this->postmodel->getcategorieslist(8);
        $this->loadLayout($this->data, 'frontend/blog/listing_category');

    }
    public function category_detail($category_id , $username = NULL) {
        $this->verifyUser($username); //die;
        $this->data['category_blog'] = $this->postmodel->getPostList($category_id,10);
        $this->data['category_id'] = $category_id;
        $this->data['category'] = $this->postmodel->getcategorieslist(8);
        $this->loadLayout($this->data, 'frontend/blog/category_detail');

    }
    public function post_detail($post_id , $username = NULL) {
        $this->verifyUser($username);
        $this->data['blog_detail'] = $this->postmodel->getPostInfo($post_id);
        $this->data['category'] = $this->postmodel->getcategorieslist(8);
        $tags = array("{base-url}","{image_base}");
        $replace = array(base_url(), 'https://staging3.karmora.com/public/');
        $this->data['post_content']        = str_replace($tags, $replace, $this->data['blog_detail']->post_content);
        $this->loadLayout($this->data, 'frontend/blog/post_detail');
    }
    public function savefeedbackpost($username = NULL) {
        $this->verifyUser($username); //die;
        $email_data = $this->commonmodel->getemailInfo(46);
        $tags = array("{content}");
        $replace = array($_POST['user_feedback']);
        $subject = $email_data->email_title;
        $message = $this->prepEmailContent($tags, $replace, $subject, $email_data->email_description, '', $email_data->email_header_text, 'withoutheader');
        $this->send_mail('usmana@karmora.com', $subject, $message);
        echo 'true';die;
    }

}
