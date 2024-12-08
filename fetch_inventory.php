<?php
session_start();
include('connection.php');

// Fetch total measurement for the chart
$stmt = $conn->prepare("SELECT product_name, total_measurement FROM inventory");
$stmt->execute();
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart
$chartData = [];
foreach ($inventory as $item) {
    $chartData[] = (float)$item['total_measurement']; // Ensure it's a float for the chart
}

// Fetch low stock items (quantity < 1)
$lowStockStmt = $conn->prepare("SELECT product_name FROM inventory WHERE package_quantity < 2");
$lowStockStmt->execute();
$lowStockItems = $lowStockStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare low stock items for display
$lowStockList = [];
foreach ($lowStockItems as $item) {
    $lowStockList[] = $item['product_name'];
}

// Return data as JSON
echo json_encode([
    'chartData' => $chartData,
    'lowStockItems' => $lowStockList
]);
?>
