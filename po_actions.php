<?php
session_start();
include('connection.php');

// View Purchase Order Details
if (isset($_POST['click_view_btn'])) {
    $id = $_POST['user_id'];
    $fetch_query = "SELECT purchase_orders.*, purchase_order_details.* 
                    FROM purchase_orders
                    LEFT JOIN purchase_order_details 
                    ON purchase_orders.id = purchase_order_details.po_id 
                    WHERE purchase_order_details.po_id = :id";

    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <h6>Product Name: ' . htmlspecialchars($row['product_name']) . '</h6>
            <h6>Qty Ordered: ' . htmlspecialchars($row['quantity']) . '</h6>
            <h6>Qty Received: ' . htmlspecialchars($row['qty_received']) . '</h6>
            <h6>Supplier: ' . htmlspecialchars($row['supplier_name']) . '</h6>
            <h6>Status: ' . htmlspecialchars($row['status']) . '</h6>
            ';
        }
    } else {
        echo '<h4>No records found</h4>';
    }
}

// Edit Purchase Order Detail
if (isset($_POST['click_edit_btn'])) {
    $po_detail_id = $_POST['po_detail_id'];
    $arrayresult = [];

    $fetch_query = "SELECT tbl_po.*, tbl_po_details.*
                    FROM tbl_po
                    LEFT JOIN tbl_po_details ON tbl_po.po_id = tbl_po_details.po_id
                    WHERE tbl_po_details.po_detail_id = :po_detail_id";

    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':po_detail_id', $po_detail_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arrayresult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
        echo json_encode(['error' => 'No record found.']);
    }
}

// Update Purchase Order Detail
if (isset($_POST['update_data'])) {
    $po_detail_id = $_POST['po_detail_id'];
    $new_qty_received = $_POST['qty_received'];
    $status = ($_POST['quantity'] == $new_qty_received) ? 'complete' : 'incomplete';

    // Get product name for stock update
    $product_name_query = "SELECT product_name FROM tbl_po_details WHERE po_detail_id = :po_detail_id";
    $stmt = $conn->prepare($product_name_query);
    $stmt->bindParam(':po_detail_id', $po_detail_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $product_name = $row['product_name'];

    // Get initial qty_received for stock update
    $initial_qty_query = "SELECT qty_received FROM tbl_po_details WHERE po_detail_id = :po_detail_id";
    $stmt = $conn->prepare($initial_qty_query);
    $stmt->bindParam(':po_detail_id', $po_detail_id, PDO::PARAM_INT);
    $stmt->execute();
    $initial_qty_row = $stmt->fetch(PDO::FETCH_ASSOC);
    $initial_qty_received = $initial_qty_row['qty_received'];

    $qty_difference = $new_qty_received - $initial_qty_received;

    // Update stock based on the quantity difference
    $update_stock_query = "UPDATE tbl_products 
                           SET stocks = stocks + :qty_difference
                           WHERE product_name = :product_name";

    $stmt = $conn->prepare($update_stock_query);
    $stmt->bindParam(':qty_difference', $qty_difference, PDO::PARAM_INT);
    $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
    $stmt->execute();

    // Update the quantity received and status of the order
    $update_qty_received_query = "UPDATE tbl_po_details
                                  SET qty_received = :qty_received, status = :status
                                  WHERE po_detail_id = :po_detail_id";

    $stmt = $conn->prepare($update_qty_received_query);
    $stmt->bindParam(':qty_received', $new_qty_received, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':po_detail_id', $po_detail_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
}
?>
