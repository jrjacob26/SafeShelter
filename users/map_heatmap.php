<?php
session_start();
require "../config/db.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

// Fetch evacuation centers from DB
$centers = $pdo->query("SELECT center_name, latitude, longitude, max_capacity, current_capacity FROM evacuation_centers")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SafeShelter Heatmap</title>

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        .topbar {
            position: fixed;
            width: 100%;
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            z-index: 1;
        }

        #map-container {
            margin-top: 60px; /* space for topbar */
            height: calc(100% - 60px);
        }
    </style>
</head>
<body>

<div class="topbar">🗺️ SafeShelter: Crowded Shelter Heatmap</div>
<div id="map-container">
    <div id="map"></div>
</div>

<script>
// Convert PHP array to JS
const centers = <?php echo json_encode($centers); ?>;

function initMap() {
    // Default center of map
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat: 13.1391, lng: 123.7438}, // Change to your city coordinates
        mapTypeId: 'roadmap'
    });

    // Prepare heatmap data
    const heatData = centers.map(c => {
        return {
            location: new google.maps.LatLng(parseFloat(c.latitude), parseFloat(c.longitude)),
            weight: (c.current_capacity / c.max_capacity) * 10 // Adjust multiplier for visibility
        };
    });

    // Create heatmap layer
    const heatmap = new google.maps.visualization.HeatmapLayer({
        data: heatData,
        dissipating: true,
        radius: 50,
        opacity: 0.7
    });

    heatmap.setMap(map);

    // Optional: Add markers for each center
    centers.forEach(c => {
        const marker = new google.maps.Marker({
            position: {lat: parseFloat(c.latitude), lng: parseFloat(c.longitude)},
            map: map,
            title: c.center_name
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<h3>${c.center_name}</h3>
                      <p>Capacity: ${c.current_capacity} / ${c.max_capacity}</p>`
        });

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
    });
}
</script>

<!-- Google Maps JS with Visualization library -->
<script async
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization&callback=initMap">
</script>

</body>
</html>
