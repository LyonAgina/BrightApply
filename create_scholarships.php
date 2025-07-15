<?php
session_start();
require 'connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug: Show all session data
echo "<!-- DEBUG: Session data: " . print_r($_SESSION, true) . " -->";

// Verify connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug: Test database connection
$test_query = $conn->query("SELECT 1");
if (!$test_query) {
    echo "<!-- DEBUG: Database test failed: " . $conn->error . " -->";
} else {
    echo "<!-- DEBUG: Database connection successful -->";
}

// Verify admin access
if (!isset($_SESSION['id']) || $_SESSION['user_type'] != 'admin') {
    echo "<!-- DEBUG: Admin check failed. ID: " . (isset($_SESSION['id']) ? $_SESSION['id'] : 'not set') . ", Type: " . (isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'not set') . " -->";
    header("Location: login.php");
    exit();
}

// Debug: Show POST data if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<!-- DEBUG: POST data received: " . print_r($_POST, true) . " -->";
    echo "<!-- DEBUG: Form submission detected -->";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_scholarship'])) {
    echo "<!-- DEBUG: Form processing started -->";
    
    // Validate required fields
    $required = ['title', 'description', 'amount', 'type', 'deadline'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $error = "All fields are required! Missing: " . $field;
            echo "<!-- DEBUG: Missing field: $field -->";
            break;
        }
    }
    
    if (!isset($error)) {
        echo "<!-- DEBUG: All required fields present -->";
        
        // Prepare data
        $title = trim($conn->real_escape_string($_POST['title']));
        $description = trim($conn->real_escape_string($_POST['description']));
        $amount = (float)$_POST['amount'];
        $type = trim($conn->real_escape_string($_POST['type']));
        $deadline = trim($conn->real_escape_string($_POST['deadline']));
        $created_by = (int)$_SESSION['id'];
        
        echo "<!-- DEBUG: Data prepared - Title: $title, Amount: $amount, Type: $type, Deadline: $deadline, Created by: $created_by -->";
        
        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $deadline)) {
            $error = "Invalid date format! Use YYYY-MM-DD. Received: " . $deadline;
            echo "<!-- DEBUG: Date validation failed: $deadline -->";
        }
        
        // Validate amount
        if ($amount <= 0) {
            $error = "Amount must be greater than 0";
            echo "<!-- DEBUG: Amount validation failed: $amount -->";
        }
        
        if (!isset($error)) {
            echo "<!-- DEBUG: Validation passed, attempting database insert -->";
            
            // Check if table exists
            $table_check = $conn->query("SHOW TABLES LIKE 'scholarships'");
            if ($table_check->num_rows == 0) {
                $error = "Database table 'scholarships' does not exist!";
                echo "<!-- DEBUG: Table 'scholarships' does not exist -->";
            } else {
                echo "<!-- DEBUG: Table 'scholarships' exists -->";
                
                // Check table structure
                $structure = $conn->query("DESCRIBE scholarships");
                $columns = [];
                while ($row = $structure->fetch_assoc()) {
                    $columns[] = $row['Field'];
                }
                echo "<!-- DEBUG: Table columns: " . implode(', ', $columns) . " -->";
                
                // Use prepared statement
                $sql = "INSERT INTO scholarships (title, description, amount, type, deadline, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
                echo "<!-- DEBUG: SQL query: $sql -->";
                
                $stmt = $conn->prepare($sql);
                
                if ($stmt === false) {
                    $error = "Prepare failed: " . $conn->error;
                    echo "<!-- DEBUG: Prepare statement failed: " . $conn->error . " -->";
                } else {
                    echo "<!-- DEBUG: Statement prepared successfully -->";
                    
                    $stmt->bind_param("ssdssi", $title, $description, $amount, $type, $deadline, $created_by);
                    echo "<!-- DEBUG: Parameters bound -->";
                    
                    if ($stmt->execute()) {
                        $success = "Scholarship created successfully! ID: " . $stmt->insert_id;
                        echo "<!-- DEBUG: Insert successful, ID: " . $stmt->insert_id . " -->";
                        
                        // Clear form variables for display
                        $title = $description = $amount = $type = $deadline = '';
                    } else {
                        $error = "Error creating scholarship: " . $stmt->error;
                        echo "<!-- DEBUG: Execute failed: " . $stmt->error . " -->";
                    }
                    
                    $stmt->close();
                }
            }
        }
    }
    
    // Debug: Log any errors
    if (isset($error)) {
        echo "<!-- DEBUG: Final error: " . $error . " -->";
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<!-- DEBUG: POST received but create_scholarship not set -->";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Scholarships</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">BrightApply</div>
        <nav class="nav-links">
            <span class="username"><?= htmlspecialchars($_SESSION['full_name']) ?></span>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul class="admin-menu">
                <li><a href="user_management.php"><i class="fas fa-users"></i> User Management</a></li>
                <li class="active"><a href="create_scholarships.php"><i class="fas fa-graduation-cap"></i> Create Scholarships</a></li>
                <li><a href="view_application.php"><i class="fas fa-file-alt"></i> View Applications</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Create New Scholarship</h1>
            
            <?php if (isset($success)): ?>
                <div class="alert success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST" class="scholarship-form" onsubmit="console.log('Form submitted'); return true;">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?= isset($title) ? htmlspecialchars($title) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="amount">Amount ($)</label>
                    <input type="number" id="amount" name="amount" min="0.01" step="0.01" value="<?= isset($amount) ? htmlspecialchars($amount) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="type">Scholarship Type</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="academic" <?= (isset($type) && $type === 'academic') ? 'selected' : '' ?>>Academic</option>
                        <option value="needbased" <?= (isset($type) && $type === 'needbased') ? 'selected' : '' ?>>Need-Based</option>
                        <option value="athletic" <?= (isset($type) && $type === 'athletic') ? 'selected' : '' ?>>Athletic</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="deadline">Application Deadline</label>
                    <input type="date" id="deadline" name="deadline" value="<?= isset($deadline) ? htmlspecialchars($deadline) : '' ?>" required>
                </div>
                
                <button type="submit" name="create_scholarship" class="btn-submit" onclick="console.log('Submit button clicked');">
                    <i class="fas fa-save"></i> Create Scholarship
                </button>
            </form>
        </main>
    </div>
    
    <script>
        // Debug JavaScript
        console.log('Page loaded');
        
        // Check if admin.js is interfering
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.scholarship-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submit event fired');
                    console.log('Form data:', new FormData(form));
                });
            }
        });
    </script>
    
    <!-- Only load admin.js if it exists and isn't causing issues -->
    <!-- <script src="admin.js"></script> -->
</body>
</html>