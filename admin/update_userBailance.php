<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}
include('config.php');
include 'layout/header.php';
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 100px);
        /* Adjust based on your header height */
        padding: 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .form-container {
        background: white;
        width: 100%;
        max-width: 500px;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        margin: 0 auto;
        /* Added for extra centering */
    }

    .form-container:hover {
        transform: translateY(-5px);
    }

    h2 {
        color: #3a3a3a;
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-size: 14px;
        font-weight: 500;
    }

    input,
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 15px;
        color: #333;
        transition: all 0.3s ease;
    }

    input:focus,
    textarea:focus {
        border-color: #6c63ff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.2);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    button {
        background: linear-gradient(to right, #6c63ff, #8a84ff);
        color: white;
        border: none;
        padding: 14px 20px;
        width: 100%;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
    }

    button:hover {
        background: linear-gradient(to right, #5a52e0, #6c63ff);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 99, 255, 0.4);
    }

    .icon {
        position: absolute;
        right: 15px;
        top: 38px;
        color: #999;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $wallet_balance = $_POST['wallet_balence'];

    $sql = "UPDATE total_wallet_balence SET name = '$name', wallet_balence = '$wallet_balance' where id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Data Updated Successfullly');
        window.location.href = 'user_wallet_manage.php';
        </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_sql = "SELECT * FROM total_wallet_balence WHERE id = $id";
    $data = mysqli_query($conn, $new_sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
    }
}

?>

<div class="page-wrapper">
    <div class="form-container">
        <h2>Contact Us</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="form-group">
                <label for="name">name</label>
                <input type="text" id="name" name="name" required value="<?= $row['name'] ?>">
                <i class="fas fa-user icon"></i>
            </div>

            <div class="form-group">
                <label for="email">Total Balance</label>
                <input type="number" id="number" name="wallet_balence" required value="<?= $row['wallet_balence'] ?>">
            </div>

            <button type="submit">
                Update
            </button>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>