<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_data'])) {
    $transactionNumber = $_POST['transactionNumber'];
    $productName = $_POST['productName'];
    $transactionDate = $_POST['transactionDate'];
    $quantity = $_POST['quantity'];
    $supplierName = $_POST['supplierName'];
    $accId = $_POST['accId'];
    $totalAmount = $_POST['totalAmount'];
    $productsInfo = json_decode($_POST['productsInfo'], true);

    if ($productsInfo === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "message" => "Error decoding JSON data"]);
        exit;
    }

    try {
        $sql = "INSERT INTO tbl_po (po_number, po_datetime, acc_id, total_amount) VALUES (:transactionNumber, :transactionDate, :accId, :totalAmount)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':transactionNumber', $transactionNumber);
        $stmt->bindParam(':transactionDate', $transactionDate);
        $stmt->bindParam(':accId', $accId);
        $stmt->bindParam(':totalAmount', $totalAmount);

        $stmt->execute();
        $poId = $conn->lastInsertId();

        foreach ($productsInfo as $product) {
            $productName = $product['name'];
            $quantity = $product['quantity'];

            $basePriceStmt = $conn->prepare("SELECT base_price FROM tbl_products WHERE product_name = ?");
            $basePriceStmt->execute([$productName]);
            $basePrice = $basePriceStmt->fetchColumn();

            $amount = $basePrice * $quantity;

            $status = 'pending';

            $stmt = $conn->prepare("INSERT INTO tbl_po_details (po_id, product_name, quantity, supplier_name, unit_price, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$poId, $productName, $quantity, $supplierName, $basePrice, $amount, $status]);
        }

        echo json_encode(["success" => true, "message" => "Purchase saved successfully"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>