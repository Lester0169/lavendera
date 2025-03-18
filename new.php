<?php
session_start(); // Start session for managing user login state

include('config.php'); // Include database configuration

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password']; // Plain text password from the form

    // Prepare SQL statement to retrieve user data
    $stmt = $conn->prepare("SELECT id, username, password, name, photo FROM users WHERE username = ?");
    
    // Check if prepare() succeeded
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($userId, $storedUsername, $storedPassword, $name, $photo);

    // Fetch and verify user
    if ($stmt->fetch()) {
        // Verify password using password_verify()
        if (password_verify($password, $storedPassword)) { // Correct way to verify hashed password
            // Password is correct, set session variables
            $_SESSION['userId'] = $userId;
            $_SESSION['username'] = $storedUsername;
            $_SESSION['name'] = $name;
            $_SESSION['loggedin'] = true;
            $_SESSION['photo'] = $photo;

            // Redirect to schedule.php
            header("Location: address.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['loginError'] = "Invalid password";
            echo "<script type='text/javascript'>
                alert('Invalid password');
                window.location.href = 'login.php';
              </script>";
            exit();
        }
    } else {
        // User not found
        $_SESSION['loginError'] = "User not found";
        echo "<script type='text/javascript'>
                alert('User not found');
                window.location.href = 'login.php';
              </script>";
        exit();
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>