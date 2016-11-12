<?php

class PaperModel {

    private $pdo;
    private $table = 'wa_subareas';
    private $userTable = 'wa_users';
    public $paperID = '';
    public $authorID = '';
    public $reviewerID = '';
    public $subAreaID = '';
    public $title = '';
    public $document = '';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $allList = $stmt->fetchAll();
        return $allList;
    }

    public function getPaper() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $this->table "
                    . "WHERE ID = :paperID");
            $stmt->bindParam(':paperID', $this->paperID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        if ($stmt->rowCount() != 1) {
            return "Wrong number of rows returned";
        }
        
        $row = $stmt->fetch();
        $this->paperID    = $row->ID;
        $this->authorID   = $row->AUTHOR_ID;
        $this->reviewerID = $row->REVIEWER_ID;
        $this->subAreaID  = $row->SUBAREA_ID;
        $this->title      = $row->TITLE;
        $this->document   = $row->DOCUMENT;
    }

    public function doAction() {
        $errMsg = '';

//        echo("<p>_POST: ");
//        print_r($_POST);
//        echo("</p>");
//        echo("<p>_SESSION: ");
//        print_r($_SESSION);
//        echo("</p>");
        //save form values in user object
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            //save posted vars
            $this->paperID    = filter_input(INPUT_POST, "paperID");
            $this->authorID   = filter_input(INPUT_POST, "authorID");
            $this->reviewerID = filter_input(INPUT_POST, "reviewerID");
            $this->subAreaID  = filter_input(INPUT_POST, "subAreaID");
            $this->title      = filter_input(INPUT_POST, "title");
            $this->document   = filter_input(INPUT_POST, "document");
        }
    }

    public function insert() {
        
    }

    public function update() {
        
    }

    public function delete() {
        
    }

}
