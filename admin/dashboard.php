<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "lavendera"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total number of users
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];

// Fetch total transactions per month
$sql_transactions = "
    SELECT 
        MONTH(transaction_date) AS month,
        YEAR(transaction_date) AS year,
        COUNT(*) AS total_transactions
    FROM transactions
    GROUP BY YEAR(transaction_date), MONTH(transaction_date)
    ORDER BY year DESC, month DESC";
$result_transactions = $conn->query($sql_transactions);

// Fetch admin username (do not change the admin username)
$sql_admin = "SELECT username FROM admin WHERE id = 1"; // Assuming the admin's ID is 1
$result_admin = $conn->query($sql_admin);
$admin_row = $result_admin->fetch_assoc();
$admin_username = $admin_row['username'];

// Prepare the data for the chart
$months = [];
$total_transactions = [];
$percentage_customers = [];

while ($row_transactions = $result_transactions->fetch_assoc()) {
    $month_year = $row_transactions['month'] . '-' . $row_transactions['year'];
    $months[] = $month_year;
    $total_transactions[] = $row_transactions['total_transactions'];

    // Calculate the percentage of customers who have made transactions
    $sql_customers = "SELECT COUNT(DISTINCT user_id) AS total_customers 
                      FROM transactions 
                      WHERE MONTH(transaction_date) = {$row_transactions['month']} 
                      AND YEAR(transaction_date) = {$row_transactions['year']}";
    $result_customers = $conn->query($sql_customers);
    $customer_row = $result_customers->fetch_assoc();
    $total_customers = $customer_row['total_customers'];

    $percentage = ($total_customers / $total_users) * 100;
    $percentage_customers[] = round($percentage, 2);
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: "Arial", serif;
        }
        .header {
            background-color: #ffffff;
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }
        #sidebar {
            width: 250px;
            background: #1678F3;
            color: #fff;
            height: calc(100vh - 80px);
            padding: 15px;
            position: fixed;
            top: 80px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        #sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            
        }
        #sidebar a:hover {
            background: #F984F4;
            border-radius: 10;
        }
        #sidebar a:focus {
            outline: none;
            background: #1463c2;
        }
        #content {
            margin-left: 250px;
            padding: 100px 20px 20px;
            width: calc(100% - 250px);
            background-color: #f4f4f4;
        }
        .card {
            margin-bottom: 20px;
        }
        .header .laundry_logo {
            width: 15%;
            height: auto;
            position: relative;
            left: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <img class="laundry_logo" src="logo1.png" alt="Laundry Provider Logo">
    </header>
    
    <div id="sidebar">
        <div>
            <a href="dashboard.php">Dashboard Overview</a>
            <a href="manage.php">Customer Management</a>
            <a href="manage.php">Order Status</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div id="content">
        <h1>Welcome, <?php echo htmlspecialchars($admin_username); ?>!</h1>
        
        <div class="row">
    <!-- Total Users Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text"><?php echo $total_users; ?></p>
            </div>
        </div>
    </div>

    <!-- Total Transactions Card (added beside Total Users) -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Transactions</h5>
                <p class="card-text"><?php echo array_sum($total_transactions); ?></p>
            </div>
        </div>
    </div>
</div>


        <div class="row">
            <div class="col-lg-12">
                <canvas id="transactionChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var transactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Total Transactions',
                    data: <?php echo json_encode($total_transactions); ?>,
                    backgroundColor: 'rgba(22, 120, 243, 0.2)',
                    borderColor: '#1678F3',
                    borderWidth: 2
                }, {
                    label: 'Percentage of Customers',
                    data: <?php echo json_encode($percentage_customers); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    type: 'line'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html>
