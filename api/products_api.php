<?php

header('Content-Type: application/json');
require '../admin/db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get all products
        $result = $conn->query("SELECT * FROM product_list");
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
        break;

    case 'POST':
        // Create a new product
        $data = json_decode(file_get_contents("php://input"), true);
        
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $status = 1;

        $stmt = $conn->prepare("INSERT INTO product_list (name, description, price, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $name, $description, $price, $status);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product created successfully"]);
        } else {
            echo json_encode(["error" => "Failed to create product"]);
        }
        break;

    case 'PUT':
    $input = file_get_contents("php://input");
    $data = json_decode($input, true); // Decode JSON ke array PHP

    if (!isset($data['name']) || !isset($data['description']) || !isset($data['price'])) {
        echo json_encode(["error" => "Invalid or missing product data"]);
        break;
    }

    $id = $_GET['id'];
    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];

    $stmt = $conn->prepare("UPDATE product_list SET name = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update product"]);
    }
    break;



    case 'DELETE':
        // Delete a product
        $id = $_GET['id'];
        
        $stmt = $conn->prepare("DELETE FROM product_list WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete product"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

$conn->close();
?>