<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reporting
 *
 * @author Usman
 */
class Cashmeoutmodel extends commonmodel {

    public function getMinCashoutAmount($userId) {
        $query = "SELECT cashout.user_account_cashout_property_amount AS 'amount'
            FROM tbl_user_account_type AS acc_type
            LEFT JOIN tbl_user_account_cashout_property AS cashout ON acc_type.fk_user_account_cashout_property_id = cashout.pk_user_account_cashout_property_id
            WHERE pk_user_account_type_id = get_user_account_type(:userId)";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($response) > 0 ? $response[0]['amount'] : FALSE;
    }

    public function getMemberAccountBalance($userId) {
        $query = "SELECT truncate(get_available_dollar_with_user_id(:userId),2) AS 'balance'";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($response) > 0 ? $response[0]['balance'] : FALSE;
    }

    public function getUserFullNameWithId($userId) {
        $query = "SELECT get_user_full_name(:userId) as 'full_name'";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($response) > 0 ? $response[0]['full_name'] : FALSE;
    }

    public function getstate() {

        $queryStr = 'SELECT state,state_id,state_code FROM view_city_state_country WHERE country_id = 1 GROUP BY state_id';
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getMemberCurrentAddress($member_id) {
        //echo $member_id.'me';
        $query = "SELECT ua.user_address_street_address AS 'address',ua.user_address_zip_code AS 'zipcode',
                ua.user_address_city_name AS 'city',us.user_address_state_title AS 'state',us.pk_user_address_state_id AS 'state_id'
                FROM tbl_user_address AS ua ,
                tbl_user_address_state AS us
                WHERE ua.user_address_current = 'true' AND us.pk_user_address_state_id = ua.fk_user_address_state_id
                AND ua.fk_users_id = :memberId"; 

        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':memberId', $member_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response) > 0 ? $response[0] : FALSE;
    }

    public function getAllActiveCharities() {
        $query = "SELECT pk_charity_id, fk_user_id, charity_name FROM tbl_charity";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($response) > 0 ? $response : FALSE;
    }

