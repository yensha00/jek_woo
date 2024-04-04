<?php

require_once __DIR__ . '/../conn.php';

$telephone_asset_id = $_GET['telephoneAssetId'];

$sql = <<<'SQL'
    SELECT DISTINCT equipment_code 
    FROM non_consumable_item 
    WHERE status = 'ACTIVE'
    AND equipment_code LIKE :equipment_code 
    AND item_code IN ('TP') 
    LIMIT 5;
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':equipment_code', '%' . $telephone_asset_id . '%', PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}