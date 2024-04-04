<?php

session_start();

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/function.php';

date_default_timezone_set('Asia/Manila');

$_SESSION['UserID'] = 6;

$quarter = $_POST['quarter'];
$task_id = $_POST['task-id'];
$asset_id = $_POST['asset-id'];
$computer_name = $_POST['computer-name'];
$sys1 = $_POST['sys1'];
$sys1_remarks = $_POST['sys1-remarks'];
$sys2 = $_POST['sys2'];
$sys2_remarks = $_POST['sys2-remarks'];
$net_set1 = $_POST['net-set1'];
$net_set1_remarks = $_POST['net-set1-remarks'];
$net_set2 = $_POST['net-set2'];
$net_set2_remarks= $_POST['net-set2-remarks'];
$net_set3 = $_POST['net-set3'];
$net_set3_remarks = $_POST['net-set3-remarks'];
$net_set4 = $_POST['net-set4'];
$net_set4_remarks = $_POST['net-set4-remarks'];
$net_set5 = $_POST['net-set5'];
$net_set5_remarks = $_POST['net-set5-remarks'];
$hw_set1 = $_POST['hw-set1'];
$hw_set1_remarks= $_POST['hw-set1-remarks'];
$hw_set2 = $_POST['hw-set2'];
$hw_set2_remarks = $_POST['hw-set2-remarks'];
$hw_set3 = $_POST['hw-set3'];
$hw_set3_remarks = $_POST['hw-set3-remarks'];
$hw_set4 = $_POST['hw-set4'];
$hw_set4_remarks = $_POST['hw-set4-remarks'];
$sw1 = $_POST['sw1'];
$sw1_remarks = $_POST['sw1-remarks'];
$sw2 = $_POST['sw2'];
$sw2_remarks = $_POST['sw2-remarks'];
$sw3 = $_POST['sw3'];
$sw3_remarks = $_POST['sw3-remarks'];
$sw4 = $_POST['sw4'];
$sw4_remarks = $_POST['sw4-remarks'];
$sw5 = $_POST['sw5'];
$sw5_remarks = $_POST['sw5-remarks'];
$sw6 = $_POST['sw6'];
$sw6_remarks = $_POST['sw6-remarks'];
$sw7 = $_POST['sw7'];
$sw7_remarks = $_POST['sw7-remarks'];
$sec1 = $_POST['sec1'];
$sec1_remarks = $_POST['sec1-remarks'];
$sec2 = $_POST['sec2'];
$sec2_remarks = $_POST['sec2-remarks'];
$sec3 = $_POST['sec3'];
$sec3_remarks = $_POST['sec3-remarks'];
$gen_main1 = $_POST['gen-main1'];
$gen_main1_remarks = $_POST['gen-main1-remarks'];
$gen_main2 = $_POST['gen-main2'];
$gen_main2_remarks = $_POST['gen-main2-remarks'];
$gen_main3 = $_POST['gen-main3'];
$gen_main3_remarks = $_POST['gen-main3-remarks'];
$gen_main4 = $_POST['gen-main4'];
$gen_main4_remarks = $_POST['gen-main4-remarks'];
$gen_main5 = $_POST['gen-main5'];
$gen_main5_remarks = $_POST['gen-main5-remarks'];
$gen_main6 = $_POST['gen-main6'];
$gen_main6_remarks = $_POST['gen-main6-remarks'];
$gen_main7 = $_POST['gen-main7'];
$gen_main7_remarks = $_POST['gen-main7-remarks'];
$gen_main8 = $_POST['gen-main8'];
$gen_main8_remarks = $_POST['gen-main8-remarks'];
$per_dev1 = $_POST['per-dev1'];
$per_dev1_remarks = $_POST['per-dev1-remarks'];
$per_dev2 = $_POST['per-dev2'];
$per_dev2_remarks = $_POST['per-dev2-remarks'];
$per_dev3 = $_POST['per-dev3'];
$per_dev3_remarks = $_POST['per-dev3-remarks'];
$per_dev4 = $_POST['per-dev4'];
$per_dev4_remarks = $_POST['per-dev4-remarks'];
$per_dev5 = $_POST['per-dev5'];
$per_dev5_remarks = $_POST['per-dev5-remarks'];
$per_dev6 = $_POST['per-dev6'];
$per_dev6_remarks = $_POST['per-dev6-remarks'];
$added_by = $_SESSION['UserID'];
$insert_date = date('Y-m-d H:i:s');

