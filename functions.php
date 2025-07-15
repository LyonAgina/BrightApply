<?php
// functions.php
require 'connection.php';

function displayScholarships($limit = 4, $offset = 0, $sort = 'deadline', $type = '') {
    global $conn;
    
    // Validate sort parameter
    $valid_sorts = ['deadline', 'amount', 'date_added'];
    $sort = in_array($sort, $valid_sorts) ? $sort : 'deadline';
    
    // Build the base query
    $sql = "SELECT * FROM scholarships WHERE deadline >= CURDATE()";
    
    // Add type filter if specified
    if (!empty($type)) {
        $type = $conn->real_escape_string($type);
        $sql .= " AND type = '$type'";
    }
    
    // Add sorting
    switch ($sort) {
        case 'amount':
            $sql .= " ORDER BY amount DESC";
            break;
        case 'date_added':
            $sql .= " ORDER BY created_at DESC";
            break;
        default:
            $sql .= " ORDER BY deadline ASC";
    }
    
    // Add limit/offset
    $sql .= " LIMIT $limit OFFSET $offset";
    
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getScholarshipCount($type = '') {
    global $conn;
    
    $sql = "SELECT COUNT(*) as total FROM scholarships WHERE deadline >= CURDATE()";
    
    if (!empty($type)) {
        $type = $conn->real_escape_string($type);
        $sql .= " AND type = '$type'";
    }
    
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total'];
}

function renderScholarshipCard($scholarship, $showSaveButton = true, $showApplyButton = true) {
    $logged_in = isset($_SESSION['user_id']);
    ?>
    <div class="scholarship-card">
        <h3><?= htmlspecialchars($scholarship['title']) ?></h3>
        <p class="deadline">Deadline: <?= date('F j, Y', strtotime($scholarship['deadline'])) ?></p>
        <p class="amount">$<?= number_format($scholarship['amount'], 2) ?></p>
        <div class="scholarship-actions">
            <?php if ($showSaveButton && $logged_in): ?>
                <button class="save-btn" onclick="toggleSave(<?= $scholarship['id'] ?>)">
                    <i class="far fa-bookmark"></i> Save
                </button>
            <?php endif; ?>
            <?php if ($showApplyButton): ?>
                <button class="apply-btn" onclick="applyForScholarship(<?= $scholarship['id'] ?>)">Apply</button>
            <?php endif; ?>
        </div>
    </div>
    <?php
}