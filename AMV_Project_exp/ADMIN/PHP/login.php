<?php
session_start();
require 'db_connect.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $sql = "SELECT * FROM admin_user WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'ID' => $user['ID'],
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password']
            ];
            header('Location: auth.php');
            exit();
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'User not found.';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMV - Admin Login Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../STYLE/styles.css">
</head>
<body>
    <div class="container">
        
        <header class="header">
            <div class="logo">
                <div class="logo-icon">
                    <img src="../../IMG/4.png" alt="AMV Logo" style="height: 64px; width: auto; display: block; margin: 0 auto;">
                </div>
                <span class="brand-text">AMV</span>
            </div>
        </header>
        <main class="main-content">
            <div class="login-form">
                <h1 class="form-title">Admin Login Access</h1>
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" class="form">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>
                    <button type="submit" class="login-button">Login</button>
                </form>
            </div>
        </main>
    </div>
</body>
<script src="../script.js"></script>
</html>
