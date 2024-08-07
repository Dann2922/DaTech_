<?php
include_once("../connect.php");

$cate_id = ''; // Initialize the variable
$cate_name = ''; // Initialize the variable
$error_message = ''; // Initialize error message variable

if (isset($_GET['id'])) {
    $cate_id = intval($_GET['id']);

    // Fetch existing category details
    $sql = "SELECT * FROM tbl_category WHERE cate_id = $cate_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
        $cate_name = $category['cate_name'];
    } else {
        $error_message = "Category not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cate_id = intval($_POST['cate_id']);
    $cate_name = mysqli_real_escape_string($conn, $_POST['cate_name']);

    // Check if the category name already exists for a different category ID
    $check_sql = "SELECT * FROM tbl_category WHERE cate_name = '$cate_name' AND cate_id != $cate_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Category name already exists. Please choose a different name.";
    } else {
        // Update the category details
        $sql = "UPDATE tbl_category SET cate_name = '$cate_name' WHERE cate_id = $cate_id";
        if (mysqli_query($conn, $sql)) {
            echo "Category updated successfully";
            // Redirect back to category management page after successful update
            header("Location: categoryManagement.php");
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
    <title>Category Update</title>
    <link rel="stylesheet" href="css/addShort.css">
</head>
<body>
    <section class="container">
        <div class="add-container">
            <div class="form-container">
                <h1>Category Update</h1>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="categoryUpdate.php">  
                    <input type="hidden" name="cate_id" value="<?php echo htmlspecialchars($cate_id); ?>">
                    <input type="text" name="cate_name" placeholder="Category name" value="<?php echo htmlspecialchars($cate_name); ?>" required>
                    <button class="Add" type="submit" name="btnSubmit">Update</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
