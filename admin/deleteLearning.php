<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('config.php');
    $sql = "Delete FROM licence WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Data Deleted Succesfully');
        window.location.href = 'll_list.php';
        </script>";
    }
}
