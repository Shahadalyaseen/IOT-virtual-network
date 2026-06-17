<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | IoT Virtual Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card" style="width: 420px; padding: 40px;">
    <img src="assets/logo.png" alt="Logo" style="width:140px; margin-bottom: 15px;">

    <h2 style="margin-bottom: 10px; color:#2AB8FF;">
        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </h2>

    <p style="color:#B8C1CC; font-size:14px; margin-bottom:25px;">
        IoT Device Management Dashboard
    </p>

    <a href="add_device.php">
        <button style="margin-bottom:10px;">➕ Add New Device</button>
    </a>

    <a href="alerts.php">
        <button style="margin-bottom:10px;">⚠️ View Alerts</button>
    </a>

    <a href="logout.php">
        <button style="background:#ff4d4d; color:white;">🚪 Logout</button>
    </a>
</div>

</body>
</html>
