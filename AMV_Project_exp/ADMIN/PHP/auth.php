<?php
session_start();

// This is a placeholder for OTP authentication logic if needed.
// You can implement OTP verification here if required.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMV - Admin Authentication</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../STYLE/auth-styles.css">
</head>
<body>
    <div class="container">
        <div class="border-top"></div>
        <div class="border-bottom"></div>
        <header class="header">
            <div class="logo">
                <div class="logo-icon">
                    <!-- SVG logo here -->
                </div>
                <span class="brand-text">AMV</span>
            </div>
        </header>
        <main class="main-content">
            <div class="auth-form">
                <h1 class="form-title">Admin Authentication</h1>
                <form id="authForm" class="form">
                    <div class="form-group">
                        <label for="otp" class="form-label">OTP</label>
                        <div class="otp-inputs">
                            <input type="text" class="otp-input" maxlength="1" data-index="0" required>
                            <input type="text" class="otp-input" maxlength="1" data-index="1" required>
                            <input type="text" class="otp-input" maxlength="1" data-index="2" required>
                            <input type="text" class="otp-input" maxlength="1" data-index="3" required>
                            <input type="text" class="otp-input" maxlength="1" data-index="4" required>
                            <input type="text" class="otp-input" maxlength="1" data-index="5" required>
                        </div>
                        <p class="instruction-text">Enter the 6-digit authentication code sent via email.</p>
                    </div>
                    <button type="submit" class="auth-button">Login</button>
                </form>
            </div>
        </main>
    </div>
    <script src="../SCRIPT/auth-script.js"></script>
</body>
</html>
