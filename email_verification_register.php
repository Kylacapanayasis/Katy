<?php 

$active = 'Account';
include("includes/header.php"); 

// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["verification_code"])) {
    $verification_code = $_POST["verification_code"];
    $email = $_GET["email"]; // Get the email from the URL

    global $con;

    // Verify the OTP code and update the email_verified_at column
    $sql = "UPDATE customers SET email_verified_at = NOW() WHERE verification_code = '$verification_code' AND customer_email = '$email'";
    $result = mysqli_query($con, $sql);

    if (mysqli_affected_rows($con) > 0) {
        // After successful verification, set the status to 'pending' for admin approval
        $sql_pending = "UPDATE customers SET status = 'pending' WHERE customer_email = '$email'";
        mysqli_query($con, $sql_pending);

        // Redirect the user to the waiting for admin approval page
        echo "<script>alert('Email verified successfully! Waiting for admin approval.');</script>";
        echo "<script>window.location.href='waiting_for_approval.php?email=' + encodeURIComponent('$email');</script>";
    } else {
        // Verification code failed
        echo "<p>Verification code failed. Please try again.</p>";
    }
}
?>

<div id="content"><!-- #content Begin -->
    <div class="container"><!-- container Begin -->
        <div class="col-md-12"><!-- col-md-12 Begin -->
            <ul class="breadcrumb"><!-- breadcrumb Begin -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Email Verification
                </li>
            </ul><!-- breadcrumb Finish -->
        </div><!-- col-md-12 Finish -->

        <div class="col-md-12"><!-- col-md-12 Begin -->
            <div class="box"><!-- box Begin -->
                <div class="box-header"><!-- box-header Begin -->
                    <center><!-- center Begin -->
                        <h2>Enter the OTP Code to Verify Email</h2>
                    </center><!-- center Finish -->

                    <form action="#" method="post" enctype="multipart/form-data"><!-- form Begin -->
                        <div class="form-group"><!-- form-group Begin -->
                            <label>Your Verification Code</label>
                            <input type="text" class="form-control" name="verification_code" required>
                        </div><!-- form-group Finish -->

                        <div class="text-center"><!-- text-center Begin -->
                            <button type="submit" name="verify" class="btn btn-primary">
                                <i class="fa fa-user-md"></i> Verify Code
                            </button>
                        </div><!-- text-center Finish -->
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

</body>
</html>
