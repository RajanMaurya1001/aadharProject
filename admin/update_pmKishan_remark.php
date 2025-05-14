<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $remark = $_POST['remark'];

    $stmt = $conn->prepare("UPDATE pm_kissan SET remark = ? WHERE id = ?");
    $stmt->bind_param("si", $remark, $id);

    if ($stmt->execute()) {
        echo "Remark updated.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
