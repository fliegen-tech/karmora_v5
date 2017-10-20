<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Commonmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getFounder($userId) {
        $query = "SELECT ulog.fk_user_account_type_id as user_account_type_id,u.pk_user_id AS userid,u.user_username AS username,u.user_subid AS subid,ac.user_account_type_title,u.*
			FROM 
				tbl_users AS u ,tbl_user_account_type AS ac,
				tbl_user_to_user_account_type_log AS ulog  
			WHERE ulog.fk_user_id = u.pk_user_id AND u.pk_user_id = $userId
			AND ac.pk_user_account_type_id = ulog.fk_user_account_type_id
			AND ac.user_account_type_status != 'Inactive' 
                        AND ulog.user_account_log_status !=  'Inactive'
                        GROUP BY u.pk_user_id"; //die;
        $queryRS = $this->db->query($query);
        $response = $queryRS->result_array();
//        echo '<pre>';        var_dump(reset($response)); die;
        return reset($response);
    }

    // function to get user details
    public function getUserDetails($username) {

        $sql = "SELECT ulog.fk_user_account_type_id,ac.user_account_type_title,u.* 
			FROM 
				tbl_users AS u ,tbl_user_account_type AS ac,
				tbl_user_to_user_account_type_log AS ulog  
			WHERE ulog.fk_user_id = u.pk_user_id AND u.user_username = :username 
			AND ac.pk_user_account_type_id = ulog.fk_user_account_type_id
			AND ac.user_account_type_status != 'Inactive'
                        AND ulog.user_account_log_status !=  'Inactive'
                        GROUP BY u.pk_user_id";
        $staement = $this->db->conn_id->prepare($sql);
        $staement->bindParam(':username', $username, PDO::PARAM_STR);

        $staement->execute();

        $data = $staement->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function isRecordAlreadyExist($record_field, $record, $record_id_field, $record_id, $table) {
        $query = 'SELECT * from ' . $table . ' WHERE ' . $record_field . '="' . $record . '" AND ' . $record_id_field . '!=' . $record_id;

        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function visitor_country() {
        $ip = $_SERVER["REMOTE_ADDR"];
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        $result = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))
                ->geoplugin_countryCode;
        return $result <> NULL ? $result : "Unknown";
    }

    public function verifyUser($username) {

        $query = "Select pk_user_id, user_subid from view_affiliate_banner_info where user_username='" . $username . "' AND user_status = 'Active'";

        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAccounttype($user_id) {

        $query = "Select fk_user_account_type_id from tbl_user_to_user_account_type_log where fk_user_id='" . $user_id . "' And user_account_log_status = 'Active' ";

        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function curPageURL() {
        $pageURL = 'http';
        if (@$_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public function checkUpgradeEnable($accTypeId) {
        $query = "SELECT ap.user_account_properties_account_upgrade AS 'allowed_upgrade'
					FROM tbl_user_account_properties AS ap
					JOIN tbl_user_account_type AS acc_type ON ap.pk_user_account_properties_id = acc_type.fk_user_account_properties_id
					WHERE acc_type.pk_user_account_type_id = '" . $accTypeId . "'";

        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data[0]['allowed_upgrade'];
        } else {
            $response = false;
        }
        return $response;
    }

    protected function prepQuery($query) {
        return $this->db->conn_id->prepare($query);
    }

    protected function lastInsertId() {
        return $this->db->conn_id->lastInsertId();
    }

    protected function errorInfo($statement) {
        $error = $statement->errorInfo();
        return $error[0] != 00000 ? $error[0] . ': ' . $error[2] : FALSE;
    }

}
