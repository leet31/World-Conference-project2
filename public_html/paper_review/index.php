<?php
/**
 * PAPER REVIEW
 */
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (!isset($_SESSION['userRec'])){
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
$editPaperList = $PM->getEditPaperList('',$_SESSION['userRec']['ID']);

$validate = new Validate();
$fields = $validate->getFields();

$action = filter_input(INPUT_POST, 'log_action');

if ($action === NULL) {
    $action = 'reset';
} else {
    $action = strtolower($action);
}


//error_log("Action: ".$action."\n");
    
switch ($action) {
        
    case 'reset':
        $title='';
        
        include 'paperreview.php';
        
        break;
    
    case 'download':
        $PM->clear();
        $PM->fileName = trim(filter_input(INPUT_POST,'fileName'));
        $PM->localFileName = trim(filter_input(INPUT_POST,'localFileName'));
        $errMsg = $PM->viewDoc();
        //include 'paperreview.php';
        if($errMsg != 'NONE'){
            echo("<div>$errMsg</div>");
        }
        
        break;
}

