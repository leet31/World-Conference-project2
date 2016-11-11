<!DOCTYPE html>
<?php
require '../../controllers/connectDb.php';
require '../../models/ProdCatModel.php';

$PCM = new ProdCatModel($pdo);

//perform requested action, if any
$errMsg = $PCM->doAction();

//get product categories list as an array
$cat_ra = $PCM->getList();
?>
<html>
    <head>
        <title>Test Category Model</title>
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
        </style>


    </head>
    <body>
        <?php echo(file_get_contents('.\menu.html')) ?>

        <div><h2>Edit Product Categories</h2></div>
        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                <table>
                    <tr>
                        <th colspan="2" style="font-size:larger ">Insert New Category:</th>
                    </tr>
                    <tr>
                        <th>Category Name</th>
                    </tr>
                    <tr>
                        <td> <input type="text" name="catName"></td>
                        <td> <input type="submit" name="btnInsert" value ="Insert"></td>
                    </tr>
                </table>
            </form>
        </div>
        <p>
        <div>
            <table>
                <tr>
                    <th>ID</th>
                    <th></th>
                    <th>Name</th>
                </tr>
                <?php
                foreach ($cat_ra as $row) {
                    echo('<tr>');
                    echo('<td>' . $row['ID'] . '</td>'); #<td>' . $row['CATEGORY_NAME'] . '</td>');
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='catID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='submit' name='btnDelete' value='Delete'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='catID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='text' name= 'catName' value='" . $row['CATEGORY_NAME'] . "'></td>" . "\n" .
                    "<td><input type='submit' name='btnUpdate' value='Update'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>
