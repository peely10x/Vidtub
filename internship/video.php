<?php
require 'db.php';
session_start();

// Check if video is selected via GET
$videoPath = $_GET['video'] ?? null;
$title = $_GET['title'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ? htmlspecialchars($title) : "All Videos" ?></title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
    h1 { text-align: center; }
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
    .video-card img {
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
    a {
      text-decoration: none;
      color: inherit;
    }
    .video-player {
      max-width: 800px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    video {
      width: 100%;
      border-radius: 10px;
    }
    .back {
      display: inline-block;
      margin-bottom: 15px;
      text-decoration: none;
      color: #007BFF;
    }
  </style>
</head>
<body>

<?php if ($videoPath && file_exists($videoPath)): ?>
  <div class="video-player">
    <a class="back" href="videos.php">⬅ Back to all videos</a>
    <h2><?= htmlspecialchars($title) ?></h2>
    <video controls>
      <source src="<?= htmlspecialchars($videoPath) ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
<?php else: ?>
  <h1>🎥 Latest Uploaded Videos</h1>
  <div class="video-grid">
    <?php
    $stmt = $db->query("SELECT * FROM videos ORDER BY uploaded_at DESC");
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($videos as $video):
    ?>
      <div class="video-card">
        <a href="videos.php?video=<?= urlencode($video['video_path']) ?>&title=<?= urlencode($video['title']) ?>">
          <img src="<?= htmlspecialchars($video['thumbnail_path']) ?>" alt="Thumbnail">
          <div class="video-title"><?= htmlspecialchars($video['title']) ?></div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

</body>
</html>
