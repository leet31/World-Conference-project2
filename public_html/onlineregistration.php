<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Online Registration</title>
        <link rel="stylesheet" type="text/css" href="./styles.css">
    </head>

    <body background="images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Online Registration</p>
        <?php echo(file_get_contents('.\menu.html')) ?>
        <p>&nbsp;</p>
        <p>
            <label for="textfield">First name:</label>
            <input type="text" name="textfield" id="textfield">
        </p>
        <p>
            <label for="textfield2">Last name:</label>
            <input type="text" name="textfield2" id="textfield2">
        </p>
        <p>
            <label for="textfield3">Title, Company, or Organization:</label>
            <input type="text" name="textfield3" id="textfield3">
        </p>
        <p>
            <label for="textfield4">Address:</label>
            <input type="text" name="textfield4" id="textfield4">
        </p>
        <p>
            <label for="address2">Address Line 2:</label>
            <input type="text" name="address2" id="textfield4">
        </p>
        <p>
            <label for="city">City:</label>
            <input type="text" name="city" id="textfield4">
        </p>
        <p>
            <label for="state">State:</label>
            <input type="text" name="state" id="textfield4">
        </p>
        <p>
            <label for="zipcode">Zip Code:</label>
            <input type="text" name="zipcode" id="textfield4">
        </p>
        <p>
            <label for="tel">Tel:</label>
            <input type="tel" name="tel" id="tel">
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </p>
        <p>Are you a:</p>
        <p>
            <label>
                <input type="radio" name="Student " value="radio" id="Student_0">
                Student</label>
            <br>
            <label>
                <input type="radio" name="Student " value="radio" id="Student_1">
                Author/Presenter </label>
            <br>
            <label>
                <input type="radio" name="Student " value="radio" id="Student_2">
                Regular attendee</label>
        </p>
        <p>Payment Methods: </p>
        <p><img src="images/american express.png" width="99" height="81" alt=""/>  <img src="images/discover.jpg" width="114" height="80" alt=""/>  <img src="images/visa.png" width="127" height="81" alt=""/> <img src="images/mastercard.gif" width="128" height="78" alt=""/><br>
        </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </body>
</html>
