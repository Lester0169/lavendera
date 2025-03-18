<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rinse - Order History</title>
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
            font-family: 'Open Sans', sans-serif;
            line-height: 1.5;
        }
        
        /* Typography Hierarchy */
        h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.3;
        }
        
        h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 600;
            line-height: 1.3;
        }
        
        h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 600;
            line-height: 1.4;
        }
        
        p {
            font-size: 16px;
            font-weight: 400;
            line-height: 1.6;
            color: #555;
        }
        
        .sidebar {
            width: 320px;
            background: linear-gradient(135deg, #FF8C00, #FFA500);
            color: white;
            padding: 40px 30px;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar img {
            width: 180px;
            margin-bottom: 32px;
        }
        
        .sidebar h1 {
            margin-bottom: 40px;
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
            padding: 12px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-menu a:active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-menu .active {
            background-color: #1678F3;
            color: white;
            font-weight: bold;
        }
        
        .main-content {
            flex: 1;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .top-nav {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }
        
        .top-nav a {
            margin-left: 24px;
            text-decoration: none;
            color: #1a5e76;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .top-nav a:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .top-nav a:active {
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .top-nav a:first-child {
            color: #1678F3;
        }

        .order-history {
            max-width: 900px;
            margin: 0 auto;
        }

        .order-history h2 {
            margin-bottom: 32px;
            color: #333;
        }

        .history-filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .filter-dropdown {
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: white;
            font-family: 'Open Sans', sans-serif;
            font-size: 15px;
            color: #555;
            cursor: pointer;
            min-width: 160px;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-family: 'Open Sans', sans-serif;
            font-size: 15px;
            width: 240px;
            transition: border-color 0.3s ease;
        }

        .search-bar input:focus {
            border-color: #1678F3;
        }

        .search-bar button {
            margin-left: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(to right, #1678F3, #F984F4);
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .search-bar button:hover {
            background: linear-gradient(to right, #F984F4, #1678F3);
        }

        .order-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: white;
        }

        .order-card:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eee;
        }

        .order-id {
            font-weight: bold;
            color: #1678F3;
        }

        .order-date {
            color: #777;
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .order-info {
            flex: 1;
        }

        .order-info h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        .order-info p {
            margin-bottom: 8px;
            color: #555;
        }

        .price {
            font-weight: bold;
            font-size: 20px;
            color: #1678F3;
        }

        .order-status-badge {
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            max-width: 120px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .status-processing {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-scheduled {
            background-color: #cce5ff;
            color: #004085;
        }

        .order-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(to right, #1678F3, #F984F4);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #F984F4, #1678F3);
        }

        .btn-outline {
            background-color: transparent;
            color: #1678F3;
            border: 1px solid #1678F3;
            margin-right: 12px;
        }

        .btn-outline:hover {
            background-color: rgba(22, 120, 243, 0.1);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 8px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #555;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #f4f4f4;
        }

        .pagination .active {
            background-color: #1678F3;
            color: white;
            border-color: #1678F3;
        }

        .no-orders {
            text-align: center;
            padding: 80px 0;
            color: #777;
        }

        .no-orders i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 24px;
        }

        .no-orders h3 {
            margin-bottom: 16px;
            color: #555;
        }

        /* Rating Modal Styles */
        .rating-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .rating-modal-content {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .rating-modal h3 {
            margin-bottom: 16px;
            color: #333;
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .rating-stars .star {
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .rating-stars .star.active {
            color: #FFD700; /* Gold color for active stars */
        }

        .rating-modal button {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(to right, #1678F3, #F984F4);
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .rating-modal button:hover {
            background: linear-gradient(to right, #F984F4, #1678F3);
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
            .history-filters {
                flex-direction: column;
                gap: 16px;
            }
            .search-bar input {
                width: 100%;
            }
            .rating-modal-content {
                width: 90%;
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

        <!-- Order History Section -->
        <div class="order-history">
            <h2>Order History</h2>
            
            <!-- Filters and Search -->
            <div class="history-filters">
                <select class="filter-dropdown">
                    <option value="all">All Orders</option>
                    <option value="delivered">Delivered</option>
                    <option value="processing">Processing</option>
                    <option value="scheduled">Scheduled</option>
                </select>
                
                <div class="search-bar">
                    <input type="text" placeholder="Search orders...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
            
            <!-- Order Cards -->
            <div class="order-card">
                <div class="order-header">
                    <span class="order-id">Order #12345</span>
                    <span class="order-date">March 15, 2025</span>
                </div>
                <div class="order-details">
                    <div class="order-info">
                        <h3>Washing</h3>
                        <p>1 load</p>
                        <p>Delivery Address: Blk 36 Lot 21 Rosalina Village 3, Baliok, Davao City, Davao Del Sur</p>
                    </div>
                    <div class="order-price">
                        <div class="price">₱115.00</div>
                        <div class="order-status-badge status-delivered">Delivered</div>
                    </div>
                </div>
                <div class="order-actions">
                    <a href="#" class="btn btn-outline">View Details</a>
                    <a href="#" class="btn btn-primary rate-order-btn">Rate Order</a>
                </div>
            </div>
            
            <div class="order-card">
                <div class="order-header">
                    <span class="order-id">Order #12289</span>
                    <span class="order-date">March 8, 2025</span>
                </div>
                <div class="order-details">
                    <div class="order-info">
                        <h3>Drying</h3>
                        <p>30 mins</p>
                        <p>Delivery Address: Blk 36 Lot 21 Rosalina Village 3, Baliok, Davao City, Davao Del Sur</p>
                    </div>
                    <div class="order-price">
                        <div class="price">₱110.00</div>
                        <div class="order-status-badge status-delivered">Delivered</div>
                    </div>
                </div>
                <div class="order-actions">
                    <a href="#" class="btn btn-outline">View Details</a>
                    <a href="#" class="btn btn-primary rate-order-btn">Rate Order</a>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">&raquo;</a>
            </div>
            
            <!-- Empty State (Hidden by default, can be shown dynamically) -->
            <div class="no-orders" style="display: none;">
                <i class="fas fa-box-open"></i>
                <h3>No Orders Found</h3>
                <p>You haven't placed any orders yet.</p>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div class="rating-modal" id="ratingModal">
        <div class="rating-modal-content">
            <h3>Rate Your Order</h3>
            <div class="rating-stars">
                <span class="star" data-rating="1">&#9733;</span>
                <span class="star" data-rating="2">&#9733;</span>
                <span class="star" data-rating="3">&#9733;</span>
                <span class="star" data-rating="4">&#9733;</span>
                <span class="star" data-rating="5">&#9733;</span>
            </div>
            <button id="submitRating">Submit Rating</button>
        </div>
    </div>

    <script>
        // JavaScript to handle the rating modal
        const rateOrderButtons = document.querySelectorAll('.rate-order-btn');
        const ratingModal = document.getElementById('ratingModal');
        const stars = document.querySelectorAll('.rating-stars .star');
        const submitRatingButton = document.getElementById('submitRating');

        let selectedRating = 0;

        // Open the rating modal
        rateOrderButtons.forEach(button => {
            button.addEventListener('click', () => {
                ratingModal.style.display = 'flex';
            });
        });

        // Handle star rating selection
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = parseInt(star.getAttribute('data-rating'));
                selectedRating = rating;

                // Highlight selected stars
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });

        // Submit rating
        submitRatingButton.addEventListener('click', () => {
            if (selectedRating > 0) {
                alert(`Thank you for rating your order with ${selectedRating} stars!`);
                ratingModal.style.display = 'none';
                selectedRating = 0; // Reset rating
                stars.forEach(star => star.classList.remove('active')); // Reset stars
            } else {
                alert('Please select a rating before submitting.');
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === ratingModal) {
                ratingModal.style.display = 'none';
                selectedRating = 0; // Reset rating
                stars.forEach(star => star.classList.remove('active')); // Reset stars
            }
        });
    </script>
</body>
</html>