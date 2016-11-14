<?php
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)){
    header("Location: ../login");
    die();
}

require_once '../../models/fields.php';
require_once '../../models/validate.php';
require '../../controllers/connectDb.php';
require_once '../../models/UserModel.php';
require_once '../../models/PaperModel.php';
require_once '../../models/SubareaModel.php';

$UM = new UserModel($pdo);
$PM = new PaperModel($pdo);
$SM = new SubareaModel($pdo);

//data for select/option drop-down list
$areaSubareaList = $SM->getAreaSubAreaList();

//data for previously submitted papers
$editPaperList = $PM->getEditPaperList($_SESSION['userRec']['ID']);

$validate = new Validate();
$fields = $validate->getFields();

$fields->addField('title', 'Title of paper');
$fields->addField('fileChooser', 'Document file to upload - 1GB Max');
$fields->addField('subarea','Select the knowlege Area | Subarea for your paper.');

$action = filter_input(INPUT_POST, 'log_action');
if(isset($_SESSION['username'])) {
    include '../login';
} else {
    if($action === NULL){
        $action = 'reset';
    }else {
    $action = strtolower($action);
    }
}

//if ($action === NULL) {
//    $action = 'reset';
//} else {
//    $action = strtolower($action);
//}

switch ($action) {
    case 'reset':
        $title='';
        
        include 'papersubmission.php';
        
        break;
    
    case 'submit':
        $PM->authorID = $_SESSION['userRec']['ID'];
        $PM->reviewerID = '';
        $PM->subareaID = trim(filter_input(INPUT_POST,'subareaID'));
        $PM->title = trim(filter_input(INPUT_POST,'title'));
        
        $errMsg = $PM->insert();
        
        if ($errMsg != 'NONE') {
            include 'paper_submit_success.php';
        } else {
            include 'paper_submit_fail.php';
            echo '<div>' . $errMmsg . '</div>';
        }

        //include 'papersubmission.php';

        break;
}

