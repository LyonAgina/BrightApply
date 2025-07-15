<?php
session_start();
require 'connection.php';
require 'functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'deadline';
$type = isset($_GET['type']) ? $_GET['type'] : '';

$limit = 10;
$offset = ($page - 1) * $limit;

$scholarships = displayScholarships($limit, $offset, $sort, $type);
$total_scholarships = getScholarshipCount($type);
$total_pages = ceil($total_scholarships / $limit);
?>

<!DOCTYPE html>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="scholarships.php" class="active">Scholarships</a></li>
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
                <li class="active"><a href="scholarships.php"><i class="fas fa-award"></i> Scholarships</a></li>
                <li class="applications"><a href="my_applications.php"><i class="fas fa-file-alt"></i> My Applications</a></li>
                <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2>Available Scholarships</h2>
                <div class="sort-options">
                    <select id="sort-by">
                        <option value="deadline">Deadline</option>
                        <option value="amount">Amount</option>
                        <option value="date_added">Newest</option>
                    </select>
                    <select id="filter-type">
                        <option value="">All Types</option>
                        <option value="academic">Academic</option>
                        <option value="athletic">Athletic</option>
                        <option value="need-based">Need-based</option>
                    </select>
                </div>
            </div>

            <div class="scholarship-list">
                <?php if (empty($scholarships)): ?>
                    <p>No scholarships available at this time.</p>
                <?php else: ?>
                    <?php foreach ($scholarships as $scholarship): ?>
                        <?php renderScholarshipCard($scholarship); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="scholarships.php?page=<?= $page - 1 ?>" class="page-link">Previous</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="scholarships.php?page=<?= $i ?>" class="page-link <?= $i == $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="scholarships.php?page=<?= $page + 1 ?>" class="page-link">Next</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function toggleSave(scholarshipId) {
            fetch('save_scholarship.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `scholarship_id=${scholarshipId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'saved') {
                    const btn = document.querySelector(`.scholarship-card[data-id="${scholarshipId}"] .save-btn`);
                    if (btn) {
                        btn.innerHTML = '<i class="fas fa-bookmark"></i> Saved';
                        btn.classList.add('saved');
                    }
                } else if (data.status === 'unsaved') {
                    const btn = document.querySelector(`.scholarship-card[data-id="${scholarshipId}"] .save-btn`);
                    if (btn) {
                        btn.innerHTML = '<i class="far fa-bookmark"></i> Save';
                        btn.classList.remove('saved');
                    }
                }
            });
        }

        function applyForScholarship(scholarshipId) {
            window.location.href = `apply.php?scholarship_id=${scholarshipId}`;
        }

        // Sorting and filtering
        document.getElementById('sort-by').addEventListener('change', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('sort', this.value);
            window.location.search = params.toString();
        });

        document.getElementById('filter-type').addEventListener('change', function() {
            const params = new URLSearchParams(window.location.search);
            if (this.value) {
                params.set('type', this.value);
            } else {
                params.delete('type');
            }
            window.location.search = params.toString();
        });

        // Set initial dropdown values
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('sort')) {
                document.getElementById('sort-by').value = params.get('sort');
            }
            if (params.has('type')) {
                document.getElementById('filter-type').value = params.get('type');
            }
        });
    </script>
</body>
</html>