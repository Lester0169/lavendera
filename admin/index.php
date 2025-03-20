<?php
session_start();

// If already logged in, redirect to the dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Continue with the login form display...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Landing Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Averia Serif Libre", serif;
            background-color: #1E90FF; /* Background color for the page */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            width: 85%;
            margin: auto;
        }
        .header {
            background-color: #ffffff;
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
        }
        .logo1 {
            height: 60px;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-top: 120px; /* Adjusted for fixed header */
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 28px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 18px;
        }
        .login-container input[type="submit"] {
            background: linear-gradient(to right, #F984F4, #1678F3); /* Updated button color */
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 20px;
            margin-top: 20px;
        }
        .login-container input[type="submit"]:hover {
            background: linear-gradient(to right, #F984F4, #1678F3); /* Keep the gradient on hover */
            opacity: 0.9;
        }
        .header .laundry_logo {
            width: 15%;
            height: auto;
            position: relative;
            left: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <img class="laundry_logo" src="logo1.png" alt="Laundry Provider Logo">
        </div>
    </header>

    <div class="login-container">
        <h1>Admin Login</h1>
        <form method="POST" action="login.php">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>

