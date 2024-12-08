<?php
session_start();
include('connection.php');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the index and amount from the POST data
    $index = $_POST['index'];
    $amount = $_POST['amount'];

    // Fetch the current total measurement for the specified product
    $stmt = $conn->prepare("SELECT total_measurement FROM inventory WHERE id = :id");
    $stmt->bindParam(':id', $index);
    $stmt->execute();
    $currentMeasurement = $stmt->fetchColumn();

    // Calculate the new total measurement
    $newMeasurement = $currentMeasurement - $amount;

    // Update the inventory with the new measurement
    $updateStmt = $conn->prepare("UPDATE inventory SET total_measurement = :newMeasurement WHERE id = :id");
    $updateStmt->bindParam(':newMeasurement', $newMeasurement);
    $updateStmt->bindParam(':id', $index);
    $updateStmt->execute();

    // Fetch updated inventory data for the chart
    $stmt = $conn->prepare("SELECT total_measurement FROM inventory");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare updated data for the chart
    $chartData = [];
    foreach ($inventory as $item) {
        $chartData[] = (float)$item['total_measurement'];
    }

    // Return updated data as JSON
    echo json_encode(['chartData' => $chartData]);
}
?>