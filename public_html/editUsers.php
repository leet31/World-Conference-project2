<!DOCTYPE html>
<!-- temp PHP for debugging html-->
<?php
$ID           =isset($_POST['ID'])          ? $_POST['ID']          :"";
$firstName    =isset($_POST['firstName'])   ? $_POST['firstName']   :"John";
$lastName     =isset($_POST['lastName'])    ? $_POST['lastName']    :"Doe";
$company      =isset($_POST['company'])     ? $_POST['company']     :"Bigly Corp";
$address1     =isset($_POST['address1'])    ? $_POST['address1']    :"123MainSt.";
$address2     =isset($_POST['address2'])    ? $_POST['address2']    :"Apt.23G";
$city         =isset($_POST['city'])        ? $_POST['city']        :"MyfairCity";
$state        =isset($_POST['state'])       ? $_POST['state']       :"KY";
$zipCode      =isset($_POST['zipCode'])     ? $_POST['zipCode']     :"54321";
$phoneNumber  =isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] :"1234567890";
$email        =isset($_POST['email'])       ? $_POST['email']       :"0";
$admin        =isset($_POST['admin    '])   ? $_POST['admin    ']   :"0";
$attendee     =isset($_POST['attendee '])   ? $_POST['attendee ']   :"0";
$presenter    =isset($_POST['presenter'])   ? $_POST['presenter']   :"0";
$student      =isset($_POST['student  '])   ? $_POST['student  ']   :"0";
$reviewer     =isset($_POST['reviewer '])   ? $_POST['reviewer ']   :"0";
?>

<?php
require '../controllers/connectDb.php';
require '../models/UserModel.php';

$UM = new UserModel($pdo);

//perform requested action, if any
$errMsg = $UM->doAction();

//get user list as an array
$allList = $UM->getList();
?>
<html>
    <head>
        <title>Edit Users</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="./styles.css"/>
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
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                <table>
                    <tr>
                        <th colspan="10" style="font-size:larger ">Insert New/Edit User:</th>
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
                        <td> <input type="text" name="firstName"></td>
                        <td> <input type="text" name="lastName"></td>
                        <td> <input type="text" name="company"></td>
                        <td> <input type="text" name="address1"></td>
                        <td> <input type="text" name="address2"></td>
                        <td> <input type="text" name="city"></td>
                        <td> <input type="text" name="state"></td>
                        <td> <input type="text" name="zipCode"></td>
                        <td> <input type="text" name="phoneNumber"></td>
                        <td> <input type="text" name="email"></td>
                        <td> 
                            <input type="submit" name="btnInsert" value ="Insert">
                            <input type="reset" name="btnClear" value ="Clear">
                            <input type="submit" name="btnUpdate" value ="Update">
                            <input type="submit" name="btnDelete" value ="Delete">
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
                        "<input type='hidden' name='ID' value=" . $row['ID'] . ">" . "\n" .
                        "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('<td>' . "\n" .
                    "<form action = " . $_SERVER['REQUEST_URI'] . " method='post'>" . "\n" .
                    "<input type='hidden' name='ID' value=" . $row['ID'] . ">" . "\n" .
                    "<input type='text' name= 'firstName' value='" . $row['FIRST_NAME'] . "'></td>" . "\n" .
                    "<td><input type='text' name= 'lastName' value='" . $row['LAST_NAME'] . "'></td>" . "\n" .
                    "<td><input type='text' name= 'email' value='" . $row['EMAIL'] . "'></td>" . "\n" .
                    "<td><input type='submit' name='btnUpdate' value='Edit'>" . "\n" .
                    "</form>" . "\n" .
                    '</td>' . "\n");
                    echo('</tr>');
                }
                ?>

            </table>
        </div>
    </body>
</html>
