<!DOCTYPE html>
<?php
require './PHP_helper/connectDb.php';
require './PHP_helper/UserModel.php';

$UM = new UserModel($pdo);

//perform requested action, if any
$errMsg = $UM->doAction();
?>

<html>
    <head>
        <title>Temp Reg Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles.css">
    </head>
    <body>
        <?php echo(file_get_contents('.\menu.html')) ?>

        <div>Temporary Registration Page</div>
        <h2>Online Registration</h2>

        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>" ?>
        <div><h3>Input Your Information</h3>
            <form name="regForm action=" action="#" method="POST">
                <table>
                    <tr>
                        <td  align="right">*First Name:</td>
                        <td><input name="firstName" id="firstName" type="text" </td>
                    </tr>
                    <tr>
                        <td align="right">*Last Name:</td>
                        <td><input name="lastName" id="lastName" type="text"></td>
                    </tr>
                    <tr>
                        <td align="right">Company/Organization:</td>
                        <td><input name="compOrg" id="compOrg" type="text"></td>
                    </tr>
                    <tr>
                        <td align="right">*Address Line 1:</td>
                        <td><input name="address1" id="address1" type="text"></td>
                    </tr>
                    <tr>
                        <td align="right">Address Line 2:</td>
                        <td><input name="address2" id="address2" type="text"></td>
                    </tr>
                    <tr>
                        <td>*City:</td>
                        <td>*State:</td>
                        <td>*Zip Code:</td>
                    </tr>
                    <tr>
                        <td><input name="city" id="city" type="text"></td>
                        <td><input name="state" id="state" type="text"></td>
                        <td><input name="zipCode" id="zipCode" type="text" pattern="[0-9]{5}" ></td>
                    </tr>
                    <tr>
                        <td align="right">Phone Number:</td>
                        <td><input name="phone" id="phone" type="text" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}"></td>
                        <td align="right">*E-mail:</td>
                        <td><input name="email" id="email" type="email"></td>
                    </tr>
                    <tr>
                        <td align="right">*Password:</td>
                        <td><input name="password" id="password" type="password"></td>
                        <td align="right">*Confirm Password:</td>
                        <td><input name="password2" id="password2" type="password"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>*Attendee Type: &nbsp;&nbsp;</td>
                        <td align="right"><input name="attendeeType" id="rbAtPresenter" type="radio"></td><td>Presenter &nbsp;&nbsp;</td>
                        <td align="right"><input name="attendeeType" id="rbAtStudent" type="radio"></td><td>Student &nbsp;&nbsp;</td>
                        <td align="right"><input name="attendeeType" id="rbAtNa" type="radio">Neither</td>
                    </tr>
                    <tr><td><input type="submit" name="btnRegisterSubmit" value="Submit"></td></tr>

                </table>
            </form>
        </div>

    </body>
</html>
