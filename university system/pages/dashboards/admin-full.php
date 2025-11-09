<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel - EduPlatform</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <style>
        .admin-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .tab-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            background: var(--bg-primary);
            color: var(--text-primary);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-fast);
            font-weight: 600;
        }
        .tab-btn:hover {
            background: var(--primary-color);
            color: white;
        }
        .tab-btn.active {
            background: var(--primary-gradient);
            color: white;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .search-box {
            flex: 1;
            min-width: 250px;
        }
        .search-box input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 1rem;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
        }
        .admin-table thead {
            background: var(--primary-gradient);
            color: white;
        }
        .admin-table th, .admin-table td {
            padding: 1rem;
            text-align: left;
        }
        .admin-table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: background 0.2s;
        }
        .admin-table tbody tr:hover {
            background: var(--bg-primary);
        }
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success { background: #10b981; color: white; }
        .badge-warning { background: #f59e0b; color: white; }
        .badge-danger { background: #ef4444; color: white; }
        .badge-info { background: #3b82f6; color: white; }
    </style>
</head>
<body class="admin-dashboard">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform - Admin Control Panel</div>
            <nav class="nav">
                <span id="userInfo" class="user-info">Admin</span>
                <button onclick="logout()" class="btn btn-secondary" data-logout>Logout</button>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>🔐 Admin Control Panel</h1>
                <p style="color: var(--text-secondary);">Full database management and control</p>
            </div>

            <!-- Admin Tabs -->
            <div class="admin-tabs">
                <button class="tab-btn active" onclick="switchTab('users')">👥 Users</button>
                <button class="tab-btn" onclick="switchTab('courses')">📚 Courses</button>
                <button class="tab-btn" onclick="switchTab('enrollments')">📝 Enrollments</button>
                <button class="tab-btn" onclick="switchTab('assignments')">📋 Assignments</button>
                <button class="tab-btn" onclick="switchTab('categories')">🏷️ Categories</button>
                <button class="tab-btn" onclick="switchTab('announcements')">📢 Announcements</button>
                <button class="tab-btn" onclick="switchTab('logs')">📊 Activity Logs</button>
            </div>

            <!-- USERS TAB -->
            <div id="users-tab" class="tab-content active">
                <div class="widget">
                    <div class="action-bar">
                        <h3>User Management</h3>
                        <div class="search-box">
                            <input type="text" id="userSearch" placeholder="🔍 Search users..." onkeyup="searchTable('usersTable', this.value)">
                        </div>
                        <button class="btn btn-success" onclick="showModal('userModal')">+ Add User</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- COURSES TAB -->
            <div id="courses-tab" class="tab-content">
                <div class="widget">
                    <div class="action-bar">
                        <h3>Course Management</h3>
                        <div class="search-box">
                            <input type="text" id="courseSearch" placeholder="🔍 Search courses..." onkeyup="searchTable('coursesTable', this.value)">
                        </div>
                        <button class="btn btn-success" onclick="showModal('courseModal')">+ Add Course</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="coursesTable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Instructor</th>
                                    <th>Credits</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="coursesTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ENROLLMENTS TAB -->
            <div id="enrollments-tab" class="tab-content">
                <div class="widget">
                    <div class="action-bar">
                        <h3>Enrollment Management</h3>
                        <div class="search-box">
                            <input type="text" id="enrollmentSearch" placeholder="🔍 Search enrollments..." onkeyup="searchTable('enrollmentsTable', this.value)">
                        </div>
                        <button class="btn btn-success" onclick="showModal('enrollmentModal')">+ Add Enrollment</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="enrollmentsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="enrollmentsTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ASSIGNMENTS TAB -->
            <div id="assignments-tab" class="tab-content">
                <div class="widget">
                    <div class="action-bar">
                        <h3>Assignment Management</h3>
                        <div class="search-box">
                            <input type="text" id="assignmentSearch" placeholder="🔍 Search assignments..." onkeyup="searchTable('assignmentsTable', this.value)">
                        </div>
                        <button class="btn btn-success" onclick="showModal('assignmentModal')">+ Add Assignment</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="assignmentsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Course</th>
                                    <th>Due Date</th>
                                    <th>Max Points</th>
                                    <th>Submissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="assignmentsTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CATEGORIES TAB -->
            <div id="categories-tab" class="tab-content">
                <div class="widget">
                    <div class="action-bar">
                        <h3>Category Management</h3>
                        <div class="search-box">
                            <input type="text" id="categorySearch" placeholder="🔍 Search categories..." onkeyup="searchTable('categoriesTable', this.value)">
                        </div>
                        <button class="btn btn-success" onclick="showModal('categoryModal')">+ Add Category</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Courses</th>
                                    <th>Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ANNOUNCEMENTS TAB -->
            <div id="announcements-tab" class="tab-content">
                <div class="widget">
                    <div class="action-bar">
                        <h3>Announcement Management</h3>
                        <button class="btn btn-success" onclick="showModal('announcementModal')">+ Add Announcement</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="announcementsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="announcementsTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ACTIVITY LOGS TAB -->
            <div id="logs-tab" class="tab-content">
                <div class="widget">
                    <div class="action-bar">
                        <h3>Activity Logs</h3>
                        <div class="search-box">
                            <input type="text" id="logSearch" placeholder="🔍 Search logs..." onkeyup="searchTable('logsTable', this.value)">
                        </div>
                        <button class="btn btn-secondary" onclick="loadLogs()">🔄 Refresh</button>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="admin-table" id="logsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>IP Address</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody id="logsTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Generic Modal -->
    <div id="genericModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Edit Item</h3>
                <button onclick="closeModal('genericModal')" class="close-btn">&times;</button>
            </div>
            <div id="modalBody">
                <!-- Dynamic content will be inserted here -->
            </div>
        </div>
    </div>

    <script src="../../assets/js/app.js"></script>
    <script src="../../assets/js/admin-control.js"></script>
</body>
</html>


