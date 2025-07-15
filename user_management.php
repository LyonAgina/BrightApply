<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $user_type = $conn->real_escape_string($_POST['user_type']);
    
    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', user_type = '$user_type' WHERE id = $id";
    $conn->query($sql);
}

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where = $search ? "WHERE full_name LIKE '%$search%' OR email LIKE '%$search%'" : '';

$users_sql = "SELECT id, full_name, email, user_type FROM users $where";
$users_result = $conn->query($users_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                <li class="active"><a href="user_management.php"><i class="fas fa-users"></i> User Management</a></li>
                <li><a href="create_scholarships.php"><i class="fas fa-graduation-cap"></i> Create Scholarships</a></li>
                <li><a href="view_application.php"><i class="fas fa-file-alt"></i> View Applications</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>User Management</h1>
            
            <div class="admin-actions">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search users..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
            
            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($users_result->num_rows > 0): ?>
                            <?php while ($user = $users_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td>
                                        <form method="POST" class="inline-form">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>">
                                    </td>
                                    <td>
                                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                                    </td>
                                    <td>
                                            <select name="user_type">
                                                <option value="user" <?= $user['user_type'] == 'user' ? 'selected' : '' ?>>User</option>
                                                <option value="admin" <?= $user['user_type'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            </select>
                                            <button type="submit" name="update_user" class="btn-update"><i class="fas fa-save"></i> Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Actions can be added here -->
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="admin.js"></script>
</body>
</html>