<?php

class OrderModel {

    private $pdo;
    private $table = 'wa_orders';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($customer_id, $balance, $order_date, $isPaid) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (CUSTOMER_ID, BALANCE, ORDER_DATE, ISPAID) VALUES (:customer_id, :balance, :order_date, :isPaid)");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':balance', $balance);
            $stmt->bindParam(':order_date', $order_date);
            $stmt->bindParam(':isPaid', $isPaid);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'NONE';
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $orders = $stmt->fetchAll();
        return $orders;
    }

    public function getListByCustomerID($customer_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE CUSTOMER_ID = :customer_id");
        $stmt->bindParam(':customer_id', $customer_id);

        $stmt->execute();
        $orders = $stmt->fetchAll();
        return $orders;
    }

    public function getNewOrderByCustomerID($customer_id) {
        $list = $this->getListByCustomerID($customer_id);
        if (count($list) > 0) {
            return $list[count($list) - 1];
        } else {
            return null;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ID = :ID");
            $stmt->bindParam(':ID', $id);
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
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function payOrder($id) {
        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set ISPAID=:isPaid WHERE ID = :id");
            $isPaid = TRUE;
            $stmt->bindParam(':isPaid', $isPaid);
            $stmt->bindParam(':id', $id);
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
