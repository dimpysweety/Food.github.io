<?php
// Database connection settings
$servername = "localhost";  // Change if your DB is hosted elsewhere
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "no_hunger";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Validate input
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully! We will get back to you soon.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    
    // Optional: Send an email notification (Modify as needed)
    $admin_email = "admin@example.com";  // Change this to your admin email
    $headers = "From: $email";
    mail($admin_email, "New Contact Form Message", $message, $headers);
}

$conn->close();
?>
