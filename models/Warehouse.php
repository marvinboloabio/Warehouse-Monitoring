<?php
class Warehouse
{
    private $conn;
    private $table = 'warehouse_monitor';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* public function getSuppliers()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY delivery_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        **/

    public function getSuppliers()
    {
        $query = "
SELECT
    wm.warehouse_id,
    i.item_code,
    i.item_id AS item_id,
    i.item_description AS item_name,

    COALESCE(wm.beg_bal, 0) AS beg_bal,

    /* TOTAL DELIVERIES */
    COALESCE(SUM(DISTINCT del.weight_scale), 0) AS total_deliveries,

    /* TOTAL WITHDRAWALS */
    COALESCE(SUM(DISTINCT w.total_qty), 0) AS total_withdrawals,

    wm.remarks,

    /* TOTAL RECEIPT */
    COALESCE(wm.beg_bal, 0)
        + COALESCE(SUM(DISTINCT del.weight_scale), 0) AS total_receipt,

    /* THEORETICAL BALANCE */
    COALESCE(wm.beg_bal, 0)
        + COALESCE(SUM(DISTINCT del.weight_scale), 0)
        - COALESCE(SUM(DISTINCT w.total_qty), 0) AS theoretical_balance

FROM warehouse_monitor wm

INNER JOIN items i
    ON wm.item_description = i.item_id

LEFT JOIN deliveries del
    ON del.item_description = i.item_id

LEFT JOIN withdrawals w
    ON w.item_description = i.item_id

GROUP BY
    wm.warehouse_id,
    wm.beg_bal,
    wm.remarks,
    i.item_code,
    i.item_description

ORDER BY wm.warehouse_id DESC
";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveSuppliers()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'Active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSupplier($data)
    {
        $query = "INSERT INTO " . $this->table . " (
        item_description, 
        beg_bal,
        total_deliveries,
        total_withdrawals,
        remarks
    ) VALUES (
        :item_description,
        :beg_bal,
        :total_deliveries,
        :total_withdrawals,
        :remarks
    )";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function updateSupplier($data)
    {
        $query = "UPDATE " . $this->table . " SET
        item_description = :item_description,
        beg_bal = :beg_bal,
        total_deliveries = :total_deliveries,
        total_withdrawals = :total_withdrawals,
        remarks = :remarks,
        updated_at = CURRENT_TIMESTAMP
    WHERE warehouse_id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}
