<?php
// Include your database connection
require '../config/db.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Success!</h1>";
    echo "<p>The 'users' table is ready to go.</p>";
} else {
    echo "<h1>Error</h1>";
    echo "<p>Could not create table: " . $conn->error . "</p>";
}

$conn->close();
?>