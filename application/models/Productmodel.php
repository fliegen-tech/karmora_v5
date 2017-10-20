<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }


    public function getproductdetail($pk_product_id) {
        $queryStr = " SELECT * FROM tbl_product WHERE pk_product_id = ".$pk_product_id;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getproducts() {
        $queryStr = " SELECT * FROM tbl_product";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }


    public function getproductsBycat($category_id,$limit = NULL) {
        $queryStr = "SELECT p.*,rep.* FROM  tbl_product as p , tbl_relation_product_with_category as rep
                        WHERE rep.fk_product_id = p.pk_product_id
                        and rep.fk_category_id = ".$category_id." limit $limit ";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getproductdetail_withAccountType($pk_product_id) {
         $queryStr = "SELECT tbl_product.*, rc.fk_category_id FROM tbl_relation_product_with_category as rc ,tbl_product 
                          WHERE rc.fk_product_id = tbl_product.pk_product_id
                                    and tbl_product.pk_product_id = $pk_product_id
                                    group BY tbl_product.pk_product_id
                        ";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getproductpriceCart($pk_product_id,$account_type) {
        $queryStr = "SELECT p.*,view_single_product_pricing.*
                            FROM tbl_product as p , view_single_product_pricing
                            WHERE view_single_product_pricing.pk_product_id = p.pk_product_id
                            and view_single_product_pricing.fk_user_account_type_id = $account_type
                            and p.pk_product_id = $pk_product_id
                        GROUP by p.pk_product_id
                        limit 1";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getproductsWithcat($category_id) {
        $queryStr = "SELECT p.*,rep.* FROM  tbl_product as p , tbl_relation_product_with_category as rep
                        WHERE rep.fk_product_id = p.pk_product_id
                        and rep.fk_category_id = ".$category_id;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getproductAlbum($pk_product_id) {
         $queryStr = "SELECT * FROM tbl_product_album	 
                        WHERE `fk_product_id` = $pk_product_id 
                        order BY `pk_product_album_id` DESC LIMIT 3";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getproduct_price_account_type($product_id,$account_type) {
        $queryStr = " SELECT p . * , ac.user_account_type_title
                        FROM  `view_single_product_pricing` AS p, tbl_user_account_type AS ac
                        WHERE p.`fk_user_account_type_id` = ac.pk_user_account_type_id 
                        and  p.pk_product_id = $product_id And p.fk_user_account_type_id = $account_type ORDER BY p.`fk_user_account_type_id` ASC limit 1";
        $queryRS = $this->db->query($queryStr);
        if($queryRS->num_rows() > 0){
            return  $queryRS->row();
        }else{
            return '';
        }
    }
 }

