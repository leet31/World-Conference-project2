<?php
require '../../controllers/connectDb.php';
if(isset($_SESSION['username'])) {
    include '../login';
} else {
    if($action === NULL){
        $action = 'reset';
    }else {
    $action = strtolower($action);
    }
}

switch ($action) {
    case 'reset':
        break;
    case 'submit':
        break;
}

