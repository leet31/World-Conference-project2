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
        <?php echo(file_get_contents('../home/menu.php')) ?>

        <div><h2>Edit Papers</h2></div>
        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '' && strtoupper($errMsg) != 'NONE') echo "<div><h3>$errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
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
                            <input type="hidden" name="paperID"    id="authorID"   value='<?php echo($PM->authorID)  ?>'>
                            <input type="hidden" name="reviewerID" id="reviewerID" value='<?php echo($PM->reviwerID) ?>'>
                            <input type="hidden" name="areaID"     id="areaID"     value='<?php echo($PM->areaID)    ?>'>
                            <input type="hidden" name="subareaID"  id="subareaID"  value='<?php echo($PM->subareaID) ?>'>
                        </td>
                        <td> 
                            <input type="text" required style="width:100px;" name="firstName" value='<?php echo($UM->firstName) ?>' > 
                        </td>
                        <td> 
                            <input type="text" required style="width:100px;"  name="lastName"  value='<?php echo($UM->lastName) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="compOrg"   value='<?php echo($UM->compOrg) ?>' > 
                        </td>
                        <td> 
                            <input type="text" required style="width:100px;"  name="address1"  value='<?php echo($UM->address1) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="address2"  value='<?php echo($UM->address2) ?>' >
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="city"      value='<?php echo($UM->city) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:40px;"   name="state"     value='<?php echo($UM->state) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:60px;"   name="zipCode" pattern="[0-9]{5}"  value='<?php echo($UM->zipCode) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="phone" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" value='<?php echo($UM->phone) ?>' > 
                        </td>
                        <td> 
                            <input type="email" required style="width:150px;"  name="email"     value='<?php echo($UM->email) ?>' > 
                        </td>
                        <!--<td>
                            <input type='text' style="width:80px;" readonly name='pwFlag' id='pwFlag' 
                                   value='<?php #echo($UM->pwHash==""?"Not Set":"Set")  ?>'>
                        </td>-->
                        <td>
                            <input type="checkbox" name="cbAdmin"     <?php echo($UM->admin == "1" ? "checked" : "") ?> >Admin</br>
                            <input type="checkbox" name="cbAttend"    <?php echo($UM->attendee == "1" ? "checked" : "") ?> >Attendee</br>
                            <input type="checkbox" name="cbPresenter" <?php echo($UM->presenter == "1" ? "checked" : "") ?> >Presenter</br>
                            <input type="checkbox" name="cbStudent"   <?php echo($UM->student == "1" ? "checked" : "") ?> >Student</br>
                            <input type="checkbox" name="cbReviewer"  <?php echo($UM->reviewer == "1" ? "checked" : "") ?> >Reviewer</br>
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
                            <input type="reset" name="btnClear" value ="Reset"></br>                            
                            <input type="button" name="btnPassword" id="btnPassword"
                                   value='Set/Reset PW'
                                   onclick="setPw();">
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
                <?php
                foreach ($allList as $row) {
                    echo('<tr>');
                    echo('<td>' . $row['ID'] . '</td>');
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='userID' value=" . $row['ID'] . ">" . "\n" .
                    "</form>" . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='userID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='text' name= 'firstName' value='" . $row['FIRST_NAME'] . "'></td>" . "\n" .
                    "<td><input type='text' name= 'lastName' value='" . $row['LAST_NAME'] . "'></td>" . "\n" .
                    "<td><input type='text' name= 'email' value='" . $row['EMAIL'] . "'></td>" . "\n" .
                    "<td><input type='submit' name='btnEdit' value='Edit'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>

