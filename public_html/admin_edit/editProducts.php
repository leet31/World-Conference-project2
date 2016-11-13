<!DOCTYPE html>
<?php
require '../../controllers/connectDb.php';
require '../../models/ProdModel.php';
require '../../models/ProdCatModel.php';
$PM = new ProdModel($pdo);
$CM = new ProdCatModel($pdo);
//perform requested action, if any
$errMsg_product = $PM->doAction();
//get product categories list as an array
$cat_list = $CM->getList();
$product_list = $PM->getList();
?>
<html>
    <head>
        <title>Edit Category</title>
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
        </style>


    </head>
    <body>
    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Edit Categories</p>
        <?php include('../home/menu.php') ?>


        <!--display error message, if any-->


        <?php
        if (isset($errMsg_product)) {
            if ($errMsg_product == 'NONE') {
                echo '<div><h3>Update Successfully!</h3><div>';
            } else if ($errMsg_product != '') {
                echo "<div><h3>Product Error: $errMsg_product</h3><div>";
            }
        }
        ?>

        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
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
                        <td><input type="text" name="description"></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td><input type="text" name="price"></td>
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
                        <th colspan="7" style="font-size:larger ">Delete or Update Products</th>
                    </tr>
                <tr>
                    <th>ID</th>
                    <th></th>
                    <th></th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price
                    </th>
                </tr>
                <?php
                foreach ($product_list as $row) {
                    echo('<tr>');
                    echo('<td>' . $row['ID'] . '</td>');
                    echo '<form action = "' . $_SERVER['REQUEST_URI'] . '" method= "post">' .
                    '<td><input type="hidden" name="productID" value=" ' . $row['ID'] . '"></td>' .
                    '<td><input type="submit" name="btnDelete" value="Delete"></td>' .
                    '<td><select name="catID" value=" ' . $row['CATEGORY'] . '">';
                    foreach($cat_list as $cat){
                        if($cat['ID'] == $row['CATEGORY']) {
                            $cat_name = $cat['CATEGORY_NAME'];
                        }
                    }
                    echo '<option value="'.$row['CATEGORY'].'">'.$cat_name.'</option>';
                    foreach ($cat_list as $cat) {
                        echo '<option value="' . $cat['ID'] . '">' . $cat['CATEGORY_NAME'] . '</option>';
                    }
                    echo '</select>';
                    echo '</td>';
                    echo '<td><input type="text" name= "description" value="' . $row['DESCRIPTION'] . '"></td>' .
                    '<td><input type="text" name= "price" value="' . $row['PRICE'] . '"></td>' .
                    '<td><input type="submit" name="btnUpdate" value="Update"></td>' .
                    '</form>';
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>
