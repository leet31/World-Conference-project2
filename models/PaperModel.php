<?php

class PaperModel {

    private $pdo;
    private $table = 'wa_papers';
    public $paperID = '';
    public $authorID = '';
    public $reviewerID = '';
    public $subAreaID = '';
    public $title = '';
    public $mime = '';
    public $document = '';
    
    //extened info for editing display
    public $authorFullName = '';
    public $reviewerFullName = '';
    public $areaName = '';
    public $subareaName = '';
    
    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function getList() {
        $stmt = $this->pdo->prepare("SELECT ID, AUTHOR_ID, REVIEWER_ID, SUBAREA_ID, TITLE  FROM $this->table");
        $stmt->execute();
        $allList = $stmt->fetchAll();
        return $allList;
    }
    
    /**
     * gets list of papers with author name, reviewer name, area name, and subarea name for content manager
     */
    public function getEditPaperList(){
        $sql = "
            SELECT p.ID, p.REVIEWER_ID, p.AUTHOR_ID, p.SUBAREA_ID, p.TITLE, 
            s.NAME AS `SUBAREA_NAME`,
            sq.NAME AS `AREA_NAME`,
            CONCAT(an.FIRST_NAME, ' ',an.LAST_NAME) AS `AUTHOR_FULL_NAME`,
            CONCAT(rn.FIRST_NAME, ' ',rn.LAST_NAME) AS `REVIEWER_FULL_NAME`
            FROM `wa_papers` AS p
            INNER JOIN(SELECT sa.ID AS `SUBAREA_ID`, a.ID AS `AREA_ID`, a.NAME 
                        FROM `wa_subareas`AS sa 
                        INNER JOIN `wa_areas` AS `a` WHERE sa.PARENT_ID = a.ID) as `sq`
                ON p.SUBAREA_ID=sq.SUBAREA_ID 
            INNER JOIN `wa_subareas` AS s 
                ON p.SUBAREA_ID=s.ID
            INNER JOIN `wa_users` AS an 
                ON p.AUTHOR_ID=an.ID
            LEFT JOIN `wa_users` AS rn 
                ON p.REVIEWER_ID=rn.ID";
        
        try{
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        $editPaperList = $stmt->fetchAll();
        return $editPaperList;
    }
    
    public function getSinglePaperForEditing(){
        $sql = "
            SELECT p.ID, p.REVIEWER_ID, p.AUTHOR_ID, p.SUBAREA_ID, p.TITLE, 
            s.NAME AS `SUBAREA_NAME`,
            sq.NAME AS `AREA_NAME`,
            CONCAT(an.FIRST_NAME, ' ',an.LAST_NAME) AS `AUTHOR_FULL_NAME`,
            CONCAT(rn.FIRST_NAME, ' ',rn.LAST_NAME) AS `REVIEWER_FULL_NAME`
            FROM `wa_papers` AS p
            INNER JOIN(SELECT sa.ID AS `SUBAREA_ID`, a.ID AS `AREA_ID`, a.NAME 
                        FROM `wa_subareas`AS sa 
                        INNER JOIN `wa_areas` AS `a` WHERE sa.PARENT_ID = a.ID) as `sq`
                ON p.SUBAREA_ID=sq.SUBAREA_ID 
            INNER JOIN `wa_subareas` AS s 
                ON p.SUBAREA_ID=s.ID
            INNER JOIN `wa_users` AS an 
                ON p.AUTHOR_ID=an.ID
            LEFT JOIN `wa_users` AS rn 
                ON p.REVIEWER_ID=rn.ID
            WHERE p.ID = :paperID";
        
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':paperID', $this->paperID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        if ($stmt->rowCount() != 1) {
            return "Wrong number of rows returned: ".$stmt->rowCount().", id: ".$this->paperID;
        }
        
        $row = $stmt->fetch();
        $this->paperID          = $row['ID'];
        $this->authorID         = $row['AUTHOR_ID'];
        $this->reviewerID       = $row['REVIEWER_ID'];
        $this->subAreaID        = $row['SUBAREA_ID'];
        $this->title            = $row['TITLE'];
        $this->mime             = '';
        $this->document         = '';
        $this->authorFullName   = $row['AUTHOR_FULL_NAME'];
        $this->reviewerFullName = $row['REVIEWER_FULL_NAME'];
        $this->areaName         = $row['AREA_NAME'];
        $this->subareaName      = $row['SUBAREA_NAME'];
   
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
        $this->mime      = $row->MIME;
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
            //$this->document   = filter_input(INPUT_POST, "document");
            
            //extended info
            $this->authorFullName   = filter_input(INPUT_POST, "authorFullName");
            $this->reviewerFullName = filter_input(INPUT_POST, "reviewerFullName");
            $this->areaName         = filter_input(INPUT_POST, "areaName");
            $this->subareaName      = filter_input(INPUT_POST, "subareaname ");
            
//            //save posted form values to array for session vars
//            $userVars = array(
//                "paperID"          => $this->paperID,
//                "authorID"         => $this->authorID,
//                "reviewerID"       => $this->reviewerID,
//                "subAreaID"        => $this->subAreaID,
//                "title"            => $this->title,
//                "mime"             => $this->mime,
//                //"document"         => $this->document, 
//                "authorFullName"   => $this->authorFullName,
//                "reviewerFullName" => $this->reviewerFullName,
//                "areaName"         => $this->areaName,
//                "subareaName"      => $this->subareaName
//            );
//            
//            //save posted vars in session to reload on error
//            $_SESSION['userVars'] = $userVars;

       //determine which action was selected
            if (filter_input(INPUT_POST, 'btnEdit')) {
                $errMsg = $this->getSinglePaperForEditing($this->paperID);
            } else
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->delete();
            } else
            if (filter_input(INPUT_POST, 'btnUpdate')) {
                $errMsg = $this->update();
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert();
            } else
            if (filter_input(INPUT_POST, 'btnUploadPaper')) {
                $errMsg = $this->uploadPaper();
            } else
            if (filter_input(INPUT_POST, 'btnDeletePaper')) {
                $errMsg = $this->deletePaper();
            } else{
                $errMsg = "Unknown function";
            }
        }
        return $errMsg;
    }

    public function updatePaper() {
        /**
         * replaces the document paper in existing record
         * include this in HTML FORM: "<input name="document" type="file" class="inputFile" />"
         * 
         */
        if (count($_FILES) > 0) {
            return "Error: no files uploaded";
        }
        if (!is_uploaded_file($_FILES['document']['tmp_name'])) {
            return "Error: Uploaded file not found";
        }

        $docBlob = fopen($_FILES['document']['tmp_name'], 'rb');
        $mimetype = mime_content_type($_FILES['document']['tmp_name']);

        try {
            $sql = "UPDATE files
                SET MIME     = :mime,
                    DOCUMENT = :document
                WHERE ID = :paperID;";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':mime', $mime);
            $stmt->bindParam(':document', $docBlob, PDO::PARAM_LOB);
            $stmt->bindParam(':paperID', $paperID);

            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function insert() {
        /**
         * inserts new record 
         * include this in HTML FORM: "<input name="document" type="file" class="inputFile" />"
         * 
         */
        if (count($_FILES) > 0) {
            return "Error: no files uploaded";
        }
        
        if (!is_uploaded_file($_FILES['document']['tmp_name'])) {
            return "Error: Uploaded file not found";
        }

        $docBlob = fopen($_FILES['document']['tmp_name'], 'rb');
        $mimetype = mime_content_type($_FILES['document']['tmp_name']);

        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table ("
                    . "AUTHOR_ID, REVIEWER_ID, SUBAREA_ID,  TITLE, MIME,  DOCUMENT) VALUES ("
                    . ":authorID, :reviewerID, :subareaID, :title, :mime, :document");

            $stmt->bindParam(':authorId', $this->authorID);
            $stmt->bindParam(':reviewerID', $this->reviewerID);
            $stmt->bindParam(':subareaID', $this->subAreaID);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':mime', $this->mime);
            $stmt->bindParam(':document', $this->document, PDO::PARAM_LOB);
            
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        unset($_SESSION['userVars']);
        $this->clear();
        return 'NONE';
    }

    public function update() {
            try {
                $stmt = $this->pdo->prepare("UPDATE $this->table "
                    . "SET "
                    . "    AUTHOR_ID   = :authorID,  "
                    . "    REVIEWER_ID = :reviewerID,"
                    . "    SUBAREA_ID  = :subAreaID, "
                    . "    TITLE       = :title,     "
                    . "    DOCUMENT    = :document,  "
                    . "WHERE ID = :paperID ");

            $stmt->bindParam(':paperID'     , $this->paperID);
            $stmt->bindParam(':authorID'   , $this->authorID );
            $stmt->bindParam(':reviewerID' , $this->reviewerID);
            $stmt->bindParam(':subAreaID'  , $this->subAreaID);
            $stmt->bindParam(':title'      , $this->title);
            $stmt->bindParam(':document'   , $this->document);
            
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        if ($res && $stmt->rowCount() == 1) {
            return "Success: " . $stmt->rowCount() . " rows updated";
        } else {
            return"Error: Update Failed";
        }
    
    }

    public function delete() {
            try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table "
                    . "WHERE ID = :paperID;");

            $stmt->bindParam(':paperID', $this->paperID);
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        if ($res && $stmt->rowCount() == 1) {
            unset($_SESSION['userVars']);
            $this->clear();
            return "Success: " . $stmt->rowCount() . " rows deleted";
        } else {
            return"Error: Delete Failed";
        }
    }
    
    public function clear(){
        $this->paperID = '';
        $this->authorID = '';
        $this->reviewerID = '';
        $this->subAreaID = '';
        $this->title = '';
        $this->document = '';
    }

//SELECT p.ID, p.REVIEWER_ID, p.AUTHOR_ID, p.SUBAREA_ID, p.TITLE, 
//s.NAME AS `SUBAREA_NAME`,
//sq.NAME AS `AREA_NAME`,
//CONCAT(an.FIRST_NAME, ' ',an.LAST_NAME) AS `AUTHOR_FULL_NAME`,
//CONCAT(rn.FIRST_NAME, ' ',rn.LAST_NAME) AS `REVIEWER_FULL_NAME`
//FROM `wa_papers` AS p
//INNER JOIN(SELECT sa.ID AS `SUBAREA_ID`, a.ID AS `AREA_ID`, a.NAME FROM `wa_subareas`AS sa INNER JOIN `wa_areas` AS `a` WHERE sa.PARENT_ID = a.ID) as `sq`ON p.SUBAREA_ID=sq.SUBAREA_ID
//INNER JOIN `wa_subareas` AS s ON p.SUBAREA_ID=s.ID
//INNER JOIN `wa_users` AS an ON p.AUTHOR_ID=an.ID
//LEFT JOIN `wa_users` AS rn ON p.REVIEWER_ID=rn.ID

}
