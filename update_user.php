<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = 'localhost';
$user = 'root';
$password = 'root';
$db = 'testdb';
$port = 8889;

$conn = new mysqli($host, $user, $password, $db, $port);

// store injection here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'] ?? '';
    $id = $_POST['id'] ?? '';

    /*// vulnerable update
    $query = "UPDATE users SET username = '$name' WHERE id = '$id'";
    echo "<p>Query being run: $query</p>";

    $conn->query($query);

    $result = $conn->query("SELECT username FROM users WHERE id = '$id'");
    $row = $result->fetch_row();
    
    echo "<p>Username now: " . htmlspecialchars($row[0]) . "</p>";*/

    // Input validation
    if (!ctype_digit($id)) {
        echo "<p>Invalid ID: must be numeric.</p>";
        exit;
    }
    if (strlen($name) > 100) {
        echo "<p>Invalid username: too long.</p>";
        exit;
    }*/

    // Secure version
    if (!is_numeric($id)) {
        echo "<p>Invalid ID input</p>";
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    echo "<p>Updated.</p>";*/
}

?>
<form method="POST">
    <input name="id" placeholder="User ID" />
    <input name="username" placeholder="New Username" />
    <button type="submit">Update</button>
</form>
