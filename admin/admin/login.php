<?php
include('config.php');

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to check credentials in the admin table
    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);

        // Execute statement
        if ($stmt->execute()) {
            // Bind result variables
            $stmt->bind_result($id, $username, $stored_password);

            // Check if a result is returned
            if ($stmt->fetch()) {
                // Verify password
                if ($password === $stored_password) {
                    // Set session variables
                    $_SESSION['admin_id'] = $id;
                    $_SESSION['username'] = $username;

                    // Redirect to admin dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $message = "Invalid password.";
                }
            } else {
                $message = "No admin user found with that username.";
            }
        } else {
            $message = "Query execution failed.";
        }

        // Close statement
        $stmt->close();
    } else {
        $message = "Error preparing SQL statement: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}

// Output JavaScript alert and redirect
if (!empty($message)) {
    echo "<script type='text/javascript'>
            alert('$message');
            window.location.href = 'index.php';
          </script>";
}
?>