    public function insertGiftToCharity($param) {
        $karmoraCare = $this->getKarmoraCareMatch($param['amount']);
        $query = "INSERT INTO tbl_charity_donations 
            (fk_charity_id, fk_user_id, charity_donation_name, charity_donation_amount, charity_donation_amount_karmora_match,
                charity_donation_crate_date, charity_donation_status, charity_donation_type)
             VALUES ( :charityId, :userId, :fname, :amount, :amountCare, NOW(), :status, :type)"; 
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':charityId', $param['charity'], PDO::PARAM_INT);
        $statement->bindParam(':userId', $param['user_id'], PDO::PARAM_INT);
        $statement->bindParam(':fname', $param['fname'], PDO::PARAM_STR);
        $statement->bindParam(':amount', $param['amount'], PDO::PARAM_STR);
        $statement->bindParam(':amountCare', $karmoraCare, PDO::PARAM_STR);
        $statement->bindParam(':status', $param['status'], PDO::PARAM_STR);
        $statement->bindParam(':type', $param['type'], PDO::PARAM_STR);
        return $statement->execute() ? TRUE : FALSE;
    }
    
    public function insertKarmoraKashAward($param){
        $percent = $this->getKarmoraKashAwardPercent();
        if($percent > 0){
            $query = "INSERT INTO tbl_karmora_kash_account
                (fk_user_id, fk_user_id_from, kash_amount, kash_type, kash_description)
                VALUES (:userId, 0, :amount, 'Deposit', 'Gift Reward')";
            $statement = $this->db->conn_id->prepare($query);
            
            $amount = $param['donated_amount']*$percent/100;
            
            $statement->bindParam(':userId', $param['user_id'], PDO::PARAM_INT);
            $statement->bindParam(':amount', $amount, PDO::PARAM_STR);
            $statement->execute();
        }
        return;       
        
    }

    public function getCharityDetail($charityId) {
        $query = "SELECT * FROM tbl_charity WHERE pk_charity_id = :charatyId";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':charatyId', $charityId, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($response) > 0 ? $response[0] : FALSE;
    }

    public function insertCashoutRequest($param) {
        $query = "INSERT INTO tbl_user_cashout_request
            (user_cashout_request_amount, fk_user_id, user_cashout_request_name_on_cheque, user_cashout_request_street_address, 
            user_cashout_request_city, user_cashout_request_state, user_cashout_request_zipcode, user_cashout_request_phone, 
            user_cashout_request_status, user_cashout_request_create_date, fk_karmora_dollar_account_id, user_cashout_request_webcheque_id)
            VALUES ( :requestAmount, :userId, :nameOnCheque, :streetAddress, :city, 
            (SELECT user_address_state_title FROM tbl_user_address_state WHERE pk_user_address_state_id = :stateId),
            :zipCode, :phone, :status, NOW(), :dollarAccountId, :webChequeId)";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':requestAmount', $param['requestAmount'], PDO::PARAM_STR);
        $statement->bindParam(':userId', $param['userId'], PDO::PARAM_INT);
        $statement->bindParam(':nameOnCheque', $param['name'], PDO::PARAM_STR);
        $statement->bindParam(':streetAddress', $param['streetAddress'], PDO::PARAM_STR);
        $statement->bindParam(':city', $param['city'], PDO::PARAM_STR);
        $statement->bindParam(':stateId', $param['stateId'], PDO::PARAM_INT);
        $statement->bindParam(':zipCode', $param['zipCode'], PDO::PARAM_INT);
        $statement->bindParam(':phone', $param['phone'], PDO::PARAM_STR);
        $statement->bindParam(':status', $param['status'], PDO::PARAM_STR);
        $statement->bindParam(':dollarAccountId', $param['dollarAccountId'], PDO::PARAM_STR);
        $statement->bindParam(':webChequeId', $param['webChequeId'], PDO::PARAM_STR);
//        $statement->execute();
//        echo '<pre>';
//        var_dump($statement->errorInfo(), $statement->debugDumpParams());exit;
        return $statement->execute() ? $this->db->conn_id->lastInsertId() : FALSE;
    }

    public function getUserCashMeOutRequests($param) {
        $query = "SELECT user_cashout_request_create_date AS 'transaction_date', pk_user_cashout_request_id AS 'transaction_id', user_cashout_request_name_on_cheque AS 'FullName',
                CONCAT(user_cashout_request_street_address,', ',user_cashout_request_city,' ',user_cashout_request_zipcode,' ',user_cashout_request_state) AS 'FullAdrees',
                user_cashout_request_amount AS 'amount', user_cashout_request_status AS 'status'
            FROM tbl_user_cashout_request WHERE fk_user_id = :userId ORDER BY pk_user_cashout_request_id DESC";
        $statement = $this->db->conn_id->prepare($query);

        $statement->bindParam(':userId', $param['userId'], PDO::PARAM_INT);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($result) > 0 ? $result : FALSE;
    }

    public function getUserDonations($param) {
        $query = "SELECT cd.charity_donation_crate_date AS 'transaction_date', cd.pk_charity_donation_id AS 'transaction_id',  cd.charity_donation_name AS 'FullName',
            c.charity_name 'recipient', cd.charity_donation_amount AS 'amount', cd.charity_donation_status AS 'status'
            FROM tbl_charity_donations AS cd 
                LEFT JOIN tbl_charity AS c ON cd.fk_charity_id = c.pk_charity_id
                WHERE cd.fk_user_id = :userId
                ORDER BY cd.charity_donation_crate_date DESC";
            
        return $this->simpleQuerySingleParamInt($query, $param['userId']);
    }
    
//    private function
    
    private function getKarmoraCareMatch($amount) {
        $query = "select get_charity_setting_with_alias('care') as 'award'";
        $result = $this->simpleQuery($query);
        $response = $result != FALSE && count($result)>0 ? $amount * $result[0]['award'] / 100 : FALSE;
        return $response;
    }
    
    private function getKarmoraKashAwardPercent(){
        $query = "select get_charity_setting_with_alias('kash_award') as 'award'";
        $result = $this->simpleQuery($query);
        return $result != FALSE && count($result)>0 ? $result[0]['award'] : FALSE;
    }

