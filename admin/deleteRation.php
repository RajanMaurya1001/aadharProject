<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('config.php');
    $sql = "Delete FROM ration WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Data Deleted Succesfully');
       history.back();
        </script>";
    }
}
