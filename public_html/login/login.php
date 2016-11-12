<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Log In</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Log In</p>
        <?php include '../home/menu.php' ?>



        <!--display error message, if any-->

        <div>
            <form name="logForm" action="." method="post">
                <fieldset>
                    <legend>Input Your Email Address and Password</legend>
                    <label>Email:</label>
                    <input name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" >
                    <?php echo $fields->getField('email')->getHTML(); ?><br>
                    <br>
                    <label>Password:</label>
                    <input name="password" type="password" value="<?php echo htmlspecialchars($password); ?>">
                    <?php echo $fields->getField('password')->getHTML(); ?><br>
                    <br>
                    <label></label>
                    <input type="submit" name="log_action" value="Login">
                    <input type="submit" name="log_action" value="Reset">


                    </div>
                </fieldset>
            </form>
    </body>
</html>
