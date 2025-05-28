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


<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">All Birth PDF LIST</h5>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="example2" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">SL.</th>
                                <th class="text-center">Application No</th>
                                <th class="text-center">Apply Date</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Father Name</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Action</th>
                                <th class="text-center">Final Submit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM birth_certificate WHERE final_submit = 0";
                            $data = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <td class="text-center"><?= $row['application_no'] ?></td>
                                        <td class="text-center"><?= date("Y-m-d", strtotime($row['created_at'])) ?></td>
                                        <td class="text-center"><?= $row['name'] ?></td>
                                        <td class="text-center"><?= $row['phone'] ?></td>
                                        <td class="text-center"><?= $row['fName'] ?></td>
                                        <td class="text-center"><?= $row['dob'] ?></td>
                                        <td class="text-center" style="display: none;"><?= $row['user_id'] ?></td>
                                        <td class="text-center"><?= $row['status'] ?></td>
                                        <td class="text-center"><?= $row['remark'] ?></td>

                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="updateBirth.php?id=<?= $row['id'] ?>">
                                                    <button>UPDATE</button>
                                                </a>
                                                <a href="deleteBirth.php?id=<?= $row['id'] ?>">
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
                                                <form method="POST" action="final_submit.php" onsubmit="return confirm('Are you sure you want to finalize this?');">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <button type="submit" name="final_submit" style="background-color: red;">Final Submit</button>
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
<!--end page wrapper -->



<script>
    // jQuery AJAX Code (header में jQuery include करें)
    $(document).ready(function() {
        $('.status-dropdown').on('change', function() {
            var status = $(this).val();
            var id = $(this).data('id');

            var row = $(this).closest('tr');

            // Get the name and phone from appropriate td indexes
            var name = row.find('td:eq(3)').text().trim(); // 0-based index: 3 => name
            var phone = row.find('td:eq(4)').text().trim();
            var user_id = row.find('td:eq(7)').text().trim();

            var remark = row.find('.remark-textarea').val().trim();



            $.ajax({
                url: 'update_status.php',
                method: 'POST',
                data: {
                    id: id,
                    status: status,
                    name: name,
                    phone: phone,
                    remark: remark,
                    user_id: user_id
                },
                success: function(response) {
                    alert('Status updated successfully, Message sent!');
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
            xhr.open("POST", "update_remark.php", true);
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
        $('form[action="upload_certificate.php"]').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submit

            const form = $(this)[0];
            const formData = new FormData(form); // Create FormData object
            const row = $(this).closest('tr');

            // Confirm before submitting
            if (!confirm("Are you sure you want to upload and finalize this application?")) return;

            $.ajax({
                url: 'upload_certificate.php',
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
include 'layout/footer.php';
?>