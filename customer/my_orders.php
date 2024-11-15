<center>
    <h1>My Orders</h1>
    <p class="lead">Your orders in one place</p>
    <p class="text-muted">
        If you have any questions, feel free to <a href="../contact.php">Contact Us</a>. Our Customer Service works <strong>between 7:00 am - 6:00 pm</strong>
    </p>
</center>

<hr>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ON:</th>
                <th>Invoice</th>
                <th>Product Name</th>
                <th>Order Date</th>
                <th>Qty</th>
                <th>Roast Type</th>
                <th>Coffee Beans</th>
                <th>Total</th>
                <th>Paid/Unpaid</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Fetch customer details
            $customer_session = $_SESSION['customer_email'];
            $get_customer = "SELECT customer_id FROM customers WHERE customer_email='$customer_session'";
            $run_customer = mysqli_query($con, $get_customer);
            $row_customer = mysqli_fetch_array($run_customer);
            $customer_id = $row_customer['customer_id'];

            // Fetch orders without aggregation to display each product ordered individually
            $get_orders = "
            SELECT 
                co.invoice_no, 
                co.due_amount, 
                co.qty,
                co.order_date, 
                co.order_status,
                co.payment_method, 
                co.size,
                co.roast,
                co.coffee,
                p.product_title AS product_name,
                pm.payment_status AS payment_status
            FROM 
                customer_orders AS co
            JOIN 
                products AS p ON co.product_id = p.product_id
            LEFT JOIN 
                payments AS pm ON co.invoice_no = pm.invoice_no
            WHERE 
                co.customer_id='$customer_id'";
            
            $run_orders = mysqli_query($con, $get_orders);
            
            // Error handling for the query
            if (!$run_orders) {
                echo "Error: " . mysqli_error($con);
                exit(); // Stop execution if there's an error
            }

            if (mysqli_num_rows($run_orders) == 0) {
                echo "<tr><td colspan='10' class='text-center'>No orders found.</td></tr>";
            } else {
                $i = 0;
                while ($row_orders = mysqli_fetch_array($run_orders)) {
                    $invoice_no = $row_orders['invoice_no'];
                    $due_amount = $row_orders['due_amount'];
                    $qty = $row_orders['qty'];
                    $roast = $row_orders['roast'];
                    $coffee = $row_orders['coffee'];
                    $order_date = substr($row_orders['order_date'], 0, 11);
                    $order_status = $row_orders['order_status'];
                    $method = $row_orders['payment_method'];
                    $product_name = $row_orders['product_name'];
                    $payment_status = $row_orders['payment_status'];

                    // Define the order status display based on payment type and status
                    if ($method == 'online') {
                        $order_status_display = ($payment_status == 'verified') ? 'Verified' :
                                                (($payment_status == 'paid') ? 'Paid' : 'Unpaid');
                    } else {
                        if ($order_status == 'ToReceive') {
                            $order_status_display = 'Pending'; // Treat ToReceive as pending for display
                        } else {
                            $order_status_display = ($order_status == 'pending') ? 'Pending' : 
                                                    (($order_status == 'Completed') ? 'Paid' : 'Unpaid');
                        }
                    }

                    $i++;
        ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $invoice_no; ?></td>
                        <td><?php echo $product_name; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $roast; ?></td>
                        <td><?php echo $coffee; ?></td>
                        <td>₱<?php echo number_format($due_amount, 2); ?></td>
                        <td><?php echo $order_status_display; ?></td>
                        <td><?php echo $order_status; ?></td>
                    </tr>
        <?php 
                }
            }
        ?>
        </tbody>
    </table>
</div>




