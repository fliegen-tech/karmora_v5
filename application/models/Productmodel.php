<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productmodel extends Commonmodel {

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
    public function getproducts($status = '%') {
        $query = "SELECT * FROM tbl_product WHERE product_status LIKE :status";
        $statement = $this->prepQuery($query);
        $statement->bindParam(':status', $status, PDO::PARAM_STR);
        $statement->execute();
        return $statement->rowCount() > 0 ? $statement->fetchAll(PDO::FETCH_ASSOC) : FALSE;
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


    /// admin section started

    //This function will fetch detail of all product from DB
    public function getAllproduct() {

        $queryStr = " SELECT * FROM tbl_product ORDER BY product_create_date DESC";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getEditproduct($product_id) {

        $query = "SELECT * FROM tbl_product Where pk_product_id = " . $product_id;
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    // function for PDO
    public function add($data) {

        $sql = "INSERT INTO tbl_product SET "
            . "product_title =   :product_title,"
            . "product_is_fetured =   :product_is_fetured,"
            . "product_sku =   :product_sku,"
            . "product_idst_sku  =   :product_idst_sku,"
            . "product_detail    =   :product_detail,"
            . "product_price   =   :product_price,"
            . "product_status   =   :product_status,"
            . "product_create_date   =   :product_create_date";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':product_title', $data['product_title'], PDO::PARAM_STR);
        $statement->bindParam(':product_is_fetured', $data['product_is_fetured'], PDO::PARAM_STR);
        $statement->bindParam(':product_sku', $data['product_sku'], PDO::PARAM_STR);
        $statement->bindParam(':product_idst_sku', $data['product_idst_sku'], PDO::PARAM_STR);
        $statement->bindParam(':product_detail', $data['product_detail'], PDO::PARAM_STR);
        $statement->bindParam(':product_price', $data['product_price'], PDO::PARAM_STR);
        $statement->bindParam(':product_status', $data['product_status'], PDO::PARAM_STR);
        $statement->bindParam(':product_create_date', $data['product_create_date'], PDO::PARAM_STR);
        //echo $this->parms($sql, $data); die;
        if ($result = $statement->execute()) {
            $inserId = $this->db->conn_id->lastInsertId();
            return $inserId;
        } else {
            return FALSE;
        }
    }

    // function to debug PDO queries
    private function parms($string, $data) {
        $indexed = $data == array_values($data);
        foreach ($data as $k => $v) {
            if (is_string($v))
                $v = "'$v'";
            if ($indexed)
                $string = preg_replace('/\?/', $v, $string, 1);
            else
                $string = str_replace(":$k", $v, $string);
        }
        return $string;
    }

    public function getProductCategories(){
        $queryStr 	= " SELECT * from tbl_category Where category_parent_id = 94";
        $queryRS	= $this->db->query($queryStr);

        if($queryRS->num_rows() >0){

            return $queryRS->result_array();
        }else
            return '';

    }
    public function getAccountTypes(){
        $queryStr 	= " SELECT * from tbl_user_account_type Where user_account_type_status = 'Active'";
        $queryRS	= $this->db->query($queryStr);

        if($queryRS->num_rows() >0){

            return $queryRS->result_array();
        }else
            return '';

    }
    public function getEditProductCategories($id) {
        $queryStr = " SELECT * FROM tbl_relation_product_with_category where fk_product_id = " . $id ;

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }


    public function getproductToAccTypeRelation($product_id ,$accType){

        $query = "SELECT * FROM tbl_product_to_user_account_type AS sa WHERE sa.fk_product_id = $product_id AND sa.fk_user_account_type_id = $accType";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if(count($data)>0) {
            $response =  TRUE;
        }
        else {
            $response = FALSE;
        }
        return $response;
    }
    public function getAccountToProduct($product_id) {
        $query = "SELECT r.*,a.user_account_type_title as account_title,
                        r.product_to_user_account_type_commission_percentage as com_per 
                    FROM tbl_product s,tbl_user_account_type a,tbl_product_to_user_account_type r
                    WHERE s.pk_product_id =r.fk_product_id  AND a.pk_user_account_type_id = r.fk_user_account_type_id
                      AND s.pk_product_id = $product_id group by r.fk_user_account_type_id";

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }

    // deal section
    public function getAlldeal() {

        $queryStr = " SELECT * FROM tbl_deal ORDER BY pk_deal_id DESC";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getQuestion() {
        $queryStr = " SELECT * FROM tbl_review_qusetion where review_status = 'active' " ;

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getproductAlbumAdmin($product_id){
        $queryStr 	= " SELECT * from tbl_product_album Where fk_product_id = $product_id ";
        $queryRS	= $this->db->query($queryStr);
        if($queryRS->num_rows() >0){
            return $queryRS->result_array();
        }else{
            return '';
        }
    }
 }

