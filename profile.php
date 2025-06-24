<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process profile update
    require 'process_profile.php';
}

// Get user data
$user_sql = "SELECT u., up. 
            FROM users u
            LEFT JOIN user_profiles up ON u.id = up.user_id
            WHERE u.id = $user_id";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Get saved scholarships count
$saved_count_sql = "SELECT COUNT(*) as count FROM saved_scholarships WHERE user_id = $user_id";
$saved_count_result = $conn->query($saved_count_sql);
$saved_count = $saved_count_result->fetch_assoc()['count'];

// Get applications count
$app_count_sql = "SELECT COUNT(*) as count FROM applications WHERE user_id = $user_id";
$app_count_result = $conn->query($app_count_sql);
$app_count = $app_count_result->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-picture">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture">
                <?php else: ?>
                    <div class="initials"><?= substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1) ?></div>
                <?php endif; ?>
            </div>
            
            <h2><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h2>
            <p><?= htmlspecialchars($user['email']) ?></p>
            
            <div class="stats">
                <div class="stat-item">
                    <span class="stat-number"><?= $saved_count ?></span>
                    <span class="stat-label">Saved</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $app_count ?></span>
                    <span class="stat-label">Applications</span>
                </div>
            </div>
            
            <nav class="profile-nav">
                <a href="#personal" class="active">Personal Info</a>
                <a href="#education">Education</a>
                <a href="#documents">Documents</a>
                <a href="#social">Social Links</a>
                <a href="#security">Security</a>
            </nav>
        </div>
        
        <div class="profile-content">
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <!-- Personal Information Section -->
                <section id="personal">
                    <h3>Personal Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" name="profile_picture" accept="image/*">
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
                
                <!-- Documents Section -->
                <section id="documents">
                    <h3>Documents</h3>
                    
                    <div class="form-group">
                        <label>Resume/CV</label>
                        <?php if (!empty($user['resume'])): ?>
                            <p>Current file: <a href="uploads/<?= htmlspecialchars($user['resume']) ?>" target="_blank">Download</a></p>
                        <?php endif; ?>
                        <input type="file" name="resume" accept=".pdf,.doc,.docx">
                    </div>
                </section>
                
                <!-- Social Links Section -->
                <section id="social">
                    <h3>Social Links</h3>
                    
                    <div class="form-group">
                        <label>LinkedIn URL</label>
                        <input type="url" name="linkedin_url" value="<?= htmlspecialchars($user['linkedin_url'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Twitter URL</label>
                        <input type="url" name="twitter_url" value="<?= htmlspecialchars($user['twitter_url'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Personal Website</label>
                        <input type="url" name="website_url" value="<?= htmlspecialchars($user['website_url'] ?? '') ?>">
                    </div>
                </section>
                
                <!-- Security Section -->
                <section id="security">
                    <h3>Security</h3>
                    
                    <div class="form-group">
                        <label>Current Password (required for email/password changes)</label>
                        <input type="password" name="current_password">
                    </div>
                    
                    <div class="form-group">
                        <label>New Email</label>
                        <input type="email" name="new_email" value="<?= htmlspecialchars($user['email']) ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password">
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password">
                        </div>
                    </div>
                </section>
                
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>