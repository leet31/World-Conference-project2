<?php

class ProdModel {

    private $pdo;
    private $table = 'wa_products';

    public function __construct($inPdo) {
        if ($inPdo instanceof PDO) {
            $this->pdo = $inPdo;
        } else {
            die("Object Type Error");
        }
    }

    public function insert($catID, $name, $description, $price, $img_name) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (CATEGORY, NAME, DESCRIPTION, PRICE, IMG_NAME) VALUES (:catID, :name, :description, :price, :img)");
            $stmt->bindParam(':catID', $catID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':img', $img_name);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'Add Successfully! ';
    }

    public function getList($notCategory = ''){
        if ($notCategory != ''){
            $notCategory .= '%';
            $sql = "SELECT p.*
                    FROM `wa_products`as p 
                    INNER JOIN `wa_product_categories` AS pc 
                            WHERE (pc.ID = p.CATEGORY) 
                                    AND (pc.CATEGORY_NAME NOT LIKE :categoryName)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':categoryName', $notCategory);
        }else{
            $sql = "SELECT * FROM $this->table";
            $stmt = $this->pdo->prepare($sql);
        }
        
        echo("<br>prod not: $notCategory<br>");
        echo("<br>SQL: $sql<br>");
        
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getListByCat($catID) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE CATEGORY = :catID");
        $stmt->bindParam(':catID', $catID);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getProductByID($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch();
        return $product;
    }

    public function delete($productID) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE ID = :productID");
            $stmt->bindParam(':productID', $productID);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'Deleted Successfully! ';
    }

    public function update($productID, $catID, $name, $description, $price, $img) {
       
        try {
            $stmt = $this->pdo->prepare("UPDATE $this->table set CATEGORY = :catID, NAME = :name, DESCRIPTION =:description, PRICE=:price, IMG_NAME=:img WHERE ID = :productID");
            $stmt->bindParam(':productID', $productID);
            $stmt->bindParam(':catID', $catID);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':img', $img);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 'Updated Successfully! ';
    }

    public function doAction() {
        $errMsg = '';
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
            if (filter_input(INPUT_POST, 'btnDelete')) {
                $errMsg = $this->delete(filter_input(INPUT_POST, 'productID'));
            } else
            if (filter_input(INPUT_POST, 'btnUpdate')) {
                $errMsg = '';
                $name = $_FILES['newfile']['name'];
                $tmp_name = $_FILES['newfile']['tmp_name'];
                $type = $_FILES['newfile']['type'];
                $size = $_FILES['newfile']['size'];
                $extension = strtolower(substr($name, strpos($name, '.') + 1));
                $new_name = time() . '.' . $extension;
                if (isset($name)) {
                    if (!empty($name)) {
                        if (($extension == 'png' AND $type = 'image/png') || ($extension == 'jpeg' AND $type = 'image/jpeg') || ($extension == 'gif' AND $type = 'image/gif') || ($extension == 'jpeg' AND $type = 'image/pjpeg')) {
                            $location = '../product_images/';
                            if (move_uploaded_file($tmp_name, $location . $new_name)) {
                                //updated
                                $errMsg .= $this->update(filter_input(INPUT_POST, 'productID'), filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'name'), filter_input(INPUT_POST, 'description'), filter_input(INPUT_POST, 'price'), $new_name);
                            } else {
                                $errMsg .= "There were an error with the image uploading. ";
                            }
                        } else {
                            $errMsg .= "The file must be with png, jpeg, gif extension. ";
                        }
                    } else {
                        //no image is changed.
                        $productID = filter_input(INPUT_POST, 'productID');
                        $product = $this->getProductByID($productID);
                        $img = $product["IMG_NAME"];
                        $errMsg .= $this->update($productID, filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'name'), filter_input(INPUT_POST, 'description'), filter_input(INPUT_POST, 'price'), $img);
                    }
                }
            } else if (filter_input(INPUT_POST, 'btnInsert')) {//add new
                $errMsg = '';
                $name = $_FILES['file']['name'];
                $tmp_name = $_FILES['file']['tmp_name'];
                $type = $_FILES['file']['type'];
                $size = $_FILES['file']['size'];
                $extension = strtolower(substr($name, strpos($name, '.') + 1));
                $new_name = time() . '.' . $extension;
                if (isset($name)) {
                    if (!empty($name)) {
                        if (($extension == 'png' AND $type = 'image/png') || ($extension == 'jpeg' AND $type = 'image/jpeg') || ($extension == 'gif' AND $type = 'image/gif') || ($extension == 'jpeg' AND $type = 'image/pjpeg')) {
                            $location = '../product_images/';
                            if (move_uploaded_file($tmp_name, $location . $new_name)) {
                                //updated
                                $errMsg .= $this->insert(filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'name'), filter_input(INPUT_POST, 'description'), filter_input(INPUT_POST, 'price'), $new_name);
                            } else {
                                $errMsg .= "There were an error with the image uploading. ";
                            }
                        } else {
                            $errMsg .= "The file must be with png, jpeg, gif extension. ";
                        }
                    } else {
                        //no image is changed.
                        $errMsg .= $this->insert(filter_input(INPUT_POST, 'catID'), filter_input(INPUT_POST, 'name'), filter_input(INPUT_POST, 'description'), filter_input(INPUT_POST, 'price'), 'default.png');
                    }
                }
            }
        }

        return $errMsg;
    }
    
    /**
     * 
     * @param type $categoryName must be EXACT MATCH for wa_product_categories.CATEGORY_NAME
     * @param type $productName must contain enough of the first part of wa_products.NAME to match exactly one record
     */
    public function getProductInfoByName($categoryName, $productName){
        $productName .='%';
        
        $sql = "SELECT p.*
                FROM `wa_products`as p 
                INNER JOIN `wa_product_categories` AS pc 
                        WHERE (pc.ID = p.CATEGORY) 
                                AND (pc.CATEGORY_NAME = :categoryName)
                                AND (p.NAME LIKE :productName)";
//        echo("<br>sql: $sql<br>");
//        echo("<br>cat: $categoryName<br>");
//        echo("<br>prod: $productName<br>");
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':categoryName', $categoryName);
            $stmt->bindValue(':productName', $productName, PDO::PARAM_STR);
            $res = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        if (!$res) {
            return 'getProductInfoByName Failed';
        }

        $count = $stmt->rowCount();
        if ($count != 1) {
            return "Error: Wrong number of rows returned: $count";
        }
        
        $row = $stmt->fetch();
        return $row;
    }

}

?>
