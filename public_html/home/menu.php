<!-- Use php's file_get_contents() to read this file and echo() it into the <body> of each page-->
<?php
if (isset($_SESSION['userRec'])) {
    echo '<ul  class ="account"><li><a href="../edit_account">' . $_SESSION['userRec']['FIRST_NAME'] . '</a></li><li><a href="../logout">logout</a></li></ul>';
} else {
    echo '<ul class ="account"><li><a href="../login">Log In</a></li><li><a href="../register">Register</a></li></ul>';
}
include('menu.html');
if (isset($_SESSION['userRec']) && $_SESSION['userRec']['ADMIN'] == TRUE) {
    echo '<ul class="admin_menu">'
    . ' <li class="dropdown">
        <a href ="#" class ="dropbtn">Content Management</a>
        <div class="dropdown-content">
        <a href="../home/editCategories>Edit Product Categories</a>
            <a href="../home/editAreas.php">Edit Content Areas</a>
            <a href="../home/editSubareas.php">Edit Content Subareas</a>
        </div>
    </li>
    <li class ="dropdown">
        <a href ="#" class ="dropbtn">Diagnostics Menu</a>
        <div class="dropdown-content">
            <a href="../home/tempRegPage.php">Temporary Registration Page</a>
            <a href="../home/tempLoginPage.php">Temporary Login Page</a>
        </div>
    </li>'
    . '</ul>';
}
?>
    

