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
    <link rel="stylesheet" href="vendors/leaflet.js/leaflet.css" />
    <script src="vendors/leaflet.js/leaflet.js"></script>
    <link rel="stylesheet" href="css/navigation.css">

</head>

<body class="falcon-body">
  
    <main id="main_content" style="    height: 100vh">
    <div id="map-menu">
		<div class="button-map" style="top: 10px; left: 10px;"><svg id="button-map" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 37"><circle class="orange-fill" cx="18.5" cy="18.5" r="18.5"/><path class="white-fill" d="M11.95,6.86c-1.21,0-2.18.98-2.18,2.18v18.92c0,1.21.98,2.18,2.18,2.18h4.37v-3.64c0-1.21.98-2.18,2.18-2.18s2.18.98,2.18,2.18v3.64h4.37c1.21,0,2.18-.98,2.18-2.18V9.04c0-1.21-.98-2.18-2.18-2.18h-13.1ZM12.68,17.77c0-.4.33-.73.73-.73h1.46c.4,0,.73.33.73.73v1.46c0,.4-.33.73-.73.73h-1.46c-.4,0-.73-.33-.73-.73v-1.46ZM17.77,17.04h1.46c.4,0,.73.33.73.73v1.46c0,.4-.33.73-.73.73h-1.46c-.4,0-.73-.33-.73-.73v-1.46c0-.4.33-.73.73-.73ZM21.41,17.77c0-.4.33-.73.73-.73h1.46c.4,0,.73.33.73.73v1.46c0,.4-.33.73-.73.73h-1.46c-.4,0-.73-.33-.73-.73v-1.46ZM13.41,11.22h1.46c.4,0,.73.33.73.73v1.46c0,.4-.33.73-.73.73h-1.46c-.4,0-.73-.33-.73-.73v-1.46c0-.4.33-.73.73-.73ZM17.04,11.95c0-.4.33-.73.73-.73h1.46c.4,0,.73.33.73.73v1.46c0,.4-.33.73-.73.73h-1.46c-.4,0-.73-.33-.73-.73v-1.46ZM22.14,11.22h1.46c.4,0,.73.33.73.73v1.46c0,.4-.33.73-.73.73h-1.46c-.4,0-.73-.33-.73-.73v-1.46c0-.4.33-.73.73-.73Z"/></svg></div>
		<div class="label-map_return" style="    top: 16px;left: 50px;">Find rooms</div>
		</div>
        <button class="btn btn-success"  id="myLocation" style="top: 10px;right: 10px;    margin: 0;"><i class="fa-solid fa-location-crosshairs fa-xl"></i> FIND ME!</button>
        <button class="btn btn-primary"  id="reset_map" style="margin: 0;right: 0px;bottom: 55px;">RESET</button>
        <div id="map"></div>
        <script>
            let Navigate=document.querySelector('#button-map');
// let Campus=document.querySelector('#Campus');

  Navigate.addEventListener("click", function (e) {
  //  document.querySelector('#b building');
  window.location.assign("map-alone.php");
 // alert('go to building XX');

});
            var map = L.map('map').setView([49.2248636, -123.1087873], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
var personIcon = L.icon({
    iconUrl: 'images/person-marker.png',
    shadowUrl: 'images/LETTER-maker-shadow.png',

    iconSize:     [30, 40], // size of the icon
    shadowSize:   [50, 35], // size of the shadow
    iconAnchor:   [15, 40], // point of the icon which will correspond to marker's location
    shadowAnchor: [15, 35],  // the same for the shadow
    popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
});
var lIcon = L.icon({
    iconUrl: 'images/L-maker.png',
    shadowUrl: 'images/LETTER-maker-shadow.png',

    iconSize:     [30, 40], // size of the icon
    shadowSize:   [50, 35], // size of the shadow
    iconAnchor:   [15, 40], // point of the icon which will correspond to marker's location
    shadowAnchor: [15, 35],  // the same for the shadow
    popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
});
var aIcon = L.icon({
    iconUrl: 'images/A-maker.png',
    shadowUrl: 'images/LETTER-maker-shadow.png',

    iconSize:     [30, 40], // size of the icon
    shadowSize:   [50, 35], // size of the shadow
    iconAnchor:   [15, 40], // point of the icon which will correspond to marker's location
    shadowAnchor: [15, 35],  // the same for the shadow
    popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
});
var bIcon = L.icon({
    iconUrl: 'images/B-maker.png',
    shadowUrl: 'images/LETTER-maker-shadow.png',

    iconSize:     [30, 40], // size of the icon
    shadowSize:   [50, 35], // size of the shadow
    iconAnchor:   [15, 40], // point of the icon which will correspond to marker's location
    shadowAnchor: [15, 35],  // the same for the shadow
    popupAnchor:  [0, -40] // point from which the popup should open relative to the iconAnchor
});
let markerGroup = L.layerGroup().addTo(map);
let distanceGroup = L.layerGroup().addTo(map);

            function onLocationFound(e) {
                var radius = e.accuracy;
                markerGroup.clearLayers();
              let _location=e.latlng;
           //LOCATION INSIDE CAMPUS
            //    _location.lat= 49.224787500839724;
            //  _location.lng= -123.10855507850648;
            // LOCATION OUTSIDE CAMPUS BUT CLOSE
            //    _location.lat= 49.22444738692086;
            //  _location.lng= -123.11135530471803;
            // LOCATION OUTSIDE CAMPUS FAAAR
            //    _location.lat= 0;
            //  _location.lng= 0;
            
           //   radius=10;
                if(check_inside_campus(_location)){
                    L.marker(_location, {icon: personIcon}).addTo(markerGroup).bindPopup("<center><b>You are in Langara!</b> <br>  Your location is within <b>" + radius.toFixed(2) + " meters</b> from this point.</center>").openPopup();
                    L.circle(_location, radius).addTo(markerGroup);
                }else{
                  //  error_message('You are NOT in campus');
                 let distance_campus = check_distance_campus(_location);
                 if(distance_campus>1000){
                    distance_campus_label=(distance_campus/1000).toFixed(2)+' kilometers';
                 }else{
                    distance_campus_label=(distance_campus).toFixed(2)+' meters';
                 }

                 L.marker(_location, {icon: personIcon}).addTo(markerGroup).bindPopup("You are <b>" + distance_campus_label + "</b> away from Langara's main entrance").openPopup();
                 L.circle(_location, radius).addTo(markerGroup);
                }

               // L.marker(e.latlng).addTo(map)
                 //   .bindPopup("You are within " + radius.toFixed(2) + " meters from this point").openPopup();
                

                   

              
             //   alert(e.latlng);
     
            }

            // map.on('locationfound', onLocationFound);

            function onLocationError(e) {
                alert(e.message);
            }

            //map.on('locationerror', onLocationError);

            var imageUrl = 'images/langara-map.svg',
                imageBounds = [
                    [49.226359, -123.111319],
                    [49.223243, -123.105783]
                ];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);

            let myLocation = document.querySelector('#myLocation');
