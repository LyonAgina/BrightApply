<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $scholarship_id = $conn->real_escape_string($_POST['scholarship_id']);
    $notes = isset($_POST['notes']) ? $conn->real_escape_string($_POST['notes']) : null;

    // Check if already saved
    $check_sql = "SELECT id FROM saved_scholarships 
                 WHERE user_id = $user_id AND scholarship_id = $scholarship_id";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Already saved - unsave it
        $delete_sql = "DELETE FROM saved_scholarships 
                      WHERE user_id = $user_id AND scholarship_id = $scholarship_id";
        if ($conn->query($delete_sql)) {
            echo json_encode(['status' => 'unsaved']);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }
    } else {
        // Save new
        $insert_sql = "INSERT INTO saved_scholarships (user_id, scholarship_id, notes)
                      VALUES ($user_id, $scholarship_id, " . ($notes ? "'$notes'" : "NULL") . ")";
        if ($conn->query($insert_sql)) {
            echo json_encode(['status' => 'saved', 'saved_id' => $conn->insert_id]);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }
    }
    $conn->close();
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}
?>