<?php
include_once("../connect.php");

$brand_id = ''; // Initialize the variable
$brand_name = ''; // Initialize the variable
$brand_desc = ''; // Initialize the variable
$error_message = ''; // Initialize error message variable

if (isset($_GET['id'])) {
    $brand_id = intval($_GET['id']);

    // Fetch existing brand details
    $sql = "SELECT * FROM tbl_brand WHERE brand_id = $brand_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $brand = mysqli_fetch_assoc($result);
        $brand_name = $brand['brand_name'];
        $brand_desc = $brand['brand_desc'];
    } else {
        $error_message = "Brand not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand_id = intval($_POST['brand_id']);
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $brand_desc = mysqli_real_escape_string($conn, $_POST['brand_desc']); // Get the brand description

    // Check if the brand name already exists for a different brand ID
    $check_sql = "SELECT * FROM tbl_brand WHERE brand_name = '$brand_name' AND brand_id != $brand_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Brand name already exists. Please choose a different name.";
    } else {
        // Update the brand details
        $sql = "UPDATE tbl_brand SET brand_name = '$brand_name', brand_desc = '$brand_desc' WHERE brand_id = $brand_id";
        if (mysqli_query($conn, $sql)) {
            echo "Brand updated successfully";
            // Redirect back to brand management page after successful update
            header("Location: brandManagement.php");
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Update</title>
    <link rel="stylesheet" href="css/addShort.css">
</head>
<body>
    <section class="container">
        <div class="add-container">
            <div class="form-container">
                <h1>Brand Update</h1>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="brandUpdate.php">  
                    <input type="hidden" name="brand_id" value="<?php echo htmlspecialchars($brand_id); ?>">
                    <input type="text" name="brand_name" placeholder="Brand name" value="<?php echo htmlspecialchars($brand_name); ?>" required>
                    <input type="text" name="brand_desc" placeholder="Brand description" value="<?php echo htmlspecialchars($brand_desc); ?>" required>
                    <button class="Add" type="submit" name="btnSubmit">Update</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
