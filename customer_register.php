<?php 

$active='Account';
include("includes/header.php");

?>
   
<div id="content"><!-- #content Begin -->
    <div class="container"><!-- container Begin -->
        <div class="col-md-12"><!-- col-md-12 Begin -->
           
            <ul class="breadcrumb"><!-- breadcrumb Begin -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Register
                </li>
            </ul><!-- breadcrumb Finish -->
            
        </div><!-- col-md-12 Finish -->
        
        <div class="col-md-12"><!-- col-md-12 Begin -->
            
            <div class="box"><!-- box Begin -->
                
                <div class="box-header"><!-- box-header Begin -->
                    
                    <center><!-- center Begin -->
                        <h2> Register a new account </h2>
                    </center><!-- center Finish -->
                    
                    <form action="customer_register.php" method="post" enctype="multipart/form-data"><!-- form Begin -->
                        
                        <!-- Form Fields -->
                        <div class="form-group">
                            <label>Your Full Name</label>
                            <input type="text" class="form-control" name="c_name" required>
                        </div>
                        <div class="form-group">
                            <label>Your Email</label>
                            <input type="text" class="form-control" name="c_email" required>
                        </div>
                        <div class="form-group">
                            <label>Your Password</label>
                            <input type="password" class="form-control" name="c_pass" id="password" required>
                            <input type="checkbox" onclick="togglePassword()"> Show Password
                        </div>
                        <div class="form-group">
                            <label>Your Region</label>
                            <select class="form-control" name="c_city" required>
                                <option value="">Select your region</option>
                                <option value="Cavite">Cavite</option>
                                <option value="Batangas">Batangas</option>
                                <option value="Laguna">Laguna</option>
                                <option value="Quezon">Quezon</option>
                                <option value="Lucena">Lucena</option>
                                <option value="Rizal">Rizal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Your Contact</label>
                            <input type="text" class="form-control" name="c_contact" required>
                        </div>
                        <div class="form-group">
                            <label>Your Address</label>
                            <input type="text" class="form-control" name="c_address" required>
                        </div>
                        <div class="form-group">
                            <label>Please Input Your Valid ID</label>
                            <input type="file" class="form-control form-height-custom" name="c_image" required>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" name="register" class="btn btn-primary">
                            <i class="fa fa-user-md"></i> Register
                            </button>
                        </div>
                        
                    </form><!-- form Finish -->
                    
                </div><!-- box-header Finish -->
                
            </div><!-- box Finish -->
            
        </div><!-- col-md-12 Finish -->
        
    </div><!-- container Finish -->
</div><!-- #content Finish -->

<?php 
include("includes/footer.php");
?>
    
<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>

<script>
// Function to toggle the password visibility
function togglePassword() {
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
</script>

</body>
</html>

<?php 

if(isset($_POST['register'])){
    
    $c_name = $_POST['c_name'];
    $c_email = $_POST['c_email'];
    $c_pass = $_POST['c_pass'];  // Store password as plain text
    $c_city = $_POST['c_city'];
    $c_contact = $_POST['c_contact'];
    $c_address = $_POST['c_address'];
    $c_image = $_FILES['c_image']['name'];
    $c_image_tmp = $_FILES['c_image']['tmp_name'];

    // Move the uploaded file to the proper directory
    move_uploaded_file($c_image_tmp, "customer/customer_images/$c_image");

    // Insert the customer with status 'pending'
    $insert_customer = "INSERT INTO customers (customer_name, customer_email, customer_pass, customer_city, customer_contact, customer_address, customer_image, status) 
                        VALUES ('$c_name', '$c_email', '$c_pass', '$c_city', '$c_contact', '$c_address', '$c_image', 'pending')";

    $run_customer = mysqli_query($con, $insert_customer);

    if($run_customer){
        // Redirect to "Waiting for Approval" page after successful registration
        echo "<script>window.location.href='waiting_approval.php';</script>";
        exit();
    } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }
}
?>
