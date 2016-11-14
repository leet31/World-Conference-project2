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
$fields->addField('email', 'Must be a valid email address');
$fields->addField('password', 'Must be at least 6 characters.');
$fields->addField('verify_password', 'Must be same password.');
$fields->addField('attendee_type', 'Must pick one.');

//credit card fields
$fields->addField('card_type');
$fields->addField('card_number');
$fields->addField('exp_date');

$action = filter_input(INPUT_POST, 'reg_action');

if ($action === NULL) {
    $action = 'reset';
} else {
    $action = strtolower($action);
}
switch ($action) {
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

        include 'registration.php';
        break;

    case 'register':

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
        $password = filter_input(INPUT_POST, 'password');
        $verify_password = filter_input(INPUT_POST, 'verify_password');
        $attendee_type = (isset($_POST['attendee_type'])?$_POST['attendee_type']:null);

        //below is about credit card
        $cardType = filter_input(INPUT_POST, 'card_type');
        $cardNumber = filter_input(INPUT_POST, 'card_number');
        $cardDigits = preg_replace('/[^[:digit:]]/', '', $cardNumber); //delete the characters not number characters
        $expDate = filter_input(INPUT_POST, 'exp_date');

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
        $validate->password('password', $password);
        $validate->verify('verify_password', $password, $verify_password);
        $validate->attendee('attendee_type', $attendee_type);
        $attendee = FALSE;
        $presenter = FALSE;
        $student = FALSE;
        $reviewer = FALSE;
        if (count($attendee_type) > 0) {
            foreach ($attendee_type as $temp) {
                if ($temp == 'attendee') {
                    $attendee = TRUE;
                }
                if ($temp == 'presenter') {
                    $presenter = TRUE;
                }
                if ($temp == 'student') {
                    $student = TRUE;
                }
                if ($temp == 'reviewer') {
                    $reviewer = TRUE;
                }
            }
        }


//        
//         $userVars = array(
////             "userID" => $this->userID,
//                "firstName" => $first_name,
//                "lastName" => $last_name,
//                "compOrg" => $company_name,
//                "address1" => $address,
//                "address2" => $address2,
//                "city" => $city,
//                "state" => $state,
//                "zipCode" => $zip,
//                "phone" => $phone,
//                "email" => $email,
//                "attendee_type" => $attendee_type,
//             'password'=>$password,
//        );
        //validate credit card input
//        $validate->cardType('card_type', $cardType);
//        $validate->cardNumber('card_number', $cardDigits, $cardType);
//        $validate->expDate('exp_date', $expDate);
        if ($fields->hasErrors()) {
            include 'registration.php';
        } else {
            $msg = $UM->insertNew($password, $first_name, $last_name, $company_name, $attendee, $presenter, $student, $reviewer, $address, $address2, $city, $state, $zip, $phone, $email);
            if ($msg == 'NONE') {
//                $_SESSION['userVars']=$userVars;
                $UM->login($email, $password); //default login after register
                include 'register_success.php';
            } else {
                include 'register_fail.php';
                echo '<div>' . $msg . '</div>';
            }
        }
        break;
}

