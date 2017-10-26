<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usermodel
 *
 * @usamn
 */
class Usermodel extends commonmodel {

    public function __construct() {
        parent::__construct();
    }

    public function insertUserBasic($param) {
        $query = "INSERT INTO tbl_users (user_first_name, user_last_name, user_username , user_email ,user_password ,user_registration_ip_address , user_status , user_subid , fk_user_id_referrer  , user_registration_date) 
            VALUES (:fname, :lname, :username, :email, MD5(:pass), :ip_address, :status, :subid, :referrId, NOW())";
        $statement = $this->prepQuery($query);
        $this->bindParamUserBasic($statement, $param);
        if ($statement->execute()) {
            $response['query_status'] = TRUE;
            $response['user_id'] = $this->lastInsertId();
            in_array($param['acc_type'], array(3)) ?
                            $this->insertUserAccountType(array('user_id' => $response['user_id'], 'acc_type_id' => $param['acc_type'], 'status' => 'active')) : '';
        } else {
            $response['query_status'] = FALSE;
            $response['error_info'] = $this->errorInfo($statement);
        }
        return $response;
    }

    private function bindParamUserBasic($statement, $param) {
        $statement->bindParam(':fname', $param['fname'], PDO::PARAM_STR);
        $statement->bindParam(':lname', $param['lname'], PDO::PARAM_STR);
        $statement->bindParam(':username', $param['username'], PDO::PARAM_STR);
        $statement->bindParam(':email', $param['email'], PDO::PARAM_STR);
        $statement->bindParam(':pass', $param['password'], PDO::PARAM_STR);
        $statement->bindParam(':ip_address', $param['ip_address'], PDO::PARAM_STR);
        $statement->bindParam(':status', $param['status'], PDO::PARAM_STR);
        $statement->bindParam(':subid', $param['subid'], PDO::PARAM_STR);
        $statement->bindParam(':referrId', $param['referr_id'], PDO::PARAM_STR);
        return;
    }

    public function insertUserAccountType($param) {
        $query = "INSERT INTO tbl_user_to_user_account_type_log 
            (fk_user_id,  fk_user_account_type_id ,  user_account_log_status ,  user_account_log_create_date ) 
            VALUES (:userId, :accTypeId, :status, NOW())";
        $statement = $this->prepQuery($query);
        $statement->bindParam(':userId', $param['user_id'], PDO::PARAM_INT);
        $statement->bindParam(':accTypeId', $param['acc_type_id'], PDO::PARAM_INT);
        $statement->bindParam(':status', $param['status'], PDO::PARAM_STR);

        $statement->execute();
        return;
    }

    public function updateUsername($userId, $username) {
        $query = "UPDATE tbl_users SET user_username = :username WHERE pk_user_id = :userId";
        $statement = $this->prepQuery($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);

        if ($statement->execute()) {
            $response['query_status'] = TRUE;
        } else {
            $response['query_status'] = FALSE;
            $response['error_info'] = $statement->errorInfo();
        }
        return $response;
    }

    public function updateAuthId($userId, $authId) {
        $query = "UPDATE tbl_users SET user_authorize_net_sub_id = :authId WHERE pk_user_id = :userId";
        $statement = $this->prepQuery($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':authId', $authId, PDO::PARAM_STR);
        if ($statement->execute()) {
            $response['query_status'] = TRUE;
        } else {
            $response['query_status'] = FALSE;
            $response['error_message'] = $this->errorInfo($statement);
        }
        return $response;
    }

