<?php
include('connection.php');
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['supplier']) && !empty($data['products'])) {
    $supplier = htmlspecialchars($data['supplier']);
    
    $stmt = $conn->prepare("
        INSERT INTO purchase_order__details 
        (supplier_name, product_name, unit_price, quantity, quantity_received, status, total_amount) 
        VALUES (:supplier, :product_name, :unit_price, :quantity, 0, 'Pending', :total_amount)
    ");

    foreach ($data['products'] as $product) {
        $stmt->execute([
            ':supplier' => $supplier,
            ':product_name' => htmlspecialchars($product['product_name']),
            ':unit_price' => $product['unit_price'],
            ':quantity' => $product['quantity'],
            ':total_amount' => $product['amount']
        ]);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data.']);
}

$conn = null;
?>
