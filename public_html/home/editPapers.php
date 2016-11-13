<!DOCTYPE html>
<?php
require '../../controllers/connectDb.php';
require '../../models/PaperModel.php';
require '../../models/UserModel.php';
require '../../models/AreaModel.php';
require '../../models/SubareaModel.php';

$PM = new PaperModel($pdo);
$UM = new UserModel($pdo);
$AM = new AreaModel($pdo);
$SM = new SubareaModel($pdo);

//perform requested action, if any
$errMsg = $PM->doAction();

//get paper list as an array
$allList = $PM->getList();
$userList = $UM->getIdFullNameList();
$areaList = $AM->getIdNameList();
$subareaList = $SM->getIdNameParentList();
$editPaperList = $PM->getEditPaperList();
?>
<html>
    <head>
        <title>Edit Papers</title>
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
        <?php include('../home/menu.php') ?>
        <?php // foreach($userList as $row){
            //echo("</br>ID: ".$row['ID']);
            //echo("<br>Name: ".$row['FULL_NAME']);
        //}
        ?>
        <div><h2>Edit Papers</h2></div>
        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '' && strtoupper($errMsg) != 'NONE') echo "<div><h3>$errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post' enctype="multipart/form-data">
                <table>
                    <tr>
                        <th colspan="12" style="font-size:larger ">Insert New/Edit Paper:</th>
                    </tr>
                    <tr>
                        <th>Author Name</th>
                        <th>Reviewer Name</th>
                        <th>Area</th>
                        <th>Subarea</th>
                        <th>Title</th>
                        <th>Document</th>
                    </tr>
                    <tr>

                        <td style="display:none"> <!-- hidden primary key for update/delete -->
                            <input type="hidden" name="paperID"    id="paperID"    value='<?php echo($PM->paperID)  ?>'>
                            <input type="hidden" name="authorID"   id="authorID"   value='<?php echo($PM->authorID)  ?>'>
                            <input type="hidden" name="reviewerID" id="reviewerID" value='<?php echo($PM->reviwerID) ?>'>
                            <input type="hidden" name="areaID"     id="areaID"     value='<?php echo($PM->areaID)    ?>'>
                            <input type="hidden" name="subareaID"  id="subareaID"  value='<?php echo($PM->subareaID) ?>'>
                        </td>
                        <td> 
                            <select name="newAuthorID">
                                <?php
                                if($PM->authorID == ''){echo("<option disabled selected value> -- select an option -- </option>");}
                                foreach($userList as $row){
                                    echo("<option value='".$row['ID']."'".($row['ID']==$PM->authorID?"selected":"").">".$row['FULL_NAME']."</option>\n");
                                }
                                ?>
                            </select> 
                        </td>
                        <td> 
                            <select name="newReviewerID">
                                <?php
                                if($PM->reviewerID == ''){echo("<option disabled selected value> -- select an option -- </option>");}
                                foreach($userList as $row){
                                    echo("<option value='".$row['ID']."'".($row['ID']==$PM->reviewerID?"selected":"").">".$row['FULL_NAME']."</option>\n");
                                }
                                ?>
                            </select> 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="areaName"   value='<?php echo($PM->areaName) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="subareaName"  value='<?php echo($PM->subareaName) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="title"  value='<?php echo($PM->title) ?>' >
                        </td>
                        <td>
                            <input name="document" type="file" class="inputFile" />
                        </td>
                        <td> 
                            <input type="button"  name="btnViewDoc"      value='View Document' > 
                        </td>
                                                <td> 
                            <?php
                            if ($UM->userID == "") {
                                echo('<input type="submit" name="btnInsert" value ="Insert"></br>');
                            } else {
                                echo('<input type="submit" name="btnUpdate" value ="Update"></br>');
                                echo('<input type="submit" name="btnDelete" value ="Delete"></br>');
                            }
                            ?>
                            <input type="reset" name="btnClear" value ="Reset">
                        </td>
                    </tr>
                </table>
            </form> 
        </div>
        <p>
        <div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Author Name</th>
                    <th>Reviewer Name</th>
                    <th>Area Name</th>
                    <th>Subarea Name</th>
                    <th>Title</th>
                </tr>
                <?php
                foreach ($editPaperList as $row) {
                    echo('<tr>');
                    echo("<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n"); 
                    echo('<td style="display:none">' . "\n"); 
                    echo("<input type='hidden' name='paperID' value=" . $row['ID'] . ">" . "\n");
                    echo("</td>" . "\n" );
                   
                    echo('<td>' . $row['ID'] . '</td>');
                    echo("<td>".$row['AUTHOR_FULL_NAME']."</td>" . "\n" );
                    echo("<td>".$row['REVIEWER_FULL_NAME'] . "</td>" . "\n" );
                    echo("<td>".$row['AREA_NAME'] . "</td>" . "\n");
                    echo("<td>".$row['SUBAREA_NAME'] . "</td>" . "\n");
                    echo("<td>".$row['TITLE'] . "</td>" . "\n");
                    echo("<td><input type='submit' name='btnEdit' value='Edit'></td>" . "\n" );
                    echo("</form>" . "\n");
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>

