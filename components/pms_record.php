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

    <!-- THIS WILL OVERIDE THIS MODAL STYLE -->
    <style>
        .pms-modal-container th,
        .pms-modal-container thead,
        .pms-modal-container body,
        .pms-modal-container td {
            border: 1px solid #333;
            padding: 0.4rem;
        }

        .pms-history-title {
            color: #000;
        }
    </style>
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
                            <h6 class="m-0 font-weight-bold text-primary">PMS RECORD</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mb-2">
                                <div class="modal-body pms-modal-container">
                                    <!-- SEARCH BAR START -->
                                    <div class="container ms-0 px-0">
                                        <div class="row justify-content-end">
                                            <div class="d-flex my-2 ms-auto" style="width: 25rem;" role="search">
                                                <input type="search" name="search-pms-quarter" id="search-pms-quarter" class="form-control me-2" placeholder="Search" aria-label="Search" style="text-transform: uppercase;">
                                                <button class="btn btn-outline-success" id="search-pms-quarter-btn">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- SEARCH BAR END -->
                                    <table id="pms-history-table" class="table table-bordered border-dark">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2" style="vertical-align: middle;">ITEM No.</th>
                                                <th class="text-center" rowspan="2" style="vertical-align: middle;">TASK</th>
                                                <th class="text-center" rowspan="2" style="vertical-align: middle;">DESCRIPTION</th>
                                                <th class="text-center" colspan="4" style="vertical-align: middle;">QUARTER</th>
                                                <th class="text-center" rowspan="2" style="vertical-align: middle;">REMARKS</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">1st</th>
                                                <th class="text-center">2nd</th>
                                                <th class="text-center">3rd</th>
                                                <th class="text-center">4th</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <!-- SYSTEM START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="2" style="vertical-align: middle;">1</td>
                                                    <td class="vertical-center text-center" rowspan="2" style="vertical-align: middle;">SYSTEM</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check start up errors and speed of entire boot process</td>
                                                    <td class="vertical-center" id="sys1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check log-in process</td>
                                                    <td class="vertical-center" id="sys2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sys2-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- SYSTEM END -->

                                            <!-- NETWORK SETTINGS START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="5" style="vertical-align: middle;">2</td>
                                                    <td class="vertical-center text-center" rowspan="5" style="vertical-align: middle;">NETWORK SETTINGS</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check TCP/IP</td>
                                                    <td class="vertical-center" id="net_set1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check Domain name</td>
                                                    <td class="vertical-center" id="net_set2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set2-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check Computer name</td>
                                                    <td class="vertical-center" id="net_set3-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set3-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set3-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set3-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set3-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check Fileserver folder mapping</td>
                                                    <td class="vertical-center" id="net_set4-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set4-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set4-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set4-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set4-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check if unit is connected to the network</td>
                                                    <td class="vertical-center" id="net_set5-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set5-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set5-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set5-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="net_set5-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- NETWORK SETTINGS END -->

                                            <!-- HARDWARE SETTINGS START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="4" style="vertical-align: middle;">3</td>
                                                    <td class="vertical-center text-center" rowspan="4" style="vertical-align: middle;">HARDWARE SETTINGS</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check hard disk usage</td>
                                                    <td class="vertical-center" id="hw_set1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check RAM usage</td>
                                                    <td class="vertical-center" id="hw_set2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set2-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check Processor usage</td>
                                                    <td class="vertical-center" id="hw_set3-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set3-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set3-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set3-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set3-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">For Laptop: Battery run time is normal</td>
                                                    <td class="vertical-center" id="hw_set4-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set4-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set4-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set4-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="hw_set4-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- HARDWARE SETTINGS START -->

                                            <!-- SOFTWARE START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="7" style="vertical-align: middle;">4</td>
                                                    <td class="vertical-center text-center" rowspan="7" style="vertical-align: middle;">SOFTWARE</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check if the required software is installed and operational</td>
                                                    <td class="vertical-center" id="sw1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Make sure windows, drivers and softwares are up-to-date</td>
                                                    <td class="vertical-center" id="sw2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw2-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Verify proper settings and operation</td>
                                                    <td class="vertical-center" id="sw3-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw3-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw3-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw3-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw3-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Clearing of browsing history if necessary</td>
                                                    <td class="vertical-center" id="sw4-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw4-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw4-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw4-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw4-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check Operating System Licensing</td>
                                                    <td class="vertical-center" id="sw5-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw5-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw5-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw5-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw5-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check Microsoft Office Licensing</td>
                                                    <td class="vertical-center" id="sw6-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw6-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw6-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw6-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw6-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Other Software Licensing</td>
                                                    <td class="vertical-center" id="sw7-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw7-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw7-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw7-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sw7-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- SOFTWARE END -->

                                            <!-- SECURITY START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="3" style="vertical-align: middle;">5</td>
                                                    <td class="vertical-center text-center" rowspan="3" style="vertical-align: middle;">SECURITY</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Conduct windows security full scan to check for virus threats</td>
                                                    <td class="vertical-center" id="sec1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Ensure Windows Security turn on</td>
                                                    <td class="vertical-center" id="sec2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec2-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Clean potentially unwanted files and invalid Windows Registry</td>
                                                    <td class="vertical-center" id="sec3-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec3-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec3-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec3-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="sec3-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- SECURITY END -->

                                            <!-- GENERAL MAINTENANCE START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="8" style="vertical-align: middle;">6</td>
                                                    <td class="vertical-center text-center" rowspan="8" style="vertical-align: middle;">GENERAL MAINTENANCE</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Remove dust from system unit</td>
                                                    <td class="vertical-center" id="gen_main1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">check airflow and fans if working</td>
                                                    <td class="vertical-center" id="gen_main2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main2-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Perform dsk cleanup to remove junk and temporary files</td>
                                                    <td class="vertical-center" id="gen_main3-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main3-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main3-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main3-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main3-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Check thermal paste of CPU and GPU then apply if necessary</td>
                                                    <td class="vertical-center" id="gen_main4-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main4-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main4-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main4-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main4-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Defragment the hard drive</td>
                                                    <td class="vertical-center" id="gen_main5-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main5-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main5-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main5-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main5-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Clear the Recycle Bin</td>
                                                    <td class="vertical-center" id="gen_main6-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main6-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main6-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main6-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main6-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Remove unused programs</td>
                                                    <td class="vertical-center" id="gen_main7-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main7-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main7-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main7-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main7-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Clean Peripheral devices</td>
                                                    <td class="vertical-center" id="gen_main8-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main8-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main8-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main8-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="gen_main8-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- GENERAL MAINTENANCE END -->

                                            <!-- PERIPHERAL DEVICES START -->
                                            <div>
                                                <tr>
                                                    <td class="vertical-center text-center" rowspan="6" style="vertical-align: middle;">7</td>
                                                    <td class="vertical-center text-center" rowspan="6" style="vertical-align: middle;">PERIPHERAL DEVICES</td>
                                                    <td class="vertical-center" style="vertical-align: middle;">Mouse working properly</td>
                                                    <td class="vertical-center" id="per_dev1-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev1-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev1-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev1-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev1-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Keyboard working properly</td>
                                                    <td class="vertical-center" id="per_dev2-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev2-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev2-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev2-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev2-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Monitor working properly</td>
                                                    <td class="vertical-center" id="per_dev3-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev3-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev3-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev3-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev3-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">UPS/AVR working properly</td>
                                                    <td class="vertical-center" id="per_dev4-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev4-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev4-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev4-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev4-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Printer working properly</td>
                                                    <td class="vertical-center" id="per_dev5-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev5-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev5-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev5-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev5-remarks"></td>
                                                </tr>
                                                <tr>
                                                    <td class="vertical-center" style="vertical-align: middle;">Telephone working properly</td>
                                                    <td class="vertical-center" id="per_dev6-1st" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev6-2nd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev6-3rd" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev6-4th" style="vertical-align: middle;"></td>
                                                    <td class="vertical-center" id="per_dev6-remarks"></td>
                                                </tr>
                                            </div>
                                            <!-- PERIPHERAL DEVICES END -->

                                        </tbody>
                                    </table>
                                    <!-- DATE START -->
                                    <table class="table" id="legend">
                                        <thead>

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th rowspan="3" colspan="2" style="vertical-align: middle;">Legends: <span style="padding-left: 40px;"></span> <i class="bi bi-check"></i> : OK (input remarks, if any) <br> <span style="padding-left: 111px;"></span> <i class="bi bi-x"></i> : Not OK (input remarks) <br> <span style="padding-left: 104px;"></span> NA : Not applicable </th>
                                                <th class="text-center" rowspan="2" style="vertical-align: middle;">PERFORMED BY</th>
                                                <td class="text-center" id="pms-quarter1-user" style="font-size: 0.9rem;"></td>
                                                <td class="text-center" id="pms-quarter2-user" style="font-size: 0.9rem;"></td>
                                                <td class="text-center" id="pms-quarter3-user" style="font-size: 0.9rem;"></td>
                                                <td class="text-center" id="pms-quarter4-user" style="font-size: 0.9rem;"></td>
                                                <td class="text-center" rowspan="2" style="vertical-align: middle;" id="pms-year-display"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center text-danger">FN.Lastname</td>
                                                <td class="text-center text-danger">FN.Lastname</td>
                                                <td class="text-center text-danger">FN.Lastname</td>
                                                <td class="text-center text-danger">FN.Lastname</td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">DATE PERFORMED</th>
                                                <td class="text-center" id="pms-quarter1-date-display"></td>
                                                <td class="text-center" id="pms-quarter2-date-display"></td>
                                                <td class="text-center" id="pms-quarter3-date-display"></td>
                                                <td class="text-center" id="pms-quarter4-date-display"></td>
                                                <th class="text-center">Year</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- DATE END -->
                                </div>
                                <div class="modal-footer">
                                    <!-- Submition Button -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="generate-report">Generate Report</button>
                                </div>
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
    <!-- <script src="../asset/pms_script.js"></script> -->
</body>

</html>