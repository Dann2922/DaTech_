<?php
include_once("../connect.php");
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_identifier = mysqli_real_escape_string($conn, $_POST['login_identifier']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tbl_customer WHERE (cus_username = '$login_identifier' OR cus_phone = '$login_identifier' OR cus_email = '$login_identifier') AND cus_pass = '$password'";
    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_assoc($result);

    if ($customer) {
        $_SESSION['cus_id'] = $customer['cus_id'];
        $_SESSION['cus_username'] = $customer['cus_username'];
        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid username, phone number, email, or password";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/formLogin.css">
</head>
    <?php 
        include("header.php"); 
    ?>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($message) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <form method="post" action="login.php">
            <input type="text" name="login_identifier" placeholder="Username, Phone, or Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class="button-container">
            <button onclick="window.location.href='forgot_password.php'">Forgot Password</button>
            <button onclick="window.location.href='create_account.php'">Create New Account</button>
        </div>
    </div>
