<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EduPlatform</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">🎓 EduPlatform</div>
            <nav class="nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="courses.php" class="nav-link">Courses</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="register.php" class="btn btn-success">Register</a>
                <a href="login.php" class="btn btn-primary">Login</a>
            </nav>
        </div>
    </header>

    <!-- Contact Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Header Section -->
            <div class="dashboard-header" style="text-align: center; margin-bottom: 3rem;">
                <h1>Get In Touch</h1>
                <p style="color: var(--text-secondary); margin-top: 1rem;">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">
                <!-- Contact Form -->
                <div class="widget">
                    <div class="widget-header">
                        <h3>Send Us a Message</h3>
                    </div>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Your name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" class="form-control" placeholder="your.email@example.com" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select id="subject" class="form-control" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="course">Course Information</option>
                                <option value="technical">Technical Support</option>
                                <option value="billing">Billing Question</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" class="form-control" rows="6" placeholder="Tell us how we can help you..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <!-- Contact Cards -->
                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="font-size: 2rem;">📧</div>
                            <div>
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Email</h4>
                                <p style="color: var(--text-secondary); margin: 0;">support@eduplatform.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="font-size: 2rem;">📞</div>
                            <div>
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Phone</h4>
                                <p style="color: var(--text-secondary); margin: 0;">+1 (555) 123-4567</p>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="font-size: 2rem;">📍</div>
                            <div>
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Address</h4>
                                <p style="color: var(--text-secondary); margin: 0;">123 Education Street<br>Learning City, ED 12345</p>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="font-size: 2rem;">⏰</div>
                            <div>
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Office Hours</h4>
                                <p style="color: var(--text-secondary); margin: 0;">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Quick Links -->
                    <div class="widget">
                        <div class="widget-header">
                            <h4>Quick Help</h4>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; padding: 0.5rem; border-radius: var(--radius-md); transition: all 0.3s;" onmouseover="this.style.background='var(--bg-primary)'" onmouseout="this.style.background='transparent'">📚 How to Enroll in a Course?</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; padding: 0.5rem; border-radius: var(--radius-md); transition: all 0.3s;" onmouseover="this.style.background='var(--bg-primary)'" onmouseout="this.style.background='transparent'">💳 Payment & Billing</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; padding: 0.5rem; border-radius: var(--radius-md); transition: all 0.3s;" onmouseover="this.style.background='var(--bg-primary)'" onmouseout="this.style.background='transparent'">🎓 Certificate Information</a>
                            <a href="#" style="color: var(--text-secondary); text-decoration: none; padding: 0.5rem; border-radius: var(--radius-md); transition: all 0.3s;" onmouseover="this.style.background='var(--bg-primary)'" onmouseout="this.style.background='transparent'">🔧 Technical Requirements</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div style="text-align: center; padding: 3rem; background: var(--bg-primary); border-radius: var(--radius-xl); margin-top: 3rem;">
                <h3 style="margin-bottom: 1rem; color: var(--text-primary);">Connect With Us</h3>
                <p style="color: var(--text-secondary); margin-bottom: 2rem;">Follow us on social media for updates, tips, and more</p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; font-size: 2rem;">
                    <a href="#" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: white; border-radius: var(--radius-md); transition: all 0.3s; box-shadow: var(--shadow-sm);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform=''; this.style.boxShadow='var(--shadow-sm)'">📘</a>
                    <a href="#" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: white; border-radius: var(--radius-md); transition: all 0.3s; box-shadow: var(--shadow-sm);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform=''; this.style.boxShadow='var(--shadow-sm)'">🐦</a>
                    <a href="#" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: white; border-radius: var(--radius-md); transition: all 0.3s; box-shadow: var(--shadow-sm);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform=''; this.style.boxShadow='var(--shadow-sm)'">📷</a>
                    <a href="#" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: white; border-radius: var(--radius-md); transition: all 0.3s; box-shadow: var(--shadow-sm);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform=''; this.style.boxShadow='var(--shadow-sm)'">💼</a>
                    <a href="#" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: white; border-radius: var(--radius-md); transition: all 0.3s; box-shadow: var(--shadow-sm);" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform=''; this.style.boxShadow='var(--shadow-sm)'">📺</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <div class="logo" style="margin-bottom: 1rem;">🎓 EduPlatform</div>
                    <p style="color: var(--text-secondary);">Your gateway to quality education. Learn anytime, anywhere.</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem;">Quick Links</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="index.php" style="color: var(--text-secondary); text-decoration: none;">Home</a>
                        <a href="courses.php" style="color: var(--text-secondary); text-decoration: none;">Courses</a>
                        <a href="about.php" style="color: var(--text-secondary); text-decoration: none;">About</a>
                        <a href="contact.php" style="color: var(--text-secondary); text-decoration: none;">Contact</a>
                    </div>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem;">Get Started</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="register.php" style="color: var(--text-secondary); text-decoration: none;">Register</a>
                        <a href="login.php" style="color: var(--text-secondary); text-decoration: none;">Login</a>
                    </div>
                </div>
            </div>
            <div style="text-align: center; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <p style="color: var(--text-secondary);">&copy; 2024 EduPlatform. All rights reserved. | Built with ❤️</p>
            </div>
        </div>
    </footer>

    <script src="../assets/js/app.js"></script>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            // In a real application, this would send to a backend
            showNotification('Thank you for contacting us! We will respond within 24 hours.', 'success');
            
            // Reset form
            this.reset();
        });
    </script>
</body>
</html>


