<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/ItemController.php';

$controller = new ItemController();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
        $controller->getSuppliers();
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        // If the data is not valid JSON, send an error response
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
        exit;
    }
    var_dump($data);
    error_log("Creating supplier: " . print_r($data, true)); // Debug log

    // Call the controller to create the supplier
    $result = $controller->createSupplier($data);

    if ($result) {
        // Success response
        http_response_code(201); // Created
        echo json_encode(['status' => 'success', 'message' => 'Supplier created successfully']);
    } else {
        // Failure response
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Failed to create supplier']);
    }

    exit;
} elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['id'])) {
        // If data or ID is missing, send a bad request error
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Supplier ID is required for update']);
        exit;
    }

    error_log("Updating supplier with ID: " . $data['id']); // Debug log
    $controller->updateSupplier($data);
} else {
    // For unsupported methods, send a 405 Method Not Allowed response
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}