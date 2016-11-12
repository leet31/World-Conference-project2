<?php

class AreaModel {

    private $pdo;
    private $table = 'wa_areas';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($areaName, $areaDesc) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (NAME, DESCRIPTION) VALUES (:areaName, :areaDesc)");
            $stmt->bindParam(':areaName', $areaName);
            $stmt->bindParam(':areaDesc', $areaDesc);
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

    public function getIdNameList() {
        $stmt = $this->pdo->prepare(""
                . "SELECT "
                . "ID, "
                . "NAME "
                . "FROM $this->table");
        $stmt->execute();
        $idNameList = $stmt->fetchAll();
        return $idNameList;
    }

    public function delete($areaID) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ID = :areaID");
            $stmt->bindParam(':areaID', $areaID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return '';
    }

    public function update($areaID, $newName, $newDesc) {
        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set NAME = :newName, DESCRIPTION = :newDesc WHERE ID = :areaID");
            $stmt->bindParam(':areaID', $areaID);
            $stmt->bindParam(':newName', $newName);
            $stmt->bindParam(':newDesc', $newDesc);
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
                $errMsg = $this->update(filter_input(INPUT_POST, 'areaID'), filter_input(INPUT_POST, 'areaName'), filter_input(INPUT_POST, 'areaDesc'));
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert(filter_input(INPUT_POST, 'areaName'),filter_input(INPUT_POST, 'areaDesc'));
            }
        }

        return $errMsg;
    }

}

?>
