<?php

function insertItemHistory($pdo, $quarter, $task_id, $asset_id, $added_by) {
    try {
        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $remarks = 'PMS Conducted';
        $problem = setQuarter($quarter);
        $solution = 'Conduct PMS';

        $item_id_sql = <<<'SQL'
            SELECT itemid 
            FROM non_consumable_item 
            WHERE equipment_code = :equipment_code;
        SQL;

        $insert_sql = <<<'SQL'
            INSERT INTO item_history (itemid, datesrf, srf, problem, solution, remarks, added_on, added_by) 
            VALUES (:itemid, :datesrf, :srf, :problem, :solution, :remarks, :added_on, :added_by);
        SQL;

        $item_id_stmt = $pdo->prepare($item_id_sql);
        $item_id_stmt->bindParam(':equipment_code', $asset_id, PDO::PARAM_STR);
        $item_id_stmt->execute();
        $item_ids = $item_id_stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($item_ids as $item_id) {
            $stmt = $pdo->prepare($insert_sql);
            $stmt->bindParam(':itemid', $item_id, PDO::PARAM_INT);
            $stmt->bindValue(':datesrf', $date, PDO::PARAM_STR);
            $stmt->bindValue(':srf', $task_id, PDO::PARAM_STR);
            $stmt->bindValue(':problem', $problem, PDO::PARAM_STR);
            $stmt->bindValue(':solution', $solution, PDO::PARAM_STR);
            $stmt->bindValue(':remarks', $remarks, PDO::PARAM_STR);
            $stmt->bindValue(':added_on',$datetime, PDO::PARAM_STR);
            $stmt->bindParam(':added_by', $added_by, PDO::PARAM_INT);
            $stmt->execute();
        }

        return true;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function validateTaskId($pdo, $task_id) {
    try {
        $fetch_sql = <<<'SQL'
            SELECT COUNT(*) 
            FROM pms 
            WHERE task_id = :task_id;
        SQL;
            
        $stmt = $pdo->prepare($fetch_sql);
        $stmt->bindParam(':task_id',  $task_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return json_encode(['status' => 'error', 'message' => 'TASK ID ALREADY EXISTS.']);
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function setQuarter($quarter) {
    switch($quarter) {
        case '1':
            return '1st Quarter';
        case '2':
            return '2nd Quarter';
        case '3':
            return '3rd Quarter';
        case '4':
            return '4th Quarter';
        default:
            return 'Unknown Quarter';
    }
}