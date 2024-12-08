<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM purchase_orders WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($order);
    } else {
        echo json_encode(['error' => 'No order found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>