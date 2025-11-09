<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EduPlatform</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body class="admin-dashboard">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <span id="userInfo" class="user-info">Admin</span>
                <button onclick="logout()" class="btn btn-secondary logout-btn" data-logout>Logout</button>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="systemSettings()">⚙️ System Settings</button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-number">450</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">25</div>
                    <div class="stat-label">Active Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Instructors</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">System Status</div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Main Content -->
                <div class="main-content">
                    <!-- User Management Widget -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>User Management</h3>
                            <button class="btn btn-success btn-sm" onclick="showAddUserForm()">+ Add User</button>
                        </div>
                        
                        <div class="data-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTableBody">
                                    <!-- Users will be loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- System Analytics Widget -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>System Analytics</h3>
                        </div>
                        <div class="quick-stats" style="margin-bottom: 0;">
                            <div class="stat-card">
                                <div class="stat-number">245</div>
                                <div class="stat-label">Active Users Today</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">2.5GB</div>
                                <div class="stat-label">Storage Used</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">99.8%</div>
                                <div class="stat-label">Uptime</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">1,245</div>
                                <div class="stat-label">Daily Requests</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Quick Actions -->
                    <div class="widget">
                        <div class="widget-header">
                            <h3>Quick Actions</h3>
                        </div>
                        <div class="quick-actions">
                            <button class="btn btn-secondary btn-block" onclick="backupSystem()">💾 Backup System</button>
                            <button class="btn btn-secondary btn-block" onclick="viewLogs()">📊 View Logs</button>
                            <button class="btn btn-secondary btn-block" onclick="manageRoles()">👥 Manage Roles</button>
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
                                    Hello Admin! How can I help you today?
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

    <!-- User Form Modal -->
    <div id="userForm" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New User</h3>
                <button onclick="hideUserForm()" class="close-btn">&times;</button>
            </div>
            
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="userName" class="form-control" placeholder="Enter full name">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="userEmail" class="form-control" placeholder="Enter email address">
            </div>
            
            <div class="form-group">
                <label>Role</label>
                <select id="userRole" class="form-control">
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="coordinator">Coordinator</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <input type="hidden" id="userId">
            
            <div class="modal-actions">
                <button class="btn btn-primary" onclick="saveUser()">Save User</button>
                <button class="btn btn-secondary" onclick="hideUserForm()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../../assets/js/app.js"></script>
    <script src="../../assets/js/dashboard.js"></script>
</body>
</html>


