<?php
require_once __DIR__ . '/../config/Database.php';

$db = new Database();
$conn = $db->connect();

// Create Withdrawals Table
$sql = "
CREATE TABLE IF NOT EXISTS withdrawals (
    withdrawal_id INTEGER PRIMARY KEY AUTOINCREMENT,
    
    date_withdrawal DATE NOT NULL,
    item_description INTEGER NOT NULL,        -- FK to items.item_id
    ds REAL NOT NULL,
    ns REAL NOT NULL,
    total_qty REAL NOT NULL,
    remarks TEXT,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (item_description) REFERENCES items(item_id)
);
";

$conn->exec($sql);
echo "Withdrawals table created successfully!\n";
?>