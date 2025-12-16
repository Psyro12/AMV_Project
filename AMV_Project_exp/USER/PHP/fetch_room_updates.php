<?php
// Set the content type to JSON and prevent caching
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// --- Configuration ---
// Adjust these credentials to match your 'room_details' database connection
$host = 'localhost';
$user = 'root'; 
$pass = '';     
$db = 'room_details'; 

// --- Database Connection (Self-contained) ---
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4"; 
$pdo = null;

try {
     $pdo = new PDO($dsn, $user, $pass);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
     http_response_code(500);
     // Return an error object if connection fails
     echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
     exit;
}

// --- SQL Query ---
// Fetch data from the sample view. We use the GROUP BY logic to ensure we always get
// the single most recent image if the underlying table stores history, using image_name as the unique identifier.
$sql = "
    SELECT 
        t1.image_name, 
        t1.description, 
        t1.file_path, 
        t1.updated_at 
    FROM 
        room_image_details AS t1
    INNER JOIN (
        SELECT 
            image_name, 
            MAX(updated_at) AS max_updated_at
        FROM 
            room_image_details
        GROUP BY 
            image_name
    ) AS t2 
    ON t1.image_name = t2.image_name AND t1.updated_at = t2.max_updated_at;
";

try {
    $stmt = $pdo->query($sql);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the list of unique, most recent rooms as JSON
    echo json_encode($rooms);

} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Query error: ' . $e->getMessage()]);
}
?>