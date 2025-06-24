<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $content = $conn->real_escape_string($_POST['content']);
    
    $sql = "INSERT INTO posts (user_id, content, created_at)
            VALUES ($user_id, '$content', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: community.php?success=post_created");
    } else {
        header("Location: community.php?error=database_error");
    }
    $conn->close();
} else {
    header("Location: community.php");
}
?>