<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tgs_inventory");

function generateProductID($conn) {
    $check_query = "SELECT id FROM inventory ORDER BY id DESC LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);

    if ($row = mysqli_fetch_assoc($check_result)) {
        $last_id = $row['id'];
        $next_id = intval(substr($last_id, 3)) + 1;
        return "PRD" . str_pad($next_id, 4, '0', STR_PAD_LEFT);
    } else {
        return "PRD0001";
    }
}


?>