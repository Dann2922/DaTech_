<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/cart.css">
    <style>
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        .quantity-controls button {
            border: 1px solid #ddd;
            background: #fff;
            width: 30px;
            height: 30px;
        }
        .quantity-controls input {
            text-align: center;
            border: 1px solid #ddd;
            width: 40px;
            height: 30px;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Shopping Cart</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <form method="post" action="updateQuantity.php">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($item['pro_img']) ?>" alt="<?= htmlspecialchars($item['pro_name']) ?>" style="width: 100px; height: auto;">
                            </td>
                            <td><?= htmlspecialchars($item['pro_name']) ?></td>
                            <td>$<?= htmlspecialchars($item['pro_current_price']) ?></td>
                            <td>
                                <div class="quantity-controls">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('minus', <?= $item['pro_id'] ?>)">-</button>
                                    <input type="text" name="quantity[<?= $item['pro_id'] ?>]" value="<?= htmlspecialchars($item['quantity']) ?>" readonly>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('plus', <?= $item['pro_id'] ?>)">+</button>
                                </div>
                            </td>
                            <td>$<?= htmlspecialchars($item['pro_current_price'] * $item['quantity']) ?></td>
                            <td>
                                <a href="updateCart.php?action=remove&pro_id=<?= $item['pro_id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                        <?php $total += $item['pro_current_price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total</strong></td>
                        <td><strong>$<?= $total ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            <button type="submit" class="btn btn-primary">Update Cart</button>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    <?php endif; ?>
</div>

<script>
function updateQuantity(action, proId) {
    const input = document.querySelector(`input[name="quantity[${proId}]"]`);
    let quantity = parseInt(input.value, 10);
    
    if (action === 'minus') {
        if (quantity > 1) {
            input.value = quantity - 1;
        }
    } else if (action === 'plus') {
        input.value = quantity + 1;
    }
}
</script>
</body>
</html>
