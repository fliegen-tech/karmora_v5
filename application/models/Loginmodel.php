<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Loginmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * will check if userneme n pass match
     *
     * @param string $username
     * @param string $password
     * @return Boolean true in case of exists else return false
     */
    public function verifyUser($username, $password) {
        $sql = "SELECT * FROM tbl_admin_operator where admin_operator_username =  :username  AND admin_operator_password =  :password ";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) >= 1) {

            return $data;
        } else {

            return FALSE;
        }
    }
    
    public function frontendVerifyUser($username, $password) {
          $queryStr = " SELECT u.*,lg.fk_user_account_type_id as account_type_id FROM tbl_users u, tbl_user_to_user_account_type_log lg
	   				 WHERE u.pk_user_id=lg.fk_user_id AND (user_email = '" . $username . "' OR user_username= '" . $username . "')
					 AND user_password='" . $password . "'
                                         AND lg.user_account_log_status !=  'Inactive' 
                        "; //die;



        $statement = $this->db->conn_id->prepare($queryStr);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }
    public function GetsearchRefreal($search_valued ,$search_option) {
        $search_value = str_replace('%20', ' ', $search_valued); 
        if($search_option == 'name'){
            $condation = "info._name LIKE  '" . $search_value . "%'";
        }else{
            $condation = "info.user_username = $search_value ";
        }
        
        $query = "SELECT info . * , loc.country_state, loc._member_location
                    FROM view_affiliate_banner_info AS info
                    LEFT JOIN view_affiliate_banner_info_location AS loc ON info.pk_user_id = loc._member_id
                    WHERE $condation
                    GROUP BY info.pk_user_id
                    LIMIT 0 , 130"; 

        $QueryR = $this->db->query($query);

        $array = $QueryR->result_array();

        return $array;
    }
    
    public function getuserDetail($user_id) {
        $queryStr = " SELECT u.*,lg.fk_user_account_type_id as account_type_id FROM tbl_users u, tbl_user_to_user_account_type_log lg
	   				 WHERE u.pk_user_id=lg.fk_user_id AND u.pk_user_id = $user_id
					 ";
        $statement = $this->db->conn_id->prepare($queryStr);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }


}
