<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// Fetch latest alert
$latest = $pdo->query("SELECT * FROM alerts ORDER BY id DESC LIMIT 1")->fetch();

if($latest && $latest['alert_level'] == "CRITICAL"){
    echo "<script>alert('🚨 CRITICAL ALERT:\\n\\n{$latest['title']}');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SafeShelter User Dashboard</title>

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
    text-align: center;
}

h1 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 40px;
}

/* --- Button Grid --- */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
    justify-items: center;
    align-items: stretch;
}

/* --- Buttons --- */
.btn {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px 15px;
    background: #3498db;
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    transition: 0.3s;
    width: 100%;
    max-width: 220px;
    min-height: 100px;
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

/* --- Icon styling --- */
.btn::before {
    content: '';
    font-size: 2rem;
    margin-bottom: 10px;
}

.btn span.icon {
    font-size: 2rem;
    margin-bottom: 10px;
}

/* --- Responsive Adjustments --- */
@media (max-width: 500px) {
    h1 {
        font-size: 2rem;
    }
}
</style>

</head>
<body>

<div class="container">

<h1>🛟 Welcome to SafeShelter</h1>

<div class="dashboard-grid">
    <a class="btn" href="centers.php"><span class="icon">🏢</span> View Evacuation Centers</a>
    <a class="btn" href="map.php"><span class="icon">🗺️</span> Evacuation Map</a>
    <a class="btn" href="alerts.php"><span class="icon">🚨</span> Disaster Alerts</a>
    <a class="btn" href="add_family.php"><span class="icon">👨‍👩‍👧</span> Add Family</a>
    <a class="btn" href="family_locator.php"><span class="icon">📍</span> Family Locator</a>
    <a class="btn logout" href="logout.php"><span class="icon">🚪</span> Logout</a>
</div>

</div>

</body>
</html>
