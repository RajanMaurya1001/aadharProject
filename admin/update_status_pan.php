<?php
session_start();
ob_clean();
header('Content-Type: application/json');
include('config.php');

$chargeis = 0;
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='Pan'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_array($DataBirth);
    $chargeis = $resData['service_charge'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $name = $_POST['name'];
    $remark = $_POST['remark'];
    $phone = $_POST['phone'];
    $user_id = $_POST['user_id'];

    // Sanitize input
    $name = mysqli_real_escape_string($conn, $name);
    $remark = mysqli_real_escape_string($conn, $remark);
    $phone = mysqli_real_escape_string($conn, $phone);
    $user_id = mysqli_real_escape_string($conn, $user_id);


    if ($status != "Rejected") {
        // Escape variables for safety
        $status = mysqli_real_escape_string($conn, $status);
        $id = intval($id); // Ensure ID is integer

        $sql = "UPDATE pan SET status = '$status' WHERE id = $id";
        mysqli_query($conn, $sql);

        echo "<script>console.log(" . json_encode($sql) . ");</script>";
    } else {
        // Escape variables
        $status = mysqli_real_escape_string($conn, $status);
        $id = intval($id);
        $chargeis = floatval($chargeis); // Ensure numeric value
        $user_id = intval($user_id);

        // Update ration status
        $sql = "UPDATE pan SET status = '$status' WHERE id = $id";
        mysqli_query($conn, $sql);

        // Update main wallet
        $updtMainWallet = "UPDATE total_wallet_balence SET wallet_balence = wallet_balence + $chargeis WHERE user_id = $user_id";
        mysqli_query($conn, $updtMainWallet);

        // Deduct from admin wallet
        $deductAdminWallet = "UPDATE admin_wallet SET amount = amount - $chargeis";
        mysqli_query($conn, $deductAdminWallet);

        // Get current balance
        $getBal = mysqli_query($conn, "SELECT wallet_balence FROM total_wallet_balence WHERE user_id = $user_id");
        $balRow = mysqli_fetch_assoc($getBal);

        if ($balRow && isset($balRow['wallet_balence'])) {
            $current_balance = $balRow['wallet_balence'];

            // Insert wallet transaction log
            $purpose = 'Refund: Pan Details Apply';
            $type = 'credit';
            $log_status = 1; // Changed variable name to avoid conflict with $status

            // Escape strings
            $purpose = mysqli_real_escape_string($conn, $purpose);
            $type = mysqli_real_escape_string($conn, $type);

            $insertLog = "INSERT INTO wallet_transaction_history 
            (user_id, amount, available_balance, purpose, type, status)
            VALUES ($user_id, $chargeis, $current_balance, '$purpose', '$type', $log_status)";

            mysqli_query($conn, $insertLog);
        } else {
            // Handle case where user wallet record doesn't exist
            echo "<script>alert('Wallet balance not found for this user!');</script>";
        }
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
        $messageToUser = "Hello $name, your application for the Pan Manual has been $status.\n\n" .
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
            "Pan Manual Application $status is:\n\n" .
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
