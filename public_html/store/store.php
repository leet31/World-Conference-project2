
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

            }
            .product_img{
                display: inline-block;
                width: 20%
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
            /*            img:hover{
                            width:100%;
                        }*/
            .category_list a {
                color:black;
                margin:10px;
            }
            .product a{
                color:black; 
            }

        </style>

    </head>

    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Store</p>
        <?php include '../home/menu.php'; ?>
        <div class='body'>
            <div class="category_list">

                <?php
                foreach ($categories as $cat) {
                    echo '<a href=.?category_id=' . $cat['ID'] . '>' . $cat['CATEGORY_NAME'] . '</a><br>';
                }
                ?>


            </div>

            <div class="product_list">
                <h1><?php echo $category_one['CATEGORY_NAME'] ?></h1>

                <!--<a href="../cart">Go to Shopping Cart to Check out!</a>-->
                <br>
                <br>



                <?php
                if (count($product_list) < 1) {
                    echo '<h2>No Product in this category!</h2>';
                }
                foreach ($product_list as $product) {

                    echo '<div class="product">';
                    $html = '<a href=?action=product_detail&amp;product_id=' . $product['ID'] . '>';
                    if ($product['IMG_NAME'] == '') {
                        $html .= '<img src="../product_images/default.png"/><br>';
                    } else {
                        $html .= '<img src="../product_images/' . $product['IMG_NAME'] . '"/><br>';
                    }
                    $html .= $product['NAME'];
                    $html .= '$ <i>' . number_format($product['PRICE'], 2) . '</i>';
                    $html .= '</a>';
                    echo $html;
                    echo '</div>';
                }
                ?>

            </div>
        </div>


    </body></html>

