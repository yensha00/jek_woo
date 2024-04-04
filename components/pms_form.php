<?php
    require_once __DIR__ . '/../conn.php';

    if (!isset($_SESSION['UserID'])) {
        header("location: ../../login");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./asset/pms_style.css" />

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Includes -->
    <?php include "../config/database/functions.php" ?>
    <?php include "../modal/modal.php" ?>
    <!-- End of Includes -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "../navbar/side-bar.php" ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Top Navbar -->
                <?php include "../navbar/navbar-account.php" ?>
                <!-- End of Top Navbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">PMS LAPTOP/DESKTOP
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mb-2">

                              <!-- PMS FORM HEADER CONTAINER -->
                              <form action="javascript:void(0)" method="post" id="create-pms-form">
                                    <div class="container mt-5 bg-light border border-secondary rounded" style="width: 60rem;">
                                        <h1 class="text-center">Preventive Maintenance</h1>
                                        <!-- SELECT QUARTER -->
                                        <div class="row align-items-start">
                                            <div class="col">
                                                <div>
                                                    <div class="dropdown float-start">
                                                        <label for="quarter-dropdown" class="form-label">SELECT QUARTER</label>
                                                        <select id="quarter-dropdown" class="form-select" name="quarter">
                                                            <option value="">---------</option>
                                                            <option value="1">1ST</option>
                                                            <option value="2">2ND</option>
                                                            <option value="3">3RD</option>
                                                            <option value="4">4TH</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TASK ID SEARCH -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="task-id" class="form-label">TASK ID</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="task-id" id="task-id" placeholder="Enter Task ID" autocomplete="on" style="text-transform: uppercase;">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ASSET ID SEARCH -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="asset-id" class="form-label">ASSET ID</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="asset-id" id="asset-id" placeholder="Laptop/Desktop" autocomplete="off" style="text-transform: uppercase;">
                                                        <button class="btn btn-outline-secondary" type="button" id="asset-id-search-btn" form="asset-id-form">
                                                            <i class="bi bi-search"></i>
                                                        </button>
                                                    </div>
                                                    <div id="equipment-code-dropdown" class="dropdown-menu" aria-labelledby="asset-id"></div>
                                                </div>
                                            </div>

                                            <!-- TASK ID SEARCH -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="computer-name" class="form-label">COMPUTER NAME</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="computer-name" id="computer-name" placeholder="Enter Computer Name" autocomplete="on" style="text-transform: uppercase;">
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>

                                        <div class="row align-items-start">
                                            <!-- EMPLOYEE NAME DISPLAY -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="employee-name" class="form-label">EMPLOYEE NAME</label>
                                                    <input type="text" class="form-control" name="employee-name" id="employee-name-pms" disabled>
                                                </div>
                                            </div>

                                            <!-- PROCESSOR DISPLAY -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="processor" class="form-label">PROCESSOR</label>
                                                    <input type="text" class="form-control" name="processor" id="processor-pms" disabled>
                                                </div>
                                            </div>

                                            <!-- RAM DISPLAY -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="ram" class="form-label">RAM</label>
                                                    <input type="text" class="form-control" name="ram" id="ram-pms" disabled>
                                                </div>
                                            </div>

                                            <!-- LOCATION DISPLAY -->
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">LOCATION</label>
                                                    <input type="text" class="form-control" name="location" id="location-pms" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-2 mb-2">
                                            <!-- PMS PERFORM BUTTON -->
                                            <a href="">
                                                <button type="button" class="btn btn-primary btn-lg" id="perform-pms-btn"><i class="bi bi-wrench-adjustable-circle"></i> Perform PMS</button>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PMS FORM BODY CONTAINER -->
                                    <div class="pms-form mt-5" id="pms-form-cont">
                                        <!-- PMS TABLE -->
                                        <table class="pms-table">
                                            <thead>
                                                <tr>
                                                    <th>TASK</th>
                                                    <th>DESCRIPTION</th>
                                                    <th id="ok" title="Mark all as OK"><i class="bi bi-check2" style="font-size: 1.5em;"></i></th>
                                                    <th id="not-ok" title="Mark all as NOT OK"><i class="bi bi-x" style="font-size: 1.5em;"></i></th>
                                                    <th id="none" title="Mark all as N/A">N/A</th>
                                                    <th>REMARKS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- SYSTEM START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="2">SYSTEM</td>
                                                    <td class="pms-text">Check start up errors and speed of entire boot process</td>
                                                    <td><label for="sys1-1" class="table-radio-val-cont"><input type="radio" name="sys1" id="sys1-1" value="ok"></label></td>
                                                    <td><label for="sys1-2" class="table-radio-val-cont"><input type="radio" name="sys1" id="sys1-2" value="not_ok"></label></td>
                                                    <td><label for="sys1-3" class="table-radio-val-cont"><input type="radio" name="sys1" id="sys1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sys1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check log-in process</td>
                                                    <td><label for="sys2-1" class="table-radio-val-cont"><input type="radio" name="sys2" id="sys2-1" value="ok"></label></td>
                                                    <td><label for="sys2-2" class="table-radio-val-cont"><input type="radio" name="sys2" id="sys2-2" value="not_ok"></label></td>
                                                    <td><label for="sys2-3" class="table-radio-val-cont"><input type="radio" name="sys2" id="sys2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sys2-remarks"></textarea></td>
                                                </tr>
                                                <!-- SYSTEM END -->
                                                <!-- NETWORK SETTINGS START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="5">NETWORK SETTINGS</td>
                                                    <td class="pms-text">Check TCP/IP</td>
                                                    <td><label for="net-set1-1" class="table-radio-val-cont"><input type="radio" name="net-set1" id="net-set1-1" value="ok"></label></td>
                                                    <td><label for="net-set1-2" class="table-radio-val-cont"><input type="radio" name="net-set1" id="net-set1-2" value="not_ok"></label></td>
                                                    <td><label for="net-set1-3" class="table-radio-val-cont"><input type="radio" name="net-set1" id="net-set1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="net-set1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check domain name</td>
                                                    <td><label for="net-set2-1" class="table-radio-val-cont"><input type="radio" name="net-set2" id="net-set2-1" value="ok"></label></td>
                                                    <td><label for="net-set2-2" class="table-radio-val-cont"><input type="radio" name="net-set2" id="net-set2-2" value="not_ok"></label></td>
                                                    <td><label for="net-set2-3" class="table-radio-val-cont"><input type="radio" name="net-set2" id="net-set2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="net-set2-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check computer name</td>
                                                    <td><label for="net-set3-1" class="table-radio-val-cont"><input type="radio" name="net-set3" id="net-set3-1" value="ok"></label></td>
                                                    <td><label for="net-set3-2" class="table-radio-val-cont"><input type="radio" name="net-set3" id="net-set3-2" value="not_ok"></label></td>
                                                    <td><label for="net-set3-3" class="table-radio-val-cont"><input type="radio" name="net-set3" id="net-set3-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="net-set3-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check file server folder mapping</td>
                                                    <td><label for="net-set4-1" class="table-radio-val-cont"><input type="radio" name="net-set4" id="net-set4-1" value="ok"></label></td>
                                                    <td><label for="net-set4-2" class="table-radio-val-cont"><input type="radio" name="net-set4" id="net-set4-2" value="not_ok"></label></td>
                                                    <td><label for="net-set4-3" class="table-radio-val-cont"><input type="radio" name="net-set4" id="net-set4-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="net-set4-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check if unit is connected to the network</td>
                                                    <td><label for="net-set5-1" class="table-radio-val-cont"><input type="radio" name="net-set5" id="net-set5-1" value="ok"></label></td>
                                                    <td><label for="net-set5-2" class="table-radio-val-cont"><input type="radio" name="net-set5" id="net-set5-2" value="not_ok"></label></td>
                                                    <td><label for="net-set5-3" class="table-radio-val-cont"><input type="radio" name="net-set5" id="net-set5-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="net-set5-remarks"></textarea></td>
                                                </tr>
                                                <!-- NETWORK SETTINGS END -->

                                                <!-- HARDWARE SETTINGS START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="4">HARDWARE SETTINGS</td>
                                                    <td class="pms-text">Check hard disk usage</td>
                                                    <td><label for="hw-set1-1" class="table-radio-val-cont"><input type="radio" name="hw-set1" id="hw-set1-1" value="ok"></label></td>
                                                    <td><label for="hw-set1-2" class="table-radio-val-cont"><input type="radio" name="hw-set1" id="hw-set1-2" value="not_ok"></label></td>
                                                    <td><label for="hw-set1-3" class="table-radio-val-cont"><input type="radio" name="hw-set1" id="hw-set1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="hw-set1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check RAM usage</td>
                                                    <td><label for="hw-set2-1" class="table-radio-val-cont"><input type="radio" name="hw-set2" id="hw-set2-1" value="ok"></label></td>
                                                    <td><label for="hw-set2-2" class="table-radio-val-cont"><input type="radio" name="hw-set2" id="hw-set2-2" value="not_ok"></label></td>
                                                    <td><label for="hw-set2-3" class="table-radio-val-cont"><input type="radio" name="hw-set2" id="hw-set2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="hw-set2-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check processor usage</td>
                                                    <td><label for="hw-set3-1" class="table-radio-val-cont"><input type="radio" name="hw-set3" id="hw-set3-1" value="ok"></label></td>
                                                    <td><label for="hw-set3-2" class="table-radio-val-cont"><input type="radio" name="hw-set3" id="hw-set3-2" value="not_ok"></label></td>
                                                    <td><label for="hw-set3-3" class="table-radio-val-cont"><input type="radio" name="hw-set3" id="hw-set3-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="hw-set3-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Fors laptop: Battery run time is normal</td>
                                                    <td><label for="hw-set4-1" class="table-radio-val-cont"><input type="radio" name="hw-set4" id="hw-set4-1" value="ok"></label></td>
                                                    <td><label for="hw-set4-2" class="table-radio-val-cont"><input type="radio" name="hw-set4" id="hw-set4-2" value="not_ok"></label></td>
                                                    <td><label for="hw-set4-3" class="table-radio-val-cont"><input type="radio" name="hw-set4" id="hw-set4-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="hw-set4-remarks"></textarea></td>
                                                </tr>
                                                <!-- HARDWARE SETTINGS START -->

                                                <!-- SOFTWARE START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="7">SOFTWARE</td>
                                                    <td class="pms-text">Check if the required software is installed and operational</td>
                                                    <td><label for="sw1-1" class="table-radio-val-cont"><input type="radio" name="sw1" id="sw1-1" value="ok"></label></td>
                                                    <td><label for="sw1-2" class="table-radio-val-cont"><input type="radio" name="sw1" id="sw1-2" value="not_ok"></label></td>
                                                    <td><label for="sw1-3" class="table-radio-val-cont"><input type="radio" name="sw1" id="sw1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Make sure windows, drivers and softwares are up-to-date</td>
                                                    <td><label for="sw2-1" class="table-radio-val-cont"><input type="radio" name="sw2" id="sw2-1" value="ok"></label></td>
                                                    <td><label for="sw2-2" class="table-radio-val-cont"><input type="radio" name="sw2" id="sw2-2" value="not_ok"></label></td>
                                                    <td><label for="sw2-3" class="table-radio-val-cont"><input type="radio" name="sw2" id="sw2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw2-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Verify proper settings and operation</td>
                                                    <td><label for="sw3-1" class="table-radio-val-cont"><input type="radio" name="sw3" id="sw3-1" value="ok"></label></td>
                                                    <td><label for="sw3-2" class="table-radio-val-cont"><input type="radio" name="sw3" id="sw3-2" value="not_ok"></label></td>
                                                    <td><label for="sw3-3" class="table-radio-val-cont"><input type="radio" name="sw3" id="sw3-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw3-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Clearing of browsing history if necessary</td>
                                                    <td><label for="sw4-1" class="table-radio-val-cont"><input type="radio" name="sw4" id="sw4-1" value="ok"></label></td>
                                                    <td><label for="sw4-2" class="table-radio-val-cont"><input type="radio" name="sw4" id="sw4-2" value="not_ok"></label></td>
                                                    <td><label for="sw4-3" class="table-radio-val-cont"><input type="radio" name="sw4" id="sw4-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw4-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check Operating System Licensing</td>
                                                    <td><label for="sw5-1" class="table-radio-val-cont"><input type="radio" name="sw5" id="sw5-1" value="ok"></label></td>
                                                    <td><label for="sw5-2" class="table-radio-val-cont"><input type="radio" name="sw5" id="sw5-2" value="not_ok"></label></td>
                                                    <td><label for="sw5-3" class="table-radio-val-cont"><input type="radio" name="sw5" id="sw5-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw5-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check Microsoft Office Licensing</td>
                                                    <td><label for="sw6-1" class="table-radio-val-cont"><input type="radio" name="sw6" id="sw6-1" value="ok"></label></td>
                                                    <td><label for="sw6-2" class="table-radio-val-cont"><input type="radio" name="sw6" id="sw6-2" value="not_ok"></label></td>
                                                    <td><label for="sw6-3" class="table-radio-val-cont"><input type="radio" name="sw6" id="sw6-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw6-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Other Software Licensing</td>
                                                    <td><label for="sw7-1" class="table-radio-val-cont"><input type="radio" name="sw7" id="sw7-1" value="ok"></label></td>
                                                    <td><label for="sw7-2" class="table-radio-val-cont"><input type="radio" name="sw7" id="sw7-2" value="not_ok"></label></td>
                                                    <td><label for="sw7-3" class="table-radio-val-cont"><input type="radio" name="sw7" id="sw7-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sw7-remarks"></textarea></td>
                                                </tr>
                                                <!-- SOFTWARE END -->

                                                <!-- SECURITY START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="3">SECURITY</td>
                                                    <td class="pms-text">Conduct windows security full scan to check for virus threats</td>
                                                    <td><label for="sec1-1" class="table-radio-val-cont"><input type="radio" name="sec1" id="sec1-1" value="ok"></label></td>
                                                    <td><label for="sec1-2" class="table-radio-val-cont"><input type="radio" name="sec1" id="sec1-2" value="not_ok"></label></td>
                                                    <td><label for="sec1-3" class="table-radio-val-cont"><input type="radio" name="sec1" id="sec1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sec1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Ensure Windows Security turn on</td>
                                                    <td><label for="sec2-1" class="table-radio-val-cont"><input type="radio" name="sec2" id="sec2-1" value="ok"></label></td>
                                                    <td><label for="sec2-2" class="table-radio-val-cont"><input type="radio" name="sec2" id="sec2-2" value="not_ok"></label></td>
                                                    <td><label for="sec2-3" class="table-radio-val-cont"><input type="radio" name="sec2" id="sec2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sec2-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Clean potentially unwanted files and invalid windows registry</td>
                                                    <td><label for="sec3-1" class="table-radio-val-cont"><input type="radio" name="sec3" id="sec3-1" value="ok"></label></td>
                                                    <td><label for="sec3-2" class="table-radio-val-cont"><input type="radio" name="sec3" id="sec3-2" value="not_ok"></label></td>
                                                    <td><label for="sec3-3" class="table-radio-val-cont"><input type="radio" name="sec3" id="sec3-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="sec3-remarks"></textarea></td>
                                                </tr>
                                                <!-- SECURITY END -->

                                                <!-- GENERAL MAINTENANCE START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="8">GENERAL MAINTENANCE</td>
                                                    <td class="pms-text">Remove dust from system unit</td>
                                                    <td><label for="gen-main1-1" class="table-radio-val-cont"><input type="radio" name="gen-main1" id="gen-main1-1" value="ok"></label></td>
                                                    <td><label for="gen-main1-2" class="table-radio-val-cont"><input type="radio" name="gen-main1" id="gen-main1-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main1-3" class="table-radio-val-cont"><input type="radio" name="gen-main1" id="gen-main1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check airflow and fans if working</td>
                                                    <td><label for="gen-main2-1" class="table-radio-val-cont"><input type="radio" name="gen-main2" id="gen-main2-1" value="ok"></label></td>
                                                    <td><label for="gen-main2-2" class="table-radio-val-cont"><input type="radio" name="gen-main2" id="gen-main2-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main2-3" class="table-radio-val-cont"><input type="radio" name="gen-main2" id="gen-main2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main2-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Perform dsk cleanup to remove junk and temporary files</td>
                                                    <td><label for="gen-main3-1" class="table-radio-val-cont"><input type="radio" name="gen-main3" id="gen-main3-1" value="ok"></label></td>
                                                    <td><label for="gen-main3-2" class="table-radio-val-cont"><input type="radio" name="gen-main3" id="gen-main3-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main3-3" class="table-radio-val-cont"><input type="radio" name="gen-main3" id="gen-main3-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main3-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Check thermal paste of CPU and GPU then apply if necessary</td>
                                                    <td><label for="gen-main4-1" class="table-radio-val-cont"><input type="radio" name="gen-main4" id="gen-main4-1" value="ok"></label></td>
                                                    <td><label for="gen-main4-2" class="table-radio-val-cont"><input type="radio" name="gen-main4" id="gen-main4-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main4-3" class="table-radio-val-cont"><input type="radio" name="gen-main4" id="gen-main4-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main4-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Defragment the hard drive</td>
                                                    <td><label for="gen-main5-1" class="table-radio-val-cont"><input type="radio" name="gen-main5" id="gen-main5-1" value="ok"></label></td>
                                                    <td><label for="gen-main5-2" class="table-radio-val-cont"><input type="radio" name="gen-main5" id="gen-main5-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main5-3" class="table-radio-val-cont"><input type="radio" name="gen-main5" id="gen-main5-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main5-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Clear the Recycle Bin</td>
                                                    <td><label for="gen-main6-1" class="table-radio-val-cont"><input type="radio" name="gen-main6" id="gen-main6-1" value="ok"></label></td>
                                                    <td><label for="gen-main6-2" class="table-radio-val-cont"><input type="radio" name="gen-main6" id="gen-main6-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main6-3" class="table-radio-val-cont"><input type="radio" name="gen-main6" id="gen-main6-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main6-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Remove unused programs</td>
                                                    <td><label for="gen-main7-1" class="table-radio-val-cont"><input type="radio" name="gen-main7" id="gen-main7-1" value="ok"></label></td>
                                                    <td><label for="gen-main7-2" class="table-radio-val-cont"><input type="radio" name="gen-main7" id="gen-main7-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main7-3" class="table-radio-val-cont"><input type="radio" name="gen-main7" id="gen-main7-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main7-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Clean peripheral devices</td>
                                                    <td><label for="gen-main8-1" class="table-radio-val-cont"><input type="radio" name="gen-main8" id="gen-main8-1" value="ok"></label></td>
                                                    <td><label for="gen-main8-2" class="table-radio-val-cont"><input type="radio" name="gen-main8" id="gen-main8-2" value="not_ok"></label></td>
                                                    <td><label for="gen-main8-3" class="table-radio-val-cont"><input type="radio" name="gen-main8" id="gen-main8-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="gen-main8-remarks"></textarea></td>
                                                </tr>
                                                <!-- GENERAL MAINTENANCE END -->

                                                <!-- PERIPHERAL DEVICES START -->
                                                <tr>
                                                    <td class="pms-title" rowspan="6">PERIPHERAL DEVICES</td>
                                                    <td class="pms-text">Mouse working properly
                                                        <input type="text" name="mouse-asset-id" class="asset-id-input text-danger font-weight-normal" id="mouse-asset-id" style="text-transform: uppercase;" autocomplete="off">
                                                        <div id="mouse-code-dropdown" class="dropdown-menu" aria-labelledby="mouse-asset-id" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                                    </td>
                                                    <td><label for="per-dev1-1" class="table-radio-val-cont"><input type="radio" name="per-dev1" id="per-dev1-1" value="ok"></label></td>
                                                    <td><label for="per-dev1-2" class="table-radio-val-cont"><input type="radio" name="per-dev1" id="per-dev1-2" value="not_ok"></label></td>
                                                    <td><label for="per-dev1-3" class="table-radio-val-cont"><input type="radio" name="per-dev1" id="per-dev1-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="per-dev1-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Keyboard working properly
                                                        <input type="text" name="keyboard-asset-id" class="asset-id-input text-danger font-weight-normal" id="keyboard-asset-id" style="text-transform: uppercase;" autocomplete="off">
                                                        <div id="keyboard-code-dropdown" class="dropdown-menu" aria-labelledby="keyboard-asset-id" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                                    </td>
                                                    <td><label for="per-dev2-1" class="table-radio-val-cont"><input type="radio" name="per-dev2" id="per-dev2-1" value="ok"></label></td>
                                                    <td><label for="per-dev2-2" class="table-radio-val-cont"><input type="radio" name="per-dev2" id="per-dev2-2" value="not_ok"></label></td>
                                                    <td><label for="per-dev2-3" class="table-radio-val-cont"><input type="radio" name="per-dev2" id="per-dev2-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="per-dev2-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Monitor working properly
                                                        <input type="text" name="monitor-asset-id" class="asset-id-input text-danger font-weight-normal" id="monitor-asset-id" style="text-transform: uppercase;" autocomplete="off">
                                                        <div id="monitor-code-dropdown" class="dropdown-menu" aria-labelledby="monitor-asset-id" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                                    </td>
                                                    <td><label for="per-dev3-1" class="table-radio-val-cont"><input type="radio" name="per-dev3" id="per-dev3-1" value="ok"></label></td>
                                                    <td><label for="per-dev3-2" class="table-radio-val-cont"><input type="radio" name="per-dev3" id="per-dev3-2" value="not_ok"></label></td>
                                                    <td><label for="per-dev3-3" class="table-radio-val-cont"><input type="radio" name="per-dev3" id="per-dev3-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="per-dev3-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">UPS/AVR working properly
                                                        <input type="text" name="upsavr-asset-id" class="asset-id-input text-danger font-weight-normal" id="upsavr-asset-id" style="text-transform: uppercase;" autocomplete="off">
                                                        <div id="upsavr-code-dropdown" class="dropdown-menu" aria-labelledby="upsavr-asset-id" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                                    </td>
                                                    <td><label for="per-dev4-1" class="table-radio-val-cont"><input type="radio" name="per-dev4" id="per-dev4-1" value="ok"></label></td>
                                                    <td><label for="per-dev4-2" class="table-radio-val-cont"><input type="radio" name="per-dev4" id="per-dev4-2" value="not_ok"></label></td>
                                                    <td><label for="per-dev4-3" class="table-radio-val-cont"><input type="radio" name="per-dev4" id="per-dev4-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="per-dev4-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Printer working properly
                                                        <input type="text" name="printer-asset-id" class="asset-id-input text-danger font-weight-normal" id="printer-asset-id" style="text-transform: uppercase;" autocomplete="off">
                                                        <div id="printer-code-dropdown" class="dropdown-menu" aria-labelledby="printer-asset-id" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                                    </td>
                                                    <td><label for="per-dev5-1" class="table-radio-val-cont"><input type="radio" name="per-dev5" id="per-dev5-1" value="ok"></label></td>
                                                    <td><label for="per-dev5-2" class="table-radio-val-cont"><input type="radio" name="per-dev5" id="per-dev5-2" value="not_ok"></label></td>
                                                    <td><label for="per-dev5-3" class="table-radio-val-cont"><input type="radio" name="per-dev5" id="per-dev5-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="per-dev5-remarks"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="pms-text">Telephone working properly
                                                        <input type="text" name="telephone-asset-id" class="asset-id-input text-danger font-weight-normal" id="telephone-asset-id" style="text-transform: uppercase;" autocomplete="off">
                                                        <div id="telephone-code-dropdown" class="dropdown-menu" aria-labelledby="telephone-asset-id" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                                    </td>
                                                    <td><label for="per-dev6-1" class="table-radio-val-cont"><input type="radio" name="per-dev6" id="per-dev6-1" value="ok"></label></td>
                                                    <td><label for="per-dev6-2" class="table-radio-val-cont"><input type="radio" name="per-dev6" id="per-dev6-2" value="not_ok"></label></td>
                                                    <td><label for="per-dev6-3" class="table-radio-val-cont"><input type="radio" name="per-dev6" id="per-dev6-3" value="none"></label></td>
                                                    <td class="textarea-cont"><textarea name="per-dev6-remarks"></textarea></td>
                                                </tr>
                                                <!-- PERIPHERAL DEVICES END -->
                                            </tbody>
                                        </table>

                                        <!-- PERFORMED BY NAME DISPLAY -->
                                        <p style="margin-top: 0.8rem;">PERFORM BY: 
                                            <span class="text-primary">
                                                <?php 
                                                    user_info();
                                                    echo $name;
                                                ?>
                                            </span>
                                        </p>

                                        <div class="ms-5">
                                            <!-- PMS SUBMIT BUTTON -->
                                            <button type="submit" class="btn btn-success float-end mb-5 ms-5" id="create-pms-btn" form="create-pms-form">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "../footer/footer.php" ?>
    <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Alert / Toast -->
    <div id="snackbar"><span id="snacker_message"></span></div>

    <!-- JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../asset/pms_script.js"></script>
</body>

</html>