let reset_btn=document.querySelector('#reset_map');
reset_btn.addEventListener("click", function(e){
    map.setView([49.2248636, -123.1087873], 18);
    markerGroup.clearLayers();
    distanceGroup.clearLayers();
})

            myLocation.addEventListener("click", function(e) {
                map.locate({
                    setView: true,
                    maxZoom: 18
                });
               
                map.on('locationfound', onLocationFound);



                map.on('locationerror', onLocationError);
            });
            let _pointA,
                _pointB,
                _polyline,
                markerA = null,
                markerB = null;
                _markers = [];


            map.on('click', (e) => {
                _markers.push(e.latlng);
                    console.log(_markers);
      
                if (!_pointA) {
                    _pointA = e.latlng;
                    markerA = L.marker(_pointA, {icon: aIcon}).addTo(distanceGroup);
                    
                } else if (!_pointB) {
                    _pointB = e.latlng;
                    markerB = L.marker(_pointB, {icon: bIcon}).addTo(distanceGroup);
                    let length= map.distance(_pointA,_pointB); 
                    if(length>1000){
                        length_label=(length/1000).toFixed(2)+' kilometers';
                 }else{
                    length_label=(length).toFixed(2)+' meters';
                 }
                    _polyline = L.polyline([_pointA,_pointB],{
                        color:"#026e94"
                    }).addTo(distanceGroup).bindPopup("The distance is <b>" + length_label + "</b> in between these points").openPopup();;
                  
                    
                   
                    //alert(lenght.toFixed(2)+ ' meters');
                } else {
                    if(_polyline){
                        distanceGroup.removeLayer(_polyline);
                        _polyline=null;
                    }
                    _pointA=e.latlng;
                    distanceGroup.removeLayer(markerA);
                    distanceGroup.removeLayer(markerB);
                    _pointB=null;
                    markerA =L.marker(_pointA, {icon: aIcon}).addTo(distanceGroup);
                }

            });

function check_inside_campus(_pointA){
    let campus = L.polygon([
[ 49.22587281482377, -123.1110762227555],
[ 49.22395372492034, -123.11122622371536], 
[ 49.223757592070676, -123.11087202667794],
[ 49.223617496701394, -123.1061708659991],
[ 49.22570487657342, -123.10605280031997],
[ 49.225879988325495, -123.1110330253313]
]);
if(campus.getBounds().contains(_pointA)){
                        return true;
                    }else{
                        return false;
                    }

}
function check_distance_campus(_pointA){
    let campus_latlng={lat: 49.22519324913861, lng: -123.10758143663408};
   
                    markerA = L.marker(campus_latlng, {icon: lIcon}).addTo(markerGroup);
    let distance= map.distance(_pointA,campus_latlng); 
    _polyline = L.polyline([_pointA,campus_latlng],{
                        color:"#ff4200"
                    }).addTo(markerGroup);
                    var bounds = new L.LatLngBounds([_pointA,campus_latlng]);
                    map.fitBounds(bounds);
    return distance;
}
        </script>
    </main>
    <script src="vendors/sweetalert/sweetalert-v2.11.js"></script>
<script src="javascript/general.js" defer></script>


</body>

</html>