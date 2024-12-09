<?php
session_start();

if (!isset($_SESSION['user'])) header('location: login.php');
$user = $_SESSION['user'];

$conn = mysqli_connect("localhost", "root", "", "db_bariso");

if (isset($_POST['click_view_btn'])) {
    $po_id = $_POST['user_id'];
    $fetch_query = "SELECT tbl_po.*, tbl_po_details.*
          FROM tbl_po
          LEFT JOIN tbl_po_details ON tbl_po.po_id = tbl_po_details.po_id
          WHERE tbl_po.po_id = ?";
    $stmt = mysqli_prepare($conn, $fetch_query);
    mysqli_stmt_bind_param($stmt, "i", $po_id);
    mysqli_stmt_execute($stmt);
    $fetch_query_run = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($fetch_query_run) > 0) {
        while ($row = mysqli_fetch_assoc($fetch_query_run)) {
            echo '
            <h6>Product Name:' . $row['product_name'] . '</h6>
            <h6>Qty Ordered:' . $row['quantity'] . '</h6>
            <h6>Qty Received:' . $row['qty_received'] . '</h6>
            <h6>Supplier:' . $row['supplier_name'] . '</h6>
            <h6>Status:' . $row['status'] . '</h6>
            <br>
            ';
        }
    } else {
        echo '<h6> No record found. </h6>';
    }
}

if (isset($_POST['click_edit_btn'])){
    $po_detail_id = $_POST['po_detail_id'];
    $arrayresult=[];

    $fetch_query = "SELECT tbl_po.*, tbl_po_details.*
          FROM tbl_po
          LEFT JOIN tbl_po_details ON tbl_po.po_id = tbl_po_details.po_id
          WHERE tbl_po_details.po_detail_id = ?";

    $stmt = mysqli_prepare($conn, $fetch_query);
    mysqli_stmt_bind_param($stmt, "i", $po_detail_id);
    mysqli_stmt_execute($stmt);
    $fetch_query_run = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($fetch_query_run) > 0) {
        while ($row = mysqli_fetch_array($fetch_query_run)) {
            array_push($arrayresult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {                   
        echo '<h4> No record found. </h4>';
    }
}

// UPDATE DATA
if (isset($_POST['update_data'])) {
    $po_detail_id = $_POST['po_detail_id'];
    $new_qty_received = $_POST['qty_received'];
    $status = ($_POST['quantity'] == $new_qty_received) ? 'complete' : 'incomplete';

    $product_name_query = "SELECT product_name FROM tbl_po_details WHERE po_detail_id = $po_detail_id";
    $product_name_result = mysqli_query($conn, $product_name_query);
    $row = mysqli_fetch_assoc($product_name_result);

    $initial_qty_query = "SELECT qty_received, product_name FROM tbl_po_details WHERE po_detail_id = $po_detail_id";
    $initial_qty_result = mysqli_query($conn, $initial_qty_query);
    $initial_qty_row = mysqli_fetch_assoc($initial_qty_result);
    $initial_qty_received = $initial_qty_row['qty_received'];
    $product_name = $initial_qty_row['product_name'];

    $qty_difference = $new_qty_received - $initial_qty_received;

    $update_stock_query = "UPDATE tbl_products 
                            SET stocks = stocks + ?
                            WHERE product_name = ?";

    $stmt = mysqli_prepare($conn, $update_stock_query);
    mysqli_stmt_bind_param($stmt, "is", $qty_difference, $product_name);
    mysqli_stmt_execute($stmt);
    
    $status = ($new_qty_received == $_POST['quantity']) ? 'complete' : 'incomplete';

    $update_qty_received_query = "UPDATE tbl_po_details
                              SET qty_received = ?, status = ?
                              WHERE po_detail_id = ?";

$stmt = mysqli_prepare($conn, $update_qty_received_query);
mysqli_stmt_bind_param($stmt, "ssi", $new_qty_received, $status, $po_detail_id);
mysqli_stmt_execute($stmt);

    header('location: manage_po.php');
}

?>