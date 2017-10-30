<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ordermodel
 *
 * @author Syed
 */
class Ordermodel extends Commonmodel{
    public function __construct() {
        parent::__construct();
    }
    
    public function insertOrderBeforeAuthorization($data) {
        $query = "INSERT INTO tbl_oders
            (fk_user_id, order_numbr, order_total_price, order_cal_total, order_shiping_cost, 
            order_upgrade_cost, order_commsion_price, order_tax_cost, order_karmora_cash_price, 
            fk_shipping_address_id, fk_billing_address_id, order_user_name, order_create_date) 
            VALUES (:userId, :orderNumber, :totalPrice, :calTotal, :shippingCost, :upgradeCost, :commAmount, 
            :taxAmount, :karmoraKashAmount, :shippingAddressId, :billingAddressId, :fullName, NOW())";
        $statement = $this->prepQuery($query);
        $this->bindStatementOrder($statement, $data);
        if($statement->execute()){
            $response['query_status'] = TRUE;
            $response['order_id'] = $this->lastInsertId();
        }else{
            $response['query_status'] = FALSE;
            $response['error_message'] = $this->errorInfo($statement);
        }
        return $response;
    }
    
    private function bindStatementOrder($statement, $data){
        $full_name = $data['firstName'] .''.$data['lastName'];
        $statement->bindParam(':userId', $data['user_id'], PDO::PARAM_INT);
        $statement->bindParam(':orderNumber', $data['order_number'], PDO::PARAM_STR);
        $statement->bindParam(':totalPrice', $data['totalAmount'], PDO::PARAM_STR);
        $statement->bindParam(':calTotal', $data['totalAmount'], PDO::PARAM_STR);
        $statement->bindParam(':shippingCost', $data['shipping_amount'], PDO::PARAM_STR);
        $statement->bindParam(':upgradeCost', $data['upgrade_amount'], PDO::PARAM_STR);
        $statement->bindParam(':commAmount', $data['comm_amount'], PDO::PARAM_STR);
        $statement->bindParam(':taxAmount', $data['taxAmount'], PDO::PARAM_STR);
        $statement->bindParam(':karmoraKashAmount', $data['kash_amount'], PDO::PARAM_STR);
        $statement->bindParam(':shippingAddressId', $data['shipping_id'], PDO::PARAM_STR);
        $statement->bindParam(':billingAddressId', $data['billing_id'], PDO::PARAM_STR);
        $statement->bindParam(':fullName', $full_name, PDO::PARAM_STR);//.' '. $data['lastName']
        return;
    }
    
    public function insertOrderLine($data) {
        $query = "INSERT INTO tbl_order_line
            (fk_order_id, oder_line_number, fk_product_id, fk_account_type_id, order_line_price, order_line_qty)
            VALUES (:orderId, :lineNumber, :prdId, :accTypeId, :linePrice, :qty)";
        $statement= $this->prepQuery($query);
        $statement->bindParam(':orderId', $data['order_id'], PDO::PARAM_STR);
        $statement->bindParam(':lineNumber', $data['line_number'], PDO::PARAM_STR);
        $statement->bindParam(':prdId', $data['product_id'], PDO::PARAM_STR);
        $statement->bindParam(':accTypeId', $data['acc_type_id'], PDO::PARAM_STR);
        $statement->bindParam(':linePrice', $data['line_price'], PDO::PARAM_STR);
        $statement->bindParam(':qty', $data['qty'], PDO::PARAM_STR);
        
        return $statement->execute();
    }
    
    public function updateOrderAuthId($orderId, $authId) {
        $query = "UPDATE tbl_oders SET order_auth_net_transection_id = :authId WHERE pk_order_id = :orderId";
        $statement= $this->prepQuery($query);
        $statement->bindParam(':orderId', $orderId, PDO::PARAM_STR);
        $statement->bindParam(':authId', $authId, PDO::PARAM_STR);
        
        return $statement->execute() ? FALSE : $this->errorInfo($statement);
    }
}
