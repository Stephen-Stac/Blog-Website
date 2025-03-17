<?php
    include_once 'header.php';
    include 'includes/db.php';
    include 'includes/csrf.php';
    $csrf_token = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog website</title>
    <link rel="stylesheet" href="/blog/css/index.css">
</head>
<body>
    <div class="container">
        <h1>All Blog</h1>

        <?php if (isset($_SESSION['id'])): ?>
            <h2>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <?php 
                // Fetch user's posts from database, ordered by creation date descending
                $stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE user_id = ? ORDER BY posts.created_at DESC");
                $stmt->execute([$_SESSION['id']]);
                $userPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userPosts as $post): ?>
                <div class='post'>
                    <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <small>Posted by <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></small><br><br>
                    <!-- Add edit/delete functionality here -->
                    <a href='edit_post.php?id=<?php echo $post["id"]; ?>'>Edit Post</a> 
                    <a class="delete" href='delete_post.php?id=<?php echo $post["id"]; ?>'>Delete Post</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>All Posts</h3>
        <?php 
            // Fetch all posts from database, ordered by creation date descending
            $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
            $allPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($allPosts as $post): ?>
            <div class='post'>
                <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <small>Posted by <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></small><br><br>
                
                <!-- Display comments -->
                <h5>Comments:</h5>
                <?php
                    $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY comments.created_at DESC");
                    $stmt->execute([$post['id']]);
                    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($comments as $comment): ?>
                    <div class='comment'>
                        <p><?php echo htmlspecialchars($comment['content']); ?></p>
                        <small>Commented by <?php echo htmlspecialchars($comment['username']); ?> on <?php echo date('Y-m-d H:i', strtotime($comment['created_at'])); ?></small><br><br>
                    </div>
                <?php endforeach; ?>

                <!-- Add comment form -->
                <?php if (isset($_SESSION['id'])): ?>
                    <form action="add_comment.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <textarea name="content" rows="3" placeholder="Add a comment..." required></textarea><br><br>
                        <button type="submit">Submit Comment</button>
                    </form>
                <?php endif; ?>
             
            </div>
        <?php endforeach; ?>

       <div class="addpost">
        <a href="create_post.php">Add A Blog Post</a>
       </div>
    </div>
</body>
</html>