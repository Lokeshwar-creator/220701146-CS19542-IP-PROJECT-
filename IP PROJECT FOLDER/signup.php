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
    // Get the form data
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirm-password'];

    // Validate input (basic validation)
    if (!empty($user) && !empty($email) && !empty($pass) && !empty($confirmPass)) {
        if ($pass === $confirmPass) {
            // Hash the password for security
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            // Prepare an SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO signup (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user, $email, $hashedPass);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('User registered successfully!'); window.location.href = 'lgin.html';</script>";
            } else {
                // Check for specific errors like duplicate entry
                if ($conn->errno == 1062) {
                    echo "<script>alert('Username or Email already exists!'); window.location.href = 'signup.html';</script>";
                } else {
                    echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'signup.html';</script>";
                }
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Passwords do not match.'); window.location.href = 'signup.html';</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.'); window.location.href = 'signup.html';</script>";
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
    <title>InfoNews - Sign Up</title>

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
            background: url("https://static.vecteezy.com/system/resources/previews/011/640/184/original/bokeh-light-design-on-blue-background-free-vector.jpg") no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 24px;
            color: #333;
            font-size: 2rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            outline: none;
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
        }

        .signin {
            margin-top: 16px;
            font-size: 0.9rem;
        }

        .signin a {
            color: #208c5b;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Create Account</h1>

        <form action="signup.php" method="post">
            <input type="text" id="new-username" name="username" placeholder="Username" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="new-password" name="password" placeholder="Password" required>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
            <button type="submit">Sign Up</button>
        </form>

        <div class="signin">
            <p>Already have an account? <a href="signup.html">Sign In</a></p>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById("signup-form").addEventListener("submit", function (event) {
            event.preventDefault();
            const username = document.getElementById("new-username").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("new-password").value;
            const confirmPassword = document.getElementById("confirm-password").value;

            if (username === "" || email === "" || password === "" || confirmPassword === "") {
                alert("Please fill in all fields.");
                return;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters.");
                return;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return;
            }

            alert("Sign up successful!");
            window.location.href = "signup.html";
        });
    </script>
</body>
</html>
