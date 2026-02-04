<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$centers = $pdo->query("SELECT * FROM evacuation_centers")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Evacuation Centers - SafeShelter</title>

<style>
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

h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 40px;
}

/* --- Grid layout for centers --- */
.centers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

/* --- Card style --- */
.center-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.center-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

.center-card h3 {
    margin-top: 0;
    color: #3498db;
}

.center-card p {
    font-size: 1rem;
    margin: 10px 0;
}

/* --- Availability Badge --- */
.badge {
    display: inline-block;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    color: white;
}

.badge.open {
    background: green;
}

.badge.full {
    background: red;
}

/* --- Check-in Button --- */
.btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background: #3498db;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.btn:hover {
    background: #217dbb;
}

</style>
</head>
<body>

<div class="container">
    <h1>🏢 Available Evacuation Centers</h1>

    <div class="centers-grid">
        <?php foreach($centers as $center):
            $available = $center['max_capacity'] - $center['current_capacity'];
            $statusClass = ($available > 0) ? 'open' : 'full';
            $statusText = ($available > 0) ? "$available slots left" : "FULL";
        ?>
        <div class="center-card">
            <h3><?= htmlspecialchars($center['center_name']) ?></h3>
            <p>📍 <?= htmlspecialchars($center['location']) ?></p>
            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span><br>
            <?php if($available > 0): ?>
                <a class="btn" href="checkin.php?id=<?= $center['id'] ?>">✅ Check In</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>
