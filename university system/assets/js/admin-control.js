// ==================== ADMIN CONTROL PANEL ====================
// Comprehensive database management system

class AdminControl {
    constructor() {
        this.currentTab = 'users';
        this.apiBase = '../../php/admin/';
        this.init();
    }
    
    init() {
        this.loadAllData();
    }
    
    async loadAllData() {
        await this.loadUsers();
        await this.loadCourses();
        await this.loadEnrollments();
        await this.loadAssignments();
        await this.loadCategories();
        await this.loadAnnouncements();
        await this.loadLogs();
    }
    
    // ==================== USERS MANAGEMENT ====================
    async loadUsers() {
        try {
            const response = await fetch('../../php/users.php?action=get_all');
            const result = await response.json();
            
            if(result.success) {
                this.displayUsers(result.users);
            }
        } catch(error) {
            console.error('Error loading users:', error);
        }
    }
    
    displayUsers(users) {
        const tbody = document.getElementById('usersTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = users.map(user => `
            <tr>
                <td>${user.user_id}</td>
                <td>${user.full_name}</td>
                <td>${user.email}</td>
                <td><span class="role-badge ${user.role}">${user.role}</span></td>
                <td><span class="badge badge-${user.status === 'active' ? 'success' : 'warning'}">${user.status}</span></td>
                <td>${this.formatDate(user.created_at)}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="adminControl.editUser(${user.user_id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="adminControl.deleteUser(${user.user_id}, '${user.full_name}')">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    async editUser(userId) {
        // Fetch user data and show edit modal
        showNotification('Edit user feature - coming in full implementation', 'info');
    }
    
    async deleteUser(userId, userName) {
        if(!confirm(`Are you sure you want to delete user: ${userName}?`)) return;
        
        try {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('user_id', userId);
            
            const response = await fetch('../../php/users.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if(result.success) {
                showNotification('User deleted successfully', 'success');
                this.loadUsers();
            } else {
                showNotification(result.message, 'error');
            }
        } catch(error) {
            console.error('Delete error:', error);
            showNotification('Failed to delete user', 'error');
        }
    }
    
    // ==================== COURSES MANAGEMENT ====================
    async loadCourses() {
        try {
            const response = await fetch('../../php/courses.php?action=get_all');
            const result = await response.json();
            
            if(result.success) {
                this.displayCourses(result.courses);
            }
        } catch(error) {
            console.error('Error loading courses:', error);
        }
    }
    
    displayCourses(courses) {
        const tbody = document.getElementById('coursesTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = courses.map(course => `
            <tr>
                <td><strong>${course.course_code}</strong></td>
                <td>${course.title}</td>
                <td>${course.instructor_name || 'Not assigned'}</td>
                <td>${course.credits}</td>
                <td>${course.enrolled_students || 0}</td>
                <td><span class="badge badge-${course.status === 'active' ? 'success' : 'warning'}">${course.status}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="adminControl.editCourse(${course.course_id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="adminControl.deleteCourse(${course.course_id}, '${course.title}')">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    async editCourse(courseId) {
        showNotification('Edit course feature - coming in full implementation', 'info');
    }
    
    async deleteCourse(courseId, courseTitle) {
        if(!confirm(`Are you sure you want to delete course: ${courseTitle}?`)) return;
        showNotification('Delete course feature - coming in full implementation', 'info');
    }
    
    // ==================== ENROLLMENTS MANAGEMENT ====================
    async loadEnrollments() {
        try {
            // Demo data for now
            const enrollments = [
                {id: 1, student: 'Jane Doe', course: 'WEB201', status: 'enrolled', grade: 'A', date: '2024-09-01'},
                {id: 2, student: 'John Student', course: 'DS301', status: 'enrolled', grade: 'B+', date: '2024-09-01'},
                {id: 3, student: 'Mary Smith', course: 'CS101', status: 'completed', grade: 'A-', date: '2024-01-15'}
            ];
            
            this.displayEnrollments(enrollments);
        } catch(error) {
            console.error('Error loading enrollments:', error);
        }
    }
    
    displayEnrollments(enrollments) {
        const tbody = document.getElementById('enrollmentsTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = enrollments.map(enr => `
            <tr>
                <td>${enr.id}</td>
                <td>${enr.student}</td>
                <td><strong>${enr.course}</strong></td>
                <td><span class="badge badge-${enr.status === 'enrolled' ? 'info' : 'success'}">${enr.status}</span></td>
                <td><strong>${enr.grade || 'N/A'}</strong></td>
                <td>${this.formatDate(enr.date)}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="adminControl.editEnrollment(${enr.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="adminControl.deleteEnrollment(${enr.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    async editEnrollment(enrollmentId) {
        showNotification('Edit enrollment feature - coming in full implementation', 'info');
    }
    
    async deleteEnrollment(enrollmentId) {
        if(!confirm(`Are you sure you want to delete this enrollment?`)) return;
        showNotification('Delete enrollment feature - coming in full implementation', 'info');
    }
    
    // ==================== ASSIGNMENTS MANAGEMENT ====================
    async loadAssignments() {
        try {
            const assignments = [
                {id: 1, title: 'HTML & CSS Project', course: 'WEB201', due_date: '2024-12-15', max_points: 100, submissions: 25},
                {id: 2, title: 'JavaScript Calculator', course: 'WEB201', due_date: '2024-12-20', max_points: 100, submissions: 18},
                {id: 3, title: 'Data Analysis Report', course: 'DS301', due_date: '2024-12-18', max_points: 100, submissions: 20}
            ];
            
            this.displayAssignments(assignments);
        } catch(error) {
            console.error('Error loading assignments:', error);
        }
    }
    
    displayAssignments(assignments) {
        const tbody = document.getElementById('assignmentsTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = assignments.map(asn => `
            <tr>
                <td>${asn.id}</td>
                <td>${asn.title}</td>
                <td><strong>${asn.course}</strong></td>
                <td>${this.formatDate(asn.due_date)}</td>
                <td>${asn.max_points}</td>
                <td>${asn.submissions}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="adminControl.editAssignment(${asn.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="adminControl.deleteAssignment(${asn.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    async editAssignment(assignmentId) {
        showNotification('Edit assignment feature - coming in full implementation', 'info');
    }
    
    async deleteAssignment(assignmentId) {
        if(!confirm(`Are you sure you want to delete this assignment?`)) return;
        showNotification('Delete assignment feature - coming in full implementation', 'info');
    }
    
    // ==================== CATEGORIES MANAGEMENT ====================
    async loadCategories() {
        try {
            const categories = [
                {id: 1, icon: '🌐', name: 'Web Development', description: 'HTML, CSS, JavaScript', courses: 3, users: 150},
                {id: 2, icon: '📊', name: 'Data Science', description: 'ML, AI, Data Analysis', courses: 2, users: 120},
                {id: 3, icon: '📱', name: 'Mobile Development', description: 'iOS, Android Apps', courses: 2, users: 80},
                {id: 4, icon: '🔒', name: 'Cybersecurity', description: 'Ethical Hacking, Security', courses: 1, users: 60},
                {id: 5, icon: '☁️', name: 'Cloud Computing', description: 'AWS, Azure, DevOps', courses: 1, users: 90}
            ];
            
            this.displayCategories(categories);
        } catch(error) {
            console.error('Error loading categories:', error);
        }
    }
    
    displayCategories(categories) {
        const tbody = document.getElementById('categoriesTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = categories.map(cat => `
            <tr>
                <td>${cat.id}</td>
                <td style="font-size: 1.5rem;">${cat.icon}</td>
                <td><strong>${cat.name}</strong></td>
                <td>${cat.description}</td>
                <td>${cat.courses}</td>
                <td>${cat.users}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="adminControl.editCategory(${cat.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="adminControl.deleteCategory(${cat.id}, '${cat.name}')">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    async editCategory(categoryId) {
        showNotification('Edit category feature - coming in full implementation', 'info');
    }
    
    async deleteCategory(categoryId, categoryName) {
        if(!confirm(`Are you sure you want to delete category: ${categoryName}?`)) return;
        showNotification('Delete category feature - coming in full implementation', 'info');
    }
    
    // ==================== ANNOUNCEMENTS MANAGEMENT ====================
    async loadAnnouncements() {
        try {
            const announcements = [
                {id: 1, title: 'Welcome Message', content: 'Welcome to EduPlatform!', type: 'global', priority: 'high', created: '2024-11-01'},
                {id: 2, title: 'Course Update', content: 'New courses available', type: 'course', priority: 'medium', created: '2024-11-05'},
                {id: 3, title: 'System Maintenance', content: 'Scheduled maintenance', type: 'system', priority: 'high', created: '2024-11-08'}
            ];
            
            this.displayAnnouncements(announcements);
        } catch(error) {
            console.error('Error loading announcements:', error);
        }
    }
    
    displayAnnouncements(announcements) {
        const tbody = document.getElementById('announcementsTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = announcements.map(ann => `
            <tr>
                <td>${ann.id}</td>
                <td><strong>${ann.title}</strong></td>
                <td>${ann.content.substring(0, 50)}...</td>
                <td><span class="badge badge-info">${ann.type}</span></td>
                <td><span class="badge badge-${ann.priority === 'high' ? 'danger' : 'warning'}">${ann.priority}</span></td>
                <td>${this.formatDate(ann.created)}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="adminControl.editAnnouncement(${ann.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="adminControl.deleteAnnouncement(${ann.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    }
    
    async editAnnouncement(announcementId) {
        showNotification('Edit announcement feature - coming in full implementation', 'info');
    }
    
    async deleteAnnouncement(announcementId) {
        if(!confirm(`Are you sure you want to delete this announcement?`)) return;
        showNotification('Delete announcement feature - coming in full implementation', 'info');
    }
    
    // ==================== ACTIVITY LOGS ====================
    async loadLogs() {
        try {
            const logs = [
                {id: 1, user: 'admin@edu.com', action: 'login', entity: 'user', ip: '192.168.1.1', timestamp: '2024-11-08 10:30:00'},
                {id: 2, user: 'student@edu.com', action: 'course_enrollment', entity: 'course', ip: '192.168.1.2', timestamp: '2024-11-08 10:35:00'},
                {id: 3, user: 'instructor@edu.com', action: 'assignment_creation', entity: 'assignment', ip: '192.168.1.3', timestamp: '2024-11-08 11:00:00'}
            ];
            
            this.displayLogs(logs);
        } catch(error) {
            console.error('Error loading logs:', error);
        }
    }
    
    displayLogs(logs) {
        const tbody = document.getElementById('logsTableBody');
        if(!tbody) return;
        
        tbody.innerHTML = logs.map(log => `
            <tr>
                <td>${log.id}</td>
                <td>${log.user}</td>
                <td><span class="badge badge-info">${log.action}</span></td>
                <td>${log.entity}</td>
                <td>${log.ip}</td>
                <td>${log.timestamp}</td>
            </tr>
        `).join('');
    }
    
    // ==================== UTILITY FUNCTIONS ====================
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    }
}

// ==================== TAB SWITCHING ====================
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// ==================== TABLE SEARCH ====================
function searchTable(tableId, searchTerm) {
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const term = searchTerm.toLowerCase();
    
    for(let row of rows) {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(term) ? '' : 'none';
    }
}

// ==================== MODAL FUNCTIONS ====================
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if(modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if(modal) {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }
}

// ==================== INITIALIZE ====================
let adminControl;

document.addEventListener('DOMContentLoaded', function() {
    adminControl = new AdminControl();
});

