<?php
// Database connection settings
$servername = "localhost";  // Change this if your DB is hosted elsewhere
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
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $availability = trim($_POST["availability"]);
    $message = trim($_POST["message"]);

    // Validate input
    if (empty($fullname) || empty($email) || empty($phone) || empty($availability)) {
        echo "All fields except 'Message' are required.";
        exit;
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO volunteers (fullname, email, phone, availability, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $email, $phone, $availability, $message);

    if ($stmt->execute()) {
        echo "Thank you for volunteering! We will contact you soon.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
