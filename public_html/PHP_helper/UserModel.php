<?php

class UserModel {

    private $pdo;
    
    public $firstName;
    public $lastName;
    public $compOrg;
    public $address;
    public $address2;
    public $city;
    public $state;
    public $zipCode;
    public $phone;
    public $email;
    public $password;
    public $password2;
    public $attendeeType;
 
    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function doAction() {
        $errMsg = '';

        print_r($_POST);
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            echo
            //save posted vars
            $this->firstName    = filter_input(INPUT_POST, "firstName");
            $this->lastName     = filter_input(INPUT_POST, "lastName");
            $this->compOrg      = filter_input(INPUT_POST, "compOrg ");
            $this->address      = filter_input(INPUT_POST, "address");
            $this->address2     = filter_input(INPUT_POST, "address2");
            $this->city         = filter_input(INPUT_POST, "city");
            $this->state        = filter_input(INPUT_POST, "state");
            $this->zipCode      = filter_input(INPUT_POST, "zipCode");
            $this->phone        = filter_input(INPUT_POST, "phone");
            $this->email        = filter_input(INPUT_POST, "email");
            $this->password     = filter_input(INPUT_POST, "password");
            $this->password2    = filter_input(INPUT_POST, "password2");
            $this->attendeeType = filter_input(INPUT_POST, "attendeeType");
            
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->deleteProdCat(filter_input(INPUT_POST, 'catID'));
            } else
            if (filter_input(INPUT_POST, 'btnRename')) {
                $errMsg = $this->updateProdCat(filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'renameValue'));
            } else
            if (filter_input(INPUT_POST, 'btnInsert')) {
                $errMsg = $this->insertProdCat(filter_input(INPUT_POST, 'catName'));
            } else
            if (filter_input(INPUT_POST, 'btnRegisterSubmit')) {
                $errMsg = $this->submitRegistration();
            }
        }else{
            //recover posted vars from session and remove session vars
            $firstName    = filter_input(INPUT_SESSION, "firstName");
            $lastName     = filter_input(INPUT_SESSION, "lastName");
            $compOrg      = filter_input(INPUT_SESSION, "compOrg ");
            $address      = filter_input(INPUT_SESSION, "address");
            $address2     = filter_input(INPUT_SESSION, "address2");
            $city         = filter_input(INPUT_SESSION, "city");
            $state        = filter_input(INPUT_SESSION, "state");
            $zipCode      = filter_input(INPUT_SESSION, "zipCode");
            $phone        = filter_input(INPUT_SESSION, "phone");
            $email        = filter_input(INPUT_SESSION, "email");
            $attendeeType = filter_input(INPUT_SESSION, "attendeeType");
        }

        return $errMsg;
    }
    
    public function submitRegistration(){
        $errMsg = "None";
        
        $firstName    = filter_input(INPUT_POST, "firstName");
        $lastName     = filter_input(INPUT_POST, "lastName");
        $compOrg      = filter_input(INPUT_POST, "compOrg ");
        $address      = filter_input(INPUT_POST, "address");
        $address2     = filter_input(INPUT_POST, "address2");
        $city         = filter_input(INPUT_POST, "city");
        $state        = filter_input(INPUT_POST, "state");
        $zipCode      = filter_input(INPUT_POST, "zipCode");
        $phone        = filter_input(INPUT_POST, "phone");
        $email        = filter_input(INPUT_POST, "email");
        $password     = filter_input(INPUT_POST, "password");
        $password2    = filter_input(INPUT_POST, "password2");
        $attendeeType = filter_input(INPUT_POST, "attendeeType");
        
        if( !$firstName|| 
            !$lastName || 
            #!$compOrg  || 
            !$address  || 
            #!$address2 || 
            !$city     || 
            !$state    || 
            !$zipCode  || 
            #!$phone    || 
            !$email    || 
            !$password ||
            !$password2    ){
            
            $errMsg = "All fields marked with a '*' must be completed";
            return($errMsg);
            }
        
        if(!$password ||!$password2 || $password != $password2){
            $errMsg = "Passwords are missing or do not match";
            return($errMsg);
        }
        $pwHash = sha1($password);
        
        
    }

}

?>