<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('assets/config/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .otp-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .otp-container h2 {
            margin-bottom: 20px;
            color: #075E54;
            text-align: center;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="tel"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #25D366;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1ebe5d;
        }
    </style>
</head>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $checkUser = mysqli_query($conn, "SELECT * FROM user WHERE phone='$phone'");
    if (mysqli_num_rows($checkUser) == 0) {
        echo "<script>alert('Phone number not found');</script>";
        return;
    }

    $otp = rand(100000, 999999);
    $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

    // $updateOtp = mysqli_query($conn, "UPDATE user SET otp='$otp', otp_expiry='$expiry' WHERE phone='$phone'");

    if (mysqli_query($conn, "UPDATE user SET otp='$otp', otp_expire='$expiry' WHERE phone='$phone'")) {
        // Green API Details
        $idInstance = "7105245778";
        $apiToken = "ff89b835f24d423aa7e7d5602804bcdcc098a9c6d1604bebb5";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "This Mesage For Password Update " .

            "✅ Otp for forget password.\n\n" .
            "Your Otp is: $otp\n";
            
            $dataUser = [
                "chatId" => $applicantNumber,
                "message" => $messageToUser
            ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataUser));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response1 = curl_exec($ch);
        curl_close($ch);
            
        echo "<script>
        alert('OTP Send Succesfully! Message Sent..');
        window.location.href = 'verify_otp.php?phone=$phone&otp=$otp';
        </script>";
    } else {
        echo "<script>alert('Failed to generate OTP.');</script>";
    }
}
}
?>
<div class="otp-container">
    <h2>Verify via WhatsApp</h2>
    <form action="" method="post">
        <label for="phone">Enter your WhatsApp Number:</label>
        <input type="tel" name="phone" id="phone" placeholder="+91XXXXXXXXXX" required>
        <button type="submit">Send OTP</button>
    </form>
</div>



</body>
</html>
