<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: #1877f2;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #606770;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dddfe2;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 0 2px #e7f3ff;
        }

        .password-strength {
            font-size: 12px;
            color: #606770;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #166fe5;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #606770;
        }

        .login-link a {
            color: #1877f2;
            text-decoration: none;
        }

        .terms {
            font-size: 12px;
            color: #606770;
            text-align: center;
            margin: 15px 0;
        }

        .terms a {
            color: #1877f2;
            text-decoration: none;
        }

        .error-message {
            color: #ff0000;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Password visibility toggle */
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #606770;
        }
    </style>
</head>


<?php
include('../psprint/assets/config/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];


    $sql = "Insert Into user(name, email, phone, password) values('$name', '$email', '$phone', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('User Registerd Succesfully');
        window.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>
        alert('User Registerd Not Succesfully');
        window.location.href = 'registration.php';
        </script>";
    }
}

?>

<body>
    <div class="container">
        <h1>Register Hear</h1>

        <form id="registrationForm" method="post" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" placeholder="Enter your phone number" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-container">
                    <input type="password" name="password" placeholder="Create password" required>
                    <!-- <span class="toggle-password">👁️</span> -->
                </div>
            </div>

            <!-- <div class="terms">
                By clicking Sign Up, you agree to our <a href="#">Terms</a>,
                <a href="#">Privacy Policy</a> and <a href="#">Cookie Policy</a>.
            </div> -->

            <button type="submit">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Log In</a>
        </div>
    </div>
</body>

</html>