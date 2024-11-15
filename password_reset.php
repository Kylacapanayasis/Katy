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
                       Forgot Password
                   </li>
               </ul><!-- breadcrumb Finish -->
               
           </div><!-- col-md-12 Finish -->

           <div class="col-md-12"><!-- col-md-12 Begin -->
               
               <div class="box"><!-- box Begin -->
                   
                   <div class="box-header"><!-- box-header Begin -->
                       
                       <center><!-- center Begin -->
                           
                           <h2> Forgot a Password? </h2>
                           
                       </center><!-- center Finish -->

                       <form action="#" method="post" enctype="multipart/form-data"><!-- form Begin -->

                            <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Email</label>
                               
                               <input type="text" class="form-control" name="c_email" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>New password</label>
                               
                               <input type="password" class="form-control" name="new_pass" required>
                               
                           </div><!-- form-group Finish -->

                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Confirm new password</label>
                               
                               <input type="password" class="form-control" name="confirm_pass" required>
                               
                           </div><!-- form-group Finish --

                           <div class="text-center"><!-- text-center Begin -->
                               
                               <button type="submit" name="change" class="btn btn-primary">
                               
                               <i class="fa fa-user-md"></i> Change Password
                               
                               </button>
                               
                           </div><!-- text-center Finish -->

                           <?php

                           if(isset($_POST["change"])){

                                $email = $_POST['c_email'];
                                $new_pass = $_POST['new_pass'];
                                $confirm_pass = $_POST['confirm_pass'];

                                global $con;

                                if ($new_pass !== $confirm_pass) {
                                    echo "<script>alert('Password not matched');</script>";
                                }

                                $sql = "UPDATE customers SET customer_pass = '$new_pass' WHERE customer_email = '$email'";
                                $result = mysqli_query($con, $sql);

                                if($result && mysqli_affected_rows($con) > 0){
                                    echo "<script>alert('Password changed');</script>";

                                    echo "<script>window.location.href='checkout.php';</script>";
                                } else {
                                    die("Password change failed");
                                }

                    

                                exit();
                            }


                            ?>

