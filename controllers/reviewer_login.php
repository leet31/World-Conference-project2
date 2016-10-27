<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../public_html/PHP_helper/ProdCatModel.php';
require_once '../public_html/PHP_helper/UserModel.php';
require_once '../public_html/PHP_helper/wa_functions.php';
require_once '../public_html/PHP_helper/connectDb.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'reviewer_login';
    }
}
if ($action == 'reviewer_login') {
    include '../public_html/reviewerlogin.php';
} else {
    if ($action == 'reviewer_logging') {
        $username = filter_input(INPUT_GET, 'username');
        
    }
}