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
    public $mime = '';
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
            $this->document   = filter_input(INPUT_POST, "document");
            
            //save posted form values to array for session vars
            $userVars = array(
                "paperID"    => $this->paperID,
                "authorID"   => $this->authorID,
                "reviewerID" => $this->reviewerID,
                "subAreaID"  => $this->subAreaID,
                "title"      => $this->title,
                "mime"       => $this->mime,
                "document"   => $this->document  
            );
            
            //save posted vars in session to reload on error
            $_SESSION['userVars'] = $userVars;

       //determine which action was selected
            if (filter_input(INPUT_POST, 'btnEdit')) {
                $errMsg = $this->getUser($this->userID);
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

//    SELECT DISTINCT p.ID, p.REVIEWER_ID, p.AUTHOR_ID, p.SUBAREA_ID, p.TITLE, 
//    CONCAT(u.FIRST_NAME, ' ',u.LAST_NAME) AS `AUTHOR_NAME`,
//    CONCAT(r.FIRST_NAME, ' ',r.LAST_NAME) AS `REVIEWER_NAME`,
//    s.NAME AS `SUBAREA_NAME`
//    FROM `wa_papers` AS p
//    INNER JOIN `wa_users` AS u ON p.AUTHOR_ID=u.ID
//    INNER JOIN `wa_users` AS r ON p.REVIEWER_ID=r.ID
//    INNER JOIN `wa_subareas` AS s ON p.SUBAREA_ID=s.ID
}
