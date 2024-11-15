<?php 

$active = 'Account';
include("includes/header.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

if (isset($_POST["update"])) {
    $email = $_POST["c_email"];
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0; // Change to 2 for verbose debugging
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'christiandenvermendoza@gmail.com'; // Your Gmail address
        $mail->Password = 'ojrbzcgnufzsgwyy';    // Your App Password for Gmail
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('your_email@gmail.com', 'Katy Coffee Farm');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $verification_code = substr(number_format(time() * rand(), 0, '', '',), 0, 6);
        $mail->Subject = 'Password Reset Verification';
        $mail->Body = '<p>Your verification code is: <b style="font-size:30px;">' . $verification_code . '</b></p>';

        $mail->send();

        $con = mysqli_connect("localhost", "root", "", "ecom_store");

        $sql = "UPDATE customers SET verification_code='$verification_code' WHERE customer_email = '$email'";
        mysqli_query($con, $sql);

        echo "<script>window.location.href='email_verification.php?email=' + encodeURIComponent('$email');</script>";
        exit();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>

<div id="content">
    <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Forgot Password</li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <center>
                        <h2>Forgot Password?</h2>
                    </center>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Your Email</label>
                            <input type="text" class="form-control" name="c_email" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="update" class="btn btn-primary">
                                <i class="fa fa-user-md"></i> Send Verification Code
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
