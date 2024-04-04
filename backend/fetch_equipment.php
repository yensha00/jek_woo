<?php

require_once __DIR__ . '/../conn.php';

$equipment_code = $_POST['equipmentCode'];

$sql = <<<'SQL'
    SELECT 
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
    $stmt->bindParam(':equipment_code', $equipment_code, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'username' => $result['username'],
        'processor' => $result['processor'],
        'ram' => $result['ram'],
        'location' => $result['location']
    ]);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}