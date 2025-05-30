<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = 'localhost';
$user = 'root';
$password = 'root';
$db = 'testdb';
$port = 8889;

$conn = new mysqli($host, $user, $password, $db, $port);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    /* Vulnerable to SQL injection (intentional)
    $query = "SELECT * FROM users WHERE username = '$uname' AND password = '$pass'";
    echo "<p>Query: $query</p>"; // Debug line
    $result = $conn->query($query);
    */

    // Input validation
    if (strlen($uname) > 100 || strlen($pass) > 100) {
        echo "<p>Invalid input: too long.</p>";
        exit;
    }

    // Prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $uname, $pass);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result && $result->num_rows > 0) {
        echo "<p>Login successful</p>";
    } else {
        echo "<p>Login failed</p>";
    }
}
?>

<form method="POST">
    <input name="username" placeholder="Username" />
    <input name="password" placeholder="Password" type="password" />
    <button type="submit">Login</button>
</form>
