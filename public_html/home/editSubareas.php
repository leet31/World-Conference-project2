<!DOCTYPE html>
<?php
require '../../controllers/connectDb.php';
require '../../models/SubareaModel.php';

$SAM = new SubareaModel($pdo);

//perform requested action, if any
$errMsg = $SAM->doAction();

//get subareas list as an array
$allList = $SAM->getList();

//get area list IDs and Names as an array
$parentList = $SAM->getParentList();
?>
<html>
    <head>
        <title>Edit Content Subareas</title>
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
        <?php echo(file_get_contents('.\menu.php')) ?>

        <div><h2>Edit Content Subareas</h2></div>
        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                <table>
                    <tr>
                        <th colspan="3" style="font-size:larger ">Insert New Content Subarea:</th>
                    </tr>
                    <tr>
                        <th>Parent Area</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td>
                            <select name="parentID">
                                <?php
                                foreach($parentList as $parent){
                                    echo("<option value ='".$parent['ID']."'>".$parent['NAME']."</option>");
                                }
                                ?>
                            </select>
                        </td>
                        <td> <input type="text" name="subareaName"></td>
                        <td> <textarea cols="50" rows="5" name="subareaDesc"></textarea></td>
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
                    <th>Parent</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
                <?php
                foreach ($allList as $row) {
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
                    "<input type='hidden' name='subareaID' value=" . $row['ID'] . ">" . "\n");
                    echo("<select name='parentID'>");
                    foreach($parentList as $parent){
                        echo("<option value ='".$parent['ID']."'");
                        echo($parent["ID"]==$row['PARENT_ID']?" selected ":"");
                        echo(">".$parent['NAME']."</option>");
                    }
                                
                    echo("</select>");
                        echo("<td><input type='text' name= 'subareaName' value='" . $row['NAME'] . "'></td>" . "\n" .
                    "<td><textarea cols='50' rows='5' name='subareaDesc'>" . $row['DESCRIPTION'] . "</textarea></td>" . "\n" .
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
