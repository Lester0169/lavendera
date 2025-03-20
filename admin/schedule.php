<?php
// Include the database connection file
include('config.php');

// Start the session (if applicable for logged-in users)
session_start();

// Initialize variables to hold the POST data
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Get user_id from session
$service_type = isset($_POST['service_type']) ? $_POST['service_type'] : '';
$total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
$pickup_date = isset($_POST['pickup_date']) ? $_POST['pickup_date'] : '';
$dropoff_date = isset($_POST['dropoff_date']) ? $_POST['dropoff_date'] : '';
$delivery_option = isset($_POST['delivery_option']) ? $_POST['delivery_option'] : '';
$payment_method_id = isset($_POST['payment_method']) ? intval($_POST['payment_method']) : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user_id exists in the session
    if ($user_id == 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
        exit();
    }

    // Insert into orders table using prepared statements
    $sql = "INSERT INTO orders (user_id, service_type, total_price, pickup_date, dropoff_date, delivery_option, payment_method_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $user_id, $service_type, $total_price, $pickup_date, $dropoff_date, $delivery_option, $payment_method_id);

    if ($stmt->execute()) {
        // Get the inserted order ID
        $order_id = $stmt->insert_id;

        // Insert selected services into order_services table
        if (isset($_POST['services']) && is_array($_POST['services'])) {
            foreach ($_POST['services'] as $service) {
                $service_id = intval($service['service_id']);
                $quantity = intval($service['quantity']);
                $service_sql = "INSERT INTO order_services (order_id, service_id, quantity)
                                VALUES (?, ?, ?)";
                $service_stmt = $conn->prepare($service_sql);
                $service_stmt->bind_param("iii", $order_id, $service_id, $quantity);
                $service_stmt->execute();
            }
        }

        // Insert delivery option if any
        $delivery_fee = ($delivery_option == 'delivery') ? 50.00 : 0.00; // Delivery fee is ₱50.00
        $delivery_sql = "INSERT INTO order_delivery (order_id, delivery_option, delivery_fee)
                         VALUES (?, ?, ?)";
        $delivery_stmt = $conn->prepare($delivery_sql);
        $delivery_stmt->bind_param("isd", $order_id, $delivery_option, $delivery_fee);
        $delivery_stmt->execute();

        // Store the order_id in the session for later use
        $_SESSION['order_id'] = $order_id;

        // Return a success response
        echo json_encode(['status' => 'success', 'message' => 'Order scheduled successfully', 'order_id' => $order_id]);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Your Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
            padding: 0;
            display: flex;
            align-items: center;
            z-index: 100;
        }

        .step-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            color: #222;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .section p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .pickup-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #007bff;
            margin-bottom: 20px;
            position: relative;
        }

        .pickup-box strong {
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 10px;
            position: relative;
            left: 40px;
        }

        .pickup-date {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
        }

        .pickup-date i {
            margin-right: 10px;
            font-size: 20px;
            position: relative;
            bottom: 18px;
        }

        .calendar-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
            color: #007bff;
            cursor: pointer;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .calendar-icon:hover {
            color: #0056b3;
        }

        .calendar-icon::after {
            content: "Select Date";
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: #007bff;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .calendar-icon:hover::after {
            opacity: 1;
        }

        .hidden-input {
            display: none;
        }

        .service-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #007bff;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
            transition: background-color 0.3s ease;
        }

        .service-box.added {
            background-color: #e9f5ff;
        }

        .service-box label {
            font-size: 16px;
            color: #333;
        }

        .service-box .add-button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s ease;
        }

        .service-box .add-button:hover {
            background-color: #0056b3;
        }

        .service-box .add-button.added {
            background-color: #28a745;
        }

        .service-box .check-icon {
            display: none;
            color: #fff;
        }

        .service-box .add-button.added .check-icon {
            display: inline;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .payment-option:hover {
            background-color: #f9f9f9;
        }

        .payment-option.selected {
            border-color: #007bff;
            background-color: #e9f5ff;
        }

        .payment-option i {
            font-size: 24px;
            color: #28a745;
        }

        .payment-option label {
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }

        .button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            cursor: pointer;
            text-align: center;
            margin-top: 40px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .total-price {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
            text-align: right;
        }

        .error-message {
            color: #d9534f;
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }

        /* Ensure the calendar pop-up appears near the icon */
        .flatpickr-calendar {
            position: absolute;
            top: 40px;
            right: 0;
            z-index: 1000;
        }

        /* Service Type Toggle Styles */
        .service-type-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .service-type-option {
            padding: 10px 20px;
            background-color: #f9f9f9;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            flex: 1;
            max-width: 200px;
            transition: all 0.3s ease;
        }

        .service-type-option.selected {
            background-color: #e9f5ff;
            border-color: #007bff;
            color: #007bff;
        }

        .service-type-option i {
            margin-right: 8px;
            font-size: 18px;
        }

        /* Drop-off Section */
        .dropoff-section {
            display: none;
            margin-bottom: 20px;
        }

        .dropoff-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #007bff;
            margin-bottom: 20px;
            position: relative;
        }

        .dropoff-box strong {
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 10px;
            position: relative;
            left: 40px;
        }

        .dropoff-date {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
        }

        .dropoff-date i {
            margin-right: 10px;
            font-size: 20px;
            position: relative;
            bottom: 18px;
        }

        /* Delivery Option Styles */
        .delivery-section {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .delivery-toggle {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .delivery-option {
            padding: 10px 20px;
            background-color: #f9f9f9;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            flex: 1;
            max-width: 200px;
            transition: all 0.3s ease;
        }

        .delivery-option.selected {
            background-color: #e9f5ff;
            border-color: #007bff;
            color: #007bff;
        }

        .delivery-option i {
            margin-right: 8px;
            font-size: 18px;
        }

        .delivery-fee {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-top: 10px;
        }

        .delivery-note {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-top: 5px;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <button class="back-button" onclick="window.location.href='address.php'" aria-label="Go back to address page">
        <i class="fas fa-arrow-left"></i>
    </button>

    <!-- Step Indicator -->
    <div class="step-indicator">Step 2/2</div>

    <div class="container">
        <h1 class="title">Schedule your order</h1>

        <form id="orderForm" method="POST" action="schedule.php">
             <!-- Service Type Selection -->
             <div class="section">
                <h2>Service Type</h2>
                <p>Select how you prefer to handle your laundry:</p>
                <div class="service-type-toggle">
                    <div class="service-type-option selected" onclick="toggleServiceType('pickup')" id="pickupOption">
                        <i class="fas fa-truck"></i> Pickup Service
                        <span class="fee-badge">₱30</span>
                    </div>
                    <div class="service-type-option" onclick="toggleServiceType('dropoff')" id="dropoffOption">
                        <i class="fas fa-store-alt"></i> Self Drop-off
                    </div>
                </div>
                <input type="hidden" name="service_type" id="serviceTypeInput" value="pickup">
            </div>

    <!-- Pickup Section -->
    <div class="section" id="pickupSection">
                <h2>Pickup</h2>
                <p>We will deliver your laundry today if you order before 1 PM. If you order beyond 1 PM, you will get your laundry tomorrow.</p>
                <div class="pickup-box">
                    <i class="fas fa-calendar-alt calendar-icon" id="calendarIcon" aria-label="Open calendar"></i>
                    <input type="text" id="pickupDateInput" class="hidden-input" name="pickup_date">
                    <div class="pickup-info">
                        <strong>PICKUP</strong>
                        <span id="pickupDate" class="pickup-date">
                            <i class="fas fa-bicycle"></i> Tonight, March 18
                        </span>
                    </div>
                </div>
                <p style="text-align: center; color: #666; font-size: 13px;">
                    <i class="fas fa-info-circle"></i> A pickup fee of ₱30 will be added to your total.
                </p>
            </div>

    <!-- Drop-off Section -->
    <div class="section dropoff-section" id="dropoffSection">
                <h2>Drop-off</h2>
                <p>Please select when you plan to drop off your laundry at our location.</p>
                <div class="dropoff-box">
                    <i class="fas fa-calendar-alt calendar-icon" id="dropoffCalendarIcon" aria-label="Open calendar"></i>
                    <input type="text" id="dropoffDateInput" class="hidden-input" name="dropoff_date">
                    <div class="dropoff-info">
                        <strong>DROP-OFF</strong>
                        <span id="dropoffDate" class="dropoff-date">
                            <i class="fas fa-store"></i> Tonight, March 18
                        </span>
                    </div>
                </div>
                <p style="text-align: center; color: #666; font-size: 13px;">
                    <i class="fas fa-info-circle"></i> No additional fee for self drop-off.
                </p>
            </div>

    <!-- Services Section -->
    <div class="section">
                <h2>Services</h2>
                <div class="service-box" id="washingBox">
                    <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                        <div>
                            <i class="fas fa-tshirt"></i>
                            <label for="washing">Washing - ₱65.00 per load</label>
                            <select id="washingLoads" onchange="updateTotalPrice()" aria-label="Select number of loads" name="services[0][quantity]">
                                <option value="1">1 load</option>
                                <option value="2">2 loads</option>
                                <option value="3">3 loads</option>
                                <option value="4">4 loads</option>
                                <option value="5">5 loads</option>
                            </select>
                            <input type="hidden" name="services[0][service_id]" value="1"> <!-- Washing service ID -->
                        </div>
                        <button type="button" class="add-button" onclick="toggleService('washingBox')" aria-label="Add washing service">
                            <span class="button-text">Add</span>
                            <i class="fas fa-check check-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="service-box" id="dryingBox">
                    <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                        <div>
                            <i class="fas fa-wind"></i>
                            <label for="drying">Drying</label>
                            <select id="dryingTime" onchange="updateTotalPrice()" aria-label="Select drying time" name="services[1][quantity]">
                                <option value="20">20 mins - ₱40.00</option>
                                <option value="30">30 mins - ₱60.00</option>
                                <option value="40">40 mins - ₱80.00</option>
                                <option value="50">50 mins - ₱100.00</option>
                            </select>
                            <input type="hidden" name="services[1][service_id]" value="2"> <!-- Drying service ID -->
                        </div>
                        <button type="button" class="add-button" onclick="toggleService('dryingBox')" aria-label="Add drying service">
                            <span class="button-text">Add</span>
                            <i class="fas fa-check check-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

     <!-- Delivery Options Section -->
     <div class="delivery-section" id="deliverySection">
                <h2>Return Options</h2>
                <p>Choose how you want to receive your laundry after it's done:</p>
                <div class="delivery-toggle">
                    <div class="delivery-option selected" onclick="toggleDeliveryOption('delivery')" id="deliveryOption">
                        <i class="fas fa-truck"></i> Delivery
                        <span class="fee-badge">₱50</span>
                    </div>
                    <div class="delivery-option" onclick="toggleDeliveryOption('selfPickup')" id="selfPickupOption">
                        <i class="fas fa-walking"></i> Self Pickup
                    </div>
                </div>
                <input type="hidden" name="delivery_option" id="deliveryOptionInput" value="delivery">
                <div id="deliveryFeeInfo" class="delivery-fee">
                    <i class="fas fa-info-circle"></i> A delivery fee of ₱50 will be added to your total.
                </div>
            </div>

    <!-- Total Price Display -->
    <div class="total-price">
                Total: ₱<span id="totalPrice">0.00</span>
                <input type="hidden" name="total_price" id="totalPriceInput" value="0.00">
            </div>

    <!-- Payment Section -->
    <div class="section">
                <h2>Payment method</h2>
                <p style="font-size: 14px; color: #666; margin-bottom: 20px;">
                    To confirm your order, please choose your preferred payment method. You'll be charged after the delivery.
                </p>
                <div class="payment-options">
                    <div class="payment-option selected" onclick="selectPayment('Cash')">
                        <i class="fas fa-money-bill-wave"></i>
                        <label>Cash</label>
                        <input type="radio" name="payment_method" id="cash" value="1" checked style="display: none;">
                    </div>
                </div>
                <div class="error-message" id="paymentError">Please select a payment method.</div>
            </div>

    <!-- Schedule Button -->
    <div class="section">
                <button class="button" id="scheduleButton" type="submit" aria-label="Schedule my order">Schedule my order</button>
            </div>
        </form>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    // Prices
    const washingPrice = 65.00; // Price per load
        const dryingPrices = {
            20: 40.00,
            30: 60.00,
            40: 80.00,
            50: 100.00
        };
        const pickupFee = 30.00; // Pickup fee is ₱30.00
        const deliveryFee = 50.00; // Delivery fee is ₱50.00

    // Track service state
    let isWashingAdded = false;
    let isDryingAdded = false;
    let selectedDryingTime = 20; // Default drying time
    let selectedPaymentMethod = 'Cash'; // Default payment method
    let washingLoads = 1; // Default number of washing loads
    let serviceType = 'pickup'; // Default service type (pickup or dropoff)
    let deliveryOption = 'delivery'; // Default delivery option (delivery or selfPickup)

    // Set default values on page load
    document.addEventListener('DOMContentLoaded', function () {
        selectPayment('Cash');
        updateTotalPrice(); // Initialize total price

        // Initialize Flatpickr for pickup date
        const pickupDateInput = document.getElementById('pickupDateInput');
        const pickupDateElement = document.getElementById('pickupDate');
        const calendarIcon = document.getElementById('calendarIcon');

        const pickupFlatpickrInstance = flatpickr(pickupDateInput, {
            dateFormat: "Y-m-d",
            minDate: "today",
            maxDate: new Date().fp_incr(14), // Allow selection for the next two weeks
            onChange: function(selectedDates, dateStr, instance) {
                const selectedDate = selectedDates[0];
                const formattedDate = formatDate(selectedDate);
                pickupDateElement.innerHTML = `<i class="fas fa-bicycle"></i> ${formattedDate}`;
            }
        });

        // Open Flatpickr when the calendar icon is clicked
        calendarIcon.addEventListener('click', () => {
            pickupFlatpickrInstance.open();
        });

        // Initialize Flatpickr for drop-off date
        const dropoffDateInput = document.getElementById('dropoffDateInput');
        const dropoffDateElement = document.getElementById('dropoffDate');
        const dropoffCalendarIcon = document.getElementById('dropoffCalendarIcon');

        const dropoffFlatpickrInstance = flatpickr(dropoffDateInput, {
            dateFormat: "Y-m-d",
            minDate: "today",
            maxDate: new Date().fp_incr(14), // Allow selection for the next two weeks
            onChange: function(selectedDates, dateStr, instance) {
                const selectedDate = selectedDates[0];
                const formattedDate = formatDate(selectedDate);
                dropoffDateElement.innerHTML = `<i class="fas fa-store"></i> ${formattedDate}`;
            }
        });

        // Open Flatpickr when the drop-off calendar icon is clicked
        dropoffCalendarIcon.addEventListener('click', () => {
            dropoffFlatpickrInstance.open();
        });
    });

    // Toggle between pickup and drop-off service types
    function toggleServiceType(type) {
        serviceType = type;
        
        // Update the hidden input for service type
        document.getElementById('serviceTypeInput').value = type;
        
        // Update UI
        if (type === 'pickup') {
            document.getElementById('pickupOption').classList.add('selected');
            document.getElementById('dropoffOption').classList.remove('selected');
            document.getElementById('pickupSection').style.display = 'block';
            document.getElementById('dropoffSection').style.display = 'none';
        } else {
            document.getElementById('pickupOption').classList.remove('selected');
            document.getElementById('dropoffOption').classList.add('selected');
            document.getElementById('pickupSection').style.display = 'none';
            document.getElementById('dropoffSection').style.display = 'block';
        }
        
        // Update total price based on new service type
        updateTotalPrice();
    }

    // Toggle between delivery and self-pickup options
    function toggleDeliveryOption(option) {
        deliveryOption = option;
        
        // Update the hidden input for delivery option
        document.getElementById('deliveryOptionInput').value = option;
        
        // Update UI
        if (option === 'delivery') {
            document.getElementById('deliveryOption').classList.add('selected');
            document.getElementById('selfPickupOption').classList.remove('selected');
            document.getElementById('deliveryFee').textContent = 'Delivery Fee: ₱50.00';
        } else {
            document.getElementById('deliveryOption').classList.remove('selected');
            document.getElementById('selfPickupOption').classList.add('selected');
            document.getElementById('deliveryFee').textContent = 'Self Pickup: Free';
        }
        
        // Update total price based on new delivery option
        updateTotalPrice();
    }

    // Function to format date
    function formatDate(date) {
        const today = new Date();
        const tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);

        if (date.toDateString() === today.toDateString()) {
            return "Today";
        } else if (date.toDateString() === tomorrow.toDateString()) {
            return "Tomorrow";
        } else {
            const options = { weekday: 'long', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }
    }

    // Toggle service selection
    function toggleService(boxId) {
            const box = document.getElementById(boxId);
            const addButton = box.querySelector('.add-button');
            
            if (boxId === 'washingBox') {
                isWashingAdded = !isWashingAdded;
                if (isWashingAdded) {
                    box.classList.add('added');
                    addButton.classList.add('added');
                    addButton.querySelector('.button-text').textContent = 'Added';
                } else {
                    box.classList.remove('added');
                    addButton.classList.remove('added');
                    addButton.querySelector('.button-text').textContent = 'Add';
                }
            } else if (boxId === 'dryingBox') {
                isDryingAdded = !isDryingAdded;
                if (isDryingAdded) {
                    box.classList.add('added');
                    addButton.classList.add('added');
                    addButton.querySelector('.button-text').textContent = 'Added';
                } else {
                    box.classList.remove('added');
                    addButton.classList.remove('added');
                    addButton.querySelector('.button-text').textContent = 'Add';
                }
            }
            
            updateTotalPrice();
        }


    // Update the total price
    function updateTotalPrice() {
            let total = 0;
            
            if (isWashingAdded) {
                washingLoads = parseInt(document.getElementById('washingLoads').value);
                total += washingPrice * washingLoads;
                
                // Add pickup fee only if pickup service is selected
                if (serviceType === 'pickup') {
                    total += pickupFee;
                }
            }
            
            if (isDryingAdded) {
                selectedDryingTime = parseInt(document.getElementById('dryingTime').value);
                total += dryingPrices[selectedDryingTime];
            }
            
            // Add delivery fee if delivery option is selected
            if (deliveryOption === 'delivery' && (isWashingAdded || isDryingAdded)) {
                total += deliveryFee;
            }

            // Update the total price display
            document.getElementById('totalPrice').textContent = total.toFixed(2);
            document.getElementById('totalPriceInput').value = total.toFixed(2); // Update hidden input
        }

    // Select payment method
    function selectPayment(method) {
        selectedPaymentMethod = method;
        
        // Update UI
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            if (option.getAttribute('onclick').includes(method)) {
                option.classList.add('selected');
            } else {
                option.classList.remove('selected');
            }
        });
    }

    // Fetch order details after scheduling
    function fetchOrderDetails(order_id) {
        fetch('schedule_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ order_id: order_id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Display order details
                console.log('Order Details:', data.data);
                // You can update the DOM here to display the order details to the user
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Handle form submission
    document.getElementById('orderForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Validate if at least one service is selected
        if (!isWashingAdded && !isDryingAdded) {
            alert('Please select at least one service.');
            return;
        }

        // Validate if payment method is selected
        if (!selectedPaymentMethod) {
            document.getElementById('paymentError').style.display = 'block';
            return;
        } else {
            document.getElementById('paymentError').style.display = 'none';
        }

        // Submit the form via AJAX
        const formData = new FormData(this);
        fetch('schedule.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Fetch and display order details after successful scheduling
                window.location.href = 'home.php?order_success=true';
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
</body>
</html>