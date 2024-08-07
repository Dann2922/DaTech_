<?php
include_once("../connect.php");
$sql = "SELECT * from tbl_category";
$result = mysqli_query($conn, $sql);
$No = 1;
?>
<link rel="stylesheet" href="../css/management.css">
<div>
    <h1>Category Management</h1>
    <a href="categoryAdd.php">Add new Category</a>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $No . "</td>";
                        echo "<td>" . $row["cate_id"] . "</td>";
                        echo "<td>" . $row["cate_name"] . "</td>";
                        echo "<td><a href=\"categoryUpdate.php?id=" . $row['cate_id'] . "\" class=\"btn btn-warning rounded-pill\">Update</a></td>";
                        echo "</tr>";
                        $No++;
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
