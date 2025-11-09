<?php
/**
 * Reusable Footer Component
 * Include this file in any page to display the footer
 * Usage: include '../php/footer.php';
 */
?>

<footer class="footer">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            <!-- About Section -->
            <div>
                <div class="logo" style="margin-bottom: 1rem;">🎓 EduPlatform</div>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    Your gateway to quality education. Learn anytime, anywhere with our comprehensive online learning platform.
                </p>
                <div style="margin-top: 1rem;">
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">
                        <strong>Email:</strong> support@eduplatform.com<br>
                        <strong>Phone:</strong> +1 (555) 123-4567
                    </p>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 style="margin-bottom: 1rem; color: var(--text-primary);">Quick Links</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php" style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">🏠 Home</a>
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>courses.php" style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">📚 Courses</a>
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>about.php" style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">ℹ️ About Us</a>
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>contact.php" style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">📧 Contact</a>
                </div>
            </div>
            
            <!-- Account Links -->
            <div>
                <h4 style="margin-bottom: 1rem; color: var(--text-primary);">Get Started</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>register.php" style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">✍️ Register</a>
                    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>login.php" style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">🔐 Login</a>
                </div>
            </div>
            
            <!-- Social Media & Additional Info -->
            <div>
                <h4 style="margin-bottom: 1rem; color: var(--text-primary);">Connect With Us</h4>
                <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem;">
                    <a href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--bg-primary); border-radius: var(--radius-md); transition: all 0.3s; font-size: 1.25rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='var(--primary-color)'" onmouseout="this.style.transform=''; this.style.background='var(--bg-primary)'">📘</a>
                    <a href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--bg-primary); border-radius: var(--radius-md); transition: all 0.3s; font-size: 1.25rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='var(--primary-color)'" onmouseout="this.style.transform=''; this.style.background='var(--bg-primary)'">🐦</a>
                    <a href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--bg-primary); border-radius: var(--radius-md); transition: all 0.3s; font-size: 1.25rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='var(--primary-color)'" onmouseout="this.style.transform=''; this.style.background='var(--bg-primary)'">📷</a>
                    <a href="#" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--bg-primary); border-radius: var(--radius-md); transition: all 0.3s; font-size: 1.25rem;" onmouseover="this.style.transform='translateY(-3px)'; this.style.background='var(--primary-color)'" onmouseout="this.style.transform=''; this.style.background='var(--bg-primary)'">💼</a>
                </div>
                <p style="color: var(--text-secondary); font-size: 0.875rem;">
                    Follow us for updates, tips, and educational content.
                </p>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div style="text-align: center; padding-top: 2rem; border-top: 1px solid var(--border-color);">
            <p style="color: var(--text-secondary); margin-bottom: 0.5rem;">
                &copy; <?php echo date('Y'); ?> EduPlatform. All rights reserved.
            </p>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">
                <a href="#" style="color: var(--text-secondary); text-decoration: none; margin: 0 0.5rem;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">Privacy Policy</a> |
                <a href="#" style="color: var(--text-secondary); text-decoration: none; margin: 0 0.5rem;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">Terms of Service</a> |
                <a href="#" style="color: var(--text-secondary); text-decoration: none; margin: 0 0.5rem;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">Cookie Policy</a>
            </p>
            <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 1rem;">
                Built with ❤️ using modern web technologies
            </p>
        </div>
    </div>
</footer>

