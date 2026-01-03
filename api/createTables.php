<?php
require_once __DIR__ . '/../config/Database.php';

$db = new Database();
$conn = $db->connect();

// Create Withdrawals Table
$sql = "
CREATE TABLE IF NOT EXISTS warehouse_monitor (
    warehouse_id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_description INTEGER NOT NULL,        -- FK to items.item_id
    beg_bal REAL NOT NULL,
    total_deliveries REAL NOT NULL,
    total_withdrawals REAL NOT NULL,
    remarks TEXT,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (item_description) REFERENCES items(item_id)
);
";

$conn->exec($sql);
echo "Warehouse table created successfully!\n";
?>