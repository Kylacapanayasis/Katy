<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body, html {
            height: 100%; /* Make body and html full height */
            width: 100%;
            margin: 0;    /* Remove margin */
            display: flex; /* Use Flexbox to center content */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        #map {
            height: 90vh; /* Set map height to 90% of viewport height */
            width: 90vh;  /* Set map width to 90% of viewport height to maintain square shape */
            max-width: 100%; /* Ensure it doesn't exceed screen width */
            max-height: 100%; /* Ensure it doesn't exceed screen height */
            overflow: hidden; /* Prevent overflow */
            border: 2px solid #ccc; /* Optional: add a border for better visibility */
        }
    </style>
</head>
<body>


<div id="map"></div>
<div id="legend" style="background: white; padding: 10px; border-radius: 5px; position: absolute; top: 10px; right: 10px; z-index: 1000;">
    <h4>Product Legend</h4>
    <div id="legend-content"></div>
</div>


<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="sales_map.js"></script>

</body>
</html>
