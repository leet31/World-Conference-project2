<?php

class OrderDetailModel {

    private $pdo;
    private $table = 'wa_order_details';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($order_id, $product_id, $qty) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (ORDER_ID, PRODUCT_ID, QUANTITY) VALUES (:order_id, :product_id, :quantity)");
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':quantity', $qty);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getOneByIDs($order_id, $product_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE ORDER_ID = :order_id, PRODUCT_ID=:product_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $order_detail = $stmt->fetch();
        return $order_detail;
    }
    public function getListByOrderId($order_id){
         $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE ORDER_ID = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $order_details = $stmt->fetchAll();
        return $order_details;
    }

    public function delete($order_id, $product_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ORDER_ID = :order_id AND PRODUCT_ID=:product_id");
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function update($id, $customer_id, $balance, $order_date, $isPaid) {

        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set CUSTOMER_ID = :customer_id, BALANCE = :balance, ORDER_DATE =:order_date, ISPAID=:isPaid WHERE ID = :id");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':balance', $balance);
            $stmt->bindParam(':order_date', $order_date);
            $stmt->bindParam(':isPaid', $isPaid);
            $stmt->bindParam(':id', $isPaid);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function doAction() {
        
    }

}

?>
