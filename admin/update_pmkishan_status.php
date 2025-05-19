<?php
session_start();
include('config.php');
header('Content-Type: application/json'); // ✅ IMPORTANT

$chargeis = 0;
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='pm_kissan_seeding'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_array($DataBirth);
    $chargeis = $resData['service_charge'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;
    $name = $_POST['name'] ?? null;
    $remark = $_POST['remark'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    if (!$id || !$status) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }

    $id = mysqli_real_escape_string($conn, $id);
    $status = mysqli_real_escape_string($conn, $status);

    // $sql = "UPDATE pm_kissan SET status = '$status' WHERE id = $id";
    if ($status != "Rejected") {
        // Escape variables for safety
        $status = mysqli_real_escape_string($conn, $status);
        $id = intval($id); // Ensure ID is integer

        $sql = "UPDATE pm_kissan SET status = '$status' WHERE id = $id";
        mysqli_query($conn, $sql);

        echo "<script>console.log(" . json_encode($sql) . ");</script>";
    } else {
        // Escape variables
        $status = mysqli_real_escape_string($conn, $status);
        $id = intval($id);
        $chargeis = floatval($chargeis); // Ensure numeric value
        $user_id = intval($user_id);

        // Update ration status
        $sql = "UPDATE pm_kissan SET status = '$status' WHERE id = $id";
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
            $purpose = 'Refund: Pm Kissan Apply';
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
        $idInstance = "7105245150";
        $apiToken = "5930752ee220440da365847180fbf93eba31bf1fe50947f4a2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello, $name your application for the PM Kishan has been $status.\n\n" .
            "Remark: $remark\n\nThank you!";

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

        $adminNumber = "918303293043@c.us";
        $messageToAdmin = "PM Kishan Application $status:\n\nName: $name\nReason: $remark\nStatus: $status";

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
    exit;
}
