<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('config.php');
    $sql = "Delete FROM user WHERE id = $id";
    // die('delete succes');
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('User Deleted Succesfully');
       history.back();
        </script>";
    }
}