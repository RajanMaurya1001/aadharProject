<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '1' && $_SESSION['role'] !== 1) {
    die("Access Denied!");
}
$id = $_SESSION['id'];
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
                                <th>user Id</th>
                                <th class="text-center">Ration Number</th>
                                <th class="text-center">Apply Date</th>
                                <th class="text-center">Applicant Name</th>
                                <th class="text-center">state</th>
                                <th class="text-center">district</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Action</th>
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select * from ration";
                            $data = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {

                            ?>
                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <td class="text-center user_id"><?= $row['user_id'] ?></td>
                                        <td class=" text-center"><?= $row['ration_number'] ?></td>
                                        <td class="text-center"><?= date("Y-m-d", strtotime($row['created_at'])) ?></td>
                                        <td class="text-center applicant_name"><?= $row['applicant_name'] ?></td>
                                        <td class="text-center"><?= $row['state'] ?></td>
                                        <td class="text-center phone" style="display: none;"><?= $row['phone'] ?></td>
                                        <td class="text-center"><?= $row['district'] ?></td>
                                        <td class="text-center">
                                            <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>">
                                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="Process" <?= $row['status'] == 'Process' ? 'selected' : '' ?>>Process</option>
                                                <option value="Approved" <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                                <option value="Rejected" <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea class="remark-textarea remark" data-id="<?= $row['id']; ?>" rows="2"><?= htmlspecialchars($row['remark']); ?></textarea>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="updateRation.php?id=<?= $row['id'] ?>">
                                                    <button>UPDATE</button>
                                                </a>
                                                <a href="deleteRation.php?id=<?= $row['id'] ?>">
                                                    <button>DELETE</button>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="upload_rationFile.php" method="POST" enctype="multipart/form-data">
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
<!--end page wrapper -->



<script>
    // jQuery AJAX Code (header में jQuery include करें)
    $(document).ready(function() {
        $(document).on('change', '.status-dropdown', function() {
            var $dropdown = $(this); // Store reference to the current dropdown
            var status = $dropdown.val();
            var id = $dropdown.data('id');
            var row = $(this).closest('tr');
            var user_id = row.find('td:eq(1)').text().trim();

            // var user_id = $(this).closest('tr').find('.user_id').text().trim();
            var applicant_name = $dropdown.closest('tr').find('.applicant_name').text().trim();
            var phone = $dropdown.closest('tr').find('.phone').text().trim();
            var remark = $dropdown.closest('tr').find('.remark-textarea').val().trim();

            $.ajax({
                url: 'update_status_ration.php',
                method: 'POST',
                data: {
                    id: id,
                    user_id: user_id,
                    status: status,
                    applicant_name: applicant_name,
                    phone: phone,
                    remark: remark
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

                error: function(xhr, status, error) {
                    $dropdown.val($dropdown.data('previous-value'));
                    alert('AJAX Error: ' + error);
                }
            });
        });

        // Store initial values when page loads
        $('.status-dropdown').each(function() {
            $(this).data('previous-value', $(this).val());
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
            xhr.open("POST", "update_Ration_remark.php", true);
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

<?php
include('layout/footer.php');
?>