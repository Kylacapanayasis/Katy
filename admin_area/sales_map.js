// List of predefined colors
const predefinedColors = [
    '#FF5733', // Red-Orange
    '#33FF57', // Green
    '#3357FF', // Blue
    '#F1C40F', // Yellow
    '#8E44AD', // Purple
    '#E74C3C', // Red
    '#3498DB', // Light Blue
    '#2ECC71', // Light Green
    '#F39C12', // Orange
    '#D35400'  // Dark Orange
];

// Initialize the map centered on Calabarzon, Philippines
var map = L.map('map').setView([14.189, 121.153], 9); // General coordinates for CALABARZON

// Set LatLng bounds for CALABARZON region
var bounds = [
    [13.0, 120.3], // Southwest corner
    [15.3, 122.3]  // Northeast corner
];

// Add the max bounds to restrict the view
map.setMaxBounds(bounds);

// Set the zoom limits
map.setMinZoom(8); // Prevent zooming out too far
map.setMaxZoom(18); // Prevent zooming in too far

// Add OpenStreetMap tiles to the map
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Town coordinates in CALABARZON
var towns = {
    'Cavite': [14.4821, 120.8964],
    'Batangas': [13.7565, 121.0583],
    'Lucena': [13.9374, 121.6179],
    'Laguna': [14.2006, 121.3646],
    'Quezon': [14.6511, 121.0470],
    'Rizal': [14.5943, 121.2218],
    // Add more towns here as needed
};

// Fetch sales data from the PHP script
fetch('get_sales.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        var productColors = {}; // Object to store product colors
        let colorIndex = 0; // Index to track the predefined colors

        // Clear existing legend content
        document.getElementById('legend-content').innerHTML = '';

        for (var town in towns) {
            var sales = data[town] ? data[town].sales_count : 0; // Default to 0 if no sales for a town
            var mostBoughtProduct = data[town] ? data[town].most_bought_product : 'None'; // Default to 'None' if no product

            // If the product doesn't have a color assigned, assign a new one
            if (mostBoughtProduct !== 'None' && !productColors[mostBoughtProduct]) {
                productColors[mostBoughtProduct] = predefinedColors[colorIndex % predefinedColors.length];
                
                // Add product color to the legend
                const legendItem = document.createElement('div');
                legendItem.innerHTML = `<span style="background-color: ${productColors[mostBoughtProduct]}; width: 15px; height: 15px; display: inline-block;"></span> ${mostBoughtProduct}`;
                document.getElementById('legend-content').appendChild(legendItem);
                
                colorIndex++; // Move to the next color
            }

            // Determine the color based on the most bought product
            var markerColor = productColors[mostBoughtProduct] || '#000000'; // Default to black if product is not found

            // Create a custom marker with the determined color
            var customMarker = L.circleMarker(towns[town], {
                radius: 8, // Adjust the size of the marker
                fillColor: markerColor,
                color: markerColor,
                weight: 1,
                opacity: 1,
                fillOpacity: 0.8
            });

            // Add the marker to the map and bind a popup
            customMarker.addTo(map)
                .bindPopup(`${town.toUpperCase()}: <br> ${sales} total sales <br> Most Bought Product: ${mostBoughtProduct}`);
        }
    })
    .catch(error => console.error('Error fetching sales data:', error));
