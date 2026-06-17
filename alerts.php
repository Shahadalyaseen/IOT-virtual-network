<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once "config.php";

$alerts = $conn->query("SELECT alert_type, alert_message, created_at FROM alerts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Security Alerts | IoT Virtual Network</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card" style="width:550px; padding:35px; text-align:left;">
    <h2 style="margin-bottom:15px; color:#2AB8FF;">Security Alerts</h2>

    <?php if ($alerts->num_rows > 0): ?>
        <table style="width:100%; font-size:13px; border-spacing:0 8px;">
            <tr style="color:#B8C1CC;">
                <th align="left">Type</th>
                <th align="left">Message</th>
                <th align="left">Timestamp</th>
            </tr>

            <?php while($row = $alerts->fetch_assoc()): ?>
                <tr style="background:#2A3642;">
                    <td style="padding:8px; color:#2AB8FF;"><?= htmlspecialchars($row['alert_type']) ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['alert_message']) ?></td>
                    <td style="padding:8px; color:#B8C1CC;"><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <p style="color:#B8C1CC;">No alerts recorded yet.</p>
    <?php endif; ?>

    <a href="dashboard.php"><button style="margin-top:15px; background:#0B4D71; color:white;">⬅ Back to Dashboard</button></a>
</div>

</body>
</html>
