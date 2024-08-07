<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantity'] as $pro_id => $quantity) {
        $pro_id = intval($pro_id);
        $quantity = intval($quantity);

        // Ensure quantity is a positive integer
        if ($quantity < 1) {
            $quantity = 1;
        }

        // Update the quantity in the cart
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['pro_id'] == $pro_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        unset($item); // Break reference
    }
}

header("Location: cart.php");
exit();
?>
