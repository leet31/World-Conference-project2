
<?php
/**
 * STORE
 */
require '../../controllers/connectDb.php';
require '../../models/ProdModel.php';
require '../../models/ProdCatModel.php';
require '../../models/OrderModel.php';
require '../../models/OrderDetailModel.php';
require '../../models/UserModel.php';
require_once '../../models/fields.php';
require_once '../../models/validate.php';

$validate = new Validate();
$fields = $validate->getFields();
//credit card fields
$fields->addField('card_type');
$fields->addField('card_number', 'Enter number with or without dashes.');
$fields->addField('exp_date', 'Use mm/yyyy format.');
$cardType = '';
$cardNumber = '';
$cardDigits = '';
$expDate = '';

if (!isset($_SESSION)) {
    session_start();
}

$PM = new ProdModel($pdo);
$CM = new ProdCatModel($pdo);
$OM = new OrderModel($pdo);
$ODM = new OrderDetailModel($pdo);
$UM = new UserModel($pdo);

//perform requested action, if any
//$errMsg_product = $PM->doAction();
//get product categories list as an array
$categories = $CM->getList();
$products = $PM->getList();
$products_array = array();
if (isset($_SESSION['userRec'])) {
    $user = $UM->getUser($_SESSION['userRec']['ID']);
}

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
$total_b_tax = 0;
$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

if ($action === NULL) {
    $action = 'overview';
} else {
    $action = strtolower($action);
}


switch ($action) {
    case 'overview':
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

        $total_b_tax = cart\get_subtotal();
        include('cart_view.php');
//        echo var_dump($products_array);
        break;
    case 'cart':
        $total_b_tax = cart\get_subtotal();
        include 'cart_view.php';
        break;
    case 'update':
        $qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);
        $product_id = filter_input(INPUT_POST, 'product_id');
        cart\update_item($product_id, $qty);
        $total_b_tax = cart\get_subtotal();
        include 'cart_view.php';
        break;
    case 'empty_cart':
        unset($_SESSION['cartRec']);
        include 'cart_view.php';
        break;
    case 'check_out':
        //below is about credit card

        if (!isset($_SESSION['cartRec']) || cart\getTotalQty() == 0) {
            include 'cart_view.php';
            echo '<div>Error: Shopping cart is empty! Please add item first!</div>';
        } else {
            if (!isset($_SESSION['userRec'])) {
                include '../login';
                echo '<div>Please log in first to check out!</div>';
            } else {
                $user_id = $_SESSION['userRec']['ID'];
                $total_b_tax = cart\get_subtotal();
                $tax = 0; //tax percentage is set to 0 for now.
                $balance = $total_b_tax * (1 + $tax / 100);
                include 'check_out.php';
            }
        }
        break;
    case 'pay':
        $user_id = $_SESSION['userRec']['ID'];
        $total_b_tax = cart\get_subtotal();
        $tax = 0; //tax percentage is set to 0 for now.
        $balance = $total_b_tax * (1 + $tax / 100);
        //show the information from session
        //check credit card first
        $cardType = filter_input(INPUT_POST, 'card_type');
        $cardNumber = filter_input(INPUT_POST, 'card_number');
        $cardDigits = preg_replace('/[^[:digit:]]/', '', $cardNumber); //delete the characters not number characters
        $expDate = filter_input(INPUT_POST, 'exp_date');
        //validate credit card input
        $validate->cardType('card_type', $cardType);
        $validate->cardNumber('card_number', $cardDigits, $cardType);
        $validate->expDate('exp_date', $expDate);
        if ($fields->hasErrors()) {
            include 'check_out.php';
        } else if (false) {//insert credit validation here
            //if credit card is not approved!
        } else {// start insert order to database
            $user_id = $_SESSION['userRec']['ID'];
            $total_b_tax = cart\get_subtotal();
            $tax = 0; //tax percentage is set to 0 for now.
            $balance = $total_b_tax * (1 + $tax / 100);
            $date= date("Y-m-d H:i:s");
//            $date = date('Y-d-m H:i:s', strtotime($date));
            $isPaid = FALSE;
            $result = $OM->insert($user_id, $balance, $date, $isPaid); //Order table insert into it.
            if ($result == 'NONE') {// insert order table
                $new_order = $OM->getNewOrderByCustomerID($user_id); 
                foreach ($_SESSION['cartRec'] as $line) {
                    $product_id = $line['id'];
                    $qty = $line['qty'];
                    $result = $ODM->insert($new_order["ID"], $product_id, $qty);
                    if ($result != '') {
//                            echo '<div>Something is wrong when generating order detail table in Database!</div> ';
                        break;
                    }
                }
                if ($result == '') {

                    $result = "Check it out successfully!";
                    /* todo: charge credit card...
                     * 
                     */

                    $OM->payOrder($new_order['ID']);
                    unset($_SESSION['cartRec']);
                }
            }
            include 'result.php';
            echo '<div>' . $result . '</div>';
        }
        break;
}
?>
