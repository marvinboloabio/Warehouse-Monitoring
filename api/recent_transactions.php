<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';

$dbClass = new Database();
$db = $dbClass->connect();

// Fetch latest 10 transactions (deliveries and withdrawals combined)
$sql = "
SELECT
    date_receive AS date,
    i.item_description AS item_name,
    'Delivery' AS type,
    weight_scale AS quantity,
    remarks
FROM deliveries d
JOIN items i ON d.item_description = i.item_id

UNION ALL

SELECT
    date_withdrawal AS date,
    i.item_description AS item_name,
    'Withdrawal' AS type,
    total_qty AS quantity,
    remarks
FROM withdrawals w
JOIN items i ON w.item_description = i.item_id

ORDER BY date DESC
LIMIT 10
";

$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);