<?php
require_once 'Mail.php';
$action = filter_input(INPUT_POST, 'commentBtn');

if ($action === NULL) {
    $action = 'reset';
} else {
    $action = strtolower($action);
}
switch ($action){
    case 'reset':
        include 'commentsandfeedback.php';
        break;
    case 'submit':
        $to = "cuicuiruancs@gmail.com";
        $subject="Comments from Conference Website";
        $message = filter_input(INPUT_POST, 'comments');
        $name= filter_input(INPUT_POST, 'name');
        $tel= filter_input(INPUT_POST, 'tel');
        $email= filter_input(INPUT_POST, 'email');
        $headers='From:'.$email."\r\n".
                'Reply-To:'.$email."\r\n".
                "MIME-Version: 1.0\r\n".
                 "Content-type: text/html\r\n";
        if (mail($to, $subject,$message,$headers)){
            include 'result.php';
            echo '<div>Comment sent successfully!</div>';
        }else {
            include 'result.php';
            echo '<div>Comment not sent!</div>';
        }   
        break;
        
}
