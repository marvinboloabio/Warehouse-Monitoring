<?php
class Database {
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("sqlite:" . __DIR__ . "/../database.sqlite");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>