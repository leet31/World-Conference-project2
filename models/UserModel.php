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
    public $pwHash = ';';
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

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') !== 'POST') {
            unset($_SESSION['userVars']);
        }

        if (isset($_SESSION['userVars'])) {
            $userVars = $_SESSION['userVars'];
            
//            echo("<p>Constructor -UserVars: ");
//            print_r($userVars);
//            echo("</p>");
            
            if ($userVars) {
                $this->userID = $userVars['userID'];
                $this->firstName = $userVars['firstName'];
                $this->lastName = $userVars['lastName'];
                $this->compOrg = $userVars['compOrg'];
                $this->address1 = $userVars['address1'];
                $this->address2 = $userVars['address2'];
                $this->city = $userVars['city'];
                $this->state = $userVars['state'];
                $this->zipCode = $userVars['zipCode'];
                $this->phone = $userVars['phone'];
                $this->email = $userVars['email'];
                $this->password1 = $userVars['password1'];
                $this->password2 = $userVars['password2'];
                $this->attendeeType = $userVars['attendeeType'];
            }
        }
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

            //save posted form values to array for session vars
            $userVars = array(
                "userID" => $this->userID,
                "firstName" => $this->firstName,
                "lastName" => $this->lastName,
                "compOrg" => $this->compOrg,
                "address1" => $this->address1,
                "address2" => $this->address2,
                "city" => $this->city,
                "state" => $this->state,
                "zipCode" => $this->zipCode,
                "phone" => $this->phone,
                "email" => $this->email,
                "password1" => $this->password1,
                "password2" => $this->password2,
                "attendeeType" => $this->attendeeType
            );

            //save posted vars in session to reload on error
            $_SESSION['userVars'] = $userVars;

            //determine which action was selected
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->deleteUser($this->userID);
            } else
            if (filter_input(INPUT_POST, 'btnUpdate')) {
                $errMsg = $this->update($this);
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insert($this);
            } else
            if (filter_input(INPUT_POST, 'btnRegisterSubmit')) {
                $errMsg = $this->submitRegistration();
            }else
            if (filter_input(INPUT_POST, 'btnLoginSubmit')) {
                $errMsg = $this->submitLogin();
            }
        }

        return $errMsg;
    }
    
    public function submitLogin(){
        $errMsg = '';
        
        //save posted variable to $this for possible insertion into table
        $this->email = filter_input(INPUT_POST, "email");
        
        //check for required variables
        if($this->email ==='' ||
           $this->password1 === ''){
            $errMsg = "All fields must be completed";
            return $errMsg;
        }
        
        $this->pwHash = sha1($this->password1);
        
        try {
            $stmt = $this->pdo->prepare("SELECT ID, FIRST_NAME, ADMIN,  ATTENDEE,  PRESENTER,  STUDENT,  REVIEWER FROM  $this->table "
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

    public function submitRegistration() {
        $errMsg = "None";

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

        return 'NONE';
    }
    
    public function insertNew($pwd, $firstName, $lastName, $company, $attendee, $presenter, $student, $reviewer, $address, $address_2, $city, $state, $zip, $phone, $email) {
        //return "NOT IMPLEMENTED";
        //echo("Insert pw hash:" . $this->pwHash . "</br>");


        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table ("
                    . "PW_HASH,   FIRST_NAME, LAST_NAME,  COMPANY,  ADDRESS_1,  ADDRESS_2,  CITY,  STATE,  ZIP_CODE,  PHONE_NUMBER,  EMAIL,  ADMIN,  ATTENDEE,  PRESENTER,  STUDENT,  REVIEWER) VALUES ("
                    . ":pw_hash, :first_name, :last_name, :company, :address_1, :address_2, :city, :state, :zip_code, :phone_number, :email, :admin, :attendee, :presenter, :student, :reviewer)");

            $stmt->bindParam(':pw_hash', sha1($pwd));
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

}
?>

