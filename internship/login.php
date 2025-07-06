<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        // Get user from database
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check username and plain text password match
        if ($user && $password === $user['password']) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            echo "✅ Login successful. Welcome, " . htmlspecialchars($user['username']) . "!";
            header('Location: home_page.view.php'); 
        } else {
            echo "❌ Invalid username or password.";
        }
    } else {
        echo "⚠️ Both fields are required.";
    }
} else {
    echo "⛔ Invalid access.";
}
?>
