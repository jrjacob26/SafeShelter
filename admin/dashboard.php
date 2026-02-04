<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Fetch evacuation centers
$centers = $pdo->query("SELECT * FROM evacuation_centers")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SafeShelter Admin Dashboard</title>

<style>
/* --- Body & Layout --- */
body {
    font-family: 'Segoe UI', sans-serif;
    background: #eef2f7;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
}

.topbar {
    background: #2c3e50;
    color: #fff;
    padding: 20px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* --- Buttons --- */
.buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 30px;
}

.btn {
    flex: 1 1 200px;
    max-width: 220px;
    text-align: center;
    padding: 15px 10px;
    background: #3498db;
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn:hover {
    background: #217dbb;
    transform: translateY(-3px);
}

.btn.logout {
    background: #e74c3c;
}

.btn.logout:hover {
    background: #c0392b;
}

/* --- Table --- */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

th, td {
    padding: 15px;
    text-align: center;
}

th {
    background: #3498db;
    color: white;
    font-weight: bold;
}

/* --- Progress Bar --- */
.progress-container {
    background: #ddd;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    padding: 5px 0;
    color: white;
    text-align: center;
    border-radius: 10px;
    transition: width 0.5s ease-in-out;
}

/* --- Status --- */
.status-open {
    color: green;
    font-weight: bold;
}

.status-full {
    color: red;
    font-weight: bold;
}

/* --- Responsive --- */
@media (max-width: 600px) {
    .btn {
        flex: 1 1 100%;
        max-width: 100%;
    }
}
</style>
</head>
<body>

<div class="topbar">🛟 SafeShelter Admin Dashboard</div>

<div class="container">

    <!-- Buttons -->
    <div class="buttons">
        <a class="btn" href="send_alert.php">🚨 Send Disaster Alert</a>
        <a class="btn" href="add_center.php">➕ Add Center</a>
        <a class="btn" href="analytics.php">📊 Analytics Dashboard</a>
        <a class="btn logout" href="logout.php">🚪 Logout</a>
    </div>

    <!-- Evacuation Centers Table -->
    <table>
        <thead>
            <tr>
                <th>Center</th>
                <th>Location</th>
                <th>Capacity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($centers as $center): 
                $percentage = ($center['current_capacity'] / $center['max_capacity']) * 100;
                $barColor = ($percentage >= 100) ? 'red' : 'green';
            ?>
            <tr>
                <td><?= htmlspecialchars($center['center_name']) ?></td>
                <td><?= htmlspecialchars($center['location']) ?></td>
                <td>
                    <div class="progress-container">
                        <div class="progress-bar" style="width:<?= $percentage ?>%; background:<?= $barColor ?>;">
                            <?= $center['current_capacity'] ?> / <?= $center['max_capacity'] ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if($center['current_capacity'] >= $center['max_capacity']): ?>
                        <span class="status-full">FULL</span>
                    <?php else: ?>
                        <span class="status-open">OPEN</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
