<html>
    <head>
        <title>Edit Products</title>
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
        
        <div>
        <table>
            <tr>
                <th colspan="7" style="font-size:larger ">Delete or Update </th><th><a href="?action=add">Add New Product</a></th>
            </tr>
            <tr>
                <th>ID</th>
                <th></th>
                <th></th>
                <th>Category</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price
                </th>
                <th></th>
            </tr>
            <?php
            foreach ($product_list as $row) {
                echo('<tr>');
                echo('<td>' . $row['ID'] . '</td>');
                echo '<form action ="." method= "post">' .
                '<td><input type="hidden" name="productID" value=" ' . $row['ID'] . '"></td>' .
                '<td><input type="submit" name="action" value="Delete"></td>' .
                '<td><select name="catID" value=" ' . $row['CATEGORY'] . '">';
                foreach ($cat_list as $cat) {
                    if ($cat['ID'] == $row['CATEGORY']) {
                        $cat_name = $cat['CATEGORY_NAME'];
                    }
                }
                echo '<option value="' . $row['CATEGORY'] . '">' . $cat_name . '</option>';
                foreach ($cat_list as $cat) {
                    echo '<option value="' . $cat['ID'] . '">' . $cat['CATEGORY_NAME'] . '</option>';
                }
                echo '</select>';
                echo '</td>';
                echo
                '<td><input type="text" name= "name" value="' . $row['NAME'] . '"></td>' .
                '<td><input type="text" name= "description" value="' . $row['DESCRIPTION'] . '"></td>' .
                '<td><input type="text" name= "price" value="' . number_format($row['PRICE'], 2) . '"></td>' .
                '<td><input type="submit" name="action" value="Update"></td>' .
                '</form>';
                echo('</tr>');
            }
            ?>
        </table>
    </div>
</body>
</html>
