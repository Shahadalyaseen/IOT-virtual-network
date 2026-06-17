<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = $_GET['error'] ?? '';
$msg   = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | IoT Virtual Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <img src="assets/logo.png" alt="System Logo">
    <h2>IoT Virtual Network System</h2>

    <?php if ($error): ?>
        <div class="error-msg">
            <?= $error === 'empty' ? 'Please fill username and password' : 'Invalid username or password'; ?>
        </div>
    <?php endif; ?>

    <?php if ($msg === 'registered'): ?>
        <div class="success-msg">Account created successfully. Please login.</div>
    <?php endif; ?>

    <form action="process_login.php" method="post">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="submit" value="Login">
    </form>

    <p class="auth-link">
        Don't have an account?
        <a href="register.php">Register Here</a>
    </p>
</div>

</body>
</html>