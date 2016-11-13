
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Conference Program</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        
        <p style="text-align: center; font-size: 36px;">Conference Program</p>
        <?php include '../home/menu.php'; ?>
        <div>
        <p>Please sign up to receive future notifications and/or comments about your experience below:</p>

        <form id="form1" name="form1" method="post">
            <table
                <tr>
                    <td align="right">Name:</td>
                     <td><input name="name" id="name" type="text" </td>
                </tr>
                <tr>
                        <td align="right">Tel:</td>
                        <td><input name="tel" id="tel" type="text" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}"></td>
                    </tr>
                    <tr>
                    <td align="right">E-mail:</td>
                        <td><input name="email" id="email" type="email"></td>
                    </tr>
            </table>
            <table>
                <p><strong>Tip:</strong> Use the space below to leave comments and/or questions, we appreciate your feedback:</p> 
            </table>
            <table>
<form> 
  <textarea>Some text...</textarea>
</form>
            <blockquote>
                <blockquote>
                    <tr><td align="center"</td>
                                    <td><input type="submit" name="btnRegisterSubmit" value="Submit"></td>
                            </tr>
                        </blockquote>
                    </blockquote>
                
            </table>
        </form>
        </div>
    </body>
</html>
