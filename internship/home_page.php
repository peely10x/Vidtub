<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('No videos found');
}

$userId = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT * FROM videos WHERE user_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$userId]);
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output only the video HTML blocks
foreach ($videos as $video):
    $thumb = htmlspecialchars($video['thumbnail_path']);
    $title = htmlspecialchars($video['title']);
    $videoFile = htmlspecialchars($video['video_path']);
?>
    <div class="video-card">
        <video width="100%" height="180" controls poster="<?= $thumb ?>">
            <source src="<?= $videoFile ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="video-title"><?= $title ?></div>
    </div>
<?php
endforeach;
?>
