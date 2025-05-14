<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('config.php');
    $sql = "Delete FROM birth_certificate WHERE id = $id";
    // $data = mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Data Deleted Succesfully');
        window.location.href = 'birth_death_apply_list.php';
        </script>";
    }
}
