<?php

/*
 * This a reference file from book
 */


//$userID = "";
//if (isset($_SESSION['userRec'])) {
//    $userID = $_SESSION['userRec']['ID'];
//}

namespace cart {

//    echo var_dump($products_array);

    if (!isset($_SESSION)) {
        session_start();
    }

    // Add an item to the cart
    function add_item($key, $quantity) {
        global $products_array;
        if ($quantity < 1)
            return;

        // If item already exists in cart, update quantity
//        $key = (string) $key;
        if (isset($_SESSION['cartRec'][$key])) {
            $quantity += $_SESSION['cartRec'][$key]['qty'];
            update_item($key, $quantity);
            return;
        }

        // Add item
        $cost = $products_array[$key]['PRICE'];
        $total = $cost * $quantity;
        $item = array(
            'id' => $key,
            'name' => $products_array[$key]['NAME'],
            'cost' => $cost,
            'qty' => $quantity,
            'total' => $total
        );
        $_SESSION['cartRec'][$key] = $item;
    }

    // Update an item in the cart
    function update_item($key, $quantity) {
        $quantity = (int) $quantity;
        if (isset($_SESSION['cartRec'][$key])) {
            if ($quantity <= 0) {
                unset($_SESSION['cartRec'][$key]);
            } else {
                $_SESSION['cartRec'][$key]['qty'] = $quantity;
                $total = $_SESSION['cartRec'][$key]['cost'] *
                        $_SESSION['cartRec'][$key]['qty'];
                $_SESSION['cartRec'][$key]['total'] = $total;
            }
        }
    }

    // Get cart subtotal
    function get_subtotal() {
        $subtotal = 0;
        if (!isset($_SESSION['cartRec'])) {
            return 0;
        }
        foreach ($_SESSION['cartRec'] as $item) {
            $subtotal += $item['total'];
        }
        $subtotal_f = number_format($subtotal, 2);
        return $subtotal_f;
    }

    // Get a function for sorting the cart on the specified key
    function compare_factory($sort_key) {
        return function($left, $right) use ($sort_key) {
            if ($left[$sort_key] == $right[$sort_key]) {
                return 0;
            } else if ($left[$sort_key] < $right[$sort_key]) {
                return -1;
            } else {
                return 1;
            }
        };
    }

    function getTotalQty() {
        if (!isset($_SESSION['cartRec'])) {
            return 0;
        } else {
            $qty = 0;
            foreach ($_SESSION['cartRec'] as $line) {
                $qty += $line['qty'];
            }
            return $qty;
        }
    }

}
?>