<?php
// config/db.php
$host = 'mysql-39200a74-renta-backend.j.aivencloud.com'; // Change this
$user = 'avnadmin'; 
$pass = 'AVNS_YH_-XDK2KcAn_XJqDIe'; // Change this
$db   = 'defaultdb';
$port = '27770'; // Usually 5 digits

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

$success = mysqli_real_connect(
    $conn, 
    $host, 
    $user, 
    $pass, 
    $db, 
    $port, 
    NULL, 
    MYSQLI_CLIENT_SSL
);

if (!$success) {
    die("Connection failed: " . mysqli_connect_error());
}
?>