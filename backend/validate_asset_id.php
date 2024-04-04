<?php

require_once __DIR__ . '/../conn.php';

$asset_id = $_POST['assetId'];
$quarter = $_POST['quarter'];

$sql = <<<'SQL'
    SELECT * 
    FROM pms 
    WHERE asset_id = :asset_id 
    AND quarter = :quarter;
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':asset_id', $asset_id, PDO::PARAM_STR);
    $stmt->bindParam(':quarter', $quarter, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'ASSET ID ALREADY EXISTS FOR THIS QUARTER.']);
    } else {
        echo json_encode(['status' => 'success', 'message' => '']);
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}