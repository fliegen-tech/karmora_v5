<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mycharities
 *
 * @author Syed Tausif Ali Shah
 */
class Mycharitiesmodel extends commonmodel{
    //put your code here
    
    public function getMyContribution($userId){
        $query = "SELECT c.charity_name AS 'org_name', cd.charity_donation_amount AS 'my_contirbution', DATE_FORMAT(cd.charity_donation_crate_date, '%c/%d/%Y') AS 'contribution_date'
            FROM tbl_charity_donations AS cd
            LEFT JOIN tbl_charity AS c ON cd.fk_charity_id = c.pk_charity_id
            WHERE cd.fk_user_id = :userId
            ORDER BY cd.charity_donation_crate_date DESC ";
        return $this->simpleQuerySingleParamInt($query, $userId);
        
    }
    
    public function getTotalContribution() {
        $query = "SELECT DISTINCT c.charity_name AS 'org_name', get_donation_sum_by_community_with_charity_id(cd.fk_charity_id) AS 'community_donation',
            get_donation_sum_karmora_care_with_charity_id(cd.fk_charity_id) AS 'karmora_care',
            get_donation_sum_by_karmora_corporate_with_charity_id(cd.fk_charity_id) AS 'corporate_donation',
            get_donation_karmora_kash_award_with_charity_id(cd.fk_charity_id) AS 'kash_award'
            FROM tbl_charity_donations AS cd
            LEFT JOIN tbl_charity AS c ON cd.fk_charity_id = c.pk_charity_id";
        
        return $this->simpleQuery($query);
    }
    
//    local functions for easy
    
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
    
}
