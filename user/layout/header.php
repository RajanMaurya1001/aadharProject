<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>
<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor1 color-header headercolor5">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="" type="image/png" />
    <!--plugins-->
    <link href="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->

    <link rel="stylesheet" href="../assets/css/dark-theme.css" />
    <link rel="stylesheet" href="../assets/css/semi-dark.css" />
    <link rel="stylesheet" href="../assets/css/header-colors.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <title>Welcome TO - Psprint</title>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="../assets/images/logo.png" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">PSPRINT</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="index.php">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">DASHBOARD</div>
                    </a>

                </li>


                <!--Search Pan No END -->
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon">
                        </div>
                        <div class="menu-title">Wallet </div>
                    </a>
                    <ul>
                        <li> <a href="wallet.php"><i class="bx bx-right-arrow-alt"></i>Add balance</a>
                        </li>
                        <li> <a href="recharge_history.php"><i class="bx bx-right-arrow-alt"></i>Recharge History</a>
                        </li>
                        <!-- <li> <a href="wallet_history.php"><i class="bx bx-right-arrow-alt"></i>Wallet History</a> -->
                </li>

            </ul>
            </li>



            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title"> Birth Certificate <sup style="color:red;"></sup> </div>
                </a>
                <ul>
                    <li> <a href="birth_death_apply.php"><i class="bx bx-right-arrow-alt"></i>Apply</a>
                    </li>

                    <li> <a href="birth_death_apply_list.php"><i class="bx bx-right-arrow-alt"></i> Status</a>
                    </li>
                </ul>
            </li>




            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title">Ration to Aadhar (UP)<sup style="color:red;"></sup> </div>
                </a>
                <ul>


                    <li> <a href="ration2_uid_finder.php"><i class="bx bx-right-arrow-alt"></i>Apply</a>
                    </li>
                    <li> <a href="ration2_uid_finder_list.php"><i class="bx bx-right-arrow-alt"></i> Status</a>
                    </li>


                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title">PM Kishan Seeding<sup style="color:red;"></sup> </div>
                </a>
                <ul>


                    <li> <a href="pm_kishan.php"><i class="bx bx-right-arrow-alt"></i>Apply</a>
                    </li>

                    <li> <a href="pm_kishan_list.php"><i class="bx bx-right-arrow-alt"></i> Status</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title">Learning Licence</div>
                </a>
                <ul>
                    <li> <a href="ll.php"><i class="bx bx-right-arrow-alt"></i>Apply</a>
                    </li>
                    <li> <a href="ll_list.php"><i class="bx bx-right-arrow-alt"></i>Status</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title">ADHAR MANUAL</div>
                </a>
                <ul>
                    <li> <a href="aadharmanual.php"><i class="bx bx-right-arrow-alt"></i>Manual Aadhar</a>
                    </li>
                    <li> <a href="aadharmanual_list.php"><i class="bx bx-right-arrow-alt"></i>Status</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title">INSTANT PAN NO FIND</div>
                </a>
                <ul>
                    <li> <a href="panfind_apiz.php"><i class="bx bx-right-arrow-alt"></i> Server 1</a>
                    </li>

                    <li> <a href="instant_pan.php"><i class="bx bx-right-arrow-alt"></i> Server 2</a>
                    </li>

                </ul>
            </li>



            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                    </div>
                    <div class="menu-title">PAN CARD MANUAL</div>
                </a>
                <ul>
                    <li> <a href="pan_manual.php"><i class="bx bx-right-arrow-alt"></i> PAN MANUAL</a>
                    </li>

                    <li> <a href="pan_manual_list.php"><i class="bx bx-right-arrow-alt"></i>Status</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="../logout.php" class="">
                    <div class="parent-icon"><i class="bx bx-dollar"></i>
                    </div>
                    <div class="menu-title">Logout</div>
                </a>

            </li>
            </ul>
        </div>

        <?php
        $id = $_SESSION['id'];
        include('config.php');
        ?>

        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">



                    </div>
                    <div style="margin-right:12px;" class="text-success">
                        <style>
                            #time {
                                color: white;
                                font-size: 18px;
                                font-family: "Times New Roman", Times, serif;
                            }
                        </style>
                        <a id="time"></a>
                        <script>
                            var timeDisplay = document.getElementById("time");

                            function refreshTime() {
                                var dateString = new Date().toLocaleString("en-IN", {
                                    timeZone: "Asia/Kolkata"
                                });
                                var formattedString = dateString.replace(", ", " - ");
                                timeDisplay.innerHTML = formattedString;
                            }

                            setInterval(refreshTime, 1000);
                        </script>
                    </div>

                    <?php
                    $amountt = 0;

                    $amount_sql = "Select * from wallet where user_id=$id";
                    $amount_data = mysqli_query($conn, $amount_sql);
                    if (mysqli_num_rows($amount_data) > 0) {
                        while ($row = mysqli_fetch_assoc($amount_data)) {
                            $amountt += $row['amount'];
                        }
                    }
                    $total_amount = $amountt;

                    $checkMainWallet = "SELECT * FROM total_wallet_balence WHERE user_id='$id'";
                    $dataOfMainWallet = mysqli_query($conn, $checkMainWallet);
                    $resData = mysqli_fetch_assoc($dataOfMainWallet);
                    $mainAmount =  isset($resData['wallet_balence']) ? $resData['wallet_balence'] : 0;


                    ?>
                    <a class="btn btn-warning" href="wallet.php">Wallet: ₹<?= isset($mainAmount) ? $mainAmount : "0" ?></a>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">

                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
                                        class="alert-count">7</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class="bx bx-group"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Customers<span
                                                            class="msg-time float-end">14 Sec
                                                            ago</span></h6>
                                                    <p class="msg-info">5 new user registered</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i
                                                        class="bx bx-cart-alt"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Orders <span class="msg-time float-end">2
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">You have recived new orders</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class="bx bx-file"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">The pdf files generated</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class="bx bx-send"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Time Response <span
                                                            class="msg-time float-end">28 min
                                                            ago</span></h6>
                                                    <p class="msg-info">5.1 min avarage time response</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-info text-info"><i
                                                        class="bx bx-home-circle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Product Approved <span
                                                            class="msg-time float-end">2 hrs ago</span></h6>
                                                    <p class="msg-info">Your new product has approved</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i
                                                        class="bx bx-message-detail"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Comments <span class="msg-time float-end">4
                                                            hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">New customer comments recived</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class='bx bx-check-square'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Your item is shipped <span
                                                            class="msg-time float-end">5 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">Successfully shipped your item</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class='bx bx-user-pin'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New 24 authors<span
                                                            class="msg-time float-end">1 day
                                                            ago</span></h6>
                                                    <p class="msg-info">24 new authors joined last week</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class='bx bx-door-open'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Defense Alerts <span
                                                            class="msg-time float-end">2 weeks
                                                            ago</span></h6>
                                                    <p class="msg-info">45% less alerts last 4 weeks</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Notifications</div>
                                    </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
                                        class="alert-count">0</span>
                                    <i class='bx bx-comment'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Messages</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-message-list">


                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Messages</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../template/ahkweb/assets/images/avatars/avatar-2.png" class="user-img"
                                alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">IT DEPARTMENT</p>
                                <p class="designattion mb-0"></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i
                                        class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class="bx bx-cog"></i><span>Settings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class='bx bx-home-circle'></i><span>Dashboard</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class='bx bx-dollar-circle'></i><span>Earnings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class='bx bx-download'></i><span>Downloads</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="../includes/logout.php"><i
                                        class='bx bx-log-out-circle'></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>