<?php
include_once("../connect.php");

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cate_id = $_POST['cate_id'];
    $brand_id = $_POST['brand_id'];
    $pro_model = $_POST['pro_model'];
    $pro_img = $_FILES['pro_img']['name'];
    $pro_date = $_POST['pro_date'];
    $pro_desc = $_POST['pro_desc'];

    // Handle image upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($pro_img);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["pro_img"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO tbl_product_type (cate_id, brand_id, pro_model, pro_img, pro_date, pro_desc)
                VALUES ('$cate_id', '$brand_id', '$pro_model', '$target_file', '$pro_date', '$pro_desc')";

        if (mysqli_query($conn, $sql)) {
            $message = "New product type added successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        $message = "Sorry, there was an error uploading your file.";
    }
}

// Fetching necessary data for the form
$sql_categories = "SELECT * FROM tbl_category";
$result_categories = mysqli_query($conn, $sql_categories);

$sql_brands = "SELECT * FROM tbl_brand";
$result_brands = mysqli_query($conn, $sql_brands);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product Type</title>
    <link rel="stylesheet" href="../css/addLong.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Add New Product Type</h1>
            <?php if ($message): ?>
                <div class="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="productTypeAdd.php" enctype="multipart/form-data">

                <label for="cate_id">Category</label>
                <select name="cate_id" id="cate_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_categories)) { ?>
                        <option value="<?php echo $row['cate_id']; ?>"><?php echo $row['cate_name']; ?></option>
                    <?php } ?>
                </select>

                <label for="brand_id">Brand</label>
                <select name="brand_id" id="brand_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_brands)) { ?>
                        <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
                    <?php } ?>
                </select>

                <label for="pro_model">Model</label>
                <input type="text" id="pro_model" name="pro_model" required>

                <label for="pro_img">Image</label>
                <input type="file" id="pro_img" name="pro_img" required>

                <label for="pro_date">Production Date</label>
                <input type="date" id="pro_date" name="pro_date" required>

                <label for="pro_desc">Description</label>
                <textarea id="pro_desc" name="pro_desc" rows="4" required></textarea>

                <button type="submit" name="btnSubmit">Add Product Type</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
