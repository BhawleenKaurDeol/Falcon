<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falcon APP - NAVIGATION</title>
    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/navigation.css">
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main_content">
    <button class="btn btn-success" style="position: absolute; top:20px; right: 20px; z-index: 1000;;" id="myLocation"><i class="fa-solid fa-location-crosshairs"></i> Find my location</button>
    <div id="map"></div>
    <script>
       
        var map = L.map('map').setView([49.2248636, -123.1087873], 18);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);


function onLocationFound(e) {
    var radius = e.accuracy;

    L.marker(e.latlng).addTo(map)
        .bindPopup("You are within " + radius + " meters from this point").openPopup();

    L.circle(e.latlng, radius).addTo(map);
}

// map.on('locationfound', onLocationFound);

function onLocationError(e) {
    alert(e.message);
}

//map.on('locationerror', onLocationError);

var imageUrl = 'images/langara-map.svg',
    imageBounds = [[49.226359, -123.111319], [49.223243, -123.105783]];
L.imageOverlay(imageUrl, imageBounds).addTo(map);

let myLocation=document.querySelector('#myLocation');


myLocation.addEventListener("click", function (e) {
    map.locate({setView: true, maxZoom: 20});
    map.on('locationfound', onLocationFound);



map.on('locationerror', onLocationError);
  });

    </script>
    </main>
<?php
include "footer.php";
?>
    
</body>
</html>