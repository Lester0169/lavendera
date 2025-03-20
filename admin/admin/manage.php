<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

// Handle status update if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    
    // Check which table to update based on order ID format or source
    if (isset($_POST['order_type']) && $_POST['order_type'] == 'legacy') {
        $stmt = $conn->prepare("UPDATE customers SET Status = ? WHERE ID = ?");
    } else {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    }
    
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        $success_message = "Order status updated successfully!";
    } else {
        $error_message = "Error updating status: " . $conn->error;
    }
    
    $stmt->close();
}

// Fetch legacy customers
$customer_sql = "SELECT * FROM customers ORDER BY ID DESC";
$customer_result = $conn->query($customer_sql);

// Fetch scheduled orders
$schedule_sql = "SELECT * FROM orders ORDER BY created_at DESC";
$schedule_result = $conn->query($schedule_sql);

// For debugging - check if orders exist in database
$debug_count = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];

// Get sample row for debugging
$fields_debug = [];
if ($schedule_result && $schedule_result->num_rows > 0) {
    $sample_row = $schedule_result->fetch_assoc();
    $fields_debug = array_keys($sample_row);
    // Reset the pointer back to the beginning
    $schedule_result->data_seek(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order Status</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #1678F3;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .header {
            background-color: #ffffff;
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header img {
            height: 60px;
        }
        .tab-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .tab-button {
            padding: 10px 15px;
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .tab-button.active {
            background-color: #1678F3;
            color: white;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .service-badge {
            display: inline-block;
            margin: 2px;
            padding: 3px 6px;
            background-color: #1678F3;
            color: white;
            border-radius: 4px;
            font-size: 0.8em;
        }
        .alert {
            margin-bottom: 20px;
        }
        
        /* Status color indicators */
        .status-pending {
            background-color: #ffc107 !important;
            color: black;
        }
        .status-scheduled {
            background-color: #17a2b8 !important;
            color: white;
        }
        .status-picked-up {
            background-color: #6610f2 !important;
            color: white;
        }
        .status-in-wash {
            background-color: #007bff !important;
            color: white;
        }
        .status-out-for-delivery {
            background-color: #fd7e14 !important;
            color: white;
        }
        .status-delivered {
            background-color: #28a745 !important;
            color: white;
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
        <h1>Manage Order Status</h1>
        
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Debug information - remove in production -->
        <div class="alert alert-info">
            Total orders in database: <?php echo $debug_count; ?>
            <?php if(!empty($fields_debug)): ?>
                <br>Available fields in orders table: <?php echo implode(", ", $fields_debug); ?>
            <?php endif; ?>
        </div>
        
        <div class="tab-buttons">
            <button class="tab-button active" onclick="openTab('legacy-orders')">Legacy Orders</button>
            <button class="tab-button" onclick="openTab('scheduled-orders')">Scheduled Orders</button>
        </div>
        
        <!-- Legacy Orders Tab -->
        <div id="legacy-orders" class="tab-content active">
            <h3>Legacy Customer Management Orders</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Service Type</th>
                        <th>Phone</th>
                        <th>Bill</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($customer_result && $customer_result->num_rows > 0) {
                        while ($row = $customer_result->fetch_assoc()) : 
                            // Get the CSS class for status
                            $status_class = "";
                            switch($row['Status'] ?? '') {
                                case 'Pending': $status_class = "status-pending"; break;
                                case 'Scheduled for Pickup': $status_class = "status-scheduled"; break;
                                case 'Picked Up': $status_class = "status-picked-up"; break;
                                case 'In Wash': $status_class = "status-in-wash"; break;
                                case 'Out for Delivery': $status_class = "status-out-for-delivery"; break;
                                case 'Delivered': $status_class = "status-delivered"; break;
                            }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ID'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Full_Name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Full_Address'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Date'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Type_of_Service'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Phone_Number'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Bill'] ?? 'N/A'); ?></td>
                            <td class="<?php echo $status_class; ?>">
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?php echo $row['ID'] ?? '0'; ?>">
                                    <input type="hidden" name="order_type" value="legacy">
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="Pending" <?php if (($row['Status'] ?? '') == 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="Scheduled for Pickup" <?php if (($row['Status'] ?? '') == 'Scheduled for Pickup') echo 'selected'; ?>>Scheduled for Pickup</option>
                                        <option value="Picked Up" <?php if (($row['Status'] ?? '') == 'Picked Up') echo 'selected'; ?>>Picked Up</option>
                                        <option value="In Wash" <?php if (($row['Status'] ?? '') == 'In Wash') echo 'selected'; ?>>In Wash</option>
                                        <option value="Out for Delivery" <?php if (($row['Status'] ?? '') == 'Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                                        <option value="Delivered" <?php if (($row['Status'] ?? '') == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">View Details</a>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    } else {
                    ?>
                        <tr>
                            <td colspan="9" class="text-center">No legacy orders found</td>
                        </tr>
                    <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Scheduled Orders Tab -->
        <div id="scheduled-orders" class="tab-content">
            <h3>Scheduled Orders from App</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Service Type</th>
                        <th>Total Price</th>
                        <th>Pickup Date</th>
                        <th>Dropoff Date</th>
                        <th>Delivery Option</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($schedule_result && $schedule_result->num_rows > 0) {
                        while ($row = $schedule_result->fetch_assoc()) : 
                            // Get the CSS class for status
                            $status_class = "";
                            switch($row['status'] ?? '') {
                                case 'Pending': $status_class = "status-pending"; break;
                                case 'Scheduled for Pickup': $status_class = "status-scheduled"; break;
                                case 'Picked Up': $status_class = "status-picked-up"; break;
                                case 'In Wash': $status_class = "status-in-wash"; break;
                                case 'Out for Delivery': $status_class = "status-out-for-delivery"; break;
                                case 'Delivered': $status_class = "status-delivered"; break;
                            }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id'] ?? $row['order_id'] ?? $row['ID'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id'] ?? 'N/A'); ?></td>
                            <td>
                                <?php 
                                $services = json_decode($row['service_type'] ?? '[]', true);
                                if (is_array($services) && !empty($services)) {
                                    foreach ($services as $service) {
                                        echo '<span class="service-badge">' . htmlspecialchars($service) . '</span>';
                                    }
                                } else {
                                    echo htmlspecialchars($row['service_type'] ?? 'N/A');
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['total_price'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['pickup_date'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['dropoff_date'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['delivery_option'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at'] ?? 'N/A'); ?></td>
                            <td class="<?php echo $status_class; ?>">
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id'] ?? $row['order_id'] ?? $row['ID'] ?? '0'; ?>">
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="Pending" <?php if (($row['status'] ?? '') == 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="Scheduled for Pickup" <?php if (($row['status'] ?? '') == 'Scheduled for Pickup') echo 'selected'; ?>>Scheduled for Pickup</option>
                                        <option value="Picked Up" <?php if (($row['status'] ?? '') == 'Picked Up') echo 'selected'; ?>>Picked Up</option>
                                        <option value="In Wash" <?php if (($row['status'] ?? '') == 'In Wash') echo 'selected'; ?>>In Wash</option>
                                        <option value="Out for Delivery" <?php if (($row['status'] ?? '') == 'Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                                        <option value="Delivered" <?php if (($row['status'] ?? '') == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">View Details</a>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    } else {
                    ?>
                        <tr>
                            <td colspan="10" class="text-center">No scheduled orders found</td>
                        </tr>
                    <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show the selected tab content
            document.getElementById(tabName).classList.add('active');

            // Update tab button styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            document.querySelector(`[onclick="openTab('${tabName}')"]`).classList.add('active');
        }
        
        // If the status was just updated, show alert and fade out after 3 seconds
        <?php if(isset($success_message)): ?>
        setTimeout(function() {
            document.querySelector('.alert-success').style.transition = 'opacity 1s';
            document.querySelector('.alert-success').style.opacity = '0';
            setTimeout(function() {
                document.querySelector('.alert-success').style.display = 'none';
            }, 1000);
        }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>