<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=csit537_project1', 'WA_DbUser', 'secretpassword1');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
