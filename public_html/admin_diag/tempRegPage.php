<!DOCTYPE html>
<?php
require_once '../../controllers/connectDb.php';
require_once '../../models/UserModel.php';

$UM = new UserModel($pdo);

//perform requested action, if any
$errMsg = $UM->doAction();

if($errMsg == 'NONE'){
    	echo '<script type="text/javascript">';
	echo 'alert("Registration Successful");';
	echo 'window.location.replace("index.php");';
	echo '</script>';
	exit();
}
?>

<html>
    <head>
        <title>Temp Reg Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Temp Registration</p>
        <?php include('../home/menu.php') ?>

        

        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>"?>
        <div><h3>Input Your Information</h3>
            <form name="regForm" action="#" method="POST">
                <table>
                    <tr>
                        <td  align="right">*First Name:</td>
                        <td><input name="firstName" id="firstName" type="text" value="<?php echo($UM->firstName)?>" > </td>
                    </tr>
                    <tr>
                        <td align="right">*Last Name:</td>
                        <td><input name="lastName" id="lastName" type="text" value="<?php echo($UM->lastName)?>" ></td>
                    </tr>
                    <tr>
                        <td align="right">Company/Organization:</td>
                        <td><input name="compOrg" id="compOrg" type="text" value="<?php echo($UM->compOrg)?>" ></td>
                    </tr>
                    <tr>
                        <td align="right">*Address Line 1:</td>
                        <td><input name="address1" id="address1" type="text" value="<?php echo($UM->address1)?>" ></td>
                    </tr>
                    <tr>
                        <td align="right">Address Line 2:</td>
                        <td><input name="address2" id="address2" type="text" value="<?php echo($UM->address2)?>" ></td>
                    </tr>
                    <tr>
                        <td>*City:</td>
                        <td>*State:</td>
                        <td>*Zip Code:</td>
                    </tr>
                    <tr>
                        <td><input name="city" id="city" type="text" value="<?php echo($UM->city)?>" ></td>
                        <td><input name="state" id="state" type="text" value="<?php echo($UM->state)?>" ></td>
                        <td><input name="zipCode" id="zipCode" type="text" pattern="[0-9]{5}" value="<?php echo($UM->zipCode)?>"  ></td>
                    </tr>
                    <tr>
                        <td align="right">Phone Number:</td>
                        <td><input name="phone" id="phone" type="text" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" value="<?php echo($UM->phone)?>" ></td>
                        <td align="right">*E-mail:</td>
                        <td><input name="email" id="email" type="email" value="<?php echo($UM->email)?>" ></td>
                    </tr>
                    <tr>
                        <td align="right">*Password:</td>
                        <td><input name="password1" id="password1" type="password"></td>
                        <td align="right">*Confirm Password:</td>
                        <td><input name="password2" id="password2" type="password"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>*Attendee Type: &nbsp;&nbsp;</td>
                        <td align="right"><input type="radio" name="attendeeType" value="presenter"  id="rbAtPresenter" <?php echo (($UM->attendeeType=="presenter")?"checked":"");?>></td><td>Presenter &nbsp;&nbsp;</td>
                        <td align="right"><input type="radio" name="attendeeType" value="student"    id="rbAtStudent"   <?php echo (($UM->attendeeType=="student")  ?"checked":"");?>></td><td>Student &nbsp;&nbsp;</td>
                        <td align="right"><input type="radio" name="attendeeType" value="neither"    id="rbAtNeither"   <?php echo (($UM->attendeeType=="neither")  ?"checked":"");?>>Neither</td>
                    </tr>
                    <tr><td><input type="submit" name="btnRegisterSubmit" value="Submit"></td></tr>

                </table>
            </form>
        </div>

    </body>
</html>
