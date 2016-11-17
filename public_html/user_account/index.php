<?php
require_once '../../models/fields.php';
require_once '../../models/validate.php';
require '../../controllers/connectDb.php';
require_once '../../models/UserModel.php';

$UM = new UserModel($pdo);

$validate = new Validate();
$fields = $validate->getFields();
$fields->addField('first_name', 'Must enter first name.');
$fields->addField('last_name', 'Must enter last name.');
$fields->addField('company_name');
$fields->addField('address', 'Must enter address.');
$fields->addField('address_2');
$fields->addField('city');
$fields->addField('state', 'Use 2 character abbreviation.');
$fields->addField('zip', 'Use 5 or 9 digit zip code.');
$fields->addField('phone', 'Use 9999999999 format');
$fields->addField('email', 'Must be a valid email address.');
$fields->addField('password', 'Leave it blank if no change.');
$fields->addField('verify_password', 'Leave it blank if no change.');
$fields->addField('attendee_type', 'Must pick one.');

//credit card fields
$fields->addField('card_type');
$fields->addField('card_number');
$fields->addField('exp_date');

  $UM->getUser($_SESSION['userRec']['ID']);
        $userID=$UM->userID;
        $first_name = $UM->firstName;
        $last_name = $UM->lastName;
        $company_name = $UM->compOrg;
        $address = $UM->address1;
        $address2 = $UM->address2;
        $city =$UM->city;
        $state = $UM->state;
        $zip = $UM->zipCode;
        $phone = $UM->phone;
        $email = $UM->email;
//        $password = '';
        $admin=$UM->admin;
        
       
        $attendee = $UM->attendee;
        $student = $UM->student;
        $presenter = $UM->presenter;
        $reviewer = $UM->reviewer;
        
        $typeString ='';
        if($attendee){
            $typeString.='Attendee|';
        }
        if($student){
            $typeString.='Student|';
        }
        if($presenter){
            $typeString.='Presenter|';
        }
        if($reviewer){
            $typeString='Reviewer|';
        }


$action = filter_input(INPUT_POST, 'account_action');



if ($action === NULL) {
    $action = 'load';
} else {
    $action = strtolower($action);
}
switch ($action) {
    case 'load':
      
        //below is about the credit card
//        $cardType = '';
//        $cardNumber = '';
//        $cardDigits = '';
//        $expDate = '';
      
        include 'load_account.php';
        break;
    case 'cancel':
        include 'load_account.php';
        break;
    case 'reset':
        $first_name = '';
        $last_name = '';
        $company_name = '';
        $address = '';
        $address2 = '';
        $city = '';
        $state = '';
        $zip = '';
        $phone = '';
        $email = '';
        $password = '';
        $verify_password = '';
        $attendee_type='';
        $attendee = FALSE;
        $student = FALSE;
        $presenter = FALSE;
        $reviewer = FALSE;
        //below is about the credit card
        $cardType = '';
        $cardNumber = '';
        $cardDigits = '';
        $expDate = '';
        include 'edit_account.php';
        break;
    case 'edit':
        include 'edit_account.php';
        break;
    case 'update':
        $userID = $_SESSION['userRec']['ID'];
        $first_name = trim(filter_input(INPUT_POST, 'first_name'));
        $last_name = trim(filter_input(INPUT_POST, 'last_name'));
        $company_name = trim(filter_input(INPUT_POST, 'company_name'));
        $address = trim(filter_input(INPUT_POST, 'address'));
        $address2 = trim(filter_input(INPUT_POST, 'address_2'));
        $city = trim(filter_input(INPUT_POST, 'city'));
        $state = filter_input(INPUT_POST, 'state');
        $zip = filter_input(INPUT_POST, 'zip');
        $phone = filter_input(INPUT_POST, 'phone');
        $email = filter_input(INPUT_POST, 'email');
//        $password = filter_input(INPUT_POST, 'password');
//        $verify_password = filter_input(INPUT_POST, 'verify_password');
//        $attendee_type = (isset($_POST['attendee_type'])?$_POST['attendee_type']:null);

        //validate form data
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);
        $validate->text('address', $address); //address2 doesn't need validate
        $validate->text('city', $city);
        $validate->text('company_name', $company_name, false);
        $validate->text('address_2', $address2, false);
        $validate->state('state', $state);
        $validate->zip('zip', $zip);
        $validate->phone('phone', $phone);
        $validate->email('email', $email);
//        $validate->password('password', $password, false);
//        $validate->verify('verify_password', $password, $verify_password, false);
//        $validate->attendee('attendee_type', $attendee_type);
//        $attendee = FALSE;
//        $presenter = FALSE;
//        $student = FALSE;
//        $reviewer = FALSE;
//        if (count($attendee_type) > 0) {
//            foreach ($attendee_type as $temp) {
//                if ($temp == 'attendee') {
//                    $attendee = TRUE;
//                }
//                if ($temp == 'presenter') {
//                    $presenter = TRUE;
//                }
//                if ($temp == 'student') {
//                    $student = TRUE;
//                }
//                if ($temp == 'reviewer') {
//                    $reviewer = TRUE;
//                }
//            }
//        }

        if ($fields->hasErrors()) {
            include 'edit_account.php';
        } else {     
            $msg = $UM->updateNew($userID, $first_name, $last_name, $company_name, $address, $address2, $city, $state, $zip, $phone, $email);
            include 'result.php';
           
                echo '<div>' . $msg . '</div>';
        }
        break;
}

