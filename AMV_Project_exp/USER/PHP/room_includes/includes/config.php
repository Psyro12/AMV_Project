<?php
// Database configuration for XAMPP
define('DB_HOST', 'localhost');
define('DB_NAME', 'image_storage');
define('DB_USER', 'root');      // XAMPP default username
define('DB_PASS', '');          // XAMPP default password (empty)

// File upload configuration - USING ABSOLUTE PATHS FOR WINDOWS
define('UPLOAD_BASE_PATH', 'C:/xampp/htdocs/image-storage/uploads/');
define('IMAGE_UPLOAD_PATH', UPLOAD_BASE_PATH . 'images/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// URL configuration for local development
define('BASE_URL', 'http://localhost/image-storage');
define('UPLOAD_URL', BASE_URL . '/uploads/images/');

// Allowed image types
define('ALLOWED_IMAGE_TYPES', [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp'
]);

// Create upload directories if they don't exist
if (!is_dir(IMAGE_UPLOAD_PATH)) {
    mkdir(IMAGE_UPLOAD_PATH, 0755, true);
}

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>