<?php
ob_start();
ob_end_flush();
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '1' && $_SESSION['role'] !== 1) {
    die("Access Denied!");
}

include 'layout/header.php';
include('config.php');

// Fetch charge once
$chargeis = 0;
$fetchServiceCharge = "SELECT service_charge FROM services WHERE service_name='Birth_certificate'";
$DataBirth = mysqli_query($conn, $fetchServiceCharge);
if (mysqli_num_rows($DataBirth) > 0) {
    $resData = mysqli_fetch_array($DataBirth);
    $chargeis = $resData['service_charge'];
}
?>



<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $certificate = $_POST['certificate'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $name = $_POST['name'];
    $aadhar_number = $_POST['aadhar_number'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $fName = $_POST['fName'];
    $fAadhar = $_POST['fAadhar'];
    $mName = $_POST['mName'];
    $mAadhar = $_POST['mAadhar'];
    $address = $_POST['address'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $id = $_POST['id'];

    // Get phone number
    $getUser = mysqli_query($conn, "SELECT user_id FROM birth_certificate WHERE id = $id");
    $userData = mysqli_fetch_assoc($getUser);
    $user_id = $userData['user_id'];

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


    $sql = "UPDATE birth_certificate SET 
    certificate = '$certificate', 
    state = '$state', 
    district = '$district', 
    name = '$name', 
    aadhar_number = '$aadhar_number', 
    gender = '$gender', 
    dob = '$dob', 
    fName = '$fName', 
    fAadhar = '$fAadhar', 
    mName = '$mName', 
    mAadhar = '$mAadhar',
    address = '$address',
    status = '$status',
    certificate_file = '$filename',
    remark = '$remark'
WHERE id = $id";

    if (mysqli_query($conn, $sql)) {

        // Handle rejection refund and logs
        if ($status === "Rejected") {
            // Refund to user
            mysqli_query($conn, "UPDATE total_wallet_balence SET wallet_balence = wallet_balence + $chargeis WHERE user_id = $user_id");
            mysqli_query($conn, "UPDATE admin_wallet SET amount = amount - $chargeis WHERE amount >= $chargeis");

            // Log transaction
            $getBal = mysqli_query($conn, "SELECT wallet_balence FROM total_wallet_balence WHERE user_id = $user_id");
            $balRow = mysqli_fetch_assoc($getBal);
            $current_balance = $balRow['wallet_balence'];

            $purpose = 'Refund: Birth Certificate';
            $type = 'debit';
            $insertLog = "INSERT INTO wallet_transaction_history 
            (user_id, amount, available_balance, purpose, type, status) 
            VALUES ($user_id, $chargeis, $current_balance, '$purpose', '$type', 1)";
            mysqli_query($conn, $insertLog);
        }

        // Send WhatsApp messages
        if ($phone) {
            $idInstance = "7105245778";
            $apiToken = "ff89b835f24d423aa7e7d5602804bcdcc098a9c6d1604bebb5";
            $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

            $applicantNumber = "91" . $phone . "@c.us";
            $messageToUser = "Hello $name, your Birth Certificate application status is now *$status*.\n\nRemark: $remark";

            $dataUser = ["chatId" => $applicantNumber, "message" => $messageToUser];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataUser));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Curl Error: ' . curl_error($ch);
            } else {
                echo 'WhatsApp API Response: ' . $response;
            }
            curl_close($ch);
            echo "<script>window.location.href = 'birth_death_apply_list.php';</script>";
            exit;
        }
    }
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_sql = "SELECT * FROM birth_certificate WHERE id = $id";
    $data = mysqli_query($conn, $new_sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
        // $phone = $row['phone'];
    }
}
?>


