<?php
// index.php
session_start();
require 'connection.php';
require 'functions.php';

// Get featured scholarships (limit to 2 on homepage to match your current design)
$featured_scholarships = displayScholarships(2);
$total_scholarships = getScholarshipCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Platform</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="scholarships.php">Scholarships</a></li>
                <li><a href="login.php" class="login-btn">Login/Signup</a></li>


            </ul>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Find the Right Scholarship</h1>
            <div class="features">
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Verified Listings</span>
                </div>
                <div class="feature">
                    <i class="fas fa-users"></i>
                    <span>Student Networking</span>
                </div>
                <div class="feature">
                    <i class="fas fa-equals"></i>
                    <span>Equal Access</span>
                </div>
            </div>
        </section>

        <div class="content-container">
            <aside class="sidebar">
                <ul>
                    <li><a href="scholarships.php" class="sidebar-link"><i class="fas fa-award"></i> Scholarships</a></li>
                    <li class="applications"><a href="my_applications.php"><i class="fas fa-file-alt"></i> My Applications</a></li>
                    <li><a href="profile.php" class="sidebar-link"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </aside>

            <section class="main-content">
                <div class="content-header">
                    <h2>Scholarships</h2>
                    <div class="sort-options">
                        <select>
                            <option>Sort</option>
                            <option>Newest</option>
                            <option>Deadline</option>
                            <option>Amount</option>
                        </select>
                        <select>
                            <option>Type</option>
                            <option>Academic</option>
                            <option>Athletic</option>
                            <option>Need-based</option>
                        </select>
                    </div>
                </div>

                <div class="scholarship-list">
                    <?php if (empty($featured_scholarships)): ?>
                        <p>No featured scholarships available at this time.</p>
                    <?php else: ?>
                        <?php foreach ($featured_scholarships as $scholarship): ?>
                            <?php renderScholarshipCard($scholarship, false, false); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>