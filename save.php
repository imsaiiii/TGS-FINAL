<?php
session_start();
include('connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['transactionNumber'], $_POST['totalAmount'], $_POST['products'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    $transactionNumber = $_POST['transactionNumber'];
    $totalAmount = $_POST['totalAmount'];
    $products = json_decode($_POST['products'], true);

    // Validate products
    if (!is_array($products) || empty($products)) {
        echo json_encode(['success' => false, 'message' => 'Invalid products data.']);
        exit;
    }

    // Default values
    $qtyReceived = 0; // Default value for qty_received
    $accId = null; // Default value for acc_id
    $status = 'pending'; // Default status
    $supplierName = 'default_supplier'; // Default supplier name

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Insert into purchase_orders
        $stmt = $conn->prepare("INSERT INTO purchase_orders (po_number, created_at, qty_received, acc_id, total_amount) VALUES (:transactionNumber, NOW(), :qtyReceived, :accId, :totalAmount)");
        $stmt->bindParam(':transactionNumber', $transactionNumber);
        $stmt->bindParam(':qtyReceived', $qtyReceived);
        $stmt->bindParam(':accId', $accId);
        $stmt->bindParam(':totalAmount', $totalAmount);

        if (!$stmt->execute()) {
            $conn->rollBack(); // Roll back the transaction
            echo json_encode(['success' => false, 'message' => 'Failed to insert into purchase_orders.', 'error' => $stmt->errorInfo()]);
            exit;
        }

        $lastId = $conn->lastInsertId();
        foreach ($products as $product) {
            // Ensure the required fields are captured from the product array
            if (!isset($product['name'], $product['price'], $product['quantity'], $product['supplier'])) {
                $conn->rollBack();
                echo json_encode(['success' => false, 'message' => 'Missing product fields.']);
                exit;
            }
        
            $productName = $product['name'];
            $unitPrice = (float)$product['price']; // Convert to float
            $quantity = (int)$product['quantity']; // Convert to integer
            $supplierName = $product['supplier']; // Get supplier name
            $amount = $unitPrice * $quantity; // Calculate amount based on unit price and quantity
        
            // Insert into purchase_order_details
            $stmt = $conn->prepare("INSERT INTO purchase_order_details (po_id, product_name, unit_price, quantity, qty_received, status, supplier_name, amount) VALUES (:po_id, :product_name, :unit_price, :quantity, :qty_received, :status, :supplier_name, :amount)");
            $stmt->bindParam(':po_id', $lastId);
            $stmt->bindParam(':product_name', $productName);
            $stmt->bindParam(':unit_price', $unitPrice);
            $stmt->bindParam(':quantity', $quantity); // Ensure quantity is bound correctly
            $stmt->bindParam(':qty_received', $qtyReceived);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':supplier_name', $supplierName); // Bind supplier name
            $stmt ->bindParam(':amount', $amount);
        
            if (!$stmt->execute()) {
                $conn->rollBack(); // Roll back the transaction
                echo json_encode(['success' => false, 'message' => 'Failed to insert into purchase_order_details.', 'error' => $stmt->errorInfo()]);
                exit;
            }
        }
        // Commit the transaction
        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        $conn->rollBack(); // Roll back the transaction in case of an exception
        error_log($e->getMessage()); // Log the error message
        echo json_encode(['success' => false, 'message' => 'Database error occurred.', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>