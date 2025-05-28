<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('assets/config/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .otp-verification-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .otp-verification-container h2 {
            text-align: center;
            color: #075E54;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #25D366;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1ebe5d;
        }
    </style>
</head>

<?php
   if($_SERVER['REQUEST_METHOD']=="POST"){
    $phone=$_POST['phone'];
    $otp = $_POST['otp'];
     $sql = "SELECT * FROM user WHERE phone='$phone' AND otp='$otp'";
     $data = mysqli_query($conn,$sql);
     if(mysqli_num_rows($data)>0){
        echo "
            <script>
                alert('Please set new password');
                window.location.href='new_password.php?phone=$phone&otp=$otp';
            </script>
        ";
     }else{
        echo "<script>
            alert('Please Enter currect otp');
        </script>";
     }
   }
?>

<body>

<div class="otp-verification-container">
    <h2>OTP Verification</h2>
    <form action="" method="post">
        <input type="hidden" name="phone" value="<?= htmlspecialchars($_GET['phone']) ?>">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" placeholder="Enter 6-digit OTP" required>
        <button type="submit">Verify OTP</button>
    </form>
</div>

</body>
</html>
