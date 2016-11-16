<?php

/**
 * CONFERENCE REGISTER
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)) {
    header("Location: ../login");
    die();
}

require_once '../../models/fields.php';
require_once '../../models/validate.php';
require '../../controllers/connectDb.php';
require_once '../../models/UserModel.php';
require_once '../../models/PaperModel.php';

$UM = new UserModel($pdo);
$PM = new PaperModel($pdo);

$validate = new Validate();
$fields = $validate->getFields();

$fields->addField("cbRoAttendee","box is cheked for all registered attendees" );
$fields->addField("cbRoStudent","students get a discount, how much is not specified");
$fields->addField("cbRoPresenter"," box is checked if you will be presenting one or more papers");
$fields->addField("numberOfPapers","There is a 50% discount if two or more papers are submitted. To get the discount, submit the papers and then return here to register."); 
$fields->addField("cbAttendee","box is cheked for all registered attendees" );
$fields->addField("cbStudent","students get a discount, how much is not specified");
$fields->addField("cbPresenter"," box is checked if you will be presenting one or more papers");


$action = filter_input(INPUT_POST, 'log_action');
if ($action === NULL) {
    $action = 'reset';
} else {
    $action = strtolower($action);
}

//error_log("Action: ".$action."\n");

switch ($action) {

    case 'reset':
        include 'conferenceregister.php';

        break;

    default :
        include 'conferenceregister.php';

        break;
}

