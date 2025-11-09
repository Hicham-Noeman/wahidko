<?php
// ==================== DATABASE CONFIGURATION ====================

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'university_system');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application settings
define('SITE_URL', 'http://localhost/wahidko/university system');
define('UPLOAD_DIR', '../uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB

// Session configuration (must be set BEFORE session_start())
if (session_status() === PHP_SESSION_NONE) {
    // Configure session settings before starting
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS
    ini_set('session.cookie_lifetime', 0);
    
    // Start the session
    session_start();
}

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// ==================== DATABASE CONNECTION ====================
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    // Log error instead of displaying it
    error_log("Database connection failed: " . $e->getMessage());
    
    // Return generic error to client
    header('Content-Type: application/json');
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please contact administrator.'
    ]));
}

// ==================== HELPER FUNCTIONS ====================

/**
 * Send JSON response and exit
 */
function jsonResponse($success, $message, $data = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $data));
    exit;
}

/**
 * Log user activity
 */
function logActivity($pdo, $userId, $action, $entityType = null, $entityId = null) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO activity_logs (user_id, action, entity_type, entity_id, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $userId,
            $action,
            $entityType,
            $entityId,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    } catch(PDOException $e) {
        error_log("Activity log failed: " . $e->getMessage());
    }
}

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    if(is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Check if user is logged in
 */
function requireAuth() {
    if(!isset($_SESSION['user_id'])) {
        jsonResponse(false, 'Authentication required');
    }
}

/**
 * Check if user has specific role
 */
function requireRole($allowedRoles) {
    requireAuth();
    
    if(!in_array($_SESSION['role'], (array)$allowedRoles)) {
        jsonResponse(false, 'Access denied. Insufficient permissions.');
    }
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Generate random token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Create notification for user
 */
function createNotification($pdo, $userId, $title, $message, $type = 'info', $link = null) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO notifications (user_id, title, message, type, link)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $title, $message, $type, $link]);
        return true;
    } catch(PDOException $e) {
        error_log("Notification creation failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Upload file handler
 */
function handleFileUpload($file, $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'png']) {
    if($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }
    
    if($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File size exceeds limit'];
    }
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if(!in_array($extension, $allowedTypes)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    $filename = uniqid() . '_' . basename($file['name']);
    $destination = UPLOAD_DIR . $filename;
    
    if(!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    
    if(move_uploaded_file($file['tmp_name'], $destination)) {
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $destination,
            'url' => SITE_URL . '/uploads/' . $filename
        ];
    }
    
    return ['success' => false, 'message' => 'Failed to save file'];
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

/**
 * Get user by ID
 */
function getUserById($pdo, $userId) {
    try {
        $stmt = $pdo->prepare("
            SELECT user_id, email, full_name, role, phone, avatar_url, status, created_at, last_login
            FROM users
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    } catch(PDOException $e) {
        error_log("Get user failed: " . $e->getMessage());
        return null;
    }
}

// ==================== CORS HEADERS (if needed) ====================
// Uncomment if you need to enable CORS
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type, Authorization');

?>

