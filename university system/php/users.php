<?php
// ==================== USER MANAGEMENT ====================

require_once 'config.php';
session_start();

header('Content-Type: application/json');

// Check authentication
requireAuth();

// Get action
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch($action) {
    case 'get_all':
        getAllUsers();
        break;
        
    case 'get_by_id':
        getUserByIdHandler();
        break;
        
    case 'create':
        createUser();
        break;
        
    case 'update':
        updateUser();
        break;
        
    case 'delete':
        deleteUser();
        break;
        
    case 'update_status':
        updateUserStatus();
        break;
        
    default:
        jsonResponse(false, 'Invalid action');
}

// ==================== GET ALL USERS ====================
function getAllUsers() {
    global $pdo;
    
    // Only admin and coordinator can view all users
    requireRole(['admin', 'coordinator']);
    
    try {
        $role = $_GET['role'] ?? null;
        $status = $_GET['status'] ?? 'active';
        
        $query = "
            SELECT user_id, email, full_name, role, phone, status, created_at, last_login
            FROM users
            WHERE 1=1
        ";
        
        $params = [];
        
        if($role) {
            $query .= " AND role = ?";
            $params[] = $role;
        }
        
        if($status) {
            $query .= " AND status = ?";
            $params[] = $status;
        }
        
        $query .= " ORDER BY created_at DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $users = $stmt->fetchAll();
        
        jsonResponse(true, 'Users retrieved successfully', [
            'users' => $users,
            'count' => count($users)
        ]);
    } catch(PDOException $e) {
        error_log("Get users error: " . $e->getMessage());
        jsonResponse(false, 'Failed to retrieve users');
    }
}

// ==================== GET USER BY ID ====================
function getUserByIdHandler() {
    global $pdo;
    
    $userId = $_GET['user_id'] ?? null;
    
    if(!$userId) {
        jsonResponse(false, 'User ID is required');
    }
    
    // Users can only view their own profile unless they're admin/coordinator
    if($_SESSION['user_id'] != $userId && !in_array($_SESSION['role'], ['admin', 'coordinator'])) {
        jsonResponse(false, 'Access denied');
    }
    
    $user = getUserById($pdo, $userId);
    
    if($user) {
        jsonResponse(true, 'User retrieved successfully', ['user' => $user]);
    } else {
        jsonResponse(false, 'User not found');
    }
}

// ==================== CREATE USER ====================
function createUser() {
    global $pdo;
    
    // Only admin can create users
    requireRole('admin');
    
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullName = sanitizeInput($_POST['full_name'] ?? '');
    $role = sanitizeInput($_POST['role'] ?? 'student');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    
    // Validation
    if(empty($email) || empty($password) || empty($fullName)) {
        jsonResponse(false, 'Email, password, and full name are required');
    }
    
    if(!validateEmail($email)) {
        jsonResponse(false, 'Invalid email format');
    }
    
    if(strlen($password) < 6) {
        jsonResponse(false, 'Password must be at least 6 characters');
    }
    
    $validRoles = ['student', 'instructor', 'coordinator', 'admin'];
    if(!in_array($role, $validRoles)) {
        jsonResponse(false, 'Invalid role');
    }
    
    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if($stmt->fetch()) {
            jsonResponse(false, 'Email already exists');
        }
        
        // Insert new user
        $passwordHash = hashPassword($password);
        $insertStmt = $pdo->prepare("
            INSERT INTO users (email, password_hash, full_name, role, phone, status)
            VALUES (?, ?, ?, ?, ?, 'active')
        ");
        $insertStmt->execute([$email, $passwordHash, $fullName, $role, $phone]);
        
        $userId = $pdo->lastInsertId();
        
        // Log activity
        logActivity($pdo, $_SESSION['user_id'], 'create_user', 'user', $userId);
        
        jsonResponse(true, 'User created successfully', [
            'user_id' => $userId
        ]);
    } catch(PDOException $e) {
        error_log("Create user error: " . $e->getMessage());
        jsonResponse(false, 'Failed to create user');
    }
}

// ==================== UPDATE USER ====================
function updateUser() {
    global $pdo;
    
    $userId = $_POST['user_id'] ?? null;
    
    if(!$userId) {
        jsonResponse(false, 'User ID is required');
    }
    
    // Users can only update their own profile unless they're admin
    if($_SESSION['user_id'] != $userId && $_SESSION['role'] !== 'admin') {
        jsonResponse(false, 'Access denied');
    }
    
    $fullName = sanitizeInput($_POST['full_name'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $role = sanitizeInput($_POST['role'] ?? '');
    
    if(empty($fullName)) {
        jsonResponse(false, 'Full name is required');
    }
    
    try {
        $query = "UPDATE users SET full_name = ?, phone = ?";
        $params = [$fullName, $phone];
        
        // Only admin can change roles
        if($role && $_SESSION['role'] === 'admin') {
            $validRoles = ['student', 'instructor', 'coordinator', 'admin'];
            if(!in_array($role, $validRoles)) {
                jsonResponse(false, 'Invalid role');
            }
            $query .= ", role = ?";
            $params[] = $role;
        }
        
        $query .= ", updated_at = NOW() WHERE user_id = ?";
        $params[] = $userId;
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        
        // Log activity
        logActivity($pdo, $_SESSION['user_id'], 'update_user', 'user', $userId);
        
        jsonResponse(true, 'User updated successfully');
    } catch(PDOException $e) {
        error_log("Update user error: " . $e->getMessage());
        jsonResponse(false, 'Failed to update user');
    }
}

// ==================== DELETE USER ====================
function deleteUser() {
    global $pdo;
    
    // Only admin can delete users
    requireRole('admin');
    
    $userId = $_POST['user_id'] ?? null;
    
    if(!$userId) {
        jsonResponse(false, 'User ID is required');
    }
    
    // Prevent deleting yourself
    if($_SESSION['user_id'] == $userId) {
        jsonResponse(false, 'You cannot delete your own account');
    }
    
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        if($stmt->rowCount() > 0) {
            // Log activity
            logActivity($pdo, $_SESSION['user_id'], 'delete_user', 'user', $userId);
            
            jsonResponse(true, 'User deleted successfully');
        } else {
            jsonResponse(false, 'User not found');
        }
    } catch(PDOException $e) {
        error_log("Delete user error: " . $e->getMessage());
        jsonResponse(false, 'Failed to delete user');
    }
}

// ==================== UPDATE USER STATUS ====================
function updateUserStatus() {
    global $pdo;
    
    // Only admin can update status
    requireRole('admin');
    
    $userId = $_POST['user_id'] ?? null;
    $status = sanitizeInput($_POST['status'] ?? '');
    
    if(!$userId || !$status) {
        jsonResponse(false, 'User ID and status are required');
    }
    
    $validStatuses = ['active', 'inactive', 'suspended'];
    if(!in_array($status, $validStatuses)) {
        jsonResponse(false, 'Invalid status');
    }
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET status = ?, updated_at = NOW() WHERE user_id = ?");
        $stmt->execute([$status, $userId]);
        
        // Log activity
        logActivity($pdo, $_SESSION['user_id'], 'update_user_status', 'user', $userId);
        
        jsonResponse(true, 'User status updated successfully');
    } catch(PDOException $e) {
        error_log("Update status error: " . $e->getMessage());
        jsonResponse(false, 'Failed to update status');
    }
}

?>

