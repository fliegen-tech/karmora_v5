<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Homemodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getACSliders($acc_type_id) {
         $queryStr = " SELECT * FROM view_slider WHERE acc_type_id = :acc_type_id  ORDER BY banner_position ASC";
         $statment = $this->db->conn_id->prepare($queryStr);
         $statment->bindParam(':acc_type_id', $acc_type_id, PDO::PARAM_INT);
         $statment->execute();
         $result = $statment->fetchAll(PDO::FETCH_ASSOC);
         return count($result)>0 ? $result : FALSE;
         
    }
    public function getfeturedproduct() {
         $queryStr = " SELECT * FROM tbl_product order by pk_product_id desc limit 4 ";
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function checkimage($member_id) {
        $queryStr = " SELECT * FROM view_affiliate_banner_info_profile_picture WHERE id = " . $member_id. " AND profile_pic_status = 'Active'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getFeturdStores($acc_type_id) {
         $queryStr = " SELECT * FROM view_stores_list_featured WHERE acc_type_id = $acc_type_id
                        order by case when store_postion is null then 1 else 0 end, store_postion  "; 
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getTopCategoryStores($acc_type_id){
    	$query = "SELECT ls.store_id, ls.store_title, ls.cash_back_percentage, ls.category_alias
					FROM view_stores_list_stores AS ls
					WHERE ls.acc_type_id = $acc_type_id AND ls.top_store = 'active'";
    	$result = $this->db->query($query);
    	return $result->result_array();
    }
     public function GetfavourtiesStores($fk_user_id) {

        $query = "SELECT tbl_favorties.*,view_stores_list_stores.store_title 
					FROM tbl_favorties,view_stores_list_stores WHERE tbl_favorties.fk_user_id = ".$fk_user_id." 
					AND tbl_favorties.fk_store_id = view_stores_list_stores.store_id
					GROUP BY tbl_favorties.fk_store_id ORDER BY tbl_favorties.pk_favortie_id DESC LIMIT 5 ";

        $QueryR = $this->db->query($query);

        if ($QueryR->num_rows() > 0) {
            $array = $QueryR->result_array();
            return $array;
        } else {
            return false;
        }
    }
    public function getScirber($email){
        
        $queryStr    = "SELECT * from tbl_subscribers WHERE subscriber_email = '".$email."'";
        $queryRS     = $this->db->query($queryStr);
        if($queryRS->num_rows() > 0){
           return  $queryRS->row();
        }else{
           return '';
        }
    }
    public function getfetureddeals() {
         $queryStr = " SELECT * FROM tbl_product where product_is_deal = 1 and product_is_fetured = 1 order by pk_product_id desc limit 3 ";
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    
    public function getfetureddeals_with_cat($category_id) {
         $queryStr = " SELECT p.*,rc.fk_category_id FROM  tbl_product as p,
                        tbl_relation_product_with_category as rc 
                            WHERE rc.fk_product_id = p.pk_product_id
                                and rc.fk_category_id = $category_id
                                    group BY p.pk_product_id limit 3";
         $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getsidebar($account_type,$type, $limit = NULL) {
        $limitClause = is_null($limit) ?  '': ' limit '.$limit;
        $queryStr = "select `r_acc_type`.*,`badds`.* 
            from (`tbl_relation_with_user_account_type` `r_acc_type` 
            join `tbl_banner_ads` `badds` on((`r_acc_type`.`fk_table_name_id` = `badds`.`pk_banner_ads_id`))) 
            where ((`r_acc_type`.`relation_with_user_account_type_table_name` = 'tbl_banner_ads') and 
                (`r_acc_type`.`relation_with_user_account_type_status` = 'active') and 
                (`badds`.`banner_ads_status` = 1) and (`badds`.`banner_ads_banner_type` = :type)) and 
                r_acc_type.`fk_user_account_type_id`= :accountType order by badds.banner_ads_position asc $limitClause";
        
        $statement = $this->db->conn_id->prepare($queryStr);
        $statement->bindParam(':accountType', $account_type, PDO::PARAM_INT);
        $statement->bindParam(':type', $type, PDO::PARAM_INT);
        $statement->execute();
        $result = strcmp($type, 'sidebar') ?  $statement->fetchAll() : $statement->fetchObject() ;
                
        return count($result)>0 ? $result : '';
        
    }
    public function getstate($country_id){
    	$query = "SELECT *
					FROM tbl_user_address_state AS state
					WHERE state.fk_user_address_country_id = $country_id
					ORDER BY state.user_address_state_title
					";
    	$result = $this->db->query($query);
    	return $result->result_array();
    }

}

