<?php

class SubareaModel {

    private $pdo;
    private $table = 'wa_subareas';
    private $parentTable = 'wa_areas';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($parentID, $name, $desc) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (PARENT_ID, NAME, DESCRIPTION) VALUES (:parentID, :name, :desc)");
            $stmt->bindParam(':parentID', $parentID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':desc', $desc);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $allList = $stmt->fetchAll();
        return $allList;
    }

    public function getIdNameParentList() {
        $stmt = $this->pdo->prepare(""
                . "SELECT "
                . "ID, "
                . "PARENT_ID,"
                . "NAME "
                . "FROM $this->table");
        $stmt->execute();
        $nameList = $stmt->fetchAll();
        return $nameList;
    }

    public function getParentList() {
        $stmt = $this->pdo->prepare("SELECT ID, NAME FROM $this->parentTable");
        $stmt->execute();
        $allList = $stmt->fetchAll();
        return $allList;
    }

    public function delete($subareaID) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ID = :subareaID");
            $stmt->bindParam(':subareaID', $subareaID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function update($subareaID, $parentID, $name, $desc) {
        echo("update: $subareaID, $parentID, $name, $desc");
        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set PARENT_ID = :parentID, NAME = :name, DESCRIPTION = :desc WHERE ID = :subareaID");
            $stmt->bindParam(':subareaID', $subareaID);
            $stmt->bindParam(':parentID', $parentID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':desc', $desc);
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
                $errMsg = $this->delete(filter_input(INPUT_POST, 'areaID'));
            } else
            if (filter_input(INPUT_POST, 'btnUpdate')) {
                $errMsg = $this->update(filter_input(INPUT_POST, 'subareaID'), filter_input(INPUT_POST, 'parentID'), filter_input(INPUT_POST, 'subareaName'), filter_input(INPUT_POST, 'subareaDesc'));
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert(filter_input(INPUT_POST, 'parentID'), filter_input(INPUT_POST, 'subareaName'),filter_input(INPUT_POST, 'subareaDesc'));
            }
        }

        return $errMsg;
    }

}

?>
