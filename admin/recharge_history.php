<?php

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '1' && $_SESSION['role'] !== 1) {
    die("Access Denied!");
}
include 'layout/header.php';
?>


<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">All Wallet Recharge List</h5>
                    </div>

                </div>
                <hr>
                <div class="table-responsive">
                    <table id="example2" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">SL.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center" style="width: 10px;">Amount</th>
                                <th class="text-center">TXN ID</th>
                                <th class="text-center">USER ID</th>
                                <th class="text-center">TXN date</th>



                                <!-- <th class="text-center">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            // $id = $_SESSION['id'];
                            include('config.php');
                            $sql = "select * from wallet";
                            $data = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {

                            ?>

                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <th class="text-center"><?= $row['name'] ?></th>
                                        <td class="text-center"><?= $row['amount'] ?></td>
                                        <td class="text-center">
                                            <?= $row['transaction_id'] ?>
                                        </td>
                                        <td class="text-center"><?= $row['user_id'] ?></td>
                                        <td class="text-center"><?= $row['created_at'] ?></td>
                                        <!-- <td class="text-center">
                                            <a style="margin-top:2px;margin-bottom:2px;padding-top:2px;padding-bottom:2px;" class="btn btn-success" href="https://psprint.xyz/upi/walletHandler.php?client_txn_id=PS_9621339850_1171076"> Check Again </a>

                                        </td> -->
                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!--start overlay-->
<div class="overlay toggle-icon"></div>
<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

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
        $('#aadh').inputmask();
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

</body>



</html>