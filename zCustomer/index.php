<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datech</title>
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/style1.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>

<body>
    <nav class="navbar">
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-list left">
            <li class="has-children">
                <a href="job-listings.html">Job Listings</a>
                <ul class="dropdown">
                    <li><a href="job-single.html">Job Single</a></li>
                    <li><a href="post-job.html">Post a Job</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#">Brand <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Brand 1</a>
                    <a href="#">Brand 2</a>
                    <a href="#">Brand 3</a>
                </div>
            </li>
        </ul>
        <div class="logo">Datech.com</div>
        <ul class="nav-list right">
            <li class="nav-item">
                <a href="#"><i class="fas fa-box"></i> Order</a>
            </li>
            <li class="nav-item">
                <a href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
            <li class="nav-item">
                <a href="#"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
        </ul>
    </nav>
    <script>
        const menuIcon = document.getElementById('menu-icon');
        const navLists = document.querySelectorAll('.nav-list');

        menuIcon.addEventListener('click', () => {
            navLists.forEach(navList => navList.classList.toggle('active'));
        });
    </script>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slider-hero">
                        <div class="featured-carousel owl-carousel">
                            <div class="item">
                                <div class="work">
                                    <div class="img d-flex align-items-center justify-content-center" style="background-image: url(carousel/slider-1.jpg);">
                                        <div class="text text-center">
                                            <h2>Discover New Places</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="work">
                                    <div class="img d-flex align-items-center justify-content-center" style="background-image: url(carousel/slider-2.jpg);">
                                        <div class="text text-center">
                                            <h2>Dream Destination</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="work">
                                    <div class="img d-flex align-items-center justify-content-center" style="background-image: url(carousel/slider-3.jpg);">
                                        <div class="text text-center">
                                            <h2>Travel Exploration</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-5 text-center">
                            <ul class="thumbnail">
                                <li class="active img"><a href="#"><img src="carousel/thumb-1.jpg" alt="Image" class="img-fluid"></a></li>
                                <li><a href="#"><img src="carousel/thumb-2.jpg" alt="Image" class="img-fluid"></a></li>
                                <li><a href="#"><img src="carousel/thumb-3.jpg" alt="Image" class="img-fluid"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html> -->
<?php
include_once("../connect.php"); // Make sure this file connects to your database

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
$sql_products = "SELECT pro_id, pro_name, pro_image_detail, pro_current_price  FROM tbl_product";
$result_products = mysqli_query($conn, $sql_products);
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
            width: 50px;
            height: 50px;
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
    <!-- Existing content -->
    <nav class="navbar">
        <div class="menu-icon" id="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-list left">
            <li class="nav-item dropdown">
                <a href="#">Category <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Brand 1</a>
                    <a href="#">Brand 2</a>
                    <a href="#">Brand 3</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#">Brand <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Brand 1</a>
                    <a href="#">Brand 2</a>
                    <a href="#">Brand 3</a>
                </div>
            </li>
        </ul>
        <div class="logo">Datech.com</div>
        <ul class="nav-list right">
            <li class="nav-item">
                <a href="#"><i class="fas fa-box"></i> Order</a>
            </li>
            <li class="nav-item">
                <a href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
            </li>
            <li class="nav-item">
                <a href="#"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
                <a href="indentification.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
        </ul>
    </nav>

    <script>
        const menuIcon = document.getElementById('menu-icon');
        const navLists = document.querySelectorAll('.nav-list');

        menuIcon.addEventListener('click', () => {
            navLists.forEach(navList => navList.classList.toggle('active'));
        });
    </script>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="slider-hero">
                        <div class="featured-carousel owl-carousel">
                            <?php foreach ($images as $image) : ?>
                                <div class="item">
                                    <div class="work">
                                        <div class="img d-flex align-items-center justify-content-center" style="background-image: url('<?php echo htmlspecialchars($image['large_image']); ?>');">
                                            <div class="text text-center">
                                                <h2><?php echo htmlspecialchars($image['title']); ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="my-5 text-center">
                            <ul class="thumbnail">
                                <?php foreach ($images as $image) : ?>
                                    <li class="<?php echo ($image === reset($images)) ? 'active img' : 'img'; ?>">
                                        <a href="#"><img src="<?php echo htmlspecialchars($image['large_image']); ?>" alt="Image" class="img-fluid"></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Product Slider Section -->
    <section class="product-section">
        <div class="container">
            <h2 class="text-center">Our Products</h2>
            <div class="owl-carousel owl-theme">
                <?php while ($row = mysqli_fetch_assoc($result_products)) { ?>
                    <div class="item">
                        <div class="product-card">
                            <img src="<?php echo $row['pro_image_detail']; ?>" alt="<?php echo $row['pro_name']; ?>">
                            <h3><?php echo $row['pro_name']; ?></h3>
                            <p><?php echo $row['pro_current_price'] ; ?> $</p>
                            <a href="productDetail.php?pro_id=<?php echo $row['pro_id']; ?>">View Details</a>
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
    <script>
        $(document).ready(function(){
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 3,
                margin: 20,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
        });
    </script>
</body>

</html>