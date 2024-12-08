<?php
include('connection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM suppliers"; 
$result = $conn->query($sql);



header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"suppliers_data.csv\"");
header("Pragma: no-cache");
header("Expires: 0");


ob_clean();
flush();


$output = fopen("php://output", "w");

// Column headers (ensure this matches the data structure)
$columns = array('ID', 'Supplier Name', 'Status');
fputcsv($output, $columns);

// Fetch and output each row
while ($row = $result->fetch_assoc()) {
    $formatted_row = array(
        $row['id'],
        $row['supplier_name'],
        $row['status'] // Ensure 'status' exists in your database
    );
    fputcsv($output, $formatted_row);
}

// Close the output stream
fclose($output);

// Close the database connection
$conn->close();
exit;
?>
