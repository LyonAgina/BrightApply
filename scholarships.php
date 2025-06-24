<?php

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarships - BrightApply</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="scholarships.html" class="active">Scholarships</a></li>
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
                <li class="active"><a href="scholarships.html"><i class="fas fa-award"></i> Scholarships</a></li>
                <li><a href="saved.html"><i class="fas fa-bookmark"></i> Saved</a></li>
                <li><a href="community.html"><i class="fas fa-users"></i> Community</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2>Available Scholarships</h2>
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
                <div class="scholarship-card">
                    <h3>Academic Excellence Scholarship</h3>
                    <p class="deadline">Deadline: June 30, 2025</p>
                    <p class="amount">$5,000</p>
                    <div class="scholarship-actions">
                        <button class="save-btn"><i class="far fa-bookmark"></i> Save</button>
                        <button class="apply-btn">Apply</button>
                    </div>
                </div>
                
                <div class="scholarship-card">
                    <h3>STEM Innovation Award</h3>
                    <p class="deadline">Deadline: July 15, 2025</p>
                    <p class="amount">$7,500</p>
                    <div class="scholarship-actions">
                        <button class="save-btn"><i class="far fa-bookmark"></i> Save</button>
                        <button class="apply-btn">Apply</button>
                    </div>
                </div>
                
                <!-- More scholarship cards would go here -->
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
?>