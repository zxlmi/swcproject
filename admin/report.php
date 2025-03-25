<?php

require '../admin/db_connect.php';

date_default_timezone_set('Asia/Kuala_Lumpur'); // Set timezone Malaysia
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT o.id, o.name, o.email, o.mobile, o.status, o.order_date, p.name AS product_name, ol.qty, p.price
          FROM orders o
          JOIN order_list ol ON o.id = ol.order_id
          JOIN product_list p ON ol.product_id = p.id";

if ($search_query !== '') {
    $query .= " WHERE o.name LIKE '%$search_query%' OR o.email LIKE '%$search_query%'";
}

if ($status_filter !== '') {
    $query .= ($search_query !== '' ? ' AND' : ' WHERE') . " o.status = " . intval($status_filter);
}

$result = $conn->query($query);
$total_revenue = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Report</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f0f4f8;
        }
        .header {
            background: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background: #007bff;
            color: #fff;
            padding: 10px;
        }
        .table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .status-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 20px;
            color: #fff;
            cursor: pointer;
        }
        .pending { background: #ff9800; }
        .completed { background: #4caf50; }
        .cancelled { background: #f44336; }
        .revenue-card {
            padding: 20px;
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            text-align: center;
            border-radius: 8px;
            margin-top: 20px;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }
        .notification button {
            background: #fff;
            color: #28a745;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Order Report</h1>
    </div>

    <!-- Notification Popup -->
    <div class="notification" id="orderNotification">
        <span id="notificationText"></span>
        <button onclick="closeNotification()">Close</button>
    </div>
    
    <div class="container">
        <div class="filter-section">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo htmlspecialchars($search_query); ?>">
                <label for="status">Filter by Status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="0" <?php echo ($status_filter === '0') ? 'selected' : ''; ?>>Pending</option>
                    <option value="1" <?php echo ($status_filter === '1') ? 'selected' : ''; ?>>Completed</option>
                    <option value="2" <?php echo ($status_filter === '2') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
                <button type="submit">Search & Filter</button>
            </form>
            
            <form method="GET" action="export_report.php" target="_blank">
                <button class="download-btn" type="submit">Download PDF Report</button>
            </form>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php $total_price = $row['qty'] * $row['price']; ?>
                    <?php $total_revenue += $total_price; ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td>$<?php echo number_format($total_price, 2); ?></td>
                        <td>
                            <button class="status-btn <?php echo ['pending', 'completed', 'cancelled'][$row['status']]; ?>" 
                                    onclick="updateStatus(<?php echo $row['id']; ?>, <?php echo $row['status']; ?>)">
                                <?php echo ['Pending', 'Completed', 'Cancelled'][$row['status']]; ?>
                            </button>
                        </td>
                        <td><?php echo date('d-m-Y h:i A', strtotime($row['order_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No results found</p>
        <?php endif; ?>

        <div class="revenue-card">
            <h2>Total Revenue: $<?php echo number_format($total_revenue, 2); ?></h2>
        </div>
    </div>

<script>
function updateStatus(orderId, currentStatus) {
    let newStatus = (currentStatus + 1) % 3;

    $.ajax({
        url: 'update_status.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: orderId, status: newStatus }),
        success: function(response) {
            alert(response.message);
            location.reload();
        }
    });
}
</script>
</body>
</html>
<?php
$conn->close();
?>