<?php
session_start();
include_once("../connect.php"); // Include your database connection file

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process form data
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $delivery_method = htmlspecialchars($_POST['delivery_method']); // New field for delivery method

    // Assuming $cus_id is retrieved from session or elsewhere
    if (isset($_SESSION['user_id'])) {
        $cus_id = $_SESSION['user_id']; // Example, adjust as needed
    } else {
        echo "User not logged in.";
        exit();
    }

    $discount_id = null; // Adjust as needed
    $order_status = 'Pending'; // Initial order status
    $total_amount = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['pro_current_price'] * $item['quantity'];
    }

    $stmt = $conn->prepare("INSERT INTO tbl_order (cus_id, discount_id, payment_id, delivery_id, order_date, order_status, total_amount) VALUES (?, ?, ?, ?, NOW(), ?, ?)");
    $stmt->bind_param("iiiissd", $cus_id, $discount_id, $payment_method, $delivery_method, $order_status, $total_amount);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        foreach ($_SESSION['cart'] as $item) {
            $pro_id = $item['pro_id'];
            $order_quant = $item['quantity'];
            $order_price = $item['pro_current_price'];

            $stmt_detail = $conn->prepare("INSERT INTO tbl_order_detail (order_id, pro_id, order_quant, order_price) VALUES (?, ?, ?, ?)");
            $stmt_detail->bind_param("iiid", $order_id, $pro_id, $order_quant, $order_price);
            $stmt_detail->execute();
        }

        // Clear the cart after successful checkout
        unset($_SESSION['cart']);
        
        echo "<p>Thank you for your purchase, $name! Your order has been placed.</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/checkout.css">
    <style>
        .checkout-summary img {
            width: 100px;
            height: auto;
        }
        .checkout-summary table {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Checkout</h2>
    
    <!-- Cart Summary -->
    <div class="checkout-summary mb-4">
        <h4>Cart Summary</h4>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['pro_img']) ?>" alt="<?= htmlspecialchars($item['pro_name']) ?>">
                            </td>
                            <td><?= htmlspecialchars($item['pro_name']) ?></td>
                            <td>$<?= htmlspecialchars($item['pro_current_price']) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td>$<?= htmlspecialchars($item['pro_current_price'] * $item['quantity']) ?></td>
                        </tr>
                        <?php $total += $item['pro_current_price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total</strong></td>
                        <td><strong>$<?= $total ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </div>

    <!-- Checkout Form -->
    <form method="post" action="checkout.php">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select id="payment_method" name="payment_method" class="form-select" required>
                <option value="">Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="delivery_method" class="form-label">Delivery Method</label>
            <select id="delivery_method" name="delivery_method" class="form-select" required>
                <option value="">Select Delivery Method</option>
                <option value="standard">Standard Delivery</option>
                <option value="express">Express Delivery</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
</body>
</html>
