
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Online Registration</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Online Registration</p>
        <?php include '../home/menu.php'; ?>
        <div>
            <form name="regForm" action="." method="post">
                <fieldset>
                    <legend>Personal Information</legend>
                    <label>*First Name:</label>
                    <input name="first_name" type="text" value="<?php echo htmlspecialchars($first_name) ?>">
                    <?php echo $fields->getField('first_name')->getHTML(); ?><br>

                    <label>*Last Name:</label>
                    <input name="last_name" type="text" value="<?php echo htmlspecialchars($last_name) ?>">
                    <?php echo $fields->getField('last_name')->getHTML(); ?><br>

                    <label>Company/Organization:</label>
                    <input name="company_name" type="text" value="<?php echo htmlspecialchars($company_name) ?>">
                    <?php echo $fields->getField('company_name')->getHTML(); ?><br>
                    <label>*Attendee Type: </label>
                    <input name="attendee_type[]" id="rbAttendee" type="checkbox" value = "attendee"> Attendee
                    <input name="attendee_type[]" id="rbAtPresenter" type="checkbox" value="presenter"> Presenter
                    <input name="attendee_type[]" id="rbAtStudent" type="checkbox" value="student"> Student
                    <input name="attendee_type[]" id="rbAtNa" type="checkbox" value="reviewer">Reviewer
                    <?php echo $fields->getField('attendee_type')->getHTML();?><br>
                </fieldset> 
                <fieldset>
                    <legend>Contact Information</legend>
                    <label>*Address:</label>
                    <input name="address" type="text" value="<?php echo htmlspecialchars($address) ?>">
                    <?php echo $fields->getField('address')->getHTML(); ?><br>

                    <label>Additional Address:</label>
                    <input name="address_2" type="text" value="<?php echo htmlspecialchars($address2) ?>">
                    <?php echo $fields->getField('address_2')->getHTML(); ?><br>

                    <label>*City:</label>
                    <input name="city" type="text" value="<?php echo htmlspecialchars($city) ?>">
                    <?php echo $fields->getField('city')->getHTML(); ?><br>
                    <label>*State:</label>
                    <input name="state" type="text" value="<?php echo htmlspecialchars($state) ?>">
                    <?php echo $fields->getField('state')->getHTML(); ?><br> 
                    <label>*Zip:</label>
                    <input name="zip" type="text" value="<?php echo htmlspecialchars($zip) ?>">
                    <?php echo $fields->getField('zip')->getHTML(); ?><br>
                    <label>*Phone:</label>
                    <input name="phone" type="text" value="<?php echo htmlspecialchars($phone) ?>">
                    <?php echo $fields->getField('phone')->getHTML(); ?><br>
                </fieldset>
                <fieldset>
                    <legend>Account Information</legend>
                    <label>*Email:</label>
                    <input name="email" type="text" value="<?php echo htmlspecialchars($email) ?>">
                    <?php echo $fields->getField('email')->getHTML(); ?><br>

                    <label>*Password:</label>
                    <input name="password" type="password" value="<?php echo htmlspecialchars($password) ?>">
                    <?php echo $fields->getField('password')->getHTML(); ?><br>

                    <label>*Verify Password:</label>
                    <input name="verify_password" type="password" value="<?php echo htmlspecialchars($verify_password) ?>">
                    <?php echo $fields->getField('verify_password')->getHTML(); ?><br>

                    
                </fieldset> 

