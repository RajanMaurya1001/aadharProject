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
    $state = $_POST['state'];
    $district = $_POST['district'];
    $reg_no = $_POST['reg_no'];
    $aadhar_no = $_POST['aadhar_no'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $status = 'pending';


    $currentYear = date('Y');
    $prefix = 'PM_APP' . $currentYear;
    $getLast = mysqli_query($conn, "SELECT application_no FROM pm_kissan WHERE application_no LIKE '$prefix%' ORDER BY id DESC LIMIT 1");
    $lastNumber = 0;
    if ($row = mysqli_fetch_assoc($getLast)) {
        $lastCertificate = $row['application_no'];
        // Extract the numeric part after the current year's prefix
        $sequencePart = substr($lastCertificate, strlen($prefix));
        $lastNumber = (int)$sequencePart;
    }
    $newNumber = $lastNumber + 1;
    $application_no = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    $sql = "Insert into pm_kissan(state, district, reg_no, aadhar_no, name, phone, status, application_no) values('$state', '$district', '$reg_no', '$aadhar_no', '$name', '$phone', '$status', '$application_no')";
    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105242669";
        $apiToken = "dfb24b0b4e784ed4814e3a780e2ea43d01b49830e9a94562b2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $name, your application for the Pm Kishan has been submitted successfully. Thank you!";

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
            "Pm Kishan Application Received:\n\n" .
            "Registration No: $reg_no\n" .
            "Name: $name\n" .
            "phone: $phone\n" .
            "State: $state\n" .
            "District: $district\n" .
            "Aadhaar No: $aadhar_no\n" .
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


        echo "
        <script>
            alert('Applied Successfully. WhatsApp Message Sent to Applicant and Admin.');
        </script>
    ";
    }
}
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Home</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">New APPLY</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-wrap">
            <div class="main">
                <div class="col-md-12">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="alert alert-dark" role="alert">
                                            <a href="#" class="alert-link">PM Kishan Land Seeding</a><br>
                                            <br>
                                            1 Weak me kam ho jayga <br>

                                        </div>
                                        <form name="" action="" method="post" id="Job_print">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="state">State</label>
                                                        <select name="state" id="state" required="" class="form-control">
                                                            <option value="">Select State</option>
                                                            <option value="UTTAR PRADESH">Uttar Pradesh</option>
                                                            <option value="JHARKHAND">JHARKHAND</option>
                                                            <option value="BIHAR">BIHAR</option>
                                                        </select><br>

                                                        <label for="district">DISTRICT:</label>
                                                        <select name="district" id="district" class="form-control" required>
                                                            <option value="">First Select State...</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="registration">Registration Number</label>
                                                        <input type="text" required="" class="form-control" name="reg_no" id="registration" placeholder="Enter Registration Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="aadhar">Aadhar Number</label>
                                                        <input type="text" required="" class="form-control" name="aadhar_no" id="aadhar" placeholder="Enter Aadhar Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="name">Name</label>
                                                        <input type="text" required="" class="form-control" name="name" id="name" placeholder="Customer Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="Phone">Phone Number</label>
                                                        <input type="text" required="" class="form-control" name="Phone" id="Phone">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $fee_sql = "SELECT * from services where service_name = 'pm_kissan_seeding'";
                                            $fee_data = mysqli_query($conn, $fee_sql);
                                            if (mysqli_num_rows($fee_data) > 0) {
                                                $row = mysqli_fetch_assoc($fee_data);
                                            }
                                            ?>
                                            <div class="col-12 ml-2">
                                                <h5 class="text-warning ">Application Fee: ₹<?= $row['service_charge'] ?> </h5>
                                                <input type="hidden" name="fee" value="500">
                                            </div>


                                            <div class="row row-sm mg-t-20">
                                                <div class="col">
                                                    <button type="submit" name="find" class="btn btn-primary w-100"><i class="fa fa-check-circle"></i> Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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