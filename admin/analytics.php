<?php
session_start();
require "../config/db.php";

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Fetch evacuation center occupancy
$centers = $pdo->query("SELECT center_name, max_capacity, current_capacity FROM evacuation_centers")->fetchAll(PDO::FETCH_ASSOC);

// Fetch alerts by level
$alerts = $pdo->query("SELECT alert_level, COUNT(*) as total FROM alerts GROUP BY alert_level")->fetchAll(PDO::FETCH_ASSOC);

// Fetch total evacuees
$totalEvacuees = $pdo->query("SELECT COUNT(*) FROM checkins")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SafeShelter Analytics Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* --- General Layout --- */
body {
    font-family: 'Segoe UI', sans-serif;
    background: #eef2f7;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

/* --- Header --- */
h1 {
    text-align: center;
    margin-bottom: 40px;
    color: #2c3e50;
}

/* --- Summary Card --- */
.summary-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-bottom: 40px;
}

.card {
    flex: 1 1 200px;
    max-width: 250px;
    background: #3498db;
    color: white;
    padding: 25px 20px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.15);
}

.card h2 {
    margin: 0;
    font-size: 2.2rem;
}

.card p {
    margin: 5px 0 0;
    font-weight: bold;
}

/* --- Buttons --- */
a.btn {
    display: inline-block;
    padding: 12px 25px;
    background: #2c3e50;
    color: white;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 30px;
    transition: 0.3s;
}

a.btn:hover {
    background: #1a252f;
}

/* --- Chart Containers --- */
.chart-container {
    background: white;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 40px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.chart-container h2 {
    margin-top: 0;
    color: #3498db;
    margin-bottom: 20px;
}

/* --- Responsive --- */
@media(max-width: 600px){
    .summary-cards {
        flex-direction: column;
        align-items: center;
    }
}
</style>
</head>
<body>

<div class="container">
    <h1>📊 SafeShelter Analytics Dashboard</h1>

    <div class="summary-cards">
        <div class="card">
            <h2><?= $totalEvacuees ?></h2>
            <p>Total Evacuees</p>
        </div>
        <div class="card">
            <h2><?= array_sum(array_column($centers,'current_capacity')) ?></h2>
            <p>Current Occupancy</p>
        </div>
        <div class="card">
            <h2><?= array_sum(array_column($centers,'max_capacity')) ?></h2>
            <p>Max Capacity</p>
        </div>
    </div>

    <a class="btn" href="dashboard.php">← Back to Dashboard</a>

    <!-- Evacuation Center Occupancy -->
    <div class="chart-container">
        <h2>Evacuation Center Occupancy</h2>
        <canvas id="capacityChart"></canvas>
    </div>

    <!-- Disaster Alerts -->
    <div class="chart-container">
        <h2>Disaster Alerts by Level</h2>
        <canvas id="alertChart"></canvas>
    </div>
</div>

<script>
    // Occupancy Bar Chart
    const ctx = document.getElementById('capacityChart').getContext('2d');
    const capacityChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($centers,'center_name')) ?>,
            datasets: [
                {
                    label: 'Current Occupancy',
                    data: <?= json_encode(array_column($centers,'current_capacity')) ?>,
                    backgroundColor: 'rgba(231, 76, 60,0.7)'
                },
                {
                    label: 'Max Capacity',
                    data: <?= json_encode(array_column($centers,'max_capacity')) ?>,
                    backgroundColor: 'rgba(46, 204, 113,0.7)'
                }
            ]
        },
        options: {
            responsive:true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Alerts Pie Chart
    const ctx2 = document.getElementById('alertChart').getContext('2d');
    const alertChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($alerts,'alert_level')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($alerts,'total')) ?>,
                backgroundColor: ['#27ae60','#f39c12','#e74c3c']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

</body>
</html>
