<?php
include('connection.php');

if (isset($_POST['supplier'])) {
    $supplier = $_POST['supplier'];
    
    
    $stmt = $conn->prepare("SELECT product_name FROM product_suppliers WHERE supplier_name = :supplier");
    $stmt->bindParam(':supplier', $supplier);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if (count($products) > 0) {
        echo "<option value=''>-- Select Product --</option>";
        foreach ($products as $product) {
            echo "<option value='" . htmlspecialchars($product['product_name']) . "'>" . htmlspecialchars($product['product_name']) . "</option>";
        }
    } else {
        echo "<option value=''>No products found</option>";
    }
} elseif (isset($_POST['product'])) {
    $product = $_POST['product'];
    
   
    $stmt = $conn->prepare("SELECT category FROM products WHERE product_name = :product");
    $stmt->bindParam(':product', $product);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($result) {
        echo htmlspecialchars($result['category']); 
    } else {
        echo "No category found";
    }
}
?>