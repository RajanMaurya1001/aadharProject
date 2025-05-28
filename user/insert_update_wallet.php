<?php
session_start();
include('config.php');

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : "";
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
$name = isset($_SESSION['name']) ? $_SESSION['name'] : "";

$getWalletBalance = mysqli_query($conn, "Select wallet_balence from total_wallet_balence where user_id = $user_id");
if (mysqli_num_rows($getWalletBalance) > 0) {
    $row = mysqli_fetch_assoc($getWalletBalance);
}
$total_balance = $row['wallet_balence'];
// echo $total_balance;
// die();
$loginURL = "http://localhost/psprint/login.php";

if (isset($_GET['amount'])) {
    $amount = $_GET['amount'];
    $transaction_id = $_GET['transaction_id'];
    $mode = $_GET['mode'];
    $email = $_GET['email'];
    $name = $_GET['name'];
    $phone = $_GET['phone'];

    $updated_amount = $total_balance + $amount;
    // echo $updated_amount;
    // die();


    $insert_wallet = "INSERT INTO wallet (transaction_id,amount,payment_mode,user_id,email,name) VALUES ('$transaction_id',$amount,'$mode',$user_id,'$email','$name')";

    if (mysqli_query($conn, $insert_wallet)) {
        // Green API Details
        $idInstance = "7105245778";
        $apiToken = "ff89b835f24d423aa7e7d5602804bcdcc098a9c6d1604bebb5";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Dear $name, Your Wallet Balance Updated succcessfuly Transaction Amount is $amount\n" .
            "Your new Wallet Balance is $updated_amount. \n " .
            "Your Login URL is : $loginURL";

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


        // -----------------------------
        // ✅ 2. Message to Admin
        // -----------------------------
        $adminNumber = "917266956455@c.us";
        $messageToAdmin =
            "User Rechrge Succesfully:\n\n\n" .
            "NAME: $name\n\n" .
            "Price: $amount\n\n" .
            "Total Balance: $updated_amount";

        $dataAdmin = [
            "chatId" => $adminNumber,
            "message" => $messageToAdmin
        ];

        $ch2 = curl_init($url);
        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($dataAdmin));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response2 = curl_exec($ch2);
        curl_close($ch2);


        echo "
<script>
alert('Applied Successfully. WhatsApp Message Sent to Applicant and Admin.');
window.location.href = 'recharge_history.php';
</script>
";





        $select_total_wallet = "SELECT * FROM total_wallet_balence WHERE user_id=$user_id";
        $data = mysqli_query($conn, $select_total_wallet);

        if (mysqli_num_rows($data) > 0) {
            if (mysqli_query($conn, "UPDATE total_wallet_balence SET wallet_balence=wallet_balence+'$amount', name = '$name' WHERE user_id=$user_id")) {
                echo "
                    <script>
                        alert('Balence added successfully');
                        
                    </script>
                ";
            }
        } else {
            if (mysqli_query($conn, "INSERT INTO total_wallet_balence (user_id,wallet_balence, name) VALUES ($user_id,$amount, '$name')")) {
                echo "
                <script>
                    alert('Balence added successfully');
                    
                </script>
            ";
            }
        }
    }
}
