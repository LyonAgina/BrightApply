
<?php
// Start session and include database connection
session_start();
require 'connection.php';

// Redirect to login if not admin
if (!isset($_SESSION['id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Query: Get all applications with related user and scholarship info
$applications_sql = "SELECT a.*, u.full_name as user_name, u.email, s.title as scholarship_title 
                    FROM applications a
                    JOIN users u ON a.user_id = u.id
                    JOIN scholarships s ON a.scholarship_id = s.id
                    ORDER BY a.application_date DESC";
$applications_result = $conn->query($applications_sql);

// Query: Get application counts by status (pending, approved, rejected)
$status_counts_sql = "SELECT status, COUNT(*) as count FROM applications GROUP BY status";
$status_counts_result = $conn->query($status_counts_sql);
$status_counts = [];
while ($row = $status_counts_result->fetch_assoc()) {
    $status_counts[$row['status']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <!-- Navigation bar with logo and user info -->
    <header class="navbar">
        <div class="logo">BrightApply</div>
        <nav class="nav-links">
            <span class="username"><?= htmlspecialchars($_SESSION['full_name']) ?></span>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>


    <div class="dashboard-container">
        <!-- Sidebar navigation for admin pages -->
        <aside class="sidebar">
            <ul class="admin-menu">
                <li><a href="user_management.php"><i class="fas fa-users"></i> User Management</a></li>
                <li><a href="create_scholarships.php"><i class="fas fa-graduation-cap"></i> Create Scholarships</a></li>
                <li class="active"><a href="view_applications.php"><i class="fas fa-file-alt"></i> View Applications</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Scholarship Applications</h1>
            
            <!-- Status summary cards for quick stats -->
            <div class="status-summary">
                <div class="status-card pending">
                    <h3>Pending</h3>
                    <p><?= $status_counts['pending'] ?? 0 ?></p>
                </div>
                <div class="status-card approved">
                    <h3>Approved</h3>
                    <p><?= $status_counts['approved'] ?? 0 ?></p>
                </div>
                <div class="status-card rejected">
                    <h3>Rejected</h3>
                    <p><?= $status_counts['rejected'] ?? 0 ?></p>
                </div>
            </div>
            
            <!-- Filter form for applications by status and scholarship -->
            <div class="application-filters">
                <form method="GET" class="filter-form">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="all">All Applications</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="scholarship">Scholarship</label>
                        <select id="scholarship" name="scholarship">
                            <option value="all">All Scholarships</option>
                            <?php
                            // Populate scholarship dropdown from DB
                            $scholarships_sql = "SELECT id, title FROM scholarships";
                            $scholarships_result = $conn->query($scholarships_sql);
                            while ($scholarship = $scholarships_result->fetch_assoc()): ?>
                                <option value="<?= $scholarship['id'] ?>"><?= htmlspecialchars($scholarship['title']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">Filter</button>
                </form>
            </div>
            
            <!-- Applications table listing all results -->
            <div class="applications-list">
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Applicant</th>
                            <th>Scholarship</th>
                            <th>Submitted</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($applications_result->num_rows > 0): ?>
                            <?php while ($application = $applications_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $application['id'] ?></td>
                                    <td>
                                        <div class="applicant-info">
                                            <strong><?= htmlspecialchars($application['user_name']) ?></strong>
                                            <small><?= $application['email'] ?></small>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($application['scholarship_title']) ?></td>
                                    <td><?= date('M d, Y', strtotime($application['application_date'])) ?></td>
                                    <td>
                                        <!-- Status badge for application -->
                                        <span class="status-badge <?= $application['status'] ?>">
                                            <?= ucfirst($application['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No applications found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Admin dashboard JS for interactivity -->
    <script src="admin.js"></script>
</body>
</html>