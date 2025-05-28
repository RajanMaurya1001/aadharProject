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
                                                                <th style="color:white">Password</th>
                                                                <th style="color:white">DOB</th>
                                                                <th style="color:white; text-align:center;">Status</th>
                                                                <th class="text-center">Remark</th>
                                                                <th class="text-center">Action</th>
                                                                <th class="text-center">Final Submit</th>

                                                            </tr>
                                                        </thead>
                                                        <!-- Table data -->
                                                        <tbody>

                                                            <?php
                                                            $sql = "SELECT * FROM licence WHERE final_submit = 0";
                                                            $data = mysqli_query($conn, $sql);
                                                            if (mysqli_num_rows($data) > 0) {
                                                                while ($row = mysqli_fetch_assoc($data)) {

                                                            ?>
                                                                    <tr>
                                                                        <td><?= $row['id'] ?></td>
                                                                        <td><?= $row['application_no'] ?></td>
                                                                        <td><?= $row['created_at'] ?></td>
                                                                        <td class="phone"><?= $row['password'] ?></td>
                                                                        <td class="user_id" style="display: none;"><?= $row['user_id'] ?></td>
                                                                        <td><?= $row['dob'] ?></td>
                                                                        <td><?= $row['status'] ?></td>
                                                                        <td><?= $row['remark'] ?></td>


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
                                                                            <?php
                                                                            $status = $row['status'];
                                                                            $certificate = $row['certificate_file'];
                                                                            $id = $row['id'];

                                                                            $enableButton = false;

                                                                            if ($status === 'Rejected') {
                                                                                $enableButton = true;
                                                                            } elseif ($status === 'Approved' && !empty($certificate)) {
                                                                                $enableButton = true;
                                                                            }

                                                                            if ($enableButton):
                                                                            ?>
                                                                                <form method="POST" action="final_learning_submit.php" onsubmit="return confirm('Are you sure you want to finalize this?');">
                                                                                    <input type="hidden" name="id" value="<?= $id ?>">
                                                                                    <button type="submit" name="final_learning_submit" style="background-color: red;">Final Submit</button>
                                                                                </form>
                                                                            <?php else: ?>
                                                                                <button disabled style="background-color: gray;">Final Submit</button>
                                                                            <?php endif; ?>
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

        </div>
    </div>
</div>



<script>
    // jQuery AJAX Code (header में jQuery include करें)
    $(document).ready(function() {
        $('.status-dropdown').on('change', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            var application_no = $(this).closest('tr').find('.application_no').text().trim();
            var phone = $(this).closest('tr').find('.phone').text().trim();
            var user_id = $(this).closest('tr').find('.user_id').text().trim();
            var remark = $(this).closest('tr').find('.remark-textarea').val().trim();

            $.ajax({
                url: 'update_status_learning.php',
                method: 'POST',
                data: {
                    id: id,
                    status: status,
                    application_no: application_no,
                    phone: phone,
                    remark: remark,
                    user_id: user_id
                },
                success: function(response) {
                    console.log("Raw Response: ", response);

                    // ✅ No need for try-catch or JSON.parse
                    if (response.success) {
                        // ✅ Show alert message instead of toast
                        alert("Status updated successfully! Message sent.");

                        // ✅ Update dropdown UI
                        $dropdown.find('option').prop('selected', false);
                        $dropdown.find('option[value="' + status + '"]').prop('selected', true);
                    } else {
                        $dropdown.val($dropdown.data('previous-value'));
                        alert('Somthoting Status updated successfully! Message sent');
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

<script>
    $(document).ready(function() {
        $('form[action="upload_Licenece.php"]').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submit

            const form = $(this)[0];
            const formData = new FormData(form); // Create FormData object
            const row = $(this).closest('tr');

            // Confirm before submitting
            if (!confirm("Are you sure you want to upload and finalize this application?")) return;

            $.ajax({
                url: 'upload_Licenece.php',
                type: 'POST',
                data: formData,
                processData: false, // Important
                contentType: false, // Important
                success: function(response) {
                    console.log("Response from server:", JSON.stringify(response));
                    alert("Server says: " + response);

                    if (response.trim() === "success") {
                        alert("Certificate upload ho gaya ✅");
                        row.hide();
                    } else {
                        alert("Upload failed: " + response);
                    }
                }
            });
        });
    });
</script>

<?php
include('layout/footer.php');
?>