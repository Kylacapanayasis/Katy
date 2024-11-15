<?php 

$customer_session = $_SESSION['customer_email'];

$get_customer = "SELECT * FROM customers WHERE customer_email='$customer_session'";
$run_customer = mysqli_query($con, $get_customer);
$row_customer = mysqli_fetch_array($run_customer);

$customer_id = $row_customer['customer_id'];
$customer_name = $row_customer['customer_name'];
$customer_email = $row_customer['customer_email'];
$customer_city = $row_customer['customer_city'];
$customer_contact = $row_customer['customer_contact'];
$customer_address = $row_customer['customer_address'];
$customer_image = $row_customer['customer_image'];
?>

<h1 align="center"> Edit Your Account </h1>

<form action="" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to update your information?');"><!-- form Begin -->
    
    <div class="form-group"><!-- form-group Begin -->
        <label> Customer Name: </label>
        <input type="text" name="c_name" class="form-control" value="<?php echo $customer_name; ?>" required>
    </div><!-- form-group Finish -->
    
    <div class="form-group"><!-- form-group Begin -->
        <label> Customer Email: </label>
        <input type="text" name="c_email" class="form-control" value="<?php echo $customer_email; ?>" required>
    </div><!-- form-group Finish -->
    
    <div class="form-group"><!-- form-group Begin -->
        <label> Customer City: </label>
        <input type="text" name="c_city" class="form-control" value="<?php echo $customer_city; ?>" required>
    </div><!-- form-group Finish -->
    
    <div class="form-group"><!-- form-group Begin -->
        <label> Customer Contact: </label>
        <input type="text" name="c_contact" class="form-control" value="<?php echo $customer_contact; ?>" required>
    </div><!-- form-group Finish -->
    
    <div class="form-group"><!-- form-group Begin -->
        <label> Customer Address: </label>
        <input type="text" name="c_address" class="form-control" value="<?php echo $customer_address; ?>" required>
    </div><!-- form-group Finish -->
    
    <div class="form-group"><!-- form-group Begin -->
        <label> Customer Image: </label>
        <input type="file" name="c_image" class="form-control form-height-custom">
        <img class="img-responsive" src="customer_images/<?php echo $customer_image; ?>" alt="Customer Image">
    </div><!-- form-group Finish -->
    
    <div class="text-center"><!-- text-center Begin -->
        <button name="update" class="btn btn-primary"><!-- btn btn-primary Begin -->
            <i class="fa fa-user-md"></i> Update Now
        </button><!-- btn btn-primary Finish -->
    </div><!-- text-center Finish -->
    
</form><!-- form Finish -->

<?php 

if (isset($_POST['update'])) {
    
    $update_id = $customer_id;
    $c_name = $_POST['c_name'];
    $c_email = $_POST['c_email'];
    $c_city = $_POST['c_city'];
    $c_address = $_POST['c_address'];
    $c_contact = $_POST['c_contact'];

    // Handle image upload
    $c_image = $_FILES['c_image']['name'];
    $c_image_tmp = $_FILES['c_image']['tmp_name'];

    // Check if an image was uploaded
    if ($c_image) {
        move_uploaded_file($c_image_tmp, "customer_images/$c_image");
    } else {
        // If no new image is uploaded, keep the old one
        $c_image = $customer_image;
    }

    // Check if there are changes to update
    if ($c_name !== $customer_name || 
        $c_email !== $customer_email || 
        $c_city !== $customer_city || 
        $c_address !== $customer_address || 
        $c_contact !== $customer_contact || 
        $c_image !== $customer_image) {

        // Update customer information in the database
        $update_customer = "UPDATE customers SET customer_name='$c_name', customer_email='$c_email', customer_city='$c_city', customer_address='$c_address', customer_contact='$c_contact', customer_image='$c_image' WHERE customer_id='$update_id'";
        
        if (mysqli_query($con, $update_customer)) {
            // Destroy session and log out the user
            session_destroy(); // End the session
            echo "<script>alert('Your account has been edited successfully. Please log in again.')</script>";
            echo "<script>window.open('../index.php','_self')</script>"; // Redirect to index.php outside the customer folder
        } else {
            echo "<script>alert('Failed to update your account. Please try again.')</script>";
        }

    } else {
        echo "<script>alert('No changes made to your account.')</script>";
    }
}

?>
