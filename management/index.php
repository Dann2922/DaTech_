<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DaTech</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar">
        <div class="logo">Management</div>
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-list" id="nav-list">
            <li class="nav-item dropdown">
                <a href="#">Item <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="brandManagement.php">Brand</a>
                    <a href="supplierManagement.php">Supplier</a>
                    <a href="categoryManagement.php">Category</a>
                    <a href="productTypeManagement.php">Product Series</a>
                    <a href="invoiceManagement.php">Invoice</a>
                    <a href="productManagement.php">Product</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#">Order <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="">Order</a>
                    <a href="">Delivery</a>
                    <a href="">Discount</a>
                    <a href="">Payment</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#">Account <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Staff</a>
                    <a href="#">Customer</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="#"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
                <a href="loginStaff.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
        </ul>
    </nav>

    <script>
        const menuIcon = document.getElementById('menu-icon');
        const navList = document.getElementById('nav-list');

        menuIcon.addEventListener('click', () => {
            navList.classList.toggle('active');
        });
    </script>
</body>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #535C91;
}
</style>
</html>