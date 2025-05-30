<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$password = 'root';
$db = 'testdb';
$port = 8889;

$conn = new mysqli($host, $user, $password, $db, $port);

$id = $_GET['id'] ?? '';

/* VULNERABLE VERSION: allows SQL injection and stacked queries
 * This version accepts user input directly into the SQL string and uses multi_query()
 */
 /*if (!empty($id)) {
     $query = "SELECT * FROM users WHERE id = '$id';";
    
     // Multi-query allows execution of stacked SQL statements
     if ($conn->multi_query($query)) {
         do {
             if ($result = $conn->store_result()) {
                 while ($row = $result->fetch_row()) {
                     echo "<p>Result: " . htmlspecialchars($row[0]) . " | " . htmlspecialchars($row[1]) . " | " . htmlspecialchars($row[2]) . "</p>";
                 }
                 $result->free();
             }
         } while ($conn->next_result());
     }
 }*/


/*
 * SECURE VERSION: blocks stacked queries and uses prepared statements
 */
if (ctype_digit($id)) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_row()) {
            echo "<p>Result: " . htmlspecialchars($row[0]) . " | " . 
                              htmlspecialchars($row[1]) . " | " . 
                              htmlspecialchars($row[2]) . "</p>";
        }
    } else {
        echo "<p>No results.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid input</p>";
}

$conn->close();
?>
