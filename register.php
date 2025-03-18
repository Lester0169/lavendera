<?php
session_start();
include('config.php');

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set parameters from POST data
    $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Handle photo upload (if any)
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        $fileType = $_FILES['photo']['type'];
        $fileSize = $_FILES['photo']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                $photo = $targetFile;
            } else {
                $message = "Error uploading file.";
            }
        } else {
            $message = "Invalid file type or size.";
        }
    }

    // Prepare and bind the insert statement
    $sql = "INSERT INTO users (username, name, dateOfBirth, phoneNumber, password, photo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("SQL Error: " . $conn->error);
        $message = "An error occurred. Please try again later.";
    } else {
        $stmt->bind_param("ssssss", $username, $name, $dateOfBirth, $phoneNumber, $password, $photo);

        // Execute the statement
        if ($stmt->execute()) {
            // Set session variables after successful registration
            $_SESSION['userId'] = $conn->insert_id; // get the auto-incremented user ID
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;

            // Redirect to the login page
            header("Location: login.php");
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
} else {
    $message = "Form submission method not valid.";
}

// Close connection
$conn->close();

// Output JavaScript for alert and redirection
$message = $message ?? "An unknown error occurred.";
echo "<script type='text/javascript'>
        alert('$message');
        window.location.href = 'login.php';
      </script>";
?>