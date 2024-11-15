<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = 'localhost';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$database = 'ecom_store'; // Replace with your database name

// Establish connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count sales per region and get the most bought product
$sql = "
    SELECT c.customer_city, p.product_title, SUM(co.qty) as product_count, COUNT(co.customer_id) as sales_count
    FROM customers c
    JOIN customer_orders co ON c.customer_id = co.customer_id
    JOIN products p ON co.product_id = p.product_id
    WHERE co.order_status = 'Completed'
    GROUP BY c.customer_city, co.product_id
";

// Execute the query
$result = $conn->query($sql);

// Initialize an empty array to store the sales data
$sales_data = array();

// Define a mapping of cities to regions
$region_map = [
    'Cavite' => ['Cavite', 'Cavite City', 'Dasmariñas', 'Imus', 'General Trias', 'Bacoor'],
    'Batangas' => ['Batangas', 'Batangas City', 'Lipa', 'Tanauan', 'Lemery'],
    'Laguna' => ['Laguna', 'Santa Rosa', 'San Pablo', 'Calamba', 'Biñan'],
    'Quezon' => ['Quezon', 'Lucena', 'Tayabas', 'Sariaya'],
    'Lucena' => ['Lucena'],
    'Rizal' => ['Rizal', 'Antipolo', 'Binangonan', 'Taytay']
];

// Process the results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $region_found = false;

        // Determine the region based on customer city
        foreach ($region_map as $region => $cities) {
            foreach ($cities as $city) {
                if (strpos($row['customer_city'], $city) !== false) {
                    if (!isset($sales_data[$region])) {
                        $sales_data[$region] = ['sales_count' => 0, 'most_bought_product' => '', 'most_bought_count' => 0];
                    }

                    // Update sales count
                    $sales_data[$region]['sales_count'] += $row['sales_count'];

                    // Update most bought product if necessary
                    if ($row['product_count'] > $sales_data[$region]['most_bought_count']) {
                        $sales_data[$region]['most_bought_product'] = $row['product_title'];
                        $sales_data[$region]['most_bought_count'] = $row['product_count'];
                    }
                    $region_found = true;
                    break 2; // Exit both loops
                }
            }
        }
    }
}

// Return the sales data as JSON
header('Content-Type: application/json');
echo json_encode($sales_data);

// Close the database connection
$conn->close();
?>
