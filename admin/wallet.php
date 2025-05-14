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
    $amount = $_POST['amount'];
    $payment_mode = $_POST['payment_mode'];
    $transaction_id = $_POST['transaction_id'];
    $payment_mode = $_POST['payment_mode'];
    // $id = $_POST['id'];

    if (empty($_FILES['screenshot']['name'])) {
        $filename = $_POST['oldimage'];
    } else {
        $filename = time() . $_FILES['screenshot']['name'];
        $tempname = $_FILES['screenshot']['tmp_name'];
        move_uploaded_file($tempname, '../assets/payment_screenshort/' . $filename);
    }

    $update_balance_sql = "UPDATE wallet SET amount = amount + '$amount' WHERE id = $id";
    if (mysqli_query($conn, $update_balance_sql)) {

        // Insert wallet transaction
        $insert_transaction_sql = "INSERT INTO wallet (user_id, transaction_id, amount, screenshot, payment_mode) 
                               VALUES ($id, '$transaction_id', '$amount', '$filename', '$payment_mode')";
        if (mysqli_query($conn, $insert_transaction_sql)) {
            echo "<script>alert('Balance Added Successfully');
            window.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>alert('Error: Could not record transaction.');</script>";
        }
    } else {
        echo "<script>alert('Error: Could not update balance.');</script>";
    }
}



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
        <form action="" method="POST">
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
                                    <label for="inputChoosePassword2" class="col-sm-3 col-form-label">Enter
                                        Amount <span style="color:red;">*</span></label>
                                    <div class="col-sm-3">
                                        <input required name="amount" type="number" max="1000" min="100" class="form-control" id="inputChoosePassword2"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class=" row mb-3">
                                    <label for="inputChoosePassword2" class="col-sm-3 col-form-label">Select Payment Mode <span style="color:red;">*</span></label>
                                    <div class="col-sm-3">
                                        <select required class="form-control" name="payment_mode" id="">
                                            <option value="">Select Payment Mode</option>
                                            <option value="upi">UPI</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <input type="hidden" name="oldimage" value="<?= $row['screenshot'] ?>">
                                    <label class=" col-sm-3 col-form-label">Screenshort
                                        <span style="color:red;">*</span></label>
                                    <div class="col-sm-3">
                                        <input name="screenshot" type="file" class="form-control"
                                            id="" value="">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class=" col-sm-3 col-form-label">Transection ID
                                        <span style="color:red;">*</span></label>
                                    <div class="col-sm-3">
                                        <input name="transaction_id" type="text" class="form-control"
                                            id="" value="">
                                    </div>
                                </div>


                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-info px-5">Add Balance</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--end row
        <h6 class="mb-0 text-uppercase">Payment List</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">

								<thead>
									<tr>
                                        <th>Sl.</th>
                                        										<th>TXN ID</th>
										<th>Amount</th>
										<th>TXN date</th>
										<th>Email</th>
										<th>Method</th>
										<th>Status</th>
										
									</tr>
								</thead>

								<tbody>
                                                                                <tr>
										<td>1</td>
										 										<td>PS_9621339850_1171076</td>
										<td>1000</td>
										<td>2025-05-04 19:33:22</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:yellow;color:black;' class="badge badge-bg-primary">PENDING</td>
									</tr>
                                                                                        <tr>
										<td>2</td>
										 										<td>PS_9621339850_886331</td>
										<td>200</td>
										<td>2025-04-23 11:49:47</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>3</td>
										 										<td>PS_9621339850_1659450</td>
										<td>100</td>
										<td>2025-04-23 11:49:25</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:yellow;color:black;' class="badge badge-bg-primary">PENDING</td>
									</tr>
                                                                                        <tr>
										<td>4</td>
										 										<td>PS_9621339850_1561552</td>
										<td>150</td>
										<td>2025-04-06 20:33:37</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>5</td>
										 										<td>PS_9621339850_8710257</td>
										<td>100</td>
										<td>2025-04-04 21:01:33</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>6</td>
										 										<td>PS_9621339850_1017126</td>
										<td>300</td>
										<td>2025-04-04 00:07:56</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>7</td>
										 										<td>PS_9621339850_2567134</td>
										<td>200</td>
										<td>2025-03-28 11:53:13</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>8</td>
										 										<td>PS_9621339850_3895274</td>
										<td>180</td>
										<td>2025-03-22 21:10:10</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>9</td>
										 										<td>PS_9621339850_5782968</td>
										<td>150</td>
										<td>2025-03-16 20:50:39</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>10</td>
										 										<td>PS_9621339850_2878963</td>
										<td>100</td>
										<td>2025-03-16 20:50:28</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:yellow;color:black;' class="badge badge-bg-primary">PENDING</td>
									</tr>
                                                                                        <tr>
										<td>11</td>
										 										<td>PS_9621339850_2766982</td>
										<td>150</td>
										<td>2025-03-09 11:42:34</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>12</td>
										 										<td>PS_9621339850_117496</td>
										<td>150</td>
										<td>2025-03-03 15:58:43</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>13</td>
										 										<td>PS_9621339850_1728343</td>
										<td>100</td>
										<td>2025-02-25 15:52:55</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>14</td>
										 										<td>PS_9621339850_8530600</td>
										<td>100</td>
										<td>2025-02-24 16:01:43</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>15</td>
										 										<td>PS_9621339850_2833256</td>
										<td>100</td>
										<td>2025-02-19 19:30:15</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>16</td>
										 										<td>PS_9621339850_4780142</td>
										<td>200</td>
										<td>2025-02-08 16:24:55</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>17</td>
										 										<td>PS_9621339850_3951323</td>
										<td>150</td>
										<td>2025-02-06 17:51:19</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>18</td>
										 										<td>PS_9621339850_4710765</td>
										<td>100</td>
										<td>2025-02-05 19:36:49</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>19</td>
										 										<td>PS_9621339850_3027196</td>
										<td>100</td>
										<td>2025-02-02 11:46:10</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>20</td>
										 										<td>PS_9621339850_6387488</td>
										<td>100</td>
										<td>2025-02-01 22:10:04</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>21</td>
										 										<td>PS_9621339850_5439022</td>
										<td>250</td>
										<td>2025-02-01 14:20:15</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>22</td>
										 										<td>PS_9621339850_5754448</td>
										<td>100</td>
										<td>2025-01-26 15:40:05</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>23</td>
										 										<td>PS_9621339850_2492410</td>
										<td>200</td>
										<td>2025-01-25 16:47:00</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>24</td>
										 										<td>PS_9621339850_3790966</td>
										<td>100</td>
										<td>2025-01-25 16:42:36</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:yellow;color:black;' class="badge badge-bg-primary">PENDING</td>
									</tr>
                                                                                        <tr>
										<td>25</td>
										 										<td>PS_9621339850_4601654</td>
										<td>100</td>
										<td>2025-01-22 13:41:05</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>26</td>
										 										<td>PS_9621339850_463792</td>
										<td>100</td>
										<td>2025-01-06 15:01:06</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>27</td>
										 										<td>PS_9621339850_1286259</td>
										<td>100</td>
										<td>2024-12-31 15:21:42</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:yellow;color:black;' class="badge badge-bg-primary">PENDING</td>
									</tr>
                                                                                        <tr>
										<td>28</td>
										 										<td>PS_9621339850_2665683</td>
										<td>100</td>
										<td>2024-12-07 11:54:50</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>29</td>
										 										<td>PS_9621339850_646063</td>
										<td>100</td>
										<td>2024-09-15 23:10:31</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                                                                        <tr>
										<td>30</td>
										 										<td>PS_9621339850_9921630</td>
										<td>100</td>
										<td>2024-09-15 22:55:53</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:yellow;color:black;' class="badge badge-bg-primary">PENDING</td>
									</tr>
                                                                                        <tr>
										<td>31</td>
										 										<td>PS_9621339850_1241345</td>
										<td>100</td>
										<td>2024-08-16 15:00:12</td>
										<td>MYHOLYDAY09@GMAIL.COM</td>
										<td>UPI</td>

										<td style='background-color:green;color:white;' class="badge badge-bg-primary">SUCCESS</td>
									</tr>
                                            									
									
									
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
			
    </div>
</div> -->
        <!--end page wrapper -->

        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2025. All right reserved. Developed by Shivaji Services</p>
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
    <!--app JS-->
    <script src="../assets/js/app.js"></script>
    <!-- datatable -->
    <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
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
    <!--app JS-->
    <script src="../assets/js/app.js"></script>
    </body>



    </html>