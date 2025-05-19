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
    $phone = $_POST['phone'];
    $status = 'pending';

    $currentYear = date('Y');
    $prefix = 'Birth_APP' . $currentYear;
    $getLast = mysqli_query($conn, "SELECT application_no FROM birth_certificate WHERE application_no LIKE '$prefix%' ORDER BY id DESC LIMIT 1");
    $lastNumber = 0;
    if ($row = mysqli_fetch_assoc($getLast)) {
        $lastCertificate = $row['application_no'];
        // Extract the numeric part after the current year's prefix
        $sequencePart = substr($lastCertificate, strlen($prefix));
        $lastNumber = (int)$sequencePart;
    }
    $newNumber = $lastNumber + 1;
    $application_no = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);


    $sql = "INSERT INTO birth_certificate(certificate, state, district, name, aadhar_number, gender, dob, fName, fAadhar, mName, mAadhar, address, phone, application_no, status) 
     VALUES('$certificate', '$state', '$district', '$name', '$aadhar_number', '$gender', '$dob', '$fName', '$fAadhar', '$mName', '$mAadhar', '$address', '$phone', '$application_no','$status')";

    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105242669";
        $apiToken = "dfb24b0b4e784ed4814e3a780e2ea43d01b49830e9a94562b2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $name, your application for the Birth Cirtificate has been submitted successfully. Thank you!";

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
            "Birth Cirtificate Application Received:\n\n" .
            $message = "Certificate Application Received:\n\n" .
            "Certificate Type: $certificate\n" .
            "Name: $name\n" .
            "Father's Name: $fName\n" .
            "Father's Aadhaar: $fAadhar\n" .
            "Mother's Name: $mName\n" .
            "Mother's Aadhaar: $mAadhar\n" .
            "Gender: $gender\n" .
            "DOB: $dob\n" .
            "Phone: $phone\n" .
            "Aadhaar No: $aadhar_number\n" .
            "Address: $address\n" .
            "District: $district\n" .
            "State: $state\n" .
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
                        <div>
                            <h6 class="text-danger "> जन्म प्रमाण पत्र 24 घंटे में कभी भी जारी हो सकता है | प्रमाण पत्र किसी भी राज्य के किसी भी पंचायत से आएगा | इसका इस्तमाल आधार कार्ड में करना है | आगे आपकी ज़िम्मेदारी होगी | जिसका आधार नंबर नहीं है उसमें NULL लिख सकते हैं | एक बार डेटा लगाने पर कैंसिल या रिफंड नहीं होगा </h6>
                        </div>
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-id-card me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Enter Birth Certificate Details</h5>
                        </div>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                            <label for="certificate_type">Certificate Type:</label>
                            <select name="certificate" id="certificate_type" class="form-control" required>
                                <option value="birth certificate">Birth Certificate</option>
                            </select><br>
                            <label for="state">STATE:</label>
                            <select name="state" id="state" class="form-control" required>
                                <option value="">Select State</option>
                                <option value="ANDHRA PRADESH ">ANDHRA PRADESH (आंध्र प्रदेश)</option>
                                <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH (अरुणाचल प्रदेश)</option>
                                <option value="ASSAM">ASSAM (असम)</option>
                                <option value="BIHAR">BIHAR</option>
                                <option value="CHHATTISGARH">CHHATTISGARH (छत्तीसगढ़)</option>
                                <option value="GOA">GOA (गोवा)</option>
                                <option value="GUJARAT">GUJARAT (गुजरात)</option>
                                <option value="HARYANA">HARYANA (हरियाणा)</option>
                                <option value="HIMACHAL PRADESH">HIMACHAL PRADESH (हिमाचल प्रदेश)</option>
                                <option value="JHARKHAND">JHARKHAND (झारखंड)</option>
                                <option value="KARNATAKA">KARNATAKA (कर्नाटक)</option>
                                <option value="KERALA">KERALA (केरल)</option>
                                <option value="MADHYA PRADESH">MADHYA PRADESH (मध्य प्रदेश)</option>
                                <option value="MAHARASHTRA">MAHARASHTRA (महाराष्ट्र)</option>
                                <option value="MANIPUR">MANIPUR (मणिपुर)</option>
                                <option value="MEGHALAYA">MEGHALAYA (मेघालय)</option>
                                <option value="MIZORAM">MIZORAM (मिज़ोरम)</option>
                                <option value="NAGALAND">NAGALAND (नागालैंड)</option>
                                <option value="ODISHA">ODISHA (ओडिशा)</option>
                                <option value="PUNJAB">PUNJAB (पंजाब)</option>
                                <option value="RAJASTHAN">RAJASTHAN (राजस्थान)</option>
                                <option value="SIKKIM">SIKKIM (सिक्किम)</option>
                                <option value="TAMIL NADU">TAMIL NADU (तमिलनाडु)</option>
                                <option value="TELANGANA">TELANGANA (तेलंगाना)</option>
                                <option value="TRIPURA">TRIPURA (त्रिपुरा)</option>
                                <option value="UTTAR PRADESH">UTTAR PRADESH (उत्तर प्रदेश)</option>
                                <option value="UTTARAKHAND">UTTARAKHAND (उत्तराखंड)</option>
                                <option value="WEST BENGAL">WEST BENGAL (पश्चिम बंगाल)</option>

                                <!-- Union Territories -->
                                <option value="Andaman and Nicobar Islands">ANDAMAN & NICOBAR ISLANDS (अंडमान और निकोबार द्वीपसमूह)</option>
                                <option value="Chandigarh">CHANDIGARH (चंडीगढ़)</option>
                                <option value="Dadra and Nagar Haveli and Daman and Diu">DADRA & NAGAR HAVELI AND DAMAN & DIU (दादरा और नगर हवेली और दमन और दीव)</option>
                                <option value="Delhi">DELHI (दिल्ली)</option>
                                <option value="Jammu and Kashmir">JAMMU & KASHMIR (जम्मू और कश्मीर)</option>
                                <option value="Ladakh">LADAKH (लद्दाख)</option>
                                <option value="Lakshadweep">LAKSHADWEEP (लक्षद्वीप)</optin>

                            </select><br>
                            <label for="district">DISTRICT:</label>
                            <select name="district" id="district" class="form-control" required>
                                <option value="">First Select State...</option>

                            </select>

                            <br>

                            <label for="नाम / Full Name">नाम / Full NAME*</label>
                            <input type="text" name="name" oninput="this.value = this.value.toUpperCase()" class="form-control" required><br>

                            <label for="applicant_aadhar">आधार नंबर / ADHAR NUMBER*</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="aadhar_number" class="form-control" required><br>
                            <label>PHONE NUMBER*</label>
                            <input type="number" name="phone" class="form-control" required><br>

                            <label for="gender">लिंग / Gender*</label>
                            <select name="gender" class="form-control" required>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                                <option value="OTHER">Other</option>
                            </select><br>

                            <label for="date_of_birth" id="date_of_birth_label">जन्म तिथि / Date of birth*</label>
                            <input type="text" name="dob" id="date_of_birth" class="form-control" required><br>


                            <label for="father_name">पिता का नाम / Father Name*</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="fName" class="form-control" required><br>

                            <label for="father_aadhar">पिता का आधार / Father Aadhar</label>
                            <input type="number" oninput="this.value = this.value.toUpperCase()" name="fAadhar" class="form-control" required><br>

                            <label for="mother_name">माता का नाम / Mother Name *</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="mName" class="form-control" required><br>

                            <label for="mother_aadhar">माता का आधार / Mother Aadhar</label>
                            <input type="number" oninput="this.value = this.value.toUpperCase()" name="mAadhar" class="form-control" required><br>

                            <label for="address"> पता / Address *</label>
                            <textarea name="address" oninput="this.value = this.value.toUpperCase()" rows="4" class="form-control" required></textarea><br>


                            <div class="col-12 ml-2">
                                <?php
                                $fee_sql = "SELECT * from services where service_name = 'Birth_certificate'";
                                $fee_data = mysqli_query($conn, $fee_sql);
                                if (mysqli_num_rows($fee_data) > 0) {
                                    $row = mysqli_fetch_assoc($fee_data);
                                }
                                ?>
                                <h5 class="text-warning">Application Fee: ₹<?= $row['service_charge'] ?></h5>
                                <h5 class="text-warning"> DOB -> 2024 to 2025 Data Not Allow</h5>
                                <input type="hidden" name="fee" value="250">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Apply</button>
                            </div>
                        </form>
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