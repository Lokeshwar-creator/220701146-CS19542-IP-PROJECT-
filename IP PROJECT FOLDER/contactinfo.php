<?php
// Database connection details
$servername = "localhost";  // Replace with your database server IP or hostname
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "ip"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data to prevent SQL injection
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);
    
    // SQL query to insert data into the 'contactinfo' table
    $sql = "INSERT INTO contactinfo (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";
    
    // Execute query and check if data is inserted
    if ($conn->query($sql) === TRUE) {
        echo "Your message has been received. Thank you!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - INFONEWS</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: lightgrey;
        }
        h2 {
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            color: #208c5b;
        }
        .contact-info {
            margin-top: 2rem;
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <span class="navbar-brand">INFONEWS</span>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="support.html">Support</a></li>
                    <li class="nav-item"><a class="nav-link" href="signin.html">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.html">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-5 pt-5">
        <div class="contact-info">
            <h2>Contact Us</h2>
            <p>If you have any questions, feel free to reach out to us through the contact form below or via our contact information.</p>

            <!-- Contact Form -->
            <form id="contact-form" action="contactinfo.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Send Message</button>
            </form>

            <!-- Contact Information -->
            <div class="mt-4">
                <h5>Contact Information</h5>
                <p><strong>Email:</strong> <a href="mailto:lokeshjayan2004@gmail.com">lokeshjayan2004@gmail.com</a></p>
                <p><strong>Phone:</strong> 7904823291</p>
                <p><strong>Address:</strong> CHENNAI, TAMIL NADU, INDIA</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3 mt-5">
        <p>&copy; 2024 INFONEWS | <a href="#" class="text-light">Privacy Policy</a> | <a href="#" class="text-light">Terms of Service</a></p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
