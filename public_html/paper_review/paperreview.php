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
        <title>Page Review</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <style>
            table, th, td{
                border: 1px solid black;
            }

            input[type = submit]{
                margin: 0.0em;
                font-size: smaller;
                margin-right: 0em;
            }
        </style>
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png"> 
        <p style="text-align: center; font-size: large;"></p>
        <?php include '../home/menu.php' ?>
        <div>
            <fieldset>
                <legend>Download Paper for Review</legend>
                <label>Reviewer Name:</label>
                <?php echo($_SESSION['userRec']['FIRST_NAME'] . " " . $_SESSION['userRec']['LAST_NAME']); ?>
                <br>

                <label>Email Address:</label>
                <?php echo($_SESSION['userRec']['EMAIL']); ?>
                <br>
                <div>
                    <table align="center">
                        <tr>
                            <th colspan="5">Documents Assigned To Be Reviewed You</th>
                        </tr>
                        <tr>
                            <th>Author</th><th>Title</th><th>Area | Subarea</th><th>File Name</th>
                        </tr>
                        <?php
                        foreach ($editPaperList as $row) {
                            echo("<form action='.' method='post'>");
                            echo("<tr>\n");
                            echo("<td style='display:none'>\n");
                            echo("<input type='hidden' name='fileName'      id='fileName'      value='".$row['FILENAME']     ."'>");
                            echo("<input type='hidden' name='localFileName' id='localFileName' value='".$row['LOCAL_FILENAME']."'>");
                            echo("</td>\n");
                            echo("<td>\n");
                            echo($row['AUTHOR_FULL_NAME']);
                            echo("</td>\n");
                            echo("<td>\n");
                            echo($row['TITLE']);
                            echo("</td>\n");
                            echo("<td>\n");
                            echo($row['AREA_NAME'] . " | " . $row['SUBAREA_NAME']);
                            echo("</td>\n");
                            echo("<td>\n");
                            echo($row['FILENAME']);
                            echo("</td>\n");
                            echo("<td>\n");
                            echo("<input name='log_action' type='submit' value='Download'>");
                            echo("</td>\n");
                            echo("</tr>\n");
                            echo("</form>");
                        }
                        ?>
                    </table>

                </div>

            </fieldset>

        </div>
    </body>
</html>