<?php
session_start();
include("includes/db.php"); // Adjust to your database connection file

if (!isset($_SESSION['admin_email'])) {
    echo "Unauthorized access";
    exit();
}

if (isset($_POST['payment_id'])) {
    $payment_id = intval($_POST['payment_id']);
    
    $check_payment = "SELECT * FROM payments WHERE payment_id='$payment_id'";
    $run_check = mysqli_query($con, $check_payment);
    
    if (mysqli_num_rows($run_check) > 0) {
        $update_payment_status = "UPDATE payments SET payment_status='verified' WHERE payment_id='$payment_id'";
        
        if (mysqli_query($con, $update_payment_status)) {
            echo "success";
        } else {
            echo "Error updating payment status: " . mysqli_error($con);
        }
    } else {
        echo "Payment ID not found";
    }
} else {
    echo "Invalid request";
}
?>
