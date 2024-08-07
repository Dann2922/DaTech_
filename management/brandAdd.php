<?php
include_once("../connect.php");

$brand_name = ''; // Initialize the variable
$brand_desc = ''; // Initialize the variable
$error_message = ''; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $brand_desc = mysqli_real_escape_string($conn, $_POST['brand_desc']); // Get the brand description

    // Check if the brand name already exists
    $check_sql = "SELECT * FROM tbl_brand WHERE brand_name = '$brand_name'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Brand name already exists. Please choose a different name.";
    } else {
        $sql = "INSERT INTO tbl_brand (brand_name, brand_desc) VALUES ('$brand_name', '$brand_desc')";
        if (mysqli_query($conn, $sql)) {
            echo "New brand added successfully";
            // Redirect back to brand management page after successful addition
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
    <title>Brand Addition</title>
    <link rel="stylesheet" href="../css/addShort.css">
</head>
<body>
    <section class="container">
        <div class="add-container">
            <div class="form-container">
                <h1>Brand Addition</h1>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="brandAdd.php">  
                    <input type="text" name="brand_name" placeholder="Brand name" value="<?php echo htmlspecialchars($brand_name); ?>" required>
                    <input type="text" name="brand_desc" placeholder="Brand description" value="<?php echo htmlspecialchars($brand_desc); ?>" required>
                    <button class="Add" type="submit" name="btnSubmit">Add</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
