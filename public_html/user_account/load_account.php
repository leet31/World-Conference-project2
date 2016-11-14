
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>User Account Management</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <style>
            table{
                margin: auto;
               
        </style>
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Online Registration</p>
        <?php include '../home/menu.php'; ?>
        <div>
        <table border ="1">
            <tr><th>User ID</th><td><?php echo htmlspecialchars($userID) ?></td></tr>
            <tr><th>First Name</th><td><?php echo htmlspecialchars($first_name) ?></td></tr>
            <tr><th>Last Name</th><td><?php echo htmlspecialchars($last_name) ?></td></tr>
            <tr><th>Company Name</th><td><?php echo htmlspecialchars($company_name) ?></td></tr>
            <tr><th>Address</th><td><?php echo htmlspecialchars($address) ?></td></tr>
            <tr><th>Apt#/Suit#</th><td><?php echo htmlspecialchars($address2) ?></td></tr>
            <tr><th>City</th><td><?php echo htmlspecialchars($city) ?></td></tr>
            <tr><th>State</th><td><?php echo htmlspecialchars($state) ?></td></tr>
            <tr><th>Zip Code</th><td><?php echo htmlspecialchars($zip) ?></td></tr>
            <tr><th>Phone</th><td><?php echo htmlspecialchars($email) ?></td></tr>
            <tr><th>Type</th><td><?php echo htmlspecialchars($typeString) ?></td></tr>
            <tr><td></td><td> <form action="." method="post">
                <input type ="submit" name="account_action" value="Edit"></td>
            </form></tr>
           

        </table>
            
        </div>
        
    </body>
</html>

