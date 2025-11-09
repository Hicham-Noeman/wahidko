<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard - EduPlatform</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body class="coordinator-dashboard">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <span id="userInfo" class="user-info">Coordinator</span>
                <button onclick="logout()" class="btn btn-secondary" data-logout>Logout</button>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Coordinator Dashboard</h1>
                <button class="btn btn-success" onclick="addCourse()">+ Add New Course</button>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-number">25</div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Instructors</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">400</div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">92%</div>
                    <div class="stat-label">Average Satisfaction</div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Main Content -->
                <div class="main-content">
                    <!-- Course Management -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Course Management</h3>
                        </div>
                        <div class="course-list">
                            <div class="course-card">
                                <h4>Web Development (WEB201)</h4>
                                <p>Instructor: Dr. Smith • 30 Students • Fall 2024</p>
                                <div class="course-actions">
                                    <button class="btn btn-primary btn-sm" onclick="manageCourse('WEB201')">Manage</button>
                                    <button class="btn btn-secondary btn-sm" onclick="assignInstructor('WEB201')">Assign Instructor</button>
                                    <button class="btn btn-warning btn-sm" onclick="scheduleCourse('WEB201')">Schedule</button>
                                </div>
                            </div>
                            <div class="course-card">
                                <h4>Data Science (DS301)</h4>
                                <p>Instructor: Dr. Johnson • 25 Students • Spring 2024</p>
                                <div class="course-actions">
                                    <button class="btn btn-primary btn-sm" onclick="manageCourse('DS301')">Manage</button>
                                    <button class="btn btn-secondary btn-sm" onclick="assignInstructor('DS301')">Assign Instructor</button>
                                    <button class="btn btn-warning btn-sm" onclick="scheduleCourse('DS301')">Schedule</button>
                                </div>
                            </div>
                            <div class="course-card">
                                <h4>Mobile Development (MOBILE202)</h4>
                                <p>Instructor: Dr. Williams • 20 Students • Fall 2024</p>
                                <div class="course-actions">
                                    <button class="btn btn-primary btn-sm" onclick="manageCourse('MOBILE202')">Manage</button>
                                    <button class="btn btn-secondary btn-sm" onclick="assignInstructor('MOBILE202')">Assign Instructor</button>
                                    <button class="btn btn-warning btn-sm" onclick="scheduleCourse('MOBILE202')">Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Overview -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Instructor Overview</h3>
                        </div>
                        <div class="data-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Courses</th>
                                        <th>Students</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dr. John Smith</td>
                                        <td>3</td>
                                        <td>75</td>
                                        <td><span class="role-badge student">Active</span></td>
                                        <td><button class="btn btn-primary btn-sm">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>Dr. Sarah Johnson</td>
                                        <td>2</td>
                                        <td>50</td>
                                        <td><span class="role-badge student">Active</span></td>
                                        <td><button class="btn btn-primary btn-sm">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>Dr. Mike Williams</td>
                                        <td>2</td>
                                        <td>45</td>
                                        <td><span class="role-badge student">Active</span></td>
                                        <td><button class="btn btn-primary btn-sm">View</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Schedule Overview -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Schedule Overview</h3>
                        </div>
                        <div class="schedule">
                            <div class="schedule-item">
                                <div>
                                    <strong>Monday</strong>
                                    <span>5 Classes Scheduled</span>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>Tuesday</strong>
                                    <span>4 Classes Scheduled</span>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>Wednesday</strong>
                                    <span>5 Classes Scheduled</span>
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
                            <button class="btn btn-secondary btn-block" onclick="addCourse()">➕ Add Course</button>
                            <button class="btn btn-secondary btn-block" onclick="showNotification('Schedule view opened', 'info')">📅 Manage Schedule</button>
                            <button class="btn btn-secondary btn-block" onclick="showNotification('Generating reports', 'info')">📊 Generate Reports</button>
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
                                    Hello Coordinator! How can I help you manage the courses today?
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


