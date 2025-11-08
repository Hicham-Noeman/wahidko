
// Education Platform - Complete User Management System
console.log('Education Platform Script Loaded');

// Demo users data for login
const demoUsers = {
    student: { email: "student@edu.com", password: "123456", name: "John Student" },
    instructor: { email: "instructor@edu.com", password: "123456", name: "Dr. Smith" },
    admin: { email: "admin@edu.com", password: "123456", name: "System Admin" },
    coordinator: { email: "coordinator@edu.com", password: "123456", name: "Coordinator Alex" }
};

// User management system
let users = [
    { id: 'U001', name: 'John Student', email: 'student@edu.com', role: 'student' },
    { id: 'U002', name: 'Dr. Smith', email: 'instructor@edu.com', role: 'instructor' },
    { id: 'U003', name: 'Coordinator Alex', email: 'coordinator@edu.com', role: 'coordinator' },
    { id: 'U004', name: 'System Admin', email: 'admin@edu.com', role: 'admin' }
];

// Handle login form
document.addEventListener('DOMContentLoaded', function() {
    var loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            
            if (!email || !password) {
                alert('Please fill all fields');
                return;
            }
            
            var userFound = false;
            var userType = '';
            
            for (var type in demoUsers) {
                var user = demoUsers[type];
                if (user.email === email && user.password === password) {
                    userFound = true;
                    userType = type;
                    break;
                }
            }
            
            if (userFound) {
                localStorage.setItem('currentUser', JSON.stringify(demoUsers[userType]));
                localStorage.setItem('userType', userType);
                window.location.href = userType + '-dashboard.html';
            } else {
                alert('Invalid email or password');
            }
        });
    }
    
    // Load user info
    var userInfo = document.getElementById('userInfo');
    if (userInfo) {
        var userData = localStorage.getItem('currentUser');
        var userType = localStorage.getItem('userType');
        if (userData && userType) {
            var user = JSON.parse(userData);
            userInfo.textContent = 'Welcome, ' + user.name + ' (' + userType + ')';
        }
    }
    
    // Setup chatbot
    setupChatInput();
    
    // Initialize users table in admin dashboard
    displayUsers();
});

// Logout function
function logout() {
    localStorage.removeItem('currentUser');
    localStorage.removeItem('userType');
    window.location.href = 'login.html';
}

// Show notification
function showNotification(message) {
    alert(message);
}

