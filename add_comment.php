<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $content = htmlspecialchars($_POST['content']);
    $userId = $_SESSION['id'];

    $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    if ($stmt->execute([$postId, $userId, $content])) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error adding comment.";
    }
} else {
    echo "Invalid request.";
    exit;
}
?>