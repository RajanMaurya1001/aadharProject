<?php
session_start();
include('config.php');
// header('Content-Type: application/json');
$chargeis = 0;
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='ration_to_aadhar'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_assoc($DataBirth);
    $chargeis = $resData['service_charge'];
}




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $applicant_name = $_POST['applicant_name'];
    $phone = $_POST['phone'];
    $remark = $_POST['remark'];
    $user_id = $_POST['user_id'];


    // Sanitize input
    $id = mysqli_real_escape_string($conn, $id);
    $status = mysqli_real_escape_string($conn, $status);

    // $sql = "UPDATE ration SET status = '$status' WHERE id = $id";


    if ($status != "Rejected") {
        $sql = "UPDATE ration SET status = '$status' WHERE id = $id";
    } else {
        $sql = "UPDATE ration SET status = '$status' WHERE id = $id";
        $updtMainWallet = "UPDATE total_wallet_balence SET wallet_balence=wallet_balence+'$chargeis' WHERE user_id=$user_id";
        mysqli_query($conn, $updtMainWallet);

        $deductAdminWallet = "UPDATE admin_wallet SET amount = amount - '$chargeis' WHERE amount >= '$chargeis'";
        $result = mysqli_query($conn, $deductAdminWallet);
        // if (mysqli_affected_rows($conn) > 0) {
        //     // Successfully deducted
        // } else {
        //     // Wallet balance insufficient – handle refund or show error
        //     echo "Insufficient wallet balance. Cannot deduct ₹$chargeis.";
        // }


        // 3. Log refund in wallet_transaction_logs
        $getBal = mysqli_query($conn, "SELECT wallet_balence FROM total_wallet_balence WHERE user_id = $user_id");
        $balRow = mysqli_fetch_assoc($getBal);
        $current_balance = $balRow['wallet_balence'];

        // $transaction_id = 'TXN' . rand(10000, 99999);
        $purpose = 'Refund: Ration Apply';
        $type = 'credit';
        $sttatus = 1;

        $insertLog = "INSERT INTO wallet_transaction_history 
        (user_id, amount, available_balance, purpose, type, status)
        VALUES ($user_id, $chargeis, $current_balance, '$purpose', '$type', $sttatus)";
        mysqli_query($conn, $insertLog);
    }


    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105245778";
        $apiToken = "ff89b835f24d423aa7e7d5602804bcdcc098a9c6d1604bebb5";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $applicant_name, your application for the Ration has been $status.\n\n" .
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
        $adminNumber = "917266956455@c.us";
        $messageToAdmin =
            "Ration Application is $status, :\n\n" .
            "name: $applicant_name\n\n" .
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

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}
