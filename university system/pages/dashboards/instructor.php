<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - EduPlatform</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body class="instructor-dashboard">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <span id="userInfo" class="user-info">Instructor</span>
                <button onclick="logout()" class="btn btn-secondary" data-logout>Logout</button>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Instructor Dashboard</h1>
                <button class="btn btn-success" onclick="addCourse()">+ Create Course</button>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Active Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">120</div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Pending Reviews</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">New Submissions</div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Main Content -->
                <div class="main-content">
                    <!-- My Courses -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>My Courses</h3>
                        </div>
                        <div class="course-list">
                            <div class="course-card">
                                <h4>Web Development (WEB201)</h4>
                                <p>30 Students • Fall 2024</p>
                                <div class="course-actions">
                                    <button class="btn btn-primary btn-sm" onclick="manageCourse('WEB201')">Manage</button>
                                    <button class="btn btn-secondary btn-sm" onclick="viewStudents('WEB201')">View Students</button>
                                    <button class="btn btn-success btn-sm" onclick="addContent('WEB201')">Add Content</button>
                                </div>
                            </div>
                            <div class="course-card">
                                <h4>Data Science (DS301)</h4>
                                <p>25 Students • Spring 2024</p>
                                <div class="course-actions">
                                    <button class="btn btn-primary btn-sm" onclick="manageCourse('DS301')">Manage</button>
                                    <button class="btn btn-secondary btn-sm" onclick="viewStudents('DS301')">View Students</button>
                                    <button class="btn btn-success btn-sm" onclick="addContent('DS301')">Add Content</button>
                                </div>
                            </div>
                            <div class="course-card">
                                <h4>Mobile Development (MOBILE202)</h4>
                                <p>20 Students • Fall 2024</p>
                                <div class="course-actions">
                                    <button class="btn btn-primary btn-sm" onclick="manageCourse('MOBILE202')">Manage</button>
                                    <button class="btn btn-secondary btn-sm" onclick="viewStudents('MOBILE202')">View Students</button>
                                    <button class="btn btn-success btn-sm" onclick="addContent('MOBILE202')">Add Content</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Submissions -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Recent Submissions</h3>
                        </div>
                        <div class="data-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Assignment</th>
                                        <th>Course</th>
                                        <th>Submitted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jane Doe</td>
                                        <td>HTML & CSS Project</td>
                                        <td>WEB201</td>
                                        <td>2 hours ago</td>
                                        <td><button class="btn btn-primary btn-sm">Review</button></td>
                                    </tr>
                                    <tr>
                                        <td>John Student</td>
                                        <td>JavaScript Calculator</td>
                                        <td>WEB201</td>
                                        <td>5 hours ago</td>
                                        <td><button class="btn btn-primary btn-sm">Review</button></td>
                                    </tr>
                                    <tr>
                                        <td>Mary Smith</td>
                                        <td>Data Analysis Report</td>
                                        <td>DS301</td>
                                        <td>1 day ago</td>
                                        <td><button class="btn btn-primary btn-sm">Review</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Today's Schedule -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Today's Classes</h3>
                        </div>
                        <div class="schedule">
                            <div class="schedule-item">
                                <div>
                                    <strong>10:00 AM - 11:30 AM</strong>
                                    <span>Web Development</span>
                                    <p style="margin: 0; font-size: 0.75rem; color: var(--text-secondary);">Room 101</p>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>2:00 PM - 3:30 PM</strong>
                                    <span>Data Science Lab</span>
                                    <p style="margin: 0; font-size: 0.75rem; color: var(--text-secondary);">Lab 205</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Quick Actions</h3>
                        </div>
                        <div class="quick-actions">
                            <button class="btn btn-secondary btn-block" onclick="addContent()">📝 Create Assignment</button>
                            <button class="btn btn-secondary btn-block" onclick="showNotification('Announcement posted', 'success')">📢 Post Announcement</button>
                            <button class="btn btn-secondary btn-block" onclick="showNotification('Opening grade book', 'info')">📊 Grade Book</button>
                        </div>
                    </div>

                    <!-- Chatbot -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>AI Assistant</h3>
                        </div>
                        <div class="chatbot-widget">
                            <div class="chat-messages" id="chatMessages">
                                <div class="message bot-message">
                                    Hello! How can I assist you with your courses today?
                                </div>
                            </div>
                            <div class="chat-input">
                                <input type="text" id="chatInput" placeholder="Type your message...">
                                <button onclick="sendMessage()" id="sendChat" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../assets/js/app.js"></script>
    <script src="../../assets/js/dashboard.js"></script>
</body>
</html>


