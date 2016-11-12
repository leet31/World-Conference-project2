<?php
unset($_SESSION['userRec']);
if (!isset($_SESSION['userRec'])){
    include 'logout_success.php';
}

