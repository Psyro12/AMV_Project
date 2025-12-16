<?php
// Database connection parameters
$host = 'localhost';
$db = 'amenity_db';
$user = 'root'; // Change this if your database username is different
$pass = '';     // Change this if your database password is set
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Create a new PDO instance for the connection
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In a real application, you would log this error and show a generic message
    error_log("Database connection failed: " . $e->getMessage());
    // For this exercise, we will just exit to prevent further errors
    die("Could not connect to the database: " . $e->getMessage());
}

/**
 * Fetches all amenities from the 'amenities' table.
 * * @param PDO $pdo The established PDO database connection object.
 * @return array|bool An array of amenities or false on failure.
 */
function get_all_amenities(PDO $pdo)
{
    try {
        $stmt = $pdo->query('SELECT icon_class, title, description FROM amenities ORDER BY id ASC');
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        // Log the query error
        error_log("Amenity fetching query failed: " . $e->getMessage());
        return false; // Return false to indicate failure
    }
}