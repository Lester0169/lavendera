<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Admin dashboard content goes here
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
            font-family: "Averia Serif Libre", serif;
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
        .logo1 {
            height: 60px;
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
            padding: 10px 0;
        }
        #sidebar a:hover {
            background: #F984F4;
        }
        #sidebar a:focus {
            outline: none;
            background: #1463c2;
        }
        #content {
            margin-left: 250px; /* This should match the sidebar width */
            padding: 100px 20px 20px; /* Adjusted padding for fixed header */
            width: calc(100% - 250px); /* Adjusted for sidebar width */
            background-color: #f4f4f4;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <img class="logo1" src="Group 31642.png" alt="Laundry Provider Logo">
    </header>
    
    <div id="sidebar">
        <div>
            <a href="dashboard.php">Dashboard</a>
            <a href="manage.php">Manage Applications</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div id="content">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">1,234</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Active Users</h5>
                        <p class="card-text">567</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pending Requests</h5>
                        <p class="card-text">24</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Issues</h5>
                        <p class="card-text">8</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Activity</h5>
                        <!-- Placeholder for a chart -->
                        <canvas id="userActivityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Notifications</h5>
                        <ul class="list-group">
                            <li class="list-group-item">New user registered</li>
                            <li class="list-group-item">Password change request</li>
                            <li class="list-group-item">3 users reported an issue</li>
                            <li class="list-group-item">New admin message</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Placeholder for a chart (e.g., User Activity Chart)
        var ctx = document.getElementById('userActivityChart').getContext('2d');
        var userActivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'User Activity',
                    data: [10, 50, 25, 70, 40, 90],
                    backgroundColor: 'rgba(22, 120, 243, 0.2)',
                    borderColor: '#1678F3',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
