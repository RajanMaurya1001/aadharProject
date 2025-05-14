<?php

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '0' && $_SESSION['role'] !== 0) {
    die("Access Denied!");
}
include('config.php');
include 'layout/header.php';
?>
<!--start header -->



<?php
$getServices = "Select * from services where service_name = 'Ration to Aadhar'";
$serviceData = mysqli_query($conn, $getServices);
if (mysqli_num_rows($serviceData) > 0) {
    $serviceRow = mysqli_fetch_assoc($serviceData);
}
$chargeis = $serviceRow['service_charge'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ration_number = $_POST['ration_number'];
    $applicant_name = $_POST['applicant_name'];
    $state = $_POST['state'];
    $district = $_POST['district'];

    $sql = "INSERT INTO ration(ration_number, applicant_name, state, district) values('$ration_number', '$applicant_name', '$state', '$district')";
    if (mysqli_query($conn, $sql)) {
        $minusWalletUser = "UPDATE total_wallet_balence SET wallet_balence = wallet_balence - '$chargeis' WHERE user_id = $id";
        if (mysqli_query($conn, $minusWalletUser)) {
            $minusWalletAdmin = "UPDATE admin_wallet SET amount = amount + '$chargeis' WHERE user_id = 1";
            if (mysqli_query($conn, $minusWalletAdmin)) {
                echo "<script>alert('Ration to Aadhar applied'); window.location.href='index.php';</script>";
            } else {
                echo "Error updating admin_wallet: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating user wallet: " . mysqli_error($conn);
        }
    } else {
        echo "Error in main SQL: " . mysqli_error($conn);
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
                                                $fee_sql = "SELECT * from services where service_name = 'Ration to Aadhar'";
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