//  simple query processing
    private function simpleQuery($query) {
        $statement = $this->db->conn_id->prepare($query);
               
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return count($result)>0 ? $result : FALSE;
    }
    
    private function simpleQuerySingleParamInt($query, $param) {
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $param, PDO::PARAM_INT);
        
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return count($result)>0 ? $result : FALSE;
    }

//    Discarded CashMeOut Model functions


    private function runDbQuery($query) {
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data > 0)) {
            $response = $data;
        } else {
            $response = false;
        }
        return $response;
    }

    public function getMemberTotalPayment($member_id) {

        $queryStr = "SELECT ca.*, TRUNCATE((SELECT get_user_total_pending_or_available(" . $member_id . ",'Available')),2)
					 AS total 
					 FROM tbl_user_cash_back AS ca WHERE fk_user_id=" . $member_id . " AND user_cash_back_status = 'Available'";

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getFundRasingMember($fo_id) {

        $queryStr = "SELECT *
					 FROM view_affiliate_banner_info  WHERE user_acc_type_id = " . $fo_id . "";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function validateCountryStateCity($cscData) {
        //var_dump($cscData);exit;
        $query = "SELECT * 
					FROM view_city_state_country AS csc 
    				WHERE csc.country_id = " . $cscData['countryId'] . " AND
    				csc.state_id = " . $cscData['stateId'] . " AND
    				csc.city = '" . $cscData['city'] . "' AND
    				csc.zipcode = " . $cscData['zipCode'];
        //echo $query;exit;
        $validate = $this->runDbQuery($query);
        //count($validate);exit;
        if (count($validate) !== 1) {
            $response = false;
        } else {
            $response = $validate[0];
        }
        return $response;
    }

    public function getCashMeMember($user_id) {

        $queryStr = "SELECT CASE 
                        WHEN (aw.fk_withdraw_type_id = 2)
                        THEN '-'
                        ELSE CONCAT(address.user_address_street_address, ' ',address.user_address_city_name ,' ',state.user_address_state_title)
                        END AS FullAdrees ,
                        CASE 
                        WHEN (aw.fk_withdraw_type_id = 2)
                        THEN (SELECT fundraising_name FROM tbl_users WHERE pk_user_id = aw.pay_to_id)
                        ELSE get_user_full_name(aw.pay_to_id)
                        END AS FullName ,  
            cash.pk_user_cashout_request_id AS transaction_id , 
            aw.fk_withdraw_type_id ,aw.amount, 
            cash.user_cashout_request_amount,
            cash.user_cashout_request_create_date AS transaction_date 
            FROM tbl_user_address AS address , 
            tbl_amount_withdraw AS aw , tbl_user_address_country AS country,tbl_user_address_state AS state , 
            tbl_users AS us , tbl_user_cashout_request AS cash 
            WHERE address.fk_users_id =" . $user_id . " 
            AND country.pk_user_address_country_id = address.fk_user_address_country_id 
            AND state.pk_user_address_state_id = address.fk_user_address_state_id 
            AND address.user_address_current = 'true' AND us.pk_user_id = " . $user_id . "  
            AND aw.fk_cash_out_request_id = cash.pk_user_cashout_request_id
            AND cash.fk_user_id = " . $user_id;

        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getaddressConfirmation($countryId, $stateId, $cityid, $zipcode) {
        //echo $countryId.'<br>'.$stateId.'<br>'.$cityName;exit;
        //if ($countryId !== null && $stateId !== null && $cityName !== null)
        //{
        $query = "SELECT city.user_address_city_title,state.user_address_state_title ,
                                country.user_address_country_title ,city.user_address_city_zip_code
                                FROM tbl_user_address_country AS country ,tbl_user_address_city AS city
                                ,tbl_user_address_state AS state 
                                WHERE city.pk_user_address_city_id = " . $cityid . " 
                                AND state.pk_user_address_state_id = " . $stateId . " 
                                AND city.user_address_city_zip_code = " . $zipcode . "
                                AND country.pk_user_address_country_id = " . $countryId . "";
        //die;
        //echo $query;exit;
        $response = $this->runDbQuery($query);
        //var_dump($response);
        //exit;
        //}
        //else
        //{
        //$response = false;
        //}
        return $response;
    }

    public function gettempdata($pk_user_id) {
        //echo $countryId.'<br>'.$stateId.'<br>'.$cityName;exit;
        //if ($countryId !== null && $stateId !== null && $cityName !== null)
        //{
        $query = "select * from tbl_cashback_temp where user_id = " . $pk_user_id . " ORDER BY cashme_tempory_pk_id DESC limit 1 ";
        //die;
        //echo $query;exit;
        $QueryR = $this->db->query($query);

        $row = $QueryR->row();

        return $row;
        //var_dump($response);
        //exit;
        //}
        //else
        //{
        //$response = false;
        //}
    }

    public function getFundRasinguser($fo_id) {

        $queryStr = "SELECT _name FROM view_affiliate_banner_info  WHERE _member_id = " . $fo_id . "";
        $queryRS = $this->db->query($queryStr);
        $row = $queryRS->row();
        echo $row;
        exit;

        return $row;
    }

    public function getAddress($cash_out_request_id) {
        $queryStr = "SELECT  CONCAT(address.user_address_street_address, ' ', address.user_address_city_name, ' ',state.user_address_state_title, ' ',country.user_address_country_title) AS FullAdrees 
                    FROM tbl_user_cashout_request AS cr
                    LEFT JOIN tbl_user_address AS address ON cr.fk_user_address_id = address.pk_user_address_id
                    LEFT JOIN tbl_user_address_state AS state ON address.fk_user_address_state_id = state.pk_user_address_state_id
                    LEFT JOIN tbl_user_address_country AS country ON address.fk_user_address_country_id = country.pk_user_address_country_id
                    WHERE cr.pk_user_cashout_request_id	=	$cash_out_request_id
                    ";

//        $queryStr = "SELECT 
//						CONCAT(address.user_address_street_address, ' ', city.user_address_city_title, ' ',state.user_address_state_title, ' ',country.user_address_country_title) AS FullAdrees 
//						FROM tbl_user_address AS address , tbl_user_address_city AS city, 
//						tbl_user_address_country AS country,tbl_user_address_state AS state 
//						WHERE address.fk_users_id =  " . $user_id . "
//						AND city.pk_user_address_city_id = address.fk_user_address_city_id 
//						AND country.pk_user_address_country_id = address.fk_user_address_country_id 
//						AND state.pk_user_address_state_id = address.fk_user_address_state_id 
//						AND address.user_address_current = 'true'
//						";  //die;

        $queryRS = $this->db->query($queryStr);

        $row = $queryRS->row();

        return $row;
    }

    public function getStateName($stateId) {

        $sql = "select * from tbl_user_address_state where pk_user_address_state_id = :stateId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':stateId', $stateId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($result) > 0 ? $result[0] : FALSE;
    }

    public function insertPaymentRecord($array) {

        $userId = $array['fk_user_id'];
        $payment_id = $array['payment_id'];
        $sql = "insert into tbl_payment_records set "
                . "fk_user_id = $userId,"
                . "payment_id   =   $payment_id";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function userW9formdetail($user_id) {

        $queryStr = "SELECT * FROM tbl_user_w9_form WHERE fk_user_id = ".$user_id." order by w9_form_date desc limit 1";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getuser_exclusive_commissions($user_id) {

        $queryStr = "SELECT * FROM `tbl_user_exclusive_commissions` WHERE `fk_user_id` = $user_id and 
                        `exclusive_commission_status` = 'Available'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }
    public function getuser_exclusive_commissions_from_sales($user_id) {

        $queryStr = "SELECT * FROM `tbl_sales` WHERE `fk_user_id` = $user_id 
                        and `sales_payment_type` != 'cashback' and sales_cashback_payment_status = 'available'";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

}
