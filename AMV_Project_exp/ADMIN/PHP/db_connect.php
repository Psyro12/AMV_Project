<?php
// Database connection for amv_db
$host = 'localhost';
$user = 'root'; // Change if your MySQL user is different
$pass = '';
$db = 'amv_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
