<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Include database configuration
include('config.php');

// Fetch all business applications
$sql = "SELECT * FROM Customer_Management";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Business Applications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            margin: 0;
            font-family: "Arial", serif;
            background-color: #f0f8ff;
        }
        .header {
            background-color: #ffffff;
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
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
            padding: 10px;
        }
        #sidebar a:hover {
            background: #F984F4;
        }
        #content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }
        th {
            background-color: #1678F3;
            color: white;
            font-weight: bold;
        }
        td {
            background-color: #f9f9f9;
        }
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        .header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.search-container {
    display: flex;
    justify-content: flex-end;
}

.search-input {
    padding: 10px;
    font-size: 16px;
    width: 250px;
    border-radius: 4px;
    border: 1px solid #ddd;
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
        <img class="laundry_logo" src="logo1.png" alt="Business Logo">
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
    <div class="header-content">
        <h1>Customer Management</h1>
        <div class="search-container">
    <input type="text" id="searchInput" class="search-input" placeholder="Search Customer..." onkeyup="searchFunction()">
   </div>
</div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Full Address</th>
                    <th>Date</th>
                    <th>Type of Service</th>
                    <th>Phone Number</th>
                    <th>Bill</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['Full_Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['Full_Address']); ?></td>
                    <td><?php echo htmlspecialchars($row['Date']); ?></td>
                    <td><?php echo htmlspecialchars($row['Type_of_Service']); ?></td>
                    <td><?php echo htmlspecialchars($row['Phone_Number']); ?></td>
                    <td><?php echo htmlspecialchars($row['Bill']); ?></td>
                    <td><?php echo htmlspecialchars($row['Status']); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="permitModal" tabindex="-1" role="dialog" aria-labelledby="permitLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permitLabel">Business Permit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="permitFrame" width="100%" height="400px"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script>
        function viewPermit(url) {
            document.getElementById('permitFrame').src = url;
        }
        function searchFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    table = document.querySelector('table');
    tr = table.getElementsByTagName('tr');

    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td');
        let matchFound = false;
        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    matchFound = true;
                    break;
                }
            }
        }
        if (matchFound) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

    </script>
</body>
</html>
<?php
$conn->close();
?>
