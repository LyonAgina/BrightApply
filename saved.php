<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Get saved scholarships with details
$sql = "SELECT s.*, ss.saved_at, ss.notes, ss.id as save_id
        FROM saved_scholarships ss
        JOIN scholarships s ON ss.scholarship_id = s.id
        WHERE ss.user_id = $user_id
        ORDER BY ss.saved_at DESC
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
$saved_scholarships = $result->fetch_all(MYSQLI_ASSOC);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM saved_scholarships WHERE user_id = $user_id";
$count_result = $conn->query($count_sql);
$total = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Saved Scholarships</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>My Saved Scholarships</h1>
        
        <?php if (empty($saved_scholarships)): ?>
            <p>You haven't saved any scholarships yet.</p>
        <?php else: ?>
            <div class="scholarship-list">
                <?php foreach ($saved_scholarships as $scholarship): ?>
                    <div class="scholarship-card">
                        <h3><?= htmlspecialchars($scholarship['title']) ?></h3>
                        <p class="deadline">Deadline: <?= date('F j, Y', strtotime($scholarship['deadline'])) ?></p>
                        <p class="amount">$<?= number_format($scholarship['amount']) ?></p>
                        <?php if (!empty($scholarship['notes'])): ?>
                            <div class="notes">
                                <strong>Your Notes:</strong>
                                <p><?= htmlspecialchars($scholarship['notes']) ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="actions">
                            <a href="scholarship.php?id=<?= $scholarship['id'] ?>" class="btn">View Details</a>
                            <button class="btn unsave-btn" data-save-id="<?= $scholarship['save_id'] ?>">Unsave</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="saved.php?page=<?= $page - 1 ?>" class="page-link">Previous</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="saved.php?page=<?= $i ?>" class="page-link <?= $i == $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="saved.php?page=<?= $page + 1 ?>" class="page-link">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // AJAX for unsaving
        document.querySelectorAll('.unsave-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const saveId = this.getAttribute('data-save-id');
                fetch('unsave_scholarship.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: save_id=${saveId}
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.scholarship-card').remove();
                    }
                });
            });
        });
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>