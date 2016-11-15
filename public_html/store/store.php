
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
        </style>
        
    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Store</p>
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
            
            <div class="product_list">
                <h1><?php echo $category_one['CATEGORY_NAME']?></h1>
                <!--<a href="../cart">Go to Shopping Cart to Check out!</a>-->
                 <br>
                 <br>
                 
              
                 <table class='product_table'>
                     <th>Product ID</th>
                     <th>Product Name</th>
                     <th>Product Description</th>
                     <th>Product Price</th>
                     <!--<th>Quantity</th>-->
                     <!--<th></th>-->
                    <?php
                    foreach ($product_list as $product) {
                        echo '<tr>';
                        echo '<td><a href=?action=product_detail&amp;product_id='.$product['ID'].'><p name="product_id">'.$product['ID'].'</p></td>';
                        echo '<td>'.$product['NAME'].'</td>';
                        echo '<td>'.$product['DESCRIPTION'].'</td>';
                        echo '<td>'.number_format($product['PRICE'], 2).'</td>';
                        
//                        echo '<td><input type="submit" name="store_action" value="Add"></td>';
                        
                        echo '</tr>';
                    }
                    ?>
                </table>
                
                </div>
        </div>


    </body></html>

