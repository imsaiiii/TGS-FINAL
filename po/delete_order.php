<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Delete from purchase_order_details
        $stmt = $conn->prepare("DELETE FROM purchase_order_details WHERE po_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Delete from purchase_orders
        $stmt = $conn->prepare("DELETE FROM purchase_orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        $conn->rollBack(); // Roll back the transaction in case of an error
        echo json_encode(['success' => false, 'message' => 'Error deleting order: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>