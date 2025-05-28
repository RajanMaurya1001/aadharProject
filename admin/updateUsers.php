<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: #1877f2;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #606770;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dddfe2;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 0 2px #e7f3ff;
        }

        .password-strength {
            font-size: 12px;
            color: #606770;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #166fe5;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #606770;
        }

        .login-link a {
            color: #1877f2;
            text-decoration: none;
        }

        .terms {
            font-size: 12px;
            color: #606770;
            text-align: center;
            margin: 15px 0;
        }

        .terms a {
            color: #1877f2;
            text-decoration: none;
        }

        .error-message {
            color: #ff0000;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Password visibility toggle */
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #606770;
        }
    </style>
</head>

<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $password = $_POST['password'];

    $sql = "Update user set 
    name = '$name',
    email = '$email',
    phone = '$phone',
    state = '$state',
    district = '$district'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('User Updated Sucessfully');
        window.location.href = 'users.php';
        </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_sql = "SELECT * FROM user WHERE id = $id";
    $data = mysqli_query($conn, $new_sql);
    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_assoc($data);
    }
}
?>




<body>
    <div class="container">
        <h1>Update User</h1>

        <form id="registrationForm" method="post" action="">
            <div class="form-group">
                <input type="hidden" name="id" placeholder="Enter your full name" id="name" value="<?= $row['id'] ?>">

                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" id="name" value="<?= $row['name'] ?>">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" id="email" value="<?= $row['email'] ?>">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" placeholder="Enter your phone number" id="phone" value="<?= $row['phone'] ?>">
            </div>

            <div class="form-group">
                <label>Enter State</label>
                <input type="text" name="state" placeholder="Enter your phone number" id="state" value="<?= $row['state'] ?>">
            </div>

            <div class="form-group">
                <label>Enter District</label>
                <input type="text" name="district" placeholder="Enter your phone number" id="district" value="<?= $row['district'] ?>">
            </div>

            <button type="submit" id="member_amount">Update</button>
        </form>


    </div>
</body>

</html>