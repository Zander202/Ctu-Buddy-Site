<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "chat_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST and handle the message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $message = $_POST['message'];

    if (!empty($username) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $message);
        $stmt->execute();
        $stmt->close();
        echo "Message sent successfully!";
    } else {
        echo "Please provide a username and message!";
    }
}

$conn->close();
?>
