<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    include_once("../connect.php");

    $category_query = "SELECT * FROM tbl_category";
    $category_result = mysqli_query($conn, $category_query);

    $brand_query = "SELECT * FROM tbl_brand";
    $brand_result = mysqli_query($conn, $brand_query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <b>Da<i>Tech</i></b>
            </a>

            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['cus_id'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="orders.php">Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search by name" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <select class="form-select me-2" aria-label="Filter by category">
                            <option selected>Filter by category</option>
                            <?php
                            while ($category = mysqli_fetch_assoc($category_result)) {
                                echo "<option value='" . $category['cate_id'] . "'>" . $category['cate_name'] . "</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                        <select class="form-select" aria-label="Filter by brand">
                            <option selected>Filter by brand</option>
                            <?php
                            while ($brand = mysqli_fetch_assoc($brand_result)) {
                                echo "<option value='" . $brand['brand_id'] . "'>" . $brand['brand_name'] . "</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</html>
