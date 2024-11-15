<?php
// Include database connection
include("includes/db.php");

// Check if admin is logged in
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
} else {
    // Get customer ID from the URL
    if(isset($_GET['customer_id'])){
        $customer_id = $_GET['customer_id'];

        // Update status to disapproved in the database
        $disapprove_customer = "UPDATE customers SET status = 'disapproved' WHERE customer_id = '$customer_id'";
        $run_disapprove = mysqli_query($con, $disapprove_customer);

        if($run_disapprove){
            // Show success message and redirect back to view_customer.php
            echo "<script>alert('Customer has been disapproved successfully.');</script>";
            echo "<script>window.open('view_customer.php','_self');</script>";
        } else {
            // Show error message and redirect back to view_customer.php
            echo "<script>alert('Failed to disapprove the customer. Please try again.');</script>";
            echo "<script>window.open('view_customer.php','_self');</script>";
        }
    } else {
        // If customer_id is not set, redirect to the customer view page
        echo "<script>window.open('view_customer.php','_self');</script>";
    }
}
?>
