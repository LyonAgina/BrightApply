<?php

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - BrightApply</title>
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
                <li><a href="profile.html" class="login-btn">Back to Profile</a></li>
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
                <li><a href="saved.html"><i class="fas fa-bookmark"></i> Saved</a></li>
                <li><a href="community.html"><i class="fas fa-users"></i> Community</a></li>
                <li class="active"><a href="profile.html"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="profile-header">
                <div class="profile-avatar">
                    <div class="avatar" id="avatar-preview">JD</div>
                    <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                    <button class="edit-avatar" onclick="document.getElementById('avatar-upload').click()">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                <h2>Edit Profile</h2>
            </div>

            <form id="profile-form" class="profile-form">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" value="John" required>
                </div>
                
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" value="Doe" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="john.doe@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="about">About Me</label>
                    <textarea id="about">Computer Science student at State University, graduating in 2026. Interested in AI and machine learning research opportunities.</textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="window.location.href='profile.html'">Cancel</button>
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>

            <div class="education-section">
                <h3>Education</h3>
                <div class="education-form">
                    <div class="form-group">
                        <label for="institution">Institution</label>
                        <input type="text" id="institution" value="State University">
                    </div>
                    
                    <div class="form-group">
                        <label for="degree">Degree</label>
                        <input type="text" id="degree" value="Bachelor of Science in Computer Science">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start-year">Start Year</label>
                            <input type="number" id="start-year" min="1900" max="2099" value="2022">
                        </div>
                        
                        <div class="form-group">
                            <label for="end-year">End Year (Expected)</label>
                            <input type="number" id="end-year" min="1900" max="2099" value="2026">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="gpa">GPA</label>
                        <input type="number" id="gpa" min="0" max="4" step="0.01" value="3.8">
                    </div>
                    
                    <button type="button" class="save-education-btn">Update Education</button>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
?>