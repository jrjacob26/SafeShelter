<?php
session_start();
require "../config/db.php";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
    }else{
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>User Login</h2>

<form method="POST">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>
</form>

<div class="link">
<a href="register.php">Create Account</a>
</div>
</div>
