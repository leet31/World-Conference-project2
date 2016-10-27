<?php

class ProdCatModel {

    private $pdo;
    private $table = 'wa_product_categories';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($catName) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (CATEGORY_NAME) VALUES (:catName)");
            $stmt->bindParam(':catName', $catName);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $cats = $stmt->fetchAll();
        return $cats;
    }

    public function delete($catID) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ID = :catID");
            $stmt->bindParam(':catID', $catID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function update($catID, $newName) {
        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set CATEGORY_NAME = :newName WHERE ID = :catID");
            $stmt->bindParam(':catID', $catID);
            $stmt->bindParam(':newName', $newName);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function doAction() {
        $errMsg = '';

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->delete(filter_input(INPUT_POST, 'catID'));
            } else
            if (filter_input(INPUT_POST, 'btnRename')) {
                $errMsg = $this->update(filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'renameValue'));
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert(filter_input(INPUT_POST, 'catName'));
            }
        }

        return $errMsg;
    }

}

?>
