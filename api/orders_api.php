<?php

header('Content-Type: application/json');
require '../admin/db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get all orders
        $result = $conn->query("SELECT * FROM orders");
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        echo json_encode($orders);
        break;

    case 'POST':
        // Create a new order
        $data = json_decode(file_get_contents("php://input"), true);
	$status = isset($data['status']) ? $data['status'] : null;
        $name = $data['name'];
        $address = $data['address'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $status = 0;

        $stmt = $conn->prepare("INSERT INTO orders (name, address, mobile, email, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $address, $mobile, $email, $status);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Order created successfully"]);
        } else {
            echo json_encode(["error" => "Failed to create order"]);
        }
        break;

    case 'PUT':
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!$data || !isset($data['status'])) {
        echo json_encode(["error" => "Invalid or missing status data"]);
        break;
    }

    $id = $_GET['id'];
    $status = $data['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Order updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update order"]);
    }
    break;


    case 'DELETE':
        // Delete an order
        $id = $_GET['id'];
        
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Order deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete order"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

$conn->close();
?>