<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Birth Certificatet Apply</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">BIRTH APPLY</li>
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
                <h6 class="mb-0 text-uppercase">Birth Certificate Apply</h6>
                <hr />
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <!-- <div>
                            <h6 class="text-danger "> जन्म प्रमाण पत्र 24 घंटे में कभी भी जारी हो सकता है | प्रमाण पत्र किसी भी राज्य के किसी भी पंचायत से आएगा | इसका इस्तमाल आधार कार्ड में करना है | आगे आपकी ज़िम्मेदारी होगी | जिसका आधार नंबर नहीं है उसमें NULL लिख सकते हैं | एक बार डेटा लगाने पर कैंसिल या रिफंड नहीं होगा </h6>
                        </div> -->






                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-id-card me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Enter Birth Certificate Details</h5>
                        </div>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">

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
                            <input type="hidden" name="oldimage" class="form-control " value="<?= $row['certificate_file'] ?>">
                            <img src="../assets/certificates/<?= $row['certificate_file'] ?>" alt="" height="50px" width="50px" class="">

                            <label for="certificate">Upload Certificate</label>
                            <input type="file" name="certificate_file" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?= $row['certificate_file'] ?>"><br>

                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <label for="certificate_type">Certificate Type:</label>
                            <select name="certificate" id="certificate_type" class="form-control">
                                <option value="birth certificate">Birth Certificate</option>
                            </select><br>
                            <label for="state">STATE:</label>
                            <select name="state" class="form-control">
                                <option value="Uttar Pradesh" <?= $row['state'] == 'Uttar Pradesh' ? 'selected' : '' ?>>UTTAR PRADESH (उत्तर प्रदेश)</option>
                            </select><br>
                            <label for="district">DISTRICT:</label>
                            <select name="district" id="district" class="form-control">
                                <option value="">Select a district...</option>
                                <option value="AGRA" <?= $row['district'] == 'AGRA' ? 'selected' : '' ?>>AGRA आगरा</option>
                                <option value="ALIGARH" <?= $row['district'] == 'ALIGARH' ? 'selected' : '' ?>>ALIGARH अलीगढ़</option>
                                <option value="ALLAHABAD" <?= $row['district'] == 'ALLAHABAD' ? 'selected' : '' ?>>ALLAHABAD इलाहाबाद</option>
                                <option value="AMBEDKAR NAGAR" <?= $row['district'] == 'AMBEDKAR NAGAR' ? 'selected' : '' ?>>AMBEDKAR NAGAR अम्बेडकर नगर</option>
                                <option value="AMETHI" <?= $row['district'] == 'AMETHI' ? 'selected' : '' ?>>AMETHI अमेठी</option>
                                <option value="AMROHA" <?= $row['district'] == 'AMROHA' ? 'selected' : '' ?>>AMROHA अमरोहा</option>
                                <option value="AURAIYA" <?= $row['district'] == 'AURAIYA' ? 'selected' : '' ?>>AURAIYA औरैया</option>
                                <option value="AZAMGARH" <?= $row['district'] == 'AZAMGARH' ? 'selected' : '' ?>>AZAMGARH आज़मगढ़</option>
                                <option value="BAGHPAT" <?= $row['district'] == 'BAGHPAT' ? 'selected' : '' ?>>BAGHPAT बागपत</option>
                                <option value="BAHRAICH" <?= $row['district'] == 'BAHRAICH' ? 'selected' : '' ?>>BAHRAICH बहराइच</option>
                                <option value="BALLIA" <?= $row['district'] == 'BALLIA' ? 'selected' : '' ?>>BALLIA बलिया</option>
                                <option value="BALRAMPUR" <?= $row['district'] == 'BALRAMPUR' ? 'selected' : '' ?>>BALRAMPUR बलरामपुर</option>
                                <option value="BANDA" <?= $row['district'] == 'BANDA' ? 'selected' : '' ?>>BANDA बांदा</option>
                                <option value="BARABANKI" <?= $row['district'] == 'BARABANKI' ? 'selected' : '' ?>>BARABANKI बाराबंकी</option>
                                <option value="BAREILLY" <?= $row['district'] == 'BAREILLY' ? 'selected' : '' ?>>BAREILLY बरेली</option>
                                <option value="BASTI" <?= $row['district'] == 'BASTI' ? 'selected' : '' ?>>BASTI बस्ती</option>
                                <option value="BHADOHI" <?= $row['district'] == 'BHADOHI' ? 'selected' : '' ?>>BHADOHI भदोही</option>
                                <option value="BIJNOR" <?= $row['district'] == 'BIJNOR' ? 'selected' : '' ?>>BIJNOR बिजनौर</option>
                                <option value="BUDAUN" <?= $row['district'] == 'BUDAUN' ? 'selected' : '' ?>>BUDAUN बदायूं</option>
                                <option value="BULANDSHAHR" <?= $row['district'] == 'BULANDSHAHR' ? 'selected' : '' ?>>BULANDSHAHR बुलंदशहर</option>
                                <option value="CHANDAULI" <?= $row['district'] == 'CHANDAULI' ? 'selected' : '' ?>>CHANDAULI चंदौली</option>
                                <option value="CHITRAKOOT" <?= $row['district'] == 'CHITRAKOOT' ? 'selected' : '' ?>>CHITRAKOOT चित्रकूट</option>
                                <option value="DEORIA" <?= $row['district'] == 'DEORIA' ? 'selected' : '' ?>>DEORIA देवरिया</option>
                                <option value="ETAH" <?= $row['district'] == 'EATH' ? 'selected' : '' ?>>ETAH एटा</option>
                                <option value="ETAWAH" <?= $row['district'] == 'ETAWAH' ? 'selected' : '' ?>>ETAWAH इटावा</option>
                                <option value="FAIZABAD" <?= $row['district'] == 'FAIZABAD' ? 'selected' : '' ?>>FAIZABAD फैजाबाद</option>
                                <option value="FARRUKHABAD" <?= $row['district'] == 'FARRUKHABAD' ? 'selected' : '' ?>>FARRUKHABAD फर्रुखाबाद</option>
                                <option value="FATEHPUR" <?= $row['district'] == 'FATEHPUR' ? 'selected' : '' ?>>FATEHPUR फतेहपुर</option>
                                <option value="FIROZABAD" <?= $row['district'] == 'FIROZABAD' ? 'selected' : '' ?>>FIROZABAD फिरोजाबाद</option>
                                <option value="GAUTAM BUDDHA NAGAR" <?= $row['district'] == 'GAUTAM BUDDHA NAGAR' ? 'selected' : '' ?>>GAUTAM BUDDHA NAGAR गौतम बुद्ध नगर</option>
                                <option value="GHAZIABAD" <?= $row['district'] == 'GHAZIABAD' ? 'selected' : '' ?>>GHAZIABAD गाजियाबाद</option>
                                <option value="GHAZIPUR" <?= $row['district'] == 'GHAZIPUR' ? 'selected' : '' ?>>GHAZIPUR गाजीपुर</option>
                                <option value="GONDA" <?= $row['district'] == 'GONDA' ? 'selected' : '' ?>>GONDA गोंडा</option>
                                <option value="GORAKHPUR" <?= $row['district'] == 'GORAKHPUR' ? 'selected' : '' ?>>GORAKHPUR गोरखपुर</option>
                                <option value="HAMIRPUR" <?= $row['district'] == 'HAMIRPUR' ? 'selected' : '' ?>>HAMIRPUR हमीरपुर</option>
                                <option value="HAPUR" <?= $row['district'] == 'HAPUR' ? 'selected' : '' ?>>HAPUR हापुड़</option>
                                <option value="HARDOI" <?= $row['district'] == 'HARDOI' ? 'selected' : '' ?>>HARDOI हरदोई</option>
                                <option value="HATHRAS" <?= $row['district'] == 'HATHRAS' ? 'selected' : '' ?>>HATHRAS हाथरस</option>
                                <option value="JALAUN" <?= $row['district'] == 'JALAUN' ? 'selected' : '' ?>>JALAUN जालौन</option>
                                <option value="JAUNPUR" <?= $row['district'] == 'JAUNPUR' ? 'selected' : '' ?>>JAUNPUR जौनपुर</option>
                                <option value="JHANSI" <?= $row['district'] == 'JHANSI' ? 'selected' : '' ?>>JHANSI झांसी</option>
                                <option value="KANNAUJ" <?= $row['district'] == 'KANNAUJ' ? 'selected' : '' ?>>KANNAUJ कन्नौज</option>
                                <option value="KANPUR DEHAT" <?= $row['district'] == 'KANPUR DEHAT' ? 'selected' : '' ?>>KANPUR DEHAT कानपुर देहात</option>
                                <option value="KANPUR NAGAR" <?= $row['district'] == 'KANPUR NAGAR' ? 'selected' : '' ?>>KANPUR NAGAR कानपुर नगर</option>
                                <option value="KASGANJ" <?= $row['district'] == 'KASGANJ' ? 'selected' : '' ?>>KASGANJ कासगंज</option>
                                <option value="KAUSHAMBI" <?= $row['district'] == 'KAUSHAMBI' ? 'selected' : '' ?>>KAUSHAMBI कौशांबी</option>
                                <option value="KUSHINAGAR" <?= $row['district'] == 'KUSHINAGAR' ? 'selected' : '' ?>>KUSHINAGAR कुशीनगर</option>
                                <option value="LAKHIMPUR KHERI" <?= $row['district'] == 'LAKHIMPUR KHERI' ? 'selected' : '' ?>>LAKHIMPUR KHERI लखीमपुर खीरी</option>
                                <option value="LALITPUR" <?= $row['district'] == 'LALITPUR' ? 'selected' : '' ?>>LALITPUR ललितपुर</option>
                                <option value="LUCKNOW" <?= $row['district'] == 'LUCKNOW' ? 'selected' : '' ?>>LUCKNOW लखनऊ</option>
                                <option value="MAHARAJGANJ" <?= $row['district'] == 'MAHARAJGANJ' ? 'selected' : '' ?>>MAHARAJGANJ महाराजगंज</option>
                                <option value="MAHOBA" <?= $row['district'] == 'MAHOBA' ? 'selected' : '' ?>>MAHOBA महोबा</option>
                                <option value="MAINPURI" <?= $row['district'] == 'MAINPURI' ? 'selected' : '' ?>>MAINPURI मैनपुरी</option>
                                <option value="MATHURA" <?= $row['district'] == 'MATHURA' ? 'selected' : '' ?>>MATHURA मथुरा</option>
                                <option value="MAU" <?= $row['district'] == 'MAU' ? 'selected' : '' ?>>MAU मऊ</option>
                                <option value="MEERUT" <?= $row['district'] == 'MEERUT' ? 'selected' : '' ?>>MEERUT मेरठ</option>
                                <option value="MIRZAPUR" <?= $row['district'] == 'MIRZAPUR' ? 'selected' : '' ?>>MIRZAPUR मिर्जापुर</option>
                                <option value="MORADABAD" <?= $row['district'] == 'MORADABAD' ? 'selected' : '' ?>>MORADABAD मुरादाबाद</option>
                                <option value="MUZAFFARNAGAR" <?= $row['district'] == 'MUZAFFANAGARA' ? 'selected' : '' ?>>MUZAFFARNAGAR मुजफ्फरनगर</option>
                                <option value="PILIBHIT" <?= $row['district'] == 'PILIBHIT' ? 'selected' : '' ?>>PILIBHIT पीलीभीत</option>
                                <option value="PRATAPGARH" <?= $row['district'] == 'PRATAPGARH' ? 'selected' : '' ?>>PRATAPGARH प्रतापगढ़</option>
                                <option value="PRAYAGRAJ" <?= $row['district'] == 'PRAYAGRAJ' ? 'selected' : '' ?>>PRAYAGRAJ प्रयागराज</option>
                                <option value="RAEBARELI" <?= $row['district'] == 'RAEBARELI' ? 'selected' : '' ?>>RAEBARELI रायबरेली</option>
                                <option value="RAMPUR" <?= $row['district'] == 'RAMPUR' ? 'selected' : '' ?>>RAMPUR रामपुर</option>
                                <option value="SAHARANPUR" <?= $row['district'] == 'SAHARANPUR' ? 'selected' : '' ?>>SAHARANPUR सहारनपुर</option>
                                <option value="SAMBHAL" <?= $row['district'] == 'SAMBHAL' ? 'selected' : '' ?>>SAMBHAL सम्भल</option>
                                <option value="SANT KABIR NAGAR" <?= $row['district'] == 'SANT KABIR NAGAR' ? 'selected' : '' ?>>SANT KABIR NAGAR संत कबीर नगर</option>
                                <option value="SHAHJAHANPUR" <?= $row['district'] == 'SHAJAHANPUR' ? 'selected' : '' ?>>SHAHJAHANPUR शाहजहांपुर</option>
                                <option value="SHAMLI" <?= $row['district'] == 'SHAMLI' ? 'selected' : '' ?>>SHAMLI शामली</option>
                                <option value="SHRAVASTI" <?= $row['district'] == 'SHRAVASTI' ? 'selected' : '' ?>>SHRAVASTI श्रावस्ती</option>
                                <option value="SIDDHARTHNAGAR" <?= $row['district'] == 'SIDDHARTHNAGAR' ? 'selected' : '' ?>>SIDDHARTHNAGAR सिद्धार्थनगर</option>
                                <option value="SITAPUR" <?= $row['district'] == 'SITAPUR' ? 'selected' : '' ?>>SITAPUR सीतापुर</option>
                                <option value="SONBHADRA" <?= $row['district'] == 'SONBHADRA' ? 'selected' : '' ?>>SONBHADRA सोनभद्र</option>
                                <option value="SULTANPUR" <?= $row['district'] == 'SULTANPUR' ? 'selected' : '' ?>>SULTANPUR सुल्तानपुर</option>
                                <option value="UNNAO" <?= $row['district'] == 'UNNAO' ? 'selected' : '' ?>>UNNAO उन्नाव</option>
                                <option value="VARANASI" <?= $row['district'] == 'VARANASI' ? 'selected' : '' ?>>VARANASI वाराणसी</option>
                            </select>


                            <br>

                            <label for="नाम / Full Name">नाम / Full NAME*</label>
                            <input type="text" name="name" oninput="this.value = this.value.toUpperCase()" class="form-control" value="<?= $row['name'] ?>"><br>

                            <label for="applicant_aadhar">आधार नंबर / ADHAR NUMBER*</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="aadhar_number" class="form-control" value="<?= $row['aadhar_number'] ?>"><br>

                            <label for="gender">लिंग / Gender*</label>
                            <select name="gender" class="form-control" ">
                                <option value=" MALE" <?= $row['gender'] == 'MALE' ? 'selected' : '' ?>>Male</option>
                                <option value="FEMALE" <?= $row['gender'] == 'FEMALE' ? 'selected' : '' ?>>Female</option>
                                <option value="OTHER" <?= $row['gender'] == 'OTHER' ? 'selected' : '' ?>>Other</option>
                            </select><br>

                            <label for="date_of_birth" id="date_of_birth_label">जन्म तिथि / Date of birth*</label>
                            <input type="text" name="dob" id="date_of_birth" class="form-control" value="<?= $row['dob'] ?>"><br>


                            <label for="father_name">पिता का नाम / Father Name*</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="fName" class="form-control" value="<?= $row['fName'] ?>"><br>

                            <label for="father_aadhar">पिता का आधार / Father Aadhar</label>
                            <input type="number" oninput="this.value = this.value.toUpperCase()" name="fAadhar" class="form-control" value="<?= $row['fAadhar'] ?>"><br>

                            <label for="mother_name">माता का नाम / Mother Name *</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="mName" class="form-control" value="<?= $row['mName'] ?>"><br>

                            <label for="mother_aadhar">माता का आधार / Mother Aadhar</label>
                            <input type="number" oninput="this.value = this.value.toUpperCase()" name="mAadhar" class="form-control" value="<?= $row['mAadhar'] ?>"><br>

                            <label for="address"> पता / Address *</label>
                            <textarea name="address" oninput="this.value = this.value.toUpperCase()" rows="4" class="form-control"><?= $row['address'] ?></textarea><br>


                            <!-- <div class=" col-12 ml-2">
                                <h5 class="text-warning">Application Fee: ₹250</h5>
                                <h5 class="text-warning"> DOB -> 2024 to 2025 Data Not Allow</h5>

                                <input type="hidden" name="fee" value="250">
                            </div> -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>


<script>
    const certificateSelect = document.getElementById("certificate_type");
    const dateOfBirthLabel = document.getElementById("date_of_birth_label");
    const dateOfBirthInput = document.getElementById("date_of_birth");

    certificateSelect.addEventListener("change", function() {
        if (this.value === "birthcertificate") {
            dateOfBirthLabel.textContent = "Date of Birth:";
            dateOfBirthInput.setAttribute("required", "");
        } else if (this.value === "deathcertificate") {
            dateOfBirthLabel.textContent = "Date of Death:";
            dateOfBirthInput.removeAttribute("required");
        }
    });
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


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr("#date_of_birth", {
        dateFormat: "d-m-Y", // Format: 01-01-2001
        maxDate: "today" // Optional: restrict to past dates only
    });
</script>


</html>