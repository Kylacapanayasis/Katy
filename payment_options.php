<div class="box"><!-- box Begin -->
   
   <?php 
    
    $session_email = $_SESSION['customer_email'];
    
    $select_customer = "select * from customers where customer_email='$session_email'";
    
    $run_customer = mysqli_query($con,$select_customer);
    
    $row_customer = mysqli_fetch_array($run_customer);
    
    $customer_id = $row_customer['customer_id'];
    
    ?>
    
    <h1 class="text-center">Payment Options For You</h1>  
    
     <p class="lead text-center"><!-- lead text-center Begin -->
         
         <a href="customer/my_account.php?pay_offline"> Offline Payment

         </a>
         
     </p><!-- lead text-center Finish -->
     
     <center><!-- center Begin -->
         
        <p class="lead"><!-- lead Begin -->
            
            <a href="gcash.php">
                
                Online Payment
                
                <!-- <img class="img-responsive" src="images/gkas.png" alt="img-gcash"> -->

                <h1></h1>

                <!-- <img class="img-responsive" src="images/qr.jpg" alt="img-qrlods"> -->
                
            </a>
            
        </p> <!-- lead Finish -->
         
     </center><!-- center Finish -->
    
</div><!-- box Finish -->

<script src="js/jquery-331.min.js"></script>