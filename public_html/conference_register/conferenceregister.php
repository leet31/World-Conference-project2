<!doctype html>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['userRec'])) {
    header("Location: ../login");
    die();
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Conference Registration</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <style>
            table, th, td{
                border: 1px solid black;
            }

          </style>
    </head>

    <?php print_r($_SESSION['userRec']); ?>
    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png"> 
        <p style="text-align: center; font-size: large;"></p>
        <?php include '../home/menu.php' ?>
        <div>
            <fieldset>
                <legend>Registration Status</legend>
                <label>Name:</label>
                <?php echo($_SESSION['userRec']['FIRST_NAME'] . " " . $_SESSION['userRec']['LAST_NAME']); ?>
                <br>

                <label>Email Address:</label>
                <?php echo($_SESSION['userRec']['EMAIL']); ?>
                <br>
                
                <!--<p style="padding-left: 6em; font-size: larger;">Current Attendee Status</p>-->
                <label>Attendee</label>
                <input type="checkbox" name="cbRoAttendee" disabled <?php echo(($_SESSION['userRec']['ATTENDEE'])?"checked":"") ?>>
                <?php echo $fields->getField("cbRoAttendee")->getHTML(); ?>
                <br>
                <label>Student</label>
                <input type="checkbox" name="cbRoStudent" disabled <?php echo(($_SESSION['userRec']['STUDENT'])?"checked":"") ?>>
                <?php echo $fields->getField("cbRoStudent")->getHTML(); ?>
                <br>
                <label>Presenter</label>
                <input type="checkbox" name="cbRoPresenter" disabled <?php echo(($_SESSION['userRec']['PRESENTER'])?"checked":"") ?>>
                <?php echo $fields->getField("cbRoPresenter")->getHTML(); ?>
                <br>
                <label>Number of papers submitted:</label>
                <input type="text" name="numberOfPapers" readonly value='<?php echo($PM->getPaperCountByAuthorId($_SESSION['userRec']['ID'])) ?>' style="width: 2em">
                <?php echo $fields->getField("numberOfPapers")->getHTML(); ?>
                <p>
                <?php 
                    if($_SESSION['userRec']['ATTENDEE']){
                        echo("Our records show that you are already registered.<br> "
                                . "If you would like to change your registation status, please contact customer support.");
                    }
                ?>
                </p>
                
            </fieldset>
            <fieldset>
                <legend>Register</legend>
                <form name='confRegForm' action='.' method="POST">
                <label>Regular Fee</label>
                <input type="text" name="RegularFee" readonly value='$600' style="width: 4em">
                <br>
                
                <label>Discounted Fee</label>
                <input type="text" name="DiscountFee" readonly value='$600' style="width: 4em">
                <br>
                
                <label>Attendee</label>
                <input type="checkbox" name="cbAttendee" <?php echo(($_SESSION['userRec']['ATTENDEE'])?"checked":"") ?>>
                <?php echo $fields->getField("cbAttendee")->getHTML(); ?>
                <br>
                <label>Student</label>
                <input type="checkbox" name="cbStudent" <?php echo(($_SESSION['userRec']['STUDENT'])?"checked":"") ?>>
                <?php echo $fields->getField("cbStudent")->getHTML(); ?>
                <br>
                <label>Presenter</label>
                <input type="checkbox" name="cbPresenter" <?php echo(($_SESSION['userRec']['PRESENTER'])?"checked":"") ?>>
                <?php echo $fields->getField("cbPresenter")->getHTML(); ?>
                <br>
                
                <label></label>
                <input type='submit' name='log_action' value='Submit'>
                
                    
                </form>
                
            </fieldset>

        </div>
    </body>
</html>