<!DOCTYPE html>
<?php
require '../../controllers/connectDb.php';
require '../../models/UserModel.php';

$UM = new UserModel($pdo);

//perform requested action, if any
$errMsg = $UM->doAction();

//get user list as an array
$allList = $UM->getList();
?>
<html>
    <head>
        <title>Edit Users</title>
        <script>
            function setPwButtonStyle(){
                var pwHashInput = document.getElementById('pwHash').value;
                var hiddenPw = document.getElementById('hiddenPw').value;
                
                if(hiddenPw.length < 6 && pwHashInput.length < 40 ){
                    document.getElementById('btnPassword').value="Set PW";
                    document.getElementById('btnPassword').style.color='red';
                }else{
                    document.getElementById('btnPassword').value="Change PW";
                    document.getElementById('btnPassword').style.color='black';
                }
            }
            
            function setPw(){
                var pw1 = prompt("Input new password:");
                var pw2 = prompt("Re-input new password:");
                
                if (pw1 != pw2){
                    alert("Passwords do not match");
                    return;
                }
                
                if(pw1.length<6){
                    alert("Password is too short - 6 character minimum");
                    return;
                }
                
                document.getElementById("hiddenPw").value = pw1;
                setPwButtonStyle();
                alert('Password will be set when "Insert" is clicked');
                return;
            }
        </script>
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
    <body onload="setPwButtonStyle();">
        <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Edit Users</p>
         <?php include('../home/menu.php') ?>

        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '' && strtoupper($errMsg) != 'NONE') echo "<div><h3>$errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                <table>
                    <tr>
                        <th colspan="12" style="font-size:larger ">Insert New/Edit User:</th>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Company</th>
                        <th>Address Line 1</th>
                        <th>Address Line 2</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Roles</th>
                    </tr>
                    <tr>

                        <td style="display:none"> <!-- hidden primary key for update/delete -->
                            <input type="hidden" name="userID" value='<?php echo($UM->userID) ?>'>
                            <input type="hidden" name="pwHash" id="pwHash" value='<?php echo($UM->pwHash) ?>'>
                            <input type="hidden" name="hiddenPw" id="hiddenPw" value=''>
                        </td>
                        <td> 
                            <input type="text" required style="width:90px;" name="firstName" value='<?php echo($UM->firstName) ?>' > 
                        </td>
                        <td> 
                            <input type="text" required style="width:90px;"  name="lastName"  value='<?php echo($UM->lastName) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:100px;"  name="compOrg"   value='<?php echo($UM->compOrg) ?>' > 
                        </td>
                        <td> 
                            <input type="text" required style="width:100px;"  name="address1"  value='<?php echo($UM->address1) ?>' > 
                        </td>
                        <td> 
                            <input type="text" style="width:80px;"  name="address2"  value='<?php echo($UM->address2) ?>' >
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
                            <input type="email" required style="width:100px;"  name="email"     value='<?php echo($UM->email) ?>' > 
                        </td>
                        <!--<td>
                            <input type='text' style="width:80px;" readonly name='pwFlag' id='pwFlag' 
                                   value='<?php #echo($UM->pwHash==""?"Not Set":"Set") ?>'>
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
