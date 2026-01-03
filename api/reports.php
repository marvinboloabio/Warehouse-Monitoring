<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/Database.php';
header('Content-Type: application/json');

$conn = (new Database())->connect();

// GET parameters
$start = $_GET['start_date'] ?? '';
$end = $_GET['end_date'] ?? '';
$item = $_GET['item_id'] ?? null;

// Prepare subquery filters
$startFilter = $start ? "AND date_receive >= :start" : "";
$endFilter   = $end ? "AND date_receive <= :end" : "";
$startFilterW = $start ? "AND date_withdrawal >= :start" : "";
$endFilterW   = $end ? "AND date_withdrawal <= :end" : "";

// Base SQL with subqueries for deliveries and withdrawals
$sql = "
SELECT 
    i.item_code,
    i.item_description,
    COALESCE((SELECT SUM(weight_scale) FROM deliveries WHERE item_description = i.item_id $startFilter $endFilter),0) AS total_deliveries,
    COALESCE((SELECT SUM(total_qty) FROM withdrawals WHERE item_description = i.item_id $startFilterW $endFilterW),0) AS total_withdrawals,
    COALESCE((SELECT SUM(weight_scale) FROM deliveries WHERE item_description = i.item_id $startFilter $endFilter),0)
    - COALESCE((SELECT SUM(total_qty) FROM withdrawals WHERE item_description = i.item_id $startFilterW $endFilterW),0) AS stock_balance
FROM items i
";

// Filter by item if selected
if ($item) {
    $sql .= " WHERE i.item_id = :item";
}

$sql .= " ORDER BY i.item_description ASC";

$stmt = $conn->prepare($sql);

// Bind parameters
if ($start) {
    $stmt->bindValue(':start', $start);
}
if ($end) {
    $stmt->bindValue(':end', $end);
}
if ($item) {
    $stmt->bindValue(':item', $item, PDO::PARAM_INT);
}

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="warehouse_report.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Item Code','Item Description','Total Deliveries','Total Withdrawals','Stock Balance']);
    foreach ($rows as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// JSON for AJAX
echo json_encode($rows);
