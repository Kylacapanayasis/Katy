<?php
    // Include header
    $active = 'Home';
    include("includes/header.php");  

    // Include database connection
    include("includes/db.php");

    // Get the customer ID and invoice details
    if (isset($_GET['c_id'])) {
        $c_id = $_GET['c_id']; // Customer ID from URL
    } else {
        echo "<script>alert('Invalid order!'); window.open('shop.php', '_self');</script>";
        exit();
    }

    // Get customer order details
    $status = "pending";
    $method = "Offline";
    $invoice_no = mt_rand();

    $select_cart = "SELECT * FROM cart WHERE customer_id='$c_id'";
    $run_cart = mysqli_query($con, $select_cart);

    while ($row_cart = mysqli_fetch_array($run_cart)) {
        $pro_id = $row_cart['p_id'];
        $pro_qty = $row_cart['qty'];
        $pro_size = $row_cart['size'];
        $pro_roast = $row_cart['roast'];
        $pro_coffee = $row_cart['coffee'];
        $pro_price = $row_cart['p_price'];

        $due_amount = $row_cart['p_price'] * $pro_qty; // Renamed sub_total to due_amount

        // Insert order into customer_orders table
        $insert_customer_order = "INSERT INTO customer_orders (product_id, customer_id, due_amount, invoice_no, qty, size, roast, coffee, order_date, order_status, payment_method) 
                                  VALUES ('$pro_id', '$c_id', '$due_amount', '$invoice_no', '$pro_qty', '$pro_size', '$pro_roast', '$pro_coffee', NOW(), '$status', '$method')";
        $run_customer_order = mysqli_query($con, $insert_customer_order);

        // Delete items from cart after order
        $delete_cart = "DELETE FROM cart WHERE customer_id='$c_id'";
        $run_delete = mysqli_query($con, $delete_cart);
    }
?>

<div id="content"><!-- #content Begin -->
    <div class="container"><!-- container Begin -->
        <div class="col-md-12"><!-- col-md-12 Begin -->

            <ul class="breadcrumb"><!-- breadcrumb Begin -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Order Summary
                </li>
            </ul><!-- breadcrumb Finish -->

        </div><!-- col-md-12 Finish -->

        <div class="col-md-12"><!-- col-md-12 Begin -->

            <div class="box"><!-- box Begin -->

                <div class="box-header"><!-- box-header Begin -->

                    <center><!-- center Begin -->
                        <h2>Thank you for your purchase!</h2>
                        <p>Your order has been successfully placed. Below are your order details:</p>
                    </center><!-- center Finish -->

                    <!-- Order Summary: Product and Shipping Info -->
                    <div class="row"><!-- row Begin -->
                        <div class="col-md-6"><!-- col-md-6 Begin -->
                            <h3>Product Info</h3>
                            <p><strong>Product Name:</strong> <?php echo $pro_roast . " " . $pro_coffee; ?></p>
                            <p><strong>Roast Type:</strong> <?php echo $pro_roast; ?></p>
                            <p><strong>Coffee Beans:</strong> <?php echo $pro_coffee; ?></p>
                            <p><strong>Price:</strong> ₱<?php echo number_format($pro_price, 2); ?> per kg</p>
                            <p><strong>Quantity:</strong> <?php echo $pro_qty; ?></p>
                        </div><!-- col-md-6 Finish -->

                        <div class="col-md-6"><!-- col-md-6 Begin -->
                            <h3>Shipping Info</h3>
                            <p><strong>Shipping Fee:</strong> ₱45.00</p>
                            <p><strong>Total Amount:</strong> ₱<?php echo number_format($due_amount + 45, 2); ?></p> <!-- Renamed subtotal to due_amount -->
                        </div><!-- col-md-6 Finish -->
                    </div><!-- row Finish -->

                    <!-- Shipping Address -->
                    <h3>Shipping Address</h3>
                    <?php
                        // Get the customer's shipping address
                        $get_address = "SELECT customer_address FROM customers WHERE customer_id='$c_id'";
                        $run_address = mysqli_query($con, $get_address);
                        $address_row = mysqli_fetch_array($run_address);
                        $customer_address = $address_row['customer_address'];
                        echo "<p><strong>Address:</strong> $customer_address</p>";
                    ?>

                    <center><!-- center Begin -->
                        <p><strong>Note:</strong> Please pay the amount within 24 hours to complete your purchase. Thank you for shopping with us!</p>
                    </center><!-- center Finish -->

                    <!-- Shop Again Button -->
                    <div class="text-center"><!-- text-center Begin -->
                        <a href="shop.php" class="btn btn-primary">Shop Again</a>
                    </div><!-- text-center Finish -->

                </div><!-- box-header Finish -->

            </div><!-- box Finish -->

        </div><!-- col-md-12 Finish -->

    </div><!-- container Finish -->
</div><!-- #content Finish -->

<?php 
    include("includes/footer.php");  // Include footer
?>

<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>

</body>
</html>
