<!DOCTYPE html>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)) {
    header("Location: ../login");
    die();
}

require '../../controllers/connectDb.php';
require '../../models/ProdModel.php';
require '../../models/ProdCatModel.php';
require '../../models/fields.php';
require '../../models/validate.php';
$PM = new ProdModel($pdo);
$CM = new ProdCatModel($pdo);

//img name and path
//perform requested action, if any
//get product categories list as an array
$cat_list = $CM->getList();
$product_list = $PM->getList();


$validate = new Validate();
$fields = $validate->getFields();
$fields->addField('category', 'Must pick category.');
$fields->addField('product_name', 'Must enter first name.');
$fields->addField('description', 'Must enter description.');
$fields->addField('price','Must enter a price.');

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}
if ($action == NULL) {
    $action = 'product_list';
}
$action = strtolower($action);

$product_name="";
$product_description="";

switch ($action) {
    case "product_list":
        include 'product_list.php';
        break;
     case 'update':
        
        break;
    case 'add':
        if (!isset($_FILES["file"])) {
            echo '<div>no image update</div>';
            $errMsg_product = $PM->doAction('default.png');
        } else {
            //check image type: .gif .png .jpeg
            if ($_FILES["file"]["type"] == "image/gif" || $_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/pjpeg" || $_FILES["file"]["type"] == "image/png" && $_FILES["file"]["size"] < 2000000) {
                if ($_FILES["file"]["error"] > 0) {
                    echo '<div>Error: ' . $_FILES["img"]["error"] . '<div>';
                } else {
                    $temp = explode(".", $_FILES["file"]["name"]);
                    $img_new_name = rount(imcrotime(true)) . '.' . end($temp);
                    $errMsg_product = $PM->doAction($img_new_name);
//                $img_src = "upload/".$img_new_name;
                }
            }
        }
        break;
}

