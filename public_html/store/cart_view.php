<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Store</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css"><style>
            table, th, td{
                border: 1px solid black;
            }

            table{
                margin: auto;
            }
        </style>

    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Store</p>
        <?php include '../home/menu.php'; ?>
        <div>
            <h1>Your Cart</h1>
            <?php
            if (empty($_SESSION['cartRec']) || count($_SESSION['cartRec']) == 0) {
                echo 'There are no items in your cart.';
            } else {
                ?> 
                    
                   
                    <table>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Qty</th>
                        <th>Product Subtotal</th>
                        <th></th>

                        <?php
                        foreach ($_SESSION['cartRec'] as $item) {
                            echo '<form action="." method="post"><tr> ';
                            $cost = number_format($item['cost'], 2);
                            $total = number_format($item['total'], 2);
                            echo '<td><input type ="text" readonly name="product_id" value="' . $item['id'] . '"></td><td>' . $item['name'] .
                            '</td><td>' . $cost . '</td><td>'
                            . '<input type="text" name="qty" value="' .
                            $item['qty'] . '"></td><td>' . $total . '</td>';
                            echo '<td><input type="submit" name="action" value="Update"></td>';
                      
                            echo '</tr>';
                             echo '</form>';
                        }
                        ?>
                    </table>
                    
                </form>
            <?php } ?>
                <p>Total Before Tax is: $ <?php echo $total_b_tax;?></p> 
            <p>Click "Update" to update each quantity.<br> 
                Enter a quantity of 0 to remove an item.</p>
            <a href=".?action=store">Add Item</a>|
            <a href=".?action=empty_cart">Empty Cart</a>|
            <a href=".?action=check_out">Check Out</a>
            
            
        </div>
    </body>
</html>