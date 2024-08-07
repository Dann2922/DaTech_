<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<?php
include_once("../connect.php");

// Fetch images from the database
$sql = "SELECT * FROM tbl_carousel";
$result = mysqli_query($conn, $sql);

$images = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Handle search query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// Fetch all products
$sql_products = "
    SELECT a.pro_id, a.pro_current_price, a.pro_type_id, b.pro_model, b.pro_img
    FROM tbl_product a
    INNER JOIN tbl_product_type b ON a.pro_type_id = b.pro_type_id
";
if (!empty($search_query)) {
    $sql_products .= " WHERE b.pro_model LIKE '%$search_query%'";
}
$result_products = mysqli_query($conn, $sql_products);

// Fetch flash sale products (using state=2 for flash sale)
$sql_flash_sales = "
    SELECT a.pro_id, a.pro_current_price, a.pro_type_id, b.pro_model, b.pro_img
    FROM tbl_product a
    INNER JOIN tbl_product_type b ON a.pro_type_id = b.pro_type_id
    WHERE a.pro_state = 1
";
$result_flash_sales = mysqli_query($conn, $sql_flash_sales);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datech</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/style1.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Additional styles for the product cards and slider */
        .product-section {
            padding: 40px 0;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-card img {
            width: 100%;
            height: auto;
        }

        .product-card h3 {
            margin: 20px 0 10px;
            font-size: 1.5rem;
        }

        .product-card p {
            margin: 0 0 20px;
            color: #777;
        }

        .product-card a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .product-card a:hover {
            background-color: #0056b3;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">

    <!-- Centered Navbar brand -->
    <div class="mx-auto d-flex justify-content-center align-items-center">
      <a class="navbar-brand me-0 me-lg-3" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <!-- Navbar collapse content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>




    <!-- <script>
        const menuIcon = document.getElementById('menu-icon');
        const navLists = document.querySelectorAll('.nav-list');

        menuIcon.addEventListener('click', () => {
            navLists.forEach(navList => navList.classList.toggle('active'));
        });
    </script> -->

    <!-- New Product Slider Section -->
    <section class="product-section">
        <div class="container">
            <h2 class="text-center">Our Products</h2>
            <div class="owl-carousel owl-theme">
                <?php while ($row = mysqli_fetch_assoc($result_products)) { ?>
                    <div class="item" style="margin-top: 10px">
                        <div class="product-card">
                            <img src="<?php echo $row['pro_img']; ?>" alt="<?php echo $row['pro_model']; ?>">
                            <h3><?php echo $row['pro_model']; ?></h3>
                            <p><?php echo $row['pro_current_price']; ?> $</p>
                            <a href="productDetail.php?pro_id=<?php echo $row['pro_id']; ?>">View Details</a>
                            <br><br>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Flash Sale Section -->
    <section class="product-section">
        <div class="container">
            <h2 class="text-center">Flash Sale</h2>
            <div class="owl-carousel owl-theme">
                <?php while ($row = mysqli_fetch_assoc($result_flash_sales)) { ?>
                    <div class="item" style="margin-top: 10px">
                        <div class="product-card">
                            <img src="<?php echo $row['pro_img']; ?>" alt="<?php echo $row['pro_model']; ?>">
                            <h3><?php echo $row['pro_model']; ?></h3>
                            <p><?php echo $row['pro_current_price']; ?> $</p>
                            <a href="productDetail.php?pro_id=<?php echo $row['pro_id']; ?>">View Details</a>
                            <br><br>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/carousel.js"></script>

    <div class="card bg-secondary">
  <div class="card-footer">
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p>A well-known quote, contained in a blockquote element.</p>
      <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
    </blockquote>
  </div>
</div>

</body>

</html>