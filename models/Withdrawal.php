<?php
class Withdrawal
{
    private $conn;
    private $table = 'withdrawals';

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
        $query = "SELECT 
                d.*,
                i.item_code,
                i.item_description AS item_name
              FROM " . $this->table . " d
              INNER JOIN items i 
                ON d.item_description = i.item_id
              ORDER BY d.withdrawal_id DESC";

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
        date_withdrawal, 
        item_description,
        ds,
        ns,
        total_qty,
        remarks
    ) VALUES (
        :date_withdrawal,
        :item_description,
        :ds,
        :ns,
        :total_qty,
        :remarks
    )";

    $stmt = $this->conn->prepare($query);
    return $stmt->execute($data);
}


    public function updateSupplier($data)
    {
        $query = "UPDATE " . $this->table . " SET
        date_withdrawal = :date_withdrawal,
        item_description = :item_description,
        ds = :ds,
        ns = :ns,
        total_qty = :total_qty,
        remarks = :remarks,
        updated_at = CURRENT_TIMESTAMP
    WHERE withdrawal_id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}
