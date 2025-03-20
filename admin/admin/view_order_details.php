<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

// Check if order ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Order ID is required'); window.location.href='manage.php';</script>";
    exit();
}

$order_id = intval($_GET['id']);

// Handle status update if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
    }
    
    $stmt->close();
}

// Fetch the order details
$order_sql = "
    SELECT o.*, u.full_name, u.phone_number, p.address, p.instructions 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    LEFT JOIN pickup_locations p ON o.location_id = p.id 
    WHERE o.id = ?
";

$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "<script>alert('Order not found!'); window.location.href='manage.php';</script>";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order services
$services_sql = "
    SELECT os.*, s.service_name, s.service_price, s.description  
    FROM order_services os
    JOIN services s ON os.service_id = s.service_id
    WHERE os.order_id = ?
";

$services_stmt = $conn->prepare($services_sql);
$services_stmt->bind_param("i", $order_id);
$services_stmt->execute();
$services_result = $services_stmt->get_result();
$services = [];

while ($row = $services_result->fetch_assoc()) {
    $services[] = $row;
}

// Fetch order delivery information if applicable
$delivery_sql = "SELECT * FROM order_delivery WHERE order_id = ?";
$delivery_stmt = $conn->prepare($delivery_sql);
$delivery_stmt->bind_param("i", $order_id);
$delivery_stmt->execute();
$delivery_result = $delivery_stmt->get_result();
$delivery_data = $delivery_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }
        #sidebar {
            width: 250px;
            background: #1678F3;
            color: #fff;
            height: 100vh;
            padding: 15px;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        #sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        #sidebar a:hover, #sidebar a.active {
            background: #F984F4;
        }
        #content {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 260px);
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #1678F3;
            color: white;
            font-weight: bold;
        }
        .status-update {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <div>
            <a href="dashboard.php">Dashboard Overview</a>
            <a href="manage.php">Customer Management</a>
            <a href="manage.php" class="active">Order Status</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div id="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Order Details</h1>
            <a href="manage.php" class="btn btn-secondary">Back to Orders</a>
        </div>

        <!-- Status Update Form -->
        <div class="card status-update">
            <div class="card-body">
                <h5>Update Order Status</h5>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="status">Current Status: <strong><?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?></strong></label>
                        <select name="status" id="status" class="form-control">
                            <option value="Pending" <?php if (!isset($order['status']) || $order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Scheduled for Pickup" <?php if (isset($order['status']) && $order['status'] == 'Scheduled for Pickup') echo 'selected'; ?>>Scheduled for Pickup</option>
                            <option value="Picked Up" <?php if (isset($order['status']) && $order['status'] == 'Picked Up') echo 'selected'; ?>>Picked Up</option>
                            <option value="In Wash" <?php if (isset($order['status']) && $order['status'] == 'In Wash') echo 'selected'; ?>>In Wash</option>
                            <option value="Out for Delivery" <?php if (isset($order['status']) && $order['status'] == 'Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                            <option value="Delivered" <?php if (isset($order['status']) && $order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        </select>
                    </div>
                    <input type="hidden" name="update_status" value="1">
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Order Information -->
        <div class="card">
            <div class="card-header">
                Order Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                        <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order['full_name'] ?? 'N/A'); ?></p>
                        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($order['phone_number'] ?? 'N/A'); ?></p>
                        <p><strong>Service Type:</strong> <?php echo htmlspecialchars($order['service_type'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Pickup Date:</strong> <?php echo htmlspecialchars($order['pickup_date'] ?? 'N/A'); ?></p>
                        <p><strong>Dropoff Date:</strong> <?php echo htmlspecialchars($order['dropoff_date'] ?? 'N/A'); ?></p>
                        <p><strong>Delivery Option:</strong> <?php echo htmlspecialchars($order['delivery_option'] ?? 'N/A'); ?></p>
                        <p><strong>Total Price:</strong> ₱<?php echo htmlspecialchars(number_format($order['total_price'] ?? 0, 2)); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="card">
            <div class="card-header">
                Location Information
            </div>
            <div class="card-body">
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></p>
                <p><strong>Instructions:</strong> <?php echo htmlspecialchars($order['instructions'] ?? 'N/A'); ?></p>
                
                <?php if ($delivery_data): ?>
                <div class="mt-3">
                    <h5>Delivery Information</h5>
                    <p><strong>Delivery Details:</strong> <?php echo htmlspecialchars($delivery_data['delivery_details'] ?? 'N/A'); ?></p>
                    <?php if (isset($delivery_data['delivery_time'])): ?>
                    <p><strong>Delivery Time:</strong> <?php echo htmlspecialchars($delivery_data['delivery_time']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Services -->
        <?php if (!empty($services)): ?>
        <div class="card">
            <div class="card-header">
                Order Services
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($services as $service): 
                            $subtotal = $service['quantity'] * $service['service_price'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                                <td><?php echo htmlspecialchars($service['description'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($service['quantity']); ?></td>
                                <td>₱<?php echo htmlspecialchars(number_format($service['service_price'], 2)); ?></td>
                                <td>₱<?php echo htmlspecialchars(number_format($subtotal, 2)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">Total:</td>
                            <td>₱<?php echo htmlspecialchars(number_format($total, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="card">
            <div class="card-header">Order Services</div>
            <div class="card-body">
                <p class="text-center">No service details found for this order.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php 
// Close all prepared statements
$order_stmt->close();
$services_stmt->close();
$delivery_stmt->close();

// Close the database connection
$conn->close(); 
?>