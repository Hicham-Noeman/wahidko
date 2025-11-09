// ==================== DASHBOARD MANAGEMENT ====================

class DashboardManager {
    constructor() {
        this.users = [];
        this.courses = [];
        this.init();
    }
    
    init() {
        this.loadUsers();
        this.loadCourses();
        this.setupDashboardListeners();
    }
    
    // ==================== USER MANAGEMENT ====================
    async loadUsers() {
        const tableBody = document.getElementById('usersTableBody');
        if(!tableBody) return;
        
        // Sample data (will be replaced with API call)
        this.users = [
            { id: 'U001', name: 'John Student', email: 'student@edu.com', role: 'student' },
            { id: 'U002', name: 'Dr. Smith', email: 'instructor@edu.com', role: 'instructor' },
            { id: 'U003', name: 'Coordinator Alex', email: 'coordinator@edu.com', role: 'coordinator' },
            { id: 'U004', name: 'System Admin', email: 'admin@edu.com', role: 'admin' }
        ];
        
        this.displayUsers();
    }
    
    displayUsers() {
        const tableBody = document.getElementById('usersTableBody');
        if(!tableBody) return;
        
        tableBody.innerHTML = '';
        
        this.users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td><span class="role-badge ${user.role}">${user.role}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="dashboardManager.editUser('${user.id}')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="dashboardManager.deleteUser('${user.id}')">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
    
    showAddUserForm() {
        const modal = document.getElementById('userForm');
        if(modal) {
            document.getElementById('modalTitle').textContent = 'Add New User';
            document.getElementById('userId').value = '';
            document.getElementById('userName').value = '';
            document.getElementById('userEmail').value = '';
            document.getElementById('userRole').value = 'student';
            modal.classList.add('active');
            modal.style.display = 'flex';
        }
    }
    
    editUser(userId) {
        const user = this.users.find(u => u.id === userId);
        if(!user) return;
        
        const modal = document.getElementById('userForm');
        if(modal) {
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('userId').value = user.id;
            document.getElementById('userName').value = user.name;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userRole').value = user.role;
            modal.classList.add('active');
            modal.style.display = 'flex';
        }
    }
    
    hideUserForm() {
        const modal = document.getElementById('userForm');
        if(modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }
    
    saveUser() {
        const id = document.getElementById('userId').value;
        const name = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const role = document.getElementById('userRole').value;
        
        if(!name || !email) {
            showNotification('Please fill all fields', 'error');
            return;
        }
        
        if(id) {
            // Edit existing user
            const userIndex = this.users.findIndex(u => u.id === id);
            if(userIndex !== -1) {
                this.users[userIndex] = { id, name, email, role };
                showNotification('User updated successfully: ' + name, 'success');
            }
        } else {
            // Add new user
            const newId = 'U' + String(this.users.length + 1).padStart(3, '0');
            this.users.push({ id: newId, name, email, role });
            showNotification('User added successfully: ' + name, 'success');
        }
        
        this.displayUsers();
        this.hideUserForm();
    }
    
    deleteUser(userId) {
        const user = this.users.find(u => u.id === userId);
        if(!user) return;
        
        if(confirm(`Are you sure you want to delete user: ${user.name}?`)) {
            this.users = this.users.filter(u => u.id !== userId);
            this.displayUsers();
            showNotification('User deleted: ' + user.name, 'success');
        }
    }
    
    // ==================== COURSE MANAGEMENT ====================
    async loadCourses() {
        // Sample data
        this.courses = [
            { id: 'CS101', name: 'Web Development', instructor: 'Dr. Smith', students: 25 },
            { id: 'CS102', name: 'Data Science', instructor: 'Dr. Johnson', students: 30 },
            { id: 'CS103', name: 'Mobile Development', instructor: 'Dr. Williams', students: 20 }
        ];
    }
    
    // ==================== SYSTEM FUNCTIONS ====================
    systemSettings() {
        showNotification('Opening system settings...', 'info');
        // Open system settings modal if exists
        const settingsModal = document.getElementById('systemSettingsModal');
        if(settingsModal) {
            settingsModal.classList.add('active');
            settingsModal.style.display = 'flex';
        }
    }
    
    backupSystem() {
        showNotification('Starting system backup...', 'info');
        // Simulate backup process
        setTimeout(() => {
            showNotification('System backup completed successfully!', 'success');
        }, 2000);
    }
    
    viewLogs() {
        showNotification('Displaying system logs...', 'info');
    }
    
    manageRoles() {
        showNotification('Managing user roles...', 'info');
    }
    
    // ==================== COURSE ACTIONS ====================
    manageCourse(courseId) {
        showNotification('Managing course: ' + courseId, 'info');
    }
    
    viewStudents(courseId) {
        showNotification('Viewing students for course: ' + courseId, 'info');
    }
    
    addContent(courseId) {
        showNotification('Adding content to course: ' + courseId, 'info');
    }
    
    addCourse() {
        showNotification('Adding new course...', 'info');
    }
    
    assignInstructor(courseId) {
        showNotification('Assigning instructor to course: ' + courseId, 'info');
    }
    
    scheduleCourse(courseId) {
        showNotification('Scheduling course: ' + courseId, 'info');
    }
    
    // ==================== EVENT LISTENERS ====================
    setupDashboardListeners() {
        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if(e.target.classList.contains('modal')) {
                e.target.classList.remove('active');
                setTimeout(() => {
                    e.target.style.display = 'none';
                }, 300);
            }
        });
    }
}

// ==================== GLOBAL FUNCTIONS ====================
let dashboardManager;

document.addEventListener('DOMContentLoaded', function() {
    dashboardManager = new DashboardManager();
});

// User management functions
function showAddUserForm() {
    if(dashboardManager) dashboardManager.showAddUserForm();
}

function hideUserForm() {
    if(dashboardManager) dashboardManager.hideUserForm();
}

function saveUser() {
    if(dashboardManager) dashboardManager.saveUser();
}

// System functions
function systemSettings() {
    if(dashboardManager) dashboardManager.systemSettings();
}

function backupSystem() {
    if(dashboardManager) dashboardManager.backupSystem();
}

function viewLogs() {
    if(dashboardManager) dashboardManager.viewLogs();
}

function manageRoles() {
    if(dashboardManager) dashboardManager.manageRoles();
}

// Course functions
function manageCourse(courseId) {
    if(dashboardManager) dashboardManager.manageCourse(courseId);
}

function viewStudents(courseId) {
    if(dashboardManager) dashboardManager.viewStudents(courseId);
}

function addContent(courseId) {
    if(dashboardManager) dashboardManager.addContent(courseId);
}

function addCourse() {
    if(dashboardManager) dashboardManager.addCourse();
}

function assignInstructor(courseId) {
    if(dashboardManager) dashboardManager.assignInstructor(courseId);
}

function scheduleCourse(courseId) {
    if(dashboardManager) dashboardManager.scheduleCourse(courseId);
}

