<!DOCTYPE html>
<!-- temp PHP for debugging html-->
<?php
//$userID       =isset($_POST['userID'])      ? $_POST['userID']      :"1";
//$firstName    =isset($_POST['firstName'])   ? $_POST['firstName']   :"John";
//$lastName     =isset($_POST['lastName'])    ? $_POST['lastName']    :"Doe";
//$company      =isset($_POST['company'])     ? $_POST['company']     :"Bigly Corp";
//$address1     =isset($_POST['address1'])    ? $_POST['address1']    :"123MainSt.";
//$address2     =isset($_POST['address2'])    ? $_POST['address2']    :"Apt.23G";
//$city         =isset($_POST['city'])        ? $_POST['city']        :"Myfair City";
//$state        =isset($_POST['state'])       ? $_POST['state']       :"KY";
//$zipCode      =isset($_POST['zipCode'])     ? $_POST['zipCode']     :"54321";
//$phoneNumber  =isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] :"(123)456-7890";
//$email        =isset($_POST['email'])       ? $_POST['email']       :"john.doe@bigly.com";
//$admin        =isset($_POST['admin']    )   ? $_POST['admin']       :"0";
//$attendee     =isset($_POST['attendee'] )   ? $_POST['attendee']    :"0";
//$presenter    =isset($_POST['presenter'])   ? $_POST['presenter']   :"0";
//$student      =isset($_POST['student']  )   ? $_POST['student']     :"0";
//$reviewer     =isset($_POST['reviewer'] )   ? $_POST['reviewer']    :"0";
?>

<?php
require '../controllers/connectDb.php';
require '../models/UserModel.php';

$UM = new UserModel($pdo);

//perform requested action, if any
$errMsg = $UM->doAction();
//echo($UM);

//get user list as an array
$allList = $UM->getList();
?>
<html>
    <head>
        <title>Edit Users</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
        <style>
            table, th, td{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php echo(file_get_contents('.\menu.html')) ?>

        <div><h2>Edit Users</h2></div>
        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>$errMsg</h3><div>" ?>
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
                    </tr>
                    <tr>
                        
                        <td style="display:none"> <!-- hidden primary key for update/delete -->
                            <input type="hidden" name="userID" value='<?php echo($UM->userID) ?>'>
                        </td>
                        <td> <input type="text"  size="10" name="firstName" value='<?php echo($UM->firstName)?>' > </td>
                        <td> <input type="text" size="10"  name="lastName"  value='<?php echo($UM->lastName) ?>' > </td>
                        <td> <input type="text" size="10"  name="compOrg"   value='<?php echo($UM->compOrg)  ?>' > </td>
                        <td> <input type="text" size="10"  name="address1"  value='<?php echo($UM->address1) ?>' > </td>
                        <td> <input type="text" size="10"  name="address2"  value='<?php echo($UM->address2) ?>' > </td>
                        <td> <input type="text" size="10"  name="city"      value='<?php echo($UM->city)     ?>' > </td>
                        <td> <input type="text" size="1"   name="state"     value='<?php echo($UM->state)    ?>' > </td>
                        <td> <input type="text" size="6"   name="zipCode"   value='<?php echo($UM->zipCode)  ?>' > </td>
                        <td> <input type="text" size="10"  name="phone"     value='<?php echo($UM->phone)    ?>' > </td>
                        <td> <input type="text" size="15"  name="email"     value='<?php echo($UM->email)    ?>' > </td>
                        <td>
                            <input type="checkbox" name="cbAdmin"     <?php echo($UM->admin    =="1"?"checked":"") ?> >Admin</br>
                            <input type="checkbox" name="cbAttend"    <?php echo($UM->attendee =="1"?"checked":"") ?> >Attendee</br>
                            <input type="checkbox" name="cbPresenter" <?php echo($UM->presenter=="1"?"checked":"") ?> >Presenter</br>
                            <input type="checkbox" name="cbStudent"   <?php echo($UM->student  =="1"?"checked":"") ?> >Student</br>
                            <input type="checkbox" name="cbReviewer"  <?php echo($UM->reviewer =="1"?"checked":"") ?> >Reviewer</br>
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
                            <input type="reset" name="btnClear" value ="Clear">
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
