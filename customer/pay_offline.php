<?php 

include("includes/db.php");

?>
<?php 

if(isset($_GET['c_id'])){
    
    $customer_id = $_GET['c_id'];
    
}

$c_id = getCustomerDetails();

$status = "pending";

$method = "Offline";

$invoice_no = mt_rand();

$select_cart = "select * from cart where customer_id='$c_id'";

$run_cart = mysqli_query($con, $select_cart);

while($row_cart = mysqli_fetch_array($run_cart)){
    
    $pro_id = $row_cart['p_id'];
    $pro_qty = $row_cart['qty'];
    $pro_size = $row_cart['size'];
    $pro_roast = $row_cart['roast'];
    $pro_coffee = $row_cart['coffee'];
    $pro_price = $row_cart['p_price'];
    
    // Adding 45 pesos to each order subtotal
    $sub_total = ($row_cart['p_price'] * $pro_qty) + 45;
        
    $insert_customer_order = "insert into customer_orders 
        (product_id, customer_id, due_amount, invoice_no, qty, size, roast, coffee, order_date, order_status, payment_method) 
        values 
        ('$pro_id', '$c_id', '$sub_total', '$invoice_no', '$pro_qty', '$pro_size', '$pro_roast', '$pro_coffee', NOW(), '$status', '$method')";
        
    $run_customer_order = mysqli_query($con, $insert_customer_order);
        
    $delete_cart = "delete from cart where customer_id='$c_id'";
        
    $run_delete = mysqli_query($con, $delete_cart);
        
    echo "<script>alert('Your orders have been submitted, Thanks')</script>";
    echo "<script>alert('Please pay the amount within 24 hours')</script>";
    echo "<script>window.open('customer/pay_offline.php')</script>";
}

?>
