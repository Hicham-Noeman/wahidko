<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - EduPlatform</title>
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

    <!-- About Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Header Section -->
            <div class="dashboard-header" style="text-align: center; margin-bottom: 3rem;">
                <h1>About EduPlatform</h1>
                <p style="color: var(--text-secondary); margin-top: 1rem; max-width: 600px; margin-left: auto; margin-right: auto;">Empowering learners worldwide with quality education accessible anytime, anywhere</p>
            </div>

            <!-- Mission & Vision -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🎯</div>
                    <h3 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Our Mission</h3>
                    <p style="color: var(--text-secondary); text-align: center; line-height: 1.8;">To provide accessible, high-quality education that empowers students to achieve their full potential and succeed in their chosen fields.</p>
                </div>
                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">👁️</div>
                    <h3 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Our Vision</h3>
                    <p style="color: var(--text-secondary); text-align: center; line-height: 1.8;">To be the world's leading online education platform, making learning accessible to everyone, everywhere, at any time.</p>
                </div>
                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">💡</div>
                    <h3 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Our Values</h3>
                    <p style="color: var(--text-secondary); text-align: center; line-height: 1.8;">Excellence, Innovation, Integrity, and Inclusivity drive everything we do in our commitment to education.</p>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="widget" style="margin-bottom: 3rem;">
                <div class="widget-header">
                    <h2>Why Choose EduPlatform?</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <div>
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">📚 Expert Instructors</h4>
                        <p style="color: var(--text-secondary); line-height: 1.6;">Learn from industry professionals with years of experience in their fields.</p>
                    </div>
                    <div>
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">🎓 Accredited Programs</h4>
                        <p style="color: var(--text-secondary); line-height: 1.6;">All our courses are accredited and recognized by leading institutions.</p>
                    </div>
                    <div>
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">⏰ Flexible Learning</h4>
                        <p style="color: var(--text-secondary); line-height: 1.6;">Study at your own pace with 24/7 access to course materials.</p>
                    </div>
                    <div>
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">💬 Interactive Support</h4>
                        <p style="color: var(--text-secondary); line-height: 1.6;">Get help when you need it with our AI assistant and instructor support.</p>
                    </div>
                    <div>
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">📊 Track Progress</h4>
                        <p style="color: var(--text-secondary); line-height: 1.6;">Monitor your learning journey with detailed analytics and insights.</p>
                    </div>
                    <div>
                        <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">🌍 Global Community</h4>
                        <p style="color: var(--text-secondary); line-height: 1.6;">Join thousands of students from around the world in their learning journey.</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="quick-stats" style="margin-bottom: 3rem;">
                <div class="stat-card">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Active Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Expert Instructors</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Available Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
            </div>

            <!-- Our Story -->
            <div class="widget">
                <div class="widget-header">
                    <h2>Our Story</h2>
                </div>
                <div style="line-height: 1.8; color: var(--text-secondary);">
                    <p style="margin-bottom: 1rem;">
                        Founded in 2024, EduPlatform was born from a simple idea: education should be accessible to everyone, regardless of location, schedule, or background. Our founders, a group of educators and technology enthusiasts, saw the potential of online learning to break down barriers and create opportunities.
                    </p>
                    <p style="margin-bottom: 1rem;">
                        What started as a small platform with just a handful of courses has grown into a comprehensive learning ecosystem serving thousands of students worldwide. We've partnered with leading institutions and industry experts to create content that's both academically rigorous and practically relevant.
                    </p>
                    <p>
                        Today, EduPlatform continues to innovate, incorporating the latest technologies like AI-powered learning assistants, interactive simulations, and personalized learning paths. Our commitment remains unchanged: to provide world-class education that transforms lives and careers.
                    </p>
                </div>
            </div>

            <!-- Call to Action -->
            <div style="text-align: center; padding: 3rem; background: var(--primary-gradient); border-radius: var(--radius-xl); color: white; margin-top: 3rem;">
                <h2 style="margin-bottom: 1rem;">Ready to Start Learning?</h2>
                <p style="margin-bottom: 2rem; opacity: 0.9;">Join thousands of students already learning on EduPlatform</p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="register.php" class="btn btn-secondary" style="background: white; color: var(--primary-color);">Register Now</a>
                    <a href="courses.php" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid white;">Browse Courses</a>
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
</body>
</html>