$mouse_asset_id = $_POST['mouse-asset-id'] ?? null;
$keyboard_asset_id = $_POST['keyboard-asset-id'] ?? null;
$monitor_asset_id = $_POST['monitor-asset-id'] ?? null;
$upsavr_asset_id = $_POST['upsavr-asset-id'] ?? null;
$printer_asset_id = $_POST['printer-asset-id'] ?? null;
$telephone_asset_id = $_POST['telephone-asset-id'] ?? null;

$validated_task_id = validateTaskId($pdo, $task_id);

if (is_string($validated_task_id)) {
    echo $validated_task_id;
    exit();
}

$select_sql = <<<'SQL'
    SELECT COUNT(*) AS submissions 
    FROM pms 
    WHERE asset_id = :asset_id 
    AND YEAR(created_at) != YEAR(NOW()) 
    GROUP BY YEAR(created_at);
SQL;

$insert_sql = <<<'SQL'
    INSERT INTO pms (quarter, task_id, asset_id, computer_name, sys1, sys1_remarks, sys2, sys2_remarks, net_set1, net_set1_remarks, net_set2, net_set2_remarks, net_set3, net_set3_remarks, net_set4, net_set4_remarks, net_set5, net_set5_remarks, hw_set1, hw_set1_remarks, hw_set2, hw_set2_remarks, hw_set3, hw_set3_remarks, hw_set4, hw_set4_remarks, sw1, sw1_remarks, sw2, sw2_remarks, sw3, sw3_remarks, sw4, sw4_remarks, sw5, sw5_remarks, sw6, sw6_remarks, sw7, sw7_remarks, sec1, sec1_remarks, sec2, sec2_remarks, sec3, sec3_remarks, gen_main1, gen_main1_remarks, gen_main2, gen_main2_remarks, gen_main3, gen_main3_remarks, gen_main4, gen_main4_remarks, gen_main5, gen_main5_remarks, gen_main6, gen_main6_remarks, gen_main7, gen_main7_remarks, gen_main8, gen_main8_remarks, per_dev1, per_dev1_remarks, per_dev2, per_dev2_remarks, per_dev3, per_dev3_remarks, per_dev4, per_dev4_remarks, per_dev5, per_dev5_remarks, per_dev6, per_dev6_remarks, userid, updated_at, created_at) 
    VALUES (:quarter, :task_id, :asset_id, :computer_name, :sys1, :sys1_remarks, :sys2, :sys2_remarks, :net_set1, :net_set1_remarks, :net_set2, :net_set2_remarks, :net_set3, :net_set3_remarks, :net_set4, :net_set4_remarks, :net_set5, :net_set5_remarks, :hw_set1, :hw_set1_remarks, :hw_set2, :hw_set2_remarks, :hw_set3, :hw_set3_remarks, :hw_set4, :hw_set4_remarks, :sw1, :sw1_remarks, :sw2, :sw2_remarks, :sw3, :sw3_remarks, :sw4, :sw4_remarks, :sw5, :sw5_remarks, :sw6, :sw6_remarks, :sw7, :sw7_remarks, :sec1, :sec1_remarks, :sec2, :sec2_remarks, :sec3, :sec3_remarks, :gen_main1, :gen_main1_remarks, :gen_main2, :gen_main2_remarks, :gen_main3, :gen_main3_remarks, :gen_main4, :gen_main4_remarks, :gen_main5, :gen_main5_remarks, :gen_main6, :gen_main6_remarks, :gen_main7, :gen_main7_remarks, :gen_main8, :gen_main8_remarks, :per_dev1, :per_dev1_remarks, :per_dev2, :per_dev2_remarks, :per_dev3, :per_dev3_remarks, :per_dev4, :per_dev4_remarks, :per_dev5, :per_dev5_remarks, :per_dev6, :per_dev6_remarks, :userid, :updated_at, :created_at);
SQL;

