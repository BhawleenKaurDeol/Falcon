<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$disabled = ($_GET['disabled'] ?? 'off');
if (isset($_GET['id_room'])) {

    header('Location: map-building-alone.php?' . get_link_room_highlighted($_GET['id_room']) . ($disabled == 'on' ? '&disabled=on' : ''));
}
//if($_GET['building']=='b-building'){
$query = "SELECT * from building WHERE code_building='" . $_GET['building'] . "'";
$map_query = tep_db_query($query);
$total = mysqli_num_rows($map_query);
//echo $total;
if ($total > 0) {

    while ($building = tep_db_fetch_array($map_query)) {
        $id_building = $building['id_building'];
        $name_building = $building['name_building'];
        $level = $building['default_level'];
    }
}
// $level='level-0';
if (isset($_GET['level'])) {
    $level = $_GET['level'];
}

$query = "SELECT * from floor WHERE id_building='" . $id_building . "' AND code_floor='" . $level . "'";
$map_query = tep_db_query($query);
$total = mysqli_num_rows($map_query);

if ($total > 0) {

    while ($floor = tep_db_fetch_array($map_query)) {
        $id_floor = $floor['id_floor'];
        $name_floor = $floor['name_floor'];
        $map = $floor['map_floor'];
    }
}


// }else{
// header("Location: map.php");
//  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "headers_scripts.php";
    ?>
    <script>
        <?php
        $r_query = "SELECT * from room WHERE id_floor='" . $id_floor . "'";
        $room_query = tep_db_query($r_query);
        $total_rooms = mysqli_num_rows($room_query);

        if ($total_rooms > 0) {
            echo 'const rooms=[';
            while ($rooms = tep_db_fetch_array($room_query)) {
                $id_room = $rooms['id_room'];
                $code_room = $rooms['code_room'];
                echo "{code_room:'$code_room',id_room:'$id_room'},";
            }
            echo '];';
        }

        ?>
    </script>
    <script src="javascript/floor.js" defer></script>
    <script src="vendors/svg-zoom/hammer.js"></script>
    <script src="vendors/svg-zoom/svg-pan-zoom.js"></script>
    <link rel="stylesheet" href="css/building.css">

</head>

