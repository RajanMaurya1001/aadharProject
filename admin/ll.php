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
    $state = $_POST['state'];
    $district = $_POST['district'];
    $application_no = trim($_POST['application_no']);
    $dob = trim($_POST['dob']);
    $phone = $_POST['phone'];
    $password = trim($_POST['password']);

    $sql = "INSERT INTO licence (state, district, application_no, dob, phone, password)
            VALUES ('$state', '$district', '$application_no', '$dob', '$phone','$password')";

    if (mysqli_query($conn, $sql)) {
        // Green API Details
        $idInstance = "7105242669";
        $apiToken = "dfb24b0b4e784ed4814e3a780e2ea43d01b49830e9a94562b2";
        $url = "https://7105.api.greenapi.com/waInstance$idInstance/sendMessage/$apiToken";

        // -----------------------------
        // ✅ 1. Message to Applicant
        // -----------------------------
        $applicantNumber = "91" . $phone . "@c.us";
        $messageToUser = "Hello $name, your application for the Learning Licence has been submitted successfully. Thank you!";

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
            "Learning Licence Application Received:\n\n" .
            "Application No: $application_no\n" .
            "Phone: $phone\n" .
            "DOB: $dob\n" .
            "State: $state\n" .
            "District: $district\n";

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
                                            <a href="#" class="alert-link">Learning Licence Pass</a><br>

                                            Tutorial Video Complete First Before Submiting Data <br>

                                            (Note :- RTO BAHRAICH,RTO SHAMBHAL,RTO RAMPUR )
                                            Ka Exam 10 PM me lagaye <br>

                                        </div>
                                        <form method="POST" action="">


                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="state">Select State</label>
                                                        <select class="form-control" name="state" required="" id="state">
                                                            <option value="">-- Select State --</option>
                                                            <option value="ANDHRA PRADESH">ANDHRA PRADESH (आंध्र प्रदेश)</option>
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
                                                            <option value="ANDAMAN & NICOBAR ISLANDS">ANDAMAN & NICOBAR ISLANDS (अंडमान और निकोबार द्वीपसमूह)</option>
                                                            <option value="CHANDIGARH">CHANDIGARH (चंडीगढ़)</option>
                                                            <option value=">DADRA & NAGAR HAVELI AND DAMAN & DIU ">DADRA & NAGAR HAVELI AND DAMAN & DIU (दादरा और नगर हवेली और दमन और दीव)</option>
                                                            <option value="DELHI">DELHI (दिल्ली)</option>
                                                            <option value="JAMMU & KASHMIR">JAMMU & KASHMIR (जम्मू और कश्मीर)</option>
                                                            <option value="LADAKH">LADAKH (लद्दाख)</option>
                                                            <option value="LAKSHADWEEP">LAKSHADWEEP (लक्षद्वीप)</optin>
                                                        </select><br>

                                                        <label for="district">DISTRICT:</label>
                                                        <select name="district" id="district" class="form-control" required>
                                                            <option value="">Select a district...</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="rc_dl">Enter Application Number</label>
                                                        <input type="text" class="form-control" name="application_no" placeholder="Application Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="rc_dl">Enter DOB</label>
                                                        <input type="date" class="form-control" name="dob" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="rc_dl"> Phone Number</label>
                                                        <input type="text" class="form-control" name="phone" placeholder="phone" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="card-title" for="rc_dl">Enter Password</label>
                                                        <input type="text" class="form-control" name="password" placeholder="Password" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php
                                            $fee_sql = "SELECT * from services where service_name = 'Learning_ licence'";
                                            $fee_data = mysqli_query($conn, $fee_sql);
                                            if (mysqli_num_rows($fee_data) > 0) {
                                                $row = mysqli_fetch_assoc($fee_data);
                                            }
                                            ?>
                                            <div class="col-12 ml-2">
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