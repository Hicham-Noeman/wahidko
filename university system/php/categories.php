<?php
// ==================== CATEGORIES & RECOMMENDATIONS API ====================

require_once 'config.php';
session_start();

header('Content-Type: application/json');

// Get action
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch($action) {
    case 'get_all_categories':
        getAllCategories();
        break;
        
    case 'save_user_categories':
        saveUserCategories();
        break;
        
    case 'get_user_categories':
        getUserCategories();
        break;
        
    case 'get_recommendations':
        getRecommendations();
        break;
        
    default:
        jsonResponse(false, 'Invalid action');
}

// ==================== GET ALL CATEGORIES ====================
function getAllCategories() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT 
                c.*,
                COUNT(DISTINCT cc.course_id) as course_count,
                COUNT(DISTINCT uc.user_id) as user_count
            FROM categories c
            LEFT JOIN course_categories cc ON c.category_id = cc.category_id
            LEFT JOIN user_categories uc ON c.category_id = uc.category_id
            GROUP BY c.category_id
            ORDER BY c.name
        ");
        
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
        jsonResponse(true, 'Categories retrieved successfully', [
            'categories' => $categories,
            'count' => count($categories)
        ]);
    } catch(PDOException $e) {
        error_log("Get categories error: " . $e->getMessage());
        jsonResponse(false, 'Failed to retrieve categories');
    }
}

// ==================== SAVE USER CATEGORIES ====================
function saveUserCategories() {
    global $pdo;
    
    // Check authentication
    requireAuth();
    
    $userId = $_SESSION['user_id'];
    $categories = json_decode($_POST['categories'] ?? '[]', true);
    
    if(empty($categories) || !is_array($categories)) {
        jsonResponse(false, 'Categories are required');
    }
    
    if(count($categories) < 3 || count($categories) > 6) {
        jsonResponse(false, 'Please select 3-6 categories');
    }
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Delete existing user categories
        $deleteStmt = $pdo->prepare("DELETE FROM user_categories WHERE user_id = ?");
        $deleteStmt->execute([$userId]);
        
        // Insert new categories
        $insertStmt = $pdo->prepare("
            INSERT INTO user_categories (user_id, category_id)
            VALUES (?, ?)
        ");
        
        foreach($categories as $categoryId) {
            $insertStmt->execute([$userId, $categoryId]);
        }
        
        // Update user profile - mark categories as selected
        $updateStmt = $pdo->prepare("
            UPDATE users SET categories_selected = TRUE WHERE user_id = ?
        ");
        $updateStmt->execute([$userId]);
        
        // Commit transaction
        $pdo->commit();
        
        // Log activity
        logActivity($pdo, $userId, 'update_categories', 'user_categories', $userId);
        
        jsonResponse(true, 'Categories saved successfully', [
            'count' => count($categories)
        ]);
    } catch(PDOException $e) {
        $pdo->rollBack();
        error_log("Save categories error: " . $e->getMessage());
        jsonResponse(false, 'Failed to save categories');
    }
}

// ==================== GET USER CATEGORIES ====================
function getUserCategories() {
    global $pdo;
    
    // Check authentication
    requireAuth();
    
    $userId = $_SESSION['user_id'];
    
    try {
        $stmt = $pdo->prepare("
            SELECT c.*
            FROM user_categories uc
            JOIN categories c ON uc.category_id = c.category_id
            WHERE uc.user_id = ?
            ORDER BY c.name
        ");
        
        $stmt->execute([$userId]);
        $categories = $stmt->fetchAll();
        
        jsonResponse(true, 'User categories retrieved successfully', [
            'categories' => $categories,
            'count' => count($categories)
        ]);
    } catch(PDOException $e) {
        error_log("Get user categories error: " . $e->getMessage());
        jsonResponse(false, 'Failed to retrieve categories');
    }
}

// ==================== GET RECOMMENDATIONS ====================
function getRecommendations() {
    global $pdo;
    
    // Check authentication
    requireAuth();
    
    $userId = $_SESSION['user_id'];
    $limit = $_GET['limit'] ?? 6;
    
    try {
        // Check if user has selected categories
        $categoryCheckStmt = $pdo->prepare("
            SELECT COUNT(*) as count FROM user_categories WHERE user_id = ?
        ");
        $categoryCheckStmt->execute([$userId]);
        $categoryCheck = $categoryCheckStmt->fetch();
        
        if($categoryCheck['count'] == 0) {
            // No categories selected - return random courses
            $stmt = $pdo->prepare("
                SELECT 
                    c.course_id,
                    c.course_code,
                    c.title,
                    c.description,
                    c.credits,
                    i.full_name as instructor_name,
                    COUNT(DISTINCT e.student_id) as enrolled_students
                FROM courses c
                LEFT JOIN users i ON c.instructor_id = i.user_id
                LEFT JOIN enrollments e ON c.course_id = e.course_id
                WHERE c.status = 'active'
                    AND c.course_id NOT IN (
                        SELECT course_id 
                        FROM enrollments 
                        WHERE student_id = ?
                    )
                GROUP BY c.course_id
                ORDER BY RAND()
                LIMIT ?
            ");
            
            $stmt->execute([$userId, (int)$limit]);
        } else {
            // Categories selected - return courses from those categories
            $stmt = $pdo->prepare("
                SELECT 
                    c.course_id,
                    c.course_code,
                    c.title,
                    c.description,
                    c.credits,
                    i.full_name as instructor_name,
                    cat.name as category_name,
                    cat.icon as category_icon,
                    COUNT(DISTINCT e.student_id) as enrolled_students
                FROM user_categories uc
                JOIN course_categories cc ON uc.category_id = cc.category_id
                JOIN courses c ON cc.course_id = c.course_id
                JOIN categories cat ON cc.category_id = cat.category_id
                LEFT JOIN users i ON c.instructor_id = i.user_id
                LEFT JOIN enrollments e ON c.course_id = e.course_id
                WHERE uc.user_id = ?
                    AND c.status = 'active'
                    AND c.course_id NOT IN (
                        SELECT course_id 
                        FROM enrollments 
                        WHERE student_id = ?
                    )
                GROUP BY c.course_id
                ORDER BY RAND()
                LIMIT ?
            ");
            
            $stmt->execute([$userId, $userId, (int)$limit]);
        }
        
        $recommendations = $stmt->fetchAll();
        
        jsonResponse(true, 'Recommendations retrieved successfully', [
            'courses' => $recommendations,
            'count' => count($recommendations),
            'based_on_preferences' => $categoryCheck['count'] > 0
        ]);
    } catch(PDOException $e) {
        error_log("Get recommendations error: " . $e->getMessage());
        jsonResponse(false, 'Failed to get recommendations');
    }
}

?>

