<?php

class ProdModel {

    private $pdo;
    private $table = 'wa_products';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($catID, $name, $description, $price) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (CATEGORY, NAME, DESCRIPTION, PRICE) VALUES (:catID, :name, :description, :price)");
            $stmt->bindParam(':catID', $catID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'NONE';
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function delete($productID) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ID = :productID");
            $stmt->bindParam(':productID', $productID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'NONE';
    }

    public function update($productID, $catID, $name, $description, $price) {
        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set CATEGORY = :catID, NAME = :name, DESCRIPTION =:description, PRICE=:price WHERE ID = :productID");
            $stmt->bindParam(':productID', $productID);
            $stmt->bindParam(':catID', $catID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'NONE';
    }

    public function doAction() {
        $errMsg = '';

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->delete(filter_input(INPUT_POST, 'productID'));
            } else
            if (filter_input(INPUT_POST, 'btnUpdate')) {
                $errMsg = $this->update(filter_input(INPUT_POST, 'productID'), filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'name'), 
                        filter_input(INPUT_POST, 'description'), filter_input(INPUT_POST, 'price'));
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert(filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'name'), filter_input(INPUT_POST, 'description'), filter_input(INPUT_POST, 'price'));
            }
        }

        return $errMsg;
    }

}

?>
