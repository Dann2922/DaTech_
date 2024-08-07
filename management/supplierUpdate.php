<?php
include_once("../connect.php");

$sup_id = ''; // Initialize the variable
$sup_name = ''; // Initialize the variable
$error_message = ''; // Initialize error message variable

if (isset($_GET['id'])) {
    $sup_id = intval($_GET['id']);

    // Fetch existing supplier details
    $sql = "SELECT * FROM tbl_supplier WHERE sup_id = $sup_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $supplier = mysqli_fetch_assoc($result);
        $sup_name = $supplier['sup_name'];
    } else {
        $error_message = "Supplier not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sup_id = intval($_POST['sup_id']);
    $sup_name = mysqli_real_escape_string($conn, $_POST['sup_name']);

    // Check if the supplier name already exists
    $check_sql = "SELECT * FROM tbl_supplier WHERE sup_name = '$sup_name' AND sup_id != $sup_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Supplier name already exists. Please choose a different name.";
    } else {
        // Update the supplier details
        $sql = "UPDATE tbl_supplier SET sup_name = '$sup_name' WHERE sup_id = $sup_id";
        if (mysqli_query($conn, $sql)) {
            echo "Supplier updated successfully";
            // Redirect back to supplier management page after successful update
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
    <title>Supplier Update</title>
    <link rel="stylesheet" href="css/addShort.css">
</head>
<body>
    <section class="container">
        <div class="add-container">
            <div class="form-container">
                <h1>Supplier Update</h1>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="supplierUpdate.php">  
                    <input type="hidden" name="sup_id" value="<?php echo htmlspecialchars($sup_id); ?>">
                    <input type="text" name="sup_name" placeholder="Supplier name" value="<?php echo htmlspecialchars($sup_name); ?>" required>
                    <button class="Add" type="submit" name="btnSubmit">Update</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
