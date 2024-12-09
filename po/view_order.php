<?php
session_start();
include('connection.php');


// Edit User
if (isset($_POST['click_edit_btn'])) {
    $id = $_POST['user_id'];
    $fetch_query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $arrayresult = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arrayresult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
        echo json_encode([]);
    }
}

?>