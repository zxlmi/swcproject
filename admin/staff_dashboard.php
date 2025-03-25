<?php

session_start();
if (!isset($_SESSION['login_id']) || $_SESSION['login_type'] != 2) {
    header('Location: login.php');
    exit();
}

require './db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
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
        .card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-logout {
            display: inline-block;
            padding: 10px 20px;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-logout:hover {
            background: #c82333;
        }
        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Staff Dashboard</h1>
    </div>

    <div class="container">
        <div class="welcome">
            <i class="fa-solid fa-user"></i> Welcome, <?php echo $_SESSION['login_name']; ?>!
        </div>

        <div class="card">
            <h2>View Orders</h2>
            <p>Access all customer orders and keep track of their status.</p>
            <a href="view_orders.php" class="btn btn-light">View Orders</a>
        </div>

        <div class="card">
            <h2>Profile Settings</h2>
            <p>Update your profile information and change your password.</p>
            <a href="profile.php" class="btn btn-light">Edit Profile</a>
        </div>

        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

</body>
</html>
