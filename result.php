<?php

include("includes/header.php");


if (isset($_GET['search'])) { // Check if the search button is clicked

    global $db;

    $product_title = $_GET['user_query']; // Get the user's query

    // Query to search for products with a matching title
    $query = "SELECT * FROM products WHERE product_title LIKE '%$product_title%'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        // Display the search results
        while ($row = mysqli_fetch_array($result)) {
            $pro_id = $row['product_id'];
            $pro_title = $row['product_title'];
            $pro_url = $row['product_url'];
            $pro_price = $row['product_price'];
            $pro_sale_price = $row['product_sale'];
            $pro_img1 = $row['product_img1'];
            $pro_label = $row['product_label'];
            $manufacturer_id = $row['manufacturer_id'];
        
            $get_manufacturer = "select * from manufacturers where manufacturer_id='$manufacturer_id'";
        
            $run_manufacturer = mysqli_query($db, $get_manufacturer);
        
            $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        
            $manufacturer_title = $row_manufacturer['manufacturer_title'];
        
            if ($pro_label == "sale") {
                $product_price = " <del> ₱ $pro_price </del> ";
                $product_sale_price = "/ ₱ $pro_sale_price ";
            } else {
                $product_price = "  ₱ $pro_price  ";
                $product_sale_price = "";
            }
        
            if ($pro_label == "") {
                $product_label = "";
            } else {
                $product_label = "
                    <a href='#' class='label $pro_label'>
                        <div class='theLabel'> $pro_label </div>
                        <div class='labelBackground'>  </div>
                    </a>
                ";
            }
        
            echo "
    <div class='col-md-4 col-sm-6 single' style='margin-bottom: 20px;'>
        <div class='product' style='border: 1px solid #ddd; padding: 15px;'>
            <a href='$pro_url'>
                <img class='img-responsive' src='admin_area/product_images/$pro_img1' style='width: 100%;'>
            </a>
            <div class='text'>
                <center>
                    <p class='btn btn-primary' style='margin-bottom: 10px;'> $manufacturer_title </p>
                </center>
                <h3>
                    <a href='$pro_url' style='text-decoration: none; color: white;'>$pro_title</a>
                </h3>
                <p class='price' style='font-weight: bold; color: #e44d26;'>$product_price &nbsp;$product_sale_price</p>
                <p class='button'>
                    <a class='btn btn-default' href='$pro_url' style='background-color: #f0f0f0; color: #333;'>View Details</a>
                    <a class='btn btn-primary' href='$pro_url' style='background-color: #e44d26;'><i class='fa fa-shopping-cart'></i> Add to Cart</a>
                </p>
            </div>
            $product_label
        </div>
    </div>";

            
        }
    } else {
        echo "<p>No results found.</p>";
    }
}
?>




