<?php
require_once '../models/fields.php';
require_once '../models/validate.php';

$validate = new Validate();
$fields = $validate->getFields();
$fields->addField('first_name');
$fields->addField('last_name');
$fields->addField('address');
$fields->addField('address_2');
$fields->addField('city');
$fields->addField('state','Use 2 character abbreviation.');
$fields->addField('zip', 'Use 5 or 9 digit zip code.');
$fields->addField('phone', 'Use 999-999-9999 format');
$fields->addField('email','Must be a valid email address');
$fields->addField('password', 'Must be at least 6 characters.');
$fields->addField('verify_password', 'Must be same password.');
$fields->addField('attendee_type', 'Must pick one.');

$action = filter_input(INPUT_POST, 'action') ;
if($action === NULL){
    $action = 'reset';
}else {
    $action = strtolower($action);
}
switch ($action) {
    case 'reset':
        $first_name='';
        $last_name='';
        $address='';
        $address2='';
        $city='';
        $state='';
        $zip='';
        $phone='';
        $email='';
        $password='';
        $verify_password='';
        $attendee_type='';
        include '../public_html/onlineregistration.php';
        break;
    case 'register':
         $first_name=trim(filter_input(INPUT_POST,'first_name'));
        $last_name=trim(filter_input(INPUT_POST,'last_name'));
        $address='';
        $address2='';
        $city='';
        $state='';
        $zip='';
        $phone='';
        $email='';
        $password='';
        $verify_password='';
        $attendee_type='';
        
        
}


