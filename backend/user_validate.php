<?php

require_once __DIR__ . '/../conn.php';

$userid = $_SESSION['UserID'];

$sql = <<<'SQL'
    SELECT *
    FROM user 
    WHERE userid = :userid;
SQL;

$stmt = $pdo->prepare($sql); 
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display Verify PMS if the user role is admin
foreach ($result as $row) {
    if ($row['user_role'] === 1) {
        echo '<a class="collapse-item" href="../pms/verify_pms.php" id="verify_pms" style="text-decoration:none;color:#333;">VERIFY PMS</a>';
        break;
    }
    echo '';
}