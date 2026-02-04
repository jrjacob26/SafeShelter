<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
}

if(isset($_POST['add'])){

    $name = $_POST['center_name'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO evacuation_centers(center_name,location,max_capacity)
            VALUES(?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name,$location,$capacity]);

    header("Location: dashboard.php");
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>Add Evacuation Center</h2>

<form method="POST">
<input type="text" name="center_name" placeholder="Center Name" required>
<input type="text" name="location" placeholder="Location" required>
<input type="number" name="capacity" placeholder="Max Capacity" required>

<button name="add">Add Center</button>
</form>
</div>
