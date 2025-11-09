<?php
require_once '../php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPlatform - Learn Without Limits</title>
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
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="nav-link">Profile</a>
                    <a href="dashboards/<?php echo $_SESSION['role']; ?>.php" class="btn btn-primary">Dashboard</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-success">Register</a>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="main">
        <section id="home" class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Learn Without Limits</h1>
                    <p>Start your educational journey with our comprehensive learning platform</p>
                    <a href="login.php" class="btn btn-primary">Get Started</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="features">
            <div class="container">
                <h2>Why Choose Our Platform?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">👨‍🎓</div>
                        <h3>For Students</h3>
                        <p>Access courses, track progress, submit assignments, and learn at your own pace with interactive content and real-time feedback</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">👨‍🏫</div>
                        <h3>For Instructors</h3>
                        <p>Create engaging content, manage courses, grade assignments, and communicate with students effectively</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">👨‍💼</div>
                        <h3>For Coordinators</h3>
                        <p>Oversee course management, schedule classes, monitor progress, and ensure quality education delivery</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="features">
            <div class="container">
                <h2>Modern Learning Experience</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📚</div>
                        <h3>Rich Content</h3>
                        <p>Access comprehensive course materials, videos, and interactive resources</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Track Progress</h3>
                        <p>Monitor your learning journey with detailed analytics and insights</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💬</div>
                        <h3>AI Assistant</h3>
                        <p>Get instant help with our intelligent chatbot available 24/7</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include '../php/footer.php'; ?>

    <script src="../assets/js/app.js"></script>
</body>
</html>
