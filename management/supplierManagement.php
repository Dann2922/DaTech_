<?php
include_once("../connect.php");
$sql = "SELECT * from tbl_supplier";
$result = mysqli_query($conn, $sql);
$No = 1;
?>
<link rel="stylesheet" href="css/management.css">
<div>
    <h1>Supplier Management</h1>
    <a href="supplierAdd.php">Add new Supplier</a>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $No . "</td>";
                        echo "<td>" . $row["sup_id"] . "</td>";
                        echo "<td>" . $row["sup_name"] . "</td>";
                        echo "<td><a href=\"supplierUpdate.php?id=" . $row['sup_id'] . "\" class=\"btn btn-warning rounded-pill\">Update</a></td>";
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
