<?php
session_start();
include('connection.php'); // Include your database connection file

// Get the current month
$currentMonth = date('Y-m');

// Prepare the SQL statement to fetch completed orders for the current month
$stmt = $conn->prepare("SELECT order_date, total_amount FROM completed_orders WHERE DATE_FORMAT(order_date, '%Y-%m') = :currentMonth");
$stmt->bindParam(':currentMonth', $currentMonth);
$stmt->execute();
$completedOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart
$chartData = [];
$orderDates = [];
$totalSales = 0;

foreach ($completedOrders as $order) {
    $orderDate = date('Y-m-d', strtotime($order['order_date']));
    $orderAmount = (float)$order['total_amount'];

    // Sum total sales
    $totalSales += $orderAmount;

    // Group sales by date
    if (!isset($chartData[$orderDate])) {
        $chartData[$orderDate] = 0;
    }
    $chartData[$orderDate] += $orderAmount;
}

// Prepare data for the chart
$labels = array_keys($chartData);
$data = array_values($chartData);

// Return data as JSON
echo json_encode([
    'labels' => $labels,
    'data' => $data,
    'totalSales' => number_format($totalSales, 2) // Format total sales
]);
?>