<!--                <fieldset>
                    <legend>Credit Card Information</legend>
                    <label>*Payment Method:</label>
                    <input name="card_type" id="rbAtAmericanExpress" type="radio" value = "a"><img src="../../public_html/images/american express.png" width="99" height="81" alt=""/>
                    <input name="card_type" id="rbAtDiscover" type="radio" value = "d"><img src="../../public_html/images/discover.jpg" width="114" height="80" alt=""/> 
                    <input name="card_type" id="rbAtVisa" type="radio" value="v"><img src="../../public_html/images/visa.png" width="127" height="81" alt=""/> 
                    <input name="card_type" id="rbAtMastercard" type="radio" value="m"><img src="../../public_html/images/mastercard.gif" width="128" height="78" alt=""/><br>

                    <label>*Card Number:</label>
                    <input name="card_number" type="text" value="<?php echo htmlspecialchars($cardNumber) ?>">
                    <?php echo $fields->getField('card_number')->getHTML(); ?><br>

                    <label>*Expiration Date:</label>
                    <input name="exp_date" type="text" value="<?php echo htmlspecialchars($expDate) ?>">
                    <?php echo $fields->getField('exp_date')->getHTML(); ?><br>
                </fieldset>-->
                <fieldset>
                    <legend>Submit Registration</legend>

                    <label>&nbsp;</label>
                    <input type ="submit" name="reg_action" value="Register">
                    <input type = "submit" name="reg_action" value="Reset"><br>
                </fieldset>
            </form>

<!--                <table>
       <tr>
           <td  align="right">*First Name:</td>
           <td><input name="first_name" id="firstName" type="text" </td>
       </tr>
       <tr>
           <td align="right">*Last Name:</td>
           <td><input name="last_name" id="lastName" type="text"></td>
       </tr>
       <tr>
           <td align="right">Company/Organization:</td>
           <td><input name="compOrg" id="compOrg" type="text"></td>
       </tr>
       <tr>
           <td align="right">*Address Line 1:</td>
           <td><input name="address" id="address" type="text"></td>
       </tr>
       <tr>
           <td align="right">Address Line 2:</td>
           <td><input name="address_2" id="address2" type="text"></td>
       </tr>
       <tr>
           <td>*City:</td>
           <td>*State:</td>
       </tr>
       <tr>
           <td><input name="city" id="city" type="text"></td>
           <td><input name="state" id="state" type="text"></td>
       </tr>
       <tr>
           <td align="right">*Zip code:</td>
           <td><input name="zip" id="zipcode" type="text" pattern="[0-9]{5}"></td>
       </tr>
       <tr>
           <td align="right">*Phone Number:</td>
           <td><input name="phone" id="phone" type="text" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}"></td>
           <td align="right">*E-mail:</td>
           <td><input name="email" id="email" type="email"></td>
       </tr>
       <tr>
           <td align="right">*Password:</td>
           <td><input name="password" id="password" type="password"></td>
           <td align="right">*Confirm Password:</td>
           <td><input name="verify_password" id="password2" type="password"></td>
       </tr>
   </table>
   <table>
       <tr>
           <td>*Attendee Type: &nbsp;&nbsp;</td>
           <td align="right"><input name="attendee_type" id="rbAtPresenter" type="radio"></td><td>Presenter &nbsp;&nbsp;</td>
           <td align="right"><input name="attendee_type" id="rbAtStudent" type="radio"></td><td>Student &nbsp;&nbsp;</td>
           <td align="right"><input name="attendee_type" id="rbAtNa" type="radio">Neither</td>
       </tr>

   </table>
</form>
<p>Payment Methods: </p>
<input name="card_type" id="rbAtAmericanExpress" type="radio" value = "a"><img src="../images/american express.png" width="99" height="81" alt=""/>
<input name="card_type" id="rbAtDiscover" type="radio" value = "d"><img src="../images/discover.jpg" width="114" height="80" alt=""/> 
<input name="card_type" id="rbAtVisa" type="radio" value="v"><img src="../images/visa.png" width="127" height="81" alt=""/> 
<input name="card_type" id="rbAtMastercard" type="radio" value="m"><img src="../images/mastercard.gif" width="128" height="78" alt=""/><br>
<p>&nbsp;</p>
<table>
       <tr>
           <td  align="right">Credit Card Number:</td>
           <td><input name="card_number" id="creditcard" type="text" </td>
       </tr>
       <tr>
           <td  align="right">Expiration Date:</td>
           <td><input name="exp_date" id="expirationdate" type="text" </td>
       </tr>
       <tr><td><input type="submit" name="btnRegisterSubmit" value="Submit"></td></tr>
</table>-->
            <p>&nbsp;</p>
        </div>
    </body>
</html>
