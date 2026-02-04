<?php
session_start();
require "../config/db.php";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $admin = $stmt->fetch();

    if($admin && password_verify($password,$admin['password'])){
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
    }else{
        echo "<script>alert('Invalid Admin Login');</script>";
    }
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>Admin Login</h2>

<form method="POST">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>
</form>
</div>
