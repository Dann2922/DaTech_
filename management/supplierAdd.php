<?php
include_once("../connect.php");

$sup_name = ''; // Initialize the variable
$error_message = ''; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sup_name = mysqli_real_escape_string($conn, $_POST['sup_name']);

    // Check if the supplier name already exists
    $check_sql = "SELECT * FROM tbl_supplier WHERE sup_name = '$sup_name'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Supplier name already exists. Please choose a different name.";
    } else {
        // Insert the new supplier
        $sql = "INSERT INTO tbl_supplier (sup_name) VALUES ('$sup_name')";
        if (mysqli_query($conn, $sql)) {
            echo "New supplier added successfully";
            // Redirect back to supplier management page after successful addition
            header("Location: supplierManagement.php");
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
    <title>Supplier Addition</title>
    <link rel="stylesheet" href="css/addShort.css">
</head>
<body>
    <section class="container">
        <div class="add-container">
            <div class="form-container">
                <h1>Supplier Addition</h1>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="supplierAdd.php">  
                    <input type="text" name="sup_name" placeholder="Supplier name" value="<?php echo htmlspecialchars($sup_name); ?>" required>
                    <button class="Add" type="submit" name="btnSubmit">Add</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
