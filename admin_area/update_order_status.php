<?php
include("includes/db.php"); // Make sure to include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Update the order status in the database
    $stmt = $con->prepare("UPDATE customer_orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully!');</script>";
        echo "<script>window.open('index.php?view_orders','_self');</script>";
    } else {
        echo "<script>alert('Error updating order status: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
}
?>
