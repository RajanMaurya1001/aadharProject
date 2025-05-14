<?php

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== '0' && $_SESSION['role'] !== 0) {
    die("Access Denied!");
}

include 'layout/header.php';
?>


<!--start page wrapper -->
<style>
    .pointer {
        cursor: pointer;
    }
</style>





<div class="page-wrapper">

    <div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">


            <!-- ration_aadhar.php   price  Ration to Aadhar -->



            <a href="ll.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-ibiza">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹100</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Learning Licence Exam</p>
                                <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!--
              
                   <div class="col pointer">
                       <div class="card radius-10 bg-gradient-ohhappiness">
                           <div class="card-body">
                               <div class="d-flex align-items-center">
                                   <h5 class="mb-0 text-white">₹</h5>
                                   <div class="ms-auto">
                                       <i class='bx bx-id-card fs-3 text-white'></i>
                                   </div>
                               </div>
                               <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                   <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                       aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                               </div>
                               <div class="d-flex align-items-center text-white">
                                   <p class="mb-0"></p>
                                   <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </a> 

              
              
             
                   <div class="col pointer">
                       <div class="card radius-10 bg-gradient-ibiza">
                           <div class="card-body">
                               <div class="d-flex align-items-center">
                                   <h5 class="mb-0 text-white">₹</h5>
                                   <div class="ms-auto">
                                       <i class='bx bx-id-card fs-3 text-white'></i>
                                   </div>
                               </div>
                               <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                   <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                       aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                               </div>
                               <div class="d-flex align-items-center text-white">
                                   <p class="mb-0"></p>
                                   <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </a>
              
              
                  
             
                   <div class="col pointer">
                       <div class="card radius-10 bg-gradient-moonlit">
                           <div class="card-body">
                               <div class="d-flex align-items-center">
                                   <h5 class="mb-0 text-white">₹</h5>
                                   <div class="ms-auto">
                                       <i class='bx bx-id-card fs-3 text-white'></i>
                                   </div>
                               </div>
                               <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                   <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                       aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                               </div>
                               <div class="d-flex align-items-center text-white">
                                   <p class="mb-0"></p>
                                   <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </a> 
              
               <a href="">
                   <div class="col pointer">
                       <div class="card radius-10 bg-gradient-deepblue">
                           <div class="card-body">
                               <div class="d-flex align-items-center">
                                  <h5 class="mb-0 text-white">₹</h5>
                                   <div class="ms-auto">
                                       <i class='bx bx-id-card fs-3 text-white'></i>
                                   </div>
                               </div>
                               <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                   <div class="progress-bar bg-white" role="progressbar"
                                       style="width: %" aria-valuenow="90"
                                       aria-valuemin="0" aria-valuemax="100"></div>
                               </div>
                               <div class="d-flex align-items-center text-white">
                                   <p class="mb-0"></p>
                                   <p class="mb-0 ms-auto"><span><i
                                               class='bx bx-up-arrow-alt'></i></span></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </a> 
              
              -->

            <!-- <a href="aadhar_advance_print.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ohhappiness">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹15</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">AADHAR ADVANCE</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->





            <!-- <a href="puc.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-deepblue">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹60 , ₹90</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">PUC CERTIFICATE</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->




            <!-- <a href="challan_Axen.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-moonlit">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹5</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Challan Find</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->




            <a href="pm_kishan.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-ibiza">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹500</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">PM Kishan (Seeding)</p>
                                <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>






            <!-- <a href="https://psprint.xyz/admin/voter_adv_hkb.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ohhappiness">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹5</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">VOTER ADVANCE</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <a href="ration2_uid_finder.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-deepblue">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹60</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Ration to Aadhar (UP)</p>
                                <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>


            <!-- <a href="https://psprint.xyz/admin/panfind_apiz.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-moonlit">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹15</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">PAN NO FIND</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="https://psprint.xyz/admin/vote_mob_link.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ibiza">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹5</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">VOTER MOBILE NO LINK</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="https://psprint.xyz/admin/vot_org_instant.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ohhappiness">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹5</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">VOTER ORIGNAL PDF</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="https://psprint.xyz/admin/Ration_Pdf_hkb.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-deepblue">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹6</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">RATION PDF</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="https://psprint.xyz/admin/rcprint_apiz.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-moonlit">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹8</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">RC Vehical PDF</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->



            <!-- <a href="DL_Instant_Hkb.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ibiza">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹8</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">DL PRINT</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <a href="https://psprint.xyz/admin/Pan_Advance_Axen.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-ohhappiness">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹5</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar"
                                    style="width: %" aria-valuenow="90"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">PAN MANUAL</p>
                                <p class="mb-0 ms-auto"><span><i
                                            class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>


            <a href="https://psprint.xyz/admin/aadharmanual.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-deepblue">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹5</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">AADHAR MANUAL</p>
                                <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>



            <a href="https://psprint.xyz/admin/pandetails_apiz.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-moonlit">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹8</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar"
                                    style="width: %" aria-valuenow="90"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">PAN DETAILS</p>
                                <p class="mb-0 ms-auto"><span><i
                                            class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>



            <!-- <a href="dlprint_apiz.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ibiza">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹8</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">DL PDF 2</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="https://psprint.xyz/admin/voter_manual.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ohhappiness">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹5</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">VOTER MANUAL</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->



            <!-- <a href="https://psprint.xyz/admin/rc_get.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-deepblue">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹10</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">RC PRINT 2</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- 
                    <a href="https://psprint.xyz/admin/instant_pan.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-moonlit">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹20</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">PAN FIND 2</p>
                                        <p class="mb-0 ms-auto"><span><i class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->




            <!-- <a href="UidRation.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ibiza">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹12</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Aadhar to Ration PDF</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->



            <!-- <a href="DLFind_Axen.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ohhappiness">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹15</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">DL NO Find</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="AadhaarConvertPVC_AxenList.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-deepblue">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹10</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Aadhar PDF to PVC PDF</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="passportapply.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-moonlit">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹20</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Passport Manual</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->



            <a href="birth_death_apply.php">
                <div class="col pointer">
                    <div class="card radius-10 bg-gradient-ibiza">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 text-white">₹250</h5>
                                <div class="ms-auto">
                                    <i class='bx bx-id-card fs-3 text-white'></i>
                                </div>
                            </div>
                            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                <div class="progress-bar bg-white" role="progressbar"
                                    style="width: %" aria-valuenow="90"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex align-items-center text-white">
                                <p class="mb-0">Birth Certificate</p>
                                <p class="mb-0 ms-auto"><span><i
                                            class='bx bx-up-arrow-alt'></i></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>


            <!-- <a href="eid_to_aadhaar_no.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-ohhappiness">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹500</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Genrated EID to Aadhar</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->



            <!-- <a href="aadhar_to_pdf.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-deepblue">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹400</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Aadhar No to Aadhar PDF</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->


            <!-- <a href="matching_duplicate.php">
                        <div class="col pointer">
                            <div class="card radius-10 bg-gradient-moonlit">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 text-white">₹300</h5>
                                        <div class="ms-auto">
                                            <i class='bx bx-id-card fs-3 text-white'></i>
                                        </div>
                                    </div>
                                    <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                        <div class="progress-bar bg-white" role="progressbar"
                                            style="width: %" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex align-items-center text-white">
                                        <p class="mb-0">Matching Duplicate to Aadhar</p>
                                        <p class="mb-0 ms-auto"><span><i
                                                    class='bx bx-up-arrow-alt'></i></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> -->



            <!--
 <a href="https://psprint.xyz/admin/eid_to_aadhaar_no.php">
                   <div class="col pointer">
                       <div class="card radius-10 bg-gradient-deepblue">
                           <div class="card-body">
                               <div class="d-flex align-items-center">
                                   <h5 class="mb-0 text-white">₹200</h5>
                                   <div class="ms-auto">
                                       <i class='bx bx-id-card fs-3 text-white'></i>
                                   </div>
                               </div>
                               <div class="progress my-2 bg-white-transparent" style="height:4px;">
                                   <div class="progress-bar bg-white" role="progressbar"
                                       style="width: %" aria-valuenow="90"
                                       aria-valuemin="0" aria-valuemax="100"></div>
                               </div>
                               <div class="d-flex align-items-center text-white">
                                   <p class="mb-0">Matching Duplicate</p>
                                   <p class="mb-0 ms-auto"><span><i
                                               class='bx bx-up-arrow-alt'></i></span></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </a>   -->


        </div>
        <!--end row-->
        <!-- start::Row -->

        <!-- end::Row -->
        <!-- start::Row -->

        <br>
        <!-- end::Row -->

    </div>


</div>
<!--end page wrapper -->

<!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<footer class="page-footer">
    <p class="mb-0">Copyright © 2025. All right reserved. </p>
</footer>
</div>
<!--end wrapper-->
<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>

    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr />
        <h6 class="mb-0">Theme Styles</h6>
        <hr />
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode">
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" checked>
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr />
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr />
        <h6 class="mb-0">Header Colors</h6>
        <hr />
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
            </div>
        </div>
        <hr />
        <h6 class="mb-0">Sidebar Colors</h6>
        <hr />
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end switcher-->
<!-- Bootstrap JS -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="../assets/plugins/chartjs/chart.min.js"></script>
<script src="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="../assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="../assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
<script src="../assets/plugins/jquery-knob/excanvas.js"></script>
<script src="../assets/plugins/jquery-knob/jquery.knob.js"></script>
<script>
    $(function() {
        $(".knob").knob();
    });
</script>
<script src="../assets/js/index.js"></script>
<!--app JS-->
<script src="../assets/js/app.js"></script>
</body>



</html>