<?php
include("includes/db.php");
include("functions/functions.php");

if (isset($_POST['add_cart'])) {
    // Ensure the customer is logged in
    if (!isset($_SESSION['customer_email'])) {
        echo "<script>alert('Please log in to add items to your cart.');</script>";
        echo "<script>window.open('checkout.php','_self');</script>";
        exit();
    }

    $customer_session = $_SESSION['customer_email'];
    $get_customer = "SELECT customer_id FROM customers WHERE customer_email=?";
    $stmt = $con->prepare($get_customer);
    $stmt->bind_param("s", $customer_session);
    $stmt->execute();
    $result = $stmt->get_result();
    $row_customer = $result->fetch_assoc();
    $customer_id = $row_customer['customer_id'];

    $product_qty = $_POST['product_qty'];
    $pro_size = $_POST['size'];
    $pro_roast = $_POST['roast'];
    $pro_coffee = $_POST['coffee'];
    $product_price = $_POST['p_price'];

    // Calculate subtotal
    $sub_total = $product_qty * $product_price;

    // Insert into cart
    $insert_cart = "INSERT INTO cart (customer_id, qty, size, roast, coffee, p_price, total) VALUES (customer_id, $product_qty, $pro_size, $pro_roast, $pro_coffee, $product_price, $total)";
    $stmt = $con->prepare($insert_cart);
    $total = $sub_total; // Adjust total as needed
    $stmt->bind_param("iissssi", $customer_id, $product_qty, $pro_size, $pro_roast, $pro_coffee, $product_price, $total);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product has been added to cart.');</script>";
        echo "<script>window.open('cart.php','_self');</script>";
    } else {
        echo "<script>alert('Error adding product to cart: " . mysqli_error($con) . "');</script>";
    }
}
?>
