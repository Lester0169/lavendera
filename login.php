<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/Login Form.png') no-repeat center center;
            background-size: cover;
            filter: blur(8px); /* Adjust the blur intensity as needed */
            z-index: -1; /* Ensure the blur effect is behind the content */
        }
        .form-box {
            width: 380px;
            height: 580px;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            padding: 40px;
            position: relative;
            box-shadow: 0 0 20px 9px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            right: 293px;
            border: 2px solid #1678F3; /* Add border with color */
            border-radius: 10px; /* Optional: Add rounded corners to the border */
        }
        /* New CSS for the logo */
        .form-logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 200px; /* Adjust width as needed */
            height: auto; /* Maintain aspect ratio */
        }
        .input-field {
            width: 100%;
            padding: 8px 10px; /* Adjusted padding for better border appearance */
            margin: 5px 0;
            border: 2px solid #1678F3; /* Match the input field border color with the form box */
            border-radius: 5px; /* Optional: Adds rounded corners to the border */
            outline: none;
            background: transparent;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="form-box" style="background: rgba(255, 255, 255, 0.9);">
            <!-- New Image in the top-left corner -->
            <img src="images/logo1.png" alt="Form Logo" class="form-logo">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="signup()">Sign Up</button>
            </div>
            <form id="login-form" class="input-group" action="new.php" method="post">
                <input type="text" name="username" class="input-field" placeholder="Username" required>
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button type="submit" class="submit-btn">Log In</button>
            </form>
            <form id="signup-form" class="input-group" action="register.php" method="post">
    <input type="text" name="username" class="input-field" placeholder="Username" required>
    <input type="text" name="name" class="input-field" placeholder="Name" required>
    <input type="date" name="dateOfBirth" class="input-field" placeholder="Date of Birth" required>
    <input type="tel" name="phoneNumber" class="input-field" placeholder="Phone Number" required>
    <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
    <input type="checkbox" class="check-box"><span>I agree to terms and conditions</span>
    <button type="submit" class="submit-btn">Sign Up</button>
</form>
        </div>
    </div>

    <script>
        var x = document.getElementById("login-form");
        var y = document.getElementById("signup-form");
        var z = document.getElementById("btn");

        function login() {
            x.style.left = "50px";
            y.style.left = "450px";
            z.style.left = "0px";
        }

        function signup() {
            x.style.left = "-400px";
            y.style.left = "50px";
            z.style.left = "110px";
        }

        // Set initial state
        login(); // or signup();
    </script>
</body>
</html>