
<html>
    <head>
        <title>Add Products</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
        <style>
            table, th, td{
                border: 1px solid black;
            }

            input[type = submit]{
                margin: 0.0em;
                font-size: smaller;
                margin-right: 0em;
            }
            table{
                margin: auto;
            }
            img{
                width:150px;
                height: 150px;
            }
        </style>


    </head>
    <body>
    <body background="../images/2015_AIGA-Design-Month_Website-Footer.png">
        <p style="text-align: center; font-size: 36px;">Edit Products</p>
        <?php include('../home/menu.php') ?>

        <!--display error message, if any-->


        <?php
        if (isset($errMsg_product)) {
            if ($errMsg_product == 'NONE') {
                echo '<div><h3>Update Successfully!</h3></div>';
            } else if ($errMsg_product != '') {
                echo "<div><h3>Product Error: $errMsg_product</h3></div>";
            }
        }
        ?>

        <div>
            <form action = "<?php filter_input(INPUT_SERVER, 'REQUEST_URI') ?>" method='post'>
                <table>
                    <tr>
                        <th colspan="2" style="font-size:larger ">Insert New Product</th>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>

                            <?php
                            echo '<select name="catID">';
                            foreach ($cat_list as $cat) {
                                echo '<option value="' . $cat['ID'] . '">' . $cat['CATEGORY_NAME'] . '</option>';
                            }
                            echo '</select>'
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input type="text" name="description"></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td><input type="text" name="price"></td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td><input type="file" name="file"></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td> <input type="submit" name="btnInsert" value ="Insert"></td>
                    </tr>
                </table>
            </form>
        </div>
        <p>
        <div>

          
        </div>
    </body>
</html>
