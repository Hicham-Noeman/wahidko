<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Interests - EduPlatform</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        .category-card {
            background: var(--bg-secondary);
            border: 3px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-base);
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        .category-card.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        }
        .category-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        .category-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        .category-desc {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .selection-info {
            text-align: center;
            padding: 1rem;
            background: var(--bg-primary);
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
        }
        .selection-count {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }
    </style>
</head>
<body class="login-page">
    <div class="login-container" style="max-width: 900px;">
        <div class="login-card" style="padding: 3rem;">
            <div class="logo" style="margin-bottom: 1rem;">🎓 EduPlatform</div>
            <h2>Select Your Learning Interests</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 2rem;">
                Choose 3-6 categories that interest you. We'll recommend courses based on your selections.
            </p>

            <div class="selection-info">
                <div class="selection-count">
                    <span id="selectedCount">0</span> / 6 selected
                </div>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0.5rem;">
                    Minimum: 3 categories • You can change these later in your profile
                </p>
            </div>

            <div class="category-grid" id="categoriesGrid">
                <!-- Will be populated by JavaScript -->
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="skipSelection()">Skip for Now</button>
                <button type="button" id="saveBtn" class="btn btn-primary" onclick="saveCategories()" disabled>Continue</button>
            </div>
        </div>
    </div>

    <script src="../assets/js/app.js"></script>
    <script>
        const categories = [
            {id: 1, icon: '🌐', name: 'Web Development', description: 'HTML, CSS, JavaScript, Frontend & Backend'},
            {id: 2, icon: '📊', name: 'Data Science', description: 'Machine Learning, AI, Data Analysis'},
            {id: 3, icon: '📱', name: 'Mobile Development', description: 'iOS, Android, Cross-platform Apps'},
            {id: 4, icon: '🔒', name: 'Cybersecurity', description: 'Ethical Hacking, Network Security'},
            {id: 5, icon: '☁️', name: 'Cloud Computing', description: 'AWS, Azure, DevOps'},
            {id: 6, icon: '🗄️', name: 'Databases', description: 'SQL, NoSQL, Database Design'},
            {id: 7, icon: '🎨', name: 'UI/UX Design', description: 'User Interface, User Experience'},
            {id: 8, icon: '🎮', name: 'Game Development', description: 'Unity, Unreal Engine, Game Design'},
            {id: 9, icon: '🤖', name: 'Artificial Intelligence', description: 'Machine Learning, Deep Learning'},
            {id: 10, icon: '⛓️', name: 'Blockchain', description: 'Cryptocurrency, Smart Contracts'},
            {id: 11, icon: '📡', name: 'IoT', description: 'Internet of Things, Embedded Systems'},
            {id: 12, icon: '📈', name: 'Digital Marketing', description: 'SEO, Social Media Marketing'}
        ];

        let selectedCategories = [];

        document.addEventListener('DOMContentLoaded', function() {
            renderCategories();
        });

        function renderCategories() {
            const grid = document.getElementById('categoriesGrid');
            grid.innerHTML = categories.map(cat => `
                <div class="category-card" data-id="${cat.id}" onclick="toggleCategory(${cat.id})">
                    <div class="category-icon">${cat.icon}</div>
                    <div class="category-name">${cat.name}</div>
                    <div class="category-desc">${cat.description}</div>
                </div>
            `).join('');
        }

        function toggleCategory(categoryId) {
            const index = selectedCategories.indexOf(categoryId);
            const card = document.querySelector(`[data-id="${categoryId}"]`);
            
            if(index > -1) {
                // Deselect
                selectedCategories.splice(index, 1);
                card.classList.remove('selected');
            } else {
                // Select (max 6)
                if(selectedCategories.length < 6) {
                    selectedCategories.push(categoryId);
                    card.classList.add('selected');
                } else {
                    showNotification('Maximum 6 categories allowed', 'warning');
                    return;
                }
            }

            updateSelectionCount();
        }

        function updateSelectionCount() {
            const count = selectedCategories.length;
            document.getElementById('selectedCount').textContent = count;
            
            // Enable/disable save button
            const saveBtn = document.getElementById('saveBtn');
            if(count >= 3 && count <= 6) {
                saveBtn.disabled = false;
                saveBtn.style.opacity = '1';
            } else {
                saveBtn.disabled = true;
                saveBtn.style.opacity = '0.5';
            }
        }

        async function saveCategories() {
            if(selectedCategories.length < 3) {
                showNotification('Please select at least 3 categories', 'warning');
                return;
            }

            try {
                const currentUser = JSON.parse(localStorage.getItem('currentUser'));
                if(!currentUser) {
                    window.location.href = 'login.php';
                    return;
                }

                // Save to localStorage (in production, save to database)
                currentUser.categories = selectedCategories;
                currentUser.categories_selected = true;
                localStorage.setItem('currentUser', JSON.stringify(currentUser));

                showNotification('Interests saved successfully!', 'success');
                
                // Redirect based on role
                setTimeout(() => {
                    window.location.href = `dashboards/${currentUser.role}.php`;
                }, 1000);
            } catch(error) {
                console.error('Error saving categories:', error);
                showNotification('Failed to save interests', 'error');
            }
        }

        function skipSelection() {
            if(confirm('Skip interest selection? You can set this later in your profile.')) {
                const currentUser = JSON.parse(localStorage.getItem('currentUser'));
                if(currentUser) {
                    currentUser.categories_selected = true;
                    localStorage.setItem('currentUser', JSON.stringify(currentUser));
                    window.location.href = `dashboards/${currentUser.role}.php`;
                } else {
                    window.location.href = 'login.php';
                }
            }
        }
    </script>
</body>
</html>


