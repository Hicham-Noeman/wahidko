<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - EduPlatform</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body class="student-dashboard">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <span id="userInfo" class="user-info">Student</span>
                <button onclick="logout()" class="btn btn-secondary" data-logout>Logout</button>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Student Dashboard</h1>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Enrolled Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Assignments Due</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">A-</div>
                    <div class="stat-label">Average Grade</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">85%</div>
                    <div class="stat-label">Attendance</div>
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
                                <h4>Web Development</h4>
                                <p>Learn HTML, CSS, JavaScript, and modern frameworks</p>
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 75%"></div>
                                    </div>
                                    <span>75% Complete</span>
                                </div>
                                <button class="btn btn-primary btn-sm">Continue Learning</button>
                            </div>
                            <div class="course-card">
                                <h4>Data Science</h4>
                                <p>Python, Statistics, and Machine Learning</p>
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 40%"></div>
                                    </div>
                                    <span>40% Complete</span>
                                </div>
                                <button class="btn btn-primary btn-sm">Continue Learning</button>
                            </div>
                            <div class="course-card">
                                <h4>Mobile Development</h4>
                                <p>Build native mobile applications</p>
                                <div class="course-progress">
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 60%"></div>
                                    </div>
                                    <span>60% Complete</span>
                                </div>
                                <button class="btn btn-primary btn-sm">Continue Learning</button>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Courses -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>✨ Recommended For You</h3>
                            <a href="../courses.php" class="btn btn-secondary btn-sm">View All</a>
                        </div>
                        <div id="recommendedCourses" class="course-list">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>

                    <!-- Recent Assignments -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Pending Assignments</h3>
                        </div>
                        <div class="assignments-list">
                            <div class="assignment-item">
                                <div>
                                    <strong>Web Development Project</strong>
                                    <p style="margin: 0; font-size: 0.875rem; color: var(--text-secondary);">Create a responsive website</p>
                                </div>
                                <span class="due-date" style="color: #ef4444;">Due: Tomorrow</span>
                            </div>
                            <div class="assignment-item">
                                <div>
                                    <strong>Data Analysis Report</strong>
                                    <p style="margin: 0; font-size: 0.875rem; color: var(--text-secondary);">Analyze provided dataset</p>
                                </div>
                                <span class="due-date">Due: 3 days</span>
                            </div>
                            <div class="assignment-item">
                                <div>
                                    <strong>JavaScript Calculator</strong>
                                    <p style="margin: 0; font-size: 0.875rem; color: var(--text-secondary);">Build interactive calculator</p>
                                </div>
                                <span class="due-date">Due: 5 days</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Schedule -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Today's Schedule</h3>
                        </div>
                        <div class="schedule">
                            <div class="schedule-item">
                                <div>
                                    <strong>10:00 AM</strong>
                                    <span>Web Development Class</span>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>2:00 PM</strong>
                                    <span>Data Science Lab</span>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>4:00 PM</strong>
                                    <span>Mobile Dev Workshop</span>
                                </div>
                            </div>
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
                                    Hello! I'm your education assistant. How can I help you today?
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
    <script>
        // Load recommended courses
        document.addEventListener('DOMContentLoaded', async function() {
            await loadRecommendations();
        });

        async function loadRecommendations() {
            try {
                // Demo recommendations (replace with API call in production)
                const recommendations = [
                    {
                        code: 'AI401',
                        title: 'Artificial Intelligence',
                        description: 'Deep learning and neural networks',
                        category: '🤖 AI',
                        instructor: 'Dr. David Lee'
                    },
                    {
                        code: 'CLOUD301',
                        title: 'Cloud Architecture',
                        description: 'AWS and Azure cloud solutions',
                        category: '☁️ Cloud',
                        instructor: 'Dr. Sarah Wilson'
                    }
                ];

                const container = document.getElementById('recommendedCourses');
                
                if(recommendations.length === 0) {
                    container.innerHTML = '<p style="color: var(--text-secondary); text-align: center; padding: 2rem;">No recommendations available. <a href="../select-categories.php">Update your interests</a></p>';
                    return;
                }

                container.innerHTML = recommendations.map(course => `
                    <div class="course-card">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                            <span style="font-size: 1.5rem;">${course.category}</span>
                            <span class="badge badge-info">Recommended</span>
                        </div>
                        <h4>${course.title}</h4>
                        <p style="color: var(--primary-color); font-size: 0.875rem; margin-bottom: 0.5rem;">${course.code}</p>
                        <p style="color: var(--text-secondary); margin-bottom: 0.5rem;">${course.description}</p>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">👨‍🏫 ${course.instructor}</p>
                        <button class="btn btn-primary btn-sm" style="margin-top: 1rem;" onclick="showNotification('Feature coming soon!', 'info')">Enroll Now</button>
                    </div>
                `).join('');
            } catch(error) {
                console.error('Error loading recommendations:', error);
            }
        }
    </script>
</body>
</html>


