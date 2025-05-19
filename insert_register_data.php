<?php
session_start();
include('../psprint/assets/config/config.php');


if (isset($_GET['charge'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $state = $_GET['state'];
    $district = $_GET['district'];
    $transaction_id = $_GET['transaction_id'];
    $membership_amount = $_GET['charge'];
    $password = $_GET['password'];

    $sql = "Insert Into user(name, email, phone, state, district, password, membership_amount, transaction_id) values('$name', '$email', '$phone', '$state', '$district', '$password', '$membership_amount', '$transaction_id')";
    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105242669";
        $apiToken = "dfb24b0b4e784ed4814e3a780e2ea43d01b49830e9a94562b2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $application_no, your application for the Learning Licence has been $status.\n\n" .
            "remark : $remark\n\n" .
            "Thank you!";

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
        $adminNumber = "918303293043@c.us";
        $messageToAdmin =
            "Learning Licence Application $status is:\n\n" .
            "application_no: $application_no\n\n" .
            "Reason: $remark\n\n" .
            "Application Status: $status\n";

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
        echo "<script>
        alert('User Login Succesfully! Message Sent..);
        window.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>
        alert('User Registerd Not Succesfully');
        window.location.href = 'registration.php';
        </script>";
    }
}
