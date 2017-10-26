<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trainingmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * will get all the records
     * @param integer $page [optional]
     * @param integer $limit [optional]
     * @return array of records
     */
    public function gettrainings() {

        $queryStr = " SELECT * from tbl_trainings";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else
            return '';
    }

   
// for user Type
    public function getUserAccountType() {
        $queryStr = " SELECT * FROM tbl_user_account_type";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getTrainingCategories(){
		$queryStr 	= " SELECT * from tbl_category Where category_parent_id = 103";
		$queryRS	= $this->db->query($queryStr);
                if($queryRS->num_rows() >0){
		   
		   return $queryRS->result_array();
		}else
			return '';	
                
                }
    public function getkarmoraTraining($cat_id) {

            $queryStr = " SELECT * from tbl_trainings where fk_category_id = $cat_id and training_status = 'Active'";
            $queryRS = $this->db->query($queryStr);
            if ($queryRS->num_rows() > 0) {
                return $queryRS->result_array();
            } else
                return '';
        }
    public function getcharities() {

        $queryStr = "SELECT tbl_charity.* ,tbl_users.user_username,tbl_users.user_first_name ,tbl_users.user_last_name FROM tbl_users,tbl_charity WHERE tbl_users.pk_user_id = tbl_charity.fk_user_id";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else
            return '';
    }  
    public function gettriplepromtions() {

        $queryStr = " SELECT * from tbl_tripple_karmora_cash_promtion";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else{
                return '';
            }
    }
    public function getCharityDetail($charityId) {
        $query = "SELECT tbl_charity.* ,tbl_users.user_username,tbl_users.user_email,tbl_users.user_first_name ,tbl_users.user_last_name FROM tbl_users,tbl_charity 
                    WHERE tbl_users.pk_user_id = tbl_charity.fk_user_id
                    and tbl_charity.pk_charity_id = $charityId
                  ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }
}
