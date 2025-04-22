<?php
// Connect to the database using MAMP credentials
$host = 'localhost';
$user = 'root';
$password = 'root';
$db = 'testdb';
$port = 8889; // MAMP uses port 8889 for MySQL

$conn = new mysqli($host, $user, $password, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$id = $_GET['id'] ?? '';

// ❌ Vulnerable to SQL injection
$query = "SELECT * FROM users WHERE id = '$id'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
        echo "<p>Result: " . htmlspecialchars($row[0]) . " | " . htmlspecialchars($row[1]) . " | " . htmlspecialchars($row[2]) . "</p>";
    }
    
} else {
    echo "<p>No results.</p>";
}

$conn->close();
?>
