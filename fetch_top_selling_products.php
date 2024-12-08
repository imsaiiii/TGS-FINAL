<?php
session_start();
include('connection.php'); // Include your database connection file

// Prepare the SQL statement to fetch the top 3 best-selling products
$stmt = $conn->prepare("
    SELECT product_name, SUM(quantity) AS total_quantity
    FROM completed_orders_details
    GROUP BY product_name
    ORDER BY total_quantity DESC
    LIMIT 3
");
$stmt->execute();
$topSellingProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart and product list
$productNames = [];
$quantities = [];

foreach ($topSellingProducts as $product) {
    $productNames[] = $product['product_name'];
    $quantities[] = (int)$product['total_quantity'];
}

// Return data as JSON
echo json_encode([
    'productNames' => $productNames,
    'quantities' => $quantities
]);
?>