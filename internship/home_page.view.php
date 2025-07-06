<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    // Optional: Redirect to login page
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch videos
$stmt = $db->prepare("SELECT * FROM videos WHERE user_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$userId]);
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Video Gallery</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }
    h1 {
      text-align: center;
    }
    .video-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .video-card {
      background: #fff;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .video-card video {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }
    .video-title {
      margin-top: 10px;
      font-size: 1rem;
      font-weight: bold;
      color: #333;
    }
  </style>
</head>
<body>

  <a href="upload.html">Upload</a>
  <h1>🎥 Your Uploaded Videos</h1>
  
  <div class="video-grid">
    <?php foreach ($videos as $video): ?>
      <div class="video-card">
        <video controls poster="<?= htmlspecialchars($video['thumbnail_path']) ?>">
          <source src="<?= htmlspecialchars($video['video_path']) ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
        <div class="video-title"><?= htmlspecialchars($video['title']) ?></div>
      </div>
    <?php endforeach; ?>
  </div>

</body>
</html>
