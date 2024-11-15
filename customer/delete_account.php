<center><!-- center Begin -->
    
    <h1> Do You Really Want To Delete Your Account ? </h1>
    
    <form action="" method="post"><!-- form Begin -->
        
       <input type="submit" name="Yes" value="Yes, I Want To Delete" class="btn btn-danger"> 
        
       <input type="submit" name="No" value="No, I Dont Want To Delete" class="btn btn-primary"> 
        
    </form><!-- form Finish -->
    
</center><!-- center Finish -->


<?php 

$c_email = $_SESSION['customer_email'];

if(isset($_POST['Yes'])){
    
    // Select the customer_id associated with the current email
    $select_customer = "SELECT customer_id FROM customers WHERE customer_email='$c_email'";
    $run_customer = mysqli_query($con, $select_customer);
    $row_customer = mysqli_fetch_assoc($run_customer);
    $c_id = $row_customer['customer_id'];

    // Delete orders associated with the customer_id
    $delete_orders = "DELETE FROM customer_orders WHERE customer_id='$c_id'";
    $run_delete_order = mysqli_query($con, $delete_orders);

    // Delete the customer
    $delete_customer = "DELETE FROM customers WHERE customer_email='$c_email'";
    $run_delete_customer = mysqli_query($con, $delete_customer);

    if($run_delete_customer && $run_delete_order){
        session_destroy();
        echo "<script>alert('Successfully deleted your account and orders. Goodbye!')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
    }
}

if(isset($_POST['No'])){
    echo "<script>window.open('my_account.php?my_orders','_self')</script>";
}

?>
