<?php
session_start(); // Start the session
require_once 'connection.php'; // Include your database connection

try {
    // Ensure paymentMethod, totalAmount, and cartData are set
    if (!isset($paymentMethod) || !isset($totalAmount) || !isset($cartData)) {
        throw new Exception("Required variables are not set.");
    }

    // Insert into completed_orders
    $stmt = $conn->prepare("INSERT INTO completed_orders (order_date, payment_method, total_amount, paid) VALUES (NOW(), ?, ?, 'No')");
    if ($stmt->execute([$paymentMethod, $totalAmount])) {
        $orderId = $conn->lastInsertId();

        // Insert into completed_orders_details and deduct ingredients
        foreach ($cartData as $item) {
            // Insert order details
            $stmt = $conn->prepare("INSERT INTO completed_orders_details (order_id, product_id, product_name, quantity, price_total) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$orderId, $item['productId'], $item['name'], $item['quantity'], $item['totalPrice']]);

            // Fetch product ingredients
            $ingredients = getProductIngredients($item['productId']);
            foreach ($ingredients as $ingredient) {
                // Deduct from inventory based on the quantity ordered
                $totalQuantityNeeded = $ingredient['quantity'] * $item['quantity'];
                deductFromInventory($ingredient['ingredient_name'], $totalQuantityNeeded);
            }
        }

        // Insert into payments table
        $paymentReference = uniqid();
        $stmt = $conn->prepare("INSERT INTO payments (order_id, payment_method, payment_reference, amount_paid, payment_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$orderId, $paymentMethod, $paymentReference, $totalAmount]);

        // Set success message in session and redirect
        $_SESSION['status'] = [
            'type' => 'success',
            'message' => "Order placed successfully!"
        ];
        header("Location: pos.php");
        exit();
    } else {
        $_SESSION['status'] = [
            'type' => 'error',
            'message' => "Error in placing order. Please try again."
        ];
        header("Location: pos.php");
        exit();
    }
} catch (PDOException $e) {
    // Handle database error
    http_response_code(500);
    $_SESSION['status'] = [
        'type' => 'error',
        'message' => "Database Error: " . $e->getMessage()
    ];
    header("Location: pos.php");
    exit();
} catch (Exception $e) {
    // Handle general error
    http_response_code(400);
    $_SESSION['status'] = [
        'type' => 'error',
        'message' => "Error: " . $e->getMessage()
    ];
    header("Location: pos.php");
    exit();
}

// Function to fetch product ingredients
function getProductIngredients($productId) {
    global $conn; // Use the global connection variable
    $stmt = $conn->prepare("SELECT ingredient_name, quantity FROM product_ingredients_detail WHERE product_id = ?");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to deduct from inventory
function deductFromInventory($ingredientName, $quantity) {
    global $conn; // Use the global connection variable
    // Check current inventory level using product_name instead of ingredient_name
    $stmt = $conn->prepare("SELECT total_measurement FROM inventory WHERE product_name = ?");
    $stmt->execute([$ingredientName]); // Assuming ingredientName corresponds to product_name
    $currentMeasurement = $stmt->fetchColumn();

 if ($currentMeasurement !== false && $currentMeasurement >= $quantity) {
        // Deduct from inventory only if sufficient stock is available
        $stmt = $conn->prepare("UPDATE inventory SET total_measurement = total_measurement - ? WHERE product_name = ?");
        $stmt->execute([$quantity, $ingredientName]);
    } else {
        // Handle insufficient inventory case
        http_response_code(400); // Bad Request
        echo json_encode(["status" => "error", "message" => "Insufficient inventory for ingredient: " . $ingredientName]);
        exit; // Stop further execution
    }
}