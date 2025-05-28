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
                        <h5 class="mb-0">All AADHAAR MANUAL LIST</h5>
                    </div>

                </div>
                <hr>
                <div class="table-responsive">
                    <table id="example2" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">SL.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">AADHAAR NUMBER</th>
                                <th class="text-center">DATE</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">REMARK</th>

                                <th class="text-center">ACTION</th>
                                <!-- <th class="text-center">FILE</th> -->
                                <th class="text-center">Final Submit</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from aadhar where final_submit = 0";
                            $data = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {

                            ?>
                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <td class="text-center name"><?= $row['name'] ?></td>
                                        <td class="text-center user_id" style="display: none;"><?= $row['user_id'] ?></td>
                                        <td class="text-center"><?= $row['aadhar_no'] ?></td>
                                        <td class="text-center phone" style="display:none"><?= $row['phone'] ?></td>
                                        <td class="text-center"><?= date("Y-m-d", strtotime($row['created_at'])) ?></td>
                                        <td class="text-center"><?= $row['status'] ?></td>
                                        <td class="text-center"><?= $row['remark'] ?></td>




                                        <td class="text-center">
                                            <a href="updateAadhar.php?id=<?= $row['id'] ?>">
                                                <button>UPDATE</button>
                                            </a>
                                            <a href="deleteAadhar.php?id=<?= $row['id'] ?>">
                                                <button>DELETE</button>
                                            </a>
                                        </td>

                                        <!-- <td class="text-center">
                                            <a
                                                style="margin-top:2px;margin-bottom:2px;padding-top:2px;padding-bottom:2px;"
                                                class="btn btn-success"
                                                href="aadhardownload.php?file=<?= $row['id'] ?>"
                                                target="_blank">
                                                Print
                                            </a>
                                        </td> -->


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
                                                <form method="POST" action="aadhar_submit.php" onsubmit="return confirm('Are you sure you want to finalize this?');">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <button type="submit" name="aadhar_submit" style="background-color: red;">Final Submit</button>
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

//for status update
<script>
    // jQuery AJAX Code (header में jQuery include करें)
    $(document).ready(function() {
        $('.status-dropdown').on('change', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            var name = $(this).closest('tr').find('.name').text().trim();
            var phone = $(this).closest('tr').find('.phone').text().trim();
            var user_id = $(this).closest('tr').find('.user_id').text().trim();
            var remark = $(this).closest('tr').find('.remark-textarea').val().trim();

            $.ajax({
                url: 'update_status_aadhar.php',
                method: 'POST',
                data: {
                    id: id,
                    status: status,
                    name: name,
                    phone: phone,
                    remark: remark,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Status updated successfully!, Message Sent');
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
            xhr.open("POST", "update_aadhar_remark.php", true);
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