<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Don't escape passwords

    $stmt = $conn->prepare("SELECT id, email, password, full_name, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect based on user type
            header("Location: " . ($user['user_type'] == 'admin' ? 'admin.php' : 'index.php'));
            exit();
        }
    }
    
    // Invalid credentials
    header("Location: login.php?error=invalid");
    exit();
}

// Not a POST request
header("Location: login.php");
exit();
?>