<?php

class UserModel {

    private $pdo;
    private $table = 'wa_users';
    //only on HTML registration form
    public $password1 = '';
    public $password2 = '';
    public $attendeeType = '';
    //Fields in MySQL Table
    public $userID = '';
    public $pwHash = '';
    public $firstName = '';
    public $lastName = '';
    public $compOrg = '';
    public $address1 = '';
    public $address2 = '';
    public $city = '';
    public $state = '';
    public $zipCode = '';
    public $phone = '';
    public $email = '';
    public $admin = '';
    public $attendee = '';
    public $presenter = '';
    public $student = '';
    public $reviewer = '';

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

    //do action in submitted HTML Form
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
            $this->userID = filter_input(INPUT_POST, "userID");
            $this->pwHash = filter_input(INPUT_POST, "pwHash");
            $this->firstName = filter_input(INPUT_POST, "firstName");
            $this->lastName = filter_input(INPUT_POST, "lastName");
            $this->compOrg = filter_input(INPUT_POST, "compOrg");
            $this->address1 = filter_input(INPUT_POST, "address1");
            $this->address2 = filter_input(INPUT_POST, "address2");
            $this->city = filter_input(INPUT_POST, "city");
            $this->state = filter_input(INPUT_POST, "state");
            $this->zipCode = filter_input(INPUT_POST, "zipCode");
            $this->phone = filter_input(INPUT_POST, "phone");
            $this->email = filter_input(INPUT_POST, "email");
            $this->admin = filter_input(INPUT_POST, "cbAdmin") == 'on' ? 1 : 0;
            $this->attendee = filter_input(INPUT_POST, "cbAttend") == 'on' ? 1 : 0;
            $this->presenter = filter_input(INPUT_POST, "cbPresenter") == 'on' ? 1 : 0;
            $this->student = filter_input(INPUT_POST, "cbStudent") == 'on' ? 1 : 0;
            $this->reviewer = filter_input(INPUT_POST, "cbReviewer") == 'on' ? 1 : 0;
            $this->password1 = filter_input(INPUT_POST, "password1");
            $this->password2 = filter_input(INPUT_POST, "password2");
            $this->attendeeType = filter_input(INPUT_POST, "attendeeType");

