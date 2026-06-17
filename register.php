<?php
include 'config.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $message = "Please fill all fields.";
        $messageType = "error";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $messageType = "error";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already exists.";
            $messageType = "error";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password_hash);

            if ($stmt->execute()) {
                header("Location: index.php?msg=registered");
                exit();
            } else {
                $message = "Registration failed.";
                $messageType = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | IoT Virtual Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <img src="assets/logo.png" alt="System Logo">
    <h2>Create New Account</h2>

    <?php if (!empty($message)): ?>
        <div class="<?= $messageType === 'error' ? 'error-msg' : 'success-msg'; ?>">
            <?= $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <input type="password" name="confirm_password" placeholder="Confirm password" required>
        <input type="submit" value="Register">
    </form>

    <p class="auth-link">
        Already have an account?
        <a href="index.php">Login Here</a>
    </p>
</div>

</body>
</html>