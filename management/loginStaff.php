<!-- <link rel="stylesheet" href="./css/login.css">
<div class="flip-container">
    <div class="flipper" id="flipper">
        <div class="front">
            <h1 class="title">Login</h1>
            <form action="">
                <input type="text" placeholder="Email">
                <input type="password" placeholder="Password">
                <a class="forgot" href="#">Forgot your password?</a>
                <button>Login</button>
            </form>
        </div>
    </div>
</div> -->
<?php
include_once("../connect.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_login = $_POST['staff_login'];
    $staff_pass = $_POST['staff_pass'];

    // Escape user inputs for security
    $staff_login = mysqli_real_escape_string($conn, $staff_login);
    $staff_pass = mysqli_real_escape_string($conn, $staff_pass);

    // Create SQL query to check for the staff login credentials
    $sql = "SELECT * FROM tbl_staff WHERE (staff_username = '$staff_login' OR staff_email = '$staff_login') AND staff_pass = '$staff_pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['staff_username'] = $row['staff_username'];
        // Redirect to a welcome page or dashboard
        header("Location: indexStaff.php");
    } else {
        $error_message = "Invalid email/username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="flip-container">
        <div class="flipper" id="flipper">
            <div class="front">
                <h1 class="title">Login</h1>
                <?php if (isset($error_message)) { ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php } ?>
                <form method="post" action="loginStaff.php">
                    <input type="text" name="staff_login" placeholder="Email or Username" required>
                    <input type="password" name="staff_pass" placeholder="Password" required>
                    <a class="forgot" href="#">Forgot your password?</a>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
