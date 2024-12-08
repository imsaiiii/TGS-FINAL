<?php
include('connection.php');

try {
    
    $conn->beginTransaction();

  
    $total_amount = $_POST['total_amount'];
    $stmt1 = $conn->prepare("INSERT INTO purchase_order (total_amount) VALUES (?)");
    $stmt1->execute([$total_amount]);

    $purchase_order_id = $conn->lastInsertId();

 
    $stmt2 = $conn->prepare("INSERT INTO purchase_order_details (product_name, unit_price, total_amount, quantity) SELECT product_name, unit_price, total_amount, 1 FROM temporary_po");
    $stmt2->execute();

    $conn->exec("DELETE FROM temporary_po");

    $conn->commit();
    echo "Purchase order confirmed.";
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Failed to confirm purchase order: " . $e->getMessage();
}
$conn = null;
?>
