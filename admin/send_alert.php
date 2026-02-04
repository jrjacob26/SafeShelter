<?php
session_start();
require "../config/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
}

if(isset($_POST['send'])){

    $title = $_POST['title'];
    $message = $_POST['message'];
    $level = $_POST['level'];

    $sql = "INSERT INTO alerts(title,message,alert_level)
            VALUES(?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title,$message,$level]);

    echo "<script>alert('Alert Broadcasted Successfully!');</script>";
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="container">
<h2>🚨 Broadcast Disaster Alert</h2>

<form method="POST">

<input type="text" name="title" placeholder="Alert Title" required>

<textarea name="message"
placeholder="Type disaster instructions..."
style="width:100%;height:120px;padding:10px;border-radius:8px;"
required></textarea>

<select name="level" required>
<option value="LOW">LOW RISK</option>
<option value="MODERATE">MODERATE</option>
<option value="CRITICAL">CRITICAL</option>
</select>

<button name="send">SEND ALERT</button>

</form>
</div>
