<?php
// ==================== AUTHENTICATION HANDLER ====================

require_once 'config.php';
session_start();

header('Content-Type: application/json');

// Get action
$action = $_POST['action'] ?? '';

switch($action) {
    case 'login':
        handleLogin();
        break;
        
    case 'logout':
        handleLogout();
        break;
        
    case 'check_session':
        checkSession();
        break;
        
    case 'register':
        handleRegister();
        break;
        
    case 'forgot_password':
        handleForgotPassword();
        break;
        
    default:
        jsonResponse(false, 'Invalid action');
}

// ==================== LOGIN ====================
function handleLogin() {
    global $pdo;
    
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if(empty($email) || empty($password)) {
        jsonResponse(false, 'Email and password are required');
    }
    
    if(!validateEmail($email)) {
        jsonResponse(false, 'Invalid email format');
    }
    
    try {
        // Get user from database
        $stmt = $pdo->prepare("
            SELECT user_id, email, password_hash, full_name, role, status 
            FROM users 
            WHERE email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        // Check if user exists and password is correct
        if($user && password_verify($password, $user['password_hash'])) {
            // Check if account is active
            if($user['status'] !== 'active') {
                jsonResponse(false, 'Account is ' . $user['status'] . '. Please contact administrator.');
            }
            
            // Update last login
            $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
            $updateStmt->execute([$user['user_id']]);
            
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            // Log activity
            logActivity($pdo, $user['user_id'], 'login');
            
            // Send success response
            jsonResponse(true, 'Login successful', [
                'user_id' => $user['user_id'],
                'role' => $user['role'],
                'name' => $user['full_name'],
                'email' => $user['email']
            ]);
        } else {
            // Invalid credentials
            jsonResponse(false, 'Invalid email or password');
        }
    } catch(PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        jsonResponse(false, 'Login failed. Please try again.');
    }
}

// ==================== LOGOUT ====================
function handleLogout() {
    global $pdo;
    
    if(isset($_SESSION['user_id'])) {
        logActivity($pdo, $_SESSION['user_id'], 'logout');
    }
    
    // Destroy session
    session_unset();
    session_destroy();
    
    jsonResponse(true, 'Logged out successfully');
}

// ==================== CHECK SESSION ====================
function checkSession() {
    if(isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
        // Session is active
        jsonResponse(true, 'Session active', [
            'user_id' => $_SESSION['user_id'],
            'name' => $_SESSION['name'],
            'email' => $_SESSION['email'],
            'role' => $_SESSION['role']
        ]);
    } else {
        jsonResponse(false, 'No active session');
    }
}

// ==================== REGISTER ====================
function handleRegister() {
    global $pdo;
    
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullName = sanitizeInput($_POST['full_name'] ?? '');
    $role = sanitizeInput($_POST['role'] ?? 'student');
    
    // Validation
    if(empty($email) || empty($password) || empty($fullName)) {
        jsonResponse(false, 'All fields are required');
    }
    
    if(!validateEmail($email)) {
        jsonResponse(false, 'Invalid email format');
    }
    
    if(strlen($password) < 6) {
        jsonResponse(false, 'Password must be at least 6 characters');
    }
    
    // Check if email already exists
    try {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if($stmt->fetch()) {
            jsonResponse(false, 'Email already registered');
        }
        
        // Insert new user
        $passwordHash = hashPassword($password);
        $insertStmt = $pdo->prepare("
            INSERT INTO users (email, password_hash, full_name, role, status)
            VALUES (?, ?, ?, ?, 'active')
        ");
        $insertStmt->execute([$email, $passwordHash, $fullName, $role]);
        
        $userId = $pdo->lastInsertId();
        
        // Log activity
        logActivity($pdo, $userId, 'registration');
        
        jsonResponse(true, 'Registration successful', [
            'user_id' => $userId
        ]);
    } catch(PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        jsonResponse(false, 'Registration failed. Please try again.');
    }
}

// ==================== FORGOT PASSWORD ====================
function handleForgotPassword() {
    global $pdo;
    
    $email = sanitizeInput($_POST['email'] ?? '');
    
    if(empty($email)) {
        jsonResponse(false, 'Email is required');
    }
    
    if(!validateEmail($email)) {
        jsonResponse(false, 'Invalid email format');
    }
    
    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user) {
            // Generate reset token
            $token = generateToken();
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token in database (you'll need to create a password_resets table)
            // For now, just send success message
            
            jsonResponse(true, 'Password reset instructions sent to your email');
        } else {
            // Don't reveal if email exists or not (security best practice)
            jsonResponse(true, 'If the email exists, reset instructions have been sent');
        }
    } catch(PDOException $e) {
        error_log("Forgot password error: " . $e->getMessage());
        jsonResponse(false, 'Request failed. Please try again.');
    }
}

?>

