<?php

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved - Scholarship Platform</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="scholarships.html">Scholarships</a></li>
                <li><a href="community.html">Community</a></li>
                <li><a href="login.html" class="login-btn">Login/Signup</a></li>
            </ul>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>

    <div class="content-container">
        <aside class="sidebar">
            <ul>
                <li><a href="scholarships.html"><i class="fas fa-award"></i> Scholarships</a></li>
                <li class="active"><a href="saved.html"><i class="fas fa-bookmark"></i> Saved</a></li>
                <li><a href="community.html"><i class="fas fa-users"></i> Community</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2>Your Saved Scholarships</h2>
                <div class="filter-options">
                    <select>
                        <option>All</option>
                        <option>Applied</option>
                        <option>Not Applied</option>
                    </select>
                </div>
            </div>

            <div class="saved-list">
                <div class="saved-item">
                    <div class="saved-info">
                        <h3>Academic Excellence Scholarship</h3>
                        <p class="deadline">Deadline: June 30, 2025</p>
                        <p class="status applied"><i class="fas fa-check-circle"></i> Applied</p>
                    </div>
                    <div class="saved-actions">
                        <button class="remove-btn"><i class="far fa-trash-alt"></i> Remove</button>
                        <button class="view-btn">View Details</button>
                    </div>
                </div>
                
                <div class="saved-item">
                    <div class="saved-info">
                        <h3>STEM Innovation Award</h3>
                        <p class="deadline">Deadline: July 15, 2025</p>
                        <p class="status not-applied"><i class="far fa-clock"></i> Not Applied</p>
                    </div>
                    <div class="saved-actions">
                        <button class="remove-btn"><i class="far fa-trash-alt"></i> Remove</button>
                        <button class="apply-btn">Apply Now</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
?>