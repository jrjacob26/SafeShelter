<?php
require "../config/db.php";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins(admin_name,email,password) VALUES(?,?,?)";
    $stmt = $pdo->prepare($sql);

    if($stmt->execute([$name,$email,$password])){
        header("Location: login.php");
    }
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>Admin Register</h2>

<form method="POST">
<input type="text" name="name" placeholder="Admin Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="register">Register</button>
</form>
</div>
