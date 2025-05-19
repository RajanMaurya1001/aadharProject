<?php
session_start();
ob_clean();
header('Content-Type: application/json');
include('config.php');
$chargeis = 0;
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='aadhar'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_array($DataBirth);
    $chargeis = $resData['service_charge'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $remark = $_POST['remark'];
    $user_id = $_POST['user_id'];

    // Sanitize input
    $id = mysqli_real_escape_string($conn, $id);
    $status = mysqli_real_escape_string($conn, $status);

    // $sql = "UPDATE aadhar SET status = '$status' WHERE id = $id";

    if ($status != "Rejected") {
        $sql = "UPDATE aadhar SET status = '$status' WHERE id = $id";
    } else {
        $sql = "UPDATE aadhar SET status = '$status' WHERE id = $id";
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
        $purpose = 'Refund: Aadhar Apply';
        $type = 'credit';
        $status = 1;

        $insertLog = "INSERT INTO wallet_transaction_history 
        (user_id, amount, available_balance, purpose, type, status)
        VALUES ($user_id, $chargeis, $current_balance, '$purpose', '$type', $status)";
        mysqli_query($conn, $insertLog);
    }

    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105245150";
        $apiToken = "5930752ee220440da365847180fbf93eba31bf1fe50947f4a2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $name, your application for the Aadhar Manual has been $status.\n\n" .
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
            "Aadhar Manual Application $status is:\n\n" .
            "name: $name\n\n" .
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
