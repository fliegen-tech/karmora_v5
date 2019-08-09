<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ShareModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 

	
	public function get_karmora_commercial_videos($acc_type_id) {
         $queryStr = "SELECT * FROM view_karmora_commercial WHERE acc_type_id = '".$acc_type_id."' GROUP BY video_id ORDER BY video_id DESC limit 4";
         $queryRS = $this->db->query($queryStr);
		if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }

    }

	public function get_alredy_contact($sender_id,$email) {
        $queryStr = "SELECT * FROM tbl_email_contacts WHERE sender_id = '".$sender_id."' and email = '".$email."'";
        $queryRS = $this->db->query($queryStr);
		if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getShopperInvited($userId) {
        $queryStr = "SELECT email FROM tbl_email_contacts WHERE sender_id = '" . $userId . "'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getShopperCommunity($userId) {
        $queryStr = "SELECT user_email FROM tbl_users WHERE fk_user_id_referrer= '" . $userId . "'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getaboutJoiningCommunity($userId) {

        $queryStr = "SELECT email FROM tbl_email_contacts
         WHERE sender_id = '" . $userId . "' AND  email NOT IN
         (SELECT user_email 
         FROM tbl_users)";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    
    public function getuseremailInfo($user_id) {

        $queryStr = "SELECT * from 
                     tbl_about_member where fk_user_id = ".$user_id;
       $queryRS = $this->db->query($queryStr);    
	if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function checkfundrasingorg($user_id) {

      $queryStr = "SELECT get_fundraising_org_of_with_user_id($user_id) AS user_id ;";
       $queryRS = $this->db->query($queryStr);    
	if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    
    public function getUserCampaign($user_id) {

       $queryStr = "SELECT * FROM tbl_compaign WHERE fk_user_id = ".$user_id." AND compaign_status='Active'";
       $queryRS = $this->db->query($queryStr);    
	if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    
    public function getCampaignEmail($emailType,$campaignId) {

       $queryStr = "SELECT * FROM tbl_compaign_email WHERE email_type= '".$emailType."' AND fk_compaign_id = ".$campaignId ;
       $queryRS = $this->db->query($queryStr);    
	if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getCampaignId($userID){
        $queryStr = 'SELECT *
                    FROM tbl_compaign
                    WHERE fk_user_id = get_fundraising_org_of_with_user_id('.$userID.') AND compaign_status = "ACTIVE" LIMIT 1;';
        $queryRS = $this->db->query($queryStr);    
	if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
        
    }
    public function get_contact_list($userId) {
        $queryStr = "SELECT ec.*,au.* FROM tbl_email_contacts AS ec ,tbl_email_automated AS au ,tbl_users AS us 
                        WHERE ec.sender_id = ".$userId." AND us.user_email != ec.email AND au.email_user_id = ".$userId."
                        AND ec.sender_id = us.pk_user_id
                        GROUP BY ec.pk_email_contact_id";
        $queryRS = $this->db->query($queryStr);
		if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }

    }
    public function get_auto_list($userId) {
        $queryStr = "SELECT * from tbl_email_automated where email_user_id = ".$userId;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }

    }
    public function getNextAutomail(){
        $queryStr = 'SELECT *
                    FROM tbl_email_automated
                    WHERE email_next_run_time < NOW()';
        $queryRS = $this->db->query($queryStr);    
	if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
        
    }

    public function getVideos($cat_id = null){
        $where = '';
        if($cat_id !==''){
            $where = ' and `vc`.`fk_category_id` = '.$cat_id;
        }
        $queryStr = "select `v`.`pk_video_id` AS `pk_video_id`,
                        `v`.`video_title` AS `video_title`,
                        `v`.`video_cover_photo` AS `video_cover_photo`,
                        `v`.`video_url` AS `video_url`
                     from (`tbl_video` `v` left join `tbl_video_to_category` `vc` on((`v`.`pk_video_id` = `vc`.`fk_video_id`)))
                     where `v`.`video_status` = 'active'".$where." order by `v`.`video_create_date` desc";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }

    }
    public function getCategoryList($filter = '') {
        $queryStr = "SELECT c.*,p.category_title as parent_title  FROM tbl_category c JOIN tbl_category p ON c.category_parent_id = p.pk_category_id  WHERE c.category_parent_id=$filter"
            . " ORDER BY c.pk_category_id asc";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

}

?>