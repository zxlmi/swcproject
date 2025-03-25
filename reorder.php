// reorder.php
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
    
    // Copy order details into a new order
    $copy_order = $conn->query("INSERT INTO orders (user_id, name, address, mobile, email, status, order_date) 
                                SELECT user_id, name, address, mobile, email, 0, NOW() FROM orders WHERE id = '$order_id' AND user_id = '$user_id'");
    
    if ($copy_order) {
        $new_order_id = $conn->insert_id;
        
        // Copy order items
        $copy_items = $conn->query("INSERT INTO order_list (order_id, product_id, qty) 
                                   SELECT '$new_order_id', product_id, qty FROM order_list WHERE order_id = '$order_id'");
        
        if ($copy_items) {
            echo "<script>alert('Order has been reordered successfully.'); window.location='http://localhost/opos/index.php?page=my_orders';</script>";
        } else {
            echo "<script>alert('Failed to reorder items.'); window.location='http://localhost/opos/index.php?page=my_orders';</script>";
        }
    } else {
        echo "<script>alert('Failed to create reorder.'); window.location='http://localhost/opos/index.php?page=my_orders';</script>";
    }
}
?>