<?php

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '1' && $_SESSION['role'] !== 1) {
    die("Access Denied!");
}
$id = $_SESSION['id'];
include('config.php');
include 'layout/header.php';
// Fetch charge once
$chargeis = 0;
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='ration_to_aadhar'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_array($DataBirth);
    $chargeis = $resData['service_charge'];
}
?>
<!--start header -->



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ration_number = $_POST['ration_number'];
    $applicant_name = $_POST['applicant_name'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $id = $_POST['id'];


    // Get phone number
    $getUser = mysqli_query($conn, "SELECT user_id FROM ration WHERE id = $id");
    $userData = mysqli_fetch_assoc($getUser);
    if ($userData && isset($userData['user_id'])) {
        $user_id = $userData['user_id'];
    } else {
        die("Invalid ID or user not found.");
    }

    $getPhone = mysqli_query($conn, "SELECT phone FROM user WHERE id = $user_id");
    $phoneData = mysqli_fetch_assoc($getPhone);
    $phone = $phoneData['phone'];




    if (empty($_FILES['certificate_file']['name'])) {
        $filename = $_POST['oldimage'];
    } else {
        $filename = time() . $_FILES['certificate_file']['name'];
        $tempname = $_FILES['certificate_file']['tmp_name'];
        move_uploaded_file($tempname, '../assets/certificates/' . $filename);
    }

    // $sql = "INSERT INTO ration(ration_number, applicant_name, state, district) values('$ration_number', '$applicant_name', '$state', '$district')";

    $sql = "Update ration set

    ration_number = '$ration_number',
    applicant_name = '$applicant_name',
    state = '$state',
    district = '$district',
    status = '$status',
    certificate_file = '$filename',
    remark = '$remark'
    where id = '$id'";


    if (mysqli_query($conn, $sql)) {

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
            $type = 'debit';
            $sttatus = 1;

            $insertLog = "INSERT INTO wallet_transaction_history 
            (user_id, amount, available_balance, purpose, type, status)
            VALUES ($user_id, $chargeis, $current_balance, '$purpose', '$type', $sttatus)";
            mysqli_query($conn, $insertLog);
        }


        if ($phone) {
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
            echo "<script>
            alert('Update Successfuly');
            window.location.href = 'ration2_uid_finder_list.php';
           </script>";
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_sql = "SELECT * FROM ration WHERE id = $id";
    $data = mysqli_query($conn, $new_sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- Start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="main-content">
                                <div class="card card-default">
                                    <div class="card-header bg-warning">
                                        <div class="card-title">
                                            <h3><strong>RATION TO AADHAAR FIND INSTANT Only ( Uttar Pradesh )</strong></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-12">
                                    <hr>
                                    <div class="row dgnform">
                                        <form name="" action="" method="post" id="rasan_print" enctype="multipart/form-data">

                                            <label for="status">Status</label>
                                            <select class="form-select form-select-sm status-dropdown" name="status" data-id="<?= $row['id'] ?>">
                                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Process" <?= $row['status'] == 'Process' ? 'selected' : '' ?>>Process</option>
                                                <option value="Approved" <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                <option value="Rejected" <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                            </select>

                                            <label for="remark">Remark</label>
                                            <input type="text" name="remark" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?= $row['remark'] ?>"><br>
                                            <!-- <label for="certificate">Upload Certificate</label> -->
                                            <input type="hidden" name="oldimage" class="form-control ">
                                            <img src="../assets/certificates/<?= $row['certificate_file'] ?>" alt="" height="50px" width="50px" class="">

                                            <label for="certificate">Upload Certificate</label>
                                            <input type="file" name="certificate_file" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?= $row['certificate_file'] ?>"><br>

                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="form-group">
                                                        <label class="card-title" for="ration_number">Ration Number <span class="-mark text-red" style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" name="ration_number" id="ration_number" placeholder="Enter Ration Number" value="<?= $row['ration_number'] ?>">
                                                    </div>
                                                </div>
                                                <div class=" col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="ration_number">Applicant Name <span class="-mark text-red" style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" name="applicant_name" id="ration_number" placeholder="Enter Name" value="<?= $row['applicant_name'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="state">State:</label>
                                                    <select name="state" id="state" class="form-control">
                                                        <option value="">Select a district...</option>
                                                        <option value="UTTAR PRADESH" <?= $row['state'] == 'UTTAR PRADESH' ? 'selected' : '' ?>>UTTAR PRADESH</option>
                                                        <option value="JHARKHAND" <?= $row['state'] == 'JHARKHAND' ? 'selected' : '' ?>>JHARKHAND</option>
                                                    </select>
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label for="district">DISTRICT:</label>
                                                    <select name="district" id="district" class="form-control">
                                                        <option value="">First Select State..</option>

                                                    </select><br>
                                                </div>
                                                <!-- <?php
                                                        $fee_sql = "SELECT * from services where service_name = 'Ration to Aadhar'";
                                                        $fee_data = mysqli_query($conn, $fee_sql);
                                                        if (mysqli_num_rows($fee_data) > 0) {
                                                            $row = mysqli_fetch_assoc($fee_data);
                                                        }
                                                        ?>
                                                <div class="col-12 ml-2">
                                                    <h5 class="text-warning">Application Fee:
                                                        ₹<?= $row['service_charge'] ?> </h5>
                                                </div> -->
                                                <div class="row row-sm mg-t-20">
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-check-circle"></i> Submit</button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                </div>
            </div>
            <script src="../assets/js/bootstrap.bundle.min.js"></script>
            <!--plugins-->
            <!-- <script src="../assets/js/jquery.min.js"></script> -->
            <script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
            <script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
            <script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
            <!--app JS-->
            <script src="../assets/js/app.js"></script>

            //for select state wise district
            <script>
                // JavaScript AJAX Code
                document.getElementById('state').addEventListener('change', function() {
                    var state = this.value;
                    var districtDropdown = document.getElementById('district');

                    if (state) {
                        // AJAX Request
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "get_districts.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        xhr.onload = function() {
                            if (this.status == 200) {
                                var districts = JSON.parse(this.responseText);
                                districtDropdown.innerHTML = '<option value="">Select district</option>';

                                districts.forEach(function(district) {
                                    var option = document.createElement('option');
                                    option.value = district.value;
                                    option.textContent = district.text;
                                    districtDropdown.appendChild(option);
                                });
                            }
                        }

                        xhr.send("state=" + encodeURIComponent(state));
                    }
                });
            </script>


</body>

</html>



<!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<footer class="page-footer">
    <p class="mb-0">Copyright © 2025. All right reserved. </p>
</footer>
</div>
<!--end wrapper-->
<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>

    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr />
        <h6 class="mb-0">Theme Styles</h6>
        <hr />
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode">
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" checked>
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr />
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr />
        <h6 class="mb-0">Header Colors</h6>
        <hr />
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
            </div>
        </div>
        <hr />
        <h6 class="mb-0">Sidebar Colors</h6>
        <hr />
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end switcher-->