try {
    $stmt_check = $pdo->prepare($select_sql);
    $stmt_check->bindParam(':asset_id', $asset_id, PDO::PARAM_STR);
    $stmt_check->execute();
    $submission_counts = $stmt_check->fetchAll(PDO::FETCH_ASSOC);

    if (count($submission_counts) < 4) {
        $stmt = $pdo->prepare($insert_sql);
        $stmt->bindParam(':quarter', $quarter, PDO::PARAM_STR);
        $stmt->bindParam(':task_id', $task_id, PDO::PARAM_STR);
        $stmt->bindParam(':asset_id', $asset_id, PDO::PARAM_STR);
        $stmt->bindParam(':computer_name', $computer_name, PDO::PARAM_STR);
        $stmt->bindParam(':sys1', $sys1, PDO::PARAM_STR);
        $stmt->bindParam(':sys1_remarks', $sys1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sys2', $sys2, PDO::PARAM_STR);
        $stmt->bindParam(':sys2_remarks', $sys2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':net_set1', $net_set1, PDO::PARAM_STR);
        $stmt->bindParam(':net_set1_remarks', $net_set1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':net_set2', $net_set2, PDO::PARAM_STR);
        $stmt->bindParam(':net_set2_remarks', $net_set2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':net_set3', $net_set3, PDO::PARAM_STR);
        $stmt->bindParam(':net_set3_remarks', $net_set3_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':net_set4', $net_set4, PDO::PARAM_STR);
        $stmt->bindParam(':net_set4_remarks', $net_set4_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':net_set5', $net_set5, PDO::PARAM_STR);
        $stmt->bindParam(':net_set5_remarks', $net_set5_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set1', $hw_set1, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set1_remarks', $hw_set1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set2', $hw_set2, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set2_remarks', $hw_set2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set3', $hw_set3, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set3_remarks', $hw_set3_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set4', $hw_set4, PDO::PARAM_STR);
        $stmt->bindParam(':hw_set4_remarks', $hw_set4_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw1', $sw1, PDO::PARAM_STR);
        $stmt->bindParam(':sw1_remarks', $sw1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw2', $sw2, PDO::PARAM_STR);
        $stmt->bindParam(':sw2_remarks', $sw2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw3', $sw3, PDO::PARAM_STR);
        $stmt->bindParam(':sw3_remarks', $sw3_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw4', $sw4, PDO::PARAM_STR);
        $stmt->bindParam(':sw4_remarks', $sw4_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw5', $sw5, PDO::PARAM_STR);
        $stmt->bindParam(':sw5_remarks', $sw5_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw6', $sw6, PDO::PARAM_STR);
        $stmt->bindParam(':sw6_remarks', $sw6_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sw7', $sw7, PDO::PARAM_STR);
        $stmt->bindParam(':sw7_remarks', $sw7_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sec1', $sec1, PDO::PARAM_STR);
        $stmt->bindParam(':sec1_remarks', $sec1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sec2', $sec2, PDO::PARAM_STR);
        $stmt->bindParam(':sec2_remarks', $sec2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sec3', $sec3, PDO::PARAM_STR);
        $stmt->bindParam(':sec3_remarks', $sec3_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main1', $gen_main1, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main1_remarks', $gen_main1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main2', $gen_main2, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main2_remarks', $gen_main2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main3', $gen_main3, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main3_remarks', $gen_main3_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main4', $gen_main4, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main4_remarks', $gen_main4_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main5', $gen_main5, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main5_remarks', $gen_main5_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main6', $gen_main6, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main6_remarks', $gen_main6_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main7', $gen_main7, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main7_remarks', $gen_main7_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main8', $gen_main8, PDO::PARAM_STR);
        $stmt->bindParam(':gen_main8_remarks', $gen_main8_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev1', $per_dev1, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev1_remarks', $per_dev1_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev2', $per_dev2, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev2_remarks', $per_dev2_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev3', $per_dev3, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev3_remarks', $per_dev3_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev4', $per_dev4, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev4_remarks', $per_dev4_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev5', $per_dev5, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev5_remarks', $per_dev5_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev6', $per_dev6, PDO::PARAM_STR);
        $stmt->bindParam(':per_dev6_remarks', $per_dev6_remarks, PDO::PARAM_STR);
        $stmt->bindParam(':userid', $added_by, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $insert_date, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $insert_date, PDO::PARAM_STR);
        $stmt->execute();

        insertItemHistory($pdo, $quarter, $task_id, $asset_id, $added_by);

        insertItemHistory($pdo, $quarter, $task_id, $mouse_asset_id, $added_by);
        insertItemHistory($pdo, $quarter, $task_id, $keyboard_asset_id, $added_by);
        insertItemHistory($pdo, $quarter, $task_id, $monitor_asset_id, $added_by);
        insertItemHistory($pdo, $quarter, $task_id, $upsavr_asset_id, $added_by);
        insertItemHistory($pdo, $quarter, $task_id, $printer_asset_id, $added_by);
        insertItemHistory($pdo, $quarter, $task_id, $telephone_asset_id, $added_by);

        echo json_encode(['status' => 'success', 'message' => 'PMS SAVED!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'MAXIMUM PMS REACHED FOR THIS ASSET ID.']);
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}