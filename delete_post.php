<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    if ($stmt->execute([$postId, $_SESSION['id']])) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting post.";
    }
} else {
    echo "Invalid request.";
    exit;
}
?>