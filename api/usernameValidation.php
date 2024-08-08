<?php
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *');
// Allow specific headers and methods
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');

// Database configuration
$host = 'localhost'; // Database host
$dbname = 'task_manager'; // Database name
$user = 'root'; // Database username
$pass = 'Alimardani33'; // Database password

// Create a MySQLi connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username'])) {
    $username = $data['username'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Check if the username exists
    if ($count > 0) {
        // Username exists
        echo json_encode(['valid' => false]);
    } else {
        // Username does not exist
        echo json_encode(['valid' => true]);
    }
} else {
    echo json_encode(['error' => 'Username not provided']);
}

// Close the database connection
$conn->close();
