<!DOCTYPE html>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)){
    header("Location: ../login");
    die();
}

require '../../controllers/connectDb.php';
require '../../models/UserModel.php';

$UM = new UserModel($pdo);

//perform requested action, if any
$errMsg = $UM->doAction();

if($errMsg == 'NONE'){
        $firstName = $_SESSION['userRec']['FIRST_NAME'];
    	echo '<script type="text/javascript">';
	echo 'alert("Login Successful!\nWelcome '.$firstName.'");';
	echo 'window.location.replace("index.php");';
	echo '</script>';
	exit();
}
?>

<html>
    <head>
        <title>Temp Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Temp Log In</p>
        <?php include('../home/menu.php') ?>
        <h2>Log In</h2>

        <!--display error message, if any-->
        <?php if (isset($errMsg) && $errMsg != '') echo "<div><h3>Error: $errMsg</h3><div>"?>
        <div><h3>Input Your Email Address and Password</h3>
            <form name="loginForm" action="#" method="POST">
                <table>
                    <tr>
                        <th align="right">Email Address:</th>
                        <td><input name="email" id="email" type="email" value="<?php echo($UM->email)?>" ></td>
                    </tr>
                    <tr>
                        <th align="right">Password:</th>
                        <td><input name="password1" id="password1" type="password"></td>
                    </tr>
                    <tr><td><input type="submit" name="btnLoginSubmit" value="Submit"></td></tr>
                </table>
            </form>
            
        </div>
  </body>
</html>
