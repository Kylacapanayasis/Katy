<?php
session_start(); // Make sure to start the session if not started already

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    include("includes/db.php");

    if (isset($_GET['cancel_order'])) {
        $edit_order_id = $_GET['cancel_order'];

        // Directly update the order status to "Cancelled"
        $update_order = "update customer_orders set order_status='cancelled' where order_id='$edit_order_id'";
        $run_order = mysqli_query($con, $update_order);

        if ($run_order) {
            echo "<script>alert('Your Order Has Been Cancelled')</script>";
            echo "<script>window.open('index.php?view_orders','_self')</script>";
        }
    }
}
?>