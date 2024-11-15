<?php 
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

// Database connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Payments
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">
                   <i class="fa fa-tags"></i> View Payments
               </h3>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> Payment ID: </th>
                                <th> Invoice No: </th>
                                <th> Amount Due (PHP): </th>
                                <th> Method: </th>
                                <th> Payment Date: </th>
                                <th> Payment Proof: </th>
                                <th> Payment Status: </th>
                                <th> Actions: </th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                                $get_payments = "SELECT payment_id, invoice_no, due_amount, payment_mode, payment_date, proof, payment_status FROM payments";
                                $run_payments = mysqli_query($con, $get_payments);
          
                                while ($row_payments = mysqli_fetch_array($run_payments)) {
                                    $payment_id = $row_payments['payment_id'];
                                    $invoice_no = $row_payments['invoice_no'];
                                    $due_amount = $row_payments['due_amount'];
                                    $payment_mode = $row_payments['payment_mode'];
                                    $payment_date = $row_payments['payment_date'];
                                    $proof = $row_payments['proof'];
                                    $payment_status = $row_payments['payment_status'];
                                    
                                    $proof_path = "http://localhost/katy/proofs/" . basename($proof);
                            ?>
                            
                            <tr id="payment_<?php echo $payment_id; ?>">
                                <td> <?php echo $payment_id; ?> </td>   
                                <td> <?php echo $invoice_no; ?> </td>
                                <td> ₱<?php echo number_format($due_amount, 2); ?></td>
                                <td> <?php echo htmlspecialchars($payment_mode); ?> </td>
                                <td> <?php echo date("Y-m-d", strtotime($payment_date)); ?> </td>
                                <td> 
                                    <a href="<?php echo $proof_path; ?>" target="_blank" title="View Payment Proof">
                                        <img src="<?php echo $proof_path; ?>" style="width:50px; height:50px;" alt="Payment Proof">
                                    </a>
                                </td>
                                <td id="status_<?php echo $payment_id; ?>"> <?php echo htmlspecialchars($payment_status); ?> </td>
                                <td>
                                    <!-- Approve Button, disabled if payment is already verified -->
                                    <button 
                                        onclick="approvePayment(<?php echo $payment_id; ?>)" 
                                        class="btn btn-success btn-sm" 
                                        <?php if ($payment_status == 'verified') echo 'disabled'; ?>
                                    >
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                    
                                    <!-- Delete Button with confirmation -->
                                    <button 
                                        onclick="confirmDelete(<?php echo $payment_id; ?>)" 
                                        class="btn btn-danger btn-sm"
                                    >
                                        <i class="fa fa-trash-o"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Function to approve payment
function approvePayment(paymentId) {
    if (confirm("Are you sure you want to approve this payment?")) {
        $.ajax({
            url: 'approve_payment.php',
            type: 'POST',
            data: { payment_id: paymentId },
            success: function(response) {
                if (response == 'success') {
                    document.getElementById('status_' + paymentId).innerText = 'verified';
                    alert("Payment approved successfully.");
                    location.reload(); // Reload the page to refresh the table after approval
                } else {
                    alert("Error approving payment: " + response);
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + xhr.responseText);
            }
        });
    }
}

// Function to confirm deletion
function confirmDelete(paymentId) {
    if (confirm("Are you sure you want to delete this payment?")) {
        window.location.href = "index.php?delete_payment=" + paymentId;
    }
}
</script>
