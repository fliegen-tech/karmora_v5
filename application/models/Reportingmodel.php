<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reporting
 *
 * @author Baig
 */
class ReportingModel extends commonmodel {

    public function getKashBack($userid, $month = NULL, $year = NULL) {
        if ($month === NULL) {
            $month = date('m');
        }
        if ($year === NULL) {
            $year = date('Y');
        }

        $sql = "SELECT DATE_FORMAT(CAST(cb.date AS DATE), '%m-%d-%Y') AS 'date', 
                    cb.advertiser_name, 
                    cb.product_description, 
                    cb.purchase_amount,
                    cb.kash_back_percentage, 
                    cb.kash_back, 
                    cb.status 
                FROM view_my_cash_back AS cb 
                WHERE cb.member_id = $userid"
                . " AND MONTH(cb.date) = $month"
                . " AND YEAR(cb.date) = $year";
        //echo $sql;exit;
        $statement = $this->db->conn_id->prepare($sql);
        //$statement->bindParam(':username', $username, PDO::PARAM_STR);
        //$statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
            ;
        }
    }

    public function getCommunity($userid) {
        $sql = "SELECT *, DATE_FORMAT(DATE(join_date),'%m-%d-%Y') AS join_date FROM view_my_community WHERE referrer = $userid";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return $data;
            ;
        } else {
            return FALSE;
        }
    }

    public function goodKarmora($userid, $month = NULL, $year = NULL) {
        if ($month === NULL) {
            $month = date('m');
        }
        if ($year === NULL) {
            $year = date('Y');
        }
        $sql = "SELECT purchase_date,"
                . " community_member, "
                . "membership_level,"
                . "shopper_cash_back,"
                . " override_bonus_percentage, "
                . "good_karmora_bonus, "
                . "status "
                . "FROM view_good_karmora_bonus "
                . "WHERE cash_back_to = $userid AND "
                . "SUBSTRING_INDEX(purchase_date,'-',1) = $month AND "
                . "SUBSTRING_INDEX(purchase_date,'-',-1) = $year "
                . "ORDER BY purchase_date ASC";

        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function yearToDateCashBack($userid) {

        $sql = "SELECT DATE(cb.date) AS 'date',  cb.kash_back"
                . " FROM view_my_cash_back AS cb "
                . "WHERE cb.member_id = $userid AND ((`date` BETWEEN  DATE_FORMAT(NOW() ,'%Y-01-01') AND CURRENT_TIMESTAMP() ))";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function yearToDateGoodKarmora($userid) {

        $sql = "SELECT DATE(purchase_date) AS purchase_date, SUM( good_karmora_bonus) as ytd_good_karmora, "
                . "STATUS FROM view_good_karmora_bonus "
                . "WHERE cash_back_to = $userid AND "
                . "CAST(CONCAT( return_date_part(purchase_date, 'year'),'-',
		return_date_part(purchase_date, 'month'),'-',
		return_date_part(purchase_date, 'day')) AS DATE) BETWEEN DATE_FORMAT(NOW() ,'%Y-01-01') AND CURRENT_TIMESTAMP()";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getAvailableEarnings($memberId) {
        $sql = "SELECT *
                FROM view_affiliate_banner_info_earning_details AS v_ed
                WHERE v_ed.member_id = $memberId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data[0];
        } else {
            $response = FALSE;
        }
        return $response;
        }

        //    old function name getUserAccountType
        public function getAffiliateBannerInfo($memeberId){
        $query = "SELECT * FROM view_affiliate_banner_info WHERE _member_id = $memeberId";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data[0]['user_account_type_title'];
        } else {
            $response = FALSE;
        }
        return $response;
    }

    public function getMemberCashedOutAmmount($memberId) {
        $query = "SELECT CONCAT('$ ',TRUNCATE(SUM(cb.user_cash_back_amount),2)) AS amount_cashed_out
                    FROM tbl_user_cash_back AS cb
                    WHERE cb.user_cash_back_status = 'Cashed out' AND cb.fk_user_id = $memberId
                    GROUP BY cb.fk_user_id";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data[0]['amount_cashed_out'];
        } else {
            $response = FALSE;
        }
        return $response;
    }

    public function getFundraisingGoodKarmora($userId, $accTypeId) {
        $whereClause = '';
        switch ($accTypeId) {
            case 6: {
                    $whereClause = 'fvgk.cash_back_to = ' . $userId;
                    break;
                }
            case 7: {
                    $whereClause = 'fvgk.cash_back_from = ' . $userId;
                    break;
                }
            case 9: {
                    $whereClause = 'fvgk.actual_cash_back_from = ' . $userId;
                    break;
                }
        }
        $sql = "select *, SUM(TRUNCATE(fvgk.good_karmora_bonus,2)) AS total_bonus 
                        from fundraising_view_good_karmora_bonus as fvgk
                        where $whereClause
                        group by fvgk.cash_back_from, fvgk.actual_cash_back_from";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getAmbassadorDetail($userId) {
        $sql = "select user_first_name, user_last_name, DATE(user_registration_date) as join_date from tbl_users where pk_user_id = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_member_compaign_targets($user_id) {
        $queryStr = "SELECT comp.pk_compaign_id ,compaintaget.*
                        FROM fundraising_view_member_compaign_targets AS compaintaget , tbl_compaign AS comp
                        WHERE comp.fk_user_id = compaintaget.fk_user_id_referrer 
                        AND comp.compaign_status = 'Active'
                        AND compaintaget.pk_user_id = " . $user_id;
        $result = $this->db->query($queryStr);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function gealredycompainTarget($user_id, $pk_compaign_id) {
        $queryStr = "SELECT *
                        FROM tbl_compaign_targets 
                        WHERE fk_compaign_id = " . $pk_compaign_id . " 
                        AND fk_user_id_assigned_to = " . $user_id;
        $result = $this->db->query($queryStr);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return '';
        }
    }

    public function getSummaryEarningsforYear($user_id = NULL, $year = NULL) {
        $year === NULL ? $year = date('Y') : '';
        if ($user_id !== NULL) {
            $response['cash_back'] = $this->getSummaryofCashBackforYear($user_id, $year);
            $response['good_karmora_bonus'] = $this->getSummaryofGoodKarmoraBonusforYear($user_id, $year);
        } else {
            $response = FALSE;
        }

        //var_dump($response);exit;
        return $response;
    }

    private function getSummaryofCashBackforYear($user_id, $year) {

        $query = "SELECT * FROM view_summary_my_cash_back WHERE member_id = $user_id AND _year = $year";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data;
        } else {
            $response = FALSE;
        }
        return $response;
    }

    private function getSummaryofGoodKarmoraBonusforYear($user_id, $year) {
        $businessId = $this->commonmodel->get_business_id_for_user_account_type_with_user_id($user_id);
        switch ($businessId) {
            case 1:
                $table = 'view_summary_good_karmora_com';
                break;
            case 2:
                $table = 'view_summary_good_karmora_fo';
                break;
        }

        $query = "SELECT * FROM $table WHERE member_id = $user_id AND _year = $year";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data;
        } else {
            $response = FALSE;
        }
        return $response;
    }

    public function getTotalMembers($userId) {
        $sql = "select SUM(community_count) as total_members from view_my_community where `referrer` = $userId";
        $statement = $this->db->conn_id->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0]['total_members'];
        } else {
            return FALSE;
        }
    }

    public function getUserShoppingCommunity($user_id) {
        $queryStr = "SELECT DATE_FORMAT(user_registration_date, '%m/%d/%Y') AS 'join_date',
                        CONCAT(user_first_name,' ', user_last_name) AS 'name',
                        get_referrer_member_relation_level($user_id, pk_user_id) AS 'floor',
                        get_user_account_type_title_with_user_id(pk_user_id) AS 'membership_status'
                        FROM tbl_users
                        WHERE FIND_IN_SET(pk_user_id, get_all_referrals_for_allowed_levels_with_user_id($user_id))
                        ORDER BY user_registration_date, FLOOR ASC";
        $queryRS = $this->db->query($queryStr);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getUsermycashback($user_id, $month, $year) {
        $condation = '';
        if ($month != '') {
            $condation = "AND MONTH(STR_TO_DATE(date, '%m/%d/%Y')) = $month";
        }
        if ($year != '') {
            $condation.= " AND YEAR(STR_TO_DATE(date, '%m/%d/%Y')) = $year";
        }
        $query = "SELECT * from view_ewallet_my_cash_back where fk_user_id = :userId  ORDER BY pk_user_cash_back_id DESC";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response > 0) ? $response : '';
    }

    public function getUserdownloadmycashback($user_id, $month, $year) {
        $condation = '';
        if ($month != '') {
            $condation = "AND MONTH(STR_TO_DATE(date, '%m/%d/%Y')) = $month";
        }
        if ($year != '') {
            $condation.= " AND YEAR(STR_TO_DATE(date, '%m/%d/%Y')) = $year";
        }
        $query = "SELECT date,merchant,purchase_price,floor,cash_back,additional10,
                    cash_back_percent,status
                    from view_ewallet_my_cash_back where fk_user_id = :userId $condation";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response > 0) ? $response : '';
    }

    public function getuserexclusivecommissions($user_id, $month, $year) {

        $condation = '';
        if ($month != '') {
            $condation = "AND MONTH(STR_TO_DATE(date, '%m/%d/%Y')) = $month";
        }
        if ($year != '') {
            $condation.= " AND YEAR(STR_TO_DATE(date, '%m/%d/%Y')) = $year";
        }
        $query = "SELECT * from view_my_exclusive_commissions where fk_user_id = :userId $condation";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response > 0) ? $response : '';
    }

    public function getUserKarmoraKash($user_id) {
        $query = "SELECT * from view_my_karmora_kash where fk_user_id = :userId ORDER BY date DESC";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response > 0) ? $response : FALSE;
    }

    public function getPoolShareStats($user_id) {
        $query = "SELECT * from view_5for5_p3_stats where pk_user_id = :userId";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response > 0) ? reset($response) : FALSE;
    }

    public function getPoolShare($user_id) {
        $query = "SELECT CONCAT(MONTHNAME(p3.5for5_p3_create_date),', ', YEAR(p3.5for5_p3_create_date)) AS _month, 
                    TRUNCATE((p3.exclusive_sales_total + p3.cashback_total),2) as total_revenue,
                    TRUNCATE(p3.pool_value,2) AS pool_value, 
                    TRUNCATE(p3.qualifying_value,2) AS qualify_vol,
                    TRUNCATE(p3ua.p3_user_volume,2) AS my_vol,
                    TRUNCATE(p3ua.p3_user_profit_share,2) AS my_profit_share
                FROM tbl_5for5_p3 as p3
                LEFT JOIN tbl_5for5_p3_user_activity AS p3ua ON CONCAT(YEAR(p3.5for5_p3_create_date),'-',MONTH(p3.5for5_p3_create_date)) = CONCAT(YEAR(p3ua.p3_user_activity_create_date),'-',MONTH(p3ua.p3_user_activity_create_date))
                WHERE p3ua.fk_user_id = :userId
                ORDER BY p3.5for5_p3_create_date DESC";
        $statement = $this->db->conn_id->prepare($query);
        $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($response > 0) ? $response : FALSE;
    }

}
