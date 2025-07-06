<?php
$host = '127.0.0.1';
$dbname = 'video_streaming_platform';
$username = 'root';
$password = 'Mush3kah6eeng9so';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}
?>
