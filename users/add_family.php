<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['add'])){

    $email = $_POST['email'];

    $sql = "INSERT INTO family_members(user_id, family_email) VALUES(?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $email]);

    echo "<script>alert('✅ Family member added successfully!'); window.location='family_locator.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Family Member - SafeShelter</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #eef2f7;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

.container {
    background: white;
    padding: 40px 30px;
    margin-top: 60px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 90%;
    text-align: center;
}

h2 {
    color: #2c3e50;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

input[type="email"] {
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 1rem;
    width: 100%;
    box-sizing: border-box;
}

input[type="email"]:focus {
    outline: none;
    border-color: #3498db;
}

button {
    padding: 15px;
    border: none;
    border-radius: 10px;
    background: #3498db;
    color: white;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #217dbb;
}

@media(max-width: 500px){
    .container {
        padding: 30px 20px;
        margin-top: 30px;
    }
}
</style>
</head>
<body>

<div class="container">
    <h2>👨‍👩‍👧 Add Family Member</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter family email" required>
        <button type="submit" name="add">➕ Add</button>
    </form>
</div>

</body>
</html>
