
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>


</head>
<body>



<div class="box"><!-- box Begin -->
    
  <div class="box-header"><!-- box-header Begin -->
      
      <center><!-- center Begin -->
          
          <h1> Login </h1>
          
          <p class="lead"> Already have our account..? </p>
          
          
          
      </center><!-- center Finish -->
      
  </div><!-- box-header Finish -->
   
  <form method="post" action="checkout.php"><!-- form Begin -->
      
      <div class="form-group"><!-- form-group Begin -->
          
          <label> Email </label>
          
          <input name="c_email" type="text" class="form-control" required>
          
      </div><!-- form-group Finish -->
      
       <div class="form-group"><!-- form-group Begin -->
          
          <label> Password </label>
          
          <input name="c_pass" type="password" class="form-control" required>
          <!-- <i class="fa fa-eye" aria-hidden="true" id="togglePassword"></i> -->
           
          
      </div><!-- form-group Finish -->
      

     
      <div class="text-center"><!-- text-center Begin -->
          
          <button name="login" value="Login" class="btn btn-primary">
              
              <i class="fa fa-sign-in"></i> Login
              
          </button>
          
      </div><!-- text-center Finish -->     
      
  </form><!-- form Finish -->
   
  <center><!-- center Begin -->
      
     <a href="customer_register.php">
         
         <h3> Don't have account? Register here </h3>
         
     </a> 

     <center><!-- center Begin -->
      
      <a href="forgot_password.php">
          
          <h3> Forgot password? Click here </h3>
          
      </a> 
      
       
   </center><!-- center Finish -->
      
  </center><!-- center Finish -->

  <center><!-- center Begin -->
      
      <a href="admin_area/login.php">
          
          <h3> Are you an admin? Login here! </h3>
          
      </a> 
       
   </center><!-- center Finish -->
    
</div><!-- box Finish -->

<script>
    document.getElementById("showPassword").addEventListener("change", function() {
        var passwordField = document.getElementById("password");
        if (this.checked) {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    });
</script>

<?php
session_start();  // Ensure the session is started
include("includes/db.php");  // Include database connection

if (isset($_POST['login'])) {
    // Get the email and password from the form
    $customer_email = $_POST['c_email'];
    $customer_pass = $_POST['c_pass'];

    // Select the customer by email and password
    $select_customer = "SELECT * FROM customers WHERE customer_email='$customer_email' AND customer_pass='$customer_pass'";
    $run_customer = mysqli_query($con, $select_customer);
    $check_customer = mysqli_num_rows($run_customer);

    // If customer doesn't exist, show an error message
    if ($check_customer == 0) {
        echo "<script>alert('Email or Password is incorrect')</script>";
        exit();
    }

    // Fetch customer data (including status)
    $customer = mysqli_fetch_array($run_customer);
    $customer_status = $customer['status'];  // Get the account status

    // Check the account status and redirect accordingly
    if ($customer_status == 'pending') {
        // If the account is pending, redirect to the waiting page with a message
        
        echo "<script>window.open('waiting_approval.php', '_self');</script>";
        exit();
    } elseif ($customer_status == 'disapproved') {
        // If the account is disapproved, redirect to a disapproved page with a message
       
        echo "<script>window.open('disapproved_account.php', '_self');</script>";
        exit();
    } elseif ($customer_status == 'approved') {
        // If the account is approved, log the user in
        $_SESSION['customer_email'] = $customer_email;
        echo "<script>alert('You are logged in successfully!')</script>";

        // Check if the customer has items in the cart
        $get_ip = getCustomerDetails();  // Assuming this function fetches the user ID or IP
        $select_cart = "SELECT * FROM cart WHERE customer_id='$get_ip'";
        $run_cart = mysqli_query($con, $select_cart);
        $check_cart = mysqli_num_rows($run_cart);

        // Redirect to the appropriate page based on cart status
        if ($check_cart == 0) {
            echo "<script>window.open('customer/my_account.php?my_orders', '_self');</script>";
        } else {
            echo "<script>window.open('index.php', '_self');</script>";
        }
    }
}
?>

    
</body>
</html>


