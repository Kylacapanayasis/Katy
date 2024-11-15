<h1 align="center">Change Password</h1>

<form action="" method="post" onsubmit="return confirmPasswordChange()"><!-- form Begin -->

    <div class="form-group">
        <label>Your Old Password:</label>
        <input type="password" name="old_pass" class="form-control" required id="old_pass">
    </div>

    <div class="form-group">
        <label>Your New Password:</label>
        <input type="password" name="new_pass" class="form-control" required id="new_pass" onkeyup="validatePassword()">
        <small id="passwordHelp" class="form-text text-muted">
            Password must be at least 8 characters, include a number and a special character (e.g., @, #, $).
        </small>
    </div>

    <div class="form-group">
        <label>Confirm Your New Password:</label>
        <input type="password" name="new_pass_again" class="form-control" required id="new_pass_again">
    </div>

    <div class="form-group">
        <input type="checkbox" onclick="togglePasswordVisibility()"> Show Passwords
    </div>

    <div class="text-center">
        <button type="submit" name="submit" class="btn btn-primary" id="submitBtn" disabled>
            <i class="fa fa-user-md"></i> Update Now
        </button>
    </div>

</form>

<script>
function togglePasswordVisibility() {
    var oldPassInput = document.getElementById("old_pass");
    var newPassInput = document.getElementById("new_pass");
    var newPassAgainInput = document.getElementById("new_pass_again");
    
    if (oldPassInput.type === "password") {
        oldPassInput.type = "text";
        newPassInput.type = "text";
        newPassAgainInput.type = "text";
    } else {
        oldPassInput.type = "password";
        newPassInput.type = "password";
        newPassAgainInput.type = "password";
    }
}

function validatePassword() {
    var newPassInput = document.getElementById("new_pass").value;
    var regex = /^(?=.*[!@#$%^&*])(?=.*[0-9])(?=.*[a-zA-Z]).{8,}$/;
    var submitBtn = document.getElementById("submitBtn");

    if (regex.test(newPassInput)) {
        document.getElementById("passwordHelp").style.color = "green";
        submitBtn.disabled = false;
    } else {
        document.getElementById("passwordHelp").style.color = "red";
        submitBtn.disabled = true;
    }
}

function confirmPasswordChange() {
    var newPass = document.getElementById("new_pass").value;
    var confirmPass = document.getElementById("new_pass_again").value;

    if (newPass !== confirmPass) {
        alert("New passwords do not match. Please try again.");
        return false;
    }
    return true;
}
</script>

<?php 
if(isset($_POST['submit'])){
    $c_email = $_SESSION['customer_email'];
    $c_old_pass = $_POST['old_pass'];
    $c_new_pass = $_POST['new_pass'];
    $c_new_pass_again = $_POST['new_pass_again'];

    $sel_c_old_pass = "SELECT * FROM customers WHERE customer_email='$c_email' AND customer_pass='$c_old_pass'";
    $run_c_old_pass = mysqli_query($con,$sel_c_old_pass);
    
    if(mysqli_num_rows($run_c_old_pass) == 0){
        echo "<script>alert('Sorry, your current password is incorrect. Please try again.')</script>";
        exit();
    }

    if($c_new_pass != $c_new_pass_again){
        echo "<script>alert('Sorry, your new passwords do not match.')</script>";
        exit();
    }

    $update_c_pass = "UPDATE customers SET customer_pass='$c_new_pass' WHERE customer_email='$c_email'";
    $run_c_pass = mysqli_query($con,$update_c_pass);

    if($run_c_pass){
        session_destroy();
        echo "<script>alert('Your password has been updated. Please log in again.')</script>";
        echo "<script>window.location.href='../checkout.php';</script>";  // Updated redirect path to index.php outside customer folder
    }
}
?>
