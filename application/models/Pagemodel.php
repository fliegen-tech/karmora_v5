<?php

class Pagemodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //This function will fetch detail of all pages from DB
    function getAllPages() {
        $query = "SELECT c.*,d.page_title AS parent_title  FROM tbl_page c
						LEFT JOIN tbl_page d  ON c.page_parent_id = d.pk_page_id WHERE c.page_current_version=1 ORDER BY c.page_create_date DESC";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }



    //this function will fetch page details of a specific page from DB
    public function getSinglePageDetail($id) {
        $query = "SELECT * FROM tbl_page WHERE pk_page_id=" . $id . ";";
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    //this function will fetch page details of a specific page from DB
    public function getIntereatedpage($page_inheritance) {
        $query = "SELECT * FROM tbl_page WHERE page_inheritance != 'Last'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }

    public function getPageCategories() {
        $queryStr = " SELECT * from tbl_category Where category_parent_id=10";
        $queryRS = $this->db->query($queryStr);

        if ($queryRS->num_rows() > 0) {

            return $queryRS->result_array();
        } else
            return '';
    }
    
    public function getpagedetail($alias) {
        $query = "SELECT * FROM tbl_page WHERE page_alias = '".$alias."' and page_current_version = true";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

}

?>