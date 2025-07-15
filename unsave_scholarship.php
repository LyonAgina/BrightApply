<?php
session_start();
require 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Content-Type: application/json");
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $save_id = intval($_POST['save_id']);

    // Validate save_id
    if ($save_id <= 0) {
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode(['error' => 'Invalid save ID']);
        exit();
    }

    // Delete the saved scholarship (make sure it belongs to the current user)
    $delete_sql = "DELETE FROM saved_scholarships WHERE id = ? AND id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('ii', $save_id, $user_id);
    
    header("Content-Type: application/json");
    
    if ($delete_stmt->execute()) {
        if ($delete_stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Scholarship removed from saved list']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Scholarship not found or already removed']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to remove scholarship']);
    }
    
    $conn->close();
} else {
    header("Content-Type: application/json");
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>