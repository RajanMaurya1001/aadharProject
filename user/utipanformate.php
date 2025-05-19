<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Pan Card Priview</title>
    <link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet">
    <link href="aadhar.css" type="text/css" rel="stylesheet">
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <style type="text/css">
        @media print {
            .bg {
                -webkit-print-color-adjust: exact;
                /* Chrome, Safari */
                print-color-adjust: exact;
                /* Firefox */
                background: url('../assets/panPvc/utipanformate.jpg') no-repeat;

            }
        }

        .bg {
            background: url('../assets/panPvc/utipanformate.jpg') no-repeat;
            width: 800px;
            height: 986px;
            overflow: visible;
            display: block;
            background-size: 100% auto;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
include('config.php');
$id = $_GET['file'];
$sql = "SELECT * FROM pan WHERE id = '$id'";
$data = mysqli_query($conn, $sql);
if (mysqli_num_rows($data) > 0) {
    $row = mysqli_fetch_assoc($data);
}

?>

<main class="bg">
    <style>
        img.mrmins.mrninbigs {

            top: 59px;
            position: absolute;
            left: 247px;

        }

        .cimg {
            top: 85px;
            position: absolute;
            left: 27px;
        }

        .mainno {
            top: 105px;
            position: absolute;
            left: 142px;
            font-weight: 800;
            font-size: 11px;
        }

        .name {
            top: 155px;
            position: absolute;
            left: 37px;
            font-weight: 800;
            font-size: 9px;
        }

        .fathername {
            top: 185px;
            position: absolute;
            left: 38px;
            font-weight: 800;
            font-size: 9px;
        }

        .bod {
            top: 220px;
            position: absolute;
            left: 37px;
            font-weight: 800;
            font-size: 9px;
        }

        .sign {
            top: 210px;
            position: absolute;
            left: 170px;
        }
    </style>



    </p>
    <!-- <img class="mrmins mrninbigs" src='https://chart.googleapis.com/chart?chs=110x110&cht=qr&chl=&chld=L|0&chf=bg,s,FFFFFF00' > -->


    <img class="cimg" src="../assets/panimages/<?= $row['image'] ?>" width="60px" height="60px" />
    <p class="mainno"><B><?= $row['pan_no'] ?></B></p>
    <p class="name"><?= $row['name'] ?></p>
    <p class="fathername"><?= $row['fName'] ?></p>
    <p class="bod"><?= $row['dob'] ?></p>
    <img class="sign" src="../assets/panimages/<?= $row['sign_image'] ?>" width="65px"
        height="25px" />
</main>
</body>

</html>