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

// Handle approval and disapproval actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = $_POST['application_id'];
    if (isset($_POST['approve'])) {
        $application_status = 'approved';
    } elseif (isset($_POST['disapprove'])) {
        $application_status = 'disapproved';
    }

    if (isset($application_status)) {
        // Update the application status
        $stmt = $conn->prepare("UPDATE business_applications SET application_status = ? WHERE id = ?");
        if (!$stmt) {
            die("Error preparing UPDATE statement: " . $conn->error);
        }
        $stmt->bind_param("si", $application_status, $application_id);
        if ($stmt->execute()) {
            $message = "Application status updated to " . $application_status;
        } else {
            $message = "Error updating application status: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all business applications
$sql = "SELECT * FROM business_applications";
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
            font-family: "Averia Serif Libre", serif;
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
            padding: 10px 0;
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
    </style>
</head>
<body>
    <header class="header">
        <img class="logo1" src="Group 31642.png" alt="Business Logo">
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
        <h1>Manage Business Applications</h1>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Business Name</th>
                    <th>Full Address</th>
                    <th>Business Permit</th>
                    <th>Availability</th>
                    <th>Phone Number</th>
                    <th>Application Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['business_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_address']); ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#permitModal" onclick="viewPermit('<?php echo htmlspecialchars('../' . $row['business_permit']); ?>')">View Permit</button>
                    </td>
                    <td><?php echo htmlspecialchars($row['availability']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['application_status']); ?></td>
                    <td class="actions">
                        <form method="post" action="">
                            <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                            <button type="submit" name="disapprove" class="btn btn-danger btn-sm">Disapprove</button>
                        </form>
                    </td>
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
    </script>
</body>
</html>
<?php
$conn->close();
?>
