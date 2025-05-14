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


<?php
$getServices = "Select * from services where service_name = 'aadhar'";
$serviceData = mysqli_query($conn, $getServices);
if (mysqli_num_rows($serviceData) > 0) {
    $serviceRow = mysqli_fetch_assoc($serviceData);
}
$chargeis = $serviceRow['service_charge'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aadhar_no = $_POST['aadhar_no'];
    $name = $_POST['name'];
    $fName = $_POST['fname'];
    $house_no = $_POST['house_no'];
    $locality  = $_POST['locality'];
    $post_office = $_POST['post_office'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pin_code = $_POST['pin_code'];
    $dob = $_POST['dob'];
    $birth_address = $_POST['birth_address'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $language = $_POST['language'];
    $name_local_language  = $_POST['name_local_language'];
    $address_local_language = $_POST['address_local_language'];

    $filename = time() . $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    move_uploaded_file($tempname, '../assets/upload/' . $filename);

    $sql = "INSERT INTO aadhar(aadhar_no, name, fname, house_no, locality, post_office, state, city, pin_code, dob, birth_address,gender, address, image, language, name_local_language, address_local_language, user_id)
    values('$aadhar_no', '$name', '$fName', '$house_no', '$locality', '$post_office', '$state', '$city', '$pin_code', 
    '$dob', '$birth_address', '$gender', '$address', '$filename', '$language', '$name_local_language', '$address_local_language', '$id')";

    if (mysqli_query($conn, $sql)) {
        $minusWalletUser = "UPDATE total_wallet_balence SET wallet_balence = wallet_balence - '$chargeis' WHERE user_id = $id";
        if (mysqli_query($conn, $minusWalletUser)) {
            $minusWalletAdmin = "UPDATE admin_wallet SET amount = amount + '$chargeis' WHERE user_id = 1";
            if (mysqli_query($conn, $minusWalletAdmin)) {
                echo "<script>alert('Aadhar applied'); window.location.href='index.php';</script>";
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
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h6 class="mb-0 text-uppercase">Aadhar Manaual Print</h6>
                <hr />
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-id-card me-1 font-22 text-primary"></i>
                            </div>
                            <strong><i class="fa fa-warning"></i> suchna!</strong>
                            <marquee>
                                <p style="font-family: Impact; font-size: 18pt">कृपया ध्यान दें -: ✔ ADHAR MANUAL PRINT सिर्फ आपको EMERGENCY काम में ही यूज करे । कोई गलत काम में यूज न करें</p>
                            </marquee>

                            <h5 class="mb-0 text-primary">♻ अब आप मनुअल ADHAR कार्ड बना सकते है INSTANT सिर्फ ₹ 10 ।
                            </h5>
                        </div>
                        <hr>

                        <form method="post" autocomplete="off" onSubmit="return validation();" enctype="multipart/form-data" action="" style="width:100%">
                            <div class="row dgnform">
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Aadhar Card No.</label>
                                            <div class="form-group">
                                                <input class="form-control" id="aadhar_no" placeholder="Aadharcard No..." autocomplete="off" name="aadhar_no" type="number" maxlength="12" required value="">
                                                <span id="erroraadharno" class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Name</label>
                                            <div class="form-group">
                                                <input class="form-control " value="" id="name" placeholder="Example : Raju Kumar" name="name" type="text" required value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Father Name </label>
                                            <div class="form-group">

                                                <input class="form-control" name="fName" id="fName" placeholder="Example : Shyam Singh" Value="" type="text" value="" oninput="setaddress()">
                                            </div>
                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>House No</label>
                                            <input class="form-control" name="house_no" id="house_no" type="number" oninput="setaddress()" required="" placeholder="House No">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Gali,Locality</label>
                                            <input class="form-control" name="locality" id="locality" oninput="setaddress()" type="text" required="" placeholder="Gali, Locality, Panchayat">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Post Office</label>
                                            <input class="form-control" name="post_office" id="post_office" type="text" oninput="setaddress()" required="" placeholder="Post Office">
                                        </div>
                                        <div class="col-md-4">
                                            <label>State</label>
                                            <input class="form-control" name="state" id="state" type="text" oninput="setaddress()" required="" placeholder="State">
                                        </div>
                                        <div class="col-md-4">
                                            <label>City</label>
                                            <input class="form-control" name="city" id="city" type="text" oninput="setaddress()" required="" placeholder="City">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Pin code</label>
                                            <input class="form-control" name="pin_code" id="pincode" type="number" maxlength="7" oninput="setaddress()" required="" placeholder="pincode">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label>Date Of Birth</label>
                                            <div class="form-group">
                                                <input class="form-control" name="dob" type="text" required placeholder="D.O.B.(dd/MM/yyyy)" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Date Of Birth Local</label>
                                            <input class="form-control " id="birthtithilocal" name="birth_address" placeholder="Auto Fill" type="text" value="">
                                        </div></br>

                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <label>Select Gender</label>
                                            <div class="form-group">
                                                <select class="form-control" name="gender" id="gender" required>
                                                    <option value="">GENDER</option>
                                                    <option value="Male" name="gender" id="gender">Male</option>
                                                    <option value="Female" name="gender" id="gender">Female</option>
                                                </select><br>
                                            </div>
                                        </div>

                                        <input class="form-control " id="pata" name="pata" readonly="readonly" type="hidden" value="address">
                                        <input class="form-control " id="patalocal" name="patalocal" readonly="readonly" type="hidden" value="">
                                    </div>
                                </div>

                                <div class="col-sm-7">
                                    <label>Address </label>
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="S/O : Mo Rahim,  khurdaha, Jakhauli, Faizabad, Uttar Pradesh, 878987" style="height:55px" id="txtSource" name="address" rows="10" type="text"></textarea>
                                        <span id="errortxtSource" class="error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Select Image </label>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control" id="image" accept="image/x-png,image/jpg,image/jpeg" required />
                                        <img src="" id="blah" width="100px" height="100px" style="display: none;">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Select Local Language</label>
                                            <div class="form-group">
                                                <select class="form-control" onchange="changelang()" name="language" id="language" required>
                                                    <option value="">SELECT </option>
                                                    <option value="hindi">Hindi </option>
                                                    <option value="punjabi">Punjabi </option>
                                                    <option value="gujarati">Gujarati</option>
                                                    <option value="marathi">Marathi </option>
                                                    <option value="tamil">Tamil </option>
                                                    <option value="kannada">Kannada </option>
                                                    <option value="bengali">Bengali </option>
                                                    <option value="telgu">Telugu </option>
                                                    <option value="oriya">Oriya </option>
                                                    <option value="sindhi">Sindhi </option>
                                                </select>
                                                <span id="errorlanguage" class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Name (Local Language) </label>
                                            <div class="form-group">
                                                <input class="form-control" id="name_regional" name="name_local_language" type="text" value="">
                                                <span id="errorname_regional" class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Address (Local Language) </label>
                                            <div class="form-group">
                                                <textarea class="form-control" id="txtTarget" style="height:55px" name="address_local_language" rows="10" type="text"></textarea>
                                                <span id="errortxtTarget" class="error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $fee_sql = "SELECT * from services where service_name = 'Aadhar'";
                                    $fee_data = mysqli_query($conn, $fee_sql);
                                    if (mysqli_num_rows($fee_data) > 0) {
                                        $row = mysqli_fetch_assoc($fee_data);
                                    }
                                    ?>
                                    <div class="col-12 ml-2">
                                        <h5 class="text-warning ">Application Fee: ₹<?= $row['service_charge'] ?></h5>

                                    </div>
                                    <div class="col-sm-3">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button type="submit" name="savedataauto" class="btn btn-success btn-block">Submit</button>
                                        </div>



                                    </div>
                                    <div class="col-sm-3">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <a href="https://www.google.com/intl/sa/inputtools/try/" target="_blank" type="button" name="button" class="btn btn-primary btn-block">Open Google Input Tools</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>

                    </div>
                    <!-- /# row -->
                    </section>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function validation() {



            var txtSource = document.getElementById('txtSource').value;
            if (txtSource.trim() == "") {
                document.getElementById('errortxtSource').innerHTML = " **Please Enter Address !!!";
                document.getElementById('txtSource').style.border = "1px solid red";
                document.getElementById('txtSource').focus();
                return false;
            }

            var name_regional = document.getElementById('name_regional').value;
            if (name_regional.trim() == "") {
                document.getElementById('errorname_regional').innerHTML = " **Please Enter Name in Local Language !!!";
                document.getElementById('name_regional').style.border = "1px solid red";
                document.getElementById('name_regional').focus();
                return false;
            }

            var txtTarget = document.getElementById('txtTarget').value;
            if (txtTarget.trim() == "") {
                document.getElementById('errortxtTarget').innerHTML = " **Please Enter Local Language Address !!!";
                document.getElementById('txtTarget').style.border = "1px solid red";
                document.getElementById('txtTarget').focus();
                return false;
            }

        }

        function setaddress() {
            var fathername = document.getElementById('fathername').value;
            var houseno = document.getElementById('houseno').value;
            var streetlocality = document.getElementById('streetlocality').value;
            var vtcandpost = document.getElementById('vtcandpost').value;
            var state = document.getElementById('state').value;
            var city = document.getElementById('city').value;
            var pincode = document.getElementById('pincode').value;

            document.getElementById('txtSource').innerHTML = "S/O : " + fathername + ", " + houseno + ", " + streetlocality + ", " + vtcandpost + ", " + city + ", " + state + ", " + pincode;
        }
    </script>

    <script type="text/javascript">
        //English to hindi translate code
        function changelang() {
            var lang = document.getElementById("language").value;
            //alert(lang);
            var url =
                "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + escape($("#txtSource").val());

            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 500; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#txtTarget").val(result);

                }
            });

            url =
                "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + escape($("#name").val());
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 500; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    $("#name_regional").val(result);

                }
            });


            url =
                "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + escape($("#gender").val());
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 500; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    if (result == "नर")
                        result = "पुरुष";
                    $("#genderlocal").val(result);

                }
            });

            url =
                "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + escape($("#gender").val());
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 500; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    if (result == "ਨਰ")
                        result = "ਮਰਦ";
                    $("#genderlocal").val(result);

                }
            });

            url =
                "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + escape($("#birthtithi").val());
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 500; i++) {
                    result += data[0][i][0];
                    //alert(result);
                    $("#birthtithilocal").val(result);

                }
            });


            url =
                "https://translate.googleapis.com/translate_a/single?client=gtx";
            url += "&sl=" + 'EN';
            url += "&tl=" + lang;
            url += "&dt=t&q=" + escape($("#pata").val());
            //alert(url);
            $.get(url, function(data, status) {
                var result = '';
                for (var i = 0; i <= 500; i++) {
                    result += data[0][i][0];
                    // alert(result);
                    $("#patalocal").val(result);

                }
            });

        };
        //Words and Characters Count
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
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
        $('#pan_no').inputmask();
        $('#timea').inputmask("hh:mm:ss", {
            placeholder: "00:00:00",
            insertMode: false,
            showMaskOnHover: false,
            hourFormat: 12
        });
    });
</script>

</html>