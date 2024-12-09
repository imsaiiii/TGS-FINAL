<?php
session_start();
include('connection.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch purchase orders and their details
    $query = "SELECT po.id, po.po_number, po.created_at, po.qty_received, pod.quantity, pod.product_name, pod.unit_price, pod.supplier_name, pod.status
              FROM purchase_orders po
              LEFT JOIN purchase_order_details pod ON po.id = pod.po_id";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any orders were fetched
    if ($orders) {
        echo json_encode($orders);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No purchase orders found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>