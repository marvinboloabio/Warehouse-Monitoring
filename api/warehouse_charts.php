<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once __DIR__ . '/../config/Database.php';

// Connect to SQLite
$dbClass = new Database();
$db = $dbClass->connect();

/*
 Deliveries = SUM(weight_scale)
 Withdrawals = SUM(total_qty)
 Grouped per item
*/
$sql = "
SELECT
    i.item_description AS item_name,
    COALESCE(SUM(d.weight_scale), 0) AS total_deliveries,
    COALESCE(SUM(w.total_qty), 0) AS total_withdrawals
FROM items i
LEFT JOIN deliveries d ON d.item_description = i.item_id
LEFT JOIN withdrawals w ON w.item_description = i.item_id
GROUP BY i.item_id, i.item_description
ORDER BY i.item_description ASC
";

$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$deliveries = [];
$withdrawals = [];

foreach ($rows as $row) {
    $labels[] = $row['item_name'];
    $deliveries[] = (float)$row['total_deliveries'];
    $withdrawals[] = (float)$row['total_withdrawals'];
}

echo json_encode([
    'labels' => $labels,
    'deliveries' => $deliveries,
    'withdrawals' => $withdrawals
]);
