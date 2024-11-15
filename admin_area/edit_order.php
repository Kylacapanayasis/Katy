<?php 
    
    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>

<div class="col-md-9"><!-- col-md-9 Begin -->
               
               <div class="box"><!-- box Begin -->
                   
                   <h1 align="center"> Confirming Offline Payment</h1>
                   
                   <form action="" method="post" enctype="multipart/form-data"><!-- form Begin -->
                       
                       <div class="form-group"><!-- form-group Begin -->
                           
                         <label> Invoice No: </label>
                          
                          <input type="text" class="form-control" name="invoice_no" required>
                           
                       </div><!-- form-group Finish -->
                       
                       <div class="form-group"><!-- form-group Begin -->
                           
                         <label> Amount Sent: </label>
                          
                          <input type="text" class="form-control" name="amount_sent" required>
                           
                       </div><!-- form-group Finish -->

                       <div class="form-group"><!-- form-group Begin -->
                            <label> Due amount: </label>

                            <input type="text" class="form-control" name="due_amount" >

                        </div><!-- form-group Finish -->
                       
                       <div class="form-group"><!-- form-group Begin -->
                           
                         <label> Select Payment Mode: </label>
                          
                          <select name="payment_mode" class="form-control"><!-- form-control Begin -->
                              
                              <option> Select Payment Mode </option>
                              <option> Cash </option>
                              <!-- <option> Paypall </option>
                              <option> Payoneer </option>
                              <option> Western Union </option> -->
                              
                          </select><!-- form-control Finish -->
                           
                       </div><!-- form-group Finish -->
                       
                       <div class="form-group"><!-- form-group Begin -->
                           
                         <label> Transaction / Reference ID: </label>
                          
                          <input type="text" value="PAID BY CASH" class="form-control" name="ref_no" required>
                           
                       </div><!-- form-group Finish -->
                       
                       <div class="form-group"><!-- form-group Begin -->
                           
                         <label> Payment Date: </label>
                          
                          <input type="text" class="form-control" name="date" required>
                           
                       </div><!-- form-group Finish -->

                       
                    <div class="form-group">

                        <label for="profilePicture">Upload Cash Payment Proof:</label>

                        <input type="file" name="proof" id="profilePicture" class="form-control">

                    </div>
                    
                       
                       <div class="text-center"><!-- text-center Begin -->
                           
                           <button class="btn btn-primary btn-lg" name="confirm_payment"><!-- tn btn-primary btn-lg Begin -->
                               
                               <i class="fa fa-user-md"></i> Confirm Payment
                               
                           </button><!-- tn btn-primary btn-lg Finish -->
                           
                       </div><!-- text-center Finish -->
                       
                   </form><!-- form Finish -->
                   
               </div><!-- box Finish -->
               
           </div><!-- col-md-9 Finish -->

           <?php

    if (isset($_POST['confirm_payment'])) {
    
    $invoice_no = $_POST['invoice_no'];

    $amount = $_POST['amount_sent'];
    $due_amount = $_POST['due_amount'];
    $payment_mode = $_POST['payment_mode'];
    $ref_no = "PAID BY CASH";
    $payment_date = $_POST['date'];
    $payment_proof = $_FILES['proof']['name'];
    $temp_name1 = $_FILES['proof']['tmp_name'];

    $payment_status = "Complete";

    // Check if the file upload was successful before proceeding
   // Check if the file upload was successful before proceeding
    move_uploaded_file($temp_name1, "customer/cash_payment/$payment_proof");

    $insert_payment = "INSERT INTO payments (invoice_no, due_amount, amount, payment_mode, ref_no, payment_date, proof, payment_status) VALUES ('$invoice_no', '$due_amount', '$amount', '$payment_mode', 'PAID BY CASH', '$payment_date', '$payment_proof', '$payment_status')";

        
    $run_payment = mysqli_query($con, $insert_payment);
        
    $update_customer_order = "UPDATE customer_orders SET order_status='$payment_status' WHERE invoice_no='$invoice_no'";
        
    $run_customer_order = mysqli_query($con, $update_customer_order);
        
    if ($run_customer_order) {
            
            echo "<script>alert('Orders Confirmed')</script>";
            
            echo "<script>window.open('index.php?view_orders','_self')</script>";
            
    }else{}

}


?>



<?php } ?> 