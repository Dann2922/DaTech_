<?php
include_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $sup_id = $_POST['sup_id'];
    $import_date = $_POST['import_date'];
    $invoice_details = $_POST['invoice_details'];

    // Insert into tbl_import_invoice
    $sql = "INSERT INTO tbl_import_invoice (staff_id, sup_id, import_date) VALUES ('$staff_id', '$sup_id', '$import_date')";
    if (mysqli_query($conn, $sql)) {
        $import_invoice_id = mysqli_insert_id($conn);

        // Insert into tbl_invoice_detail
        foreach ($invoice_details as $detail) {
            $pro_id = $detail['pro_id'];
            $import_quant = $detail['import_quant'];
            $disbursement = $detail['disbursement'];

            $sql_detail = "INSERT INTO tbl_invoice_detail (import_invoice_id, pro_id, import_quant, disbursement)
                           VALUES ('$import_invoice_id', '$pro_id', '$import_quant', '$disbursement')";
            mysqli_query($conn, $sql_detail);

            // Update product quantity
            $sql_update_product = "UPDATE tbl_product SET pro_quant = pro_quant + $import_quant WHERE pro_id = '$pro_id'";
            mysqli_query($conn, $sql_update_product);
        }

        echo "New invoice added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetching necessary data for the form
$sql_products = "SELECT * FROM tbl_product";
$result_products = mysqli_query($conn, $sql_products);

$sql_staff = "SELECT * FROM tbl_staff";
$result_staff = mysqli_query($conn, $sql_staff);

$sql_suppliers = "SELECT * FROM tbl_supplier";
$result_suppliers = mysqli_query($conn, $sql_suppliers);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Invoice</title>
    <link rel="stylesheet" href="../css/addLong.css">
</head>

<body>
    <br>
    <div class="container">
        <div class="form-container">
            <h1>Add New Invoice</h1>
            <form method="post" action="addInvoice.php">
                <label for="staff_id">Staff</label> 
                <!-- get section static data from user -->
                <select name="staff_id" id="staff_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_staff)) { ?>
                        <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['staff_fullname']; ?></option>
                    <?php } ?>
                </select>

                <label for="sup_id">Supplier</label>
                <select name="sup_id" id="sup_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_suppliers)) { ?>
                        <option value="<?php echo $row['sup_id']; ?>"><?php echo $row['sup_name']; ?></option>
                    <?php } ?>
                </select>

                <label for="import_date">Import Date</label>
                <input type="date" id="import_date" name="import_date" required>

                <h2>Invoice Details</h2>
                <div id="invoice-details-container">
                    <div class="invoice-detail">
                        <label for="pro_id">Product</label>
                        <select name="invoice_details[0][pro_id]" required>
                            <?php while ($row = mysqli_fetch_assoc($result_products)) { ?>
                                <option value="<?php echo $row['pro_id']; ?>"><?php echo $row['pro_name']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="import_quant">Quantity</label>
                        <input type="number" name="invoice_details[0][import_quant]" required>

                        <label for="disbursement">Disbursement</label>
                        <input type="number" name="invoice_details[0][disbursement]" required>
                    </div>
                </div>
                <button type="button" id="add-detail-button">Add More Details</button>
<br>
                <button type="submit" name="btnSubmit">Add Invoice</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-detail-button').addEventListener('click', function() {
            const container = document.getElementById('invoice-details-container');
            const index = container.children.length;

            const detailDiv = document.createElement('div');
            detailDiv.classList.add('invoice-detail');

            detailDiv.innerHTML = `
                <label for="pro_id">Product</label>
                <select name="invoice_details[${index}][pro_id]" required>
                    <?php while ($row = mysqli_fetch_assoc($result_products)) { ?>
                        <option value="<?php echo $row['pro_id']; ?>"><?php echo $row['pro_name']; ?></option>
                    <?php } ?>
                </select>

                <label for="import_quant">Quantity</label>
                <input type="number" name="invoice_details[${index}][import_quant]" required>

                <label for="disbursement">Disbursement</label>
                <input type="number" name="invoice_details[${index}][disbursement]" required>
            `;

            container.appendChild(detailDiv);
        });
    </script>
</body>

</html>