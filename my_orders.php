<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'admin/db_connect.php';

if (!isset($_SESSION['login_user_id'])) {
    echo "<script>alert('Please login first to view your orders.'); window.location='login.php';</script>";
    exit;
}

$user_id = $_SESSION['login_user_id'];
$query = $conn->query("SELECT id, order_date, status,
                        CASE 
                            WHEN status = 0 THEN 'Pending' 
                            WHEN status = 1 THEN 'Processing' 
                            WHEN status = 2 THEN 'Completed' 
                            WHEN status = 3 THEN 'Cancelled' 
                            ELSE 'Unknown' 
                        END as status_text 
                        FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC");
?>

<div class="container-fluid">
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-center mb-4 page-title">
                    <h1 class="text-white">My Orders</h1>
                    <hr class="divider my-4 bg-dark" />
                </div>
            </div>
        </div>
    </header>

    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date & Time</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $query->fetch_assoc()) { ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td><?php echo date('d M Y h:i A', strtotime($row['order_date'])); ?></td>
                                    <td>
                                        <?php 
                                        $items_query = $conn->query("SELECT p.name, ol.qty FROM order_list ol JOIN product_list p ON ol.product_id = p.id WHERE ol.order_id = '".$row['id']."'");
                                        while ($item = $items_query->fetch_assoc()) {
                                            echo $item['qty'] . "x " . $item['name'] . "<br>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo isset($row['status']) && $row['status'] == 2 ? 'success' : ($row['status'] == 1 ? 'primary' : ($row['status'] == 3 ? 'danger' : 'warning')); ?>">
                                            <?php echo isset($row['status_text']) ? ucfirst($row['status_text']) : 'Pending'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 0) { ?>
                                            <a href="cancel_order.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                                        <?php } ?>
                                        <a href="reorder.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Reorder</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>