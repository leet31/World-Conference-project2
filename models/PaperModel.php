<?php

class PaperModel {

    private $pdo;
    private $table = 'wa_papers';
    
    //table columns
    public $paperID = '';
    public $authorID = '';
    public $reviewerID = '';
    public $subareaID = '';
    public $title = '';
    public $fileName = '';
    public $localFileName = '';
     
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
        $stmt = $this->pdo->prepare(""
                . "SELECT * "
                . "FROM $this->table");
        $stmt->execute();
        $allList = $stmt->fetchAll();
        return $allList;
    }
    
    /**
     * gets list of papers with author name, reviewer name, area name, and subarea name for content manager
     */
    public function getEditPaperList($authorID = '',$reviewerID = ''){
        $sql = "
            SELECT p.ID, p.REVIEWER_ID, p.AUTHOR_ID, p.SUBAREA_ID, p.TITLE, p.FILENAME, p.LOCAL_FILENAME,
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
        
        //add WHERE clause, if any
        if($authorID != ''){
            $sql .= " \nWHERE p.AUTHOR_ID = :authorID";
        }else if($reviewerID != ''){
            $sql .= " \nWHERE p.REVIEWER_ID = :reviewerID";
        }
                
        try{
            $stmt = $this->pdo->prepare($sql);

            //bind parameters, if needed
            if($authorID != ''){
                 $stmt->bindValue(':authorID', $authorID);
             } else if($reviewerID != ''){
                 $stmt->bindValue(':reviewerID', $reviewerID);
             }
             
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        $editPaperList = $stmt->fetchAll();
        return $editPaperList;
    }
    
    public function getSinglePaperForEditing(){
        $sql = "
            SELECT p.ID, p.REVIEWER_ID, p.AUTHOR_ID, p.SUBAREA_ID, p.TITLE, p.FILENAME, p.LOCAL_FILENAME,
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
        $this->subareaID        = $row['SUBAREA_ID'];
        $this->title            = $row['TITLE'];
        $this->fileName         = $row['FILENAME'];
        $this->localFileName    = $row['LOCAL_FILENAME'];
        $this->authorFullName   = $row['AUTHOR_FULL_NAME'];
        $this->reviewerFullName = $row['REVIEWER_FULL_NAME'];
        $this->areaName         = $row['AREA_NAME'];
        $this->subareaName      = $row['SUBAREA_NAME'];
        
        //echo("</br>Get FileName: $this->fileName");
   
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
        $this->paperID       = $row->ID;
        $this->authorID      = $row->AUTHOR_ID;
        $this->reviewerID    = $row->REVIEWER_ID;
        $this->subareaID     = $row->SUBAREA_ID;
        $this->title         = $row->TITLE;
        $this->fileName      = $row->FILENAME;
        $this->localFileName = $row->LOCAL_FILENAME;
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
            $this->paperID       = filter_input(INPUT_POST, "paperID");
            $this->authorID      = filter_input(INPUT_POST, "authorID");
            $this->reviewerID    = filter_input(INPUT_POST, "reviewerID");
            $this->subareaID     = filter_input(INPUT_POST, "subareaID");
            $this->title         = filter_input(INPUT_POST, "title");
            $this->fileName      = filter_input(INPUT_POST, "fileName");
            $this->localFileName = filter_input(INPUT_POST, "localFileName");
            
            //extended info
            $this->authorFullName   = filter_input(INPUT_POST, "authorFullName");
            $this->reviewerFullName = filter_input(INPUT_POST, "reviewerFullName");
            $this->areaName         = filter_input(INPUT_POST, "areaName");
            $this->subareaName      = filter_input(INPUT_POST, "subareaname");
             
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
                $returnArray = $this->insert();
                if(!$returnArray[0]){
                    $errMsg = $returnArray[1];
                }else {
                    $errMsg ='';
                }
            } else
            if (filter_input(INPUT_POST, 'btnUploadPaper')) {
                $errMsg = $this->uploadPaper();
            } else
            if (filter_input(INPUT_POST, 'btnDeletePaper')) {
                $errMsg = $this->deletePaper();
            } else
            if (filter_input(INPUT_POST, 'btnClear')) {
                $errMsg = $this->clear();
            } else
            if(filter_input(INPUT_POST, 'btnViewDoc')) {
                //echo("<br>viewDoc...");
                $errMsg = $this->viewDoc(); 
            }else{
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
         * inserts new record and uploads file to documents folder
         * include this in HTML FORM: "<input name="document" type="file" class="inputFile" />"
         * <form> must have these two attributes: "method='post' enctype='multipart/form-data' "
         */
        //$uploadLogFile = 'C:\temp\uploads.log';
        error_log(microtime()." Insert started\n");//,3,"$uploadLogFile");
        
        error_log(microtime()." authorID:      ".$this->authorID     ."\n");//,3,"$uploadLogFile");
        error_log(microtime()." reviewerID:    ".$this->reviewerID   ."\n");//,3,"$uploadLogFile");
        error_log(microtime()." subareaID:     ".$this->subareaID    ."\n");//,3,"$uploadLogFile");
        error_log(microtime()." title:         ".$this->title        ."\n");//,3,"$uploadLogFile");
        error_log(microtime()." fileName:      ".$this->fileName     ."\n");//,3,"$uploadLogFile");
        error_log(microtime()." localFileName: ".$this->localFileName."\n");//,3,"$uploadLogFile");
        $files_str=print_r($_FILES, true);
        error_log(microtime()." _FILES:        ".$files_str          ."\n");//,3,"$uploadLogFile");
        
//        echo("</br> authorID:      ".$this->authorID);
//        echo("</br> reviewerID:    ".$this->reviewerID);
//        echo("</br> subareaID:     ".$this->subareaID);
//        echo("</br> title:         ".$this->title);
//        echo("</br> fileName:      ".$this->fileName);
//        echo("</br> localFileName: ".$this->localFileName);
//        
//        echo("</br>_FILES: ");
//        print_r($_FILES);
//        echo("</br>Count: ".count($_FILES));
        
        if (count($_FILES) <= 0) {
            return array(false,"Error: no files uploaded");
        }
        
        if (!is_uploaded_file($_FILES['document']['tmp_name'])) {
            return array(false,"Error: Uploaded file not found");
        }
        
        $target_dir = "../../documents/";
        $target_file = $target_dir . basename($_FILES["document"]['tmp_name']);
        error_log(microtime()." Target File:    ".$target_file          ."\n");
        //echo("</br>Target File: $target_file");
        $uploadOk = 1;
        
        // Check file size
        if ($_FILES["document"]["size"] > 8388608) {
            return array(false,"Sorry, your file is too large ( > 8 MB).");
        }
        
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            $errMsg = "The file ". basename( $_FILES["document"]["name"]). " has been uploaded.";
        } else {
            return array(false,"Sorry, there was an error uploading your file.");
        }

        $this->fileName=$_FILES['document']['name'];
        $this->localFileName=basename($_FILES["document"]['tmp_name']);
        error_log(microtime()." fileName:      ".$this->fileName     ."\n");//,3,"$uploadLogFile");
        error_log(microtime()." localFileName: ".$this->localFileName."\n");//,3,"$uploadLogFile");
        
//        echo("<br><br> fileName:      ".$this->fileName);
//        echo("<br> localFileName: ".$this->localFileName);
        
       try {
            $cols =  "AUTHOR_ID, SUBAREA_ID, TITLE,  FILENAME,  LOCAL_FILENAME  ";
            $params= ":authorID, :subareaID, :title, :fileName, :localFileName";
            
            if($this->reviewerID != ''){
                $cols   .= ", REVIEWER_ID";
                $params .= ", :reviewerID";
            }
            
            $sql="INSERT INTO $this->table ("
                    . "$cols  ) VALUES ("
                    . "$params )";
            error_log(microtime()." sql       :    ".$sql."\n");//,3,"$uploadLogFile");
//            echo("<br>$sql");
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':authorID'  , $this->authorID);
            $stmt->bindParam(':subareaID' , $this->subareaID);
            $stmt->bindParam(':title'     , $this->title);
            $stmt->bindParam(':fileName'  , $this->fileName);
            $stmt->bindParam(':localFileName'  , $this->localFileName);
            if($this->reviewerID != ''){
                $stmt->bindParam(':reviewerID', $this->reviewerID);
            }
            
            $stmt->execute();
        } catch (PDOException $e) {
            $this->fileName = '';
            error_log(microtime()." PDO Exception: ".$e->getMessage()."\n");//,3,"$uploadLogFile");
            return array(false,$e->getMessage());
        }

        $this->clear();
        unset($_POST);
        error_log(microtime()." Insertion OK:      ".$this->pdo->lastInsertId()."\n");//,3,"$uploadLogFile");
        return array(true,'Success:Document Number is '.$this->pdo->lastInsertId());
    }

    public function update() {
        $sql="UPDATE $this->table "
                    . "SET "
                    . "    AUTHOR_ID   = :authorID,  "
                    . "    REVIEWER_ID = :reviewerID,"
                    . "    SUBAREA_ID  = :subareaID, "
                    . "    TITLE       = :title      "
                    . "WHERE ID = :paperID ";
        
            try {
                $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':paperID'    , $this->paperID);
            $stmt->bindParam(':authorID'   , $this->authorID );
            $stmt->bindParam(':reviewerID' , $this->reviewerID);
            $stmt->bindParam(':subareaID'  , $this->subareaID);
            $stmt->bindParam(':title'      , $this->title);
            
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
        $this->subareaID = '';
        $this->title = '';
        $this->fileName = '';
        $this->localFileName = '';
    }

    public function viewDoc(){
//        echo("</br>FileName: $this->fileName");
//        echo("</br>LocalFileName: $this->localFileName");
//       
//        error_log("FileName: ".$this->fileName."\n");
//        error_log("LocalFileName: ".$this->localFileName."\n");
        
        $errMsg = "";
        $source_dir = "../../documents/";
        $source_file = $source_dir.$this->localFileName;
        //echo("</br>SourceFile: $source_file");
    
        //sanitize file name
        //$this->fileName = str_replace("'","-",$this->fileName);
        
        if (file_exists($source_file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            //header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Content-Disposition: attachment; filename="'.$this->fileName.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($source_file));
            ob_clean();
            flush();
            readfile($source_file);
        }else{
            return"Error: source file does not exist";
        }
        return"NONE";

    }
    
    /**
     * Function: sanitize
     * Returns a sanitized string, typically for URLs.
     *
     * Parameters:
     *     $string - The string to sanitize.
     *     $force_lowercase - Force the string to lowercase?
     *     $anal - If set to *true*, will remove all non-alphanumeric characters.
     */
    public function sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]", "&#39;",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
                (function_exists('mb_strtolower')) ?
                        mb_strtolower($clean, 'UTF-8') :
                        strtolower($clean) :
                $clean;
    }
    
    public function getPaperCountByAuthorId($authorId){
        $sql = "select COUNT(ID) as `P_COUNT` from $this->table WHERE AUTHOR_ID = :authorId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':authorId', $authorId);
        try{
            $res = $stmt->execute();
        }catch (PDOException $e) {
            //see php log for details
            //return $e->getMessage();
            return -1;
        }
        
        $row=$stmt->fetch();
        return $row['P_COUNT'];
    }

}
