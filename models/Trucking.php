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
        $query = "INSERT INTO " . $this->table . " (plate_no, trucking_service) VALUES (:plate_no, :trucking_service)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function updateSupplier($data) {
        $query = "UPDATE " . $this->table . " SET plate_no=:plate_no, trucking_service=:trucking_service WHERE trucking_id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // New method: get trucking service by plate number
    public function getTruckingServiceByPlate($plateNo) {
        $query = "SELECT trucking_service FROM " . $this->table . " WHERE plate_no = :plate_no LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['plate_no' => $plateNo]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['trucking_service'] : null;
    }
}