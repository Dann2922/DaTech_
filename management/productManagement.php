<?php
include_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProduct'])) {
    $pro_id = $_POST['pro_id'];
    $pro_type_id = $_POST['pro_type_id'];
    $pro_name = $_POST['pro_name'];
    $pro_image_detail = $_FILES['pro_image_detail']['name'];
    $color = $_POST['color'];
    $storage = $_POST['storage'];
    $pro_state = $_POST['pro_state'];
    $pro_old_price = $_POST['pro_old_price'];
    $pro_current_price = $_POST['pro_current_price'];
    $pro_quant = $_POST['pro_quant'];

    // Handle file upload if a new image is provided
    if (!empty($pro_image_detail)) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($pro_image_detail);
        move_uploaded_file($_FILES["pro_image_detail"]["tmp_name"], $target_file);
    } else {
        // If no new image is uploaded, use the existing image
        $target_file = $_POST['existing_img'];
    }

    $sql_update = "UPDATE tbl_product SET pro_type_id='$pro_type_id', pro_name='$pro_name', pro_image_detail='$target_file', color='$color', storage='$storage', pro_state='$pro_state', pro_old_price='$pro_old_price', pro_current_price='$pro_current_price', pro_quant='$pro_quant' WHERE pro_id='$pro_id'";
    mysqli_query($conn, $sql_update);
}

$sql = "SELECT p.*, t.cate_id, t.brand_id, t.pro_model, c.cate_name, b.brand_name 
        FROM tbl_product AS p 
        INNER JOIN tbl_product_type AS t ON p.pro_type_id = t.pro_type_id 
        INNER JOIN tbl_category AS c ON t.cate_id = c.cate_id 
        INNER JOIN tbl_brand AS b ON t.brand_id = b.brand_id";
$result = mysqli_query($conn, $sql);
$No = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="../css/management.css">
</head>

<body>
    <div>
        <h1>Product Management</h1>
        <a href="productAdd.php">Add new Product</a>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Model</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Storage</th>
                        <th>State</th>
                        <th>Old Price</th>
                        <th>Current Price</th>
                        <th>Quantity</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $No . "</td>";
                            echo "<td>" . $row['pro_model'] . "</td>";
                            echo "<td>" . $row['pro_name'] ." ". $row['color'] . "</td>";
                            echo "<td><img src='" . $row['pro_image_detail'] . "' alt='" . $row['pro_name'] . "' width='50' height='50'></td>";
                            echo "<td>" . $row['color'] . "</td>";
                            echo "<td>" . $row['storage'] . "</td>";
                            echo "<td>" . $row['pro_state'] . "</td>";
                            echo "<td>" . $row['pro_old_price'] . "</td>";
                            echo "<td>" . $row['pro_current_price'] . "</td>";
                            echo "<td>" . $row['pro_quant'] . "</td>";
                            echo "<td><a href=\"productUpdate.php?id=" . $row['pro_id'] . "\" class=\"btn btn-warning rounded-pill\">Update</a></td>";
                            echo "</tr>";
                            $No++;
                        }
                    } else {
                        echo "<tr><td colspan='13'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>
