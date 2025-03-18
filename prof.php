<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rinse - My Account</title>
  <!-- Add Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Add Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      display: flex;
      min-height: 100vh;
      background-color: #f4f4f4;
      font-family: 'Open Sans', sans-serif; /* Body font */
      line-height: 1.5; /* Consistent line height */
    }
    
    /* Typography Hierarchy */
    h1 {
      font-family: 'Poppins', sans-serif; /* Header font */
      font-size: 32px; /* H1 size */
      font-weight: 700; /* Bold */
      line-height: 1.3; /* Slightly tighter for headers */
    }
    
    h2 {
      font-family: 'Poppins', sans-serif; /* Header font */
      font-size: 28px; /* H2 size */
      font-weight: 600; /* Semi-bold */
      line-height: 1.3;
    }
    
    h3 {
      font-family: 'Poppins', sans-serif; /* Header font */
      font-size: 24px; /* H3 size */
      font-weight: 600; /* Semi-bold */
      line-height: 1.4;
    }
    
    p {
      font-size: 16px; /* Body text size */
      font-weight: 400; /* Regular */
      line-height: 1.6; /* 1.5x font size for readability */
      color: #555; /* Slightly lighter for body text */
    }
    
    .sidebar {
      width: 320px;
      background: linear-gradient(135deg, #FF8C00, #FFA500); /* Gradient for depth */
      color: white;
      padding: 40px 30px;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }
    
    .sidebar img {
      width: 180px;
      margin-bottom: 32px; /* Increased margin */
    }
    
    .sidebar h1 {
      margin-bottom: 40px; /* Increased margin */
      margin-top: 0;
      color: white;
    }
    
    .sidebar-menu {
      list-style: none;
      padding-left: 0;
    }
    
    .sidebar-menu li {
      margin-bottom: 20px;
      font-size: 18px;
    }
    
    .sidebar-menu a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 12px 16px; /* Increased padding */
      border-radius: 8px; /* Consistent border-radius */
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .sidebar-menu a:hover {
      background-color: rgba(255, 255, 255, 0.1); /* Light tint for hover */
    }
    
    .sidebar-menu a:active {
      background-color: rgba(255, 255, 255, 0.2); /* Slightly darker for active state */
    }
    
    .sidebar-menu .active {
      background-color: #1678F3; /* Accent blue for active link */
      color: white;
      font-weight: bold;
    }
    
    .main-content {
      flex: 1;
      padding: 40px; /* Increased padding */
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .top-nav {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 40px; /* Increased margin */
    }
    
    .top-nav a {
      margin-left: 24px; /* Increased margin */
      text-decoration: none;
      color: #1a5e76;
      font-size: 16px;
      padding: 8px 16px; /* Consistent padding */
      border-radius: 8px; /* Consistent border-radius */
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .top-nav a:hover {
      background-color: rgba(0, 0, 0, 0.05); /* Light hover effect */
    }
    
    .top-nav a:active {
      background-color: rgba(0, 0, 0, 0.1); /* Slightly darker for active state */
    }
    
    .top-nav a:first-child {
      color: #1678F3; /* Accent blue */
    }

    .profile-sections {
      display: flex;
      flex-wrap: wrap;
      gap: 56px;
    }
    
    .profile-section {
      flex: 1;
      min-width: 300px;
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
    }
    
    .section-title {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
      font-weight: 600;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      display: block;
      margin-bottom: 8px;
      color: #444;
      font-weight: 500;
    }
    
    .form-input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
      display: flex;
      align-items: center;
      transition: border-color 0.3s ease;
    }
    
    .form-input:hover {
      border-color: #1678F3;
    }
    
    .form-input:focus-within {
      border-color: #FFA500;
      box-shadow: 0 0 0 2px rgba(255, 165, 0, 0.2);
    }
    
    .form-input.error {
      border-color: #ff4444;
    }
    
    .form-input svg {
      margin-right: 10px;
      color: #999;
      transition: color 0.3s ease;
    }
    
    .form-input:hover svg {
      color: #1678F3;
    }
    
    .form-input input {
      border: none;
      outline: none;
      width: 100%;
      font-size: 16px;
      background: transparent;
    }
    
    .row {
      display: flex;
      gap: 20px;
    }
    
    .col {
      flex: 1;
    }
    
    .clear-button {
      background: none;
      border: none;
      cursor: pointer;
      color: #999;
      padding: 4px;
      transition: color 0.3s ease;
    }
    
    .clear-button:hover {
      color: #ff4444;
    }
    
    .primary-button {
      background-color: #1678F3;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    
    .primary-button:hover {
      background-color: #125bb7;
    }
    
    .helper-text {
      font-size: 14px;
      color: #666;
      margin-top: 4px;
    }
    
    .error-text {
      font-size: 14px;
      color: #ff4444;
      margin-top: 4px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        padding: 20px;
      }
      .main-content {
        padding: 20px;
      }
      .profile-sections {
        flex-direction: column;
        gap: 20px;
      }
      .row {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar Navigation -->
  <div class="sidebar">
    <img src="images/logo1.png" alt="Rinse Logo">
    <h1>My Account</h1>
    <ul class="sidebar-menu">
      <li><a href="home.php" <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'class="active" aria-current="page"' : ''; ?>>Schedule a pickup</a></li>
      <li><a href="prof.php" <?php echo basename($_SERVER['PHP_SELF']) == 'prof.php' ? 'class="active" aria-current="page"' : ''; ?>>Profile</a></li>
      <li><a href="history.php" <?php echo basename($_SERVER['PHP_SELF']) == 'history.php' ? 'class="active" aria-current="page"' : ''; ?>>Order history</a></li>
    </ul>
  </div>

  <!-- Main Content Area -->
  <div class="main-content">
    <!-- Top Navigation -->
    <div class="top-nav">
      <a href="#">My Account</a>
      <a href="logout.php">Log out</a>
    </div>

    <!-- Profile Content -->
    <div class="profile-sections">
      <div class="profile-section">
        <h2 class="section-title">Profile</h2>
        
        <div class="form-group">
          <label class="form-label">First name</label>
          <div class="form-input">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="2"/>
              <path d="M20 21C20 18.8783 19.1571 16.8434 17.6569 15.3431C16.1566 13.8429 14.1217 13 12 13C9.87827 13 7.84344 13.8429 6.34315 15.3431C4.84285 16.8434 4 18.8783 4 21" stroke="currentColor" stroke-width="2"/>
            </svg>
            <input type="text" placeholder="Enter your first name">
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Last name</label>
          <div class="form-input">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="2"/>
              <path d="M20 21C20 18.8783 19.1571 16.8434 17.6569 15.3431C16.1566 13.8429 14.1217 13 12 13C9.87827 13 7.84344 13.8429 6.34315 15.3431C4.84285 16.8434 4 18.8783 4 21" stroke="currentColor" stroke-width="2"/>
            </svg>
            <input type="text" placeholder="Enter your last name">
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Email</label>
          <div class="form-input">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 8L10.8906 13.2604C11.5624 13.7083 12.4376 13.7083 13.1094 13.2604L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z" stroke="currentColor" stroke-width="2"/>
            </svg>
            <input type="email" placeholder="Enter your email">
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label">Phone number</label>
          <div class="form-input">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 5C3 3.89543 3.89543 3 5 3H8.27924C8.70967 3 9.09181 3.27543 9.22792 3.68377L10.7257 8.17721C10.8831 8.64932 10.6694 9.16531 10.2243 9.38787L7.96701 10.5165C9.06925 12.9612 11.0388 14.9308 13.4835 16.033L14.6121 13.7757C14.8347 13.3306 15.3507 13.1169 15.8228 13.2743L20.3162 14.7721C20.7246 14.9082 21 15.2903 21 15.7208V19C21 20.1046 20.1046 21 19 21H18C9.71573 21 3 14.2843 3 6V5Z" stroke="currentColor" stroke-width="2"/>
            </svg>
            <input type="tel" placeholder="Enter your phone number">
          </div>
          <div class="helper-text">Format: +639 8123-4567</div>
        </div>
      </div>
      
      <div class="profile-section">
        <h2 class="section-title">Address</h2>
        
        <div class="form-group">
          <label class="form-label">Street address</label>
          <div class="form-input">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2"/>
              <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2"/>
            </svg>
            <input type="text" placeholder="Enter your street address">
            <button class="clear-button">✕</button>
          </div>
        </div>
        
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label class="form-label">Province</label>
              <div class="form-input">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2"/>
                  <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2"/>
                </svg>
                <input type="text" placeholder="Enter your Province">
              </div>
            </div>
          </div>
          
          <div class="col">
            <div class="form-group">
              <label class="form-label">City</label>
              <div class="form-input">
                <input type="text" placeholder="Enter your city">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Save Button -->
    <div class="form-group">
      <button class="primary-button">Save Changes</button>
    </div>
  </div>
</body>
</html>