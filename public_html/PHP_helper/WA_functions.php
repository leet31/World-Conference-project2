<?php

function insertProdCat($pdo, $catName) {
    $table = 'wa_product_categories';

    try {
        $stmt = $pdo->prepare("INSERT INTO $table (CATEGORY_NAME) VALUES (:catName)");
        $stmt->bindParam(':catName', $catName);
        $stmt->execute();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return '';
}

function getProdCatList($pdo) {
    $table = 'wa_product_categories';

    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    return $cats;
}

function deleteProdCat($pdo, $catID) {
    $table = 'wa_product_categories';

    try {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE ID = :catID");
        $stmt->bindParam(':catID', $catID);
        $stmt->execute();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return '';
}

function updateProdCat($pdo, $catID, $newName) {
    $table = 'wa_product_categories';

    try {
        $stmt = $pdo->prepare("UPDATE $table set CATEGORY_NAME = :newName WHERE ID = :catID");
        $stmt->bindParam(':catID', $catID);
        $stmt->bindParam(':newName', $newName);
        $stmt->execute();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return '';
}

function doProdCatAction($pdo) {
    $errMsg = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //something posted
        if (isset($_POST['btnDelete'])) {
            $errMsg = deleteProdCat($pdo, $_POST['catID']);
        } else
        if (isset($_POST['btnRename'])) {
            $errMsg = updateProdCat($pdo, $_POST['catID'], $_POST['renameValue']);
        } else
        if (isset($_POST['btnInsert'])) {
            $errMsg = insertProdCat($pdo, $_POST['catName']);
        }
    }
    
    return $errMsg;
}

?>
