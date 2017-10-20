<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cartmodel extends CI_Model {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function validate_add_cart_item() {

        $shopper_account_type = $this->input->post('shopper_account_type'); //get account type
        $price                = $this->input->post('shopper_account_type_price'); //get account type
        $id                   = $this->input->post('product_id'); // Assign posted product_id to $id
        $qty                  = $this->input->post('quantity'); // Assign posted quantity to $cty
        $query                = $this->db->query(" select * from tbl_product where  pk_product_id = ".$id);
        $result_array         = $query->result();
        if ($result_array > 0) {
            // We have a match!
                $product_name = strip_tags($result_array[0]->product_title);
                $string = preg_replace('/[-?!.:]/', '', $product_name);
                $product_name = str_replace(":", "", $string);
                // Create an array with product information
               $data = array(
                        'id' => $id,
                        'pic' => $result_array[0]->product_image,
                        'qty' => $qty,
                        'shopper_account_type' => $shopper_account_type,
                        'price' => $price,
                        'name' => $product_name
                    );
                // Add the data to the cart using the insert function that is available because we loaded the cart library
                $this->cart->insert($data);
                return TRUE; // Finally return TRUE
        } else {
            // Nothing found! Return FALSE!
            return FALSE;
        }
    }

    // Updated the shopping cart
    function validate_update_cart() {

        // Get the total number of items in cart
        $total = $this->cart->total_items();
        // Retrieve the posted information
        $item = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        // Cycle true all items and update them
        for ($i = 0; $i < $total; $i++) {
            // Create an array with the products rowid's and quantities.
            $data = array(
                'rowid' => $item[$i],
                'qty' => $qty[$i]
            );

            // Update the cart with the new information
            $this->cart->update($data);
        }
    }

    public function getOrderDetailById($order_no, $user_id) {
        $query = "select * from view_my_order_detail where fk_user_id = $user_id and order_no = '" . $order_no . "'";
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function getOrderProduct($order_no) {
        $query = "SELECT tbl_order_line.*,tbl_product.product_title FROM `tbl_order_line` , tbl_product WHERE tbl_order_line.`fk_order_id` = $order_no and tbl_order_line.fk_product_id = tbl_product.pk_product_id";
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->result_array();
        } else {
            return '';
        }
    }

    public function getOrderDetailTotalsSummery($orderId) {
        $query = "SELECT * FROM tbl_oders where pk_order_id = :orderId";
        $statment = $this->db->conn_id->prepare($query);
        $statment->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $statment->execute();
        $result = $statment->fetchAll(PDO::FETCH_ASSOC);
        return count($result)>0 ? $result : FALSE;

    }

    public function getOrderDetailTotalsSummery_row($orderId) {
        $query = "SELECT * FROM tbl_oders where pk_order_id = $orderId";
        $queryRS = $this->db->query($query);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }
    public function getOrdercoupon($userId,$order_id) {
        $query = "SELECT * FROM tbl_coupon_users where coupon_used_user_id = $userId and coupon_used_fk_order_id = $order_id limit 1";
        $queryRS = $this->db->query($query);
        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

    public function getOrderDetail($pk_order_id) {
        $query = "select * from view_my_order_detail where pk_order_id = $pk_order_id ";
        $queryRS = $this->db->query($query);

        if ($queryRS->num_rows() > 0) {
            return $queryRS->row();
        } else {
            return '';
        }
    }

}
