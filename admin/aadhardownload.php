<html lang="hi">

<head>
  <title>PDF</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <script>
    window.onload = function() {
      window.print();
    }
  </script>

  <style type="text/css">
    body {
      font-family: 'Roboto', sans-serif;
    }

    h1,
    h2,
    h3,
    h4 {
      font-family: 'Open Sans', sans-serif;
    }

    .clr {
      clear: both;
    }

    .pdf {
      /*width: 650px;*/
      width: 680px;
      height: 845px;
      border: solid 2px;
      margin: 10% auto;
    }

    .left {
      width: 48.7%;
      float: left;
      border-right: solid 2px;
      height: 100%;
    }

    .right {
      width: 48.8%;
      float: left;
      border-left: solid 2px;
      height: 100%;
    }

    .cntr {
      float: left;

    }

    img {
      width: 100%;
    }

    .img4 {
      /*
      border-bottom: solid #e70000;
      */
    }

    p {
      font-size: 12px;
      text-align: center;
      margin: 0;
    }

    .rtt {
      float: left;
      width: 15%;
    }

    .rtt_rt {
      float: left;
      width: 146%;
      padding-left: 18%;
      margin-top: -10%;
    }

    .rtt p,
    .brcd p {
      transform: rotate(90deg);
      margin-top: 25px;
      font-size: 9px;
      font-weight: bold;
    }

    ul li {
      font-size: 10px;
      list-style: none;
      line-height: 11px;
    }

    ul {
      padding: 0;
      margin-top: 5px;
    }

    .vld {
      float: left;
      width: 52%;
      text-align: right;
    }

    .brcd {
      float: left;
      width: 26%;
      background: url("../assets/aadharPvc/q.jpg") no-repeat;
      background-size: 50px;
      margin-top: 100px;
      padding-left: 15px;
      background-position-x: center;
    }

    .brcd.print {
      display: list-item;
      list-style-image: url("../assets/aadharPvc/q.jpg");
      list-style-position: inside;
    }

    .prnt {
      position: absolute;
      margin-top: -60px;
    }

    .vld img {
      width: 153px;
      padding-top: 32px;
    }

    h4 span,
    h2 span {
      color: #e70000;
    }

    h4 {
      font-size: 14px;
      text-align: center;
      padding-top: 20px;
      margin: 0;
    }

    h3 {
      margin: 0 0 4px;
      text-align: center;
    }

    h3 span {
      border-bottom: solid 0;
    }

    h2 {
      text-align: center;
      font-size: 18px;
      letter-spacing: 1px;
      font-weight: 500;
      margin: 0;
      border-bottom: solid #e70000;
    }

    .img2 {
      /*
      border-top: dashed 1px;
      */
      margin-top: 5px;
      padding: 5px 0;
    }

    img.cut-008 {
      height: 8px;
    }

    .a_lft {
      width: 20%;
      float: left;
      padding: 0 15px;
      padding-left: 24px;
    }

    .a_rgt {
      width: 68%;
      float: left;
    }

    .a_rgt ul {
      margin-top: 0;
      margin-bottom: 0;
    }

    .a_rgt img {
      width: 75px;
      float: right;
      position: absolute;
      margin: 25px 140px 0;
    }

    .adhr h2 {
      font-size: 14px;
      border-top: solid #e70000 2px;
      border-bottom: 0;
    }

    .adhr p {
      font-size: 10px;
    }

    .adhr h3 {
      font-size: 16px;
    }

    .img6 {
      margin-top: 0px;
      height: 23px;
    }

    .adhr .brcd {
      width: 5%;
    }

    .adhr .brcd p {
      font-size: 6px;
      margin-top: 10px;
    }

    .b_rgt {
      width: 36%;
      float: right;
    }

    .b_lft {
      width: 64%;
      float: left;
      max-height: 112px;
      margin-top: 0%;
    }

    .adhr2 ul li {
      font-size: 10px;
      line-height: 10px;
    }

    .adhr2 ul {
      padding: 0;
      margin: 0;
      margin-bottom: 8px;
      margin-left: 10px;
    }

    .adhr2 ul li span {
      font-weight: bold;
    }

    .blank {
      min-height: 124px;
    }

    .adhr h3 span {
      border-bottom: solid 0px;
    }

    .cut {
      width: 12px;
      position: absolute;
      padding: 2px 0px 0px 5px;
    }

    .cut2 {
      position: absolute;
      width: 8px;
      margin: 8px 0 0 -4px;
    }

    .brcd h5 {
      margin: 0;
      font-weight: normal;
      font-size: 12px;
    }

    .brcd ul li {
      font-size: 7px;
      line-height: 8px;
    }

    .one {
      height: 500px;
    }

    .two {
      height: 110px;
    }

    .three {
      height: 178px;
      position: relative;
      margin-top: -11px;
    }

    .rtt_rt ul {
      width: 45%;
    }

    .info h4 {
      color: #f60000;
      letter-spacing: .5px;
      text-transform: uppercase;
      font-size: 12px;
      padding-top: 10px;
    }

    .info ul li,
    .info2 ul li {
      font-size: 11px;
      line-height: 16px;
    }

    .info ul li span,
    .info2 ul li span {
      color: #f60000;
    }

    .info2 ul li {
      padding: 4px 0;
    }

    .info2,
    .info {
      padding: 0 20px;
    }

    .info li::before,
    .info2 li::before {
      content: "■";
      color: #D60F26;
      font-size: 12px;
      padding-right: 5px;
    }

    .info2 ul {
      border: solid 1px #666;
      padding: 5px;
    }

    .info2 {
      padding: 0 15px;
    }

    .info2 ul li .brk,
    .info ul li .brk {
      color: #333;
      padding-left: 12px;
    }

    .img7 {
      border-top: solid #e70000 2px;
      height: 18px;
      padding-top: 2px;
    }

    img.img2.img--013 {
      padding: 0;
      width: 332px;
      padding-left: 1px;
    }

    img.img6.image--010 {
      border: 0px;
      padding: 0px;
    }

    .right img.cut-008 {
      margin-left: 1px;
    }

    img.cut-verti {
      height: 841px;
      width: 10px;
    }

    p.download-date {
      font-weight: bold;
      transform: rotate(90deg);
      font-size: 7px;
      position: absolute;
      top: 97px;
      left: -31px;
    }

    p.download-date.issue {
      right: -314px;
    }
  </style>
