<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Store</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css"><style>
           .product_table, .product_table th, .product_table td{
                border: 1px solid black;
            }
          
            .product_table{
                margin: auto;
            }
            
            .product_table th, .product_table td{
                width: 200px;
            }
        </style>
        
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Product Detail</p>
        <?php include '../home/menu.php'; ?>
        <div>
            <div class="category_list">
                <table>
                    <?php
                    foreach ($categories as $cat) {
                        echo '<tr><td><a href=.?category_id='.$cat['ID'].'>'.$cat['CATEGORY_NAME'].'</a></td></tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="product_detail">
                <form name="productDetailForm" action="." method="post">
                <table class="product_table">
                    
                    <?php
                    echo '<tr><th>Product ID</th><td><input type="text" name="product_id" readonly value='.$product['ID'].'></td></tr>';
                    echo '<tr><th>Product Name</th><td>'.$product['NAME'].'</td></tr>';
                    echo '<tr><th>Product Description</th><td>'.$product['DESCRIPTION'].'</td></tr>';
                    echo '<tr><th>Product Price</th><td>'.number_format($product['PRICE'], 2).'</td></tr>';
                    ?>
                     <tr><th>Quantity</th><td><select name ="qty">
                    <option>1</option><option>2</option><option>3</option><option>4</option>'
                    </select></td></tr>
                    <tr><td></td><td><input type="submit" name ="action" value="Add"></td></tr>
                </table>
                    </form>
            </div>
    </body>
</html>
