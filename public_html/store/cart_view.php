<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Shopping Cart</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css"><style>
            fieldset{
                text-align: right;
            }
            input[type=text]{
                padding: 10px;
                width:80px;
                border-style: none;
                border-width: 0px;
                background-color: #f2f2f2;
                text-align: center;
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
                <legend>Your Cart</legend>
                <?php
                if (empty($_SESSION['cartRec']) || count($_SESSION['cartRec']) == 0) {
                    echo 'There are no items in your cart.';
                } else {
                    ?> 
                    <table>
                        <th>Item#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>

                        <?php
                        foreach ($_SESSION['cartRec'] as $item) {
                            echo '<form action="." method="post"><tr> ';
                            $cost = number_format($item['cost'], 2);
                            $total = number_format($item['total'], 2);
                            echo '<td><input type ="text" readonly name="product_id" value="' . $item['id'] . '"></td>';
                          
                            echo '<td>' . $item['name'] .
                            '</td><td>' . $cost . '</td><td>'
                            . '<input type="number" name="qty" value="' .
                            $item['qty'] . '"  max="10" step="1"></td><td>' . $total . '</td>';
                            echo '<td><input type="submit" name="action" value="Update"></td>';
                            echo '</tr>';
                            echo '</form>';
                        }
                        ?>
                    </table>
                <?php } ?>
                <p>Total Before Tax is: $ <?php echo $total_b_tax; ?></p> 
                <p>Click "Update" to update each quantity.<br> 
                    Enter a quantity of 0 to remove an item.</p>
                <a href=".?action=overview">Add Item</a>|
                <a href=".?action=empty_cart">Empty Cart</a>|
                <a href=".?action=check_out">Check Out</a>
            </fieldset>

        </div>
    </body>
</html>