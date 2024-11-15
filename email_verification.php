<?php 

$active = 'Account';
include("includes/header.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["verification_code"])) {
    $verification_code = $_POST["verification_code"];
    $email = $_GET["email"];

    $con = mysqli_connect("localhost", "root", "", "ecom_store");

    $sql = "UPDATE customers SET email_verified_at = NOW() WHERE verification_code = '$verification_code' AND customer_email = '$email'";
    $result = mysqli_query($con, $sql);

    if (mysqli_affected_rows($con) > 0) {
        echo "<script>alert('Verification successful! Please set your new password.');</script>";
        echo "<script>window.location.href='reset_password.php?email=' + encodeURIComponent('$email');</script>";
    } else {
        echo "<p>Verification code failed. Please try again.</p>";
    }
}
?>

<div id="content">
    <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Email Verification</li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <center>
                        <h2>Enter the OTP Code to Verify Email</h2>
                    </center>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Your Verification Code</label>
                            <input type="text" class="form-control" name="verification_code" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="verify" class="btn btn-primary">
                                <i class="fa fa-user-md"></i> Verify Code
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script src="js/jquery-331.min.js"></script>
<script src="js/bootstrap-337.min.js"></script>

</body>
</html>
