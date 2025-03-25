<?php

header('Content-Type: application/json');
require '../admin/db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get all users
        $result = $conn->query("SELECT id, name, email FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
        break;

    case 'POST':
        // Create a new user
        $data = json_decode(file_get_contents("php://input"), true);
        
        $name = $data['name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo json_encode(["message" => "User created successfully"]);
        } else {
            echo json_encode(["error" => "Failed to create user"]);
        }
        break;

        case 'PUT':
            $input = file_get_contents("php://input");
        
            // Bersihkan input daripada whitespace atau karakter pelik
            $input = trim($input);
            $input = stripslashes($input);
        
            $data = json_decode($input, true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(["error" => "Invalid JSON format", "raw_input" => $input]);
                break;
            }
        
            echo json_encode(["debug" => $data]);
        
            if (!isset($data['name']) || !isset($data['email'])) {
                echo json_encode(["error" => "Invalid or missing user data"]);
                break;
            }
        
            $id = $_GET['id'];
            $name = $data['name'];
            $email = $data['email'];
        
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $email, $id);
        
            if ($stmt->execute()) {
                echo json_encode(["message" => "User updated successfully"]);
            } else {
                echo json_encode(["error" => "Failed to update user"]);
            }
            break;
        
        
        

    case 'DELETE':
        // Delete a user
        $id = $_GET['id'];
        
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "User deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete user"]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

$conn->close();
?>
