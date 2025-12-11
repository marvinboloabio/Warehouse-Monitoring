<?php
class Trucking {
    private $conn;
    private $table = 'trucking';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSuppliers() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY trucking_id DESC";
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
        $query = "INSERT INTO " . $this->table . " (plate_no, trucking_service) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function updateSupplier($data) {
        $query = "UPDATE " . $this->table . " SET plate_no=:name, trucking_service=:description WHERE trucking_id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}