/// ===== USER MANAGEMENT SYSTEM =====
function displayUsers() {
    const tableBody = document.getElementById('usersTableBody');
    if (tableBody) {
        tableBody.innerHTML = '';
        
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="padding: 1rem; border-bottom: 1px solid #eee;">${user.id}</td>
                <td style="padding: 1rem; border-bottom: 1px solid #eee;">${user.name}</td>
                <td style="padding: 1rem; border-bottom: 1px solid #eee;">${user.email}</td>
                <td style="padding: 1rem; border-bottom: 1px solid #eee;">
                    <span class="role-badge ${user.role}">${user.role}</span>
                </td>
                <td style="padding: 1rem; border-bottom: 1px solid #eee;">
                    <button class="btn btn-primary btn-sm" onclick="showEditUserForm('${user.id}')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser('${user.id}')">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
}

function showAddUserForm() {
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userId').value = '';
    document.getElementById('userName').value = '';
    document.getElementById('userEmail').value = '';
    document.getElementById('userRole').value = 'student';
    document.getElementById('userForm').style.display = 'block';
}

function showEditUserForm(userId) {
    const user = users.find(u => u.id === userId);
    if (user) {
        document.getElementById('modalTitle').textContent = 'Edit User';
        document.getElementById('userId').value = user.id;
        document.getElementById('userName').value = user.name;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('userRole').value = user.role;
        document.getElementById('userForm').style.display = 'block';
    }
}

function hideUserForm() {
    document.getElementById('userForm').style.display = 'none';
}

function saveUser() {
    const id = document.getElementById('userId').value;
    const name = document.getElementById('userName').value;
    const email = document.getElementById('userEmail').value;
    const role = document.getElementById('userRole').value;
    
    if (!name || !email) {
        alert('Please fill all fields');
        return;
    }
    
    if (id) {
        // Edit existing user
        const userIndex = users.findIndex(u => u.id === id);
        if (userIndex !== -1) {
            users[userIndex] = { id, name, email, role };
            showNotification('✅ User updated successfully: ' + name);
        }
    } else {
        // Add new user
        const newId = 'U' + (users.length + 1).toString().padStart(3, '0');
        users.push({ id: newId, name, email, role });
        showNotification('✅ User added successfully: ' + name);
    }
    
    displayUsers();
    hideUserForm();
}

function deleteUser(userId) {
    const user = users.find(u => u.id === userId);
    if (user) {
        if (confirm(`⚠️ Are you sure you want to delete user: ${user.name}?`)) {
            users = users.filter(u => u.id !== userId);
            displayUsers();
            showNotification('🗑️ User deleted: ' + user.name);
        }
    }
}

// ===== ADMIN DASHBOARD FUNCTIONS =====
function systemSettings() {
    showNotification('⚙️ Opening system settings...');
}

function backupSystem() {
    showNotification('💾 Starting system backup...');
}

function viewLogs() {
    showNotification('📊 Displaying system logs...');
}

function manageRoles() {
    showNotification('👥 Managing user roles...');
}

// ===== CHATBOT FUNCTIONS =====
function sendMessage() {
    var input = document.getElementById('chatInput');
    var message = input.value.trim();
    
    if (message) {
        addMessageToChat('user', message);
        
        var botResponse = getBotResponse(message);
        
        setTimeout(function() {
            addMessageToChat('bot', botResponse);
        }, 500);
        
        input.value = '';
    }
}

function addMessageToChat(sender, message) {
    var messages = document.getElementById('chatMessages');
    if (messages) {
        var messageDiv = document.createElement('div');
        
        if (sender === 'user') {
            messageDiv.className = 'message user-message';
            messageDiv.textContent = 'You: ' + message;
        } else {
            messageDiv.className = 'message bot-message';
            messageDiv.textContent = 'Bot: ' + message;
        }
        
        messages.appendChild(messageDiv);
        messages.scrollTop = messages.scrollHeight;
    }
}


function getBotResponse(message) {
    var lowerMessage = message.toLowerCase();
    
    if (lowerMessage.includes('hello') || lowerMessage.includes('hi')) {
        return 'Hello! How can I help you today?';
    }
    if (lowerMessage.includes('course')) {
        return 'We offer Web Development, Data Science, and more!';
    }
    if (lowerMessage.includes('elaf')) {
        return 'i love her!';
    }
    if (lowerMessage.includes('schedule')) {
        return 'Check your schedule in the Schedule section.';
    }
    if (lowerMessage.includes('grade')) {
        return 'Your grades are in the Grades section.';
    }
    
    return 'I understand: ' + message + '. How can I assist you?';
}

function setupChatInput() {
    var chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendMessage();
            }
        });
    }
}

// Other dashboard functions...
function manageCourse(courseId) { showNotification('Manage: ' + courseId); }
function viewStudents(courseId) { showNotification('View students: ' + courseId); }
function addContent(courseId) { showNotification('Add content: ' + courseId); }
function addCourse() { showNotification('Add new course'); }
function assignInstructor(courseId) { showNotification('Assign instructor: ' + courseId); }
function scheduleCourse(courseId) { showNotification('Schedule: ' + courseId); }

// دالة تسجيل الدخول
async function loginUser(email, password) {
    try {
        const formData = new FormData();
        formData.append('action', 'login');
        formData.append('email', email);
        formData.append('password', password);
        
        const response = await fetch('login.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if(result.success) {
            localStorage.setItem('userRole', result.role);
            window.location.href = result.role + '-dashboard.html';
        } else {
            alert(result.message);
        }
    } catch(error) {
        console.error('Error:', error);
        alert('خطأ في الاتصال');
    }
}

// ربط مع صفحة login.html
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if(loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            loginUser(email, password);
        });
    }
});

// دوال رفع الملفات
async function uploadFile(courseCode, fileName, fileType) {
    try {
        const formData = new FormData();
        formData.append('action', 'upload_file');
        formData.append('course_code', courseCode);
        formData.append('file_name', fileName);
        formData.append('file_type', fileType);
        
        const response = await fetch('php/upload.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if(result.success) {
            alert(result.message);
            return result.file;
        } else {
            alert(result.message);
            return null;
        }
    } catch(error) {
        console.error('Error:', error);
        alert('❌ خطأ في رفع الملف');
        return null;
    }
}

async function getCourseFiles(courseCode) {
    try {
        const formData = new FormData();
        formData.append('action', 'get_files');
        formData.append('course_code', courseCode);
        
        const response = await fetch('php/upload.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if(result.success) {
            return result.files;
        } else {
            console.error(result.message);
            return [];
        }
    } catch(error) {
        console.error('Error:', error);
        return [];
    }
}