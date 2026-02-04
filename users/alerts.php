<?php
session_start();
require "../config/db.php";

$alerts = $pdo->query("
SELECT * FROM alerts
ORDER BY created_at DESC
");
?>

<style>

.alert{
padding:20px;
margin:20px;
border-radius:12px;
color:white;
font-family:'Segoe UI';
}

.low{ background:#27ae60; }
.moderate{ background:#f39c12; }
.critical{ background:#e74c3c; }

</style>

<h1 style="text-align:center;">📢 Disaster Alerts</h1>

<?php foreach($alerts as $alert):

$class = strtolower($alert['alert_level']);
?>

<div class="alert <?= $class ?>">

<h2><?= $alert['title'] ?></h2>

<b>Alert Level: <?= $alert['alert_level'] ?></b>

<p><?= $alert['message'] ?></p>

<small><?= $alert['created_at'] ?></small>

</div>

<?php endforeach; ?>
