<?php
    $active = 'Home';
    include("includes/header.php");  // Include header

    // Include database connection
    include("includes/db.php");

    // Get the invoice number from the URL
    if (isset($_GET['invoice_no'])) {
        $invoice_no = $_GET['invoice_no'];

        // Fetch order details using the invoice number
        $query = "SELECT * FROM customer_orders WHERE invoice_no='$invoice_no'";
        $result = mysqli_query($con, $query);
        $order = mysqli_fetch_array($result);

        if ($order) {
            $p_id = $order['product_id'];
            $c_id = $order['customer_id'];
            $product_qty = $order['qty'];
            $pro_roast = $order['roast'];
            $pro_coffee = $order['coffee'];
            $due_amount = $order['due_amount'];
            $shipping_fee = 45; // Shipping fee defined earlier
            $order_date = $order['order_date'];
            $payment_method = $order['payment_method']; // Fetch payment method

            // Fetch product details
            $get_product = "SELECT * FROM products WHERE product_id='$p_id'";
            $run_product = mysqli_query($con, $get_product);
            $product = mysqli_fetch_array($run_product);

            $product_title = $product['product_title'];
            $product_price = $product['product_price'];
            $product_sale = $product['product_sale'];
            $product_label = $product['product_label'];
        }
    } else {
        echo "<script>alert('Invalid order!'); window.open('shop.php', '_self');</script>";
        exit();
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

                    <!-- Order Details -->
                    <div class="row"><!-- row Begin -->
                        <div class="col-md-6"><!-- col-md-6 Begin -->
                            <h3>Product Info</h3>
                            <p><strong>Product Name:</strong> <?php echo $product_title; ?></p>
                            <p><strong>Roast Type:</strong> <?php echo $pro_roast; ?></p>
                            <p><strong>Coffee Beans:</strong> <?php echo $pro_coffee; ?></p>
                            <p><strong>Price:</strong> ₱<?php echo number_format($product_price, 2); ?> per kg</p>
                        </div><!-- col-md-6 Finish -->
                        
                        <div class="col-md-6"><!-- col-md-6 Begin -->
                            <h3>Shipping Info</h3>
                            <p><strong>Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p> <!-- Display payment method -->
                            <p><strong>Shipping Fee:</strong> ₱<?php echo number_format($shipping_fee, 2); ?></p>
                            <p><strong>Total:</strong> ₱<?php echo number_format($due_amount, 2); ?></p> <!-- Calculate and display total -->
                        </div><!-- col-md-6 Finish -->
                    </div><!-- row Finish -->

                    <h3>Shipping Address</h3>
                    <?php
                        // Get the customer's shipping address
                        $get_address = "SELECT customer_address FROM customers WHERE customer_id='$c_id'";
                        $run_address = mysqli_query($con, $get_address);
                        $address_row = mysqli_fetch_array($run_address);
                        $customer_address = $address_row['customer_address'];
                        echo "<p><strong>Address:</strong> $customer_address</p>";
                    ?>

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
