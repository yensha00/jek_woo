<?php

require_once __DIR__ . '/../conn.php';

$asset_id = $_POST['assetId'];

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
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}