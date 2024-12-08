<?php
include('connection.php');

if (isset($_GET['supplier_name'])) {
    $supplier = $_GET['supplier_name'];
    $stmt = $conn->prepare("SELECT product_name FROM supplier_products WHERE supplier = ?");
    $stmt->execute([$supplier]);

    while ($row = $stmt->fetch()) { 
        echo "<option value='{$row['product_name']}'>{$row['product_name']}</option>";
    }
}
?>