
<?php



include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aadhar_submit'])) {
    $id = intval($_POST['id']);

    // Fetch current status and certificate_file
    $check = mysqli_query($conn, "SELECT status, certificate_file FROM aadhar WHERE id = $id");
    $row = mysqli_fetch_assoc($check);

    if ($row) {
        $status = $row['status'];
        $certificate = $row['certificate_file'];

        $allowSubmit = false;

        if ($status == 'Rejected') {
            $allowSubmit = true;
        } elseif ($status == 'Approved' && !empty($certificate)) {
            $allowSubmit = true;
        }

        if ($allowSubmit) {
            $update = mysqli_query($conn, "UPDATE aadhar SET final_submit = 1 WHERE id = $id");
            // Optional: handle logging or feedback
        }
    }
}

// Redirect back to list page
header("Location: aadharmanual_list.php");
exit();
