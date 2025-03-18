<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Your Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            position: relative; /* Ensure this is set */
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

        .edit-link {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10; /* Bring the edit button to the front */
            cursor: pointer; /* Ensure it shows as clickable */
        }

        .edit-link:hover {
            text-decoration: underline;
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

        .delivery-info {
            display: none;
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            position: relative;
        }

        .delivery-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .delivery-info .edit-delivery {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            position: absolute;
            right: 0;
            top: 10px;
        }

        .delivery-info .edit-delivery:hover {
            text-decoration: underline;
        }

        .delivery-info .tricycle-icon {
            margin-right: 10px;
            color: #007bff;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Ensure modal is on top */
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .modal-content button {
            margin-top: 10px;
        }

        .modal-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-option:hover {
            background-color: #f9f9f9;
        }

        .modal-option.selected {
            border-color: #007bff;
            background-color: #e9f5ff;
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

        .payment-option img {
            width: 40px;
            height: 40px;
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
    </style>
</head>
<body>
    <!-- Back Button -->
    <button class="back-button" onclick="window.location.href='address.php'" aria-label="Go back to address page">
        <i class="fas fa-arrow-left"></i>
    </button>

    <!-- Step Indicator -->
    <div class="step-indicator">Step 2/2</div>

    <!-- Main Content -->
    <div class="container">
        <h1 class="title">Schedule your order</h1>

        <div class="section">
            <h2>Pickup</h2>
            <p>We will deliver your laundry today if you order before 1 PM. If you order beyond 1 PM, you will get your laundry tomorrow.</p>
            <div class="pickup-box">
                <a href="#" class="edit-link" onclick="openModal()" aria-label="Edit pickup date">Edit</a>
                <div class="pickup-info">
                    <strong>PICKUP</strong>
                    <span id="pickupDate" class="pickup-date">
                        <i class="fas fa-bicycle"></i> Tonight, March 18
                    </span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Services & delivery</h2>
            <div class="service-box" id="washingBox">
                <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                    <div>
                        <i class="fas fa-tshirt"></i>
                        <label for="washing">Washing - ₱65.00 per load</label>
                        <select id="washingLoads" onchange="updateTotalPrice()" aria-label="Select number of loads">
                            <option value="1">1 load</option>
                            <option value="2">2 loads</option>
                            <option value="3">3 loads</option>
                            <option value="4">4 loads</option>
                            <option value="5">5 loads</option>
                        </select>
                    </div>
                    <button class="add-button" onclick="toggleService('washingBox')" aria-label="Add washing service">
                        <span class="button-text">Add</span>
                        <i class="fas fa-check check-icon"></i>
                    </button>
                </div>
                <div id="washingDelivery" class="delivery-info">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-bicycle tricycle-icon"></i>
                        <div>
                            <p style="margin: 0; font-size: 14px; color: #666;">DELIVERY</p>
                            <p style="margin: 0; font-size: 14px; color: #666;">Tonight, March 18</p>
                            <p style="margin: 0; font-size: 14px; color: #666;">Delivery Fee: ₱50.00</p>
                        </div>
                    </div>
                    <a href="#" class="edit-delivery" onclick="editDelivery()" aria-label="Edit delivery date">Edit</a>
                </div>
            </div>
            <div class="service-box" id="dryingBox">
                <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                    <div>
                        <i class="fas fa-wind"></i>
                        <label for="drying">Drying</label>
                        <select id="dryingTime" onchange="updateTotalPrice()" aria-label="Select drying time">
                            <option value="20">20 mins - ₱40.00</option>
                            <option value="30">30 mins - ₱60.00</option>
                            <option value="40">40 mins - ₱80.00</option>
                            <option value="50">50 mins - ₱100.00</option>
                        </select>
                    </div>
                    <button class="add-button" onclick="toggleService('dryingBox')" aria-label="Add drying service">
                        <span class="button-text">Add</span>
                        <i class="fas fa-check check-icon"></i>
                    </button>
                </div>
                <div id="dryingDelivery" class="delivery-info">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-bicycle tricycle-icon"></i>
                        <div>
                            <p style="margin: 0; font-size: 14px; color: #666;">DELIVERY</p>
                            <p style="margin: 0; font-size: 14px; color: #666;">Tonight, March 18</p>
                            <p style="margin: 0; font-size: 14px; color: #666;">Delivery Fee: ₱50.00</p>
                        </div>
                    </div>
                    <a href="#" class="edit-delivery" onclick="editDelivery()" aria-label="Edit delivery date">Edit</a>
                </div>
            </div>
            <!-- Total Price Display -->
            <div class="total-price">
                Total: ₱<span id="totalPrice">0.00</span>
            </div>
        </div>

        <div class="section">
            <h2>Payment method</h2>
            <p style="font-size: 14px; color: #666; margin-bottom: 20px;">
                To confirm your pickup, please choose your preferred payment method. You'll be charged after the delivery.
            </p>
            <div class="payment-options">
                <div class="payment-option selected" onclick="selectPayment('Gcash')">
                    <img class="logo1" src="images/GCash_Logo.png" alt="Gcash Logo">
                    <label>Gcash</label>
                    <input type="radio" name="payment" id="gcash" checked style="display: none;">
                </div>
                <div class="payment-option" onclick="selectPayment('PayMaya')">
                    <img class="logo1" src="images/Maya.png" alt="PayMaya Logo">
                    <label>PayMaya</label>
                    <input type="radio" name="payment" id="paymaya" style="display: none;">
                </div>
                <div class="payment-option" onclick="selectPayment('Cash')">
                    <i class="fas fa-money-bill-wave" style="font-size: 24px; color: #28a745;"></i>
                    <label>Cash</label>
                    <input type="radio" name="payment" id="cash" style="display: none;">
                </div>
            </div>
            <div class="error-message" id="paymentError">Please select a payment method.</div>
        </div>

        <div class="section">
            <button class="button" id="scheduleButton" onclick="scheduleOrder()" aria-label="Schedule my order">Schedule my order</button>
        </div>
    </div>

    <!-- Pickup Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <p>Order Pickup</p>
            <div class="modal-option" onclick="selectOption('Today')">
                <span>Today</span>
                <i class="fas fa-check" style="display: none;"></i>
            </div>
            <div class="modal-option" onclick="selectOption('Tomorrow')">
                <span>Tomorrow</span>
                <i class="fas fa-check" style="display: none;"></i>
            </div>
            <button class="button" onclick="closeModal()" aria-label="Close modal">Close</button>
        </div>
    </div>

    <!-- Delivery Modal -->
    <div id="deliveryModal" class="modal">
        <div class="modal-content">
            <p>Order Delivery</p>
            <div class="modal-option" onclick="selectDeliveryOption('Today')">
                <span>Today</span>
                <i class="fas fa-check" style="display: none;"></i>
            </div>
            <div class="modal-option" onclick="selectDeliveryOption('Tomorrow')">
                <span>Tomorrow</span>
                <i class="fas fa-check" style="display: none;"></i>
            </div>
            <button class="button" onclick="closeDeliveryModal()" aria-label="Close modal">Close</button>
        </div>
    </div>

    <script>
        // Prices
        const washingPrice = 65.00; // Price per load
        const dryingPrices = {
            20: 40.00,
            30: 60.00,
            40: 80.00,
            50: 100.00
        };
        const deliveryFee = 50.00; // Delivery fee in the Philippines

        // Track added services
        let isWashingAdded = false;
        let isDryingAdded = false;
        let selectedDryingTime = 20; // Default drying time
        let selectedPaymentMethod = 'Gcash'; // Default payment method
        let washingLoads = 1; // Default number of washing loads

        // Set default payment method on page load
        document.addEventListener('DOMContentLoaded', function () {
            selectPayment('Gcash');
            updateTotalPrice(); // Initialize total price
        });

        function openModal() {
            console.log('Edit button clicked'); // Debugging
            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function selectOption(option) {
            const pickupDate = document.getElementById('pickupDate');
            if (option === 'Today') {
                pickupDate.innerHTML = '<i class="fas fa-bicycle"></i> Tonight, March 18';
            } else if (option === 'Tomorrow') {
                pickupDate.innerHTML = '<i class="fas fa-bicycle"></i> Tomorrow, March 19';
            }
            closeModal();
        }

        function openDeliveryModal() {
            document.getElementById('deliveryModal').style.display = 'flex';
        }

        function closeDeliveryModal() {
            document.getElementById('deliveryModal').style.display = 'none';
        }

        function selectDeliveryOption(option) {
            const deliveryDateElements = document.querySelectorAll('.delivery-info p:nth-child(2)');
            if (option === 'Today') {
                deliveryDateElements.forEach(element => {
                    element.textContent = 'Tonight, March 18';
                });
            } else if (option === 'Tomorrow') {
                deliveryDateElements.forEach(element => {
                    element.textContent = 'Tomorrow, March 19';
                });
            }
            closeDeliveryModal();
        }

        function toggleService(boxId) {
            const box = document.getElementById(boxId);
            const button = box.querySelector('.add-button');
            const buttonText = button.querySelector('.button-text');
            const deliveryInfo = box.querySelector('.delivery-info');

            if (!button.classList.contains('added')) {
                button.classList.add('added');
                buttonText.textContent = 'Added';
                deliveryInfo.style.display = 'block';
                box.classList.add('added');
                if (boxId === 'washingBox') isWashingAdded = true;
                if (boxId === 'dryingBox') isDryingAdded = true;
            } else {
                button.classList.remove('added');
                buttonText.textContent = 'Add';
                deliveryInfo.style.display = 'none';
                box.classList.remove('added');
                if (boxId === 'washingBox') isWashingAdded = false;
                if (boxId === 'dryingBox') isDryingAdded = false;
            }
            updateTotalPrice();
        }

        function updateTotalPrice() {
            selectedDryingTime = document.getElementById('dryingTime').value;
            washingLoads = document.getElementById('washingLoads').value; // Get number of washing loads
            let total = 0;

            if (isWashingAdded) total += washingPrice * washingLoads; // Multiply by number of loads
            if (isDryingAdded) total += dryingPrices[selectedDryingTime];
            if (isWashingAdded || isDryingAdded) total += deliveryFee; // Add delivery fee only if a service is added

            document.getElementById('totalPrice').textContent = total.toFixed(2);
        }

        function editDelivery() {
            openDeliveryModal();
        }

        function selectPayment(method) {
            const paymentOptions = document.querySelectorAll('.payment-option');
            paymentOptions.forEach(option => option.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            selectedPaymentMethod = method;
            document.getElementById('paymentError').style.display = 'none';
        }

        function scheduleOrder() {
            if (!selectedPaymentMethod) {
                document.getElementById('paymentError').style.display = 'block';
                return;
            }
            window.location.href = 'home.php'; // Redirect to home.php
        }

        // Initialize total price on page load
        updateTotalPrice();
    </script>
</body>
</html>