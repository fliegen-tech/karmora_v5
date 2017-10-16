<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PostModel extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
 
     public function getPostList($cat_id,$limit) {
       if($cat_id=='all'){
			$sql = "SELECT p.*,DATEDIFF(NOW(), p.post_create_datetime) as ago,GROUP_CONCAT(DISTINCT c.category_title SEPARATOR ',') 
			 	AS `cats`, 
				COUNT(DISTINCT bc.pk_comment_id) AS count_coment
				FROM tbl_blog_posts AS p 
				LEFT JOIN tbl_category AS c ON FIND_IN_SET(c.pk_category_id, p.categories) != 0 
				LEFT JOIN tbl_blog_comments AS bc ON bc.fk_post_id=p.pk_post_id
				WHERE p.STATUS='Published' 
				GROUP BY p.pk_post_id ORDER BY  p.post_create_datetime DESC LIMIT ".$limit;
		
			}else{
				
		    $sql = "SELECT p.*,DATEDIFF(NOW(), p.post_create_datetime) as ago ,GROUP_CONCAT(DISTINCT c.category_title SEPARATOR ',')
				 AS `cats`, 
				COUNT(DISTINCT bc.pk_comment_id) AS count_coment
				FROM tbl_blog_posts AS p 
				LEFT JOIN tbl_category AS c ON FIND_IN_SET(c.pk_category_id, p.categories) != 0 
				LEFT JOIN tbl_blog_comments AS bc ON bc.fk_post_id=p.pk_post_id
				WHERE p.STATUS='Published'  AND FIND_IN_SET('".$cat_id."',categories)
				GROUP BY p.pk_post_id ORDER BY  p.post_create_datetime DESC LIMIT ".$limit;
			}
         $queryRS = $this->db->query($sql);
         if ($queryRS->num_rows() > 0) {
             return $queryRS->result_array();
         } else {
             return '';
         }
    }

	public function getPostCategories() {
        $queryStr = "SELECT * from tbl_category Where category_parent_id=8";
        $queryRS = $this->db->query($queryStr);
		if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }

    }

	//this function will fetch page details of a specific page from DB
    public function getPostInfo($post_id) {
       $query = "SELECT p.*,CONCAT(ao.admin_operator_first_name,' ',ao.admin_operator_last_name) 
					as username FROM tbl_blog_posts p,tbl_admin_operator ao 
					WHERE ao.pk_admin_operator_id=p.fk_user_id AND pk_post_id = ".$post_id ;
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }
	public function getCatIdByAlias($alias) {
     $query = "SELECT pk_category_id,category_title FROM tbl_category WHERE category_alias ='".$alias."'";
		
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }
	
	function get_blog_Comments($post_id){
			 $queryStr   = 'SELECT tbl_blog_comments.*,CONCAT(u.user_first_name," ",u.user_last_name) AS name,view_affiliate_banner_info_profile_picture.profile_pic AS profile_image 
                                                FROM tbl_blog_comments,view_affiliate_banner_info_profile_picture,tbl_users u WHERE tbl_blog_comments.fk_post_id = '.$post_id.'
                                                AND tbl_blog_comments.fk_user_id = view_affiliate_banner_info_profile_picture.id
                                                AND u.pk_user_id=tbl_blog_comments.fk_user_id
                                                 AND tbl_blog_comments.status="Published"
                                                 AND view_affiliate_banner_info_profile_picture.profile_pic_status ="Active"';
					
				$queryRS	= $this->db->query($queryStr);
				if($queryRS->num_rows() > 0){
				   return $queryRS->result_array();
				}else{
				  return '';
				}
	}
    public function getcategorieslist($parent_cat_id) {
        $query = "SELECT * FROM tbl_category WHERE category_parent_id = ".$parent_cat_id . " ORDER BY pk_category_id DESC ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return '';
        }
    }
}

?>