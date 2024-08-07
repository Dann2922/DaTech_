<?php
include_once("connect.php"); // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $identifier = mysqli_real_escape_string($conn, $_POST['cus_username']); // This could be either cus_username or cus_email
    $cus_pass = mysqli_real_escape_string($conn, $_POST['cus_pass']);
    
    // Adjust SQL query to check both cus_username and cus_email
    $sql = "SELECT * FROM tbl_customer WHERE cus_username = ? OR cus_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $identifier, $identifier);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($cus_pass, $row['cus_pass'])) {
            // Start session and set session variables
            session_start();
            $_SESSION['cus_username'] = $row['cus_username'];
            $_SESSION['user_id'] = $row['id']; // Optional: store user ID in session
            
            // Redirect to a dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid cus_username or cus_pass.";
        }
    } else {
        echo "Invalid cus_username or cus_pass.";
    }
}
?>
