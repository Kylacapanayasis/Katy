
<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Orders
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-tags"></i> View Orders
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No:</th>
                                <th>Customer Email:</th>
                                <th>Customer Address:</th> <!-- Added Customer Address column -->
                                <th>Invoice No:</th>
                                <th>Product Name:</th>
                                <th>Product Qty:</th>
                                <th>Roast Type:</th>
                                <th>Coffee Beans:</th>
                                <th>Order Date:</th>
                                <th>Total Amount:</th>
                                <th>Status:</th>
                                <th>Update Status:</th>
                                <!-- <th>Delete:</th> --> <!-- Hidden Delete column -->
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_orders = "SELECT * FROM customer_orders";
                            $run_orders = mysqli_query($con, $get_orders);

                            while ($row_order = mysqli_fetch_array($run_orders)) {
                                $order_id = $row_order['order_id'];
                                $product_id = $row_order['product_id'];
                                $c_id = $row_order['customer_id'];
                                $order_amount = $row_order['due_amount'];
                                $invoice_no = $row_order['invoice_no'];
                                $qty = $row_order['qty'];
                                $pro_roast = $row_order['roast'];
                                $pro_coffee = $row_order['coffee'];
                                $order_status = htmlspecialchars($row_order['order_status']);
                                $order_date = htmlspecialchars($row_order['order_date']);

                                // Fetch product title safely using prepared statements
                                $stmt = $con->prepare("SELECT product_title FROM products WHERE product_id = ?");
                                $stmt->bind_param("i", $product_id);
                                $stmt->execute();
                                $stmt->bind_result($product_title);
                                $stmt->fetch();
                                $stmt->close();

                                // Fetch customer email and address safely using prepared statements
                                $stmt = $con->prepare("SELECT customer_email, customer_address FROM customers WHERE customer_id = ?");
                                $stmt->bind_param("i", $c_id);
                                $stmt->execute();
                                $stmt->bind_result($customer_email, $customer_address);
                                $stmt->fetch();
                                $stmt->close();

                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($customer_email); ?></td>
                                    <td><?php echo htmlspecialchars($customer_address); ?></td> <!-- Display Customer Address -->
                                    <td><?php echo htmlspecialchars($invoice_no); ?></td>
                                    <td><?php echo htmlspecialchars($product_title); ?></td>
                                    <td><?php echo htmlspecialchars($qty); ?></td>
                                    <td><?php echo htmlspecialchars($pro_roast); ?></td>
                                    <td><?php echo htmlspecialchars($pro_coffee); ?></td>
                                    <td><?php echo htmlspecialchars($order_date); ?></td>
                                    <td><?php echo htmlspecialchars($order_amount); ?></td>
                                    <td><?php echo ucfirst($order_status); ?></td>
                                    <td>
                                        <form action="update_order_status.php" method="POST">
                                            <select name="new_status">
                                                <option value="To Ship" <?php if ($order_status == 'To Ship') echo 'selected'; ?>>To Ship</option>
                                                <option value="To Receive" <?php if ($order_status == 'To Receive') echo 'selected'; ?>>To Receive</option>
                                                <option value="Delivered" <?php if ($order_status == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                            </select>
                                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                                        </form>
                                   
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
