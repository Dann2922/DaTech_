<?php
include_once("../connect.php");

$sql = "SELECT pt.*, c.cate_name, b.brand_name 
        FROM tbl_product_type AS pt 
        INNER JOIN tbl_category AS c ON pt.cate_id = c.cate_id 
        INNER JOIN tbl_brand AS b ON pt.brand_id = b.brand_id";
$result = mysqli_query($conn, $sql);
$No = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Type Management</title>
    <link rel="stylesheet" href="../css/management.css">
</head>
<body>
    <div>
        <h1>Product Type Management</h1>
        <a href="productTypeAdd.php">Add new Product Type</a>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Image</th>
                        <th>Production date</th>
                        <th>Description</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $No . "</td>";
                            echo "<td>" . $row['cate_name'] . "</td>";
                            echo "<td>" . $row['brand_name'] . "</td>";
                            echo "<td>" . $row['pro_model'] . "</td>";
                            echo "<td><img src='" . $row['pro_img'] . "' alt='" . $row['pro_model'] . "' width='50' height='50'></td>";
                            echo "<td>" . $row['pro_date'] . "</td>";
                            echo "<td>" . $row['pro_desc'] . "</td>";
                            echo "<td><a href=\"productTypeUpdate.php?id=" . $row['pro_type_id'] . "\" class=\"btn btn-warning rounded-pill\">Update</a></td>";
                            echo "</tr>";
                            $No++;
                        }
                    } else {
                        echo "<tr><td colspan='8'>No data found</td></tr>";
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
