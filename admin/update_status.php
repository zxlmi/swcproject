<?php

require '../admin/db_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['status'])) {
    $id = $data['id'];
    $status = $data['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Order status updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update status"]);
    }
} else {
    echo json_encode(["error" => "Invalid request data"]);
}

$conn->close();
?>
