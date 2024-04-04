<?php

require_once __DIR__ . '/../conn.php';

$input_asset_id = $_GET['inputValue'];

$sql = <<<'SQL'
    SELECT DISTINCT equipment_code 
    FROM non_consumable_item 
    WHERE status = 'ACTIVE'
    AND equipment_code LIKE :inputValue 
    AND item_code IN ('DC', 'LC') 
    LIMIT 10;
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':inputValue', '%' . $input_asset_id . '%', PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}