<?php
session_start();
include('config.php');

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : "";
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";

if (isset($_GET['amount'])) {
    $amount = $_GET['amount'];
    $transaction_id = $_GET['transaction_id'];
    $mode = $_GET['mode'];
    $email = $_GET['email'];
    $insert_wallet = "INSERT INTO wallet (transaction_id,amount,payment_mode,user_id,email) VALUES ('$transaction_id',$amount,'$mode',$user_id,'$email')";

    if (mysqli_query($conn, $insert_wallet)) {
        $select_total_wallet = "SELECT * FROM total_wallet_balence WHERE user_id=$user_id";
        $data = mysqli_query($conn, $select_total_wallet);

        if (mysqli_num_rows($data) > 0) {
            if (mysqli_query($conn, "UPDATE total_wallet_balence SET wallet_balence=wallet_balence+'$amount' WHERE user_id=$user_id")) {
                echo "
                    <script>
                        alert('Balence added successfully');
                    </script>
                ";
            }
        } else {
            if (mysqli_query($conn, "INSERT INTO total_wallet_balence (user_id,wallet_balence) VALUES ($user_id,$amount)")) {
                echo "
                    <script>
                        alert('Balence added successfully');
                    </script>
                ";
            }
        }
    }
}
