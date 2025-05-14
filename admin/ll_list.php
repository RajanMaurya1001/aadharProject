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

<style>
    /* Custom styling for the table */
    .table-responsive {
        max-height: 500px;
        overflow: auto;
        position: relative;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }

    /* Fixed table layout for equal column widths */
    #example2 {
        table-layout: fixed;
        width: 100%;
        margin: 0;
    }

    /* Equal column widths (10 columns = ~10% each) */
    #example2 th,
    #example2 td {
        width: 10%;
        text-align: center;
        padding: 12px 8px;
        vertical-align: middle;
        word-wrap: break-word;
    }

    /* Sticky header */
    #example2 thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
    }

    /* Scrollbar styling */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Form elements styling */
    .status-dropdown {
        width: 100%;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .remark-textarea {
        width: 100%;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        resize: vertical;
    }

    /* Button styling */
    .table-responsive button {
        padding: 5px 10px;
        margin: 2px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Update button */
    .table-responsive button:nth-child(1) {
        background-color: #4CAF50;
        color: white;
    }

    /* Delete button */
    .table-responsive button:nth-child(2) {
        background-color: #f44336;
        color: white;
    }

    /* Upload button */
    .table-responsive button[type="submit"] {
        background-color: #2196F3;
        color: white;
    }

    /* File input styling */
    .table-responsive input[type="file"] {
        width: 100%;
        margin-bottom: 5px;
    }
</style>
<!-- Modal for processing -->
<script>
    function myFunction() {
        $("#proc_modal").modal('show');
        document.f1.submit();
    }
</script>

<div class="modal fade" id="proc_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <center>
                <img src="assets/images/settings.gif" width="100px" height="100px">
                <h6>Please wait. we are processing your request ...</h6>
            </center>
        </div>
    </div>
</div>

<!-- Styling -->
<style>
    /* Your styles go here */
</style>

<!-- Datatable initialization -->
<script>
    $(document).ready(() => {
        $('#default-datatable').DataTable();
    });
</script>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <!-- Content section -->
            <div class="content-wrap">
                <div class="main">
                    <div class="col-md-12">
                        <div class="main-content">
                            <section class="section">
                                <div class="card-header bg-danger">
                                    <div class="card-title">
                                        <h3><strong>Learning Licence List </strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="default-datatable" class="table table-bordered" width="100%">
                                                        <!-- Table headers -->
                                                        <thead style="color:white;background:linear-gradient(-62deg, #3a3a53, #03a9f4);">
                                                            <tr>
                                                                <th style="color:white; text-align:center;">#</th>
                                                                <th style="color:white"> PS Print Application Number</th>
                                                                <th style="color:white">Date/Time</th>
                                                                <th style="color:white">Application Number</th>
                                                                <th style="color:white">DOB</th>
                                                                <th style="color:white; text-align:center;">Status</th>
                                                                <th class="text-center">Remark</th>
                                                                <th class="text-center">Action</th>
                                                                <th class="text-center">File</th>

                                                            </tr>
                                                        </thead>
                                                        <!-- Table data -->
                                                        <tbody>

                                                            <?php
                                                            $sql = "select * from licence";
                                                            $data = mysqli_query($conn, $sql);
                                                            if (mysqli_num_rows($data) > 0) {
                                                                while ($row = mysqli_fetch_assoc($data)) {

                                                            ?>
                                                                    <tr>
                                                                        <td><?= $row['id'] ?></td>
                                                                        <td>PS_64217009</td>
                                                                        <td><?= $row['created_at'] ?></td>
                                                                        <td><?= $row['application_no'] ?></td>
                                                                        <td><?= $row['dob'] ?></td>
                                                                        <td class="text-center">
                                                                            <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>">
                                                                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                                                <option value="Process" <?= $row['status'] == 'Process' ? 'selected' : '' ?>>Process</option>
                                                                                <option value="Approved" <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                                                <option value="Rejected" <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <textarea class="remark-textarea" data-id="<?= $row['id']; ?>" rows="2"><?= htmlspecialchars($row['remark']); ?></textarea>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex flex-column">
                                                                                <a href="updateLearning.php?id=<?= $row['id'] ?>">
                                                                                    <button>UPDATE</button>
                                                                                </a>
                                                                                <a href="deleteLearning.php?id=<?= $row['id'] ?>">
                                                                                    <button>DELETE</button>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <form action="upload_Licenece.php" method="POST" enctype="multipart/form-data">
                                                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                                                <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                                                                                <button type="submit">Upload</button>
                                                                            </form>
                                                                        </td>

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
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ClipboardJS initialization -->
            <script>
                $(document).ready(function() {
                    new ClipboardJS('.btn');
                });
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

        <script>
            // jQuery AJAX Code (header में jQuery include करें)
            $(document).ready(function() {
                $('.status-dropdown').on('change', function() {
                    var status = $(this).val();
                    var id = $(this).data('id');

                    $.ajax({
                        url: 'update_status_learning.php',
                        method: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                // Optional: Show success message
                                alert('Status updated successfully!');
                                // location.reload();
                            } else {
                                alert('Error updating status!');
                            }
                        },
                        error: function() {
                            alert('Server error!');
                        }
                    });
                });
            });
        </script>

        <!-- remark Ka Ajax hai -->
        <script>
            document.querySelectorAll('.remark-textarea').forEach(function(textarea) {
                textarea.addEventListener('blur', function() {
                    var id = this.dataset.id;
                    var remark = this.value;

                    // AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_Learning_remark.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onload = function() {
                        if (xhr.status == 200) {
                            console.log("Remark updated for ID " + id);
                        }
                    };

                    xhr.send("id=" + encodeURIComponent(id) + "&remark=" + encodeURIComponent(remark));
                });
            });
        </script>

        </body>



        </html>