<?php
session_start();
require "../config/db.php";

$user_id = $_SESSION['user_id'];

$sql = "
SELECT u.fullname,
e.center_name,
e.location,
c.checkin_time

FROM family_members f

JOIN users u
ON u.email = f.family_email

LEFT JOIN checkins c
ON u.id = c.user_id

LEFT JOIN evacuation_centers e
ON c.center_id = e.id

WHERE f.user_id = ?
ORDER BY c.checkin_time DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$family = $stmt->fetchAll();
?>

<h1>📍 Family Locator</h1>

<table border="1" cellpadding="12">

<tr>
<th>Name</th>
<th>Evacuation Center</th>
<th>Location</th>
<th>Last Check-in</th>
</tr>

<?php foreach($family as $f): ?>

<tr>
<td><?= $f['fullname'] ?? 'Not Registered Yet' ?></td>

<td>
<?= $f['center_name'] ?? 
"<span style='color:red;'>Not Checked-in</span>" ?>
</td>

<td><?= $f['location'] ?? '-' ?></td>

<td><?= $f['checkin_time'] ?? '-' ?></td>

</tr>

<?php endforeach; ?>

</table>
