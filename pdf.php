<?php
// Configuration
require_once __DIR__ . '/conn.php';
include '../tcpdf/tcpdf.php';
include '../config/database/functions.php';
session_start();
ob_start();
user_info();

class MYPDF extends TCPDF
{
    public function Header()
    {
        $image_file = '../../img/MACBUILDERS.jpg';
        $this->Image($image_file, 40, 4, 22, 17, 'JPG');
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 0, 'MAC BUILDERS', 0, 1, 'C', 0, '', 0);
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 0, 'Purok 8, Brgy. Linao, Ormoc City, Western Leyte-6541', 0, 1, 'C', 0, '', 1);
        $this->Cell(0, 0, 'Tel. Nos.: (053) 560-9092, 255-2654; Fax: 561-5720', 0, 1, 'C', 0, '', 1);
    }

    public function Footer()
    {
        // Set footer margin
        $this->SetY(-15);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 0, 'MBC-SP-ICT-02F1', 0, 1, 'L', 0, '', 1);
        $this->Cell(0, 0, 'Rev. 1 29/02/24', 0, 1, 'L', 0, '', 1);
    }

    public function LoadData($pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
            $asset_id = isset($_REQUEST['assetId']) ? $_REQUEST['assetId'] : '';

            if (!empty($asset_id)) {
                // Get the current year
                $current_year = date('Y');

                $sql = <<<'SQL'
                    SELECT p.*, u.names AS user_name
                    FROM pms p
                    LEFT JOIN user u ON p.userid = u.userid
                    WHERE p.asset_id = :asset_id
                    AND YEAR(p.created_at) = :current_year;
                SQL;

                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':asset_id', $asset_id, PDO::PARAM_STR);
                    $stmt->bindParam(':current_year', $current_year, PDO::PARAM_INT);
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    return $rows;
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
                }
            }
        }
    }

    public function LoadEquipment($pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
            $asset_id = isset($_REQUEST['assetId']) ? $_REQUEST['assetId'] : '';

            if (!empty($asset_id)) {
                $sql = <<<'SQL'
                    SELECT 
                        nci.equipment_code AS asset_code,
                        nu.empname AS username, 
                        nci.processor, 
                        ia.description AS ram, 
                        mr.location
                    FROM non_consumable_item nci
                    LEFT JOIN (
                        SELECT *
                        FROM item_deploy
                        WHERE is_deleted = 0
                    ) id ON nci.itemid = id.itemid
                    LEFT JOIN employee_user nu ON id.empid = nu.empid
                    LEFT JOIN (
                        SELECT *
                        FROM memo_receipt
                        WHERE is_deleted = 0
                    ) mr ON nci.itemid = mr.itemid
                    LEFT JOIN (
                        SELECT *
                        FROM item_addon
                        WHERE addonname = 'RAM' AND is_deleted = 0
                    ) ia ON nci.equipment_code = ia.asset_code
                    WHERE nci.equipment_code = :equipment_code
                    AND nci.status = 'ACTIVE'
                    ORDER BY id.added_on DESC
                    LIMIT 1;
                SQL;

                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':equipment_code', $asset_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    if ($result) {
                        return json_encode([
                            'status' => 'success',
                            'asset_id' => $result['asset_code'],
                            'username' => $result['username'],
                            'processor' => $result['processor'],
                            'ram' => $result['ram'],
                            'location' => $result['location']
                        ]);
                    } else {
                        return json_encode([
                            'status' => 'error',
                            'message' => 'Equipment not found'
                        ]);
                    }
                } catch (PDOException $e) {
                    return json_encode([
                        'status' => 'error',
                        'message' => 'Database error: ' . $e->getMessage()
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Asset ID is empty'
                ]);
            }
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function loadComputername($pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
            $asset_id = isset($_REQUEST['assetId']) ? $_REQUEST['assetId'] : '';

            if (!empty($asset_id)) {
                $fetch_query = <<<'SQL'
                    SELECT computer_name 
                    FROM pms
                    WHERE asset_id = :asset_id
                SQL;

                try {
                    $stmt = $pdo->prepare($fetch_query);
                    $stmt->bindParam(':asset_id', $asset_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    return json_encode([
                        'status' => 'success', 
                        'computer_name' => $result['computer_name']
                    ]);
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
                }
            }
        }
    }
}

$preference = array(
    'Duplex' => 'DuplexFlipLongEdge',
    'PickTrayByPDFSize' => true,
    'PrintPageRange' => array(2, 1),
    'NumCopies' => 1
);

$width = 216;
$height = 279;
$pageLayout = array($width, $height);

