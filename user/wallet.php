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
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$phone = isset($_SESSION['mobile_number']) ? $_SESSION['mobile_number'] : "";
// print_r($_SESSION);
include('config.php');
include 'layout/header.php';
?>



<?php
$new_sql = "SELECT * FROM user WHERE id = $id";
$result = mysqli_query($conn, $new_sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "No user found with ID: $id";
}

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Wallet</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Wallet Management</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                            href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                            link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <!--end row-->

        <div class="row">
            <div class="col-xl-9 mx-auto">
                <h6 class="mb-0 text-uppercase">Add Wallet Balance</h6>
                <hr />
                <div class="card border-top border-0 border-4 border-info">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-wallet me-1 font-22 text-info"></i>
                                </div>
                                <h5 class="mb-0 text-info">Add Balance VIA card UPI</h5>
                            </div>
                            <hr />

                            <div class="row mb-3">
                                <label class=" col-sm-3 col-form-label">Email
                                    <span style="color:red;">*</span></label>
                                <div class="col-sm-3">
                                    <input name="email" type="email" class="form-control"
                                        id="email" value="<?= $email ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputChoosePassword2" class="col-sm-3 col-form-label">Enter
                                    Amount <span style="color:red;">*</span></label>
                                <div class="col-sm-3">
                                    <input required name="amount" type="number" class="form-control" id="amount"
                                        placeholder="Amount">
                                </div>
                            </div>
                            <div class=" row mb-3">
                                <label for="inputChoosePassword2" class="col-sm-3 col-form-label">Select Payment Mode <span style="color:red;">*</span></label>
                                <div class="col-sm-3">
                                    <select required class="form-control" name="payment_mode" id="mode">
                                        <option value="">Select Payment Mode</option>
                                        <option value="upi">UPI</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-3">

                                    <button type="button" id="wallet_add" class="btn btn-info px-5">Add Balance</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- patyment gateway included -->
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            document.querySelector("#wallet_add").addEventListener("click", function() {
                let mobile = '<?= $phone ?>';
                let amount = document.querySelector("#amount").value;
                let mode = document.querySelector("#mode").value;
                let email = document.querySelector("#email").value;

                if (!amount || !mode || !email) {
                    alert("All field is required");
                    return;
                }

                // send the data in gateway
                let totalAmount = parseFloat(amount) * 100;

                let options = {
                    "key": "rzp_live_t6gVKS9RuNQJUO", //your rozarpay key 
                    "amount": totalAmount,
                    "currency": "INR",
                    "name": "PS-PRINT",
                    "description": "Payment for Adding wallet balence",
                    "handler": function(response) {
                        alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);

                        // Redirect to process_payment.php with all required data
                        let wallet_data = new URLSearchParams({
                            transaction_id: response.razorpay_payment_id,
                            amount: amount,
                            mode: mode,
                            email: email,
                            payment_status: "Success"
                        }).toString();


                        window.location.href = `insert_update_wallet.php?${wallet_data}`;
                    },
                    "prefill": {
                        "name": name,
                        // "email": email,
                        "contact": mobile
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };

                let rzp1 = new Razorpay(options);
                rzp1.open();
            })
        </script>

        <?php
        include('layout/footer.php');
        ?>