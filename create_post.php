<?php
    include_once 'header.php';
    include 'includes/db.php';
    include 'includes/csrf.php';
    $csrf_token = generateCsrfToken();

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="/blog/css/create_post.css">
</head>
<body>
    <div class="container">
        <h2>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <h3>Create New Post</h3>
        <form action="create_post.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="title" placeholder="Post Title" required>
            <textarea name="content" rows="10" placeholder="Write your post here..." required></textarea>
            <button type="submit">Publish Post</button>
        </form>
        <?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
                    die('CSRF token validation failed');
                }

                $title = htmlspecialchars($_POST['title']);
                $content = htmlspecialchars($_POST['content']);
                $userId = $_SESSION['id'];

                // Insert post into database
                $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");

                if ($stmt->execute([$userId, $title, $content])) {
                    echo "<p>Post published successfully!</p>";
                    header("Location: index.php"); // Refresh page after publishing post
                    exit();
                } else {
                    echo "<p>Error publishing post.</p>";
                }
            }
        ?>
    </div>
</body>
</html>