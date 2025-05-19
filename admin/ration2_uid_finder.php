<?php

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '1' && $_SESSION['role'] !== 1) {
    die("Access Denied!");
}
include('config.php');
include 'layout/header.php';
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ration_number = $_POST['ration_number'];
    $applicant_name = $_POST['applicant_name'];
    $state = $_POST['state'];
    $phone = $_POST['phone'];
    $district = $_POST['district'];

    $sql = "INSERT INTO ration(ration_number, applicant_name, state, district, phone) values('$ration_number', '$applicant_name', '$state', '$district', '$phone')";
    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105242669";
        $apiToken = "dfb24b0b4e784ed4814e3a780e2ea43d01b49830e9a94562b2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $name, your application for the Ration to Aadhar has been submitted successfully. Thank you!";

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
            "Ration to Aadhar Application Received:\n\n" .
            "Applicant Name: $applicant_name\n" .
            "Phone: $phone\n" .
            "Ration Card Number: $ration_number\n" .
            "District: $district\n" .
            "State: $state\n";

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
        </script>
    ";
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
                                        <form name="" action="" method="post" id="rasan_print">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="ration_number">Ration Number <span class="required-mark text-red" style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" name="ration_number" id="ration_number" placeholder="Enter Ration Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="ration_number">Applicant Name <span class="required-mark text-red" style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" name="applicant_name" id="ration_number" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="phone">Phone Number<span class="required-mark text-red" style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" name="phone" id="phone">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="state">State:</label>
                                                    <select name="state" id="state" class="form-control" required>
                                                        <option value="">Select a district...</option>
                                                        <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                                                        <option value="JHARKHAND">JHARKHAND</option>
                                                    </select>
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label for="district">DISTRICT:</label>
                                                    <select name="district" id="district" class="form-control" required>
                                                        <option value="">First Select State..</option>

                                                    </select><br>
                                                </div>
                                                <?php
                                                $fee_sql = "SELECT * from services where service_name = 'ration_to_aadhar'";
                                                $fee_data = mysqli_query($conn, $fee_sql);
                                                if (mysqli_num_rows($fee_data) > 0) {
                                                    $row = mysqli_fetch_assoc($fee_data);
                                                }
                                                ?>
                                                <div class="col-12 ml-2">
                                                    <h5 class="text-warning">Application Fee:
                                                        ₹<?= $row['service_charge'] ?> </h5>
                                                </div>
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

            <?php
            include('layout/footer.php');
            ?>