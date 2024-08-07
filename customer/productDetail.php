<?php
include_once("../connect.php");
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$pro_id = isset($_GET['pro_id']) ? intval($_GET['pro_id']) : 0;

if ($pro_id > 0) {
    // Fetch product details
    $sql = "
        SELECT p.pro_id, p.pro_name, p.pro_image_detail, p.pro_current_price, p.color, p.storage, p.pro_state, p.pro_old_price, 
               pt.pro_model, pt.pro_img, pt.pro_date, pt.pro_desc, b.brand_name
        FROM tbl_product p
        JOIN tbl_product_type pt ON p.pro_type_id = pt.pro_type_id
        JOIN tbl_brand b ON pt.brand_id = b.brand_id
        WHERE p.pro_id = ?
    ";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $pro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            // Handle case where product is not found
            $product = null;
        }
        $stmt->close();
    }
} else {
    // Handle invalid product ID
    $product = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/productDetail.css">
    <style>
        /* Custom Styles */
    </style>
</head>

<body>

    <!-- content -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 product-gallery d-flex justify-content-center">
                        <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="<?= $product['pro_image_detail'] ?>">
                            <img class="fit" src="<?= $product['pro_image_detail'] ?>" />
                        </a>
                    </div>
                    <div class="d-flex justify-content-center mb-3 product-thumbnails">
                        <!-- Add more thumbnails as needed -->
                        <a data-fslightbox="mygalley" class="mx-1" target="_blank" data-type="image" href="<?= $product['pro_image_detail'] ?>">
                            <img width="60" height="60" src="<?= $product['pro_image_detail'] ?>" />
                        </a>
                    </div>
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3 product-detail-container">
                        <h4 class="product-title text-dark"><?= htmlspecialchars($product['pro_name']) ?></h4>
                        <div class="d-flex flex-row my-3 product-rating">
                            <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">4.5</span>
                            </div>
                            <span class="text-success ms-2"><?= htmlspecialchars($product['pro_state']) ?></span>
                        </div>
                        <div class="mb-3 product-price">
                            <span>$<?= htmlspecialchars($product['pro_current_price']) ?></span>
                        </div>
                        <div class="product-details mb-4">
                            <div class="row">
                                <dt class="col-3">Model:</dt>
                                <dd class="col-9"><?= htmlspecialchars($product['pro_model']) ?></dd>
                                <dt class="col-3">Color:</dt>
                                <dd class="col-9"><?= htmlspecialchars($product['color']) ?></dd>
                                <dt class="col-3">Brand:</dt>
                                <dd class="col-9"><?= htmlspecialchars($product['brand_name']) ?></dd>
                            </div>
                        </div>
                        <hr />
                        <div class="row mb-4">
                            <div class="col-md-4 col-6">
                                <label class="mb-2">Color</label>
                                <select class="form-select border border-secondary" style="height: 35px;">
                                    <option>Red</option>
                                    <option>Blue</option>
                                    <option>Black</option>
                                </select>
                            </div>
                        </div>
                        <a href="#" class="btn btn-custom btn-buy-now">Buy now</a>
                        <a href="addToCart.php?pro_id=<?= $product['pro_id'] ?>" class="btn btn-custom btn-add-to-cart"><i class="me-1 fa fa-shopping-basket"></i> Add to cart</a>
                        <a href="#" class="btn btn-custom btn-save"><i class="me-1 fa fa-heart fa-lg"></i> Save</a>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- content -->

    <section class="bg-light border-top py-4">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <div class="border rounded-2 px-3 py-2 bg-white">
                        <!-- Pills navs -->
                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab" aria-controls="ex1-pills-1" aria-selected="true">Specification</a>
                            </li>
                        </ul>
                        <!-- Pills navs -->

                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">
                            <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                                <p>
                                    <?= htmlspecialchars($product['pro_desc']) ?>
                                </p>

                                <table class="table border mt-3 mb-2">
                                    <tr>
                                        <th class="py-2">Display</th>
                                        <td class="py-2">13.3-inch LED-backlit display with IPS</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Processor capacity</th>
                                        <td class="py-2">2.3GHz dual-core Intel Core i5</td>
                                    </tr>
                                    <tr>
                                        <th class="py-2">Memory</th>
                                        <td class="py-2">8 GB RAM or 16 GB RAM</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.10/index.min.js"></script>
</body>

</html>