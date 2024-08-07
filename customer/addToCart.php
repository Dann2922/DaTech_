<?php
session_start();
include_once("../connect.php");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$pro_id = isset($_GET['pro_id']) ? intval($_GET['pro_id']) : 0;
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : null;

if ($pro_id > 0) {
    // Fetch product details
    $sql = "
        SELECT p.pro_id, p.pro_name, p.pro_current_price, pt.pro_model, pt.pro_img
        FROM tbl_product p
        JOIN tbl_product_type pt ON p.pro_type_id = pt.pro_type_id
        WHERE p.pro_id = ?
    ";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $pro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            
            // Check if the product is already in the cart
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['pro_id'] == $pro_id) {
                    $item['quantity'] += 1; // Increase quantity if found
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                // Add new product to the cart
                $product['quantity'] = 1; // Ensure quantity is set
                $_SESSION['cart'][] = $product;
            }
            
            // Insert order details into the tbl_order_detail table
            $order_quant = $product['quantity'];
            $order_price = $product['pro_current_price'] * $order_quant;

            // Create a new order_id if not set
            if (is_null($order_id)) {
                $sql_order = "INSERT INTO tbl_order (order_date, payment_id) VALUES (NOW(), NULL)"; // Assuming payment_id can be NULL or adjust accordingly
                if ($conn->query($sql_order) === TRUE) {
                    $order_id = $conn->insert_id;
                    $_SESSION['order_id'] = $order_id;
                }
            }

            $sql_order_detail = "
                INSERT INTO tbl_order_detail (order_id, pro_id, order_quant, order_price) 
                VALUES (?, ?, ?, ?)
            ";
            if ($stmt_order_detail = $conn->prepare($sql_order_detail)) {
                $stmt_order_detail->bind_param("iiid", $order_id, $pro_id, $order_quant, $order_price);
                $stmt_order_detail->execute();
                $stmt_order_detail->close();
            }
        }
        $stmt->close();
    }
}

header("Location: cart.php");
exit();
?>
