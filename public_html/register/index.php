<?php
    $action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'home';
    }
    switch ($action){
        case 'register':
            include 'view/onlineregistration.php';
            break;
        case 'register_submit':
            break;
    }
    
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home page</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body background="images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: xx-large; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif;">
            <strong><em>World Congress CS-IT Conferences</em></strong>
        </p>
        <?php echo(file_get_contents('../home/menu.html')) ?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <?php echo"<p><h1>Hello PHP from Kevin!</h1>"; ?>
    </body>

</html>