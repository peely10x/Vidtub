<?php
require 'db.php';
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

// Optional: hash password for security
// $password = hash('sha256', $password);

// Check if user already exists
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

if ($stmt->fetch()) {
    echo "❌ Username already taken.";
} else {
    // Insert new user
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "✅ Registered successfully. <a href='login.html'>Login now</a>";
}
?>
