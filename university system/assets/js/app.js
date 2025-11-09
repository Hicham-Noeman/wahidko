// ==================== MODERN UNIVERSITY SYSTEM ====================

class UniversitySystem {
    constructor() {
        this.currentUser = null;
        this.apiBase = '../php/';
        this.init();
    }
    
    init() {
        this.checkSession();
        this.setupEventListeners();
        this.initAnimations();
        this.loadUserInfo();
    }
    
    // ==================== AUTHENTICATION ====================
    async login(email, password) {
        try {
            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('email', email);
            formData.append('password', password);
            
            const response = await fetch(this.apiBase + 'auth.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if(result.success) {
                this.showNotification('Welcome ' + result.name + '!', 'success');
                localStorage.setItem('currentUser', JSON.stringify(result));
                
                setTimeout(() => {
                    // Check if user has selected categories (first login redirect)
                    if(result.role === 'student' && !result.categories_selected) {
                        window.location.href = 'select-categories.php';
                    } else {
                        window.location.href = `dashboards/${result.role}.php`;
                    }
                }, 1000);
            } else {
                this.showNotification(result.message, 'error');
            }
        } catch(error) {
            console.error('Login error:', error);
            this.showNotification('Connection error. Please try again.', 'error');
        }
    }
    
    async logout() {
        try {
            const formData = new FormData();
            formData.append('action', 'logout');
            
            await fetch(this.apiBase + 'auth.php', {
                method: 'POST',
                body: formData
            });
            
            localStorage.removeItem('currentUser');
            this.showNotification('Logged out successfully', 'success');
            setTimeout(() => {
                window.location.href = '../login.php';
            }, 1000);
        } catch(error) {
            console.error('Logout error:', error);
            window.location.href = '../login.php';
        }
    }
    
    async checkSession() {
        try {
            const formData = new FormData();
            formData.append('action', 'check_session');
            
            const response = await fetch(this.apiBase + 'auth.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if(result.success) {
                this.currentUser = result;
            } else {
                // Check if on dashboard page
                if(window.location.pathname.includes('dashboards/')) {
                    window.location.href = '../login.php';
                }
            }
        } catch(error) {
            console.error('Session check error:', error);
        }
    }
    
    // ==================== UI UPDATES ====================
    loadUserInfo() {
        const userInfoEl = document.getElementById('userInfo');
        if(userInfoEl) {
            const userData = localStorage.getItem('currentUser');
            if(userData) {
                const user = JSON.parse(userData);
                userInfoEl.textContent = `Welcome, ${user.name}`;
            }
        }
    }
    
    showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(n => n.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">${this.getNotificationIcon(type)}</span>
                <span class="notification-message">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    getNotificationIcon(type) {
        const icons = {
            success: '✓',
            error: '✗',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || icons.info;
    }
    
    // ==================== ANIMATIONS ====================
    initAnimations() {
        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.card, .widget, .stat-card, .feature-card').forEach(el => {
            observer.observe(el);
        });
        
        // Header scroll effect
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            const header = document.querySelector('.header');
            
            if(header) {
                if(currentScroll > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
            
            lastScroll = currentScroll;
        });
    }
    
    // ==================== EVENT LISTENERS ====================
    setupEventListeners() {
        // Login form
        const loginForm = document.getElementById('loginForm');
        if(loginForm) {
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                this.login(email, password);
            });
        }
        
        // Logout buttons
        const logoutBtns = document.querySelectorAll('[data-logout]');
        logoutBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.logout();
            });
        });
    }
    
    // ==================== CHATBOT ====================
    setupChatbot() {
        const chatInput = document.getElementById('chatInput');
        const sendButton = document.getElementById('sendChat');
        
        if(chatInput) {
            chatInput.addEventListener('keypress', (e) => {
                if(e.key === 'Enter') {
                    e.preventDefault();
                    this.sendMessage();
                }
            });
        }
        
        if(sendButton) {
            sendButton.addEventListener('click', () => this.sendMessage());
        }
    }
    
    sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        
        if(message) {
            this.addMessageToChat('user', message);
            const botResponse = this.getBotResponse(message);
            
            setTimeout(() => {
                this.addMessageToChat('bot', botResponse);
            }, 500);
            
            input.value = '';
        }
    }
    
    addMessageToChat(sender, message) {
        const messagesContainer = document.getElementById('chatMessages');
        if(messagesContainer) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}-message`;
            messageDiv.textContent = message;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
    
    getBotResponse(message) {
        const lowerMessage = message.toLowerCase();
        
        const responses = {
            'hello': 'Hello! How can I help you today?',
            'hi': 'Hi there! What can I do for you?',
            'course': 'We offer Web Development, Data Science, Mobile Development, and more! Check your courses section.',
            'schedule': 'You can find your schedule in the Schedule section on your dashboard.',
            'grade': 'Your grades are available in the Grades section.',
            'assignment': 'Check the Assignments section to see your pending tasks.',
            'help': 'I can help you with courses, schedules, grades, and assignments. What would you like to know?',
            'thanks': 'You\'re welcome! Feel free to ask if you need anything else.',
            'bye': 'Goodbye! Have a great day!'
        };
        
        for(const [key, response] of Object.entries(responses)) {
            if(lowerMessage.includes(key)) {
                return response;
            }
        }
        
        return 'I understand your message: "' + message + '". How can I assist you further?';
    }
    
    // ==================== MODAL MANAGEMENT ====================
    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if(modal) {
            modal.classList.add('active');
            modal.style.display = 'flex';
        }
    }
    
    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if(modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }
    
    // ==================== UTILITY FUNCTIONS ====================
    showLoader() {
        const loader = document.createElement('div');
        loader.id = 'globalLoader';
        loader.className = 'spinner';
        loader.style.position = 'fixed';
        loader.style.top = '50%';
        loader.style.left = '50%';
        loader.style.transform = 'translate(-50%, -50%)';
        loader.style.zIndex = '9999';
        document.body.appendChild(loader);
    }
    
    hideLoader() {
        const loader = document.getElementById('globalLoader');
        if(loader) {
            loader.remove();
        }
    }
}

// ==================== GLOBAL FUNCTIONS ====================
let universitySystem;

document.addEventListener('DOMContentLoaded', function() {
    universitySystem = new UniversitySystem();
    universitySystem.setupChatbot();
});

// Global logout function
function logout() {
    if(universitySystem) {
        universitySystem.logout();
    }
}

// Global modal functions
function openModal(modalId) {
    if(universitySystem) {
        universitySystem.openModal(modalId);
    }
}

function closeModal(modalId) {
    if(universitySystem) {
        universitySystem.closeModal(modalId);
    }
}

// Chatbot functions
function sendMessage() {
    if(universitySystem) {
        universitySystem.sendMessage();
    }
}

// Show notification helper
function showNotification(message, type = 'info') {
    if(universitySystem) {
        universitySystem.showNotification(message, type);
    }
}