    public function getSignupPromo($promoId) {
        $query = "SELECT * FROM tbl_signup_promo WHERE pk_promo_id = :promoId";
        $statement = $this->prepQuery($query);
        $statement->bindParam(':promoId', $promoId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount() ? $statement->fetch(PDO::FETCH_ASSOC) : FALSE;
    }

    public function getuser_main_summary($user_id) {

        $query = "SELECT * from view_my_account_main_summary where pk_user_id = $user_id";
        $queryRS = $this->db->query($query);
        $response = $queryRS->num_rows() > 0 ? $queryRS->row() : '';
        return $response;
    }

    public function getuser_exective_summary($user_id) {

        $query = "SELECT * from view_my_account_exective_summary where pk_user_id = $user_id";
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function getUserorders($user_id) {

        $sql = "select * from view_my_orders where fk_user_id ='" . $user_id . "'";
        $queryRS = $this->db->query($sql);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function InsertAddress($userId, $data) {
        $query = "INSERT INTO tbl_user_address
            SET fk_users_id = :userId, user_address_street_address = :streeAddress, user_address_street_address_2 = :streeAddress_2,
            user_address_city_name = :city, user_address_zip_code = :zipCode, fk_user_address_state_id = :stateId,
            fk_user_address_country_id = :countryId, user_address_create_date = NOW(), user_address_current = 'false'";
        $statement = $this->prepQuery($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_STR);
        $statement->bindParam(':streeAddress', $data['address1'], PDO::PARAM_STR);
        $statement->bindParam(':streeAddress_2', $data['address2'], PDO::PARAM_STR);
        $statement->bindParam(':city', $data['city'], PDO::PARAM_STR);
        $statement->bindParam(':zipCode', $data['zip_code'], PDO::PARAM_STR);
        $statement->bindParam(':stateId', $data['state'], PDO::PARAM_STR);
        $statement->bindParam(':countryId', $data['country'], PDO::PARAM_STR);
        if ($statement->execute()) {
            $response['query_status'] = TRUE;
            $response['address_id'] = $this->lastInsertId();
        } else {
            $response['query_status'] = FALSE;
            $response['error_message'] = $this->errorInfo($statement);
        }
        return $response;
    }

    public function getuser_trackingdetail($user_id) {
        $queryStr = "SELECT *
                        FROM tbl_user_tracker 
                     WHERE fk_user_id = $user_id  
                     order by pk_user_tracker_id desc"; //die;
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getuser_persantage_summary($account_type) {

        $query = "SELECT us.user_acc_kash_settings_get_on_redemption_purchases_amount
                    FROM  `tbl_user_acc_kash_settings` AS us, tbl_user_account_type ac
                    WHERE us.user_acc_kash_settings_get_on_redemption_purchases =1
                    AND ac.fk_user_acc_kash_settings_id = us.`Pk_user_acc_kash_settings_id` 
                    AND ac.pk_user_account_type_id = $account_type LIMIT 1";
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    /*
     * Old usermodel start
     */

    public function editProfile($data) {
        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $phone = '';
        $userId = $data['userId'];
        $sql = "UPDATE tbl_users SET"
                . " `user_first_name`    =   '$fname',"
                . "`user_last_name` =   '$lname',"
                . "`user_email` =   '$email',"
                . "`user_phone_no`  =   '$phone'"
                . " where `pk_user_id`   =   $userId";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function changePassword($data, $id) {
        $password = md5($data['password']);
        $witoutmd5 = $data['password'];
        $sql = "Update tbl_users set user_password = '$password' , user_temp_data = '$witoutmd5' where pk_user_id = $id";
        $statement = $this->db->conn_id->prepare($sql);
        if ($statement->execute()) {
            return TRUE;
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

    public function updateAddress($data) {
        //set all previous address for user to false
        $setAllAddressInactiveQuery = "UPDATE tbl_user_address AS uadd SET uadd.user_address_current = 'false' WHERE uadd.fk_users_id = " . $data['userId'];
        //echo $setAllAddressInactiveQuery;exit;

        $statement = $this->db->conn_id->prepare($setAllAddressInactiveQuery);
        $statement->execute();
        // echo '========<pre>'; print_r($data); //die;

        $userId = $data['userId'];
        $streetAddress = $data['streetAddress'];
        $streetAddress_2 = $data['streetAddress_2'];
        $city = $data['city'];
        $zipCode = $data['zipCode'];
        $stateId = $data['stateId'];
        $countryId = $data['countryId'];
        $insertAddressQuery = "INSERT INTO tbl_user_address
                                SET 
                                    fk_users_id = :userId,
                                    user_address_street_address = :address1,
                                    user_address_street_address_2 = :streeAddress_2,
                                    user_address_city_name = :city,
                                    user_address_zip_code = :zipCode,
                                    fk_user_address_state_id = :stateId,
                                    fk_user_address_country_id = :countryId,
                                    user_address_create_date = NOW(),
                                    user_address_current = 'true'";
        $insertStatement = $this->db->conn_id->prepare($insertAddressQuery);

        $insertStatement->bindParam(':userId', $userId, PDO::PARAM_STR);
        $insertStatement->bindParam(':address1', $streetAddress, PDO::PARAM_STR);
        $insertStatement->bindParam(':streeAddress_2', $streetAddress_2, PDO::PARAM_STR);
        $insertStatement->bindParam(':city', $city, PDO::PARAM_STR);
        $insertStatement->bindParam(':zipCode', $zipCode, PDO::PARAM_STR);
        $insertStatement->bindParam(':stateId', $stateId, PDO::PARAM_STR);
        $insertStatement->bindParam(':countryId', $countryId, PDO::PARAM_STR);
        //echo $this->parms($insertAddressQuery, $data); die;
        //echo 'sad'.$insertStatement->errorInfo(); die;
        if ($insertStatement->execute()) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function validateCountryStateCity($cscData) {
        //var_dump($cscData);exit;
        $query = "SELECT * 
                    FROM view_user_address_current AS vuac
                    WHERE 
                    vuac.member_id = " . $cscData['userId'] . " AND
                    vuac.address = '" . $cscData['streetAddress'] . "' AND
                    vuac.address_2 = '" . $cscData['streetAddress_2'] . "' AND
                    vuac.city = '" . $cscData['city'] . "' AND
                    vuac.zip_code = " . $cscData['zipCode'] . " AND
                    vuac.state_id = " . $cscData['stateId'] . " AND
                    vuac.country_id = " . $cscData['countryId'];
        //echo $query; die;
        $validate = $this->runDbQuery($query);
        //echo count($validate);exit;
        if (count($validate) !== 1) {
            $response = false;
        } else {
            $response = $validate;
        }
        return $response;
    }

    public function getMemberCurrentAddress($member_id = null) {
        $response = '';
        if ($member_id !== null) {
            $query = "SELECT *
                        FROM view_member_address AS addr
                        WHERE addr.member_id = $member_id AND addr.address_current = 'true' LIMIT 1";
            $statement = $this->db->conn_id->prepare($query);
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($data) > 0) {
                $response['address'] = $data[0];
                //var_dump($response['address']);exit;
            } else {

                $response['address'] = FALSE;
                $response['statesOfCurrentAddressCountry'] = $this->getStatesofCountry(1);
            }
            //count($data)>0 ? $response['address'] = $data[0] : $response['address'] = false;
            /*
              if (count($data) > 0) {
              $response['address'] = $data[0];
              } else {
              $response['address'] = false;
              }
             * 
             */
        } else {
            $response['address'] = false;
        }

        $response['countriesList'] = $this->getCountries();
        $response['address'] !== false ?
                        $response['statesOfCurrentAddressCountry'] = $this->getStatesofCountry(1) :
                        //$response['statesOfCurrentAddressCountry'] = false;
                        /*
                          if ($response['address'] !== false) {
                          $response['statesOfCurrentAddressCountry'] = $this->getStatesofCountry($data[0]['country_id']);
                          } else {
                          $response['statesOfCurrentAddressCountry'] = false;
                          }
                         * 
                         */
                        $response['address'] !== false ?
                                $response['citiesOfCurrentAddressState'] = $this->getCitiesofStates($data[0]['country_id'], $data[0]['state_id']) :
                                $response['citiesOfCurrentAddressState'] = false;
        /*
          if ($response['address'] !== false) {
          $response['citiesOfCurrentAddressState'] = $this->getCitiesofStates($data[0]['country_id'], $data[0]['state_id']);
          } else {
          $response['citiesOfCurrentAddressState'] = false;
          }
         * 
         */
        /* echo'<pre>';
          print_r($response);
          exit; */

        return $response;
    }

    public function getCitiesofStates($countryId = null, $stateId = null) {
        if ($countryId !== null && $stateId !== null) {
            $query = "SELECT *
					FROM tbl_user_address_city AS city
					LEFT JOIN tbl_user_address_state AS state ON city.fk_user_address_state_id = state.pk_user_address_state_id
					WHERE city.fk_user_address_state_id = $stateId AND
							state.fk_user_address_country_id = $countryId
					ORDER BY city.user_address_city_zip_code ASC";

            $query1 = "SELECT DISTINCT city.user_address_city_title AS 'city_title'
					FROM tbl_user_address_city AS city
					LEFT JOIN tbl_user_address_state AS state ON city.fk_user_address_state_id = state.pk_user_address_state_id
					WHERE city.fk_user_address_state_id = $stateId AND
							state.fk_user_address_country_id = $countryId
					ORDER BY city.user_address_city_title
					";

            $response['city'] = $this->runDbQuery($query);
            $response['cityNames'] = $this->runDbQuery($query1);

            if ($response['cityNames'] !== false) {
                $first = true;
                foreach ($response['cityNames'] as $cityName) {
                    if ($first === true) {
                        reset($response['cityNames']);
                        $first = false;
                    }
                    $response['cityNames'][key($response['cityNames'])]['optionVal'] = $countryId . '-.-' . $stateId . '-.-' . $cityName['city_title'];
                    next($response['cityNames']);
                }
            }
            //var_dump($response['cityNames']);exit;
        } else {
            $response = false;
        }
        /* echo '<pre>';
          print_r($response);
          exit; */
        return $response;
    }

    public function getZipCodesOfCity($countryId = null, $stateId = null, $cityName = null) {
        //echo $countryId.'<br>'.$stateId.'<br>'.$cityName;exit;
        if ($countryId !== null && $stateId !== null && $cityName !== null) {
            $query = "SELECT *
					FROM tbl_user_address_city AS city
					LEFT JOIN tbl_user_address_state AS state ON city.fk_user_address_state_id = state.pk_user_address_state_id
					WHERE city.user_address_city_title = '" . $cityName . "' AND
							city.fk_user_address_state_id = $stateId AND
							state.fk_user_address_country_id = $countryId 					
					ORDER BY city.user_address_city_zip_code ASC";
            //echo $query;exit;
            $response = $this->runDbQuery($query);
            //var_dump($response);
            //exit;
        } else {
            $response = false;
        }
        return $response;
    }

    // get list of all Country States and Cities
    private function getCitySateCountryList() {
        $queryList['country'] = "SELECT *
								FROM tbl_user_address_country AS country
								WHERE country.user_address_status = 'active'
								ORDER BY state.user_address_state_title";
        $queryList['state'] = "SELECT *
							FROM tbl_user_address_state AS state
							WHERE 1
							ORDER BY state.user_address_state_title";
        $queryList['city'] = "SELECT *
							FROM tbl_user_address_city AS city
							WHERE 1
							ORDER BY state.user_address_state_title";
        $first = true;
        foreach ($queryList as $query) {
            if ($first) {
                reset($queryList);
                $first = false;
            }
            $reponse[key($queryList)] = $this->runDbQuery($query);
            next($queryList);
        }

        return $reponse;
    }

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

    // function to get user address in.
    // function to get user picture
    public function checkProfilePic($userId) {
        $sql = "select * from tbl_user_profile_picture where fk_user_id = $userId  AND profile_user_picture_status='Active'";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    // function to set profile picture
    public function setProfilePic($userId, $data) {
        $pic_name = $data['picname'];
        $user_id = $userId;
        $sql = "INSERT INTO  tbl_user_profile_picture  SET"
                . " `profile_user_picture_image_name`    =   :picname,"
                . "`fk_user_id` = " . $user_id;

        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':picname', $pic_name, PDO::PARAM_STR);
        // $statement->bindParam(':userid', $user_id, PDO::PARAM_INT);
        //$statement->bindParam(':id',$userId,  PDO::PARAM_INT);
        // echo $this->parms($sql, $data);
        echo $this->parms($sql, $data);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updatePhone($userId, $phone) {
        $sql = "update tbl_users set `user_phone_no` = :phone where pk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUserEmails($userId) {
        $sql = "SELECT * FROM tbl_email_type_to_user_relation, tbl_email_type WHERE tbl_email_type_to_user_relation.fk_email_type_id = tbl_email_type.pk_email_type_id
AND tbl_email_type_to_user_relation.fk_user_id = $userId GROUP BY tbl_email_type_to_user_relation.fk_email_type_id";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getCurrentEmails($userId) {
        $sql = "SELECT fk_email_type_id FROM tbl_email_type_to_user_relation WHERE tbl_email_type_to_user_relation.fk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function changeEmailSub($string, $userId) {
        $sqlInactive = "UPDATE tbl_email_type_to_user_relation SET email_type_to_user_relation_status = 'Inactive' WHERE fk_user_id = $userId AND fk_email_type_id
NOT IN ($string)";
        $statementInactive = $this->db->conn_id->prepare($sqlInactive);
        if ($statementInactive->execute()) {
            $sqlActive = "UPDATE tbl_email_type_to_user_relation SET email_type_to_user_relation_status = 'Active' WHERE fk_user_id = $userId AND fk_email_type_id
 IN ($string)";
            $statementActive = $this->db->conn_id->prepare($sqlActive);
            $statementActive->execute();
        }

        return TRUE;
    }

    public function changeEmailAll($userId) {
        $sql = "update tbl_email_type_to_user_relation SET email_type_to_user_relation_status = 'Inactive' WHERE fk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
    }

    public function validateCountryStateCityforcheckout($cscData) {
        //var_dump($cscData);exit;
        $query = "SELECT * 
                    FROM view_user_address_current AS vuac
                    WHERE 
                    vuac.member_id = " . $cscData['userId'] . " AND
                    vuac.address = '" . $cscData['streetAddress'] . "' AND
                    vuac.address_2 = '" . $cscData['streetAddress_2'] . "' AND
                    vuac.city = '" . $cscData['city'] . "' AND
                    vuac.zip_code = " . $cscData['zipCode'] . " AND
                    vuac.state_id = " . $cscData['stateId'] . " AND
                    vuac.country_id = " . $cscData['countryId'];
        //echo $query;
        $validate = $this->runDbQuery($query);
        //echo count($validate);exit;
        if (count($validate) !== 1) {
            $response = false;
        } else {
            $response = $validate['address_id'];
        }
        return $response;
    }

    public function insertShiipingAddress($data) {
        $userId = $data['userId'];
        $streetAddress = $data['streetAddress'];
        $streetAddress_2 = $data['streetAddress_2'];
        $city = $data['city'];
        $zipCode = $data['zipCode'];
        $stateId = $data['stateId'];
        $countryId = $data['countryId'];
        $insertAddressQuery = "INSERT INTO tbl_user_address
                                SET 
                                    fk_users_id = :userId,
                                    user_address_street_address = :streeAddress,
                                    user_address_street_address_2 = :streeAddress_2,
                                    user_address_city_name = :city,
                                    user_address_zip_code = :zipCode,
                                    fk_user_address_state_id = :stateId,
                                    fk_user_address_country_id = :countryId,
                                    user_address_create_date = NOW(),
                                    user_address_current = 'false'";
        $insertStatement = $this->db->conn_id->prepare($insertAddressQuery);

        $insertStatement->bindParam(':userId', $userId, PDO::PARAM_STR);
        $insertStatement->bindParam(':streeAddress', $streetAddress, PDO::PARAM_STR);
        $insertStatement->bindParam(':streeAddress_2', $streetAddress_2, PDO::PARAM_STR);
        $insertStatement->bindParam(':city', $city, PDO::PARAM_STR);
        $insertStatement->bindParam(':zipCode', $zipCode, PDO::PARAM_STR);
        $insertStatement->bindParam(':stateId', $stateId, PDO::PARAM_STR);
        $insertStatement->bindParam(':countryId', $countryId, PDO::PARAM_STR);

        if ($insertStatement->execute()) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function getMemberPhoneno($id) {
        $query = "select user_phone_no from tbl_users where pk_user_id=" . $id;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getUserordernumber($id) {
        $query = "select order_numbr from tbl_oders where fk_user_id=" . $id . " ORDER BY pk_order_id Desc limit 1";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getbounckarmoracash($slug, $account_type) {
        $query = "SELECT bc.*,rbc.*
                    FROM `tbl_bonus_karmora_cash` as bc, tbl_relation_bonus_karmora_cash as rbc 
                    WHERE 
                    bc.pk_bonus_karmora_cash =
                    rbc.fk_bonus_karmora_cash_id
                    and rbc.fk_accont_type_id = $account_type
                    and bc.bonus_slug = '" . $slug . "' limit 1";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getuserCouponDetail($coupons_code) {
        $query = "SELECT * from tbl_coupon_users where  coupons_code = '" . $coupons_code . "' and coupons_status != 'InActive' limit 1";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function set_kk_on_personal_exclusive_purchase($order_id) {
        $query = "SELECT set_kk_on_personal_exclusive_purchase($order_id)";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function updateAddressLimted($data) {
        //set all previous address for user to false
        $setAllAddressInactiveQuery = "UPDATE tbl_user_address AS uadd SET uadd.user_address_current = 'false' WHERE uadd.fk_users_id = " . $data['userId'];
        //echo $setAllAddressInactiveQuery;exit;

        $statement = $this->db->conn_id->prepare($setAllAddressInactiveQuery);
        $statement->execute();
        $datas = array(
            'fk_users_id' => $data['userId'],
            'user_address_street_address' => $data['streetAddress'],
            'user_address_street_address_2' => $data['streetAddress_2'],
            'user_address_city_name' => $data['city'],
            'user_address_zip_code' => $data['zipCode'],
            'fk_user_address_state_id' => $data['stateId'],
            'fk_user_address_country_id' => $data['countryId'],
            'user_address_create_date' => 'NOW()',
            'user_address_current' => 'true'
        );
        $this->db->insert('tbl_user_address', $datas);
        //echo '<pre>'; print_r($datas);echo $this->db->last_query();
        $address_id = $this->db->insert_id();

        return $address_id;
    }

    public function getwebinar_registration($email) {
        $query = "SELECT * from tbl_webinar_registration where webinar_registration_email = '" . $email . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getalreadyemail($email) {
        $query = "SELECT user_email from tbl_users where user_email = '" . $email . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    /*
     * Old usermodel end
     */
}
