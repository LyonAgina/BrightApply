<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process profile update
    require 'process_profile.php';
}

// Get user data
$user_sql = "SELECT u.*, up.* 
            FROM users u
            LEFT JOIN user_profiles up ON u.id = up.user_id
            WHERE u.id = $user_id";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();



// Get applications count
$app_count_sql = "SELECT COUNT(*) as count FROM applications WHERE user_id = $user_id";
$app_count_result = $conn->query($app_count_sql);
$app_count = $app_count_result->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    
    <body>
        <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="scholarships.php">Scholarships</a></li>
                <li><span class="username"><?= htmlspecialchars($_SESSION['full_name']) ?></span></li>
            </ul>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>

    <div class="content-container">
        <aside class="sidebar">
            <ul>
                <li><a href="scholarships.php"><i class="fas fa-award"></i> Scholarships</a></li>
                <li class="applications"><a href="my_applications.php"><i class="fas fa-file-alt"></i> My Applications</a></li>
                <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

    

    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-picture">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture">
                <?php else: ?>
                    <div class="initials"><?= substr($user['full_name'], 0, 1)  ?></div>
                <?php endif; ?>
            </div>
            
            <h2><?= htmlspecialchars($user['full_name']) ?></h2>
            <p><?= htmlspecialchars($user['email']) ?></p>
        
                <div class="stat-item">
                    <span class="stat-number"><?= $app_count ?></span>
                    <span class="stat-label">Applications</span>
                </div>
            </div>
            
        </div>
        
        <div class="profile-content">
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <!-- Personal Information Section -->
                <section id="personal">
                    <h3>Personal Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                        </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" value="<?= htmlspecialchars($user['date_of_birth'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="">Select</option>
                                <option value="male" <?= ($user['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= ($user['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
                                <option value="other" <?= ($user['gender'] ?? '') == 'other' ? 'selected' : '' ?>>Other</option>
                                <option value="prefer_not_to_say" <?= ($user['gender'] ?? '') == 'prefer_not_to_say' ? 'selected' : '' ?>>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" rows="4"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    </div>
                </section>
                
                <!-- Education Section -->
                <section id="education">
                    <h3>Education Information</h3>
                    
                    <div class="form-group">
                        <label>Education Level</label>
                        <select name="education_level">
                            <option value="">Select</option>
                            <option value="high_school" <?= ($user['education_level'] ?? '') == 'high_school' ? 'selected' : '' ?>>High School</option>
                            <option value="undergraduate" <?= ($user['education_level'] ?? '') == 'undergraduate' ? 'selected' : '' ?>>Undergraduate</option>
                            <option value="graduate" <?= ($user['education_level'] ?? '') == 'graduate' ? 'selected' : '' ?>>Graduate</option>
                            <option value="phd" <?= ($user['education_level'] ?? '') == 'phd' ? 'selected' : '' ?>>PhD</option>
                            <option value="other" <?= ($user['education_level'] ?? '') == 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>School Name</label>
                            <input type="text" name="school_name" value="<?= htmlspecialchars($user['school_name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Major/Field of Study</label>
                            <input type="text" name="major" value="<?= htmlspecialchars($user['major'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Graduation Year</label>
                            <input type="number" name="graduation_year" min="1900" max="2100" 
                                   value="<?= htmlspecialchars($user['graduation_year'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>GPA</label>
                            <input type="number" name="gpa" step="0.01" min="0" max="4" 
                                   value="<?= htmlspecialchars($user['gpa'] ?? '') ?>">
                        </div>
                    </div>
                </section>
                
            
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
    
    
</body>
</html>
<?php $conn->close(); ?>