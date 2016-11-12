<!-- Use php's file_get_contents() to read this file and echo() it into the <body> of each page-->
    <?php 
   
    if(isset($_SESSION['userRec'])) {
        echo '<ul  class ="account"><li><a href="../edit_account">'.$_SESSION['userRec']['FIRST_NAME'].'</a></li><li><a href="../logout">logout</a></li></ul>';
        
    }else{
    echo '<ul class ="account"><li><a href="../login">Log In</a></li><li><a href="../register">Register</a></li></ul>';
    }
    include('menu.html');
    ?>
    

