<?php
session_start();
require "../config/db.php";
require "../libs/phpqrcode/qrlib.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
}

$centers = $pdo->query("SELECT * FROM evacuation_centers")->fetchAll();

?>

<h1>QR Codes for Evacuation Centers</h1>

<?php foreach($centers as $c): ?>
<div style="margin-bottom:30px;">
<h3><?= $c['center_name'] ?></h3>

<?php 
// Generate QR code for check-in URL
$url = "http://localhost/users/qr_checkin.php?center_id=".$c['id'];
QRcode::png($url, false, QR_ECLEVEL_L, 5);
?>
<p>Scan this QR to check-in.</p>
</div>
<?php endforeach; ?>
