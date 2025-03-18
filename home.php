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

        <!-- Order Details Section -->
        <div class="order-details">
            <div class="order-status">
                <h2>YOUR LAUNDRY IS ON THE WAY</h2>
                <div class="order-timeline">
                    <div class="timeline-item filled">
                        <i class="fas fa-calendar-check"></i>
                        <strong>Scheduled for Pickup</strong>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-truck-pickup"></i>
                        <strong>Picked Up</strong>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-soap"></i>
                        <strong>In Wash</strong>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-truck"></i>
                        <strong>Out for Delivery</strong>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-check-circle"></i>
                        <strong>Delivered</strong>
                    </div>
                </div>
                <p>Your laundry is being processed and will be delivered to your doorstep. <span class="emoji">😊</span></p>
            </div>

            <!-- Delivery Address Section -->
            <div class="delivery-address">
                <h3>Delivery Address</h3>
                <p><strong>Lester Jhon Andico</strong></p>
                <p>(+63) 9518410074</p>
                <p>Blk 36 Lot 21 Rosalina Village 3, Ballok, Davao City, Davao Del Sur</p>
            </div>
        </div>
    </div>
</body>
</html>