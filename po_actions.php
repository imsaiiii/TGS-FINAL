<?php
session_start();
include('connection.php');

if (isset($_POST['click__view_data_btn'])) {
    $id = $_POST['order_id']; // This should be the ID of the purchase order detail

    try {
        // Use parameterized queries to prevent SQL injection
        $fetch_query = "
        SELECT 
            pod.id AS pod_id,
            pod.po_id,
            po.po_number,
            pod.product_name,
            pod.unit_price,
            pod.quantity,
            pod.qty_received AS pod_qty_received,
            pod.status AS pod_status,
            pod.supplier_name,
            pod.amount AS pod_amount,
            po.created_at AS po_created_at,
            po.qty_received AS po_qty_received,
            po.acc_id,
            po.total_amount AS po_total_amount,
            po.received_date AS po_received_date
        FROM 
            purchase_order_details pod
        JOIN 
            purchase_orders po ON pod.po_id = po.id
        WHERE 
            pod.po_id = :po_id
        ";  // Use parameterized query with placeholder

        // Prepare and execute the query
        $stmt = $conn->prepare($fetch_query);
        $stmt->bindParam(':po_id', $id, PDO::PARAM_INT); // Use named binding for clarity
        $stmt->execute();

        // Check if there are any results
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all results

            foreach ($results as $row) {
                echo '
                <h6>Product Name: ' . htmlspecialchars($row['product_name']) . '</h6>
                <h6>Qty Ordered: ' . htmlspecialchars($row['quantity']) . '</h6>
                <h6>Qty Received: ' . htmlspecialchars($row['pod_qty_received']) . '</h6>
                <h6>Supplier: ' . htmlspecialchars($row['supplier_name']) . '</h6>
                <h6>Status: ' . htmlspecialchars($row['pod_status']) . '</h6>
                <h6>PO Number: ' . htmlspecialchars($row['po_number']) . '</h6>
                <h6>Total Amount: ' . htmlspecialchars($row['pod_amount']) . '</h6>
                <br>
                ';
            }
        } else {
            echo '<h4>No records found</h4>';
        }
    } catch (PDOException $e) {
        // Handle any errors with the PDO query
        echo '<h4>Error: ' . htmlspecialchars($e->getMessage()) . '</h4>';
    }
}

// Check if the form is submitted to update PO data
if (isset($_POST['update_data'])) {
    $po_id = $_POST['po_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $qty_received = $_POST['qty_received'];
    $supplier_name = $_POST['supplier_name'];
    $status = $_POST['status'];

    // Fetch current qty_received and product_name from the purchase_order_details table
    $query = "SELECT product_name, qty_received FROM purchase_order_details WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $po_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Calculate the quantity difference
        $initial_qty_received = $row['qty_received'];
        $qty_difference = $qty_received - $initial_qty_received;

        // Update the purchase_order_details table
        $update_query = "UPDATE purchase_order_details 
                         SET product_name = ?, quantity = ?, qty_received = ?, status = ?, supplier_name = ? 
                         WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("siiisi", $product_name, $quantity, $qty_received, $status, $supplier_name, $po_id);
        $stmt->execute();

        // Update the inventory table to reflect the stock changes
        $inventory_query = "UPDATE inventory SET total_measurement = CAST(total_measurement AS SIGNED) + ? 
                            WHERE product_name = ?";
        $stmt = $conn->prepare($inventory_query);
        $stmt->bind_param("is", $qty_difference, $product_name);
        $stmt->execute();

        // If PO status is 'complete', update the status in the purchase_orders table
        if ($status == 'complete') {
            $update_po_query = "UPDATE purchase_orders SET qty_received = qty_received + ? WHERE id = ?";
            $stmt = $conn->prepare($update_po_query);
            $stmt->bind_param("ii", $qty_received, $po_id);
            $stmt->execute();
        }

        echo "Data successfully updated!";
    } else {
        echo "Error: PO not found.";
    }
}

