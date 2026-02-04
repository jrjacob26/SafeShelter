<?php
require "../config/db.php";

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(fullname,email,password) VALUES(?,?,?)";
    $stmt = $pdo->prepare($sql);

    if($stmt->execute([$fullname,$email,$password])){
        header("Location: login.php");
    }
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>User Register</h2>

<form method="POST">
<input type="text" name="fullname" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="register">Register</button>
</form>

<div class="link">
<a href="login.php">Already have an account?</a>
</div>
</div>
