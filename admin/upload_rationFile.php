<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['certificate']['tmp_name'];
        $fileName = basename($_FILES['certificate']['name']);
        $uploadDir = "../assets/certificates/";

        // Directory check and create
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $targetPath = $uploadDir . time() . "_" . $fileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            // Escape file path for safety
            $safePath = mysqli_real_escape_string($conn, $targetPath);
            $safeId = (int)$id;

            // Update database using procedural style
            $sql = "UPDATE ration SET certificate_file = '$safePath' WHERE id = $safeId";
            if (mysqli_query($conn, $sql)) {
                echo "success"; // 👈 AJAX ke liye plain text
            } else {
                echo "Database update failed.";
            }
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file selected.";
    }
}