//$pdf = new TCPDF('P', 'mm', $pageLayout);
$pdf = new MYPDF('P', 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MAC Builders');
$pdf->SetTitle('IT Infrastructure History Record');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, '25', PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->AddPage();
$pdf->setViewerPreferences($preference);

$macbuilders_logo = '../img/mac.jpg';
$pdf->Image($macbuilders_logo, 40, 5, 22, 17, 'JPG');
$iso_logo = '../img/iso.jpg';
$pdf->Image($iso_logo, 153, 5, 19, 17, 'JPG');

// set font
$pdf->SetFont('dejavusans', 'B', 7);

// Fetch data from the database
$myPDF = new MYPDF();
$data = $myPDF->LoadData($pdo);
$equipment_data = $myPDF->LoadEquipment($pdo);
$computer_name_data = $myPDF->loadComputername($pdo);

$equipment = json_decode($equipment_data, true);
$computer = json_decode($computer_name_data, true);

// Add your content on top of the table
$html = <<<EOD
<br><br><br><br>
<table>
    <tr>
        <td>
            ASSET ID :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> {$equipment['asset_id']} </u>
        </td>
        <td style="text-align: right;">
            Computer Name :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> {$computer['computer_name']} </u>
        </td>
    </tr>
    <tr>
        <td>
            User Name :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> {$equipment['username']} </u>
        </td>
        <td style="text-align: right;">
            Processor :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> {$equipment['processor']} </u>
        </td>
    </tr>
    <tr>
        <td>
            Location :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> {$equipment['location']} </u>
        </td>
        <td style="text-align: right;">
            RAM :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> {$equipment['ram']} </u>
        </td>
    </tr>
</table>
EOD;

$pdf->writeHTML($html, true, false, false, false, '');

// -----------------------------------------------------------------------------

// declear date variable
$year = '';

// Declare quarter 1 variables

$sys1_q1 = '';
$sys2_q1 = '';
$net_set1_q1 = '';
$net_set2_q1 = '';
$net_set3_q1 = '';
$net_set4_q1 = '';
$net_set5_q1 = '';
$hw_set1_q1 = '';
$hw_set2_q1 = '';
$hw_set3_q1 = '';
$hw_set4_q1 = '';
$sw1_q1 = '';
$sw2_q1 = '';
$sw3_q1 = '';
$sw4_q1 = '';
$sw5_q1 = '';
$sw6_q1 = '';
$sw7_q1 = '';
$sec1_q1 = '';
$sec2_q1 = '';
$sec3_q1 = '';
$gen_main1_q1 = '';
$gen_main2_q1 = '';
$gen_main3_q1 = '';
$gen_main4_q1 = '';
$gen_main5_q1 = '';
$gen_main6_q1 = '';
$gen_main7_q1 = '';
$gen_main8_q1 = '';
$per_dev1_q1 = '';
$per_dev2_q1 = '';
$per_dev3_q1 = '';
$per_dev4_q1 = '';
$per_dev5_q1 = '';
$per_dev6_q1 = '';

$sys1_q1_remarks = '';
$sys2_q1_remarks = '';
$net_set1_q1_remarks = '';
$net_set2_q1_remarks = '';
$net_set3_q1_remarks = '';
$net_set4_q1_remarks = '';
$net_set5_q1_remarks = '';
$hw_set1_q1_remarks = '';
$hw_set2_q1_remarks = '';
$hw_set3_q1_remarks = '';
$hw_set4_q1_remarks = '';
$sw1_q1_remarks = '';
$sw2_q1_remarks = '';
$sw3_q1_remarks = '';
$sw4_q1_remarks = '';
$sw5_q1_remarks = '';
$sw6_q1_remarks = '';
$sw7_q1_remarks = '';
$sec1_q1_remarks = '';
$sec2_q1_remarks = '';
$sec3_q1_remarks = '';
$gen_main1_q1_remarks = '';
$gen_main2_q1_remarks = '';
$gen_main3_q1_remarks = '';
$gen_main4_q1_remarks = '';
$gen_main5_q1_remarks = '';
$gen_main6_q1_remarks = '';
$gen_main7_q1_remarks = '';
$gen_main8_q1_remarks = '';
$per_dev1_q1_remarks = '';
$per_dev2_q1_remarks = '';
$per_dev3_q1_remarks = '';
$per_dev4_q1_remarks = '';
$per_dev5_q1_remarks = '';
$per_dev6_q1_remarks = '';

$quarter1_user = '';
$perform_q1_month_day = '';

// Declare quarter 2 variables

$sys1_q2 = '';
$sys2_q2 = '';
$net_set1_q2 = '';
$net_set2_q2 = '';
$net_set3_q2 = '';
$net_set4_q2 = '';
$net_set5_q2 = '';
$hw_set1_q2 = '';
$hw_set2_q2 = '';
$hw_set3_q2 = '';
$hw_set4_q2 = '';
$sw1_q2 = '';
$sw2_q2 = '';
$sw3_q2 = '';
$sw4_q2 = '';
$sw5_q2 = '';
$sw6_q2 = '';
$sw7_q2 = '';
$sec1_q2 = '';
$sec2_q2 = '';
$sec3_q2 = '';
$gen_main1_q2 = '';
$gen_main2_q2 = '';
$gen_main3_q2 = '';
$gen_main4_q2 = '';
$gen_main5_q2 = '';
$gen_main6_q2 = '';
$gen_main7_q2 = '';
$gen_main8_q2 = '';
$per_dev1_q2 = '';
$per_dev2_q2 = '';
$per_dev3_q2 = '';
$per_dev4_q2 = '';
$per_dev5_q2 = '';
$per_dev6_q2 = '';

$sys1_q2_remarks = '';
$sys2_q2_remarks = '';
$net_set1_q2_remarks = '';
$net_set2_q2_remarks = '';
$net_set3_q2_remarks = '';
$net_set4_q2_remarks = '';
$net_set5_q2_remarks = '';
$hw_set1_q2_remarks = '';
$hw_set2_q2_remarks = '';
$hw_set3_q2_remarks = '';
$hw_set4_q2_remarks = '';
$sw1_q2_remarks = '';
$sw2_q2_remarks = '';
$sw3_q2_remarks = '';
$sw4_q2_remarks = '';
$sw5_q2_remarks = '';
$sw6_q2_remarks = '';
$sw7_q2_remarks = '';
$sec1_q2_remarks = '';
$sec2_q2_remarks = '';
$sec3_q2_remarks = '';
$gen_main1_q2_remarks = '';
$gen_main2_q2_remarks = '';
$gen_main3_q2_remarks = '';
$gen_main4_q2_remarks = '';
$gen_main5_q2_remarks = '';
$gen_main6_q2_remarks = '';
$gen_main7_q2_remarks = '';
$gen_main8_q2_remarks = '';
$per_dev1_q2_remarks = '';
$per_dev2_q2_remarks = '';
$per_dev3_q2_remarks = '';
$per_dev4_q2_remarks = '';
$per_dev5_q2_remarks = '';
$per_dev6_q2_remarks = '';

$quarter2_user = '';
$perform_q2_month_day = '';

// Declare quarter 3 variables

$sys1_q3 = '';
$sys2_q3 = '';
$net_set1_q3 = '';
$net_set2_q3 = '';
$net_set3_q3 = '';
$net_set4_q3 = '';
$net_set5_q3 = '';
$hw_set1_q3 = '';
$hw_set2_q3 = '';
$hw_set3_q3 = '';
$hw_set4_q3 = '';
$sw1_q3 = '';
$sw2_q3 = '';
$sw3_q3 = '';
$sw4_q3 = '';
$sw5_q3 = '';
$sw6_q3 = '';
$sw7_q3 = '';
$sec1_q3 = '';
$sec2_q3 = '';
$sec3_q3 = '';
$gen_main1_q3 = '';
$gen_main2_q3 = '';
$gen_main3_q3 = '';
$gen_main4_q3 = '';
$gen_main5_q3 = '';
$gen_main6_q3 = '';
$gen_main7_q3 = '';
$gen_main8_q3 = '';
$per_dev1_q3 = '';
$per_dev2_q3 = '';
$per_dev3_q3 = '';
$per_dev4_q3 = '';
$per_dev5_q3 = '';
$per_dev6_q3 = '';

$sys1_q3_remarks = '';
$sys2_q3_remarks = '';
$net_set1_q3_remarks = '';
$net_set2_q3_remarks = '';
$net_set3_q3_remarks = '';
$net_set4_q3_remarks = '';
$net_set5_q3_remarks = '';
$hw_set1_q3_remarks = '';
$hw_set2_q3_remarks = '';
$hw_set3_q3_remarks = '';
$hw_set4_q3_remarks = '';
$sw1_q3_remarks = '';
$sw2_q3_remarks = '';
$sw3_q3_remarks = '';
$sw4_q3_remarks = '';
$sw5_q3_remarks = '';
$sw6_q3_remarks = '';
$sw7_q3_remarks = '';
$sec1_q3_remarks = '';
$sec2_q3_remarks = '';
$sec3_q3_remarks = '';
$gen_main1_q3_remarks = '';
$gen_main2_q3_remarks = '';
$gen_main3_q3_remarks = '';
$gen_main4_q3_remarks = '';
$gen_main5_q3_remarks = '';
$gen_main6_q3_remarks = '';
$gen_main7_q3_remarks = '';
$gen_main8_q3_remarks = '';
$per_dev1_q3_remarks = '';
$per_dev2_q3_remarks = '';
$per_dev3_q3_remarks = '';
$per_dev4_q3_remarks = '';
$per_dev5_q3_remarks = '';
$per_dev6_q3_remarks = '';

$quarter3_user = '';
$perform_q3_month_day = '';

// Declare quarter 4 variables

$sys1_q4 = '';
$sys2_q4 = '';
$net_set1_q4 = '';
$net_set2_q4 = '';
$net_set3_q4 = '';
$net_set4_q4 = '';
$net_set5_q4 = '';
$hw_set1_q4 = '';
$hw_set2_q4 = '';
$hw_set3_q4 = '';
$hw_set4_q4 = '';
$sw1_q4 = '';
$sw2_q4 = '';
$sw3_q4 = '';
$sw4_q4 = '';
$sw5_q4 = '';
$sw6_q4 = '';
$sw7_q4 = '';
$sec1_q4 = '';
$sec2_q4 = '';
$sec3_q4 = '';
$gen_main1_q4 = '';
$gen_main2_q4 = '';
$gen_main3_q4 = '';
$gen_main4_q4 = '';
$gen_main5_q4 = '';
$gen_main6_q4 = '';
$gen_main7_q4 = '';
$gen_main8_q4 = '';
$per_dev1_q4 = '';
$per_dev2_q4 = '';
$per_dev3_q4 = '';
$per_dev4_q4 = '';
$per_dev5_q4 = '';
$per_dev6_q4 = '';

$sys1_q4_remarks = '';
$sys2_q4_remarks = '';
$net_set1_q4_remarks = '';
$net_set2_q4_remarks = '';
$net_set3_q4_remarks = '';
$net_set4_q4_remarks = '';
$net_set5_q4_remarks = '';
$hw_set1_q4_remarks = '';
$hw_set2_q4_remarks = '';
$hw_set3_q4_remarks = '';
$hw_set4_q4_remarks = '';
$sw1_q4_remarks = '';
$sw2_q4_remarks = '';
$sw3_q4_remarks = '';
$sw4_q4_remarks = '';
$sw5_q4_remarks = '';
$sw6_q4_remarks = '';
$sw7_q4_remarks = '';
$sec1_q4_remarks = '';
$sec2_q4_remarks = '';
$sec3_q4_remarks = '';
$gen_main1_q4_remarks = '';
$gen_main2_q4_remarks = '';
$gen_main3_q4_remarks = '';
$gen_main4_q4_remarks = '';
$gen_main5_q4_remarks = '';
$gen_main6_q4_remarks = '';
$gen_main7_q4_remarks = '';
$gen_main8_q4_remarks = '';
$per_dev1_q4_remarks = '';
$per_dev2_q4_remarks = '';
$per_dev3_q4_remarks = '';
$per_dev4_q4_remarks = '';
$per_dev5_q4_remarks = '';
$per_dev6_q4_remarks = '';

$quarter4_user = '';
$perform_q4_month_day = '';

function getIcon($data) {
    if ($data == 'ok') {
        return '&#10003;'; // Checkmark symbol
    } else if ($data == 'not_ok') {
        return '&#10005;'; // Cross mark symbol
    } else {
        return '<span class="na-text">N/A</span>'; // N/A text
    }
}

function getFirstRemarks($remark) {
    if ($remark != '') {
        return '1st: ' . $remark . '<br>';
    } else {
        return '';
    }
}

function getSecondRemarks($remark) {
    if ($remark != '') {
        return '2nd: ' . $remark . '<br>';
    } else {
        return '';
    }
}

function getThirdRemarks($remark) {
    if ($remark != '') {
        return '3rd: ' . $remark . '<br>';
    } else {
        return '';
    }
}

function getFourthRemarks($remark) {
    if ($remark != '') {
        return '4th: ' . $remark . '<br>';
    } else {
        return '';
    }
}

foreach ($data as $row) {

    // Fetch created year
    $year = date('Y', strtotime($row['created_at']));

    switch ($row['quarter']) {
        case '1':
            $sys1_q1 = getIcon($row['sys1']);
            $sys2_q1 = getIcon($row['sys2']);
            $net_set1_q1 = getIcon($row['net_set1']);
            $net_set2_q1 = getIcon($row['net_set2']);
            $net_set3_q1 = getIcon($row['net_set3']);
            $net_set4_q1 = getIcon($row['net_set4']);
            $net_set5_q1 = getIcon($row['net_set5']);
            $hw_set1_q1 = getIcon($row['hw_set1']);
            $hw_set2_q1 = getIcon($row['hw_set2']);
            $hw_set3_q1 = getIcon($row['hw_set3']);
            $hw_set4_q1 = getIcon($row['hw_set4']);
            $sw1_q1 = getIcon($row['sw1']);
            $sw2_q1 = getIcon($row['sw2']);
            $sw3_q1 = getIcon($row['sw3']);
            $sw4_q1 = getIcon($row['sw4']);
            $sw5_q1 = getIcon($row['sw5']);
            $sw6_q1 = getIcon($row['sw6']);
            $sw7_q1 = getIcon($row['sw7']);
            $sec1_q1 = getIcon($row['sec1']);
            $sec2_q1 = getIcon($row['sec2']);
            $sec3_q1 = getIcon($row['sec3']);
            $gen_main1_q1 = getIcon($row['gen_main1']);
            $gen_main2_q1 = getIcon($row['gen_main2']);
            $gen_main3_q1 = getIcon($row['gen_main3']);
            $gen_main4_q1 = getIcon($row['gen_main4']);
            $gen_main5_q1 = getIcon($row['gen_main5']);
            $gen_main6_q1 = getIcon($row['gen_main6']);
            $gen_main7_q1 = getIcon($row['gen_main7']);
            $gen_main8_q1 = getIcon($row['gen_main8']);
            $per_dev1_q1 = getIcon($row['per_dev1']);
            $per_dev2_q1 = getIcon($row['per_dev2']);
            $per_dev3_q1 = getIcon($row['per_dev3']);
            $per_dev4_q1 = getIcon($row['per_dev4']);
            $per_dev5_q1 = getIcon($row['per_dev5']);
            $per_dev6_q1 = getIcon($row['per_dev6']);

            $sys1_q1_remarks = getFirstRemarks($row['sys1_remarks']);
            $sys2_q1_remarks = getFirstRemarks($row['sys2_remarks']);
            $net_set1_q1_remarks = getFirstRemarks($row['net_set1_remarks']);
            $net_set2_q1_remarks = getFirstRemarks($row['net_set2_remarks']);
            $net_set3_q1_remarks = getFirstRemarks($row['net_set3_remarks']);
            $net_set4_q1_remarks = getFirstRemarks($row['net_set4_remarks']);
            $net_set5_q1_remarks = getFirstRemarks($row['net_set5_remarks']);
            $hw_set1_q1_remarks = getFirstRemarks($row['hw_set1_remarks']);
            $hw_set2_q1_remarks = getFirstRemarks($row['hw_set2_remarks']);
            $hw_set3_q1_remarks = getFirstRemarks($row['hw_set3_remarks']);
            $hw_set4_q1_remarks = getFirstRemarks($row['hw_set4_remarks']);
            $sw1_q1_remarks = getFirstRemarks($row['sw1_remarks']);
            $sw2_q1_remarks = getFirstRemarks($row['sw2_remarks']);
            $sw3_q1_remarks = getFirstRemarks($row['sw3_remarks']);
            $sw4_q1_remarks = getFirstRemarks($row['sw4_remarks']);
            $sw5_q1_remarks = getFirstRemarks($row['sw5_remarks']);
            $sw6_q1_remarks = getFirstRemarks($row['sw6_remarks']);
            $sw7_q1_remarks = getFirstRemarks($row['sw7_remarks']);
            $sec1_q1_remarks = getFirstRemarks($row['sec1_remarks']);
            $sec2_q1_remarks = getFirstRemarks($row['sec2_remarks']);
            $sec3_q1_remarks = getFirstRemarks($row['sec3_remarks']);
            $gen_main1_q1_remarks = getFirstRemarks($row['gen_main1_remarks']);
            $gen_main2_q1_remarks = getFirstRemarks($row['gen_main2_remarks']);
            $gen_main3_q1_remarks = getFirstRemarks($row['gen_main3_remarks']);
            $gen_main4_q1_remarks = getFirstRemarks($row['gen_main4_remarks']);
            $gen_main5_q1_remarks = getFirstRemarks($row['gen_main5_remarks']);
            $gen_main6_q1_remarks = getFirstRemarks($row['gen_main6_remarks']);
            $gen_main7_q1_remarks = getFirstRemarks($row['gen_main7_remarks']);
            $gen_main8_q1_remarks = getFirstRemarks($row['gen_main8_remarks']);
            $per_dev1_q1_remarks = getFirstRemarks($row['per_dev1_remarks']);
            $per_dev2_q1_remarks = getFirstRemarks($row['per_dev2_remarks']);
            $per_dev3_q1_remarks = getFirstRemarks($row['per_dev3_remarks']);
            $per_dev4_q1_remarks = getFirstRemarks($row['per_dev4_remarks']);
            $per_dev5_q1_remarks = getFirstRemarks($row['per_dev5_remarks']);
            $per_dev6_q1_remarks = getFirstRemarks($row['per_dev6_remarks']);

            $quarter1_user = $row['user_name'];
            $perform_q1_month_day = date('m-d', strtotime($row['created_at']));
            break;
        case '2':
            $sys1_q2 = getIcon($row['sys1']);
            $sys2_q2 = getIcon($row['sys2']);
            $net_set1_q2 = getIcon($row['net_set1']);
            $net_set2_q2 = getIcon($row['net_set2']);
            $net_set3_q2 = getIcon($row['net_set3']);
            $net_set4_q2 = getIcon($row['net_set4']);
            $net_set5_q2 = getIcon($row['net_set5']);
            $hw_set1_q2 = getIcon($row['hw_set1']);
            $hw_set2_q2 = getIcon($row['hw_set2']);
            $hw_set3_q2 = getIcon($row['hw_set3']);
            $hw_set4_q2 = getIcon($row['hw_set4']);
            $sw1_q2 = getIcon($row['sw1']);
            $sw2_q2 = getIcon($row['sw2']);
            $sw3_q2 = getIcon($row['sw3']);
            $sw4_q2 = getIcon($row['sw4']);
            $sw5_q2 = getIcon($row['sw5']);
            $sw6_q2 = getIcon($row['sw6']);
            $sw7_q2 = getIcon($row['sw7']);
            $sec1_q2 = getIcon($row['sec1']);
            $sec2_q2 = getIcon($row['sec2']);
            $sec3_q2 = getIcon($row['sec3']);
            $gen_main1_q2 = getIcon($row['gen_main1']);
            $gen_main2_q2 = getIcon($row['gen_main2']);
            $gen_main3_q2 = getIcon($row['gen_main3']);
            $gen_main4_q2 = getIcon($row['gen_main4']);
            $gen_main5_q2 = getIcon($row['gen_main5']);
            $gen_main6_q2 = getIcon($row['gen_main6']);
            $gen_main7_q2 = getIcon($row['gen_main7']);
            $gen_main8_q2 = getIcon($row['gen_main8']);
            $per_dev1_q2 = getIcon($row['per_dev1']);
            $per_dev2_q2 = getIcon($row['per_dev2']);
            $per_dev3_q2 = getIcon($row['per_dev3']);
            $per_dev4_q2 = getIcon($row['per_dev4']);
            $per_dev5_q2 = getIcon($row['per_dev5']);
            $per_dev6_q2 = getIcon($row['per_dev6']);

            $sys1_q2_remarks = getSecondRemarks($row['sys1_remarks']);
            $sys2_q2_remarks = getSecondRemarks($row['sys2_remarks']);
            $net_set1_q2_remarks = getSecondRemarks($row['net_set1_remarks']);
            $net_set2_q2_remarks = getSecondRemarks($row['net_set2_remarks']);
            $net_set3_q2_remarks = getSecondRemarks($row['net_set3_remarks']);
            $net_set4_q2_remarks = getSecondRemarks($row['net_set4_remarks']);
            $net_set5_q2_remarks = getSecondRemarks($row['net_set5_remarks']);
            $hw_set1_q2_remarks = getSecondRemarks($row['hw_set1_remarks']);
            $hw_set2_q2_remarks = getSecondRemarks($row['hw_set2_remarks']);
            $hw_set3_q2_remarks = getSecondRemarks($row['hw_set3_remarks']);
            $hw_set4_q2_remarks = getSecondRemarks($row['hw_set4_remarks']);
            $sw1_q2_remarks = getSecondRemarks($row['sw1_remarks']);
            $sw2_q2_remarks = getSecondRemarks($row['sw2_remarks']);
            $sw3_q2_remarks = getSecondRemarks($row['sw3_remarks']);
            $sw4_q2_remarks = getSecondRemarks($row['sw4_remarks']);
            $sw5_q2_remarks = getSecondRemarks($row['sw5_remarks']);
            $sw6_q2_remarks = getSecondRemarks($row['sw6_remarks']);
            $sw7_q2_remarks = getSecondRemarks($row['sw7_remarks']);
            $sec1_q2_remarks = getSecondRemarks($row['sec1_remarks']);
            $sec2_q2_remarks = getSecondRemarks($row['sec2_remarks']);
            $sec3_q2_remarks = getSecondRemarks($row['sec3_remarks']);
            $gen_main1_q2_remarks = getSecondRemarks($row['gen_main1_remarks']);
            $gen_main2_q2_remarks = getSecondRemarks($row['gen_main2_remarks']);
            $gen_main3_q2_remarks = getSecondRemarks($row['gen_main3_remarks']);
            $gen_main4_q2_remarks = getSecondRemarks($row['gen_main4_remarks']);
            $gen_main5_q2_remarks = getSecondRemarks($row['gen_main5_remarks']);
            $gen_main6_q2_remarks = getSecondRemarks($row['gen_main6_remarks']);
            $gen_main7_q2_remarks = getSecondRemarks($row['gen_main7_remarks']);
            $gen_main8_q2_remarks = getSecondRemarks($row['gen_main8_remarks']);
            $per_dev1_q2_remarks = getSecondRemarks($row['per_dev1_remarks']);
            $per_dev2_q2_remarks = getSecondRemarks($row['per_dev2_remarks']);
            $per_dev3_q2_remarks = getSecondRemarks($row['per_dev3_remarks']);
            $per_dev4_q2_remarks = getSecondRemarks($row['per_dev4_remarks']);
            $per_dev5_q2_remarks = getSecondRemarks($row['per_dev5_remarks']);
            $per_dev6_q2_remarks = getSecondRemarks($row['per_dev6_remarks']);

            $quarter2_user = $row['user_name'];
            $perform_q2_month_day = date('m-d', strtotime($row['created_at']));
            break;
        case '3':
            $sys1_q3 = getIcon($row['sys1']);
            $sys2_q3 = getIcon($row['sys2']);
            $net_set1_q3 = getIcon($row['net_set1']);
            $net_set2_q3 = getIcon($row['net_set2']);
            $net_set3_q3 = getIcon($row['net_set3']);
            $net_set4_q3 = getIcon($row['net_set4']);
            $net_set5_q3 = getIcon($row['net_set5']);
            $hw_set1_q3 = getIcon($row['hw_set1']);
            $hw_set2_q3 = getIcon($row['hw_set2']);
            $hw_set3_q3 = getIcon($row['hw_set3']);
            $hw_set4_q3 = getIcon($row['hw_set4']);
            $sw1_q3 = getIcon($row['sw1']);
            $sw2_q3 = getIcon($row['sw2']);
            $sw3_q3 = getIcon($row['sw3']);
            $sw4_q3 = getIcon($row['sw4']);
            $sw5_q3 = getIcon($row['sw5']);
            $sw6_q3 = getIcon($row['sw6']);
            $sw7_q3 = getIcon($row['sw7']);
            $sec1_q3 = getIcon($row['sec1']);
            $sec2_q3 = getIcon($row['sec2']);
            $sec3_q3 = getIcon($row['sec3']);
            $gen_main1_q3 = getIcon($row['gen_main1']);
            $gen_main2_q3 = getIcon($row['gen_main2']);
            $gen_main3_q3 = getIcon($row['gen_main3']);
            $gen_main4_q3 = getIcon($row['gen_main4']);
            $gen_main5_q3 = getIcon($row['gen_main5']);
            $gen_main6_q3 = getIcon($row['gen_main6']);
            $gen_main7_q3 = getIcon($row['gen_main7']);
            $gen_main8_q3 = getIcon($row['gen_main8']);
            $per_dev1_q3 = getIcon($row['per_dev1']);
            $per_dev2_q3 = getIcon($row['per_dev2']);
            $per_dev3_q3 = getIcon($row['per_dev3']);
            $per_dev4_q3 = getIcon($row['per_dev4']);
            $per_dev5_q3 = getIcon($row['per_dev5']);
            $per_dev6_q3 = getIcon($row['per_dev6']);

            $sys1_q3_remarks = getThirdRemarks($row['sys1_remarks']);
            $sys2_q3_remarks = getThirdRemarks($row['sys2_remarks']);
            $net_set1_q3_remarks = getThirdRemarks($row['net_set1_remarks']);
            $net_set2_q3_remarks = getThirdRemarks($row['net_set2_remarks']);
            $net_set3_q3_remarks = getThirdRemarks($row['net_set3_remarks']);
            $net_set4_q3_remarks = getThirdRemarks($row['net_set4_remarks']);
            $net_set5_q3_remarks = getThirdRemarks($row['net_set5_remarks']);
            $hw_set1_q3_remarks = getThirdRemarks($row['hw_set1_remarks']);
            $hw_set2_q3_remarks = getThirdRemarks($row['hw_set2_remarks']);
            $hw_set3_q3_remarks = getThirdRemarks($row['hw_set3_remarks']);
            $hw_set4_q3_remarks = getThirdRemarks($row['hw_set4_remarks']);
            $sw1_q3_remarks = getThirdRemarks($row['sw1_remarks']);
            $sw2_q3_remarks = getThirdRemarks($row['sw2_remarks']);
            $sw3_q3_remarks = getThirdRemarks($row['sw3_remarks']);
            $sw4_q3_remarks = getThirdRemarks($row['sw4_remarks']);
            $sw5_q3_remarks = getThirdRemarks($row['sw5_remarks']);
            $sw6_q3_remarks = getThirdRemarks($row['sw6_remarks']);
            $sw7_q3_remarks = getThirdRemarks($row['sw7_remarks']);
            $sec1_q3_remarks = getThirdRemarks($row['sec1_remarks']);
            $sec2_q3_remarks = getThirdRemarks($row['sec2_remarks']);
            $sec3_q3_remarks = getThirdRemarks($row['sec3_remarks']);
            $gen_main1_q3_remarks = getThirdRemarks($row['gen_main1_remarks']);
            $gen_main2_q3_remarks = getThirdRemarks($row['gen_main2_remarks']);
            $gen_main3_q3_remarks = getThirdRemarks($row['gen_main3_remarks']);
            $gen_main4_q3_remarks = getThirdRemarks($row['gen_main4_remarks']);
            $gen_main5_q3_remarks = getThirdRemarks($row['gen_main5_remarks']);
            $gen_main6_q3_remarks = getThirdRemarks($row['gen_main6_remarks']);
            $gen_main7_q3_remarks = getThirdRemarks($row['gen_main7_remarks']);
            $gen_main8_q3_remarks = getThirdRemarks($row['gen_main8_remarks']);
            $per_dev1_q3_remarks = getThirdRemarks($row['per_dev1_remarks']);
            $per_dev2_q3_remarks = getThirdRemarks($row['per_dev2_remarks']);
            $per_dev3_q3_remarks = getThirdRemarks($row['per_dev3_remarks']);
            $per_dev4_q3_remarks = getThirdRemarks($row['per_dev4_remarks']);
            $per_dev5_q3_remarks = getThirdRemarks($row['per_dev5_remarks']);
            $per_dev6_q3_remarks = getThirdRemarks($row['per_dev6_remarks']);

            $quarter3_user = $row['user_name'];
            $perform_q3_month_day = date('m-d', strtotime($row['created_at']));
            break;
        case '4':
            $sys1_q4 = getIcon($row['sys1']);
            $sys2_q4 = getIcon($row['sys2']);
            $net_set1_q4 = getIcon($row['net_set1']);
            $net_set2_q4 = getIcon($row['net_set2']);
            $net_set3_q4 = getIcon($row['net_set3']);
            $net_set4_q4 = getIcon($row['net_set4']);
            $net_set5_q4 = getIcon($row['net_set5']);
            $hw_set1_q4 = getIcon($row['hw_set1']);
            $hw_set2_q4 = getIcon($row['hw_set2']);
            $hw_set3_q4 = getIcon($row['hw_set3']);
            $hw_set4_q4 = getIcon($row['hw_set4']);
            $sw1_q4 = getIcon($row['sw1']);
            $sw2_q4 = getIcon($row['sw2']);
            $sw3_q4 = getIcon($row['sw3']);
            $sw4_q4 = getIcon($row['sw4']);
            $sw5_q4 = getIcon($row['sw5']);
            $sw6_q4 = getIcon($row['sw6']);
            $sw7_q4 = getIcon($row['sw7']);
            $sec1_q4 = getIcon($row['sec1']);
            $sec2_q4 = getIcon($row['sec2']);
            $sec3_q4 = getIcon($row['sec3']);
            $gen_main1_q4 = getIcon($row['gen_main1']);
            $gen_main2_q4 = getIcon($row['gen_main2']);
            $gen_main3_q4 = getIcon($row['gen_main3']);
            $gen_main4_q4 = getIcon($row['gen_main4']);
            $gen_main5_q4 = getIcon($row['gen_main5']);
            $gen_main6_q4 = getIcon($row['gen_main6']);
            $gen_main7_q4 = getIcon($row['gen_main7']);
            $gen_main8_q4 = getIcon($row['gen_main8']);
            $per_dev1_q4 = getIcon($row['per_dev1']);
            $per_dev2_q4 = getIcon($row['per_dev2']);
            $per_dev3_q4 = getIcon($row['per_dev3']);
            $per_dev4_q4 = getIcon($row['per_dev4']);
            $per_dev5_q4 = getIcon($row['per_dev5']);
            $per_dev6_q4 = getIcon($row['per_dev6']);

            $sys1_q4_remarks = getFourthRemarks($row['sys1_remarks']);
            $sys2_q4_remarks = getFourthRemarks($row['sys2_remarks']);
            $net_set1_q4_remarks = getFourthRemarks($row['net_set1_remarks']);
            $net_set2_q4_remarks = getFourthRemarks($row['net_set2_remarks']);
            $net_set3_q4_remarks = getFourthRemarks($row['net_set3_remarks']);
            $net_set4_q4_remarks = getFourthRemarks($row['net_set4_remarks']);
            $net_set5_q4_remarks = getFourthRemarks($row['net_set5_remarks']);
            $hw_set1_q4_remarks = getFourthRemarks($row['hw_set1_remarks']);
            $hw_set2_q4_remarks = getFourthRemarks($row['hw_set2_remarks']);
            $hw_set3_q4_remarks = getFourthRemarks($row['hw_set3_remarks']);
            $hw_set4_q4_remarks = getFourthRemarks($row['hw_set4_remarks']);
            $sw1_q4_remarks = getFourthRemarks($row['sw1_remarks']);
            $sw2_q4_remarks = getFourthRemarks($row['sw2_remarks']);
            $sw3_q4_remarks = getFourthRemarks($row['sw3_remarks']);
            $sw4_q4_remarks = getFourthRemarks($row['sw4_remarks']);
            $sw5_q4_remarks = getFourthRemarks($row['sw5_remarks']);
            $sw6_q4_remarks = getFourthRemarks($row['sw6_remarks']);
            $sw7_q4_remarks = getFourthRemarks($row['sw7_remarks']);
            $sec1_q4_remarks = getFourthRemarks($row['sec1_remarks']);
            $sec2_q4_remarks = getFourthRemarks($row['sec2_remarks']);
            $sec3_q4_remarks = getFourthRemarks($row['sec3_remarks']);
            $gen_main1_q4_remarks = getFourthRemarks($row['gen_main1_remarks']);
            $gen_main2_q4_remarks = getFourthRemarks($row['gen_main2_remarks']);
            $gen_main3_q4_remarks = getFourthRemarks($row['gen_main3_remarks']);
            $gen_main4_q4_remarks = getFourthRemarks($row['gen_main4_remarks']);
            $gen_main5_q4_remarks = getFourthRemarks($row['gen_main5_remarks']);
            $gen_main6_q4_remarks = getFourthRemarks($row['gen_main6_remarks']);
            $gen_main7_q4_remarks = getFourthRemarks($row['gen_main7_remarks']);
            $gen_main8_q4_remarks = getFourthRemarks($row['gen_main8_remarks']);
            $per_dev1_q4_remarks = getFourthRemarks($row['per_dev1_remarks']);
            $per_dev2_q4_remarks = getFourthRemarks($row['per_dev2_remarks']);
            $per_dev3_q4_remarks = getFourthRemarks($row['per_dev3_remarks']);
            $per_dev4_q4_remarks = getFourthRemarks($row['per_dev4_remarks']);
            $per_dev5_q4_remarks = getFourthRemarks($row['per_dev5_remarks']);
            $per_dev6_q4_remarks = getFourthRemarks($row['per_dev6_remarks']);

            $quarter4_user = $row['user_name'];
            $perform_q4_month_day = date('m-d', strtotime($row['created_at']));
            break;
        default:
            break;
    }

    $tbl = <<<EOD
    <table border="1">

    <tr>
    <th align="center" rowspan="2">ITEM <br> No.</th>
    <th align="center" rowspan="2" colspan="2"><br><br>TASK</th>
    <th align="center" rowspan="2" colspan="5"><br><br>DESCRIPTION</th>
    <th align="center" colspan="4">QUARTER</th>
    <th align="center" rowspan="2" colspan="2"><br><br>REMARKS</th>
    </tr>
    <tr>
    <th align="center">1st</th>
    <th align="center">2nd</th>
    <th align="center">3rd</th>
    <th align="center">4th</th>
    </tr>

    <tr>
    <td rowspan="2" align="center"><br><br>1</td>
    <td rowspan="2" colspan="2" align="center"><br><br>System</td>
    <td colspan="5">Check start up errors and speed of entire boot process</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys1_q4}</td>
    <td colspan="2" style="padding-bottom: -1rem;">
        $sys1_q1_remarks
        $sys1_q2_remarks
        $sys1_q3_remarks 
        $sys1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check log-in process</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sys2_q4}</td>
    <td colspan="2">
        $sys2_q1_remarks
        $sys2_q2_remarks
        $sys2_q3_remarks 
        $sys2_q4_remarks
    </td>
    </tr>

    <tr>
    <td rowspan="5" align="center"><br><br><br>2</td>
    <td rowspan="5" colspan="2" align="center"><br><br><br>NETWORK SETTINGS</td>
    <td colspan="5">Check TCP/IP</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set1_q4}</td>
    <td colspan="2">
        $net_set1_q1_remarks
        $net_set1_q2_remarks
        $net_set1_q3_remarks
        $net_set1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check Domain name</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set2_q4}</td>
    <td colspan="2">
        $net_set2_q1_remarks
        $net_set2_q2_remarks
        $net_set2_q3_remarks
        $net_set2_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check Computer name</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set3_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set3_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set3_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set3_q4}</td>
    <td colspan="2">
        $net_set3_q1_remarks
        $net_set3_q2_remarks
        $net_set3_q3_remarks
        $net_set3_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check Fileserver folder mapping</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set4_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set4_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set4_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set4_q4}</td>
    <td colspan="2">
        $net_set4_q1_remarks
        $net_set4_q2_remarks
        $net_set4_q3_remarks
        $net_set4_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check if unit is connected to the network</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set5_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set5_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set5_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$net_set5_q4}</td>
    <td colspan="2">
        $net_set5_q1_remarks
        $net_set5_q2_remarks
        $net_set5_q3_remarks
        $net_set5_q4_remarks
    </td>
    </tr>

    <tr>
    <td rowspan="4" align="center"><br><br>3</td>
    <td rowspan="4" colspan="2" align="center"><br><br>HARDWARE SETTINGS</td>
    <td colspan="5">Check hard disk usage</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set1_q4}</td>
    <td colspan="2">
        $hw_set1_q1_remarks
        $hw_set1_q2_remarks
        $hw_set1_q3_remarks
        $hw_set1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check RAM usage</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set2_q4}</td>
    <td colspan="2">
        $hw_set2_q1_remarks
        $hw_set2_q2_remarks
        $hw_set2_q3_remarks
        $hw_set2_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check Processor usage</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set3_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set3_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set3_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set3_q4}</td>
    <td colspan="2">
        $hw_set3_q1_remarks
        $hw_set3_q2_remarks
        $hw_set3_q3_remarks
        $hw_set3_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">For Laptop: Battery run time is normal</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set4_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set4_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set4_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$hw_set4_q4}</td>
    <td colspan="2">
        $hw_set4_q1_remarks
        $hw_set4_q2_remarks
        $hw_set4_q3_remarks
        $hw_set4_q4_remarks
    </td>
    </tr>


    <tr>
    <td rowspan="7" align="center"><br><br><br><br><br>4</td>
    <td rowspan="7" colspan="2" align="center"><br><br><br><br><br>SOFTWARE</td>
    <td colspan="5">Check if the required software is installed and operational</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw1_q4}</td>
    <td colspan="2">
        $sw1_q1_remarks
        $sw1_q2_remarks
        $sw1_q3_remarks
        $sw1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Make sure windows, drivers and softwares are up-to-date</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw2_q4}</td>
    <td colspan="2">
        $sw2_q1_remarks
        $sw2_q2_remarks
        $sw2_q3_remarks
        $sw2_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Verify proper settings and operation</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw3_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw3_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw3_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw3_q4}</td>
    <td colspan="2">
        $sw3_q1_remarks
        $sw3_q2_remarks
        $sw3_q3_remarks
        $sw3_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Clearing of browsing history if necessary</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw4_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw4_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw4_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw4_q4}</td>
    <td colspan="2">
        $sw4_q1_remarks
        $sw4_q2_remarks
        $sw4_q3_remarks
        $sw4_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check Operating System Licensing</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw5_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw5_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw5_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw5_q4}</td>
    <td colspan="2">
        $sw5_q1_remarks
        $sw5_q2_remarks
        $sw5_q3_remarks
        $sw5_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check Microsoft Office Licensing</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw6_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw6_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw6_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw6_q4}</td>
    <td colspan="2">
        $sw6_q1_remarks
        $sw6_q2_remarks
        $sw6_q3_remarks
        $sw6_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Other Software Licensing</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw7_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw7_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw7_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sw7_q4}</td>
    <td colspan="2">
        $sw7_q1_remarks
        $sw7_q2_remarks
        $sw7_q3_remarks
        $sw7_q4_remarks
    </td>   
    </tr>


    <tr>
    <td rowspan="3" align="center"><br><br><br>5</td>
    <td rowspan="3" colspan="2" align="center"><br><br><br>SECURITY</td>
    <td colspan="5">Conduct windows security full scan to check for virus threats</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec1_q4}</td>
    <td colspan="2">
        $sec1_q1_remarks
        $sec1_q2_remarks
        $sec1_q3_remarks
        $sec1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Ensure Windows Security turn on</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec2_q4}</td>
    <td colspan="2">
        $sec2_q1_remarks
        $sec2_q2_remarks
        $sec2_q3_remarks
        $sec2_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Clean potentially unwanted files and invalid Windows Registry</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec3_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec3_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec3_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$sec3_q4}</td>
    <td colspan="2">
        $sec3_q1_remarks
        $sec3_q2_remarks
        $sec3_q3_remarks
        $sec3_q4_remarks
    </td>
    </tr>


    <tr>
    <td rowspan="8" align="center"><br><br><br><br><br>6</td>
    <td rowspan="8" colspan="2" align="center"><br><br><br><br><br>GENERAL MAINTENANCE</td>
    <td colspan="5">Remove dust from system unit</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main1_q4}</td>
    <td colspan="2">
        $gen_main1_q1_remarks
        $gen_main1_q2_remarks
        $gen_main1_q3_remarks
        $gen_main1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">check airflow and fans if working</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main2_q4}</td>
    <td colspan="2">
        $gen_main2_q1_remarks
        $gen_main2_q2_remarks
        $gen_main2_q3_remarks
        $gen_main2_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Perform dsk cleanup to remove junk and temporary files</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main3_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main3_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main3_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main3_q4}</td>
    <td colspan="2">
        $gen_main3_q1_remarks
        $gen_main3_q2_remarks
        $gen_main3_q3_remarks
        $gen_main3_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Check thermal paste of CPU and GPU then apply if necessary</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main4_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main4_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main4_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main4_q4}</td>
    <td colspan="2">
        $gen_main4_q1_remarks
        $gen_main4_q2_remarks
        $gen_main4_q3_remarks
        $gen_main4_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Defragment the hard drive</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main5_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main5_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main5_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main5_q4}</td>
    <td colspan="2">
        $gen_main5_q1_remarks
        $gen_main5_q2_remarks
        $gen_main5_q3_remarks
        $gen_main5_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Clear the Recycle Bin</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main6_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main6_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main6_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main6_q4}</td>
    <td colspan="2">
        $gen_main6_q1_remarks
        $gen_main6_q2_remarks
        $gen_main6_q3_remarks
        $gen_main6_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Remove unused programs</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main7_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main7_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main7_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main7_q4}</td>
    <td colspan="2">
        $gen_main7_q1_remarks
        $gen_main7_q2_remarks
        $gen_main7_q3_remarks
        $gen_main7_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Clean Peripheral devices</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main8_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main8_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main8_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$gen_main8_q4}</td>
    <td colspan="2">
        $gen_main8_q1_remarks
        $gen_main8_q2_remarks
        $gen_main8_q3_remarks
        $gen_main8_q4_remarks
    </td>
    </tr>


    <tr>
    <td rowspan="6" align="center"><br><br><br>7</td>
    <td rowspan="6" colspan="2" align="center"><br><br><br>PERIPHERAL DEVICES</td>
    <td colspan="5">Mouse working properly</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev1_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev1_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev1_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev1_q4}</td>
    <td colspan="2">
        $per_dev1_q1_remarks
        $per_dev1_q2_remarks
        $per_dev1_q3_remarks
        $per_dev1_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Keyboard working properly</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev2_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev2_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev2_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev2_q4}</td>
    <td colspan="2">
        $per_dev2_q1_remarks
        $per_dev2_q2_remarks
        $per_dev2_q3_remarks
        $per_dev2_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Monitor working properly</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev3_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev3_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev3_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev3_q4}</td>
    <td colspan="2">
        $per_dev3_q1_remarks
        $per_dev3_q2_remarks
        $per_dev3_q3_remarks
        $per_dev3_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">UPS/AVR working properly</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev4_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev4_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev4_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev4_q4}</td>
    <td colspan="2">
        $per_dev4_q1_remarks
        $per_dev4_q2_remarks
        $per_dev4_q3_remarks
        $per_dev4_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Printer working properly</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev5_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev5_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev5_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev5_q4}</td>
    <td colspan="2">
        $per_dev5_q1_remarks
        $per_dev5_q2_remarks
        $per_dev5_q3_remarks
        $per_dev5_q4_remarks
    </td>
    </tr>
    <tr>
    <td colspan="5">Telephone working properly</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev6_q1}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev6_q2}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev6_q3}</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$per_dev6_q4}</td>
    <td colspan="2">
        $per_dev6_q1_remarks
        $per_dev6_q2_remarks
        $per_dev6_q3_remarks
        $per_dev6_q4_remarks
    </td>
    </tr>

    <tr>
    <th rowspan="4" colspan="6"><br><br><br><br><br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Legends: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#10003; : OK (input remarks, if any) <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#10005;  : Not OK (input remarks) <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NA : Not applicable </th>
    <th align="center" rowspan="2" colspan="2"><br><br>Performed by: <br> (ex.; J. Dela Cruz & Signature)<br></th>
    <td align="center">{$quarter1_user}</td>
    <td align="center">{$quarter2_user}</td>
    <td align="center">{$quarter3_user}</td>
    <td align="center">{$quarter4_user}</td>
    <td align="center" rowspan="2" colspan="2"><br><br><br>{$year}</td>
    </tr>
    <tr>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    </tr>
    <tr>
    <th align="center" colspan="2">DATE PERFORMED: <br> (mm/dd/yy)</th>
    <td align="center"><br><br>{$perform_q1_month_day}</td>
    <td align="center"><br><br>{$perform_q2_month_day}</td>
    <td align="center"><br><br>{$perform_q3_month_day}</td>
    <td align="center"><br><br>{$perform_q4_month_day}</td>
    <th align="center" colspan="2"><br><br>Year</th>
    </tr>
    <tr>
    <td align="center" colspan="2"><br>Noted by: <br> (ex.; J. Dela Cruz & Signature)</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" style="color: red;"><br><br>FN.Last<br>name</td>
    <td align="center" colspan="2"><br><br>yy</td>
    </tr>

    </table>
    EOD;
} // closing for the foreach

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$pdf->Output();
