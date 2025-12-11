<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=monitoringDB", "marvin", "12345");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected!";
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}
?>