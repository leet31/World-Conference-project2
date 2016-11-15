<!-- Use php's file_get_contents() to read this file and echo() it into the <body> of each page-->
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if (isset($_SESSION['userRec'])) {
    echo '<ul  class ="account"><li class="main_menu"><a href="../user_account">' . $_SESSION['userRec']['FIRST_NAME'] . '</a></li><li class="main_menu"><a href="../logout">Logout</a></li></ul>';
} else {
    echo '<ul class ="account"><li class="main_menu"><a href="../login">Log In</a></li><li class="main_menu"><a href="../register">Register</a></li></ul>';
}
include('menu.html');
if (isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE) {
    echo '<ul class="admin_menu">'
    . ' <li class="dropdown">
        <a href ="#" class ="dropbtn">Content Management</a>
        <div class="dropdown-content">
            <a href="../admin_edit/editCategories.php">Edit Product Categories</a>
            <a href="../admin_edit/editProducts.php">Edit Product</a>
            <a href="../admin_edit/editAreas.php">Edit Content Areas</a>
            <a href="../admin_edit/editSubareas.php">Edit Content Subareas</a>
            <a href="../admin_edit/editUsers.php">Edit Users</a>
        </div>
    </li>
    <li class ="dropdown">
        <a href ="#" class ="dropbtn">Diagnostics Menu</a>
        <div class="dropdown-content">
            <a href="../admin_diag/tempRegPage.php">Temporary Registration Page</a>
            <a href="../admin_diag/tempLoginPage.php">Temporary Login Page</a>
             <a href="../admin_diag/tempCreditCardPayment.php">Temporary CreditCardPayment</a>
        </div>
    </li>'
    . '</ul>';
}
?>
    

