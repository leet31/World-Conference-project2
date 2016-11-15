<!doctype html>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!(isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE)) {
    header("Location: ../login");
    die();
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Page Submission</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <style>
            table, th, td{
                border: 1px solid black;
            }
        </style>
        <script>
            window.onload = function () {
                document.getElementById('paperSubmitForm').addEventListener('submit', function (evt) {
                    var file = document.getElementById('document').files[0];
                    
                    if (file && file.size < 8388608) { // defualt XAMPP limit
                        //Submit form        
                    } else {
                        alert("Error: File is larger than 8 MB");
                        //Prevent default and display error
                        evt.preventDefault();
                    }
                }, false);
            }
        </script>
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png"> 
        <p style="text-align: center; font-size: large;"></p>
        <?php include '../home/menu.php' ?>
        <div>
            <form name="paperSubmitForm" id="paperSubmitForm" action="." method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Submit Paper for Review</legend>
                    <label>Name:</label>
                    <?php echo($_SESSION['userRec']['FIRST_NAME'] . " " . $_SESSION['userRec']['LAST_NAME']); ?>
                    <br>

                    <label>Email Address:</label>
                    <?php echo($_SESSION['userRec']['EMAIL']); ?>
                    <br>

                    <label>Title:</label>
                    <input name="title" type="text" required value="" style="width: 25em">
                    <?php echo $fields->getField('title')->getHTML(); ?>
                    <br>

                    <label>Area | Subarea</label>
                    <select name="subareaID" required style="width: 25em">
                        <option selected disabled value>--  Select Area | Subarea --</option>
                        <?php
                        foreach ($areaSubareaList as $row) {
                            echo("<option value='" . $row['ID'] . "'>" . $row[1] . "</option>");
                        }
                        ?>
                    </select>
                    <?php echo $fields->getField('subarea')->getHTML(); ?>
                    <br>

                    <label>File to Upload:</label>
                    <input name="document" id="document" type="file" required style="width: 25em">
                    <?php echo $fields->getField('fileChooser')->getHTML(); ?><br>
                    <br>
                    <label></label>
                    <input type="submit" name="log_action" value="Submit">
                    <input type="submit" name="log_action" value="Reset">
                    <br>

                </fieldset>
            </form>
            <table align="center">
                <tr>
                    <th colspan="3">Documents Previously Submitted by You</th>
                </tr>
                <tr>
                    <th>Title</th><th>Area | Subarea</th><th>File Name</th>
                </tr>
                <?php
                foreach ($editPaperList as $row) {
                    echo("<tr>\n");
                    echo("<td>\n");
                    echo($row['TITLE']);
                    echo("</td>\n");
                    echo("<td>\n");
                    echo($row['AREA_NAME'] . " | " . $row['SUBAREA_NAME']);
                    echo("</td>\n");
                    echo("<td>\n");
                    echo($row['FILENAME']);
                    echo("</td>\n");
                    echo("</tr>\n");
                }
                ?>
            </table>

        </div>
    </body>
</html>