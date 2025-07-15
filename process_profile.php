<?php
session_start();
require 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Initialize variables
$errors = [];
$success = false;

// Handle file uploads
$profile_picture = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (in_array($file_ext, $allowed_types)) {
        $filename = 'profile_' . $user_id . '_' . time() . '.' . $file_ext;
        $destination = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destination)) {
            $profile_picture = $filename;
        } else {
            $errors[] = "Failed to upload profile picture";
        }
    } else {
        $errors[] = "Invalid file type for profile picture. Only JPG, PNG, GIF are allowed.";
    }
}

// Prepare data
$full_name = $_POST['full_name'] ?? '';
$date_of_birth = $_POST['date_of_birth'] ?? null;
$gender = $_POST['gender'] ?? null;
$bio = $_POST['bio'] ?? null;
$education_level = $_POST['education_level'] ?? null;
$school_name = $_POST['school_name'] ?? null;
$major = $_POST['major'] ?? null;
$graduation_year = $_POST['graduation_year'] ?? null;
$gpa = $_POST['gpa'] ?? null;

// Validate required fields
if (empty($full_name)) {
    $errors[] = "Full name is required";
}

if (empty($errors)) {
    // Check if profile exists
    $check_sql = "SELECT * FROM user_profiles WHERE user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param('i', $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Update existing profile
        $sql = "UPDATE user_profiles SET 
                full_name = ?,
                date_of_birth = ?,
                gender = ?,
                bio = ?,
                education_level = ?,
                school_name = ?,
                major = ?,
                graduation_year = ?,
                gpa = ?,
                updated_at = NOW()";
        
        $params = [
            $full_name,
            $date_of_birth,
            $gender,
            $bio,
            $education_level,
            $school_name,
            $major,
            $graduation_year,
            $gpa
        ];
        
        $types = 'ssssssssd'; // 'd' for decimal gpa
        
        if ($profile_picture) {
            $sql .= ", profile_picture = ?";
            $params[] = $profile_picture;
            $types .= 's';
        }
        
        $sql .= " WHERE user_id = ?";
        $params[] = $user_id;
        $types .= 'i';
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Failed to update profile: " . $stmt->error;
        }
    } else {
        // Create new profile
        $sql = "INSERT INTO user_profiles (
                user_id, full_name, date_of_birth, gender, bio, 
                education_level, school_name, major, graduation_year, gpa, created_at";
        
        if ($profile_picture) {
            $sql .= ", profile_picture";
        }
        
        $sql .= ") VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()";
        
        if ($profile_picture) {
            $sql .= ", ?";
        }
        
        $sql .= ")";
        
        $params = [
            $user_id,
            $full_name,
            $date_of_birth,
            $gender,
            $bio,
            $education_level,
            $school_name,
            $major,
            $graduation_year,
            $gpa
        ];
        
        $types = 'issssssssd';
        
        if ($profile_picture) {
            $params[] = $profile_picture;
            $types .= 's';
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Failed to create profile: " . $stmt->error;
        }
    }
}

// Handle password change if provided
if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password === $confirm_password) {
        // Verify current password
        $check_sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($current_password, $user['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param('si', $hashed_password, $user_id);
            
            if (!$update_stmt->execute()) {
                $errors[] = "Failed to update password";
            }
        } else {
            $errors[] = "Current password is incorrect";
        }
    } else {
        $errors[] = "New passwords do not match";
    }
}

// Handle email change if provided
if (!empty($_POST['new_email'])) {
    $new_email = $_POST['new_email'];
    
    // Check if email already exists
    $check_email_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param('si', $new_email, $user_id);
    $check_stmt->execute();
    $email_result = $check_stmt->get_result();
    
    if ($email_result->num_rows > 0) {
        $errors[] = "Email already exists";
    } else {
        $update_sql = "UPDATE users SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('si', $new_email, $user_id);
        
        if (!$stmt->execute()) {
            $errors[] = "Failed to update email";
        }
    }
}

// Set session messages and redirect
if ($success && empty($errors)) {
    $_SESSION['success_message'] = "Profile updated successfully!";
} else {
    $_SESSION['error_messages'] = $errors;
}

header("Location: profile.php");
exit();
?>