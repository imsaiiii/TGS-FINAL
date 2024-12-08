<?php
include('connection.php');

if (isset($_GET['supplier'])) {
    $supplier_name = htmlspecialchars($_GET['supplier'], ENT_QUOTES, 'UTF-8');

    try {
        $stmt = $conn->prepare("SELECT product_name, price FROM supplier_products WHERE supplier = :supplier_name");
        $stmt->bindParam(':supplier_name', $supplier_name, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            foreach ($result as $row) {
                echo "<option value='" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "' data-price='" . htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
        } else {
            echo "<option value=''>No products found for this supplier</option>";
        }
    } catch (PDOException $e) {
        echo "<option value=''>Error fetching products</option>";
        error_log("Database error: " . $e->getMessage()); // Log the error message for debugging
    }

    $conn = null;
} else {
    echo "<option value=''>Please select a supplier first</option>";
}