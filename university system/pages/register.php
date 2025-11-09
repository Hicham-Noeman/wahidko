<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EduPlatform</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="login-page">
    <div class="login-container" style="max-width: 500px;">
        <div class="login-card">
            <div class="logo">🎓 EduPlatform</div>
            <h2>Create Your Account</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 2rem;">Join thousands of students learning online</p>
            
            <form id="registerForm" class="login-form">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" required placeholder="Enter your full name" autocomplete="name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email" autocomplete="email">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" autocomplete="tel">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a password (min 6 characters)" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="role">I want to register as:</label>
                    <select id="role" name="role" class="form-control">
                        <option value="student">Student</option>
                        <option value="instructor">Instructor</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" id="terms" required style="width: auto;">
                        <span style="font-size: 0.875rem;">I agree to the <a href="#" style="color: var(--primary-color);">Terms & Conditions</a></span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Create Account</button>
            </form>
            
            <p class="login-footer" style="text-align: center; margin-top: 1.5rem;">
                Already have an account? <a href="login.php" style="color: var(--primary-color); font-weight: 600;">Login here</a>
            </p>

            <p class="login-footer" style="text-align: center;">
                <a href="index.php">← Back to Home</a>
            </p>
        </div>
    </div>

    <script src="../assets/js/app.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const role = document.getElementById('role').value;
            const terms = document.getElementById('terms').checked;

            // Validation
            if(!fullName || !email || !password) {
                showNotification('Please fill in all required fields', 'error');
                return;
            }

            if(password.length < 6) {
                showNotification('Password must be at least 6 characters', 'error');
                return;
            }

            if(password !== confirmPassword) {
                showNotification('Passwords do not match', 'error');
                return;
            }

            if(!terms) {
                showNotification('Please accept the terms and conditions', 'error');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailRegex.test(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('action', 'register');
                formData.append('full_name', fullName);
                formData.append('email', email);
                formData.append('phone', phone);
                formData.append('password', password);
                formData.append('role', role);

                const response = await fetch('../php/auth.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if(result.success) {
                    showNotification('Registration successful! Redirecting to login...', 'success');
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                } else {
                    showNotification(result.message || 'Registration failed. Please try again.', 'error');
                }
            } catch(error) {
                console.error('Registration error:', error);
                showNotification('An error occurred. Please try again later.', 'error');
            }
        });

        // Real-time password validation
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if(confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</body>
</html>


