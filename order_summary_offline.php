<?php
session_start();
include("includes/header.php");

if(isset($_SESSION['customer_email']) && isset($_GET['pay_offline'])){
    $session_email = $_SESSION['customer_email'];
    $select_customer = "SELECT * FROM customers WHERE customer_email='$session_email'";
    $run_customer = mysqli_query($con, $select_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $customer_id = $row_customer['customer_id'];

    // Fetch order details (assuming an order ID is stored in session or passed via URL)
    $order_id = $_SESSION['order_id'];  // This assumes you have stored the order ID in the session
    $select_order = "SELECT * FROM orders WHERE order_id='$order_id' AND customer_id='$customer_id'";
    $run_order = mysqli_query($con, $select_order);
    $order = mysqli_fetch_array($run_order);
    
    if(!$order) {
        echo "<h3>Order not found!</h3>";
        exit;
    }

    // Fetch order items
    $items_query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
    $items_result = mysqli_query($con, $items_query);
    $total_price = 0;
?>
    <div id="content">
        <div class="container">
            <h2>Order Summary</h2>
            <div class="box">
                <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
                <p><strong>Status:</strong> <?php echo $order['order_status']; ?> (Awaiting Offline Payment)</p>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($item = mysqli_fetch_array($items_result)) {
                            echo "<tr>";
                            echo "<td>".$item['product_title']."</td>";
                            echo "<td>".$item['quantity']."</td>";
                            echo "<td>₱".$item['price']."</td>";
                            echo "<td>₱".$item['total']."</td>";
                            $total_price += $item['total'];
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <p><strong>Total: ₱<?php echo $total_price; ?></strong></p>
                
                <!-- Offline Payment Instructions -->
                <p><strong>Offline Payment Instructions:</strong> Please transfer the amount to our bank account. <a href="payment_instructions.php">Click here for payment details.</a></p>

                <p>You will receive an email confirmation once your payment is processed.</p>
                
                <!-- Button to proceed to My Account -->
                <p><a href="customer/my_account.php" class="btn btn-primary">Proceed to My Account</a></p>
            </div>
        </div>
    </div>

<?php 
} else {
    echo "<h3>Please log in to view your order summary.</h3>";
}

include("includes/footer.php");
?>
