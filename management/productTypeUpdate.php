<?php
include_once("../connect.php");

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProductType'])) {
    $pro_type_id = $_POST['pro_type_id'];
    $cate_id = $_POST['cate_id'];
    $brand_id = $_POST['brand_id'];
    $pro_model = $_POST['pro_model'];
    $pro_img = $_FILES['pro_img']['name'];
    $pro_date = $_POST['pro_date'];
    $pro_desc = $_POST['pro_desc'];

    // Handle image upload
    if (!empty($pro_img)) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($pro_img);
        move_uploaded_file($_FILES["pro_img"]["tmp_name"], $target_file);
    } else {
        $target_file = $_POST['existing_img'];
    }

    $sql_update = "UPDATE tbl_product_type SET cate_id='$cate_id', brand_id='$brand_id', pro_model='$pro_model', pro_img='$target_file', pro_date='$pro_date', pro_desc='$pro_desc' WHERE pro_type_id='$pro_type_id'";
    if (mysqli_query($conn, $sql_update)) {
        $message = "Product type updated successfully";
    } else {
        $message = "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $pro_type_id = $_GET['id'];
    $sql = "SELECT * FROM tbl_product_type WHERE pro_type_id='$pro_type_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Fetching necessary data for the form
    $sql_categories = "SELECT * FROM tbl_category";
    $result_categories = mysqli_query($conn, $sql_categories);

    $sql_brands = "SELECT * FROM tbl_brand";
    $result_brands = mysqli_query($conn, $sql_brands);
} else {
    header("Location: productTypeManagement.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product Type</title>
    <link rel="stylesheet" href="../css/addLong.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Update Product Type</h1>
            <?php if ($message): ?>
                <div class="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="productTypeUpdate.php" enctype="multipart/form-data">
                <input type="hidden" name="pro_type_id" value="<?php echo $row['pro_type_id']; ?>">
                <input type="hidden" name="existing_img" value="<?php echo $row['pro_img']; ?>">

                <label for="cate_id">Category</label>
                <select name="cate_id" id="cate_id" required>
                    <?php while ($category = mysqli_fetch_assoc($result_categories)) { ?>
                        <option value="<?php echo $category['cate_id']; ?>" <?php if ($category['cate_id'] == $row['cate_id']) echo 'selected'; ?>>
                            <?php echo $category['cate_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="brand_id">Brand</label>
                <select name="brand_id" id="brand_id" required>
                    <?php while ($brand = mysqli_fetch_assoc($result_brands)) { ?>
                        <option value="<?php echo $brand['brand_id']; ?>" <?php if ($brand['brand_id'] == $row['brand_id']) echo 'selected'; ?>>
                            <?php echo $brand['brand_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="pro_model">Model</label>
                <input type="text" id="pro_model" name="pro_model" value="<?php echo $row['pro_model']; ?>" required>

                <label for="pro_img">Image</label>
                <input type="file" id="pro_img" name="pro_img">
                <img src="<?php echo $row['pro_img']; ?>" alt="Current Image" width="100">

                <label for="pro_date">Production Date</label>
                <input type="date" id="pro_date" name="pro_date" value="<?php echo $row['pro_date']; ?>" required>

                <label for="pro_desc">Description</label>
                <textarea id="pro_desc" name="pro_desc" rows="4" required><?php echo $row['pro_desc']; ?></textarea>

                <button type="submit" name="updateProductType">Update Product Type</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
