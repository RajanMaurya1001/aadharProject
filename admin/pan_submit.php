
<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pan_submit'])) {
    $id = intval($_POST['id']);

    // Check if status is Approved or Rejected and certificate file exists
    $check = mysqli_query($conn, "SELECT * FROM pan WHERE id = $id AND (status = 'Approved' OR status = 'Rejected') AND certificate_file IS NOT NULL AND certificate_file != ''");

    if (mysqli_num_rows($check) > 0) {
        $update = mysqli_query($conn, "UPDATE pan SET final_submit = 1 WHERE id = $id");

        if ($update) {
            // You can add logging or success notification here
        } else {
            // You can handle error if needed
        }
    }
}

// Redirect back to list page
header("Location: pan_manual_list.php");
exit();
