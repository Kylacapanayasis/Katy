<?php
$active = 'Account';
include("includes/header.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['reset_password'])) {
    $email = $_GET['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } 
    // Validate password strength
    elseif (!preg_match('/^(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$/', $new_password)) {
        echo "<script>alert('Password must be at least 8 characters long and include at least one special character and one number.');</script>";
    } 
    else {
        // Update the password without hashing
        $con = mysqli_connect("localhost", "root", "", "ecom_store");

        $sql = "UPDATE customers SET customer_pass='$new_password' WHERE customer_email='$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_affected_rows($con) > 0) {
            echo "<script>alert('Password reset successful! You can now log in.');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<p>Failed to reset password. Please try again.</p>";
        }
    }
}
?>

<div id="content">
    <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Reset Password</li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <center>
                        <h2>Set Your New Password</h2>
                    </center>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   pattern="^(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$" 
                                   title="Must be at least 8 characters, include one special character and one number" 
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
                        </div>
                        <div class="text-center">
                            <button type="submit" name="reset_password" class="btn btn-primary">
                                <i class="fa fa-user-md"></i> Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePasswordVisibility() {
    var newPassword = document.getElementById("new_password");
    var confirmPassword = document.getElementById("confirm_password");
    if (newPassword.type === "password") {
        newPassword.type = "text";
        confirmPassword.type = "text";
    } else {
        newPassword.type = "password";
        confirmPassword.type = "password";
    }
}
</script>

<?php include("includes/footer.php"); ?>
<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>

</body>
</html>
