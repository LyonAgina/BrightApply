<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $scholarship_id = $conn->real_escape_string($_POST['scholarship_id']);
    $essay = $conn->real_escape_string($_POST['essay']);
    
    // Check if already applied
    $check = $conn->query("SELECT * FROM applications 
                          WHERE user_id=$user_id AND scholarship_id=$scholarship_id");
    
    if ($check->num_rows > 0) {
        header("Location: scholarship.php?id=$scholarship_id&error=already_applied");
        exit();
    }

    $sql = "INSERT INTO applications (user_id, scholarship_id, essay, application_date)
            VALUES ($user_id, $scholarship_id, '$essay', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: scholarship.php?id=$scholarship_id&success=application_submitted");
    } else {
        header("Location: scholarship.php?id=$scholarship_id&error=database_error");
    }
    $conn->close();
} else {
    header("Location: scholarships.php");
}
?>