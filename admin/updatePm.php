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
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='pm_kissan_seeding'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_array($DataBirth);
    $chargeis = $resData['service_charge'];
}
?>



<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $state = $_POST['state'];
    $district = $_POST['district'];
    $reg_no = $_POST['reg_no'];
    $aadhar_no = $_POST['aadhar_no'];
    $name = $_POST['name'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $id = $_POST['id'];


    // Get phone number
    $getUser = mysqli_query($conn, "SELECT user_id FROM pm_kissan WHERE id = $id");
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

    // $sql = "Insert into pm_kissan(state, district, reg_no, aadhar_no, name, status, application_no) values('$state', '$district', '$reg_no', '$aadhar_no', '$name', '$status', '$application_no')";

    $sql = "Update pm_kissan set
         state = '$state',
         district = '$district',
         reg_no = '$reg_no',
         aadhar_no = '$aadhar_no',
         name = '$name',
         status = '$status',
         certificate_file = '$filename',
         remark = '$remark'
         where  id = $id";

    if (mysqli_query($conn, $sql)) {
        if ($status != "Rejected") {
            // Escape variables for safety
            $status = mysqli_real_escape_string($conn, $status);
            $id = intval($id); // Ensure ID is integer

            $sql = "UPDATE pm_kissan SET status = '$status' WHERE id = $id";
            $updateResult = mysqli_query($conn, $sql);
        } else {
            // Escape variables
            $status = mysqli_real_escape_string($conn, $status);
            $id = intval($id);
            $chargeis = floatval($chargeis); // Ensure numeric value
            $user_id = intval($user_id);

            // Update ration status
            $sql = "UPDATE pm_kissan SET status = '$status' WHERE id = $id";
            $updateResult = mysqli_query($conn, $sql);

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
                $type = 'debit';
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
                echo json_encode(['success' => false, 'error' => 'Wallet balance not found for this user!']);
                exit;
            }
        }

        if ($phone) {
            $idInstance = "7105245778";
            $apiToken = "ff89b835f24d423aa7e7d5602804bcdcc098a9c6d1604bebb5";
            $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

            $applicantNumber = "91{$phone}@c.us";
            $messageToUser = "Hello, {$name} your application for the PM Kishan has been {$status}.\n\n" .
                "Remark: {$remark}\n\nThank you!";

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

            $adminNumber = "917266956455@c.us";
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
            echo "<script>
            alert('Update Successfuly');
            window.location.href = 'pm_kishan_list.php';
           </script>";
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
        exit;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_sql = "SELECT * FROM pm_kissan WHERE id = $id";
    $data = mysqli_query($conn, $new_sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
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
                                        <form name="" action="" method="post" id="Job_print" enctype="multipart/form-data">

                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">

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

                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <label class="card-title" for="state">State</label>
                                                        <select name="state" id="state" class="form-control">
                                                            <option value="">Select State</option>
                                                            <option value="UTTAR PRADESH" <?= $row['state'] == 'Uttar Pradesh' ? 'selected' : '' ?>>Uttar Pradesh</option>
                                                            <option value="JHARKHAND" <?= $row['state'] == 'JHARKHAND' ? 'selected' : '' ?>>JHARKHAND</option>
                                                            <option value="BIHAR" <?= $row['state'] == 'BIHAR' ? 'selected' : '' ?>>BIHAR</option>
                                                        </select><br>

                                                        <label for="district">DISTRICT:</label>
                                                        <select name="district" id="district" class="form-control">
                                                            <option value="">First Select State...</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="registration">Registration Number</label>
                                                        <input type="text"="" class="form-control" name="reg_no" id="registration" placeholder="Enter Registration Number" value="<?= $row['reg_no'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="aadhar">Aadhar Number</label>
                                                        <input type="text"="" class="form-control" name="aadhar_no" id="aadhar" placeholder="Enter Aadhar Number" value="<?= $row['aadhar_no'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="name">Name</label>
                                                        <input type="text"="" class="form-control" name="name" id="name" placeholder="Customer Name" value="<?= $row['name'] ?>">
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
        <script>
            function removeSpaces(inputElement) {
                inputElement.value = inputElement.value.replace(/\s/g, '');
            }
        </script>

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
    <!-- Bootstrap JS -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="../assets/plugins/chartjs/chart.min.js"></script>
    <script src="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="../assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
    <script src="../assets/plugins/jquery-knob/excanvas.js"></script>
    <script src="../assets/plugins/jquery-knob/jquery.knob.js"></script>
    <script>
        $(function() {
            $(".knob").knob();
        });
    </script>
    <script src="../assets/js/index.js"></script>
    <!--app JS-->
    <script src="../assets/js/app.js"></script>
    <!-- datatable -->
    <script src="../template/ahkweb/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../template/ahkweb/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>

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