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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pro_type_id = $_POST['pro_type_id'];
    $pro_name = $_POST['pro_name'];
    $color = $_POST['color'];
    $storage = $_POST['storage'];
    $pro_state = $_POST['pro_state'];
    $pro_old_price = $_POST['pro_old_price'];
    $pro_current_price = $_POST['pro_current_price'];
    $pro_quant = $_POST['pro_quant'];

    // Handle main image upload
    $target_dir = "../uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["pro_image_detail"]["name"], PATHINFO_EXTENSION));
    $image_name = preg_replace("/[^a-zA-Z0-9]/", "_", $pro_name . '_' . $color ) . '.' . $imageFileType;
    $target_file = $target_dir . $image_name;
    $uploadOk = 1;

    // Check if image file is a valid image
    $check = getimagesize($_FILES["pro_image_detail"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["pro_image_detail"]["size"] > 5000000) { // 5MB limit
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = $error;
    } else {
        $temp_file = $_FILES["pro_image_detail"]["tmp_name"];
        if (resizeImage($temp_file, $target_file, 800, 800, $imageFileType)) {
            $pro_image_detail = $target_file;
        } else {
            $message = "Sorry, there was an error resizing or uploading your file.";
        }
    }

    if ($uploadOk == 1) {
        $sql = "INSERT INTO tbl_product (pro_type_id, pro_name, pro_image_detail, color, storage, pro_state, pro_old_price, pro_current_price, pro_quant)
                VALUES ('$pro_type_id', '$pro_name', '$pro_image_detail', '$color', '$storage', '$pro_state', '$pro_old_price', '$pro_current_price', '$pro_quant')";

        if (mysqli_query($conn, $sql)) {
            $message = "New product added successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
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
    <title>Add New Product</title>
    <link rel="stylesheet" href="../css/addLong.css">
    <link rel="stylesheet" href="../css/imagePreview.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Add New Product</h1>
            <?php if ($message): ?>
                <div class="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="productAdd.php" enctype="multipart/form-data">

                <label for="pro_type_id">Product Type</label>
                <select name="pro_type_id" id="pro_type_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_product_types)) { ?>
                        <option value="<?php echo $row['pro_type_id']; ?>"><?php echo $row['pro_model']; ?></option>
                    <?php } ?>
                </select>

                <label for="pro_name">Product Name</label>
                <input type="text" id="pro_name" name="pro_name" required>

                <label for="pro_image_detail">Product Image</label>
                <input type="file" id="pro_image_detail" name="pro_image_detail" required>
                <div id="pro_image_detail_preview" class="image-preview"></div>

                <label for="color">Color</label>
                <input type="text" id="color" name="color" required>

                <label for="storage">Storage</label>
                <input type="text" id="storage" name="storage" required>

                <label for="pro_state">Product State</label>
                <select name="pro_state" id="pro_state" required>
                    <option value="0">Normal</option>
                    <option value="1">Pre-order</option>
                    <option value="2">Sold Out</option>
                </select>

                <label for="pro_old_price">Old Price</label>
                <input type="text" id="pro_old_price" name="pro_old_price" required>

                <label for="pro_current_price">Current Price</label>
                <input type="text" id="pro_current_price" name="pro_current_price" required>

                <label for="pro_quant">Quantity</label>
                <input type="number" id="pro_quant" name="pro_quant" required>

                <label>Sub Images</label>
                <div id="sub-images-container">
                    <div>
                        <input type="file" name="sub_images[]" >
                    </div>
                </div>
                <button type="button" id="add-sub-image-button">Add Another Sub Image</button>
                <div id="sub_images_preview" class="image-preview"></div>

                <button type="submit" name="btnSubmit">Add Product</button>
            </form>
        </div>
    </div>
    <script src="../js/imagePreview.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
