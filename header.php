<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/blog/css/header.css">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class="logo">BLOG</div>
        <div class="navlinks">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Sign Up</a></li>
                <?php if (isset($_SESSION['id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>
</html>