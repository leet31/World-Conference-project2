
<?php

require '../../controllers/connectDb.php';
require '../../models/ProdModel.php';
require '../../models/ProdCatModel.php';

 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$PM = new ProdModel($pdo);
$CM = new ProdCatModel($pdo);
//perform requested action, if any
//$errMsg_product = $PM->doAction();
//get product categories list as an array
$categories = $CM->getList();
$products = $PM->getList();
$products_array = array();

foreach ($products as $product) {
//    $products_array[$product['ID']] = array(
//        'id' => $product['ID'],
//        'name'=> $product['NAME'],
//        'description' =>$product['DESCRIPTION'],
//        'price'=>$product['PRICE']      
//            );
    $products_array[$product['ID']] = $product;
}
require_once('cart.php');
$total_b_tax=0;
$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

if ($action === NULL) {
    $action = 'store';
} else {
    $action = strtolower($action);
}


switch ($action) {
    case 'store':
        $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
        if ($category_id == NULL || $category_id == FALSE) {
            $category_id = 1;
        }
        $category_one = $CM->getListByID($category_id);
        $product_list = $PM->getListByCat($category_id);
        include 'store.php';
        break;
    case 'product_detail':
        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
        if ($product_id == NULL || $product_id == FALSE) {
            $error = 'Missing or incorrect product id.';
            include('../errors/error.php');
        } else {
            $product = $PM->getProductByID($product_id);

            include 'product_detail.php';
//            echo 'this is product detail';
            break;
        }
    case 'add':
        if (empty($_SESSION['cartRec'])) {
            $_SESSION['cartRec'] = array(); //initial shopping cart
        }
        if (isset($_SESSION['cartRec'])) {
            $product_id = filter_input(INPUT_POST, 'product_id');
            $qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);
        }
        $product = $PM->getProductByID($product_id);

        cart\add_item($product_id, $qty);
        
        $total_b_tax= cart\get_subtotal();
        include('cart_view.php');
//        echo var_dump($products_array);
        break;
    case 'cart':
        $total_b_tax= cart\get_subtotal();
        include 'cart_view.php';
        break;
    case 'update':
        $qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);
        $product_id= filter_input(INPUT_POST,'product_id');
        cart\update_item($product_id, $qty);
        $total_b_tax= cart\get_subtotal();
        include 'cart_view.php';
        break;
    case 'empty_cart':
        unset($_SESSION['cartRec']);
        include 'cart_view.php';
        break;
    case 'check_out':
        
        include 'blank.php';
        break;
}
?>
