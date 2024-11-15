<?php
// Start the session to access session variables
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "ecom_store");

// Function to get customer details based on session email
function getCustomerDetails() {
    global $con; // Make sure to use the global $con (database connection)
    
    // Retrieve customer email from session
    $customer_email = $_SESSION['customer_email'];
    
    // Query to get customer ID based on email
    $query = "SELECT customer_id FROM customers WHERE customer_email='$customer_email'";
    $result = mysqli_query($con, $query);
    
    // Check if the query was successful and return the customer_id
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['customer_id'];
    } else {
        // Handle error if no customer is found
        return null;
    }
}

// Check if customer is logged in
if (isset($_SESSION['customer_email'])) {
    $customer_email = $_SESSION['customer_email'];

    // Retrieve customer ID
    $c_id = getCustomerDetails();

    if ($c_id) {
        // Define shipping fee
        $shipping_fee = 45;

        // Calculate total price from cart (include shipping fee)
        $total = 0;
        $select_cart = "SELECT * FROM cart WHERE customer_id='$c_id'";
        $run_cart = mysqli_query($con, $select_cart);

        while ($row_cart = mysqli_fetch_array($run_cart)) {
            $product_qty = $row_cart['qty'];
            $pro_id = $row_cart['p_id'];

            // Get product price
            $get_price = "SELECT * FROM products WHERE product_id='$pro_id'";
            $run_price = mysqli_query($con, $get_price);
            $row_price = mysqli_fetch_array($run_price);

            $pro_price = $row_price['product_price'];
            $pro_sale = $row_price['product_sale'];
            $pro_label = $row_price['product_label'];

            // Determine product price
            $product_price = ($pro_label == "sale") ? $pro_sale : $pro_price;

            // Calculate subtotal for the product
            $total += ($product_qty * $product_price);
        }

        // Add shipping fee to the total
        $order_total = $total + $shipping_fee;

        // Order details
        $order_date = date('Y-m-d H:i:s');
        $order_status = 'Pending';
        $payment_method = 'offline'; // Payment method

        // Generate a random invoice number
        do {
            $invoice_no = mt_rand();
            $check_invoice = "SELECT * FROM customer_orders WHERE invoice_no='$invoice_no'";
            $result = mysqli_query($con, $check_invoice);
        } while (mysqli_num_rows($result) > 0); // Regenerate if the invoice number exists

        // Insert order into customer_orders
        $insert_order = "INSERT INTO customer_orders (customer_id, order_date, order_status, order_total, payment_method, invoice_no) 
                         VALUES ('$c_id', '$order_date', '$order_status', '$order_total', '$payment_method', '$invoice_no')";
        $run_order = mysqli_query($con, $insert_order);

        if ($run_order) {
            // Get the last inserted order ID (for order summary)
            $order_id = mysqli_insert_id($con);

            // Insert order items (products in the cart) into order_items
            $select_cart = "SELECT * FROM cart WHERE customer_id='$c_id'";
            $run_cart = mysqli_query($con, $select_cart);

            while ($row_cart = mysqli_fetch_array($run_cart)) {
                $pro_id = $row_cart['p_id'];
                $pro_qty = $row_cart['qty'];
                $pro_price = $row_cart['p_price'];

                // Insert each product into the order_items table
                $insert_order_items = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                       VALUES ('$order_id', '$pro_id', '$pro_qty', '$pro_price')";
                mysqli_query($con, $insert_order_items);
            }

            // After the order is placed, empty the cart
            $delete_cart = "DELETE FROM cart WHERE customer_id='$c_id'";
            mysqli_query($con, $delete_cart);

            // Redirect to order summary page
            echo "<script>window.open('order_summary.php?invoice_no=$invoice_no','_self');</script>";
        } else {
            echo "<script>alert('There was an error processing your order. Please try again.');</script>";
            echo "<script>window.open('checkout.php','_self');</script>";
        }
    } else {
        echo "<script>alert('Error: Customer details not found.');</script>";
        echo "<script>window.open('checkout.php','_self');</script>";
    }
}
?>
