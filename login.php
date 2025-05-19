<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            max-width: 450px;
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

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .forgot-password {
            color: #1877f2;
            text-decoration: none;
            font-size: 14px;
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

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #606770;
        }

        .signup-link a {
            color: #1877f2;
            text-decoration: none;
        }

        .error-message {
            color: #ff0000;
            font-size: 12px;
            margin-top: 5px;
        }

        .divider {
            border-top: 1px solid #dddfe2;
            margin: 20px 0;
        }
    </style>
</head>

<?php
session_start();
include('../psprint/assets/config/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $_SESSION['id'] = $user['id'];

    $sql = "SELECT id, email,phone, role FROM user WHERE email = '$email' AND password = '$password'";
    $data = mysqli_query($conn, $sql);


    if (mysqli_num_rows($data) > 0) {
        $user = mysqli_fetch_assoc($data);

        $_SESSION['email'] = $user['email'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['mobile_number'] = $user['phone'];
        $_SESSION['name'] = $user['name'];
        // $_SESSION['user_id'] = $user['id'];

        if ($user['role'] == 1) {
            header("Location: ../psprint/admin/index.php");
        } else {
            header("Location: ../psprint/user/index.php");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}


?>

<body>
    <div class="container">
        <h1>Welcome Back</h1>

        <form id="loginForm" method="post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-container">
                    <input type="password" name="password" placeholder="Enter password" required>
                    <span class="toggle-password">👁️</span>
                </div>
            </div>

            <div class="options">
                <label class="remember-me">
                    <input type="checkbox"> Remember me
                </label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit">Log In</button>
        </form>

        <div class="divider"></div>

        <div class="signup-link">
            Don't have an account? <a href="registration.html">Sign Up</a>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function(e) {
                const passwordInput = this.previousElementSibling;
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.textContent = type === 'password' ? '👁️' : '👁️';
            });
        });
    </script>
</body>

</html>