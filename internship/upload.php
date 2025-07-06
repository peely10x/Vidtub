<?php
require 'db.php'; // assumes you have a PDO connection in db.php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';

    $video = $_FILES['video'] ?? null;
    $thumb = $_FILES['thumbnail'] ?? null;

    // Check for errors
    if (!$title || !$video || !$thumb) {
        echo "❌ Missing required fields.";
        exit;
    }

    // Check upload errors
if ($video['error'] !== UPLOAD_ERR_OK || $thumb['error'] !== UPLOAD_ERR_OK) {
    echo "❌ Video error: " . $video['error'] . "<br>";
    echo "❌ Thumbnail error: " . $thumb['error'];
    exit;
}


    // Optional: Validate file types
    $allowedVideoTypes = ['video/mp4'];
    $allowedImageTypes = ['image/jpeg', 'image/png'];

    if (!in_array($video['type'], $allowedVideoTypes)) {
        echo "❌ Only MP4 videos are allowed.";
        exit;
    }

    if (!in_array($thumb['type'], $allowedImageTypes)) {
        echo "❌ Thumbnail must be JPG or PNG.";
        exit;
    }

    // Generate unique names
    $videoName = uniqid("video_") . "_" . basename($video['name']);
    $thumbName = uniqid("thumb_") . "_" . basename($thumb['name']);

    $videoPath = "uploads/" . $videoName;
    $thumbPath = "uploads/" . $thumbName;

    // Move uploaded files
    $videoUploaded = move_uploaded_file($video['tmp_name'], $videoPath);
    $thumbUploaded = move_uploaded_file($thumb['tmp_name'], $thumbPath);
    $user_id = $_SESSION['user_id'];

    if ($videoUploaded && $thumbUploaded) {
        // Insert into database
        $stmt = $db->prepare("INSERT INTO videos (title, video_path, thumbnail_path,user_id) VALUES (?, ?, ?,?)");
        $stmt->execute([$title, $videoPath, $thumbPath,$user_id]);
        echo "✅ Video and thumbnail uploaded successfully!";
        header('location: home_page.view.php');
    } else {
        echo "❌ Failed to move uploaded files.";
    }
} else {
    echo "⛔ Invalid request method.";
}
?>
