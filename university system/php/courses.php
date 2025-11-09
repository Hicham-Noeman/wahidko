<?php
// ==================== COURSE MANAGEMENT API ====================

require_once 'config.php';
session_start();

header('Content-Type: application/json');

// Get action
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch($action) {
    case 'get_all':
        getAllCourses();
        break;
        
    case 'get_by_id':
        getCourseById();
        break;
        
    case 'enroll':
        enrollInCourse();
        break;
        
    case 'get_enrolled':
        getEnrolledCourses();
        break;
        
    default:
        jsonResponse(false, 'Invalid action');
}

// ==================== GET ALL COURSES (PUBLIC) ====================
function getAllCourses() {
    global $pdo;
    
    try {
        $query = "
            SELECT 
                c.course_id,
                c.course_code,
                c.title,
                c.description,
                c.credits,
                c.semester,
                c.year,
                c.status,
                i.full_name as instructor_name,
                COUNT(DISTINCT e.student_id) as enrolled_students
            FROM courses c
            LEFT JOIN users i ON c.instructor_id = i.user_id
            LEFT JOIN enrollments e ON c.course_id = e.course_id AND e.status = 'enrolled'
            WHERE c.status = 'active'
            GROUP BY c.course_id
            ORDER BY c.created_at DESC
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $courses = $stmt->fetchAll();
        
        // Add additional info for display
        foreach($courses as &$course) {
            // Calculate duration (placeholder - can be stored in DB)
            $course['duration'] = $course['credits'] * 4 . ' weeks';
            
            // Determine level based on course code (simple logic)
            $courseCode = $course['course_code'];
            if(preg_match('/[1-2]\d{2}/', $courseCode)) {
                $course['level'] = 'Beginner';
            } elseif(preg_match('/[3-4]\d{2}/', $courseCode)) {
                $course['level'] = 'Intermediate';
            } else {
                $course['level'] = 'Advanced';
            }
            
            // Max students
            $course['max_students'] = 30;
        }
        
        jsonResponse(true, 'Courses retrieved successfully', [
            'courses' => $courses,
            'count' => count($courses)
        ]);
    } catch(PDOException $e) {
        error_log("Get courses error: " . $e->getMessage());
        jsonResponse(false, 'Failed to retrieve courses');
    }
}

// ==================== GET COURSE BY ID ====================
function getCourseById() {
    global $pdo;
    
    $courseId = $_GET['course_id'] ?? null;
    
    if(!$courseId) {
        jsonResponse(false, 'Course ID is required');
    }
    
    try {
        $query = "
            SELECT 
                c.*,
                i.full_name as instructor_name,
                i.email as instructor_email,
                coord.full_name as coordinator_name,
                COUNT(DISTINCT e.student_id) as enrolled_students,
                COUNT(DISTINCT a.assignment_id) as total_assignments
            FROM courses c
            LEFT JOIN users i ON c.instructor_id = i.user_id
            LEFT JOIN users coord ON c.coordinator_id = coord.user_id
            LEFT JOIN enrollments e ON c.course_id = e.course_id AND e.status = 'enrolled'
            LEFT JOIN assignments a ON c.course_id = a.course_id
            WHERE c.course_id = ?
            GROUP BY c.course_id
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$courseId]);
        $course = $stmt->fetch();
        
        if($course) {
            jsonResponse(true, 'Course retrieved successfully', ['course' => $course]);
        } else {
            jsonResponse(false, 'Course not found');
        }
    } catch(PDOException $e) {
        error_log("Get course by ID error: " . $e->getMessage());
        jsonResponse(false, 'Failed to retrieve course');
    }
}

// ==================== ENROLL IN COURSE ====================
function enrollInCourse() {
    global $pdo;
    
    // Check authentication
    requireAuth();
    
    // Only students can enroll
    if($_SESSION['role'] !== 'student') {
        jsonResponse(false, 'Only students can enroll in courses');
    }
    
    $courseId = $_POST['course_id'] ?? null;
    
    if(!$courseId) {
        jsonResponse(false, 'Course ID is required');
    }
    
    $studentId = $_SESSION['user_id'];
    
    try {
        // Check if already enrolled
        $checkStmt = $pdo->prepare("
            SELECT enrollment_id FROM enrollments 
            WHERE student_id = ? AND course_id = ?
        ");
        $checkStmt->execute([$studentId, $courseId]);
        
        if($checkStmt->fetch()) {
            jsonResponse(false, 'You are already enrolled in this course');
        }
        
        // Check course capacity
        $capacityStmt = $pdo->prepare("
            SELECT 
                c.max_students,
                COUNT(e.student_id) as current_students
            FROM courses c
            LEFT JOIN enrollments e ON c.course_id = e.course_id AND e.status = 'enrolled'
            WHERE c.course_id = ?
            GROUP BY c.course_id
        ");
        $capacityStmt->execute([$courseId]);
        $capacity = $capacityStmt->fetch();
        
        if($capacity && $capacity['current_students'] >= $capacity['max_students']) {
            jsonResponse(false, 'This course is full');
        }
        
        // Enroll student
        $enrollStmt = $pdo->prepare("
            INSERT INTO enrollments (student_id, course_id, status)
            VALUES (?, ?, 'enrolled')
        ");
        $enrollStmt->execute([$studentId, $courseId]);
        
        // Log activity
        logActivity($pdo, $studentId, 'course_enrollment', 'course', $courseId);
        
        // Create notification
        createNotification(
            $pdo,
            $studentId,
            'Successfully Enrolled',
            'You have been enrolled in the course',
            'success'
        );
        
        jsonResponse(true, 'Successfully enrolled in course', [
            'enrollment_id' => $pdo->lastInsertId()
        ]);
    } catch(PDOException $e) {
        error_log("Enroll error: " . $e->getMessage());
        jsonResponse(false, 'Failed to enroll in course');
    }
}

// ==================== GET ENROLLED COURSES ====================
function getEnrolledCourses() {
    global $pdo;
    
    // Check authentication
    requireAuth();
    
    $studentId = $_SESSION['user_id'];
    
    try {
        $query = "
            SELECT 
                c.course_id,
                c.course_code,
                c.title,
                c.description,
                c.credits,
                i.full_name as instructor_name,
                e.enrollment_date,
                e.status,
                e.grade
            FROM enrollments e
            JOIN courses c ON e.course_id = c.course_id
            LEFT JOIN users i ON c.instructor_id = i.user_id
            WHERE e.student_id = ?
            ORDER BY e.enrollment_date DESC
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$studentId]);
        $courses = $stmt->fetchAll();
        
        jsonResponse(true, 'Enrolled courses retrieved successfully', [
            'courses' => $courses,
            'count' => count($courses)
        ]);
    } catch(PDOException $e) {
        error_log("Get enrolled courses error: " . $e->getMessage());
        jsonResponse(false, 'Failed to retrieve enrolled courses');
    }
}

?>

