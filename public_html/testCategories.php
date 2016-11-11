<!DOCTYPE html>
<?php
require '../controllers/connectDb.php';
require '../models/ProdCatModel.php';

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
            <link rel="stylesheet" type="text/css" href="css/styles.css">
    
    </head>
    <body>
        <?php echo(file_get_contents('.\menu.html')) ?>

        <div><h2>Edit Product Categories</h2></div>
        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div>
            <table>
                <tr>
                    <td>Insert New Category:</td>
                    <td>
                        <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                            <input type="text" name="catName">
                            <input type="submit" name="btnInsert" value ="Insert">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <p>
        <div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                <?php
                foreach ($cat_ra as $row) {
                    echo('<tr>');
                    echo('<td>' . $row['ID'] . '</td><td>' . $row['CATEGORY_NAME'] . '</td>');
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='catID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='submit' name='btnDelete' value='Delete'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='catID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='text' name= 'renameValue' value=''>" . "\n" .
                    "<input type='submit' name='btnRename' value='Rename'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
        <div>
            <p>This page demonstrates the use of the library functions toa
                insert, update, list, and delete product categories.</p>
            <p>Errors are returned on failures including duplicate or blank product category names.</p>
        </div>
    </body>
</html>
