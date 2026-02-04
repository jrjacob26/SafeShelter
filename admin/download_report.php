<?php
require "../config/db.php";

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=evacuation_report.csv');

$out = fopen('php://output', 'w');
fputcsv($out, ['Center Name','Location','Max Capacity','Current Capacity','Last Check-in']);

$centers = $pdo->query("SELECT * FROM evacuation_centers")->fetchAll();

foreach($centers as $c){
    // Get last check-in time
    $last = $pdo->query("SELECT checkin_time FROM checkins WHERE center_id={$c['id']} ORDER BY checkin_time DESC LIMIT 1")->fetchColumn();
    fputcsv($out, [$c['center_name'],$c['location'],$c['max_capacity'],$c['current_capacity'],$last]);
}

fclose($out);
exit;
