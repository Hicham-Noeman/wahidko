<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EduPlatform</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <span id="userInfo" class="user-info">Profile</span>
                <button onclick="logout()" class="btn btn-secondary" data-logout>Logout</button>
            </nav>
        </div>
    </header>

    <!-- Profile Content -->
    <main class="dashboard">
        <div class="container">
            <div class="dashboard-header">
                <h1>👤 My Profile</h1>
            </div>

            <div class="dashboard-grid">
                <!-- Main Content -->
                <div class="main-content">
                    <!-- Edit Profile -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Edit Profile Information</h3>
                        </div>
                        <form id="profileForm">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" id="fullName" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" disabled>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <textarea id="bio" class="form-control" rows="4" placeholder="Tell us about yourself..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                        </form>
                    </div>

                    <!-- Course History -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>📚 Course History</h3>
                        </div>
                        <div id="courseHistoryContainer">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Profile Stats -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Profile Stats</h3>
                        </div>
                        <div class="quick-stats" style="grid-template-columns: 1fr; gap: 1rem;">
                            <div class="stat-card">
                                <div class="stat-number" id="totalCourses">0</div>
                                <div class="stat-label">Total Courses</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number" id="completedCourses">0</div>
                                <div class="stat-label">Completed</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number" id="avgGrade">-</div>
                                <div class="stat-label">Average Grade</div>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>My Interests</h3>
                            <a href="select-categories.php" class="btn btn-secondary btn-sm">Edit</a>
                        </div>
                        <div id="userCategories">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/app.js"></script>
    <script>
        let userProfile = null;

        document.addEventListener('DOMContentLoaded', function() {
            loadProfile();
            loadCourseHistory();
            loadUserCategories();

            document.getElementById('profileForm').addEventListener('submit', saveProfile);
        });

        async function loadProfile() {
            try {
                const currentUser = JSON.parse(localStorage.getItem('currentUser'));
                if(!currentUser) {
                    window.location.href = 'login.php';
                    return;
                }

                // Load from localStorage for now (in production, fetch from API)
                document.getElementById('fullName').value = currentUser.name || '';
                document.getElementById('email').value = currentUser.email || '';
                document.getElementById('phone').value = currentUser.phone || '';
                document.getElementById('bio').value = currentUser.bio || '';

                document.getElementById('userInfo').textContent = currentUser.name;
            } catch(error) {
                console.error('Error loading profile:', error);
            }
        }

        async function saveProfile(e) {
            e.preventDefault();

            const profileData = {
                full_name: document.getElementById('fullName').value,
                phone: document.getElementById('phone').value,
                bio: document.getElementById('bio').value
            };

            try {
                // In production, save to database via API
                const currentUser = JSON.parse(localStorage.getItem('currentUser'));
                const updatedUser = {...currentUser, ...profileData, name: profileData.full_name};
                localStorage.setItem('currentUser', JSON.stringify(updatedUser));

                showNotification('Profile updated successfully!', 'success');
            } catch(error) {
                console.error('Error saving profile:', error);
                showNotification('Failed to update profile', 'error');
            }
        }

        async function loadCourseHistory() {
            try {
                // Demo data - replace with API call
                const courses = [
                    {code: 'CS101', title: 'Introduction to Computer Science', status: 'completed', grade: 'A', date: '2024-05-15'},
                    {code: 'WEB201', title: 'Web Development', status: 'enrolled', grade: '-', date: '2024-09-01'},
                    {code: 'DS301', title: 'Data Science', status: 'enrolled', grade: '-', date: '2024-09-01'}
                ];

                const container = document.getElementById('courseHistoryContainer');
                
                if(courses.length === 0) {
                    container.innerHTML = '<p style="color: var(--text-secondary); text-align: center; padding: 2rem;">No courses yet. <a href="courses.php">Browse courses</a></p>';
                    return;
                }

                container.innerHTML = courses.map(course => `
                    <div class="course-card" style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h4 style="margin-bottom: 0.5rem;">${course.title}</h4>
                                <p style="color: var(--text-secondary); font-size: 0.875rem;">${course.code}</p>
                            </div>
                            <div style="text-align: right;">
                                <span class="badge badge-${course.status === 'completed' ? 'success' : 'info'}">${course.status}</span>
                                <p style="font-weight: bold; margin-top: 0.5rem;">Grade: ${course.grade}</p>
                            </div>
                        </div>
                        <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0.5rem;">
                            ${course.status === 'completed' ? 'Completed' : 'Enrolled'}: ${new Date(course.date).toLocaleDateString()}
                        </p>
                    </div>
                `).join('');

                // Update stats
                document.getElementById('totalCourses').textContent = courses.length;
                document.getElementById('completedCourses').textContent = courses.filter(c => c.status === 'completed').length;
                
                const grades = courses.filter(c => c.grade !== '-').map(c => c.grade);
                if(grades.length > 0) {
                    // Simple average calculation (would be more sophisticated in production)
                    document.getElementById('avgGrade').textContent = 'B+';
                }
            } catch(error) {
                console.error('Error loading course history:', error);
            }
        }

        async function loadUserCategories() {
            try {
                // Demo data - replace with API call
                const categories = [
                    {icon: '🌐', name: 'Web Development'},
                    {icon: '📊', name: 'Data Science'},
                    {icon: '📱', name: 'Mobile Development'}
                ];

                const container = document.getElementById('userCategories');
                
                if(categories.length === 0) {
                    container.innerHTML = '<p style="color: var(--text-secondary); text-align: center; padding: 1rem;">No interests selected. <a href="select-categories.php">Select now</a></p>';
                    return;
                }

                container.innerHTML = categories.map(cat => `
                    <div style="padding: 0.75rem; background: var(--bg-primary); border-radius: var(--radius-md); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 1.5rem;">${cat.icon}</span>
                        <span style="font-weight: 600;">${cat.name}</span>
                    </div>
                `).join('');
            } catch(error) {
                console.error('Error loading categories:', error);
            }
        }
    </script>
</body>
</html>


