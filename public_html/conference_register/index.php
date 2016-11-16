<?php

/**
 * CONFERENCE REGISTER
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['userRec'])) {
    header("Location: ../login");
    die();
}

require_once '../../models/fields.php';
require_once '../../models/validate.php';
require '../../controllers/connectDb.php';
require_once '../../models/UserModel.php';
require_once '../../models/PaperModel.php';
require_once '../../models/ProdModel.php';

require '../../models/ProdCatModel.php';
require_once '../store/cart.php';


$UM = new UserModel($pdo);
$PM = new PaperModel($pdo);
$ProdM = new ProdModel($pdo);
$CM = new ProdCatModel($pdo);

$products = $ProdM->getList();
global $products_array;
$products_array = array();
foreach ($products as $product) {
    $products_array[$product['ID']] = $product;
}

$validate = new Validate();
$fields = $validate->getFields();

$fields->addField("cbRoAttendee", "checked for all registered attendees");
$fields->addField("cbRoStudent", "checked if you have declared yourself to be a student");
$fields->addField("cbRoPresenter", "checked if one or more of your submitted papers have been selected for presentation");
$fields->addField("cbRoReviewer", "checked if you have been selected to review submitted papers");
$fields->addField("numberOfPapers", "the number of papers you have submitted");
#$fields->addField("cbAttendee","box is cheked for all registered attendees" );
$fields->addField("cbStudent", "check this if you are a full-time student, and click Update");
#$fields->addField("cbPresenter"," box is checked if you will be presenting one or more papers");

$errMsg = '';
$paperCount = $PM->getPaperCountByAuthorId($_SESSION['userRec']['ID']);

//get full conference price to display
$regFeeInfo = $ProdM->getProductInfoByName('Conference Fees', 'No Discount');

//echo("<br>regFee: ");
//print_r($regFeeInfo);
//echo("<br>");

if (!(is_array($regFeeInfo) or ( $regFeeInfo instanceof Traversable))) {
    if (is_string($regFeeInfo)) {
        $errMsg .= "\n" . $regFeeInfo;
        $regFeeInfo = array('PRICE' => 'Err');
    }
}

$discountFeeInfo = '';
getDiscountFeeInfo();

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

    case 'submit':
        $msg = checkStudentStatusChanged();
        if ($msg == '') {
            if (empty($_SESSION['cartRec'])) {
                $_SESSION['cartRec'] = array(); //initial shopping cart
            }
            if (isset($_SESSION['cartRec'])) {
                $product_id = $discountFeeInfo['ID'];
                $qty = 1;
            }

            cart\add_item($product_id, $qty);

            $_SESSION['IS_REGISTERING'] = true;
            header("Location: ../store/?action=cart");
        } else {
            include 'conferenceregister.php';
            echo("<p>$msg</p>");
        }
        break;

    case 'update':
        $msg = checkStudentStatusChanged();
        include 'conferenceregister.php';
        echo("<p>$msg</p>");

        break;

    default :
        include 'conferenceregister.php';

        break;
}

function getDiscountFeeInfo() {
    global $errMsg;
    global $ProdM;
    global $discountFeeInfo;
    global $discountName;
    global $paperCount;

    //get full discounted price to display
    if ($paperCount < 2) {
        if ($_SESSION['userRec']['STUDENT']) {
            $discountName = 'Student Discount';
        } else {
            $discountName = 'No Discount';
        }
    } else {
        if ($_SESSION['userRec']['STUDENT']) {
            $discountName = 'Both Discounts';
        } else {
            $discountName = '2 Paper Discount';
        }
    }
    $discountFeeInfo = $ProdM->getProductInfoByName('Conference Fees', $discountName);
    if (!(is_array($discountFeeInfo) or ( $discountFeeInfo instanceof Traversable))) {
        if (is_string($discountFeeInfo)) {
            $errMsg .= "\n" . $discountFeeInfo;
            $discountFeeInfo = array('PRICE' => 'Err');
        }
    }
}

/**
 * Check if user changed Student role and update wa_users record and 
 * $_SESSION(['userRec'] if so.
 * Return '' on success or errormessage
 */
function checkStudentStatusChanged() {
    global $UM;
    $isStudentChecked = filter_input(INPUT_POST, 'cbStudent') != NULL;
    $msg = '';

    //if student checkbox changed, update User table
    if (($_SESSION['userRec']['STUDENT']) != $isStudentChecked) {
        $userID = $_SESSION['userRec']['ID'];
        $fieldName = 'STUDENT';
        $fieldValue = $isStudentChecked;
        $msg = $UM->updateSingleField($userID, $fieldName, $fieldValue);
        //if no error, update UserRec to match table
        if ($msg == '') {
            $_SESSION['userRec']['STUDENT'] = $isStudentChecked ? 1 : 0;
            getDiscountFeeInfo();
        }
    }
}
