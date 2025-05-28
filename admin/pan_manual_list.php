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
                        <h5 class="mb-0">All RASAN PDF LIST</h5>
                    </div>

                </div>
                <hr>
                <div class="table-responsive">
                    <table id="example2" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">SL.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">PAN NUMBER</th>
                                <th class="text-center">FATHER</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Action</th>
                                <!-- <th class="text-center">File</th> -->
                                <th class="text-center">Final Submit</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "select * from pan where final_submit = 0";
                            $data = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {

                            ?>
                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-2">
                                                    <h6 class="mb-1 font-14 name"><?= $row['name'] ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center phone" style="display: none;"><?= $row['phone'] ?></td>
                                        <td class="text-center"><?= $row['pan_no'] ?></td>
                                        <td class="text-center"><?= $row['fName'] ?></td>
                                        <td class="text-center"><?= date("Y-m-d", strtotime($row['created_at'])) ?></td>
                                        <td class="text-center user_id" style="display: none;"><?= $row['user_id'] ?></td>4
                                        <td class="text-center"><?= $row['status'] ?></td>
                                        <td class="text-center"><?= $row['remark'] ?></td>

                                        <td>
                                            <a href="updatePan.php?id=<?= $row['id'] ?>">
                                                <button>UPDATE</button>
                                            </a>
                                            <a href="deletePan.php?id=<?= $row['id'] ?>">
                                                <button>DELETE</button>
                                            </a>
                                        </td>


                                        <!-- <td class="text-center">
                                            <a
                                                style="margin-top:2px;margin-bottom:2px;padding-top:2px;padding-bottom:2px;"
                                                class="btn btn-success"
                                                href="utipanformate.php?file=<?= $row['id'] ?>"
                                                target="_blank">
                                                Print
                                            </a>
                                        </td> -->

                                        <td>
                                            <?php if (!empty($row['certificate_file']) && ($row['status'] == 'Approved' || $row['status'] == 'Rejected')): ?>
                                                <form method="POST" action="pan_submit.php" onsubmit="return confirm('Are you sure you want to finalize this?');">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <button type="submit" name="pan_submit" style="background-color: red;">Final Submit</button>
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
    $(document).ready(function() {
        $('.status-dropdown').on('change', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            var name = $(this).closest('tr').find('.name').text().trim();
            var phone = $(this).closest('tr').find('.phone').text().trim();
            var user_id = $(this).closest('tr').find('.user_id').text().trim();
            var remark = $(this).closest('tr').find('.remark-textarea').val().trim();

            $.ajax({
                url: 'update_status_pan.php',
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