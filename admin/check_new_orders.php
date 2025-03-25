<?php

require '../admin/db_connect.php';

date_default_timezone_set('Asia/Kuala_Lumpur');
header('Content-Type: application/json');

// Check the latest order
$query = "SELECT name FROM orders WHERE order_date >= NOW() - INTERVAL 10 SECOND ORDER BY order_date DESC LIMIT 1";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode([
        'newOrder' => true,
        'customerName' => $row['name']
    ]);
} else {
    echo json_encode([ 'newOrder' => false ]);
}

$conn->close();
?>
