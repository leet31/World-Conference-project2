<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Log In</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Login Successful!</p>
        <?php include '../home/menu.php'; ?>
        <div>
            <p></p>
            <p>Welcome <?php $_SESSION['userRec']['FIRST_NAME']?></p>
        </div>
    </body>
