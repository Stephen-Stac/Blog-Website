<?php
    include_once 'header.php';
    include 'includes/db.php';
    include 'includes/csrf.php';
    $csrf_token = generateCsrfToken();
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username']; // Set the username in the session
            header('Location: index.php');
            exit;
        } else {
            echo "Login failed";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/blog/css/login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>

            <button type="submit" name="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    </div>
</body>
</html>