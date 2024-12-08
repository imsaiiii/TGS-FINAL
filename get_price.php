<?php
include('connection.php');

if (isset($_POST['product_name'])) {
    $productName = $_POST['product_name'];

    $stmt = $conn->prepare("SELECT price FROM supplier_products WHERE product_name = ?");
    $stmt->execute([$productName]);

    $row = $stmt->fetch();

    if ($row) {
        echo $row['price'];
    } else {
        echo '0';
    }
} else {
    echo '0';
}