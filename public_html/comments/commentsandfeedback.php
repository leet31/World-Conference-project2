
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Comment and Feedback</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <style>
            fieldset{
                margin: auto;
            }
        </style>
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">

        <p style="text-align: center; font-size: 36px;">Comment and Feedback</p>
        <?php include '../home/menu.php'; ?>
        <div>

            <form id="form1" name="form1" method="post">
                <fieldset>
                    <legend>Please sign up to receive future notifications and/or comments about your experience below:</legend>
                    <label>Name:</label>
                    <input name="name" id="name" type="text"><br>

                    <label>Tel:</label>
                    <input name="tel" id="tel" type="text" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}"><br>
                    <label>E-mail:</label>
                    <input name="email" id="email" type="email">
                    <label><strong>Tip:</strong></label>Use the space below to leave comments and/or questions, we appreciate your feedback:<br>
                    <label></label><textarea  name="comments"placeholder="Please input your comments" rows="15" cols="50"></textarea>
                    <br>
                    <label></label><input type="submit" name="commentBtn" value="Submit">
                </fieldset>
            </form>

        </div>
    </body>
</html>
