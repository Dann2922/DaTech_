<?php
session_start();

if (isset($_GET['pro_id'])) {
    $product_id = $_GET['pro_id'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Reindex the array
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    
    header('Location: cart.php');
    exit;
}
?>
