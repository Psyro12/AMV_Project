<?php
// Database connection for room_details
$host = 'localhost';
$user = 'root'; // Change if your MySQL user is different
$pass = '';
$db = 'room_details';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
