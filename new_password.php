<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Password</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        input[type="password"],
        input[type="hidden"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #25D366;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1ebe5d;
        }

        @media (max-width: 500px) {
            .container {
                padding: 20px;
                border-radius: 8px;
            }

            h2 {
                font-size: 22px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<?php
include "assets/config/config.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
    $phone = $_POST['phone'];
    $otp=$_POST['otp'];
    $password = $_POST['new_password'];
    $sql="UPDATE user SET password='$password',otp='',otp_expire='' WHERE phone='$phone'";
    if(mysqli_query($conn,$sql)){
        echo "
            <script>
                alert('Password updated successfully');
                window.location.href='login.php';
            </script>
        ";
    }else{
          echo "
            <script>
                alert('Unable to update password');
               
            </script>
        ";
    }
}
?>

<div class="container">
    <h2>Create New Password</h2>
    <form action="" method="post">
        <!-- Hidden Fields for phone and OTP -->
        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($_GET['phone'] ?? ''); ?>">
        <input type="hidden" name="otp" value="<?php echo htmlspecialchars($_GET['otp'] ?? ''); ?>">

        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>

        <button type="submit">Set New Password</button>
    </form>
</div>

</body>
</html>
