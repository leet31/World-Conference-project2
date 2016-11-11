<?php 
#sets the root of the website so that any file can be referenced relative to the root
$web_root = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Important Dates</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>

    <body bgcolor="#D49318" text="#FFFFFF">
        <p style="text-align: center; font-size: 24px; font-weight: bold; color: #000000;">Important Dates </p>

        <?php echo(file_get_contents($web_root.'menu.html')) ?>
        <p>December 5th, 2016: Submission of draft papers (2000-200 words), extended abstracts (600-2000 words)</p>
        <p>&nbsp;</p>
        <p>January 25th, 2017: Notifications of Acceptance</p>
        <p>&nbsp;</p>
        <p>February 25th, 2017: Submission of camera-ready or final versions of the accepted papers</p>
        <p>&nbsp;</p>
        <p>July 6th, 2017: Conference Starts</p>
        <p>&nbsp;</p>
        <p>July 11th, 2017: Conference Ends</p>
        <p style="color: #F7F3F3">&nbsp;</p>
    </body>
</html>
