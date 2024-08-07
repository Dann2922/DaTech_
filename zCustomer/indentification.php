<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="flip-container">
        <div class="flipper" id="flipper">
            <div class="front">
                <h1 class="title">Login</h1>
                <form action="login.php" method="post">
                    <input type="text" name="cus_username" placeholder="cus_username" required />
                    <input type="cus_pass" name="cus_pass" placeholder="cus_pass" required />
                    <a class="forgot" href="#">Forgot your cus_pass?</a>
                    <button type="submit" name="login">Login</button>
                    <br>
                    <a class="flipbutton" id="loginButton" href="#">Create a new account</a>
                </form>
            </div>

            <div class="back">
                <h1 class="title">Register</h1>
                <form action="register.php" method="post">
                    <input type="text" name="cus_username" placeholder="cus_username" required />
                    <input type="text" name="cus_fullname" placeholder="Full name" required />
                    <input type="date" name="cus_birthday" placeholder="Date of birth" required />
                    <input type="text" name="cus_phone" placeholder="Phone number" required />
                    <input type="email" name="cus_email" placeholder="Email" required />
                    <input type="text" name="cus_address" placeholder="Address" required />
                    <input type="cus_pass" name="cus_pass" placeholder="cus_pass" required />
                    <input type="cus_pass" name="confirm_cus_pass" placeholder="Confirm cus_pass" required />
                    <button type="submit" name="register">Sign up</button>
                    <br>
                    <a class="flipbutton" id="registerButton" href="#">Login to my account</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>
