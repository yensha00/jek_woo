<?php

$database = [
    'db_host' => 'localhost',
    'db_name' => 'ict_asset',
    'db_user' => 'root',
    'db_pass' => ''
];

try {
    $dsn = "mysql:host={$database['db_host']};dbname={$database['db_name']}";
    $pdo = new PDO($dsn, $database['db_user'], $database['db_pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    throw new PDOException('Database connection failed. Error: ' . $e->getMessage());
}