<body class="falcon-body">

    <main class="map-container" style="height: 100vh; overflow: hidden;">
        <div id="label-menu">

            <!-- <h1 class="label-map"><?= '<a href="map-alone.php">' . $name_building . '</a> &gt; ' . $name_floor ?></h1> -->
            <div class="button-menu"><svg id="button-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.74 37.74">
                    <circle class="orange-fill" cx="18.87" cy="18.87" r="18.87" />
                    <path class="white-fill" d="M17.4,7.25c.65-.3,1.41-.3,2.06,0l9.6,4.43c.37.17.61.54.61.96s-.24.79-.61.96l-9.6,4.43c-.65.3-1.41.3-2.06,0l-9.6-4.43c-.37-.18-.61-.55-.61-.96s.24-.79.61-.96l9.6-4.43ZM26.72,16.22l2.34,1.08c.37.17.61.54.61.96s-.24.79-.61.96l-9.6,4.43c-.65.3-1.41.3-2.06,0l-9.6-4.43c-.37-.18-.61-.55-.61-.96s.24-.79.61-.96l2.34-1.08,6.67,3.08c1.03.47,2.21.47,3.24,0l6.67-3.08h0ZM20.05,24.92l6.67-3.08,2.34,1.08c.37.17.61.54.61.96s-.24.79-.61.96l-9.6,4.43c-.65.3-1.41.3-2.06,0l-9.6-4.43c-.37-.18-.61-.55-.61-.96s.24-.79.61-.96l2.34-1.08,6.67,3.08c1.03.47,2.21.47,3.24,0h0Z" />
                </svg></div>
            <div class="options-menu hide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.29 350.46">
                    <g id="bg">
                        <rect class="cls-20" width="150.29" height="350.46" />
                    </g>
                    <g id="vending_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="321.85" width="134.41" height="21.86" /><text class="cls-8" transform="translate(35.22 335.71)">
                            <tspan x="0" y="0">Vending Machine</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="329.02" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,329.87c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.32,332.87c0,3.62-2.94,6.57-6.57,6.57s-6.57-2.94-6.57-6.57,2.94-6.57,6.57-6.57,6.57,2.94,6.57,6.57" />
                        <path class="cls-17" d="M25.78,328.92v7.49h-.65v.28h-2.74v-.28h-.64v-7.49h4.02ZM24.07,330.27h.98v-.67h-.98v.67ZM24.07,331.48h.98v-.67h-.98v.67ZM24.07,332.7h.98v-.67h-.98v.67ZM22.48,330.27h.98v-.67h-.98v.67ZM22.48,331.48h.98v-.67h-.98v.67ZM25.39,333.54h-3.24v1.11h3.24v-1.11Z" />
                        <rect class="cls-17" x="22.8" y="333.6" width=".49" height=".98" transform="translate(-306.65 275.34) rotate(-75.95)" />
                        <path class="cls-17" d="M19.45,330.36c.34.07.66-.15.73-.48.07-.33-.15-.66-.48-.73-.34-.07-.66.15-.73.48-.07.33.15.66.48.73" />
                        <path class="cls-17" d="M21.42,333.04c-.08-.15-.94-1.87-.98-1.95-.1-.2-.25-.35-.47-.4-.22-.04-1.19-.23-1.4-.27-.43-.09-.85.19-.94.62-.04.22-.38,1.7-.41,1.85-.03.15.06.29.21.32.15.03.29-.06.32-.21.03-.17.37-1.66.37-1.66l.26.06-.37,1.67v3.4c0,.2.16.36.36.36s.36-.16.36-.36v-2.77h.26v2.77c0,.2.16.36.36.36s.37-.16.37-.36v-3.11l.33-1.64.11.02s.71,1.44.77,1.55c.07.13.23.19.36.12.13-.07.19-.23.12-.36" />
                    </g>
                    <g id="parking_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="295.63" width="134.17" height="21.86" /><text class="cls-7" transform="translate(35.21 309.5)">
                            <tspan class="cls-26" x="0" y="0">P</tspan>
                            <tspan class="cls-25" x="4.4" y="0">a</tspan>
                            <tspan class="cls-24" x="8.57" y="0">r</tspan>
                            <tspan class="cls-27" x="11.21" y="0">k</tspan>
                            <tspan class="cls-12" x="15.39" y="0">i</tspan>
                            <tspan class="cls-28" x="17.51" y="0">n</tspan>
                            <tspan class="cls-23" x="22.24" y="0">g Pay Station</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="302.8" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,303.64c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.3,306.64c-.07,3.61-3.05,6.49-6.67,6.43-3.61-.07-6.49-3.06-6.42-6.67.07-3.61,3.05-6.49,6.67-6.42,3.62.07,6.49,3.05,6.42,6.67" />
                        <path class="cls-17" d="M22.51,307.4h-1.57v3.08h-1.59v-8.18h3.17c1.69,0,2.7,1.16,2.7,2.55s-1.01,2.55-2.7,2.55M22.43,303.73h-1.49v2.24h1.49c.72,0,1.18-.45,1.18-1.11s-.46-1.12-1.18-1.12" />
                    </g>
                    <g id="water_station_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="269.4" width="134.17" height="21.86" /><text class="cls-10" transform="translate(35.22 282.9)">
                            <tspan x="0" y="0">Water Station</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="276.57" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,277.42c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.25,280.32c-.06,3.6-3.02,6.46-6.61,6.4-3.59-.06-6.46-3.02-6.4-6.61.06-3.59,3.02-6.45,6.61-6.4,3.59.06,6.46,3.02,6.4,6.61" />
                        <path class="cls-17" d="M23.56,279c.06,0,.12-.05.12-.11,0-.07-.05-.12-.12-.12s-.11.05-.11.12c0,.06.05.11.11.11M23.69,278.56c0-.07-.05-.12-.12-.12s-.12.05-.12.12.05.12.12.12.12-.05.12-.12M24.35,277.93c0-.07-.06-.13-.13-.13s-.13.06-.13.13.06.13.13.13.13-.06.13-.13M24.68,277.92c0-.07-.06-.14-.14-.14s-.14.06-.14.14.06.14.14.14.14-.06.14-.14M23.86,279.01c.06,0,.11-.05.11-.12s-.05-.11-.11-.11-.12.05-.12.11.05.12.12.12M24,278.58c0-.06-.05-.12-.12-.12s-.12.06-.12.12.05.12.12.12.12-.05.12-.12M24.18,278.32c0-.07-.06-.13-.13-.13-.07,0-.13.06-.13.13s.06.13.13.13c.07,0,.13-.06.13-.13M24.48,278.21c0-.07-.06-.13-.13-.13s-.13.06-.13.13c0,.08.06.14.13.14s.13-.06.13-.14M23.12,278.02c.5,0,.9-.4.9-.9s-.4-.9-.9-.9-.9.4-.9.9.4.9.9.9M19.82,284.26v-4.32l1.6-.84v.8c0,.1.01.11.08.19,0,0,.77.84.98,1.08.16.16.43.16.6,0,.16-.17.16-.42,0-.6-.22-.24-.8-.89-.8-.89v-1.56c0-.23-.09-.46-.27-.63-.28-.27-.69-.35-1.02-.18-.44.23-1.65.87-1.97,1.03-.35.18-.6.45-.6.84v5.07c0,.38.31.68.69.68s.69-.3.69-.68M24.03,278.03c0-.07-.06-.13-.13-.13s-.13.06-.13.13.06.13.13.13.13-.06.13-.13M25.84,279.08h-2.95c-.19,0-.35.15-.35.35,0,.09.04.18.1.25.15.16,1.76,1.95,1.76,1.95h1.44v-2.55ZM23.81,278.26c0-.07-.05-.12-.12-.12s-.12.05-.12.12c0,.06.05.12.12.12s.12-.06.12-.12M25,278.06c0-.08-.06-.14-.14-.14s-.14.06-.14.14.06.14.14.14.14-.06.14-.14M25.12,278.46c.08,0,.15-.07.15-.15s-.07-.14-.15-.14-.15.06-.15.14c0,.08.07.15.15.15M24.78,278.31c0-.08-.06-.14-.14-.14-.08,0-.14.06-.14.14s.06.14.14.14.14-.06.14-.14M24.87,278.7c.08,0,.15-.06.15-.14s-.07-.14-.15-.14-.15.06-.15.14.07.14.15.14" />
                    </g>
                    <g id="bank_label" class="button-label">
                        <rect class="cls-16" x="8.42" y="243.18" width="134.03" height="21.86" /><text class="cls-1" transform="translate(35.69 257.21)">
                            <tspan x="0" y="0">Bank Machine</tspan>
                        </text>
                        <rect class="cls-17" x="124.19" y="250.35" width="7.53" height="7.52" />
                        <path class="cls-13" d="M133.04,251.19c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.25,254.07c-.06,3.6-3.02,6.46-6.61,6.4-3.59-.06-6.46-3.02-6.4-6.61.06-3.59,3.02-6.45,6.61-6.4,3.59.06,6.46,3.02,6.4,6.61" />
                        <path class="cls-17" d="M19.39,253.78l-.19-.58h-1.08l-.2.58h-.55l.99-2.86h.65l1.01,2.86h-.61ZM18.76,251.9c-.05-.14-.08-.27-.11-.39h0c-.03.13-.07.26-.11.39l-.29.85h.81l-.29-.85Z" />
                        <polygon class="cls-17" points="21.47 251.39 21.47 253.78 20.92 253.78 20.92 251.39 20.18 251.39 20.18 250.92 22.22 250.92 22.22 251.39 21.47 251.39" />
                        <path class="cls-17" d="M25.58,253.78l-.21-1.38c-.04-.26-.07-.52-.09-.72h0c-.04.18-.09.42-.16.65l-.46,1.44h-.54l-.44-1.34c-.08-.25-.14-.52-.19-.76h0c-.02.26-.05.51-.08.76l-.17,1.34h-.55l.43-2.86h.65l.48,1.48c.05.15.11.4.16.6h0c.05-.22.11-.43.16-.6l.49-1.49h.64l.45,2.86h-.57Z" />
                        <path class="cls-17" d="M21.9,257.69v.52h-.39v-.49c-.19,0-.35-.03-.51-.05l.04-.49c.17.06.37.09.54.09.27,0,.45-.09.45-.32,0-.47-1.13-.27-1.13-1.15,0-.38.27-.67.67-.75v-.43h.39v.4c.15,0,.3.02.43.05l-.03.46c-.17-.05-.34-.07-.47-.07-.31,0-.42.13-.42.28,0,.44,1.14.28,1.14,1.14,0,.39-.26.7-.7.8" />
                    </g>
                    <g id="washroom_male_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="216.96" width="134.41" height="21.86" /><text class="cls-4" transform="translate(35.22 230.81)">
                            <tspan x="0" y="0">Washroom,
                                Male</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="224.12" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,224.97c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.3,227.78c-.06,3.61-3.03,6.5-6.65,6.44-3.61-.06-6.5-3.04-6.44-6.65.07-3.61,3.05-6.49,6.66-6.44,3.62.05,6.49,3.04,6.44,6.65" />
                        <path class="cls-17" d="M24.25,225.4c0-.2.15-.36.35-.36s.35.16.35.36-.15.35-.35.35-.35-.16-.35-.35" />
                        <path class="cls-17" d="M25.86,227.6h-1.16c-.18,0-.35-.14-.36-.33l-.06-1.09c0-.19.14-.36.33-.37.19-.01.35.14.36.33l.03.37h.66c.09,0,.16.07.16.16s-.07.15-.16.16h-.64v.2h.9c.07,0,.14.04.18.1l.64,1.1c.06.1.03.23-.07.29-.1.06-.23.02-.29-.07l-.51-.86" />
                        <path class="cls-17" d="M25.88,227.92c-.07.52-.51.91-1.04.91-.59,0-1.07-.47-1.07-1.06,0-.34.15-.64.4-.83l-.02-.33c-.4.23-.66.67-.66,1.16,0,.74.59,1.35,1.34,1.35.56,0,1.04-.36,1.24-.86l-.2-.34" />
                        <path class="cls-17" d="M20.35,224.26c.46,0,.84-.38.84-.85s-.38-.85-.84-.85-.85.38-.85.85.38.85.85.85" />
                        <path class="cls-17" d="M19.45,224.45c-.6,0-1.08.49-1.08,1.1v2.6c0,.51.74.51.74,0v-2.38h.17v6.51c0,.67.98.65.98,0v-3.77h.17v3.77c0,.65.99.67.99,0v-6.51h.17v2.38c0,.51.74.51.73,0v-2.58c0-.56-.43-1.11-1.09-1.11h-1.78" />
                    </g>
                    <g id="washroom_female_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="190.73" width="134.17" height="21.86" /><text class="cls-9" transform="translate(35.21 204.6)">
                            <tspan x="0" y="0">Washroom,
                                Female</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="197.9" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,198.74c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.19,201.55c-.06,3.56-2.99,6.4-6.55,6.34-3.55-.06-6.4-2.99-6.34-6.55.06-3.56,2.99-6.39,6.55-6.34,3.56.06,6.4,2.99,6.34,6.55" />
                        <path class="cls-17" d="M20.49,198.05c.45,0,.82-.36.82-.81s-.37-.82-.82-.82-.81.37-.81.82.36.81.81.81" />
                        <path class="cls-17" d="M20.37,203.23v2.85c0,.51-.77.51-.77,0v-2.85h-1.02l1.09-3.78h-.18l-.63,2.16c-.15.47-.8.28-.65-.23l.71-2.35c.08-.27.41-.74,1-.74h1.12c.58,0,.92.47,1.01.74l.72,2.35c.14.5-.51.71-.66.22l-.64-2.15h-.18l1.1,3.78h-1.02v2.86c0,.51-.77.51-.77,0v-2.86h-.22" />
                        <path class="cls-17" d="M24.23,199.17c0-.19.16-.35.35-.35s.36.16.36.35-.16.35-.36.35-.35-.16-.35-.35" />
                        <path class="cls-17" d="M25.83,201.34h-1.14c-.19,0-.35-.13-.36-.32l-.06-1.07c0-.19.13-.35.32-.36.19-.01.35.13.36.32l.03.37h.66c.09,0,.16.07.16.16,0,.09-.07.15-.16.16h-.65l.02.2h.88c.07,0,.13.03.17.1l.64,1.08c.05.1.02.22-.08.28-.1.06-.22.02-.28-.07l-.5-.85" />
                        <path class="cls-17" d="M25.84,201.66c-.08.51-.51.9-1.03.9-.58,0-1.05-.47-1.05-1.05,0-.33.15-.63.4-.82l-.02-.32c-.39.23-.65.66-.65,1.15,0,.73.58,1.32,1.32,1.32.55,0,1.04-.35,1.22-.84l-.19-.33" />
                    </g>
                    <g id="washroom_all_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="164.51" width="134.17" height="21.86" /><text class="cls-10" transform="translate(35.22 178.01)">
                            <tspan x="0" y="0">Washroom,
                                All Gender</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="171.68" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,172.52c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.12,175.49c-.05,3.52-2.95,6.32-6.47,6.27-3.51-.06-6.33-2.96-6.27-6.47.05-3.52,2.95-6.32,6.47-6.27,3.52.06,6.33,2.95,6.27,6.48" />
                        <path class="cls-17" d="M24.23,173.14c0-.19.16-.35.35-.35s.35.16.35.35-.15.35-.35.35-.35-.16-.35-.35" />
                        <path class="cls-17" d="M25.82,175.28h-1.13c-.18,0-.34-.13-.35-.31l-.06-1.06c-.01-.19.13-.35.31-.35.19,0,.35.13.36.31l.02.37h.65c.09,0,.16.07.16.16s-.07.16-.16.16h-.63v.2h.88c.07,0,.13.03.17.1l.64,1.07c.05.1.02.22-.07.28-.09.05-.22.02-.28-.07l-.5-.84" />
                        <path class="cls-17" d="M25.83,175.59c-.07.5-.51.89-1.03.89-.57,0-1.04-.46-1.04-1.03,0-.33.16-.62.39-.81v-.32c-.4.22-.66.65-.66,1.13,0,.72.59,1.31,1.3,1.31.55,0,1.03-.34,1.22-.83l-.19-.33" />
                        <path class="cls-22" d="M18.86,170.97s-.08.03-.12.06c-.03.01-.11.04-.11.07,0,.04.07.09.1.1.05.02.16,0,.22,0h3.17c.08,0,.17,0,.22,0,.03,0,.11-.05.1-.1,0-.02-.08-.05-.11-.06-.05-.03-.09-.04-.13-.06-.08-.03-.17-.09-.26-.1-.12-.02-.23,0-.35,0h-2.12c-.12,0-.26-.01-.36,0-.09.02-.17.07-.26.1" />
                        <path class="cls-22" d="M18.64,171.72v1.38c0,.13-.03.45.03.52.04.05.14.04.23.04h3.23c.09,0,.18,0,.22-.02.07-.05.06-.18.06-.31v-1.63c0-.09,0-.22-.01-.26-.04-.07-.13-.07-.25-.07h-3.19c-.07,0-.18,0-.23,0-.12.03-.09.19-.09.34" />
                        <path class="cls-22" d="M19.44,174.09c-.06.03-.19.08-.19.15,0,.09.14.14.23.17.32.1.68.12,1.08.12s.78-.02,1.08-.12c.08-.03.24-.08.24-.17,0-.05-.05-.09-.11-.12-.14-.07-.4-.11-.56-.13-.26-.03-.57-.05-.88-.03-.32.02-.65.04-.9.13" />
                        <path class="cls-22" d="M18.79,174.47c.03.5.27.9.55,1.16.28.27.69.49,1.22.49.53-.01.94-.21,1.23-.5.27-.27.48-.59.54-1.07,0-.02.02-.06,0-.09-.07.01-.11.07-.16.11-.05.03-.12.06-.19.09-.63.25-1.67.27-2.42.12-.22-.05-.44-.1-.61-.2-.05-.04-.12-.11-.17-.11,0,0,0,0,0,0" />
                        <path class="cls-22" d="M19.61,176.07c-.03.33-.06.62-.1.95,0,.07-.05.26,0,.31.04.03.17.02.26.02h1.6c.08,0,.22.02.25-.02.02-.03,0-.09,0-.16-.03-.38-.08-.75-.12-1.12-.26.13-.56.24-.93.24-.29,0-.52-.06-.72-.15-.07-.03-.15-.08-.21-.09,0,0-.01,0-.01.01" />
                        <path class="cls-18" d="M19.12,170.87c.09-.01.24,0,.36,0h2.12c.12,0,.23-.02.35,0,.09.01.17.07.26.1.03.01.08.03.13.06.03.02.1.04.11.07,0,.05-.07.09-.1.1-.05.02-.14,0-.22,0h-3.17c-.06,0-.17.01-.22,0-.03,0-.1-.05-.09-.1,0-.03.07-.05.11-.07.04-.02.08-.04.12-.05.09-.04.17-.09.26-.11" />
                        <path class="cls-18" d="M18.74,171.38s.16,0,.23,0h3.19c.12,0,.21-.01.25.07.02.04.01.17.01.26v1.63c0,.13.01.26-.06.31-.04.02-.14.02-.22.02h-3.23c-.1,0-.2,0-.23-.04-.06-.07-.03-.39-.03-.52v-1.38c0-.16-.03-.32.09-.34" />
                        <path class="cls-18" d="M19.63,171.79c.02-.27-.32-.21-.58-.22-.11,0-.2-.02-.21.07,0,.14.26.07.39.09-.05.31.38.31.4.06" />
                        <path class="cls-14" d="M19.23,171.73c-.13-.02-.39.05-.39-.09,0-.09.1-.07.21-.07.26,0,.6-.05.58.22-.02.25-.45.25-.4-.06" />
                        <path class="cls-18" d="M20.34,173.96c.31-.02.61,0,.88.03.15.02.41.06.56.13.05.03.11.07.11.12,0,.09-.15.14-.24.17-.3.1-.69.12-1.08.12-.41,0-.76-.02-1.08-.12-.09-.03-.23-.08-.23-.17,0-.07.13-.13.19-.15.25-.09.57-.11.9-.13" />
                        <path class="cls-18" d="M18.8,174.46s.11.08.17.11c.17.1.39.16.61.2.75.15,1.79.13,2.42-.12.07-.02.13-.05.19-.09.05-.04.09-.09.16-.1.02.02,0,.06,0,.09-.05.47-.27.8-.54,1.07-.29.28-.7.49-1.23.49-.53.01-.95-.22-1.22-.48-.29-.26-.53-.66-.55-1.16,0,0,0-.01,0-.01" />
                        <path class="cls-18" d="M19.62,176.05c.06,0,.14.07.21.09.2.08.43.14.72.14.38,0,.67-.11.93-.24.04.36.08.73.12,1.11,0,.07.02.13,0,.16-.03.04-.17.02-.25.02h-1.59c-.08,0-.22.02-.26-.02-.05-.05,0-.24,0-.31.04-.33.06-.62.09-.95,0,0,.01-.01.01-.02" />
                        <path class="cls-17" d="M17.93,178.36h.1l.45,1h-.15l-.13-.3h-.43l-.12.3h-.15l.43-1ZM18.14,178.94l-.16-.36-.16.36h.31Z" />
                        <polygon class="cls-17" points="18.59 178.36 18.74 178.36 18.74 179.23 19.18 179.23 19.18 179.36 18.59 179.36 18.59 178.36" />
                        <polygon class="cls-17" points="19.31 178.36 19.45 178.36 19.45 179.23 19.9 179.23 19.9 179.36 19.31 179.36 19.31 178.36" />
                        <rect class="cls-17" x="19.97" y="178.96" width=".36" height=".14" />
                        <path class="cls-17" d="M21.04,178.87h.34v.42c-.13.05-.24.08-.37.08-.16,0-.29-.05-.39-.15-.1-.1-.15-.22-.15-.36s.06-.27.16-.37c.1-.1.23-.15.38-.15.06,0,.11,0,.16.02.05.01.11.03.19.07v.15c-.11-.07-.23-.11-.35-.11-.11,0-.2.04-.28.12-.08.07-.11.16-.11.27,0,.12.03.21.11.28.07.07.17.11.29.11.05,0,.13-.02.2-.04h.02v-.21h-.19v-.13Z" />
                        <polygon class="cls-17" points="21.58 178.36 22.15 178.36 22.15 178.49 21.73 178.49 21.73 178.79 22.13 178.79 22.13 178.92 21.73 178.92 21.73 179.23 22.16 179.23 22.16 179.36 21.58 179.36 21.58 178.36" />
                        <polygon class="cls-17" points="23.11 178.36 23.25 178.36 23.25 179.36 23.13 179.36 22.46 178.59 22.46 179.36 22.32 179.36 22.32 178.36 22.44 178.36 23.11 179.14 23.11 178.36" />
                        <path class="cls-17" d="M23.46,179.36v-1h.34c.14,0,.24.02.32.07.08.04.15.1.19.18.05.08.07.17.07.26,0,.07-.01.13-.04.19-.02.06-.06.12-.11.16-.04.05-.1.08-.17.11-.04.02-.07.02-.1.03-.04,0-.09,0-.18,0h-.32ZM23.79,178.49h-.18v.74h.18c.07,0,.13,0,.17-.01.04,0,.07-.02.11-.04.02,0,.04-.03.07-.05.07-.07.11-.16.11-.27s-.04-.2-.11-.26c-.03-.03-.07-.05-.09-.06-.04-.02-.07-.03-.1-.03-.03,0-.08,0-.14,0" />
                        <polygon class="cls-17" points="24.56 178.36 25.12 178.36 25.12 178.49 24.7 178.49 24.7 178.79 25.11 178.79 25.11 178.92 24.7 178.92 24.7 179.23 25.14 179.23 25.14 179.36 24.56 179.36 24.56 178.36" />
                        <path class="cls-17" d="M25.29,179.36v-1h.26c.1,0,.18.03.24.08.06.05.08.12.08.2,0,.06-.02.11-.04.15-.03.04-.07.08-.13.1.03.02.06.05.1.09.03.03.07.1.12.19.03.05.06.1.08.13l.05.07h-.16l-.05-.07s0,0,0-.01l-.03-.04-.04-.07-.06-.08s-.05-.08-.07-.1c-.03-.03-.05-.04-.07-.05-.02-.01-.06-.01-.1-.01h-.04v.43h-.14ZM25.48,178.48h-.05v.31h.05c.08,0,.12,0,.15-.02.03-.01.05-.03.06-.06.01-.02.02-.05.02-.09,0-.03,0-.06-.02-.08-.02-.03-.04-.05-.07-.05-.03-.01-.08-.02-.15-.02" />
                    </g>
                    <g id="accessible_label" class="button-label">
                        <rect class="cls-16" x="8.42" y="138.28" width="134.03" height="21.86" /><text class="cls-1" transform="translate(35.69 152.32)">
                            <tspan x="0" y="0">Accessible Entry</tspan>
                        </text>
                        <path class="cls-19" d="M28.31,149.39c0,3.47-2.82,6.28-6.29,6.28s-6.29-2.81-6.29-6.28,2.82-6.28,6.29-6.28,6.29,2.81,6.29,6.28" />
                        <path class="cls-17" d="M20.25,145.21c0-.45.37-.82.82-.82s.82.37.82.82-.37.81-.82.81-.82-.36-.82-.81" />
                        <path class="cls-17" d="M23.99,150.23h-2.67c-.44,0-.8-.31-.84-.74l-.14-2.48c-.02-.44.31-.81.75-.83.44-.02.81.31.84.74l.05.85h1.54c.21,0,.37.16.37.37s-.17.36-.37.37h-1.5l.02.46h2.06c.16,0,.31.09.4.23l1.5,2.5c.13.24.06.52-.17.65-.23.13-.53.05-.66-.17l-1.18-1.97Z" />
                        <path class="cls-17" d="M24.03,150.97c-.17,1.17-1.19,2.07-2.42,2.07-1.35,0-2.45-1.09-2.45-2.43,0-.77.36-1.46.93-1.9l-.04-.75c-.92.53-1.53,1.52-1.53,2.65,0,1.7,1.38,3.07,3.1,3.07,1.31,0,2.43-.81,2.88-1.95l-.46-.77Z" />
                        <rect class="cls-17" x="124.19" y="145.45" width="7.53" height="7.52" />
                        <path class="cls-13" d="M133.04,146.3c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                    </g>
                    <g id="staircase_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="112.06" width="134.17" height="21.86" /><text class="cls-11" transform="translate(35.22 126.11)">
                            <tspan x="0" y="0">Staircase</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="119.23" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,120.07c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-21" d="M28.03,123.16c-.06,3.56-2.99,6.39-6.55,6.34-3.55-.06-6.4-2.99-6.34-6.55.05-3.56,2.99-6.4,6.54-6.34,3.57.05,6.4,2.99,6.34,6.55" />
                        <path class="cls-15" d="M28.03,123.05c0,3.57-2.88,6.45-6.45,6.45s-6.44-2.89-6.44-6.45,2.88-6.44,6.44-6.44,6.45,2.88,6.45,6.44" />
                        <polygon class="cls-17" points="17.48 125.54 18.93 125.54 18.93 124.06 20.37 124.06 20.37 122.58 21.84 122.58 21.84 121.12 23.29 121.12 23.29 119.67 25.45 119.67 25.45 120.41 24.02 120.41 24.02 121.86 22.55 121.86 22.55 123.34 21.11 123.34 21.11 124.81 19.64 124.81 19.64 126.28 17.48 126.28 17.48 125.54" />
                    </g>
                    <g id="elevator_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="85.84" width="134.17" height="21.86" /><text class="cls-3" transform="translate(35.22 99.7)">
                            <tspan x="0" y="0">Elevator</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="93" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,93.85c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M27.97,96.96c0,3.56-2.87,6.44-6.39,6.44s-6.39-2.88-6.39-6.44,2.86-6.45,6.39-6.45,6.39,2.89,6.39,6.45" />
                        <path class="cls-17" d="M18.4,97.66v3.57c0,.47.38.84.84.84h4.61c.46,0,.84-.35.84-.84v-4.65c0-.47-.37-.85-.84-.85h-4.61c-.48,0-.84.39-.84.85v1.08M23.83,101.19h-4.55v-4.57h4.55v4.57Z" />
                        <path class="cls-17" d="M22.69,92.14c-.01-.6.87-.61.87,0v1.85s.46-.58.46-.58c.32-.36.89.14.54.54l-1.14,1.37c-.18.18-.41.18-.58,0l-1.14-1.37c-.35-.41.23-.91.54-.55l.46.58v-1.85" />
                        <path class="cls-17" d="M19.53,95c0,.61.87.62.87,0l-.02-1.85.47.58c.32.36.89-.14.54-.55l-1.14-1.36c-.18-.18-.41-.18-.59,0l-1.13,1.37c-.35.4.23.91.54.54l.46-.58v1.85" />
                        <path class="cls-17" d="M21.55,97.89c.15,0,.28-.12.28-.28s-.13-.28-.28-.28-.27.12-.27.28.12.28.27.28" />
                        <path class="cls-17" d="M20.1,97.89c.15,0,.28-.12.28-.28s-.12-.28-.28-.28-.27.12-.27.28.13.28.27.28" />
                        <path class="cls-17" d="M20.58,99.35c.09,0,.16-.07.16-.16v-1.04c0-.09-.07-.16-.16-.16h-.94c-.09,0-.16.07-.16.16v1.04c0,.09.07.16.16.16h.09v1.41c0,.1.08.18.17.18s.17-.08.17-.18v-1.41h.06v1.41c0,.1.09.18.18.18s.17-.08.17-.18v-1.41h.09" />
                        <path class="cls-17" d="M22.98,97.89c-.15,0-.27-.12-.27-.28s.12-.28.27-.28.28.12.28.28-.12.28-.28.28" />
                        <path class="cls-17" d="M22.51,99.35c-.09,0-.17-.07-.17-.16v-1.04c0-.09.08-.16.17-.16h.94c.09,0,.16.07.16.16v1.04c0,.09-.07.16-.16.16h-.09v1.41c0,.1-.07.18-.17.18s-.18-.08-.18-.18v-1.41h-.06v1.41c0,.1-.08.18-.18.18s-.17-.08-.17-.18v-1.41h-.09" />
                        <path class="cls-17" d="M21.58,99.75v1.03c0,.07.06.14.13.14.07,0,.13-.06.13-.14v-1.03h.37l-.16-.54h.09c.06,0,.12-.07.1-.13-.06-.21-.22-.78-.27-.93-.03-.08-.1-.15-.19-.15h-.45c-.09,0-.17.07-.19.15-.05.16-.21.73-.28.93-.02.07.04.13.1.13h.09l-.16.54h.37v1.03c0,.07.06.14.13.14s.13-.06.13-.14v-1.03h.06" />
                    </g>
                    <g id="first_aid_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="59.61" width="134.17" height="21.86" /><text class="cls-6" transform="translate(35.2 73.83)">
                            <tspan x="0" y="0">First Aid</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="66.78" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,67.62c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.16,70.73c0,3.63-2.94,6.58-6.58,6.58s-6.58-2.94-6.58-6.58,2.94-6.58,6.58-6.58,6.58,2.94,6.58,6.58" />
                        <polygon class="cls-17" points="20.1 66.53 23.05 66.53 23.05 69.3 25.82 69.3 25.82 72.24 23.07 72.24 23.07 75.01 20.12 75.01 20.12 72.24 17.34 72.24 17.34 69.3 20.1 69.3 20.1 66.53" />
                    </g>
                    <g id="emergency_exit_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="33.39" width="134.17" height="21.86" /><text class="cls-5" transform="translate(35.21 47.07)">
                            <tspan x="0" y="0">Emergency Exit</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="40.55" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,41.4c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.13,44.5c-.06,3.62-3.04,6.5-6.65,6.44-3.61-.06-6.49-3.04-6.44-6.65.06-3.61,3.04-6.5,6.65-6.44,3.61.06,6.5,3.04,6.44,6.65" />
                        <polygon class="cls-17" points="24.36 45.97 23.84 45.97 23.84 40.15 18.81 40.15 18.81 48.64 23.84 48.64 23.84 47.11 24.36 47.11 24.36 45.97" />
                        <path class="cls-15" d="M20.53,42.2c.35,0,.64-.29.64-.64s-.29-.64-.64-.64-.64.28-.64.64.28.64.64.64M22.55,46.15c-.03-.48-.09-1.51-.09-1.51l-.6-1.69c.26.14.55.29.63.33.08.15.52,1,.52,1l.55-.29-.57-1.08c-.03-.06-.07-.1-.13-.13l-1.26-.66c-.08-.04-.17-.05-.25-.01l-.91.35c-.09.03-.16.1-.18.19,0,0-.31.97-.38,1.19-.2.08-.85.33-.85.33l.22.57.99-.39c.09-.03.15-.1.18-.19,0,0,.09-.28.18-.57l.44,1.21-1,3.2.75.23.93-2.98.07,1.31c.01.21.18.37.39.37h2.02s0-.78,0-.78c0,0-1.15,0-1.65,0" />
                    </g>
                    <g id="emergency_call_label" class="button-label">
                        <rect class="cls-16" x="7.94" y="7.16" width="133.62" height="21.86" /><text class="cls-2" transform="translate(35.22 20.51)">
                            <tspan x="0" y="0">Emergency Call Station</tspan>
                        </text>
                        <rect class="cls-17" x="123.71" y="14.33" width="7.53" height="7.52" />
                        <path class="cls-13" d="M132.56,15.18c.24.24.24.64,0,.88l-4.96,4.96c-.24.24-.64.24-.88,0l-2.48-2.48c-.24-.24-.24-.64,0-.88s.64-.24.88,0l2.04,2.04,4.52-4.52c.24-.24.64-.24.88,0h0Z" />
                        <path class="cls-15" d="M28.09,18.24c-.06,3.59-3.02,6.46-6.61,6.4-3.59-.06-6.46-3.02-6.4-6.61.06-3.59,3.02-6.45,6.61-6.4,3.59.06,6.46,3.02,6.4,6.61" />
                        <path class="cls-17" d="M22.03,19.02c-.16-.08-.33.01-.33.01,0,0-.01-.5-.35-.53-.17-.02-.28.06-.28.06,0,0,.01-.44-.4-.44-.45,0-.3.58-.45.59-.14,0-.08-2.42-.16-2.66-.08-.26-.48-.27-.57-.01-.16.45.06,4-.58,4.13-.65.14-1.13-.81-1.64-.87-.51-.05-.43.29-.43.29,0,0,2.47,2.6,2.48,2.61.22.27.67.45,1.19.45.64,0,1.18-.24,1.34-.64.15-.4.46-1.65.47-2.06.03-.65-.13-.87-.28-.95" />
                        <path class="cls-17" d="M20.95,16.08c0,.34-.14.64-.36.86l.04.04c.23-.23.38-.55.38-.91s-.14-.67-.38-.91l-.05.05c.22.22.36.53.36.86" />
                        <path class="cls-17" d="M18.51,16.08c0-.34.14-.64.36-.86l-.04-.04c-.23.23-.38.55-.38.91s.14.68.38.91l.05-.04c-.22-.22-.36-.53-.36-.86" />
                        <path class="cls-17" d="M20.68,16.08c0,.26-.1.5-.28.67l.05.05c.18-.18.29-.43.29-.71s-.11-.53-.29-.71l-.04.04c.17.17.28.41.28.67" />
                        <path class="cls-17" d="M18.79,16.08c0-.26.11-.5.28-.67l-.05-.04c-.18.18-.29.43-.29.71s.11.53.29.71l.04-.04c-.17-.17-.28-.41-.28-.67" />
                        <path class="cls-17" d="M19.07,16.08c0-.18.07-.35.19-.47l-.04-.05c-.13.13-.21.32-.21.52s.08.38.21.52l.05-.05c-.12-.12-.19-.29-.19-.47" />
                        <path class="cls-17" d="M20.4,16.08c0,.18-.07.35-.19.47l.04.05c.13-.13.21-.32.21-.52s-.08-.38-.21-.52l-.05.05c.12.12.2.29.2.47" />
                        <rect class="cls-17" x="23.28" y="16.16" width="3.06" height="1.09" />
                        <rect class="cls-17" x="24.27" y="15.17" width="1.09" height="3.06" />
                    </g>
                </svg>
            </div>
        </div>

        <div id="mobile-div">
        <div id="navigate-menu">
			<button class="btn btn-success button-navigate" id="myLocation"><i class="fa-solid fa-location-crosshairs fa-xl"></i> FIND ME!</button>
		</div>
            <?php if ($disabled == 'off') {
            ?>
                <form action="" method="get" class="levelForm">
                    <div>
                        <?php
                        $query = $_GET;
                        // replace parameter(s)
                        unset($query['level']);
                        // rebuild url
                        $query_result = http_build_query($query);
                        // new link

                        ?>
                        <a href="map-alone.php?active_building=<?=get_field_building(get_field_floor(get_field_room($id_room,'id_floor'),'id_building'),'code_building')?>" class="btn btn-success buidling_link"><i class="fa-solid fa-building"></i> <?=get_field_building(get_field_floor(get_field_room($id_room,'id_floor'),'id_building'),'name_building')?></a> &#10093; 
                        <select name="level" id="level" class="select_floor" onchange="window.location.replace('map-building-alone.php?<?= $query_result ?>&level='+this.value)"  >
                            <?php
                            $query = "SELECT * from floor WHERE id_building='" . $id_building . "'";
                            $level_query = tep_db_query($query);
                            $total_levels = mysqli_num_rows($level_query);



                            while ($level_a = tep_db_fetch_array($level_query)) {
                                $id_floor = $level_a['id_floor'];
                                $name_floor = $level_a['name_floor'];
                                $code_floor = $level_a['code_floor'];



                            ?>
                                <option value="<?= $code_floor ?>" <?= $level == $code_floor ? 'selected' : '' ?>><?= $name_floor ?></option>
                            <?php } ?>
                        </select>
                            </div>
                </form>
            <?php } ?>
            <?= $map ?>
        </div>
        <script>
            // Don't use window.onLoad like this in production, because it can only listen to one function.
            window.onload = function() {
                var eventsHandler;

                eventsHandler = {
                    haltEventListeners: ['touchstart', 'touchend', 'touchmove', 'touchleave', 'touchcancel'],
                    init: function(options) {
                            var instance = options.instance,
                                initialScale = 1,
                                pannedX = 0,
                                pannedY = 0

                            // Init Hammer
                            // Listen only for pointer and touch events
                            this.hammer = Hammer(options.svgElement, {
                                inputClass: Hammer.SUPPORT_POINTER_EVENTS ? Hammer.PointerEventInput : Hammer.TouchInput
                            })

                            // Enable pinch
                            this.hammer.get('pinch').set({
                                enable: true
                            })

                            // Handle double tap
                            this.hammer.on('doubletap', function(ev) {
                                instance.zoomIn()
                            })

                            // Handle pan
                            this.hammer.on('panstart panmove', function(ev) {
                                // On pan start reset panned variables
                                if (ev.type === 'panstart') {
                                    pannedX = 0
                                    pannedY = 0
                                }

                                // Pan only the difference
                                instance.panBy({
                                    x: ev.deltaX - pannedX,
                                    y: ev.deltaY - pannedY
                                })
                                pannedX = ev.deltaX
                                pannedY = ev.deltaY
                            })

                            // Handle pinch
                            this.hammer.on('pinchstart pinchmove', function(ev) {
                                // On pinch start remember initial zoom
                                if (ev.type === 'pinchstart') {
                                    initialScale = instance.getZoom()
                                    instance.zoom(initialScale * ev.scale)
                                }

                                instance.zoom(initialScale * ev.scale)

                            })

                            // Prevent moving the page on some devices when panning over SVG
                            options.svgElement.addEventListener('touchmove', function(e) {
                                e.preventDefault();
                            });
                        }

                        ,
                    destroy: function() {
                        this.hammer.destroy()
                    }
                }

                // Expose to window namespace for testing purposes
                window.panZoom = svgPanZoom('#floor', {
                    zoomEnabled: true,
                    controlIconsEnabled: true,
                    fit: 1,
                    center: 1,
                    customEventsHandler: eventsHandler
                });


            };

            let Navigate = document.querySelector('#myLocation');
            Navigate.addEventListener("click", function(e) {
                window.location.assign("navigation-alone.php?back-to=map-building-alone.php");
            });
        </script>
    </main>
    <script src="vendors/sweetalert/sweetalert-v2.11.js"></script>
    <script src="javascript/general.js" defer></script>
</body>

</html>