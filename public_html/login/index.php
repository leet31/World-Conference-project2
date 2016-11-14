<?php
require_once '../../models/fields.php';
require_once '../../models/validate.php';
require '../../controllers/connectDb.php';
require_once '../../models/UserModel.php';

$UM = new UserModel($pdo);

$validate = new Validate();
$fields = $validate->getFields();

$fields->addField('email', 'Must be a valid email address.');
$fields->addField('password', 'Must be at least 6 characters.');

$action = filter_input(INPUT_POST, 'log_action');

if ($action === NULL) {
    $action = 'reset';
} else {
    $action = strtolower($action);
}

switch ($action) {
    case 'reset':
        $email = '';
        $password = '';
        include 'login.php';

        break;
    case 'login':
        $email = trim(filter_input(INPUT_POST, 'email'));
        $password = trim(filter_input(INPUT_POST, 'password'));

        $validate->email('email', $email);
        $validate->password('password', $password);
        if ($fields->hasErrors()) {
            include 'login.php';
        } else {

            $msg = $UM->login($email, $password);
            if ($msg == 'NONE') {
                include 'login_success.php';
            } else {
                include 'login_fail.php';
                echo '<div>' . $msg . '</div>';
            }
        }

    break;
    
}

