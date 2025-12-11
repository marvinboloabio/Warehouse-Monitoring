<?php
class Item {
    private $conn;
    private $table = 'items';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSuppliers() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY item_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveSuppliers() {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'Active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSupplier($data) {
        $query = "INSERT INTO " . $this->table . " (item_code, item_description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    } 

    public function updateSupplier($data) {
        $query = "UPDATE " . $this->table . " SET category_name=:name, description=:description,status=:status WHERE category_id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}