<?php
$host = "localhost";      // or 127.0.0.1
$username = "root";       // default XAMPP username
$password = "";           // default XAMPP has no password
$database = "bright_apply";  // change this to your actual database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Optional: Show success
// echo "Connected successfully";
?>
