<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Shopping Cart</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css"><style>
            fieldset{
                text-align: Center;
            }


            input[type=number]{
                width: 80px;
            }

            table{
                margin: auto;
            }
            td, th{
                border:solid #C0C0C0;
                border-width:0px 1px 1px 0px;
                padding:10px;
                text-align: center;
            }
            table{
                border:solid #C0C0C0;
                border-width:1px 0px 0px 1px;
            }
            a{
                color: black;
            }
        </style>

    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Shopping Cart</p>
        <?php include '../home/menu.php'; ?>
        <div>
            <fieldset>
                <legend>Order Summary</legend>
                <table>
                    <th>item#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Sub Total</th>

                    <?php
                    foreach ($_SESSION['cartRec'] as $line) {

                        echo '<tr>';
                        echo '<td>' . $line['id'] . '</td>';
                        echo '<td>' . $line['name'] . '</td>';
                        echo '<td> $ ' . number_format($line['cost'], 2) . '</td>';
                        echo '<td>' . $line['qty'] . '</td>';
                        echo '<td>' . number_format($line['cost'] * $line['qty'], 2) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr><td>Total</td><td colspan="4">
                            <?php echo '$ ' . number_format($balance, 2); ?></td></tr>
                </table>
            </fieldset>
            <fieldset>
                <legend>Shipping Address</legend>

                <table>
                    <tr><th>Name: </th><td><?php echo $user['FIRST_NAME'] . ' ' . $user['LAST_NAME']; ?></td></tr>
                    <tr><th>Phone: </th><td><?php echo $user['PHONE_NUMBER']; ?></td></tr>
                    <tr><th>Address: </th><td><?php echo $user['ADDRESS_1'] . ' ' . $user['ADDRESS_2']; ?></td></tr>
                    <tr><th>City, State, ZIP Code: </th><td><?php echo $user['CITY'] . ',' . $user['STATE'] . ' ' . $user['ZIP_CODE']; ?></td></tr>
                </table>
            </fieldset>
            <fieldset>
                <legend>Credit Card Information</legend>
                <label>*Payment Method:</label>
                <form method="post" name="payment" action=".">
                    <input name="card_type" id="rbAtAmericanExpress" type="radio" value = "a"><img src="../../public_html/images/american express.png" width="99" height="81" alt=""/>
                    <input name="card_type" id="rbAtDiscover" type="radio" value = "d"><img src="../../public_html/images/discover.jpg" width="114" height="80" alt=""/> 
                    <input name="card_type" id="rbAtVisa" type="radio" value="v"><img src="../../public_html/images/visa.png" width="127" height="81" alt=""/> 
                    <input name="card_type" id="rbAtMastercard" type="radio" value="m"><img src="../../public_html/images/mastercard.gif" width="128" height="78" alt=""/><br>
                    <table>
                        <tr><td>*Card Number:</td>
                            <td> <input name="card_number" type="text" value="<?php echo htmlspecialchars($cardNumber) ?>"></td>
                            <td><?php echo $fields->getField('card_number')->getHTML(); ?></td></tr>

                        <tr><td>*Expiration Date:</td>
                            <td> <input name="exp_date" type="text" value="<?php echo htmlspecialchars($expDate) ?>"></td>
                            <td><?php echo $fields->getField('exp_date')->getHTML(); ?></td></tr>
                        
                    </table>
                    <input type="submit" name="action" value="Pay">
                </form>
            </fieldset>

        </div>

    </body>
</html>