</head>

<?php
// session_start();
// // $user_id = $_SESSION['user_id'];
include('config.php');
$id = $_GET['file'];
$sql = "Select * from aadhar where id=$id";
$data = mysqli_query($conn, $sql);
if (mysqli_num_rows($data) > 0) {
  $row = mysqli_fetch_assoc($data);
}


?>



<body>
  <div class="pdf">
    <div class="left">
      <div class="one">
        <img src="../assets/aadharPvc/image--001.jpg">
        <p> नामांकन क्रम / Enrollment No: 4892/89659/70818 </p>
        <div class="rtt">
          <p>Download&nbsp;Date:&nbsp;15/05/2025</p>
          <div class="clr"></div>
        </div>
        <div class="rtt_rt">
          <ul>
            <li>To</li>
            <li><?= $row['name_local_language'] ?></li>
            <li><?= $row['name'] ?></li>
            <li><?= $row['address'] ?></li>
          </ul>
          <div class="clr"></div>
        </div>

        <div class="rtt">
          <p style="margin-top: 77px;">Issue&nbsp;Date:&nbsp;15/04/2025</p>
          <div class="clr"></div>
        </div>
        <div class="brcd print">
          <div class="prnt">
            <h5>Signature Valid</h5>
            <ul>
              <li>Digitally signed by DS</li>
              <li>UNIQUE IDENTIFICATION</li>
              <li>AUTHORITY OF INDIA 03</li>
              <li>Date: 2019.05.23 03:02:17</li>
              <li>IST</li>
            </ul>
          </div>
          <div class="clr"></div>
        </div>
        <div class="vld">


          <img src="https://quickchart.io/qr?size=200&amp;text=%3C%3Fxml+version%3D%221.0%22+encoding%3D%22UTF-8%22%3F%3E%0A%3Cbooks%3E%3Cbook%3E%3CPrintLetterBarcodeData+uid%3D%22228538344040%22+name%3D%22Rajan%22+gender%3D%22M%22+dob%3D%2226%2F07%2F2004%22+co%3D%22Father%22+po%3D%22%22+address%3D%22S%2FO+%3A+Father%2C+50%2C+Ijarahi%2C+Deoria%2C+Deoria%2C+UP%2C+274001%22+pc%3D%22%22%2F%3E%3C%2Fbook%3E%3C%2Fbooks%3E%0A"
            title="QR Code">



          <div class="clr"></div>
        </div>

        <div class="clr"></div>

      </div> <!--one-->

      <div class="two">
        <img src="../assets/aadharPvc/image--002.png" class="aapka-aadhar">

        <h3><span><?= $row['aadhar_no'] ?></span></h3>

        <img src="../assets/aadharPvc/image--003.png" class="meri-image">

      </div> <!--two-->

      <div class="adhr">
        <img src="../assets/aadharPvc/image--008.png" class="cut-008">
        <div class="three">
          <p class="download-date">Download&nbsp;Date:&nbsp;15/04/2025</p>
          <img src="../assets/aadharPvc/image--009.jpg" class="img2">
          <div class="a_lft">
            <img src="../assets/upload/<?= $row['image'] ?>">
          </div>
          <div class="a_rgt">
            <ul>
              <li><?= $row['name_local_language'] ?></li>
              <li><?= $row['name'] ?></li>
              <li><?= $row['birth_address'] ?> / DOB : <?= $row['dob'] ?></li>
              <li><?= $row['gender_local'] ?> / MALE</li>
            </ul>

            <p class="download-date issue">Issue&nbsp;Date:&nbsp;15/04/2025</p>
          </div>
        </div> <!--three-->
        <h3><span><?= $row['aadhar_no'] ?></span></h3>
        <!-- <h2>मेरा <span>आधार</span>, मेरी पहचान</h2> -->
        <img src="../assets/aadharPvc/image--010.jpg" class="img6 image--010">
      </div>

      <div class="clr"></div>
    </div>
    <div class="cntr">
      <img src="../assets/aadharPvc/image--004.png" class="cut-verti">
      <div class="clr"></div>
    </div>
    <div class="right">
      <div class="one">
        <img src="../assets/aadharPvc/image--005.jpg" class="img4">
        <img src="../assets/aadharPvc/image--006.jpg" class="img4">

      </div> <!--one-->
      <div class="two"></div>

      <div class="adhr adhr2">
        <img src="../assets/aadharPvc/image--012.png" class="cut-008">
        <div class="three">
          <img src="../assets/aadharPvc/image--013.jpg" class="img2 img--013">
          <div class="b_lft">
            <ul>
              <li><span>पता:</span></li>
              <li><?= $row['address_local_language'] ?></li>
            </ul>
            <ul>
              <li><span>Address:</span></li>
              <li><?= $row['address'] ?></li>
            </ul>
          </div>
          <div class="b_rgt">


            <img
              src="https://quickchart.io/qr?size=200&amp;text=%3C%3Fxml+version%3D%221.0%22+encoding%3D%22UTF-8%22%3F%3E%0A%3Cbooks%3E%3Cbook%3E%3CPrintLetterBarcodeData+uid%3D%22228538344040%22+name%3D%22Rajan%22+gender%3D%22M%22+dob%3D%2226%2F07%2F2004%22+co%3D%22Father%22+po%3D%22%22+address%3D%22S%2FO+%3A+Father%2C+50%2C+Ijarahi%2C+Deoria%2C+Deoria%2C+UP%2C+274001%22+pc%3D%22%22%2F%3E%3C%2Fbook%3E%3C%2Fbooks%3E%0A">



          </div>

          <div class="clr"></div>
        </div> <!--three-->
        <h3><span><?= $row['aadhar_no'] ?></span></h3>
        <img src="../assets/aadharPvc/image--015.png" class="img6">
      </div>

      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>

</body>

</html>