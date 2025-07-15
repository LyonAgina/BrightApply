<?php
session_start();
require 'connection.php';
require 'functions.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$applications_sql = "SELECT a.*, s.title as scholarship_title, u.full_name
                    FROM applications a
                    JOIN scholarships s ON a.scholarship_id = s.id
                    JOIN users u ON a.user_id = u.id
                    WHERE a.user_id = $user_id
                    ORDER BY a.application_date DESC";
$applications_result = $conn->query($applications_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - BrightApply</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>

<style>
.table-container {
    margin: 2rem 0;
    background: var(--white);
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Responsive Wrapper */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Applications Table */
.applications-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
    min-width: 600px;
}

.applications-table th {
    background-color: var(--primary-color);
    color: white;
    text-align: left;
    padding: 1rem;
    font-weight: 600;
    position: sticky;
    top: 0;
}

.applications-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.applications-table tr:last-child td {
    border-bottom: none;
}

.applications-table tr:hover {
    background-color: var(--secondary-color);
}

/* Status Badges */
.status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-badge.pending {
    background-color: #e6f3ff;
    color: #0062cc;
    border: 1px solid #b3d7ff;
}

.status-badge.approved {
    background-color: #e6ffed;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-badge.rejected {
    background-color: #ffe6e6;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.status-badge.under_review {
    background-color: #fffae6;
    color: #856404;
    border: 1px solid #ffeeba;
}

/* No Applications Message */
.no-applications {
    text-align: center;
    padding: 2rem;
    color: var(--light-text);
    font-style: italic;
}

/* Applications Page Sidebar */
.applications-sidebar li.active {
    background-color: #e6f3ff;
    border-left: 4px solid var(--primary-color);
}

/* Responsive Table */
@media (max-width: 768px) {
    .applications-table {
        display: block;
        min-width: auto;
    }
    
    .applications-table thead {
        display: none;
    }
    
    .applications-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }
    
    .applications-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px dotted var(--border-color);
    }
    
    .applications-table td::before {
        content: attr(data-label);
        font-weight: bold;
        margin-right: 1rem;
        flex: 1;
        color: var(--primary-color);
    }
    
    .applications-table td:last-child {
        border-bottom: none;
    }
    
    .status-badge {
        padding: 0.3rem 0.6rem;
    }
    
    .applications-sidebar {
        width: 100%;
    }
}

/* Mobile Menu for Applications Page */
@media (max-width: 768px) {
    .applications-sidebar {
        position: fixed;
        left: -250px;
        transition: left 0.3s ease;
        z-index: 1000;
        height: calc(100vh - 60px);
    }
    
    .applications-sidebar.active {
        left: 0;
    }
    
    .applications-main-content {
        margin-left: 0;
        width: 100%;
    }
}
</style>
<body>
    <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="scholarships.php">Scholarships</a></li>
                <li><span class="username"><?= htmlspecialchars($_SESSION['full_name'] ?? 'User') ?></span></li>
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
                <li class="active"><a href="my_applications.php"><i class="fas fa-file-alt"></i> My Applications</a></li>
                <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>My Scholarship Applications</h1>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="applications-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Scholarship</th>
                                <th>Submitted Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($applications_result->num_rows > 0): ?>
                                <?php while ($application = $applications_result->fetch_assoc()): ?>
                                    <tr>
                                        <td data-label="Full Name"><?= htmlspecialchars($application['full_name'] ?? 'N/A') ?></td>
                                        <td data-label="Scholarship"><?= htmlspecialchars($application['scholarship_title'] ?? 'N/A') ?></td>
                                        <td data-label="Submission Date">
                                            <?= !empty($application['application_date']) ? date('F j, Y', strtotime($application['application_date'])) : 'N/A' ?>
                                        </td>
                                        <td data-label="Status">
                                            <span class="status-badge <?= htmlspecialchars($application['status'] ?? '') ?>">
                                                <?= ucfirst(htmlspecialchars($application['status'] ?? 'Unknown')) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="no-applications">You haven't submitted any applications yet</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenu = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');
            
            if (mobileMenu && navLinks) {
                mobileMenu.addEventListener('click', function() {
                    navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
                });
            }
            
            // Auto-resize textareas
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
                textarea.dispatchEvent(new Event('input'));
            });
            
            // Responsive handling
            function handleResponsive() {
                if (window.innerWidth > 768) {
                    if (navLinks) navLinks.style.display = 'flex';
                } else {
                    if (navLinks) navLinks.style.display = 'none';
                }
            }
            
            window.addEventListener('resize', handleResponsive);
            handleResponsive();
        });
    </script>
</body>
</html>