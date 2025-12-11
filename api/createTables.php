<?php
require_once __DIR__ . '/../config/Database.php';

$db = new Database();
$conn = $db->connect();

// Create table
$sql = "
CREATE TABLE IF NOT EXISTS deliveries (
    delivery_id INTEGER PRIMARY KEY AUTOINCREMENT,

    item_description INTEGER NOT NULL,                -- FK to items.item_id
    date_receive DATE NOT NULL,
    transaction_type TEXT NOT NULL,                   -- Deliveries / Transfer-in
    weight_scale REAL,
    dynamics_qty REAL,
    truckscale_vs_dynamics REAL,
    five_tonner REAL,
    num_bag INTEGER,
    tonner_vs_truck REAL,
    tord_no TEXT,
    atw_no TEXT,
    pallet_qty INTEGER,
    supplier TEXT,
    plate_no TEXT,
    weigh_slip TEXT,
    status TEXT,
    trucking_service TEXT,
    remarks TEXT,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (item_description) REFERENCES items(item_id)
);
";
$conn->exec($sql);
echo "Deliveries table created successfully!\n";


// --------------------------------------
// INSERT DUMMY DATA
// --------------------------------------

$insert = "
INSERT INTO deliveries (
    item_description, date_receive, transaction_type, weight_scale,
    dynamics_qty, truckscale_vs_dynamics, five_tonner, num_bag,
    tonner_vs_truck, tord_no, atw_no, pallet_qty, supplier,
    plate_no, weigh_slip, status, trucking_service, remarks
)
VALUES
(1, '2025-01-10', 'Deliveries', 15000.50, 14900.20, 100.30, 5.20, 300, 95.10, 'TORD-001', 'ATW-001', 20, 'ABC Supplier', 'ABC1234', 'WSL-001', 'Pending', 'J&T Logistics', 'No issues'),
(2, '2025-01-11', 'Transfer-in', 16890.70, 16750.00, 140.70, 6.00, 280, 120.50, 'TORD-002', 'ATW-002', 18, 'XYZ Trading', 'XYZ5678', 'WSL-002', 'Transacted', 'LBC Cargo', 'All good'),
(3, '2025-01-12', 'Deliveries', 20000.00, 19950.20, 49.80, 4.30, 250, 42.50, 'TORD-003', 'ATW-003', 22, 'Fresh Mills', 'FML2233', 'WSL-003', 'Pending', 'Metro Movers', 'Slight delay in schedule'),
(1, '2025-01-13', 'Deliveries', 17400.90, 17330.00, 70.90, 5.10, 290, 65.50, 'TORD-004', 'ATW-004', 19, 'ABC Supplier', 'ABC9988', 'WSL-004', 'Transacted', 'J&T Logistics', 'Delivered smoothly'),
(4, '2025-01-14', 'Transfer-in', 16220.10, 16100.50, 119.60, 6.50, 310, 110.20, 'TORD-005', 'ATW-005', 25, 'Bulk Foods Inc', 'BFD2211', 'WSL-005', 'Pending', 'Provincial Trucking', 'Unloaded without issues'),
(2, '2025-01-15', 'Deliveries', 14950.00, 14880.00, 70.00, 4.90, 265, 64.00, 'TORD-006', 'ATW-006', 17, 'XYZ Trading', 'XYZ3344', 'WSL-006', 'Pending', 'LBC Cargo', 'Rainy weather'),
(3, '2025-01-16', 'Deliveries', 18500.00, 18420.80, 79.20, 5.60, 320, 70.00, 'TORD-007', 'ATW-007', 30, 'Fresh Mills', 'FML8822', 'WSL-007', 'Transacted', 'Metro Movers', 'Quality check done'),
(5, '2025-01-17', 'Deliveries', 16000.00, 15900.75, 99.25, 5.30, 280, 88.20, 'TORD-008', 'ATW-008', 23, 'United Harvest', 'UHV6677', 'WSL-008', 'Pending', 'RoadRunner Trucking', 'Heavy traffic'),
(1, '2025-01-18', 'Transfer-in', 17200.20, 17140.00, 60.20, 6.00, 295, 55.10, 'TORD-009', 'ATW-009', 20, 'ABC Supplier', 'ABC2233', 'WSL-009', 'Pending', 'J&T Logistics', 'No remarks'),
(4, '2025-01-19', 'Deliveries', 19000.10, 18950.00, 50.10, 4.80, 275, 49.50, 'TORD-010', 'ATW-010', 18, 'Bulk Foods Inc', 'BFD9911', 'WSL-010', 'Transacted', 'Provincial Trucking', 'Fast unloading');
";

$conn->exec($insert);
echo "Dummy data inserted successfully!\n";

?>
