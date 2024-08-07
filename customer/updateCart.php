<?php
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$pro_id = isset($_GET['pro_id']) ? intval($_GET['pro_id']) : 0;

if ($action == 'remove' && $pro_id > 0) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['pro_id'] == $pro_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
}

header("Location: cart.php");
exit();
?>
