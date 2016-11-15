<?php

if (!isset($_SESSION)) {
    session_start();
}
unset($_SESSION['userRec']);
unset($_SESSION['cartRec']); //unset all shopping cart for test purpose;
if (!isset($_SESSION['userRec'])) {
    include 'logout_success.php';
}

