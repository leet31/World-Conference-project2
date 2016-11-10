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
$fields->addField('phone', 'Use 999-999-9999 format');
$fields->addField('email', 'Must be a valid email address');
$fields->addField('password', 'Must be at least 6 characters.');
$fields->addField('verify_password', 'Must be same password.');
$fields->addField('attendee_type', 'Must pick one.');

//credit card fields
$fields->addField('card_type');
$fields->addField('card_number');
$fields->addField('exp_date');

$action = filter_input(INPUT_POST, 'reg_action');

if($action === NULL){
$action = 'reset';
}else {
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
        $attendee = '';
        $student = '';
        $presenter = '';
        $reviewer = '';
        //below is about the credit card
        $cardType = '';
        $cardNumber = '';
        $cardDigits = '';
        $expDate = '';

        include 'onlineregistration.php';
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
        $attendee_type = filter_input(INPUT_POST, 'attendee_type');
        
        //below is about credit card
        $cardType = filter_input(INPUT_POST, 'card_type');
        $cardNumber = filter_input(INPUT_POST, 'card_number');
        $cardDigits = preg_replace('/[^[:digit:]]/', '', $cardNumber); //delete the characters not number characters
        $expDate = filter_input(INPUT_POST, 'exp_date');

        //validate form data
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);
        //company name doesn't need validate
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
        if($attendee_type[0] == 'attendee') {
            $attendee = 1;
        } else {
            $attendee = 0;
        }
        if($attendee_type[1] == 'presenter') {
            $presenter = 1;
        }else {
            $presenter = 0;
        }
        if($attendee_type[2] == 'student') {
            $student = 1;
        }else {
            $student = 0;
        }
        if($attendee_type[3] == 'reviewer') {
            $reviewer = 1;
        }else {
            $reviewer = 0;
        }
        //validate credit card input
//        $validate->cardType('card_type', $cardType);
//        $validate->cardNumber('card_number', $cardDigits, $cardType);
//        $validate->expDate('exp_date', $expDate);
        if ($fields->hasErrors()) {
            
            include 'onlineregistration.php';
        }else {
            $UM->insertNew($password, $first_name, $last_name, $company_name, $attendee, $presenter, $student, $reviewer, $address, $address2, $city, $state, $zip, $phone, $email);
            include 'register_success.php';
        }
        break;

}

