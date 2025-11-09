-- ==================== DATABASE UPDATES FOR NEW FEATURES ====================
-- Add this to your existing database or run after schema.sql

USE university_system;

-- ==================== CATEGORIES TABLE ====================
CREATE TABLE IF NOT EXISTS categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== USER CATEGORIES (PREFERENCES) ====================
CREATE TABLE IF NOT EXISTS user_categories (
    user_category_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_category (user_id, category_id),
    INDEX idx_user (user_id),
    INDEX idx_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== COURSE CATEGORIES ====================
CREATE TABLE IF NOT EXISTS course_categories (
    course_category_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE,
    UNIQUE KEY unique_course_category (course_id, category_id),
    INDEX idx_course (course_id),
    INDEX idx_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==================== UPDATE USERS TABLE ====================
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS bio TEXT AFTER phone,
ADD COLUMN IF NOT EXISTS profile_completed BOOLEAN DEFAULT FALSE AFTER status,
ADD COLUMN IF NOT EXISTS categories_selected BOOLEAN DEFAULT FALSE AFTER profile_completed;

-- ==================== INSERT SAMPLE CATEGORIES ====================
INSERT INTO categories (name, description, icon) VALUES
('Web Development', 'HTML, CSS, JavaScript, Frontend & Backend', '🌐'),
('Data Science', 'Machine Learning, AI, Data Analysis', '📊'),
('Mobile Development', 'iOS, Android, Cross-platform Apps', '📱'),
('Cybersecurity', 'Ethical Hacking, Network Security', '🔒'),
('Cloud Computing', 'AWS, Azure, DevOps', '☁️'),
('Databases', 'SQL, NoSQL, Database Design', '🗄️'),
('UI/UX Design', 'User Interface, User Experience', '🎨'),
('Game Development', 'Unity, Unreal Engine, Game Design', '🎮'),
('Artificial Intelligence', 'Machine Learning, Deep Learning', '🤖'),
('Blockchain', 'Cryptocurrency, Smart Contracts', '⛓️'),
('IoT', 'Internet of Things, Embedded Systems', '📡'),
('Digital Marketing', 'SEO, Social Media Marketing', '📈')
ON DUPLICATE KEY UPDATE name=name;

-- ==================== ASSIGN CATEGORIES TO EXISTING COURSES ====================
-- Web Development course
INSERT INTO course_categories (course_id, category_id) 
SELECT c.course_id, cat.category_id 
FROM courses c 
CROSS JOIN categories cat 
WHERE c.course_code = 'WEB201' AND cat.name = 'Web Development'
ON DUPLICATE KEY UPDATE course_id=course_id;

-- Data Science course
INSERT INTO course_categories (course_id, category_id) 
SELECT c.course_id, cat.category_id 
FROM courses c 
CROSS JOIN categories cat 
WHERE c.course_code = 'DS301' AND cat.name = 'Data Science'
ON DUPLICATE KEY UPDATE course_id=course_id;

-- Computer Science basics - Web Development
INSERT INTO course_categories (course_id, category_id) 
SELECT c.course_id, cat.category_id 
FROM courses c 
CROSS JOIN categories cat 
WHERE c.course_code = 'CS101' AND cat.name = 'Web Development'
ON DUPLICATE KEY UPDATE course_id=course_id;

-- Mobile Development
INSERT INTO course_categories (course_id, category_id) 
SELECT c.course_id, cat.category_id 
FROM courses c 
CROSS JOIN categories cat 
WHERE c.course_code = 'MOBILE202' AND cat.name = 'Mobile Development'
ON DUPLICATE KEY UPDATE course_id=course_id;

-- ==================== COURSE HISTORY VIEW ====================
CREATE OR REPLACE VIEW user_course_history AS
SELECT 
    e.student_id,
    u.full_name as student_name,
    c.course_id,
    c.course_code,
    c.title as course_title,
    c.credits,
    i.full_name as instructor_name,
    e.enrollment_date,
    e.status,
    e.grade,
    e.final_grade,
    COUNT(DISTINCT s.submission_id) as total_submissions,
    AVG(s.grade) as average_assignment_grade
FROM enrollments e
JOIN users u ON e.student_id = u.user_id
JOIN courses c ON e.course_id = c.course_id
LEFT JOIN users i ON c.instructor_id = i.user_id
LEFT JOIN assignments a ON c.course_id = a.course_id
LEFT JOIN submissions s ON a.assignment_id = s.assignment_id AND s.student_id = e.student_id
GROUP BY e.enrollment_id, e.student_id, u.full_name, c.course_id, c.course_code, 
         c.title, c.credits, i.full_name, e.enrollment_date, e.status, e.grade, e.final_grade;

-- ==================== RECOMMENDED COURSES VIEW ====================
CREATE OR REPLACE VIEW recommended_courses_view AS
SELECT 
    uc.user_id,
    c.course_id,
    c.course_code,
    c.title,
    c.description,
    c.credits,
    cat.name as category_name,
    i.full_name as instructor_name,
    COUNT(DISTINCT e.student_id) as enrolled_students
FROM user_categories uc
JOIN course_categories cc ON uc.category_id = cc.category_id
JOIN courses c ON cc.course_id = c.course_id
JOIN categories cat ON cc.category_id = cat.category_id
LEFT JOIN users i ON c.instructor_id = i.user_id
LEFT JOIN enrollments e ON c.course_id = e.course_id
WHERE c.status = 'active'
    AND c.course_id NOT IN (
        SELECT course_id 
        FROM enrollments 
        WHERE student_id = uc.user_id
    )
GROUP BY uc.user_id, c.course_id, c.course_code, c.title, c.description, 
         c.credits, cat.name, i.full_name;

-- ==================== SUCCESS MESSAGE ====================
SELECT 'Database updated successfully with new features!' AS message;
SELECT 'New tables: categories, user_categories, course_categories' AS tables_added;
SELECT 'Run this script after schema.sql or on existing database' AS note;

