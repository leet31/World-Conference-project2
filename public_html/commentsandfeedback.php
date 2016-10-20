<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Comments and Feedback</title>
        <link rel="stylesheet" type="text/css" href="./styles.css">
    </head>

    <body>
        <?php echo(file_get_contents('.\menu.html')) ?>
        <p>Please sign up to receive future notifications and/or comments about your experience below:</p>

        <form id="form1" name="form1" method="post">
            <p>
                <label for="textfield">Name:</label>
                <input type="text" name="textfield" id="textfield">
            </p>
            <p>
                <label for="tel">Tel:</label>
                <input type="tel" name="tel" id="tel">
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email">
            </p>
            <blockquote>
                <blockquote>
                    <blockquote>
                        <blockquote>
                            <p>
                                <input type="submit" name="submit" id="submit" value="Submit">
                            </p>
                        </blockquote>
                    </blockquote>
                </blockquote>
            </blockquote>
        </form>
        <p>&nbsp;</p>
    </body>
</html>
