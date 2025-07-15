<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['scholarship_id'])) {
    header("Location: scholarships.php");
    exit();
}

$scholarship_id = (int)$_GET['scholarship_id'];
$user_id = $_SESSION['id'];

// Check if scholarship exists
$scholarship_sql = "SELECT * FROM scholarships WHERE id = $scholarship_id";
$scholarship_result = $conn->query($scholarship_sql);

if ($scholarship_result->num_rows === 0) {
    header("Location: scholarships.php");
    exit();
}

$scholarship = $scholarship_result->fetch_assoc();
$success = $error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $essay = $conn->real_escape_string($_POST['essay']);
    $status = 'pending';
    
    // Check if already applied (remove this check if you want multiple applications)
    $check_sql = "SELECT * FROM applications WHERE user_id = $user_id AND scholarship_id = $scholarship_id";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        $error = "You've already applied for this scholarship.";
    } else {
        $insert_sql = "INSERT INTO applications (user_id, scholarship_id, essay, status, applied_at)
                      VALUES ($user_id, $scholarship_id, '$essay', '$status', NOW())";
        
        if ($conn->query($insert_sql)) {
            $success = "Application submitted successfully!";
            // Clear form on success
            $_POST['essay'] = '';
        } else {
            $error = "Error submitting application. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?= htmlspecialchars($scholarship['title']) ?> | BrightApply</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="scholarships.php">Scholarships</a></li>
                <li><a href="profile.php" class="login-btn">Profile</a></li>
            </ul>
        </nav>
    </header>

    <div class="content-container">
        <aside class="sidebar">
            <ul>
                <li><a href="scholarships.php"><i class="fas fa-award"></i> Scholarships</a></li>
                <li><a href="saved.php"><i class="fas fa-bookmark"></i> Saved</a></li>
                <li class="active"><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="application-container">
                <h1>Apply for: <?= htmlspecialchars($scholarship['title']) ?></h1>
                
                <div class="scholarship-info">
                    <p><strong>Amount:</strong> $<?= number_format($scholarship['amount'], 2) ?></p>
                    <p><strong>Deadline:</strong> <?= date('F j, Y', strtotime($scholarship['deadline'])) ?></p>
                </div>

                <?php if ($success): ?>
                    <div class="success-message">
                        <?= $success ?>
                        <p>You can <a href="scholarships.php">browse more scholarships</a> or <a href="my_applications.php">view your applications</a>.</p>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="error-message"><?= $error ?></div>
                <?php endif; ?>

                <?php if (empty($success)): ?>
                <form method="POST" action="" class="application-form">
                    <div class="form-group">
                        <label for="essay">Application Essay *</label>
                        <textarea id="essay" name="essay" rows="8" required><?= isset($_POST['essay']) ? htmlspecialchars($_POST['essay']) : '' ?></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Submit Application</button>
                </form>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>