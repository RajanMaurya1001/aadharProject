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
                        <h5 class="mb-0">All Users LIST</h5>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="example2" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">SL.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">District</th>
                                <th class="text-center">State</th>
                                <th class="text-center">Membership Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from user where role = 0";
                            $data = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $row['id'] ?></td>
                                        <td class="text-center"><?= $row['name'] ?></td>
                                        <td class="text-center"><?= $row['email'] ?></td>
                                        <td class="text-center"><?= $row['phone'] ?></td>
                                        <td class="text-center"><?= $row['district'] ?></td>
                                        <td class="text-center"><?= $row['state'] ?></td>
                                        <td class="text-center"><?= $row['membership_amount'] ?></td>


                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="updateUsers.php?id=<?= $row['id'] ?>">
                                                    <button>UPDATE</button>
                                                </a>
                                                <a href="deleteUsers.php?id=<?= $row['id'] ?>">
                                                    <button>DELETE</button>
                                                </a>
                                            </div>
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







<?php
include 'layout/footer.php';
?>