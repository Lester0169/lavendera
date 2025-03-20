<?php
session_start();
include('config.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's latest order status from orders table
$latest_order_query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($latest_order_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$has_active_order = false;
$current_status = "";
$order_details = null;

if ($result && $result->num_rows > 0) {
    $has_active_order = true;
    $order_details = $result->fetch_assoc();
    $current_status = $order_details['status'] ?? 'Scheduled for Pickup';
} else {
    // Check if user has a legacy order in customers table
    $legacy_query = "SELECT * FROM customers WHERE user_id = ? ORDER BY ID DESC LIMIT 1";
    $stmt = $conn->prepare($legacy_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $legacy_result = $stmt->get_result();
    
    if ($legacy_result && $legacy_result->num_rows > 0) {
        $has_active_order = true;
        $order_details = $legacy_result->fetch_assoc();
        $current_status = $order_details['Status'] ?? 'Scheduled for Pickup';
    }
}

// Helper function to determine which timeline items should be filled
function isStatusFilled($item_status, $current_status) {
    $status_order = [
        'Pending' => 0,
        'Scheduled for Pickup' => 1,
        'Picked Up' => 2,
        'In Wash' => 3,
        'Out for Delivery' => 4,
        'Delivered' => 5
    ];
    
    // If current status isn't in our defined statuses, default to first step
    if (!isset($status_order[$current_status])) {
        return $item_status === 'Scheduled for Pickup';
    }
    
    // Return true if this item's status is less than or equal to the current status
    return $status_order[$item_status] <= $status_order[$current_status];
}

// Helper function to determine which status is currently active
function isActiveStatus($item_status, $current_status) {
    return $item_status === $current_status;
}

// Helper function to calculate progress percentage for progress bar
function getProgressPercentage($current_status) {
    $status_order = [
        'Pending' => 0,
        'Scheduled for Pickup' => 0,
        'Picked Up' => 25,
        'In Wash' => 50,
        'Out for Delivery' => 75,
        'Delivered' => 100
    ];
    
    return $status_order[$current_status] ?? 0;
}

// Fetch user profile data for the delivery address
$profile_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($profile_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$profile_result = $stmt->get_result();
$user_data = $profile_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rinse - Home</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .alert-success {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            text-align: center;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
            font-family: 'Open Sans', sans-serif; /* Body font */
            line-height: 1.5; /* Consistent line height */
        }
        
        /* Typography Hierarchy */
        h1 {
            font-family: 'Poppins', sans-serif; /* Header font */
            font-size: 32px; /* H1 size */
            font-weight: 700; /* Bold */
            line-height: 1.3; /* Slightly tighter for headers */
        }
        
        h2 {
            font-family: 'Poppins', sans-serif; /* Header font */
            font-size: 28px; /* H2 size */
            font-weight: 600; /* Semi-bold */
            line-height: 1.3;
        }
        
        h3 {
            font-family: 'Poppins', sans-serif; /* Header font */
            font-size: 24px; /* H3 size */
            font-weight: 600; /* Semi-bold */
            line-height: 1.4;
        }
        
        p {
            font-size: 16px; /* Body text size */
            font-weight: 400; /* Regular */
            line-height: 1.6; /* 1.5x font size for readability */
            color: #555; /* Slightly lighter for body text */
        }
        
        .sidebar {
            width: 320px;
            background: linear-gradient(135deg, #FF8C00, #FFA500); /* Gradient for depth */
            color: white;
            padding: 40px 30px;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        
        .sidebar img {
            width: 180px;
            margin-bottom: 32px; /* Increased margin */
        }
        
        .sidebar h1 {
            margin-bottom: 40px; /* Increased margin */
            margin-top: 0;
            color: white;
        }
        
        .sidebar-menu {
            list-style: none;
            padding-left: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 16px; /* Increased padding */
            border-radius: 8px; /* Consistent border-radius */
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1); /* Light tint for hover */
        }
        
        .sidebar-menu a:active {
            background-color: rgba(255, 255, 255, 0.2); /* Slightly darker for active state */
        }
        
        .sidebar-menu .active {
            background-color: #1678F3; /* Accent blue for active link */
            color: white;
            font-weight: bold;
        }
        
        .main-content {
            flex: 1;
            padding: 40px; /* Increased padding */
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .top-nav {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px; /* Increased margin */
        }
        
        .top-nav a {
            margin-left: 24px; /* Increased margin */
            text-decoration: none;
            color: #1a5e76;
            font-size: 16px;
            padding: 8px 16px; /* Consistent padding */
            border-radius: 8px; /* Consistent border-radius */
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .top-nav a:hover {
            background-color: rgba(0, 0, 0, 0.05); /* Light hover effect */
        }
        
        .top-nav a:active {
            background-color: rgba(0, 0, 0, 0.1); /* Slightly darker for active state */
        }
        
        .top-nav a:first-child {
            color: #1678F3; /* Accent blue */
        }

        .order-details {
            max-width: 800px;
            margin: 0 auto;
        }

        .order-details h2 {
            margin-bottom: 24px; /* Increased margin */
            color: #333;
        }

        .order-details p {
            margin-bottom: 24px; /* Increased margin */
        }

        .order-details h3 {
            margin-top: 32px; /* Increased margin */
            margin-bottom: 20px; /* Increased margin */
            color: #333;
        }

        .order-status {
            margin-bottom: 40px; /* Increased margin */
        }

        .order-status h2 {
            margin-bottom: 20px; /* Increased margin */
        }

        .order-status p {
            margin-bottom: 24px; /* Increased margin */
        }

        .order-status .emoji {
            font-size: 20px;
        }

        .order-timeline {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* Use grid for alignment */
            gap: 16px; /* Consistent spacing */
            margin-top: 24px; /* Increased margin */
        }

        .order-timeline .timeline-item {
            text-align: center;
            color: #555;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .order-timeline .timeline-item i {
            font-size: 24px;
            margin-bottom: 12px; /* Increased margin */
            color: #ccc; /* Gray icon color by default */
            background-color: transparent;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ccc; /* Gray border by default */
            transition: all 0.3s ease; /* Smooth transitions */
        }

        .order-timeline .timeline-item.filled i {
            background-color: #28a745; /* Green circle (filled) */
            border-color: #28a745; /* Green border */
            color: white; /* White icon */
        }

        .order-timeline .timeline-item strong {
            display: block;
            font-size: 16px;
            margin-bottom: 8px; /* Increased margin */
        }

        .order-timeline .timeline-item span {
            font-size: 14px;
            color: #777; /* Slightly lighter text */
        }

        .delivery-address {
            margin-top: 32px; /* Increased margin */
            padding: 24px; /* Increased padding */
            border: 1px solid #ddd;
            border-radius: 8px; /* Consistent border-radius */
            background-color: #f9f9f9;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1); /* Subtle drop shadow */
        }

        .delivery-address h3 {
            margin-bottom: 16px; /* Increased margin */
            color: #333;
        }

        .delivery-address p {
            margin-bottom: 12px; /* Increased margin */
        }

        .button {
            display: block;
            width: 100%;
            padding: 12px 24px; /* Consistent padding */
            background-color: #1678F3; /* Accent blue */
            color: #fff;
            border: none;
            border-radius: 8px; /* Consistent border-radius */
            font-size: 18px;
            cursor: pointer;
            text-align: center;
            margin-top: 40px; /* Increased margin */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button:hover {
            background-color: #125bb3; /* Darker shade of blue */
            transform: translateY(-2px); /* Slight lift on hover */
        }

        .button:active {
            background-color: #0f4a8f; /* Even darker for active state */
            transform: translateY(0); /* Reset lift on active */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                padding: 20px;
            }
            .main-content {
                padding: 20px;
            }
            .order-timeline {
                grid-template-columns: repeat(2, 1fr); /* Adjust for smaller screens */
            }
        }
        /* Add this to your existing CSS in home.php */
.order-timeline .timeline-item.filled i {
    background-color: #28a745; /* Green circle (filled) */
    border-color: #28a745; /* Green border */
    color: white; /* White icon */
}

.order-timeline .timeline-item.active i {
    background-color: #28a745; /* Green for active status */
    border-color: #28a745;
    color: white;
    animation: pulse 1.5s infinite; /* Add pulsing effect to current status */
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

/* Add a progress bar between timeline items */
.order-timeline {
    position: relative;
}

.order-timeline::before {
    content: '';
    position: absolute;
    top: 25px; /* Align with the middle of the icons */
    left: 10%;
    right: 10%;
    height: 2px;
    background-color: #ccc;
    z-index: 0;
}

.order-timeline .progress-bar {
    position: absolute;
    top: 25px;
    left: 10%;
    height: 2px;
    background-color: #28a745;
    z-index: 1;
    transition: width 0.5s ease;
}
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <!-- Logo Added Here -->
        <img src="images/logo1.png" alt="Rinse Logo">
        <h1>My Account</h1>
        <ul class="sidebar-menu">
            <li><a href="home.php" <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'class="active" aria-current="page"' : ''; ?>>Schedule a pickup</a></li>
            <li><a href="prof.php" <?php echo basename($_SERVER['PHP_SELF']) == 'prof.php' ? 'class="active" aria-current="page"' : ''; ?>>Profile</a></li>
            <li><a href="history.php" <?php echo basename($_SERVER['PHP_SELF']) == 'history.php' ? 'class="active" aria-current="page"' : ''; ?>>Order history</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <a href="#">My Account</a>
            <a href="logout.php">Log out</a>
        </div>

        <!-- Display success message if order_success is true -->
        <?php if (isset($_GET['order_success']) && $_GET['order_success'] === 'true'): ?>
            <div class="alert-success">
                Your order has been successfully scheduled!
            </div>
        <?php endif; ?>

        <?php if ($has_active_order): ?>
        <!-- Order Details Section -->
        <div class="order-details">
            <div class="order-status">
                <h2>YOUR LAUNDRY IS <?php echo strtoupper($current_status); ?></h2>
                <div class="order-timeline">
                    <!-- Progress Bar -->
                    <div class="progress-bar" style="width: <?php echo getProgressPercentage($current_status); ?>%;"></div>
                     <!-- Dynamic status rendering based on current status -->
                     <div class="timeline-item <?php echo isStatusFilled('Scheduled for Pickup', $current_status) ? 'filled' : ''; ?> <?php echo isActiveStatus('Scheduled for Pickup', $current_status) ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-check"></i>
                        <strong>Scheduled for Pickup</strong>
                    </div>
                    <div class="timeline-item <?php echo isStatusFilled('Picked Up', $current_status) ? 'filled' : ''; ?> <?php echo isActiveStatus('Picked Up', $current_status) ? 'active' : ''; ?>">
                        <i class="fas fa-truck-pickup"></i>
                        <strong>Picked Up</strong>
                    </div>
                    <div class="timeline-item <?php echo isStatusFilled('In Wash', $current_status) ? 'filled' : ''; ?> <?php echo isActiveStatus('In Wash', $current_status) ? 'active' : ''; ?>">
                        <i class="fas fa-soap"></i>
                        <strong>In Wash</strong>
                    </div>
                    <div class="timeline-item <?php echo isStatusFilled('Out for Delivery', $current_status) ? 'filled' : ''; ?> <?php echo isActiveStatus('Out for Delivery', $current_status) ? 'active' : ''; ?>">
                        <i class="fas fa-truck"></i>
                        <strong>Out for Delivery</strong>
                    </div>
                    <div class="timeline-item <?php echo isStatusFilled('Delivered', $current_status) ? 'filled' : ''; ?> <?php echo isActiveStatus('Delivered', $current_status) ? 'active' : ''; ?>">
                        <i class="fas fa-check-circle"></i>
                        <strong>Delivered</strong>
                    </div>
                </div>
                
                <!-- Dynamic message based on current status -->
                <?php
                $status_messages = [
                    'Pending' => 'Your order is being processed. We\'ll update the status soon. 🕒',
                    'Scheduled for Pickup' => 'Your laundry is scheduled for pickup soon. Please have it ready! 😊',
                    'Picked Up' => 'Your laundry has been picked up and is on its way to our facility. 👍',
                    'In Wash' => 'Your laundry is being processed with care in our facility. 🧼',
                    'Out for Delivery' => 'Your clean laundry is on its way back to you! 🚚',
                    'Delivered' => 'Your laundry has been delivered. Enjoy your clean clothes! ✨'
                ];
                
                // Default message if status doesn't match predefined messages
                $message = $status_messages[$current_status] ?? 'Your laundry is being processed. 😊';
                ?>
                <p><?php echo $message; ?></p>
            </div>

            <!-- Delivery Address Section -->
            <div class="delivery-address">
                <h3>Delivery Address</h3>
                <p><strong><?php echo htmlspecialchars($user_data['name'] ?? 'Name Not Available'); ?></strong></p>
                <p><?php echo htmlspecialchars($user_data['phoneNumber'] ?? 'Phone Not Available'); ?></p>
                <!-- Adjust this to match your address field name -->
                <p><?php echo htmlspecialchars($user_data['address'] ?? 'Address Not Available'); ?></p>
            </div>
            
            <?php if ($current_status != 'Delivered'): ?>
            <!-- Auto-refresh the page every 5 minutes to check for status updates -->
            <script>
                setTimeout(function() {
                    location.reload();
                }, 300000); // 5 minutes in milliseconds
            </script>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <!-- No Active Order Section -->
        <div class="order-details">
            <h2>No Active Orders</h2>
            <p>You don't have any active orders at the moment.</p>
            <a href="schedule.php" class="button">Schedule a Pickup</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>