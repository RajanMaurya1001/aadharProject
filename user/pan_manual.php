<?php

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '0' && $_SESSION['role'] !== 0) {
    die("Access Denied!");
}
$id = $_SESSION['id'];
include('config.php');
// include 'layout/header.php';

?>

<?php

$getServices = "Select * from services where service_name = 'Pan'";
$serviceData = mysqli_query($conn, $getServices);
if (mysqli_num_rows($serviceData) > 0) {
    $serviceRow = mysqli_fetch_assoc($serviceData);
}
$chargeis = $serviceRow['service_charge'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_type = $_POST['card_type'];
    $pan_no = $_POST['pan_no'];
    $name = $_POST['name'];
    $fName = $_POST['fName'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];


    $filename = time() . $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    move_uploaded_file($tempname, '../assets/panimages/' . $filename);

    $filenamee = time() . $_FILES['sign_image']['name'];
    $tempnamee = $_FILES['sign_image']['tmp_name'];
    move_uploaded_file($tempnamee, '../assets/panimages/' . $filenamee);


    $sql = "INSERT INTO pan(card_type, pan_no, name, fName, dob, phone, gender, image, sign_image, user_id) 
    values('$card_type', '$pan_no', '$name', '$fName', '$dob', '$phone', '$gender', '$filename', '$filenamee', '$id')";
    if (mysqli_query($conn, $sql)) {

        // Step 1: Check Wallet Balance
        $checkWalletQuery = "SELECT wallet_balence FROM total_wallet_balence WHERE user_id = $id";
        $checkWalletResult = mysqli_query($conn, $checkWalletQuery);

        if ($checkWalletResult && mysqli_num_rows($checkWalletResult) > 0) {
            $row = mysqli_fetch_assoc($checkWalletResult);
            $walletBalence = (float)$row['wallet_balence'];

            if ($walletBalence <= 0) {
                echo "<script>
                 alert('Insufficient balance. Please add money first.');
                 window.location.href = 'pan_manual.php';
                </script>";
                exit;
            }
        } else {
            echo "<script>
                 alert('Wallet not found.');
                </script>";
            exit;
        }

        $minusWalletUser = "UPDATE total_wallet_balence SET wallet_balence = wallet_balence - '$chargeis' WHERE user_id = $id";
        if (mysqli_query($conn, $minusWalletUser)) {


            // Wallet History Insert Code
            $name = $_SESSION['name'];
            $purpose = 'PAN Manual';
            $type = 'credit';
            $status = 1;
            // $transaction_id = 'TXN' . rand(10000, 99999);

            $getNewBal = mysqli_query($conn, "SELECT wallet_balence FROM total_wallet_balence WHERE user_id = $id");
            $newBalRow = mysqli_fetch_assoc($getNewBal);
            $new_balance = $newBalRow['wallet_balence'];

            $insertLog = "INSERT INTO wallet_transaction_history 
             (user_id, amount, available_balance, purpose, type, status, name )
             VALUES ($id, $chargeis, $new_balance, '$purpose', '$type', $status, '$name')";
            mysqli_query($conn, $insertLog);


            $minusWalletAdmin = "UPDATE admin_wallet SET amount = amount + '$chargeis'";
            if (mysqli_query($conn, $minusWalletAdmin)) {
                // Green API Details
                $idInstance = "7105245778";
                $apiToken = "ff89b835f24d423aa7e7d5602804bcdcc098a9c6d1604bebb5";
                $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

                // -----------------------------
                // ✅ 1. Message to Applicant
                // -----------------------------
                $applicantNumber = "91" . $phone . "@c.us";
                $messageToUser = "Hello $name, your application for the Pan Manual has been submitted successfully. Thank you!";

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
                    "Pan Manuual Application Received:\n\n" .
                    "Card Type: $card_type\n" .
                    "PAN No: $pan_no\n" .
                    "Name: $name\n" .
                    "Father's Name: $fName\n" .
                    "DOB: $dob\n" .
                    "Gender: $gender\n" .
                    "Phone: $phone\n";


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
            window.location.href = 'pan_manual_list.php';
        </script>
    ";
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



<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Home </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">New APPLY </li>
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
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h6 class="mb-0 text-uppercase">PAN MANUAL PDF </h6>
                <hr />
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-id-card me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Enter Pan Card Details</h5>
                        </div>
                        <hr>

                        <form method="post" autocomplete="off" onSubmit="return validation();" enctype="multipart/form-data" action="" style="width:100%">
                            <div class="row dgnform">
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Select Pan Card Type</label>
                                            <div class="form-group ">
                                                <select name="card_type" autofocus id="admin" class="form-control stylec">
                                                    <option value="NSDL (FULL PAGE)"> NSDL (FULL PAGE) </option>
                                                    <option value="UTI (CARD SIZE)">UTI (CARD SIZE)</option>
                                                    <option value="OLD (OLD FORMAT)"> NORMAL (OLD FORMAT) </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Pan Card No.</label>
                                            <div class="form-group">
                                                <input class="form-control stylec" value="" id="pannumber" placeholder="" autocomplete="off" name="pan_no" type="text" maxlength="10" required onkeyup="this.value = this.value.toUpperCase();" onblur='ValidatePAN(this)'>
                                                <span id="erroraadharno" class="error"></span>
                                            </div>
                                        </div></br>
                                        <div class="col-sm-12">
                                            <label>Name</label>
                                            <div class="form-group">
                                                <input class="form-control stylec" value="" id="name" placeholder="" name="name" type="text" required onkeyup="this.value = this.value.toUpperCase();">



                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Father Name </label>
                                            <div class="form-group">

                                                <input class="form-control stylec" name="fName" id="fName" placeholder="" Value="" type="text" onkeyup="this.value = this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Date Of Birth</label>
                                            <div class="form-group">
                                                <input class="form-control stylec" name="dob" data-field="date" type="text" value="" required placeholder="D.O.B.(dd/MM/yyyy)">

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Phone Number </label>
                                            <div class="form-group">
                                                <input class="form-control stylec" name="phone" id="phone" type="text">
                                            </div>
                                        </div>

                                        <div class=" col-sm-6">
                                            <label>Gender </label>
                                            <div class="form-group ">

                                                <select name="gender" class="form-control stylec" required>
                                                    <option value=""></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label id="stype">Select Image </label>
                                            <div class="form-group">
                                                <input type="file" name="image" class="form-control stylec" id="imgInp" required />
                                                <img src="" id="blah" width="100px" height="100px" style="margin-top: 12px;
    box-shadow: 4px 4px 2px 1px;
    border-radius: 10px;" />
                                                <input type="hidden" name="blahin" id="blahin" value="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label id="simgs">Select Sign Image </label>
                                            <div class="form-group">
                                                <input type="file" name="sign_image" class="form-control stylec" id="signInp" required />
                                                <img src="" id="blahs" width="100px" height="100px" style="margin-top: 12px;
    box-shadow: 4px 4px 2px 1px;
    border-radius: 10px;" />
                                                <input type="hidden" name="blahsin" id="blahsin" value="" class="form-control" />
                                            </div>
                                        </div>
                                        <?php
                                        $fee_sql = "SELECT * from services where service_name = 'Pan'";
                                        $fee_data = mysqli_query($conn, $fee_sql);
                                        if (mysqli_num_rows($fee_data) > 0) {
                                            $row = mysqli_fetch_assoc($fee_data);
                                        }
                                        ?>
                                        <div class="col-12 ml-2">
                                            <h5 class="text-warning ">Application Fee: ₹<?= $row['service_charge'] ?></h5>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <label>&nbsp;</label>
                                                <div class="form-group">
                                                    <button type="submit" name="savedata" class="btn btn-success btn-block" style="box-shadow: 0 0 0 3px rgba(40,167,69,.5);" onclick="window.location.href='pan_manual.php'">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </form>
                    </div>
                    <!-- /# row -->
                    </section>
                    <style>
                        .stylec {
                            box-shadow: 2px 3px #000 !important;
                            border-radius: 50px !important;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function validation() {

            var aadharno = document.getElementById('pannumber').value;
            if (aadharno.length < 10) {
                document.getElementById('erroraadharno').innerHTML = " **Please Enter 10 Digit Pan Card Number !!!";
                document.getElementById('pannumber').style.border = "1px solid red";
                document.getElementById('pannumber').focus();
                return false;
            }





        }
    </script>

    <script type="text/javascript">
        //English to hindi translate code

        //Words and Characters Count
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                    $('#blahin').val(e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#blah").hide();
        $("#imgInp").change(function() {
            readURL(this);
            $("#blah").show();
        });


        function readURLs(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blahs').attr('src', e.target.result);
                    $('#blahsin').val(e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#blahs").hide();
        $("#signInp").change(function() {
            readURLs(this);
            $("#blahs").show();
        });
    </script>



    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <img src="" width="" height="" />
                </div>

            </div>
            <button type="button" class="btn btn-default" data-dismiss="modal" style="    position: absolute;
    top: -20px;
    right: -422px;
    border-radius: 50%;
    background: red;
	border-color:red;
    color: white;">X</button>
        </div>
    </div>

    <div id="myModals" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="     height: 352px;
    width: 727px;
    margin-left: 165px;
">

                <div class="modal-body" style="height: 243px;">
                    <img src="abs.jpg" height="200px" width="100%">
                    <form method="post" action="paytmv/index.php">
                        <div class="">

                            <p style="    font-size: 18px;
    text-align: center;
    margin-top:20px;
    ">You Not Authorized For using This Pan Services Please Buy Services.</p>
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-3 col-sm-3 col-xs-6">






                                </div>
                            </div>

                            <div class="col-md-12 col-sm-4 col-xs-6">

                                <div class="form-group">

                                    <input type="hidden" name="service[]" value="1" />



                                    <span id="erroruserid" class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-4 col-xs-6">

                                <div class="form-group">
                                    <input autocomplete="off" type="hidden" class="form-control" id="Pay_Amt" value="500" name="Pay_Amt" placeholder="Website URL/ Link" readonly>
                                    <input type="hidden" value="9621339850" name="pay_uid" />
                                    <span id="erroruserid" class="error"></span>
                                </div>
                            </div>














                        </div>
                        </table>
                </div>
                <div class="col-md-12 col-sm-4 col-xs-6">
                    <label>&nbsp;</label>
                    <div class="form-group">


                        <div class="col-md-6"><button type="submit" id="submit" name="submit" style="padding:17px;background:orange;border:1px solid orange;" class="btn btn-success btn-block"> &nbsp;&nbsp;&nbsp; Buy Now &nbsp;&nbsp;&nbsp;</button> </div>
                        <div class="col-md-6"><a href="panel.php" style="padding:17px;background:orange;border:1px solid orange;    margin-top: -65px;
    margin-left: 343px;" class="btn btn-success btn-block"> &nbsp;&nbsp;&nbsp; Dashboard &nbsp;&nbsp;&nbsp;</a></div>
                    </div>
                </div>
            </div>
            </form>
        </div>



    </div>


    <style>
        .modal-body {
            flex: inherit !important;
            padding: inherit !important;
        }

        .modal-footer {
            border: none !important;
        }

        .modal-dialog {
            margin: 30px 248px auto !important;
            max-width: auto !important;
            width: 100% !important;
        }
    </style>





    <!--[if lt IE 9]>
			<link rel="stylesheet" type="text/css" href="DateTimePicker-ltie9.css" />
			<script type="text/javascript" src="DateTimePicker-ltie9.js"></script>
		<![endif]-->
    <div id="dtBox"></div>
    <script>
        $("#ptype").on('change', function() {
            if ($(this).val() == 'UTI-MINOR' || $(this).val() == 'NSDL-MINOR') {
                $("#signInp").hide();

                $("#simgs").hide();
            } else {
                $("#signInp").show();
                $("#imgInp").show();
                $("#stype").show();
                $("#simgs").show();
            }
        });
    </script>

    <script type="text/javascript">
        function ValidatePAN() {
            var pan_no = document.getElementById("pannumber");

            if (pan_no.value != "") {
                PanNo = pan_no.value;
                var panPattern = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
                if (PanNo.search(panPattern) == -1) {
                    alert("Invalid Pan No");
                    pan_no.focus();
                    pan_no.value = '';
                    return false;

                }


            }
        }
    </script>





    <!--end page wrapper -->

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
<!-- <script src="../assets/js/jquery.min.js"></script> -->
<script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--app JS-->
<script src="../assets/js/app.js"></script>
</body>

<script>
    $(document).ready(function() {

        $('#eid').inputmask();
        $('#date').inputmask();
        $('#timea').inputmask("hh:mm:ss", {
            placeholder: "00:00:00",
            insertMode: false,
            showMaskOnHover: false,
            // hourFormat: 24
        });
    });
</script>

</html>