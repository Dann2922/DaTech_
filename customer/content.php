<?php
include_once("../connect.php");

// Fetch images for slideshow
$sql_slideshow = "SELECT * FROM tbl_carousel";
$result_slideshow = mysqli_query($conn, $sql_slideshow);

$slideshow_images = [];
if ($result_slideshow) {
    while ($row = mysqli_fetch_assoc($result_slideshow)) {
        $slideshow_images[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Handle search query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// Fetch all products for gallery
$sql_products = "
    SELECT a.pro_id, a.pro_current_price, a.pro_type_id, b.pro_model, b.pro_img
    FROM tbl_product a
    INNER JOIN tbl_product_type b ON a.pro_type_id = b.pro_type_id
";
if (!empty($search_query)) {
    $sql_products .= " WHERE b.pro_model LIKE '%$search_query%'";
}
$result_products = mysqli_query($conn, $sql_products);

// Fetch flash sale products (using state=1 for flash sale)
$sql_flash_sales = "
    SELECT a.pro_id, a.pro_current_price, a.pro_type_id, b.pro_model, b.pro_img
    FROM tbl_product a
    INNER JOIN tbl_product_type b ON a.pro_type_id = b.pro_type_id
    WHERE a.pro_state = 1
";
$result_flash_sales = mysqli_query($conn, $sql_flash_sales);

// Fetch best seller products (using state=3 for best seller)
$sql_best_sellers = "
    SELECT a.pro_id, a.pro_current_price, a.pro_type_id, b.pro_model, b.pro_img
    FROM tbl_product a
    INNER JOIN tbl_product_type b ON a.pro_type_id = b.pro_type_id
    WHERE a.pro_state = 3
";
$result_best_sellers = mysqli_query($conn, $sql_best_sellers);
?>

<!-- Slideshow Section -->
<section class="slideshow-section">
    <div class="container">
        <div class="owl-carousel owl-theme">
            <?php foreach ($slideshow_images as $image) { ?>
                <div class="item">
                    <img src="<?php echo $image['carousel_img']; ?>" alt="Slideshow Image">
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

<!-- Best Seller Section -->
<section class="product-section">
    <div class="container">
        <h2 class="text-center">Best Sellers</h2>
        <div class="owl-carousel owl-theme">
            <?php while ($row = mysqli_fetch_assoc($result_best_sellers)) { ?>
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

<!-- Product Gallery Section -->
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

<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/carousel.js"></script>
