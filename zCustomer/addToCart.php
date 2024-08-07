<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pro_id = $_POST['pro_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$pro_id])) {
        $_SESSION['cart'][$pro_id] += $quantity;
    } else {
        $_SESSION['cart'][$pro_id] = $quantity;
    }

    echo "Product added to cart successfully";
} else {
    echo "Invalid request";
}
?>
