<?php
// Include the database configuration
require_once 'config.php';

// Set content type to JSON
header('Content-Type: application/json');

// Function to return JSON response and exit
function sendResponse($status, $message, $data = null) {
    $response = [
        'status' => $status,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response);
    exit;
}

// Check if the database connection is successful
if ($conn->connect_error) {
    sendResponse('error', 'Connection failed: ' . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    sendResponse('error', 'Invalid request method');
}

// Collect input data
$address = $_POST['address'] ?? '';
$instructions = $_POST['instructions'] ?? '';

// Validate input - allow empty instructions
if (empty($address)) {
    sendResponse('error', 'Address is required');
}

try {
    // Begin transaction for data consistency
    $conn->begin_transaction();
    
    // Prepare the SQL statement to prevent SQL injection
    $sql = "INSERT INTO pickup_locations (address, instructions) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("ss", $address, $instructions);
    
    // Execute the query
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    
    $location_id = $conn->insert_id;
    
    // Fetch the newly inserted data
    $sql_fetch = "SELECT id, address, instructions, created_at FROM pickup_locations WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    
    if (!$stmt_fetch) {
        throw new Exception('Prepare fetch failed: ' . $conn->error);
    }
    
    $stmt_fetch->bind_param("i", $location_id);
    
    if (!$stmt_fetch->execute()) {
        throw new Exception('Execute fetch failed: ' . $stmt_fetch->error);
    }
    
    $result_fetch = $stmt_fetch->get_result();
    $location_data = $result_fetch->fetch_assoc();
    
    if (!$location_data) {
        throw new Exception('No data found for ID: ' . $location_id);
    }
    
    // Commit the transaction
    $conn->commit();
    
    // Clean up
    $stmt->close();
    $stmt_fetch->close();
    
    // Store location ID in session for future use
    session_start();
    $_SESSION['location_id'] = $location_id;
    
    sendResponse('success', 'Pickup location saved successfully', ['location_data' => $location_data]);
    
} catch (Exception $e) {
    // Roll back the transaction on error
    $conn->rollback();
    sendResponse('error', $e->getMessage());
} finally {
    // Close the connection
    $conn->close();
}
?>