<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Pickup Location</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
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
            transition: color 0.3s ease;
        }
        .back-button:hover {
            color: #007bff;
        }
        .back-button:active {
            color: #0056b3;
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
            text-align: right;
            margin-top: 40px;
            margin-bottom: 40px;
            padding-right: 20px;
            padding-left: 40px;
            position: relative;
            bottom: 37px;
        }
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }
        .form-label {
            position: absolute;
            left: 16px;
            top: 4px;
            font-size: 14px;
            color: #0056b3;
            font-weight: 500;
            background-color: #fff;
            padding: 0 5px;
            transition: top 0.3s ease, font-size 0.3s ease, color 0.3s ease;
        }
        .form-control {
            width: 100%;
            padding: 25px 15px 15px;
            font-size: 16px;
            border: 2px solid #0056b3;
            border-radius: 15px;
            box-sizing: border-box;
            background-color: #fff;
            color: #333;
        }
        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -10px;
            font-size: 12px;
            color: #007bff;
        }
        .form-control::placeholder {
            color: #aaa;
        }
        .clear-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            display: none;
        }
        .clear-icon:hover {
            color: #333;
        }
        .instructions {
            margin-top: 20px;
        }
        .instructions textarea {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            font-family: Arial, sans-serif;
            border: 2px solid #0056b3;
            border-radius: 15px;
            box-sizing: border-box;
            background-color: #fff;
            color: #333;
            resize: vertical;
        }
        .instructions textarea::placeholder {
            color: #aaa;
            font-family: Arial, sans-serif;
        }
        .button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #e8ecf0;
            color: #999;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            text-align: center;
            margin-top: 40px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .button:hover {
            background-color: #dde2e8;
        }
        .button.loading {
            background-color: #007bff;
            color: #fff;
            cursor: not-allowed;
        }
        .button.loading::after {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <button class="back-button">
        <i class="fas fa-arrow-left"></i>
    </button>

    <!-- Step Indicator -->
    <div class="step-indicator">Step 1/2</div>
    
    <div class="container">
        <h1 class="title">Where should we pick up your clothes?</h1>
        
        <form>
            <div class="form-group">
                <input type="text" id="address" class="form-control" placeholder="Enter your address">
                <label for="address" class="form-label">Address</label>
                <i class="fas fa-times clear-icon" id="clearAddress"></i>
            </div>

            <!-- Pickup and delivery instructions -->
            <div class="instructions">
                <textarea id="instructions" placeholder="Pickup and delivery instructions"></textarea>
            </div>
            
            <button type="button" class="button" id="continueButton">Continue</button>
        </form>
    </div>

    <script>
        document.querySelector('.back-button').addEventListener('click', function() {
            history.back();
        });
        
        const addressInput = document.getElementById('address');
        const clearIcon = document.getElementById('clearAddress');
        const continueButton = document.getElementById('continueButton');
        const instructionsTextarea = document.getElementById('instructions');

        // Show/hide clear icon based on input
        addressInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                clearIcon.style.display = 'block';
                continueButton.style.backgroundColor = '#007bff';
                continueButton.style.color = '#fff';
            } else {
                clearIcon.style.display = 'none';
                continueButton.style.backgroundColor = '#e8ecf0';
                continueButton.style.color = '#999';
            }
        });

        // Clear address input when clear icon is clicked
        clearIcon.addEventListener('click', function() {
            addressInput.value = '';
            clearIcon.style.display = 'none';
            continueButton.style.backgroundColor = '#e8ecf0';
            continueButton.style.color = '#999';
        });

        // Enable continue button when address or instructions are entered
        addressInput.addEventListener('input', toggleContinueButton);
        instructionsTextarea.addEventListener('input', toggleContinueButton);

        function toggleContinueButton() {
            if (addressInput.value.trim() !== '' || instructionsTextarea.value.trim() !== '') {
                continueButton.style.backgroundColor = '#007bff';
                continueButton.style.color = '#fff';
            } else {
                continueButton.style.backgroundColor = '#e8ecf0';
                continueButton.style.color = '#999';
            }
        }

        // Redirect to schedule.php when Continue button is clicked
        continueButton.addEventListener('click', function() {
            continueButton.classList.add('loading');
            setTimeout(() => {
                window.location.href = 'schedule.php';
            }, 2000); // Simulate loading delay
        });
    </script>
</body>
</html>