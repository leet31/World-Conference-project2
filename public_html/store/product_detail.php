<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Store</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css"><style>
            .category_list{
                display: inline-block;
                width: 15%;
                background-color: #f9f9f9;
                margin: 5px;
                padding:5px;
                vertical-align: top;

            }
            .product_list, .product_detail{
                display: inline-block;
                width: 80%;
                padding:0px;
                vertical-align: top;

            }
            .product_img{
                display: inline-block;
                width: 20%;
                vertical-align: top;
            }
            .product_text{
                display: inline-block;
                width: 60%;
                vertical-align: top;
            }
            .product{
                display: inline-block;
                width: 25%;
                padding:0px;
                margin-bottom: 10px;
            }
            img{
                width:150px;
            }
            img:hover{
                width:120%;
            }
            input[type=text]{
                padding: 10px;
                border-style: none;
                border-width: 0px;
                background-color: #f2f2f2;
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
                        echo '<tr><td><a href=.?category_id=' . $cat['ID'] . '>' . $cat['CATEGORY_NAME'] . '</a></td></tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="product_detail">
                <div class="product_img">
                    <?php
                    if ($product['IMG_NAME'] == '') {
                        $html = '<img src="../product_images/default.png"/><br>';
                    } else {
                        $html = '<img src="../product_images/' . $product['IMG_NAME'] . '"/><br>';
                    }
                    echo $html;
                    ?>
                </div>
                <div class="product_text">
                    <form name="productDetailForm" action="." method="post">

                        <?php
                        echo '<i><small>item #:</small></i><input type="text" name="product_id" readonly value=' . $product['ID'] . '>';
                        echo '<h3>' . $product['NAME'] . '</h3>';
                        echo '<p>' . $product['DESCRIPTION'] . '</p>';
                        echo '$ <i>' . number_format($product['PRICE'], 2) . '</i><br><br>';
                        ?>
                        <b>Qty: </b> <input name="qty" type="number" min="0" max="10" step="1"><br><br><br>
                        <input type="submit" name ="action" value="Add">

                    </form>
                </div>   
            </div>
    </body>
</html>
