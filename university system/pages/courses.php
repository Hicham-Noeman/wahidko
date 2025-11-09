<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses - EduPlatform</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="courses.php" class="nav-link">Courses</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="register.php" class="btn btn-success">Register</a>
                <a href="login.php" class="btn btn-primary">Login</a>
            </nav>
        </div>
    </header>

    <!-- Courses Section -->
    <main class="dashboard">
        <div class="container">
            <div class="dashboard-header" style="text-align: center;">
                <h1>Available Courses</h1>
                <p style="color: var(--text-secondary); margin-top: 1rem;">Browse our comprehensive course catalog. <a href="login.php" style="color: var(--primary-color);">Login</a> to enroll!</p>
            </div>

            <!-- Course Grid -->
            <div id="coursesContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <!-- Courses will be loaded here -->
            </div>

            <!-- Loading State -->
            <div id="loadingSpinner" class="text-center" style="padding: 3rem;">
                <div class="spinner"></div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <div class="logo" style="margin-bottom: 1rem;">🎓 EduPlatform</div>
                    <p style="color: var(--text-secondary);">Your gateway to quality education. Learn anytime, anywhere.</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem;">Quick Links</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="index.php" style="color: var(--text-secondary); text-decoration: none;">Home</a>
                        <a href="courses.php" style="color: var(--text-secondary); text-decoration: none;">Courses</a>
                        <a href="about.php" style="color: var(--text-secondary); text-decoration: none;">About</a>
                        <a href="contact.php" style="color: var(--text-secondary); text-decoration: none;">Contact</a>
                    </div>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem;">Get Started</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="register.php" style="color: var(--text-secondary); text-decoration: none;">Register</a>
                        <a href="login.php" style="color: var(--text-secondary); text-decoration: none;">Login</a>
                    </div>
                </div>
            </div>
            <div style="text-align: center; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <p style="color: var(--text-secondary);">&copy; 2024 EduPlatform. All rights reserved. | Built with ❤️</p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/app.js"></script>
    <script>
        // Load courses on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCourses();
        });

        async function loadCourses() {
            try {
                // Simulate API call - Replace with actual API
                const courses = [
                    {
                        code: 'CS101',
                        title: 'Introduction to Computer Science',
                        description: 'Learn the fundamentals of programming and computer science concepts',
                        instructor: 'Dr. John Smith',
                        credits: 3,
                        duration: '12 weeks',
                        level: 'Beginner',
                        students: 150
                    },
                    {
                        code: 'WEB201',
                        title: 'Web Development',
                        description: 'Master HTML, CSS, JavaScript, and modern web frameworks',
                        instructor: 'Dr. Sarah Johnson',
                        credits: 4,
                        duration: '14 weeks',
                        level: 'Intermediate',
                        students: 120
                    },
                    {
                        code: 'DS301',
                        title: 'Data Science Fundamentals',
                        description: 'Introduction to Python, Statistics, and Machine Learning',
                        instructor: 'Dr. Mike Williams',
                        credits: 3,
                        duration: '12 weeks',
                        level: 'Intermediate',
                        students: 100
                    },
                    {
                        code: 'MOBILE202',
                        title: 'Mobile App Development',
                        description: 'Build native mobile applications for iOS and Android',
                        instructor: 'Dr. Emily Brown',
                        credits: 4,
                        duration: '16 weeks',
                        level: 'Intermediate',
                        students: 80
                    },
                    {
                        code: 'AI401',
                        title: 'Artificial Intelligence',
                        description: 'Deep dive into AI algorithms and neural networks',
                        instructor: 'Dr. David Lee',
                        credits: 4,
                        duration: '14 weeks',
                        level: 'Advanced',
                        students: 60
                    },
                    {
                        code: 'CYBER301',
                        title: 'Cybersecurity Basics',
                        description: 'Learn security principles and ethical hacking',
                        instructor: 'Dr. Lisa Garcia',
                        credits: 3,
                        duration: '10 weeks',
                        level: 'Intermediate',
                        students: 90
                    }
                ];

                displayCourses(courses);
            } catch(error) {
                console.error('Error loading courses:', error);
                document.getElementById('loadingSpinner').innerHTML = '<p style="color: var(--admin-color);">Error loading courses. Please try again later.</p>';
            }
        }

        function displayCourses(courses) {
            const container = document.getElementById('coursesContainer');
            document.getElementById('loadingSpinner').style.display = 'none';
            
            container.innerHTML = courses.map(course => `
                <div class="card" style="animation: scaleIn 0.5s ease-out;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <span class="role-badge ${course.level === 'Beginner' ? 'student' : course.level === 'Intermediate' ? 'instructor' : 'coordinator'}" style="font-size: 0.7rem;">
                                ${course.level}
                            </span>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.875rem; color: var(--text-secondary);">${course.credits} Credits</div>
                        </div>
                    </div>
                    
                    <h3 style="color: var(--text-primary); margin-bottom: 0.5rem;">${course.title}</h3>
                    <p style="color: var(--primary-color); font-size: 0.875rem; margin-bottom: 1rem;">${course.code}</p>
                    <p style="color: var(--text-secondary); margin-bottom: 1rem; line-height: 1.6;">${course.description}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; padding: 1rem; background: var(--bg-primary); border-radius: var(--radius-md); margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">👨‍🏫 Instructor:</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">${course.instructor}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">⏱️ Duration:</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">${course.duration}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">👥 Students:</span>
                            <span style="font-weight: 600; font-size: 0.875rem;">${course.students}</span>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary btn-block" onclick="handleEnroll('${course.code}')">
                        🔒 Login to Enroll
                    </button>
                </div>
            `).join('');
        }

        function handleEnroll(courseCode) {
            // Check if user is logged in
            const currentUser = localStorage.getItem('currentUser');
            
            if(currentUser) {
                showNotification('Enrolling in course ' + courseCode + '...', 'info');
                // Redirect to student dashboard or enrollment page
                setTimeout(() => {
                    window.location.href = 'dashboards/student.php';
                }, 1000);
            } else {
                showNotification('Please login or register to enroll in courses', 'warning');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 1500);
            }
        }
    </script>
</body>
</html>


