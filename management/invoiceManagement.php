<?php
include_once("../connect.php");

$sql = "SELECT 
            a.import_invoice_id,
            a.import_date,
            b.invoice_detail_id,
            b.import_quant,
            b.disbursement,
            p.pro_name,
            s.staff_fullname,
            sp.sup_name
        FROM tbl_import_invoice AS a
        INNER JOIN tbl_invoice_detail AS b
            ON a.import_invoice_id = b.import_invoice_id
        INNER JOIN tbl_product AS p
            ON b.pro_id = p.pro_id
        INNER JOIN tbl_staff AS s
            ON a.staff_id = s.staff_id
        INNER JOIN tbl_supplier AS sp
            ON a.sup_id = sp.sup_id";
$result = mysqli_query($conn, $sql);
$No = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <link rel="stylesheet" href="../css/management.css">
</head>
<body>
    <div>
        <h1>Product Management</h1>
        <a href="invoiceAdd.php">Add new invoice</a>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice ID</th>
                        <th>Importer</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>Import Date</th>
                        <th>Quantity</th>
                        <th>Disbursement</th>
                        <!-- <th>Update</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $No . "</td>";
                            echo "<td>" . $row["import_invoice_id"] . "</td>";
                            echo "<td>" . $row["staff_fullname"] . "</td>";
                            echo "<td>" . $row["sup_name"] . "</td>";
                            echo "<td>" . $row["pro_name"] . "</td>";
                            echo "<td>" . $row["import_date"] . "</td>";
                            echo "<td>" . $row["import_quant"] . "</td>";
                            echo "<td>" . $row["disbursement"] . "</td>";
                            // echo "<td><a href=\"?page=#&id=" . $row['pro_id'] . "\" class=\"btn btn-warning rounded-pill\">Update</a></td>";
                            echo "</tr>";
                            $No++;
                        }
                    } else {
                        echo "<tr><td colspan='9'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
