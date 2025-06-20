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
                                        <h3><strong>PM Kishan Land Seeding List </strong></h3>
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
                                                                <th style="color:white">Application Number</th>
                                                                <th style="color:white"> Date</th>

                                                                <th style="color:white">Registration Number</th>
                                                                <th style="color:white">Name</th>
                                                                <th style="color:white; text-align:center;">Status</th>
                                                                <th class="text-center">Remark</th>
                                                                <th class="text-center">Action</th>
                                                                <th class="text-center">finel submit</th>

                                                            </tr>
                                                        </thead>
                                                        <!-- Table data -->
                                                        <tbody>
                                                            <?php
                                                            $sql = "select * from pm_kissan where final_submit = 0";
                                                            $data = mysqli_query($conn, $sql);
                                                            if (mysqli_num_rows($data) > 0) {
                                                                while ($row = mysqli_fetch_assoc($data)) {

                                                            ?>
                                                                    <tr>
                                                                        <td><?= $row['id'] ?></td>
                                                                        <td><?= $row['application_no'] ?></td>
                                                                        <td><?= date("Y-m-d", strtotime($row['created_at'])) ?></td>
                                                                        <td><?= $row['reg_no'] ?></td>
                                                                        <td class="name"><?= $row['name'] ?></td>
                                                                        <td class="user_id" style="display: none;"><?= $row['user_id'] ?></td>
                                                                        <td class="phone" style="display: none;"><?= $row['phone'] ?></td>
                                                                        <td class="text-center"><?= $row['status'] ?></td>


                                                                        <td class="text-center"><?= $row['remark'] ?></td>
                                                                        <td>
                                                                            <div class="d-flex flex-column">
                                                                                <a href="updatePm.php?id=<?= $row['id'] ?>">
                                                                                    <button>UPDATE</button>
                                                                                </a>
                                                                                <a href="deletePm.php?id=<?= $row['id'] ?>">
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
                                                                                <form method="POST" action="pmKishan_submit.php" onsubmit="return confirm('Are you sure you want to finalize this?');">
                                                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                                                    <button type="submit" name="pmKishan_submit" style="background-color: red;">Final Submit</button>
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




<!-- //for status update -->
<script>
    // jQuery AJAX Code (header में jQuery include करें)
    $(document).ready(function() {
        $('.status-dropdown').on('change', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            // Get the row data if needed (if you actually use name, remark, phone)
            var row = $(this).closest('tr');
            var name = row.find('.name').text(); // adjust selector as needed
            var remark = row.find('.remark-textarea').text(); // adjust selector as needed
            var phone = row.find('.phone').text(); // adjust selector as needed
            var user_id = row.find('.user_id').text();

            $.ajax({
                url: 'update_pmkishan_status.php',
                method: 'POST',
                data: {
                    id: id,
                    status: status,
                    name: name,
                    remark: remark,
                    phone: phone,
                    user_id: user_id
                },
                success: function(response) {
                    try {
                        var result = JSON.parse(response);
                        if (result.success) {
                            // Optional: Show success message
                            alert('Status updated successfully! Message Sent');
                            // If you want to update the UI without reloading:
                            // row.find('.status-badge').text(status); // example
                        } else {
                            alert('Error updating status: ' + (result.error || ''));
                        }
                    } catch (e) {
                        alert('Status updated successfully! Message Sent');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Server error: ' + error);
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
            xhr.open("POST", "update_pmKishan_remark.php", true);
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
        $('form[action="upload_pmFile.php"]').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submit

            const form = $(this)[0];
            const formData = new FormData(form); // Create FormData object
            const row = $(this).closest('tr');

            // Confirm before submitting
            if (!confirm("Are you sure you want to upload and finalize this application?")) return;

            $.ajax({
                url: 'upload_pmFile.php',
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