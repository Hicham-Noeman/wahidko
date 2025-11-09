-- ==================== UNIVERSITY SYSTEM DATABASE SCHEMA ====================
-- Version: 1.0
-- Description: Complete database schema for university management system

-- Drop existing database if exists (CAUTION: This will delete all data!)
-- DROP DATABASE IF EXISTS university_system;

-- Create database
CREATE DATABASE IF NOT EXISTS university_system
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE university_system;

-- ==================== USERS TABLE ====================
CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('student', 'instructor', 'coordinator', 'admin') NOT NULL DEFAULT 'student',
    phone VARCHAR(20),
    avatar_url VARCHAR(500),
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== COURSES TABLE ====================
CREATE TABLE IF NOT EXISTS courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructor_id INT,
    coordinator_id INT,
    credits INT DEFAULT 3,
    max_students INT DEFAULT 30,
    semester VARCHAR(20),
    year INT,
    status ENUM('active', 'inactive', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (coordinator_id) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_course_code (course_code),
    INDEX idx_instructor (instructor_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== ENROLLMENTS TABLE ====================
CREATE TABLE IF NOT EXISTS enrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('enrolled', 'completed', 'dropped', 'withdrawn') DEFAULT 'enrolled',
    grade VARCHAR(5),
    final_grade DECIMAL(5,2),
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, course_id),
    INDEX idx_student (student_id),
    INDEX idx_course (course_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== ASSIGNMENTS TABLE ====================
CREATE TABLE IF NOT EXISTS assignments (
    assignment_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATETIME,
    max_points INT DEFAULT 100,
    file_url VARCHAR(500),
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(user_id),
    INDEX idx_course (course_id),
    INDEX idx_due_date (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== SUBMISSIONS TABLE ====================
CREATE TABLE IF NOT EXISTS submissions (
    submission_id INT PRIMARY KEY AUTO_INCREMENT,
    assignment_id INT NOT NULL,
    student_id INT NOT NULL,
    file_url VARCHAR(500),
    submission_text TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    grade INT,
    feedback TEXT,
    graded_by INT,
    graded_at TIMESTAMP NULL,
    FOREIGN KEY (assignment_id) REFERENCES assignments(assignment_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES users(user_id),
    UNIQUE KEY unique_submission (assignment_id, student_id),
    INDEX idx_assignment (assignment_id),
    INDEX idx_student (student_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== MATERIALS TABLE ====================
CREATE TABLE IF NOT EXISTS materials (
    material_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_url VARCHAR(500) NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    uploaded_by INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(user_id),
    INDEX idx_course (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== ANNOUNCEMENTS TABLE ====================
CREATE TABLE IF NOT EXISTS announcements (
    announcement_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_by INT NOT NULL,
    is_global BOOLEAN DEFAULT FALSE,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(user_id),
    INDEX idx_course (course_id),
    INDEX idx_global (is_global)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== SCHEDULE TABLE ====================
CREATE TABLE IF NOT EXISTS schedule (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room VARCHAR(50),
    building VARCHAR(100),
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    INDEX idx_course (course_id),
    INDEX idx_day (day_of_week)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== ACTIVITY LOGS TABLE ====================
CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50),
    entity_id INT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_created_at (created_at),
    INDEX idx_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== NOTIFICATIONS TABLE ====================
CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    link VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_read (is_read),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== GRADES TABLE ====================
CREATE TABLE IF NOT EXISTS grades (
    grade_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    assignment_id INT,
    grade_value DECIMAL(5,2) NOT NULL,
    grade_letter VARCHAR(2),
    weight DECIMAL(5,2) DEFAULT 1.00,
    comments TEXT,
    graded_by INT NOT NULL,
    graded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (assignment_id) REFERENCES assignments(assignment_id) ON DELETE SET NULL,
    FOREIGN KEY (graded_by) REFERENCES users(user_id),
    INDEX idx_student (student_id),
    INDEX idx_course (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== ATTENDANCE TABLE ====================
CREATE TABLE IF NOT EXISTS attendance (
    attendance_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('present', 'absent', 'late', 'excused') DEFAULT 'present',
    notes TEXT,
    marked_by INT NOT NULL,
    marked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (marked_by) REFERENCES users(user_id),
    UNIQUE KEY unique_attendance (student_id, course_id, date),
    INDEX idx_student (student_id),
    INDEX idx_course (course_id),
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== SAMPLE DATA ====================

-- Insert sample users with password '123456' (hashed)
INSERT INTO users (email, password_hash, full_name, role, status) VALUES
('admin@edu.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtnxIVOvlItqWJuqJxCUELGrjUFu', 'System Administrator', 'admin', 'active'),
('coordinator@edu.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtnxIVOvlItqWJuqJxCUELGrjUFu', 'Course Coordinator', 'coordinator', 'active'),
('instructor@edu.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtnxIVOvlItqWJuqJxCUELGrjUFu', 'Dr. John Smith', 'instructor', 'active'),
('student@edu.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtnxIVOvlItqWJuqJxCUELGrjUFu', 'Jane Doe', 'student', 'active'),
('student2@edu.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtnxIVOvlItqWJuqJxCUELGrjUFu', 'John Student', 'student', 'active');

-- Insert sample courses
INSERT INTO courses (course_code, title, description, instructor_id, credits, semester, year, status) VALUES
('CS101', 'Introduction to Computer Science', 'Fundamentals of programming and computer science concepts', 3, 3, 'Fall', 2024, 'active'),
('WEB201', 'Web Development', 'Learn HTML, CSS, JavaScript, and modern web frameworks', 3, 4, 'Fall', 2024, 'active'),
('DS301', 'Data Science Fundamentals', 'Introduction to Python, Statistics, and Machine Learning', 3, 3, 'Spring', 2024, 'active'),
('MOBILE202', 'Mobile App Development', 'Build native mobile applications for iOS and Android', 3, 4, 'Fall', 2024, 'active');

-- Insert sample enrollments
INSERT INTO enrollments (student_id, course_id, status) VALUES
(4, 1, 'enrolled'),
(4, 2, 'enrolled'),
(4, 3, 'enrolled'),
(5, 1, 'enrolled'),
(5, 2, 'enrolled');

-- Insert sample assignments
INSERT INTO assignments (course_id, title, description, due_date, max_points, created_by) VALUES
(2, 'HTML & CSS Project', 'Create a responsive website using HTML and CSS', '2024-12-15 23:59:59', 100, 3),
(2, 'JavaScript Calculator', 'Build an interactive calculator using vanilla JavaScript', '2024-12-20 23:59:59', 100, 3),
(3, 'Data Analysis Report', 'Analyze provided dataset and create a comprehensive report', '2024-12-18 23:59:59', 100, 3);

-- Insert sample schedule
INSERT INTO schedule (course_id, day_of_week, start_time, end_time, room, building) VALUES
(2, 'Monday', '10:00:00', '11:30:00', '101', 'Computer Science Building'),
(2, 'Wednesday', '10:00:00', '11:30:00', '101', 'Computer Science Building'),
(3, 'Tuesday', '14:00:00', '15:30:00', '205', 'Data Science Lab'),
(3, 'Thursday', '14:00:00', '15:30:00', '205', 'Data Science Lab');

-- Insert sample announcements
INSERT INTO announcements (course_id, title, content, created_by, is_global, priority) VALUES
(NULL, 'Welcome to the University System', 'Welcome to our new learning management system! Explore your courses and stay updated.', 1, TRUE, 'high'),
(2, 'Web Development Assignment Due', 'Reminder: Your HTML & CSS project is due this Friday at 11:59 PM.', 3, FALSE, 'medium'),
(3, 'Data Science Lab Session', 'Extra lab session scheduled for this Saturday from 2-4 PM.', 3, FALSE, 'medium');

-- ==================== VIEWS ====================

-- View for student course overview
CREATE OR REPLACE VIEW student_courses_view AS
SELECT 
    e.student_id,
    u.full_name AS student_name,
    c.course_id,
    c.course_code,
    c.title AS course_title,
    c.credits,
    i.full_name AS instructor_name,
    e.status AS enrollment_status,
    e.grade
FROM enrollments e
JOIN users u ON e.student_id = u.user_id
JOIN courses c ON e.course_id = c.course_id
LEFT JOIN users i ON c.instructor_id = i.user_id;

-- View for instructor course overview
CREATE OR REPLACE VIEW instructor_courses_view AS
SELECT 
    c.course_id,
    c.course_code,
    c.title,
    c.credits,
    c.instructor_id,
    i.full_name AS instructor_name,
    COUNT(DISTINCT e.student_id) AS enrolled_students,
    COUNT(DISTINCT a.assignment_id) AS total_assignments
FROM courses c
LEFT JOIN users i ON c.instructor_id = i.user_id
LEFT JOIN enrollments e ON c.course_id = e.course_id AND e.status = 'enrolled'
LEFT JOIN assignments a ON c.course_id = a.course_id
WHERE c.status = 'active'
GROUP BY c.course_id, c.course_code, c.title, c.credits, c.instructor_id, i.full_name;

-- ==================== STORED PROCEDURES ====================

DELIMITER //

-- Procedure to calculate student GPA
CREATE PROCEDURE IF NOT EXISTS calculate_student_gpa(IN p_student_id INT)
BEGIN
    SELECT 
        AVG(g.grade_value) AS gpa,
        COUNT(*) AS total_courses
    FROM grades g
    WHERE g.student_id = p_student_id;
END //

-- Procedure to get course statistics
CREATE PROCEDURE IF NOT EXISTS get_course_statistics(IN p_course_id INT)
BEGIN
    SELECT 
        COUNT(DISTINCT e.student_id) AS total_students,
        COUNT(DISTINCT a.assignment_id) AS total_assignments,
        AVG(g.grade_value) AS average_grade,
        COUNT(DISTINCT s.submission_id) AS total_submissions
    FROM courses c
    LEFT JOIN enrollments e ON c.course_id = e.course_id
    LEFT JOIN assignments a ON c.course_id = a.course_id
    LEFT JOIN grades g ON c.course_id = g.course_id
    LEFT JOIN submissions s ON a.assignment_id = s.assignment_id
    WHERE c.course_id = p_course_id;
END //

DELIMITER ;

-- ==================== INDEXES FOR PERFORMANCE ====================

-- Additional indexes for better query performance
CREATE INDEX idx_users_name ON users(full_name);
CREATE INDEX idx_courses_title ON courses(title);
CREATE INDEX idx_assignments_due ON assignments(due_date);

-- ==================== COMPLETION MESSAGE ====================

SELECT 'Database schema created successfully!' AS message;
SELECT 'Default password for all users: 123456' AS note;
SELECT 'Please change default passwords after first login!' AS warning;

