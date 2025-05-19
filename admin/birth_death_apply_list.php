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
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from birth_certificate ";
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
                                                <a href="updateBirth.php?id=<?= $row['id'] ?>">
                                                    <button>UPDATE</button>
                                                </a>
                                                <a href="deleteBirth.php?id=<?= $row['id'] ?>">
                                                    <button>DELETE</button>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="upload_certificate.php" method="POST" enctype="multipart/form-data">
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

<?php
include 'layout/footer.php';
?>