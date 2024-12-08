<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'], $_POST['po_number'], $_POST['product_name'], $_POST['quantity'], $_POST['unit_price'], $_POST['supplier_name'])) {
        $id = $_POST['id'];
        $poNumber = $_POST['po_number'];
        $productName = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $unitPrice = $_POST['unit_price'];
        $supplierName = $_POST['supplier_name'];

        $stmt = $conn->prepare("UPDATE purchase_orders SET po_number = :po_number WHERE id = :id");
        $stmt->bindParam(':po_number', $poNumber);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE purchase_order_details SET product_name = :product_name, quantity = :quantity, unit_price = :unit_price, supplier_name = :supplier_name WHERE po_id = :id");
        $stmt->bindParam(':product_name', $productName);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_price', $unitPrice);
        $stmt->bindParam(':supplier_name', $supplierName);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>