            //determine which action was selected
            if (filter_input(INPUT_POST, 'btnEdit')) {
                //return error message instead of array
                $errMsg = $this->getUser($this->userID, false);
            } else
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->delete();
            } else
            if (filter_input(INPUT_POST, 'btnReset')) {
                $this->clear();
            } else
            if (filter_input(INPUT_POST, 'btnUpdate')) {
                $errMsg = $this->update();
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert($this);
            } else
            if (filter_input(INPUT_POST, 'btnRegisterSubmit')) {
                $errMsg = $this->submitRegistration();
            } else
            if (filter_input(INPUT_POST, 'btnLoginSubmit')) {
                $errMsg = $this->submitLogin();
            } else{
                $errMsg = "Unknown function";
            }
        }

        return $errMsg;
    }

    public function delete() {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table "
                    . "WHERE ID = :userID;");

            $stmt->bindParam(':userID', $this->userID);
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        if ($res) {
            unset($_SESSION['userVars']);
            $this->clear();
            return "Success: " . $stmt->rowCount() . " rows deleted";
        } else {
            return"Error: Delete Failed";
        }
    }

    public function clear() {
        $this->password1 = '';
        $this->password2 = '';
        $this->attendeeType = '';
        $this->userID = '';
        $this->pwHash = ';';
        $this->firstName = '';
        $this->lastName = '';
        $this->compOrg = '';
        $this->address1 = '';
        $this->address2 = '';
        $this->city = '';
        $this->state = '';
        $this->zipCode = '';
        $this->phone = '';
        $this->email = '';
        $this->admin = '';
        $this->attendee = '';
        $this->presenter = '';
        $this->student = '';
        $this->reviewer = '';
    }

    public function update() {

        //check if password is being changed
        $pw = filter_input(INPUT_POST, "hiddenPw");
        if ($pw != '') {
            $this->pwHash = sha1($pw);
        }
        if (strlen($this->pwHash) != 40) {
            return "Password not set or not valid";
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table "
                    . "SET "
                    . "    PW_HASH      = :pwHash   ,"
                    . "    FIRST_NAME   = :firstName,"
                    . "    LAST_NAME    = :lastName ,"
                    . "    COMPANY      = :compOrg  ,"
                    . "    ADDRESS_1    = :address1 ,"
                    . "    ADDRESS_2    = :address2 ,"
                    . "    CITY         = :city     ,"
                    . "    STATE        = :state    ,"
                    . "    ZIP_CODE     = :zipCode  ,"
                    . "    PHONE_NUMBER = :phone    ,"
                    . "    EMAIL        = :email    ,"
                    . "    ADMIN        = :admin    ,"
                    . "    ATTENDEE     = :attendee ,"
                    . "    PRESENTER    = :presenter,"
                    . "    STUDENT      = :student  ,"
                    . "    REVIEWER     = :reviewer  "
                    . "WHERE ID = :userID ");

            $stmt->bindParam(':userID', $this->userID);
            $stmt->bindParam(':pwHash', $this->pwHash);
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':compOrg', $this->compOrg);
            $stmt->bindParam(':address1', $this->address1);
            $stmt->bindParam(':address2', $this->address2);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':state', $this->state);
            $stmt->bindParam(':zipCode', $this->zipCode);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':admin', $this->admin);
            $stmt->bindParam(':attendee', $this->attendee);
            $stmt->bindParam(':presenter', $this->presenter);
            $stmt->bindParam(':student', $this->student);
            $stmt->bindParam(':reviewer', $this->reviewer);

            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        $rowCount = $stmt->rowCount();
        if ($res) {
            if ($rowCount == 1) {
                return "Success: " . $rowCount . " rows updated";
            } else {
                return "Error: " . $rowCount . " rows updated";
            }
        } else {
            return"Error: Update Failed";
        }
    }
   public function updateNew($id, $firstName, $lastName, $compOrg, $address1, $address2, $city, $state, $zipCode, $phone, $email) {

        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table "
                    . "SET "
                    . "    FIRST_NAME   = :firstName,"
                    . "    LAST_NAME    = :lastName ,"
                    . "    COMPANY      = :compOrg  ,"
                    . "    ADDRESS_1    = :address1 ,"
                    . "    ADDRESS_2    = :address2 ,"
                    . "    CITY         = :city     ,"
                    . "    STATE        = :state    ,"
                    . "    ZIP_CODE     = :zipCode  ,"
                    . "    PHONE_NUMBER = :phone    ,"
                    . "    EMAIL        = :email    "
                    . "WHERE ID = :userID ");

            $stmt->bindParam(':userID', $id);
           
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':compOrg', $compOrg);
            $stmt->bindParam(':address1', $address1);
            $stmt->bindParam(':address2', $address2);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':zipCode', $zipCode);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        $rowCount = $stmt->rowCount();
        if ($res) {
            if ($rowCount == 1) {
                return "Success: " . $rowCount . " rows updated";
            } else {
                return "Error: " . $rowCount . " rows updated";
            }
        } else {
            return"Error: Update Failed";
        }
    }
    
    /**
     * 
     * @param type $userID user ID of user to search for
     * @param type $returnArray if true, return user record (for store), 
     * otherwise return error message string "NONE" for no error.
     * @return type string or array
     */
    public function getUser($userID, $returnArray = true) {
        $errMsg = 'NONE';

        $stmt = $this->pdo->prepare("SELECT * FROM  $this->table "
                . "WHERE ID =  :userID");

        try {
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
        } catch (PDOException $e) {
            $errMsg = $e->getMessage();
        }
        
        $user = $stmt->fetch();

        $this->userID = $user['ID'];
        $this->pwHash = $user['PW_HASH'];
        $this->firstName = $user['FIRST_NAME'];
        $this->lastName = $user['LAST_NAME'];
        $this->compOrg = $user['COMPANY'];
        $this->address1 = $user['ADDRESS_1'];
        $this->address2 = $user['ADDRESS_2'];
        $this->city = $user['CITY'];
        $this->state = $user['STATE'];
        $this->zipCode = $user['ZIP_CODE'];
        $this->phone = $user['PHONE_NUMBER'];
        $this->email = $user['EMAIL'];
        $this->admin = $user['ADMIN'];
        $this->attendee = $user['ATTENDEE'];
        $this->presenter = $user['PRESENTER'];
        $this->student = $user['STUDENT'];
        $this->reviewer = $user['REVIEWER'];

        if($returnArray){
            return $user;
        }
        
        return $errMsg;
    }

    public function submitLogin() {
        $errMsg = '';

        //save posted variable to $this for possible insertion into table
        $this->email = filter_input(INPUT_POST, "email");

        //check for required variables
        if ($this->email === '' ||
                $this->password1 === '') {
            $errMsg = "All fields must be completed";
            return $errMsg;
        }

        $this->pwHash = sha1($this->password1);

        try {
            $stmt = $this->pdo->prepare("SELECT ID, FIRST_NAME, LAST_NAME, EMAIL, ADMIN,  ATTENDEE,  PRESENTER,  STUDENT,  REVIEWER FROM  $this->table "
                    . "WHERE PW_HASH =  :pw_hash "
                    . "AND EMAIL =  :email");

            $stmt->bindParam(':pw_hash', $this->pwHash);
            $stmt->bindParam(':email', $this->email);

            $stmt->execute();
            $users = $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        if (count($users) == 0)
            return "Username or Password is incorrect";

        if (count($users) > 1)
            return "Database error - multiple users returned";

        //save user identifier in session
        $userRec = $users[0];
        $_SESSION['userRec'] = $userRec;
        return "NONE";
    }

    public function login($email, $password) {
        $pwdHash = sha1($password);
        try {
            $stmt = $this->pdo->prepare("SELECT ID, FIRST_NAME, LAST_NAME, EMAIL, ADMIN,  ATTENDEE,  PRESENTER,  STUDENT,  REVIEWER FROM  $this->table "
                    . "WHERE PW_HASH =  :pw_hash "
                    . "AND EMAIL =  :email");

            $stmt->bindParam(':pw_hash', $pwdHash);
            $stmt->bindParam(':email', $email);

            $stmt->execute();
            $users = $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        if (count($users) == 0)
            return "Username or Password is incorrect";

        if (count($users) > 1)
            return "Database error - multiple users returned";

        //save user identifier in session
        $userRec = $users[0];
        
        $_SESSION['userRec'] = $userRec;
        return "NONE";
    }

    public function submitRegistration() {
        $errMsg = "NONE";

        //save posted variable to $this for possible insertion into table
        $this->firstName = filter_input(INPUT_POST, "firstName");
        $this->lastName = filter_input(INPUT_POST, "lastName");
        $this->compOrg = filter_input(INPUT_POST, "compOrg");
        $this->address1 = filter_input(INPUT_POST, "address1");
        $this->address2 = filter_input(INPUT_POST, "address2");
        $this->city = filter_input(INPUT_POST, "city");
        $this->state = filter_input(INPUT_POST, "state");
        $this->zipCode = filter_input(INPUT_POST, "zipCode");
        $this->phone = filter_input(INPUT_POST, "phone");
        $this->email = filter_input(INPUT_POST, "email");
        $this->password1 = filter_input(INPUT_POST, "password1");
        $this->password2 = filter_input(INPUT_POST, "password2");
        $this->attendeeType = filter_input(INPUT_POST, "attendeeType");

        $this->attendee = 1; //everyone who registers is a student
        $this->presenter = ($this->attendeeType === 'presenter') ? 1 : 0;
        $this->student = ($this->attendeeType === 'student') ? 1 : 0;

        //check for requied fields
        if ($this->firstName === '' ||
                $this->lastName === '' ||
                $this->compOrg === '' ||
                $this->address1 === '' ||
                $this->address2 === '' ||
                $this->city === '' ||
                $this->state === '' ||
                $this->zipCode === '' ||
                $this->phone === '' ||
                $this->email === '' ||
                $this->password1 === '' ||
                $this->password2 === '' ||
                $this->attendeeType === ''
        ) {

            $errMsg = "All fields marked with a '*' must be completed";
            return $errMsg;
        }

        if (!$this->password1 || !$this->password2 || $this->password1 != $this->password2) {
            $errMsg = "Passwords are missing or do not match";
            return $errMsg;
        }
        $this->pwHash = sha1($this->password1);
        //echo("Submit pw hash:" . $this->pwHash . "</br>");
        //echo("Submit password:" . $this->password1 . "</br>");
        $errMsg = $this->insert();
        return $errMsg;
    }

    public function insert() {
        //return "NOT IMPLEMENTED";
        //echo("Insert pw hash:" . $this->pwHash . "</br>");

        $pw = filter_input(INPUT_POST, "hiddenPw");
        if ($pw) {
            $this->pwHash = sha1($pw);
        }
        if (strlen($this->pwHash) != 40) {
            return "Password not set or not valid";
        }
        
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table ("
                    . "PW_HASH,   FIRST_NAME, LAST_NAME,  COMPANY,  ADDRESS_1,  ADDRESS_2,  CITY,  STATE,  ZIP_CODE,  PHONE_NUMBER,  EMAIL,  ADMIN,  ATTENDEE,  PRESENTER,  STUDENT,  REVIEWER) VALUES ("
                    . ":pw_hash, :first_name, :last_name, :company, :address_1, :address_2, :city, :state, :zip_code, :phone_number, :email, :admin, :attendee, :presenter, :student, :reviewer)");

            $stmt->bindParam(':pw_hash', $this->pwHash);
            $stmt->bindParam(':first_name', $this->firstName);
            $stmt->bindParam(':last_name', $this->lastName);
            $stmt->bindParam(':company', $this->compOrg);
            $stmt->bindParam(':address_1', $this->address1);
            $stmt->bindParam(':address_2', $this->address2);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':state', $this->state);
            $stmt->bindParam(':zip_code', $this->zipCode);
            $stmt->bindParam(':phone_number', $this->phone);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':admin', $this->admin);
            $stmt->bindParam(':attendee', $this->attendee);
            $stmt->bindParam(':presenter', $this->presenter);
            $stmt->bindParam(':student', $this->student);
            $stmt->bindParam(':reviewer', $this->reviewer);

            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        unset($_SESSION['userVars']);
        $this->clear();
        return 'NONE';
    }

    public function insertNew($pwd, $firstName, $lastName, $company, $attendee, $presenter, $student, $reviewer, $address, $address_2, $city, $state, $zip, $phone, $email) {
        //return "NOT IMPLEMENTED";
        //echo("Insert pw hash:" . $this->pwHash . "</br>");


        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table ("
                    . "PW_HASH,   FIRST_NAME, LAST_NAME,  COMPANY,  ADDRESS_1,  ADDRESS_2,  CITY,  STATE,  ZIP_CODE,  PHONE_NUMBER,  EMAIL,  ADMIN,  ATTENDEE,  PRESENTER,  STUDENT,  REVIEWER) VALUES ("
                    . ":pw_hash, :first_name, :last_name, :company, :address_1, :address_2, :city, :state, :zip_code, :phone_number, :email, :admin, :attendee, :presenter, :student, :reviewer)");

            $hash = sha1($pwd);
            $stmt->bindParam(':pw_hash', $hash);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':address_1', $address);
            $stmt->bindParam(':address_2', $address_2);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':zip_code', $zip);
            $stmt->bindParam(':phone_number', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':admin', $this->admin);
            $stmt->bindParam(':attendee', $attendee);
            $stmt->bindParam(':presenter', $presenter);
            $stmt->bindParam(':student', $student);
            $stmt->bindParam(':reviewer', $reviewer);

            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }


        return 'NONE';
    }

    /**
     * returns a list of all user ids with full names, suitable for HTML SELECT input
     */
    public function getIdFullNameList(){
        $stmt = $this->pdo->prepare("SELECT "
                . "ID, "
                . " CONCAT(  `FIRST_NAME` ,  ' ',  `LAST_NAME` ) AS `FULL_NAME`  "
                . " FROM $this->table");
        $stmt->execute();
        $fullNameList = $stmt->fetchAll();
        return $fullNameList;
    }
    
    /**
     * Updates a single field on a single record. Returns "" on success, or 
     * error message on failure.
     * @param type $userID  user id of record to update
     * @param type $fieldName   name of field to updat
     * @param type $fieldValue new value for $fieldName
     * @return string
     */
    public function updateSingleField($userID, $fieldName, $fieldValue){
//        echo("<br>Updating USER...<br>");
        
        $sql = "UPDATE `$this->table` SET `$fieldName` = :fieldValue WHERE `ID` = :userID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':fieldValue', $fieldValue);
        $stmt->bindParam(':userID', $userID);
        
        try{
            $res = $stmt->execute();
        }catch (PDOException $e) {
//            echo("<br>Updating USER EXCEPTION...<br>");
            return $e->getMessage();
        }
        
        if(!$res){
//            echo("<br>Updating USER Failed...<br>");
            return "Update failed";
        }
        
//        echo("<br>Updating USER OK...<br>");
        return '';
    }
}
?>

