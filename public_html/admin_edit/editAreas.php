<!DOCTYPE html>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)){
    header("Location: ../login");
    die();
}

require '../../controllers/connectDb.php';
require '../../models/AreaModel.php';

$PCM = new AreaModel($pdo);

//perform requested action, if any
$errMsg = $PCM->doAction();

//get product categories list as an array
$cat_ra = $PCM->getList();
?>
<html>
    <head>
        <title>Edit Content Areas</title>
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
        <p style="text-align: center; font-size: 36px;">Edit Top-Level Content Areas</p>
        <?php include('../home/menu.php') ?>

        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                <table>
                    <tr>
                        <th colspan="2" style="font-size:larger ">Insert New Content Area:</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td> <input type="text" name="areaName"></td>
                        <td> <textarea cols="50" rows="5" name="areaDesc"></textarea></td>
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
                    <th>Description</th>
                </tr>
                <?php
                foreach ($cat_ra as $row) {
                    echo('<tr>');
                    echo('<td>' . $row['ID'] . '</td>'); #<td>' . $row['CATEGORY_NAME'] . '</td>');
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='areaID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='submit' name='btnDelete' value='Delete'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='areaID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='text' name= 'areaName' value='" . $row['NAME'] . "'></td>" . "\n" .
                    "<td><textarea cols='50' rows='5' name='areaDesc'>" . $row['DESCRIPTION'] . "</textarea></td>" . "\n" .
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
