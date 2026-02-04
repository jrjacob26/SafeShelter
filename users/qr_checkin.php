<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['user_id'])){
    die("Please login first.");
}

$center_id = $_GET['center_id'];
$user_id = $_SESSION['user_id'];

// Check if center is full
$center = $pdo->query("SELECT * FROM evacuation_centers WHERE id=$center_id")->fetch();

if($center['current_capacity'] >= $center['max_capacity']){
    die("Center is FULL!");
}

// Insert check-in
$pdo->prepare("INSERT INTO checkins(user_id,center_id) VALUES(?,?)")
    ->execute([$user_id, $center_id]);

// Update capacity
$pdo->prepare("UPDATE evacuation_centers SET current_capacity=current_capacity+1 WHERE id=?")
    ->execute([$center_id]);

echo "✅ Successfully checked in to ".$center['center_name'];
?>
