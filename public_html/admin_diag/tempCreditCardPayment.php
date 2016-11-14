<!DOCTYPE html>
<!-- temp PHP for debugging html-->
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)){
    header("Location: ../login");
    die();
}

$firstName    =isset($_POST['firstName'])? $_POST['firstName']         :"John";
$lastName     =isset($_POST['lastName']) ? $_POST['lastName']          :"Doe";
$address1     =isset($_POST['address1']) ? $_POST['address1']          :"123MainSt.";
$address2     =isset($_POST['address2']) ? $_POST['address2']          :"Apt.23G";
$city         =isset($_POST['city'])     ? $_POST['city']              :"MyfairCity";
$state        =isset($_POST['state'])    ? $_POST['state']             :"KY";
$zipCode      =isset($_POST['zipCode'])  ? $_POST['zipCode']           : "54321";
$rbCreditCard =isset($_POST['rbCreditCard'])  ? $_POST['rbCreditCard'] : "";;
?>
<html>
    <head>
        <title>Credit Card Payment</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            table, th, td{
                border: 1px solid black;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Temp Credit Card Payment</p>
        <?php include('../home/menu.php') ?>
        <div>
        <form action='#' method='POST'>
            <table>
                <tr><td colspan="2" style='font-weight:bold; text-align: center'>Billing Information</td></tr>
                <tr><th style="text-align:right">First Name:    </th><td><input required type="text" name="firstName" <?php echo("value= '$firstName'") ?> ></tr>
                <tr><th style="text-align:right">Last Name:     </th><td><input required type="text" name="lastName"  <?php echo("value= '$lastName'") ?> ></tr>
                <tr><th style="text-align:right">Address Line 1:</th><td><input required type="text" name="address1"  <?php echo("value= '$address1'") ?> ></tr>
                <tr><th style="text-align:right">Address Line 2:</th><td><input          type="text" name="address2"  <?php echo("value= '$address2'") ?> ></tr>
                <tr><th style="text-align:right">City:          </th><td><input required type="text" name="city"      <?php echo("value= '$city'") ?> ></tr>
                <tr><th style="text-align:right">State:         </th><td><input required type="text" name="state"     <?php echo("value= '$state'") ?> ></tr>
                <tr><th style="text-align:right">Zip Code:      </th><td><input required type="text" name="zipCode"   <?php echo("value= '$zipCode'") ?> ></tr>
                <tr><td style='border: none'></br></td></tr>
                <tr><td colspan="2" style='font-weight:bold; text-align: center'>Credit Card Information</td></tr>
                <tr><td colspan="2">
                        <input type=radio name = "rbCreditCard" required value='rbVisa'      <?php echo($rbCreditCard==="rbVisa"?"checked":"")?>> Visa &nbsp;&nbsp;&nbsp;
                        <input type=radio name = "rbCreditCard" required value='rbMasterCard'<?php echo($rbCreditCard==="rbMasterCard"?"checked":"")?>> MasterCard &nbsp;&nbsp;&nbsp;
                        <input type=radio name = "rbCreditCard" required value='rbDiscover'  <?php echo($rbCreditCard==="rbDiscover"?"checked":"")?>> Discover &nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr><td>Credit Card Number</td><td><input type='text' required name='creditCardNumber' pattern='[0-9]{13,16}'></td></tr>
            </table>
            <p></p>
            <table>
                <tr><td colspan="5" style='font-weight:bold; text-align: center'>Order Information</td></tr>
                <tr>
                    <th>Item ID</th><th>Item Description</th><th>Qty</th><th>Price</th><th>Ext. Price</th>
                </tr>
                <tr>
                    <td>1234</td><td>Conference Registation</td><td>1</td><td style="text-align: right">$500.00</td><td style="text-align: right">$500.00</td>
                </tr>
                <tr><td colspan="4" style='text-align: right; font-weight: bold'>Total:</td><td style="text-align: right">$500.00</td></tr>
            </table>
            <input type='submit' value="Submit">
        </form>
            </div>
    </body>
</html>
