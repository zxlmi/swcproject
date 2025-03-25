// cancel_order.php
<?php
session_start();
include 'admin/db_connect.php';

if (!isset($_SESSION['login_user_id'])) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $user_id = $_SESSION['login_user_id'];
    
    // Update order status to cancelled
    $update = $conn->query("UPDATE orders SET status = 3 WHERE id = '$order_id' AND user_id = '$user_id'");
    
    if ($update) {
        echo "<script>alert('Order has been cancelled successfully.'); window.location='http://localhost/opos/index.php?page=my_orders';</script>";
    } else {
        echo "<script>alert('Failed to cancel order.'); window.location='http://localhost/opos/index.php?page=my_orders';</script>";
    }
}
?>