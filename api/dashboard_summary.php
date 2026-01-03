<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';

$dbClass = new Database();
$conn = $dbClass->connect();

// Total Items
$totalItems = $conn->query("SELECT COUNT(*) AS total FROM items")->fetch(PDO::FETCH_ASSOC)['total'];

// Total Deliveries (all-time)
$totalDeliveries = $conn->query("SELECT COALESCE(SUM(weight_scale),0) AS total FROM deliveries")->fetch(PDO::FETCH_ASSOC)['total'];

// Total Withdrawals (all-time)
$totalWithdrawals = $conn->query("SELECT COALESCE(SUM(total_qty),0) AS total FROM withdrawals")->fetch(PDO::FETCH_ASSOC)['total'];

// Current Stock
$currentStock = $conn->query("
    SELECT COALESCE(SUM(beg_bal + total_deliveries - total_withdrawals),0) AS total
    FROM warehouse_monitor
")->fetch(PDO::FETCH_ASSOC)['total'];

echo json_encode([
    'total_items' => $totalItems,
    'total_deliveries' => $totalDeliveries,
    'total_withdrawals' => $totalWithdrawals,
    'current_stock' => $currentStock
]);
