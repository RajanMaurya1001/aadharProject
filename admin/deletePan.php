<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('config.php');
    $sql = "Delete FROM pan WHERE id = $id";
    // $data = mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Data Deleted Succesfully');
        window.location.href = 'pan_manual_list.php';
        </script>";
    }
}
