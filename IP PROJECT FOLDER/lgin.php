<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost"; // Database server (usually localhost)
$username = "root";        // MySQL username (default is 'root')
$password = "";            // MySQL password (default is empty for localhost)
$dbname = "ip";            // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validate input (basic validation)
    if (!empty($user) && !empty($pass)) {
        // Hash the password for security
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $hashedPass);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the login page on success
            echo "<script>alert('User registered successfully!'); window.location.href = 'lgin.html';</script>";
        } else {
            // Check for specific errors like duplicate entry
            if ($conn->errno == 1062) {
                echo "<script>alert('Username already exists!'); window.location.href = 'lgin.html';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'lgin.html';</script>";
            }
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Both fields are required!'); window.location.href = 'lgin.html';</script>";
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoNews - Login</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Roboto:wght@500&display=swap">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Internal CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://elements-video-cover-images-0.imgix.net/files/220512242/Preview.jpg?auto=compress%2Cformat&h=450&w=800&fit=min&s=08d73e46fae5e0cb394d00495caedf9f') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        nav {
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            z-index: 1;
        }

        .nav-container {
            display: flex;
            gap: 20px;
        }

        .nav-link {
            color: grey;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            text-shadow: 0px 1px 5px rgba(0, 0, 0, 0.5);
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #208c5b;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        }

        h1 {
            margin-bottom: 24px;
            color: #333;
            font-size: 2rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 1rem;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #208c5b;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #208c5b;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #186846;
        }

        .forgot-password,
        .signup {
            margin-top: 16px;
            font-size: 0.9rem;
        }

        .forgot-password a,
        .signup a {
            color: #208c5b;
            text-decoration: none;
        }

        .forgot-password a:hover,
        .signup a:hover {
            text-decoration: underline;
        }

        .datetime-widget {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            font-size: xx-large;
            text-align: center;
            color: gray;
            font-size: 0.8rem;
        }

        footer a {
            color:gray;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .nav-link {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Links -->
    <nav>
        <div class="nav-container">
            <a href="home.html" class="nav-link"><i class="fas fa-home"></i> Home</a>
            <a href="about.html" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
            <a href="contact.html" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
            <a href="support.html" class="nav-link"><i class="fas fa-headset"></i> Support</a>
        </div>
    </nav>

    <!-- Date and Time Widget -->
    <div class="datetime-widget">
        <div id="date"></div>
        <div id="time"></div>
    </div>

    <div class="container">
        <h1>Login to InfoNews</h1>

        <form action="lgin.php" method="POST">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="forgot-password">
            <a href="#">Forgot Password?</a>
        </div>

        <div class="signup">
            <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
        </div>
    </div>

    <!-- JavaScript for login action and Date/Time widget -->
    <script>
        function login(event) {
            event.preventDefault(); // Prevent form submission
            
            // Get the input values
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            // Validate username (e.g., not empty, could also add email/username pattern check)
            if (username === "") {
                alert("Please enter your username.");
                return; // Stop further execution
            }

            // Validate password (e.g., not empty, at least 6 characters)
            if (password === "") {
                alert("Please enter your password.");
                return;
            } else if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return;
            }

            // If validation passes, simulate authentication and redirect
            alert("Login successful! Redirecting...");
            window.location.href = 'base1.html'; // Redirect to InfoNews main page after login
        }

        // Date and Time Widget
        function updateDateTime() {
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            const now = new Date();

            document.getElementById('date').textContent = now.toLocaleDateString('en-GB', optionsDate);
            document.getElementById('time').textContent = now.toLocaleTimeString('en-GB', optionsTime);
        }

        setInterval(updateDateTime, 1000); // Update time every second
        updateDateTime(); // Initial call
    </script>

    <!-- Footer -->
    <footer>
        &copy; 2024 InfoNews. All rights reserved. | <a href="privacy.html">Privacy Policy</a>
    </footer>

</body>
</html>
