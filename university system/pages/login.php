<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduPlatform</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="logo">🎓 EduPlatform</div>
            <h2>Login to Your Account</h2>
            
            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email" autocomplete="email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" autocomplete="current-password">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <p class="login-footer" style="text-align: center; margin-top: 1.5rem;">
                Don't have an account? <a href="register.php" style="color: var(--primary-color); font-weight: 600;">Register here</a>
            </p>

            <p class="login-footer" style="text-align: center;">
                <a href="index.php">← Back to Home</a>
            </p>

            <!-- Demo Credentials Info -->
            <div style="margin-top: 2rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; border-left: 4px solid #667eea;">
                <h4 style="margin-bottom: 0.5rem; color: #1e293b;">Demo Credentials</h4>
                <p style="font-size: 0.875rem; color: #64748b; margin: 0.25rem 0;">
                    <strong>Student:</strong> student@edu.com<br>
                    <strong>Instructor:</strong> instructor@edu.com<br>
                    <strong>Coordinator:</strong> coordinator@edu.com<br>
                    <strong>Admin:</strong> admin@edu.com<br>
                    <strong>Password:</strong> 123456
                </p>
            </div>
        </div>
    </div>

    <script src="../assets/js/app.js"></script>
</body>
</html>


