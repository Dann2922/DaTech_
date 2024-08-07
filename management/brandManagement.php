<?php
include_once("../connect.php");
$sql = "SELECT * from tbl_brand";
$result = mysqli_query($conn, $sql);
$No = 1;
?>
<link rel="stylesheet" href="../css/management.css">
<div>
    <h1>Brand Management</h1>
    <a href="brandAdd.php">Add new Brand</a>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Brand ID</th>
                    <th>Brand Name</th>
                    <th>Brand Desc</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $No . "</td>";
                        echo "<td>" . $row["brand_id"] . "</td>";
                        echo "<td>" . $row["brand_name"] . "</td>";
                        echo "<td>" . $row["brand_desc"] . "</td>";
                        echo "<td><a href=\"brandUpdate.php?id=" . $row['brand_id'] . "\" class=\"btn btn-warning rounded-pill\">Update</a></td>";
                        echo "</tr>";
                        $No++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
