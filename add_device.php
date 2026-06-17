<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once "config.php"; // DB connection

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $device_name = trim($_POST['device_name']);
    $ip_address = trim($_POST['ip_address']);

    if (!empty($device_name)) {

        // Generate random token (for IoT security)
        $token = bin2hex(random_bytes(16));

        $stmt = $conn->prepare("INSERT INTO devices (device_name, ip_address, token) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $device_name, $ip_address, $token);

        if ($stmt->execute()) {
            $success = "✅ Device added successfully!";

            // Log alert
            $alert_msg = "New device registered: " . $device_name;
            $alert_type = "device_added";
            $alert = $conn->prepare("INSERT INTO alerts (alert_type, alert_message) VALUES (?, ?)");
            $alert->bind_param("ss", $alert_type, $alert_msg);
            $alert->execute();
            $alert->close();

        } else {
            $error = "❌ Failed to add device.";
        }

        $stmt->close();

    } else {
        $error = "⚠️ Device name is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Device | IoT Virtual Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card" style="width:420px; padding:40px;">
    <h2 style="margin-bottom:15px; color:#2AB8FF;">Add New IoT Device</h2>

    <?php if ($success): ?>
        <div class="success-msg"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="device_name" placeholder="Device Name" required>
        <input type="text" name="ip_address" placeholder="IP Address (optional)">
        <input type="submit" value="Add Device">
    </form>

    <a href="dashboard.php">
        <button style="margin-top:10px; background:#0B4D71; color:white;">⬅ Back to Dashboard</button>
    </a>
</div>

</body>
</html>
