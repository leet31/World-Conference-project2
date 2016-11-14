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
$areaSubareaList = $SM->getAreaSubAreaList();
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
        <script>
            function clearFields(){
                document.getElementById("authorID").value= "0";
                document.getElementById("reviewerID").value= "0";
                document.getElementById("subareaID").value= "0";
                document.getElementById("EditTitle").value= "";
                document.getElementById("fileChooser").value= "";
                document.getElementById("paperID").value= "";      
                document.getElementById("paperIDCell").innerHTML= "";      
                document.getElementById("fileName").value= "";
                document.getElementById("fileNameCell").innerHTML= "";
                document.getElementById("localFileName").value= "";
                document.getElementById("oldauthorID").value= "";  
                document.getElementById("oldreviewerID").value= "";
                document.getElementById("oldareaID").value= "";    
                document.getElementById("oldsubareaID").value= ""; 
                document.getElementById("btnCell").innerHTML= '<input type="submit" name="btnInsert" value ="Insert"></br>\n\
                                                               <button onclick="clearFields()" name="btnClear" id="btnClear">Clear</button>';      
                document.getElementById("errMsg").innerHTML= "";      
                document.getElementById("chooserCell").innerHTML = '<input name="document" id="fileChooser" type="file" class="inputFile" required /> ';
                //alert("done");
            }
        </script>
    </head>
    <body>
        <?php include('../home/menu.php') ?>
        <?php //  foreach($areaSubareaList as $row){
            //echo("</br>ID: ".$row['ID']);
            //echo("<br>Name: ".$row['NAME']);
        //}
        ?>
        <div><h2>Edit Papers</h2></div>
        <!--display error message, if any-->
        <div id="errMsg">
            <?php if (isset($errMsg) && $errMsg != '' && strtoupper($errMsg) != 'NONE') echo "<div><h3>$errMsg</h3><div>" ?>
        </div>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post' enctype="multipart/form-data" name="editForm" id="editForm">
                <table>
                    <tr>
                        <th colspan="12" style="font-size:larger ">Insert New/Edit Paper:</th>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>Author Name</th>
                        <th>Reviewer Name</th>
                        <th>Area | Subarea</th>
                        <th>Title</th>
                        <th>File Name</th>
                        <th>Upload Document</th>
                        <th>Download Document</th>
                    </tr>
                    <tr>

                        <td style="display:none"> <!-- hidden primary key for update/delete -->
                            <input type="hidden" name="paperID"       id="paperID"       value='<?php echo($PM->paperID)      ?>'>
                            <input type="hidden" name="fileName"      id="fileName"      value='<?php echo($PM->fileName)     ?>'>
                            <input type="hidden" name="localFileName" id="localFileName" value='<?php echo($PM->localFileName)?>'>
                            <input type="hidden" name="oldAuthorID"   id="oldauthorID"   value='<?php echo($PM->authorID)     ?>'>
                            <input type="hidden" name="oldReviewerID" id="oldreviewerID" value='<?php echo($PM->reviwerID)    ?>'>
                            <input type="hidden" name="oldAreaID"     id="oldareaID"     value='<?php echo($PM->areaID)       ?>'>
                            <input type="hidden" name="oldSubareaID"  id="oldsubareaID"  value='<?php echo($PM->subareaID)    ?>'>
                         </td>
                        <td id="paperIDCell">
                            <?php echo($PM->paperID)?>
                        </td>
                        <td> 
                            <select name="authorID" id="authorID" required>
                                <?php
                                if($PM->authorID == ''){echo("<option disabled selected value='0'> -- select an option -- </option>");}
                                foreach($userList as $row){
                                    echo("<option value='".$row['ID']."'".($row['ID']==$PM->authorID?"selected":"").">".$row['FULL_NAME']."</option>\n");
                                }
                                ?>
                            </select> 
                        </td>
                        <td> 
                            <select name="reviewerID" id="reviewerID">
                                <?php
                                if($PM->reviewerID == ''){echo("<option disabled selected value='0'> -- select an option -- </option>");}
                                foreach($userList as $row){
                                    echo("<option value='".$row['ID']."'".($row['ID']==$PM->reviewerID?"selected":"").">".$row['FULL_NAME']."</option>\n");
                                }
                                ?>
                            </select> 
                        </td>
                        <td> 
                            <select name="subareaID" id="subareaID" required>
                                <?php
                                if($PM->subareaID == ''){echo("<option disabled selected value='0'> -- select an option -- </option>");}
                                foreach($areaSubareaList as $row){
                                    echo("<option value='".$row['ID']."'".($row['ID']==$PM->subareaID?"selected":"").">".$row['NAME']."</option>\n");
                                }
                                ?>
                            </select> 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  required name="title"  id="EditTitle"  value='<?php echo($PM->title) ?>' >
                        </td>
                        <td id="fileNameCell"> 
                            <?php echo($PM->fileName) ?>
                        </td>
                        <td id="chooserCell">
                            <input name="document" id="fileChooser" type="file" class="inputFile" <?php echo($PM->localFileName == ''?"required":"disabled") ?> />
                        </td>
                        <td> 
                            <input type="submit"  name="btnViewDoc" id="btnViewDoc" <?php echo($PM->paperID == ''?"disabled":"") ?>     value='View Document' > 
                            
                        </td>
                        <td id="btnCell"> 
                            <?php
                            if ($PM->paperID == "") {
                                echo('<input type="submit" name="btnInsert" value ="Insert"></br>');
                            } else {
                                echo('<input type="submit" name="btnUpdate" value ="Update"></br>');
                                echo('<input type="submit" name="btnDelete" value ="Delete"></br>');
                            }
                            ?>
                            <button onclick="clearFields()" name="btnClear" id="btnClear">Clear</button>
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
                    <th>File Name</th>
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
                    echo("<td>".$row['FILENAME'] . "</td>" . "\n");
                    echo("<td><input type='submit' name='btnEdit' value='Edit'></td>" . "\n" );
                    echo("</form>" . "\n");
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>

