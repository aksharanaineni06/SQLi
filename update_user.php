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

    // vulnerable update
    $query = "UPDATE users SET username = '$name' WHERE id = '$id'";
    $conn->query($query);

    echo "<p>Updated.</p>";
}

?>
<form method="POST">
    <input name="id" placeholder="User ID" />
    <input name="username" placeholder="New Username" />
    <button type="submit">Update</button>
</form>
