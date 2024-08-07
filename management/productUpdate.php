<?php
include_once("../connect.php");

function resizeImage($source, $destination, $max_width, $max_height, $imageFileType) {
    list($width, $height) = getimagesize($source);
    $ratio = $width / $height;

    if ($width > $height) {
        $new_width = $max_width;
        $new_height = $max_width / $ratio;
    } else {
        $new_height = $max_height;
        $new_width = $max_height * $ratio;
    }

    $new_image = imagecreatetruecolor($new_width, $new_height);

    switch ($imageFileType) {
        case 'jpg':
        case 'jpeg':
            $source_image = imagecreatefromjpeg($source);
            break;
        case 'png':
            $source_image = imagecreatefrompng($source);
            break;
        case 'gif':
            $source_image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    switch ($imageFileType) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($new_image, $destination);
            break;
        case 'png':
            imagepng($new_image, $destination);
            break;
        case 'gif':
            imagegif($new_image, $destination);
            break;
    }

    return true;
}

$message = '';

// Get the product ID from the URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT * FROM tbl_product WHERE pro_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProduct'])) {
    $pro_type_id = $_POST['pro_type_id'];
    $pro_name = $_POST['pro_name'];
    $color = $_POST['color'];
    $storage = $_POST['storage'];
    $pro_state = $_POST['pro_state'];
    $pro_old_price = $_POST['pro_old_price'];
    $pro_current_price = $_POST['pro_current_price'];
    $pro_quant = $_POST['pro_quant'];
    $pro_image_detail = $_FILES['pro_image_detail']['name'];

    // Handle file upload if a new image is provided
    if (!empty($pro_image_detail)) {
        $target_dir = "../uploads/";
        $imageFileType = strtolower(pathinfo($pro_image_detail, PATHINFO_EXTENSION));
        $image_name = preg_replace("/[^a-zA-Z0-9]/", "_", $pro_name . '_' . $color ) . '.' . $imageFileType;
        $target_file = $target_dir . $image_name;

        if (resizeImage($_FILES["pro_image_detail"]["tmp_name"], $target_file, 800, 800, $imageFileType)) {
            $pro_image_detail = $target_file;
        } else {
            $message = "Sorry, there was an error resizing or uploading your file.";
        }
    } else {
        // If no new image is uploaded, use the existing image
        $pro_image_detail = $_POST['existing_img'];
    }

    $sql_update = "UPDATE tbl_product SET pro_type_id=?, pro_name=?, pro_image_detail=?, color=?, storage=?, pro_state=?, pro_old_price=?, pro_current_price=?, pro_quant=? WHERE pro_id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("isssssddii", $pro_type_id, $pro_name, $pro_image_detail, $color, $storage, $pro_state, $pro_old_price, $pro_current_price, $pro_quant, $productId);

    if ($stmt_update->execute()) {
        $message = "Product updated successfully!";
    } else {
        $message = "Error updating product: " . $conn->error;
    }
}

// Fetching necessary data for the form
$sql_product_types = "SELECT * FROM tbl_product_type";
$result_product_types = mysqli_query($conn, $sql_product_types);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="../css/addLong.css">
    <link rel="stylesheet" href="../css/imagePreview.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Update Product</h1>
            <?php if ($message): ?>
                <div class="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="productUpdate.php?id=<?= $productId ?>" enctype="multipart/form-data">
                <input type="hidden" name="pro_id" value="<?= $productId ?>">

                <label for="pro_type_id">Product Type</label>
                <select name="pro_type_id" id="pro_type_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_product_types)) { ?>
                        <option value="<?php echo $row['pro_type_id']; ?>" <?= $row['pro_type_id'] == $product['pro_type_id'] ? 'selected' : '' ?>><?php echo $row['pro_model']; ?></option>
                    <?php } ?>
                </select>

                <label for="pro_name">Product Name</label>
                <input type="text" id="pro_name" name="pro_name" value="<?= htmlspecialchars($product['pro_name']) ?>" required>

                <label for="pro_image_detail">Product Image</label>
                <input type="file" id="pro_image_detail" name="pro_image_detail">
                <input type="hidden" name="existing_img" value="<?= htmlspecialchars($product['pro_image_detail']) ?>">
                <div id="pro_image_detail_preview" class="image-preview">
                    <img src="<?= htmlspecialchars($product['pro_image_detail']) ?>" alt="<?= htmlspecialchars($product['pro_name']) ?>" width="100">
                </div>

                <label for="color">Color</label>
                <input type="text" id="color" name="color" value="<?= htmlspecialchars($product['color']) ?>" required>

                <label for="storage">Storage</label>
                <input type="text" id="storage" name="storage" value="<?= htmlspecialchars($product['storage']) ?>" required>

                <label for="pro_state">Product State</label>
                <select name="pro_state" id="pro_state" required>
                    <option value="0">Normal</option>
                    <option value="1">Pre-order</option>
                    <option value="2">Sold Out</option>
                </select>

                <label for="pro_old_price">Old Price</label>
                <input type="text" id="pro_old_price" name="pro_old_price" value="<?= htmlspecialchars($product['pro_old_price']) ?>" required>

                <label for="pro_current_price">Current Price</label>
                <input type="text" id="pro_current_price" name="pro_current_price" value="<?= htmlspecialchars($product['pro_current_price']) ?>" required>

                <label for="pro_quant">Quantity</label>
                <input type="number" id="pro_quant" name="pro_quant" value="<?= htmlspecialchars($product['pro_quant']) ?>" required>

                <button type="submit" name="updateProduct">Update Product</button>
            </form>
        </div>
    </div>
    <script src="../js/imagePreview.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
