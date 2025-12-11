<?php
require_once __DIR__ . '/../config/Database.php';

$db = new Database();
$conn = $db->connect();

// Create table
$sql = "
CREATE TABLE IF NOT EXISTS items (
    item_id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_code TEXT NOT NULL,
    item_description TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
";
$conn->exec($sql);
echo "SQLite table created successfully!\n";

// Insert dummy data
$dummyData = [
    ['item_code' => 'ITM001', 'item_description' => 'Laptop Dell XPS 13'],
    ['item_code' => 'ITM002', 'item_description' => 'Wireless Mouse Logitech'],
    ['item_code' => 'ITM003', 'item_description' => 'Mechanical Keyboard'],
    ['item_code' => 'ITM004', 'item_description' => '27-inch Monitor'],
    ['item_code' => 'ITM005', 'item_description' => 'External Hard Drive 1TB']
];

$insert = $conn->prepare("INSERT INTO items (item_code, item_description) VALUES (:item_code, :item_description)");

foreach ($dummyData as $item) {
    $insert->execute([
        ':item_code' => $item['item_code'],
        ':item_description' => $item['item_description']
    ]);
}

echo "Dummy data inserted successfully!\n";
?>
