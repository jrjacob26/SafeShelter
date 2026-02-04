<?php
session_start();
require "../config/db.php";

$user_id = $_SESSION['user_id'];
$center_id = $_GET['id'];

// Insert checkin
$sql = "INSERT INTO checkins(user_id,center_id) VALUES(?,?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id,$center_id]);

// Update capacity
$pdo->prepare("
UPDATE evacuation_centers
SET current_capacity = current_capacity + 1
WHERE id = ?
")->execute([$center_id]);

header("Location: centers.php");
?>
