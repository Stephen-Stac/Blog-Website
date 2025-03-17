<?php
    include_once 'header.php';
    include 'includes/db.php';
    include 'includes/csrf.php';
    $csrf_token = generateCsrfToken();

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $postId = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
        $stmt->execute([$postId, $_SESSION['id']]);
        $post = $stmt->fetch();

        if (!$post) {
            echo "Post not found ";
            exit;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $postId = $_POST['id'];
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$title, $content, $postId, $_SESSION['id']])) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error updating post.";
        }
    } else {
        echo "Invalid request.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="/blog/css/edit_post.css">
</head>
<body>
    <div class="container">
        <h2>Edit Post</h2>
        <form action="edit_post.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
            <button type="submit">Update Post</button>
        </form>
    </div>
</body>
</html>