<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '1' && $_SESSION['role'] !== 1) {
    die("Access Denied!");
}
include 'layout/header.php';
?>


<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Search PAN No</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">New APPLY</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <h6 class="mb-0 text-uppercase">INSTNAT PAN NO FIND SERVICE
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-id-card me-1 font-22 text-primary"></i>
                                </div>
                                <h5 class="mb-0 text-primary">Enter AADHAAR NO TO GET INSTANT PAN NO</h5>
                            </div>
                            <hr>
                            <form action="" method="POST" class="row g-3">

                                <div class="col-md-3">
                                    <label for="inputLastName" class="form-label">AADHAAR No</label>
                                    <input name="aadhaar_no" type="text" id="aadhaar_no" placeholder="Enter 12 Digit AADHAAR  no" class="form-control">
                                    <input type="hidden" name="check" value="aadhaar">
                                </div>

                                <div class="col-12 ml-2">
                                    <h5 class="text-warning ">Application Fee: ₹20</h5>

                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Verify Now</button>
                                </div>
                                <!-- Result Section -->
                            </form>
                        </div>
                    </div>
            </div>
        </div>

    </div>
</div>

<?php

include('layout/footer.php');
?>