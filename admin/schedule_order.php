<?php
// Include the database connection file
include('config.php');

// Start the session (if applicable for logged-in users)
session_start();

// Check if the order_id is available in the session or POST data
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
} elseif (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'Order ID not found.']);
    exit();
}

// Fetch Order Information
$order_sql = "SELECT * FROM orders WHERE order_id = ?";
$order_stmt = $conn->prepare($order_sql);
if (!$order_stmt) {
    error_log("Error preparing order query: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}
$order_stmt->bind_param("i", $order_id);
if (!$order_stmt->execute()) {
    error_log("Error fetching order details: " . $order_stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}
$order_result = $order_stmt->get_result();
if ($order_result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
    exit();
}
$order_data = $order_result->fetch_assoc();

// Fetch Order Delivery Information
$delivery_sql = "SELECT * FROM order_delivery WHERE order_id = ?";
$delivery_stmt = $conn->prepare($delivery_sql);
if (!$delivery_stmt) {
    error_log("Error preparing delivery query: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}
$delivery_stmt->bind_param("i", $order_id);
if (!$delivery_stmt->execute()) {
    error_log("Error fetching delivery details: " . $delivery_stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}
$delivery_result = $delivery_stmt->get_result();
$delivery_data = $delivery_result->fetch_assoc();

// Fetch Order Services Information
$services_sql = "SELECT os.order_service_id, os.order_id, os.service_id, os.quantity, s.service_name, s.service_price, s.description
                 FROM order_services os
                 JOIN services s ON os.service_id = s.service_id
                 WHERE os.order_id = ?";
$services_stmt = $conn->prepare($services_sql);
if (!$services_stmt) {
    error_log("Error preparing services query: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}
$services_stmt->bind_param("i", $order_id);
if (!$services_stmt->execute()) {
    error_log("Error fetching services details: " . $services_stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit();
}
$services_result = $services_stmt->get_result();
$services_data = [];
while ($row = $services_result->fetch_assoc()) {
    $services_data[] = $row;
}

// Combine all the data into a single array
$order_details = [
    'order' => $order_data,
    'delivery' => $delivery_data,
    'services' => $services_data
];

// Return the data as JSON
echo json_encode(['status' => 'success', 'data' => $order_details]);

// Close the statements
$order_stmt->close();
$delivery_stmt->close();
$services_stmt->close();

// Close the database connection
$conn->close();
?>