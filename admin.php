<?php
session_start();
require 'connection.php';

// Check if user is admin
if (!isset($_SESSION['id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle user updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $user_type = $conn->real_escape_string($_POST['user_type']);
    
    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', user_type = '$user_type' WHERE id = $id";
    $conn->query($sql);
}

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where = $search ? "WHERE full_name LIKE '%$search%' OR email LIKE '%$search%'" : '';

// Get all users
$users_sql = "SELECT id, full_name, email, user_type FROM users $where";
$users_result = $conn->query($users_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">BrightApply</div>
        <nav class="nav-links">
            <span class="username">Admin User</span>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <ul class="admin-menu">
                <li><a href="user_management.php"><i class="fas fa-users"></i> User Management</a></li>
                <li><a href="create_scholarships.php"><i class="fas fa-graduation-cap"></i> Create Scholarships</a></li>
                <li class="active"><a href="view_application.php"><i class="fas fa-file-alt"></i> View Applications</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Welcome, Admin User</h1>
            <p>Select an option from the sidebar to get started.</p>
            
            </div>
        </main>
    </div>
    
    <script src="admin.js"></script>
</body>
</html>