<!DOCTYPE html>
<?php
require './PHP_helper/connectDb.php';
require './PHP_helper/WA_functions.php';

//perform requested action, if any
$errMsg = doProdCatAction($pdo);

$cat_ra = getProdCatList($pdo);
?>
<html>
    <head>
        <title>Test Category Model</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div><h2>Edit Product Categories</h2></div>
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div>
            <table>
                <tr>
                    <td>Insert New Category:</td>
                    <td>
                        <form action = "<?php $_SERVER['REQUEST_URI']?>" method='post'>
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
                    echo('<td>'."\n".
                            "<form action = ".$_SERVER['REQUEST_URI']." method='post'>"."\n".
                            "<input type='hidden' name='catID' value=".$row['ID'].">"."\n".
                            "<input type='submit' name='btnDelete' value='Delete'>"."\n".
                            "</form>"."\n".
                         '</td>'."\n");
                    echo('<td>'."\n".
                            "<form action = ".$_SERVER['REQUEST_URI']." method='post'>"."\n".
                            "<input type='hidden' name='catID' value=".$row['ID'].">"."\n".
                            "<input type='text' name= 'renameValue' value=''>"."\n".
                            "<input type='submit' name='btnRename' value='Rename'>"."\n".
                            "</form>"."\n".
                         '</td>'."\n");
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
