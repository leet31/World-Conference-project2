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
$PM = new ProdModel($pdo);
$CM = new ProdCatModel($pdo);

$errMsg_product = $PM->doAction();
//perform requested action, if any
//get product categories list as an array
?>
<html>
    <head>
        <title>Edit Product</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
        <style>
            table, th, td{
                border: 1px solid black;
            }
            input[type = submit]{
                margin: 0.0em;
                font-size: smaller;
                margin-right: 0em;
            }
            table{
                margin: auto;
            }
            img{
                width:150px;
                height:150px;
                pointer-events:none;
            }

        </style>


    </head>
    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Edit Product</p>
        <?php include('../home/menu.php') ?>


        <!--display error message, if any-->
        <?php
//        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            $name = $_FILES['file']['name'];
//
//            $tmp_name = $_FILES['file']['tmp_name'];
//            $type = $_FILES['file']['type'];
//            $size = $_FILES['file']['size'];
//
//            $extension = strtolower(substr($name, strpos($name, '.') + 1));
//            $new_name = time() . '.' . $extension;
//            if (isset($name)) {
//                if (!empty($name)) {
//                    if (($extension == 'png' AND $type = 'image/png') || ($extension == 'jpeg' AND $type = 'image/jpeg') || ($extension == 'gif' AND $type = 'image/gif') || ($extension == 'jpeg' AND $type = 'image/pjpeg')) {
//
//                        $location = 'upload/';
//
//                        if (move_uploaded_file($tmp_name, $location . $new_name)) {
//                            echo '<div>The image has been uploaded!</div>';
//                            $errMsg_product = $PM->doAction($new_name);
//                        } else {
//                            echo '<div>There were an error with the uploading.</div>';
//                        }
//                    } else {
//                        echo '<div>The file must be with png, jpeg, gif extension';
//                    }
//                } else {
//                    echo '<div>File has not been chosen</div>';
//                    $errMsg_product = $PM->doAction('default.png');
//                }
//            }
//        }
//
//            if ($name == NULL) {
//                $errMsg_product = $PM->doAction('default.png');
//            } else {
//                $temp = explode(".", $image);
////             if(end($temp)!='jpg'||end($temp)!='jpeg'||end($temp)!='png') {
////                 $errorFile = "Error: Only jpeg/jpg/png Type Allowed.";
////             } 
//                $errFile = '';
//                
//                if ($_FILES["myfile"]["size"] > 2000000) {
//                    $errFile .= "Error: File is bigger than 2000KB";
//                }
//                if (!getimagesize($_FILES["myfile"]["tmp_name"])) {
//                    $errFile .= "Error: Only jpeg/jpg/png Type Allowed.";
//                } else {
//                    $img_new_name = rount(imcrotime(true)) . '.' . end($temp);
//                    $target_dir = "upload/";
//                    $target_file = $target_dir . $img_new_name;
//                    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
//                        $errFile = "NONE";
//                    }
//                }
//                $errMsg_product = $PM->doAction($img_new_name);
////        }
        ?>



        <?php
        if (isset($errMsg_product)) {
            if ($errMsg_product != '') {
                echo '<div><h3>' . $errMsg_product . '</h3></div>';
            }
        }
        $cat_list = $CM->getList();
        $product_list = $PM->getList();
        ?>

        <div>
            <form name="newProductForm" action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post' enctype="multipart/form-data">
                <table>
                    <tr>
                        <th colspan="2" style="font-size:larger ">Insert New Product</th>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>

                            <?php
                            echo '<select name="catID">';
                            foreach ($cat_list as $cat) {
                                echo '<option value="' . $cat['ID'] . '">' . $cat['CATEGORY_NAME'] . '</option>';
                            }
                            echo '</select>'
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea name="description" cols="50" rows="15"></textarea></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <!--<td><input type="number" name="price" min="0" pattern="\d+(\.\d{2})?"></td>-->
                        <td><input type="number" name="price" min="0" step="any"></td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td><input type="file" name="file"></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td> <input type="submit" name="btnInsert" value ="Insert"></td>
                    </tr>
                </table>
            </form>
        </div>
        <p>
        <div>

            <table>
                <tr>
                    <th colspan="9" style="font-size:larger ">Delete or Update Products</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th></th>
                    <th></th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price
                    </th>
                    <td>Choose file to update new image.<br>Or there is no change on image.</td>
                    <th></th>
                </tr>
                <?php
                foreach ($product_list as $row) {
                    echo('<tr>');
                    echo('<td>' . $row['ID'] . '</td>');
                    echo '<form action = "' . $_SERVER['REQUEST_URI'] . '" method= "post" enctype="multipart/form-data">' .
                    '<td><input type="hidden" name="productID" value=" ' . $row['ID'] . '"></td>' .
                    '<td><input type="submit" name="btnDelete" value="Delete"></td>';
                    if ($row['IMG_NAME'] == '') {
                        echo '<td><img src="../product_images/default.png"></td>';
                    } else {
                        echo '<td><img src="../product_images/' . $row['IMG_NAME'] . '"></td>';
                    }
                    echo '<td><select name="catID" value=" ' . $row['CATEGORY'] . '">';
                    foreach ($cat_list as $cat) {
                        if ($cat['ID'] == $row['CATEGORY']) {
                            $cat_name = $cat['CATEGORY_NAME'];
                        }
                    }
                    echo '<option value="' . $row['CATEGORY'] . '">' . $cat_name . '</option>';
                    foreach ($cat_list as $cat) {
                        echo '<option value="' . $cat['ID'] . '">' . $cat['CATEGORY_NAME'] . '</option>';
                    }
                    echo '</select>';
                    echo '</td>';
                    echo
                    '<td><input type="text" name= "name" value="' . $row['NAME'] . '"></td>' .
                    '<td><input type="text" name= "description" value="' . $row['DESCRIPTION'] . '"></td>' .
                    '<td><input type="text" name= "price" value="' . number_format($row['PRICE'], 2) . '"></td>' .
                    '<td><input type="file" name="newfile"><input type="submit" name="btnUpdate" value="Update"></td>' .
                    '</form>';
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>
