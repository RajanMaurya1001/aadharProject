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
// include 'layout/header.php';
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $state = $_POST['state'];
    $district = $_POST['district'];
    $application_no = trim($_POST['application_no']);
    $dob = trim($_POST['dob']);
    $password = trim($_POST['password']);
    $id = $_POST['id'];

    $sql = "update  licence set 
           state = '$state',
           district = '$district',
           application_no = '$application_no',
           dob = '$dob',
           password = '$password'
           where  id = '$id'";



    if (mysqli_query($conn, $sql)) {
        echo "<script>
    alert('Data Update Successfully');
    window.location.href= 'll_list.php';
    </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_sql = "SELECT * FROM licence WHERE id = $id";
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
                                            <a href="#" class="alert-link">Learning Licence Pass</a><br>

                                            Tutorial Video Complete First Before Submiting Data <br>

                                            (Note :- RTO BAHRAICH,RTO SHAMBHAL,RTO RAMPUR )
                                            Ka Exam 10 PM me lagaye <br>



                                        </div>
                                        <form method="POST" action="">


                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <label class="card-title" for="state">Select State</label>
                                                        <select class="form-control" name="state" required id="state">
                                                            <option value="">-- Select State --</option>
                                                            <option value="ANDHRA PRADESH" <?= $row['state'] == 'ANDHRA PRADESH' ? 'selected' : '' ?>>ANDHRA PRADESH (आंध्र प्रदेश)</option>
                                                            <option value="ARUNACHAL PRADESH" <?= $row['state'] == 'ARUNACHAL PRADESH' ? 'selected' : '' ?>>ARUNACHAL PRADESH (अरुणाचल प्रदेश)</option>
                                                            <option value="ASSAM" <?= $row['state'] == 'ASSAM' ? 'selected' : '' ?>>ASSAM (असम)</option>
                                                            <option value="BIHAR" <?= $row['state'] == 'BIHAR' ? 'selected' : '' ?>>BIHAR</option>
                                                            <option value="CHHATTISGARH" <?= $row['state'] == 'CHHATTISGARH' ? 'selected' : '' ?>>CHHATTISGARH (छत्तीसगढ़)</option>
                                                            <option value="GOA" <?= $row['state'] == 'GOA' ? 'selected' : '' ?>>GOA (गोवा)</option>
                                                            <option value="GUJARAT" <?= $row['state'] == 'GUJARAT' ? 'selected' : '' ?>>GUJARAT (गुजरात)</option>
                                                            <option value="HARYANA" <?= $row['state'] == 'HARYANA' ? 'selected' : '' ?>>HARYANA (हरियाणा)</option>
                                                            <option value="HIMACHAL PRADESH" <?= $row['state'] == 'HIMACHAL PRADESH' ? 'selected' : '' ?>>HIMACHAL PRADESH (हिमाचल प्रदेश)</option>
                                                            <option value="JHARKHAND" <?= $row['state'] == 'JHARKHAND' ? 'selected' : '' ?>>JHARKHAND (झारखंड)</option>
                                                            <option value="KARNATAKA" <?= $row['state'] == 'KARNATAKA' ? 'selected' : '' ?>>KARNATAKA (कर्नाटक)</option>
                                                            <option value="KERALA" <?= $row['state'] == 'KERALA' ? 'selected' : '' ?>>KERALA (केरल)</option>
                                                            <option value="MADHYA PRADESH" <?= $row['state'] == 'MADHYA PRADESH' ? 'selected' : '' ?>>MADHYA PRADESH (मध्य प्रदेश)</option>
                                                            <option value="MAHARASHTRA" <?= $row['state'] == 'MAHARASHTRA' ? 'selected' : '' ?>>MAHARASHTRA (महाराष्ट्र)</option>
                                                            <option value="MANIPUR" <?= $row['state'] == 'MANIPUR' ? 'selected' : '' ?>>MANIPUR (मणिपुर)</option>
                                                            <option value="MEGHALAYA" <?= $row['state'] == 'MEGHALAYA' ? 'selected' : '' ?>>MEGHALAYA (मेघालय)</option>
                                                            <option value="MIZORAM" <?= $row['state'] == 'MIZORAM' ? 'selected' : '' ?>>MIZORAM (मिज़ोरम)</option>
                                                            <option value="NAGALAND" <?= $row['state'] == 'NAGALAND' ? 'selected' : '' ?>>NAGALAND (नागालैंड)</option>
                                                            <option value="ODISHA" <?= $row['state'] == 'ODISHA' ? 'selected' : '' ?>>ODISHA (ओडिशा)</option>
                                                            <option value="PUNJAB" <?= $row['state'] == 'PUNJAB' ? 'selected' : '' ?>>PUNJAB (पंजाब)</option>
                                                            <option value="RAJASTHAN" <?= $row['state'] == 'RAJASTHAN' ? 'selected' : '' ?>>RAJASTHAN (राजस्थान)</option>
                                                            <option value="SIKKIM" <?= $row['state'] == 'SIKKIM' ? 'selected' : '' ?>>SIKKIM (सिक्किम)</option>
                                                            <option value="TAMIL NADU" <?= $row['state'] == 'TAMIL NADU' ? 'selected' : '' ?>>TAMIL NADU (तमिलनाडु)</option>
                                                            <option value="TELANGANA" <?= $row['state'] == 'TELANGANA' ? 'selected' : '' ?>>TELANGANA (तेलंगाना)</option>
                                                            <option value="TRIPURA" <?= $row['state'] == 'TRIPURA' ? 'selected' : '' ?>>TRIPURA (त्रिपुरा)</option>
                                                            <option value="UTTAR PRADESH" <?= $row['state'] == 'UTTAR PRADESH' ? 'selected' : '' ?>>UTTAR PRADESH (उत्तर प्रदेश)</option>
                                                            <option value="UTTARAKHAND" <?= $row['state'] == 'UTTARAKHAND' ? 'selected' : '' ?>>UTTARAKHAND (उत्तराखंड)</option>
                                                            <option value="WEST BENGAL" <?= $row['state'] == 'WEST BENGAL' ? 'selected' : '' ?>>WEST BENGAL (पश्चिम बंगाल)</option>

                                                            <!-- Union Territories -->
                                                            <option value="ANDAMAN & NICOBAR ISLANDS" <?= $row['state'] == 'ANDAMAN & NICOBAR ISLANDS' ? 'selected' : '' ?>>ANDAMAN & NICOBAR ISLANDS (अंडमान और निकोबार द्वीपसमूह)</option>
                                                            <option value="CHANDIGARH" <?= $row['state'] == 'CHANDIGARH' ? 'selected' : '' ?>>CHANDIGARH (चंडीगढ़)</option>
                                                            <option value="DADRA & NAGAR HAVELI AND DAMAN & DIU" <?= $row['state'] == 'DADRA & NAGAR HAVELI AND DAMAN & DIU' ? 'selected' : '' ?>>DADRA & NAGAR HAVELI AND DAMAN & DIU (दादरा और नगर हवेली और दमन और दीव)</option>
                                                            <option value="DELHI" <?= $row['state'] == 'DELHI' ? 'selected' : '' ?>>DELHI (दिल्ली)</option>
                                                            <option value="JAMMU & KASHMIR" <?= $row['state'] == 'JAMMU & KASHMIR' ? 'selected' : '' ?>>JAMMU & KASHMIR (जम्मू और कश्मीर)</option>
                                                            <option value="LADAKH" <?= $row['state'] == 'LADAKH' ? 'selected' : '' ?>>LADAKH (लद्दाख)</option>
                                                            <option value="LAKSHADWEEP" <?= $row['state'] == 'LAKSHADWEEP' ? 'selected' : '' ?>>LAKSHADWEEP (लक्षद्वीप)</option>
                                                        </select>


                                                        <label for="district">DISTRICT:</label>
                                                        <select name="district" id="district" class="form-control">
                                                            <option value="" <?= $row['district'] == 'district' ? 'selected' : '' ?>>Select a district...</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="rc_dl">Enter Application Number</label>
                                                        <input type="text" class="form-control" name="application_no" placeholder="Application Number" value="<?= $row['application_no'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="rc_dl">Enter DOB</label>
                                                        <input type="date" class="form-control" name="dob" value="<?= $row['dob'] ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" card-body">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="card-title" for="rc_dl">Enter Password</label>
                                                                <input type="text" class="form-control" name="password" placeholder="Password" value="<?= $row['password'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <?php
                                                    $fee_sql = "SELECT * from services where service_name = 'Learning licence'";
                                                    $fee_data = mysqli_query($conn, $fee_sql);
                                                    if (mysqli_num_rows($fee_data) > 0) {
                                                        $row = mysqli_fetch_assoc($fee_data);
                                                    }
                                                    ?>
                                                    <div class=" col-12 ml-2">
                                                        <h5 class="text-warning ">Application Fee: ₹<?= $row['service_charge'] ?></h5>
                                                        <input type="hidden" name="fee" value="100">
                                                    </div>


                                                    <!-- <div class="col-12 ml-2">
                                                <h5 class="text-warning ">Uttar Pradesh Application Fee: 150</h5>
                                                <input type="hidden" name="fee" value="150">
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



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>




    </body>



    </html>