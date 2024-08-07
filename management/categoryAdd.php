<?php
include_once("../connect.php");

$cate_name = ''; // Initialize the variable
$error_message = ''; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cate_name = mysqli_real_escape_string($conn, $_POST['cate_name']);

    // Check if the category name already exists
    $check_sql = "SELECT * FROM tbl_category WHERE cate_name = '$cate_name'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Category name already exists. Please choose a different name.";
    } else {
        // Insert the new category
        $sql = "INSERT INTO tbl_category (cate_name) VALUES ('$cate_name')";
        if (mysqli_query($conn, $sql)) {
            echo "New category added successfully";
            // Redirect back to category management page after successful addition
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
    <title>Category Addition</title>
    <link rel="stylesheet" href="css/addShort.css">
</head>
<body>
    <section class="container">
        <div class="add-container">
            <div class="form-container">
                <h1>Category Addition</h1>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="categoryAdd.php">  
                    <input type="text" name="cate_name" placeholder="Category name" value="<?php echo htmlspecialchars($cate_name); ?>" required>
                    <button class="Add" type="submit" name="btnSubmit">Add</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
