<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('config.php');
    $sql = "Delete FROM aadhar WHERE id = $id";
    // $data = mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Data Deleted Succesfully');
        window.location.href = 'aadharmanual_list.php';
        </script>";
    }
}
