<?php
session_start();
require_once "config.php"; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header("Location: index.php?error=empty");
        exit();
    }

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $db_username, $db_password_hash);
        $stmt->fetch();

        if (password_verify($password, $db_password_hash)) {
            // Valid login
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $db_username;
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: index.php?error=badcreds");
            exit();
        }
    } else {
        header("Location: index.php?error=badcreds");
        exit();
    }
}
?>
