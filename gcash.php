<?php 
include("includes/header.php");
include("includes/db.php");
session_start(); // Ensure session is started

// Fetch total from cart for logged-in customer
$customer_email = $_SESSION['customer_email']; // Assuming customer email is stored in session
$customer_total = 0;

if (isset($customer_email)) {
    $get_customer = "SELECT * FROM customers WHERE customer_email='$customer_email'";
    $run_customer = mysqli_query($con, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $customer_id = $row_customer['customer_id'];
    
    $get_cart_total = "SELECT SUM(p_price * qty) AS total FROM cart WHERE customer_id='$customer_id'";
    $run_cart_total = mysqli_query($con, $get_cart_total);
    $row_cart_total = mysqli_fetch_array($run_cart_total);
    $customer_total = $row_cart_total['total'] ?? 0;
}

// Define shipping fee
$shipping_fee = 45.00;
$total_amount = $customer_total + $shipping_fee;

// Function to generate a unique 9-digit invoice number
function generateUniqueInvoiceNo($con) {
    do {
        $invoice_no = mt_rand(100000000, 999999999); // Generates a 9-digit number
        // Check if invoice_no already exists in payments table
        $check_query = "SELECT invoice_no FROM payments WHERE invoice_no='$invoice_no' LIMIT 1";
        $result = mysqli_query($con, $check_query);
    } while(mysqli_num_rows($result) > 0); // Repeat if invoice_no is not unique
    return $invoice_no;
}

// Generate the invoice number once to use throughout the page
$invoice_no = generateUniqueInvoiceNo($con);

?>
    
<!-- Add Google Fonts for better typography -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    /* General font styling */
    body {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }

    h2, h1 {
        font-weight: 600;
        color: #2c3e50;
    }

    p, li {
        font-weight: 400;
        font-size: 16px;
        color: #555;
    }

    /* Breadcrumb styling */
    ul.breadcrumb li a {
        color: #2980b9;
        text-decoration: none;
    }
    
    ul.breadcrumb li {
        display: inline;
        margin-right: 5px;
    }

    /* Box styling */
    .box {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 25px;
        border-radius: 8px;
    }

    .box-header {
        text-align: center;
        margin-bottom: 30px;
    }

    /* Payment amount styling */
    .amount-to-pay {
        font-size: 24px;
        font-weight: 600;
        color: #e74c3c;
        margin-bottom: 20px;
    }

    /* Instruction styling */
    .instructions {
        font-weight: 600;
        font-size: 18px;
        color: #27ae60;
    }

    .instruction-list {
        margin-top: 15px;
        margin-bottom: 30px;
    }

    .instruction-list li {
        margin-bottom: 10px;
    }

    /* Payment Proof upload section */
    .upload-section label {
        font-size: 16px;
        color: #333;
        margin-bottom: 10px;
    }

    .upload-section .btn-submit {
        background-color: #27ae60;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        margin-top: 10px;
        cursor: pointer;
    }

    .upload-section .btn-submit:hover {
        background-color: #2ecc71;
    }

    /* QR code image styling */
    .image-container {
        text-align: center;
    }

    .qr-code {
        max-width: 80%;
        margin: 0 auto;
    }
    
</style>

<div id="content">
    <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Gcash</li>
            </ul>

            <div class="col-md-12"><!-- col-md-12 Begin -->
                <div class="box"><!-- box Begin -->
                    <div class="box-header"><!-- box-header Begin -->
                        <center><!-- center Begin -->
                            <h2>Scan & Pay</h2>
                            <p>Your payment is required to complete the order. Follow these steps:</p>
                        </center><!-- center Finish -->

                        <!-- Display the due amount with shipping fee -->
                        <div class="amount-to-pay text-center">
                            <?php
                                echo "Amount to Pay: ₱" . number_format($total_amount, 2);
                                echo "<p>(Including ₱45 shipping fee)</p>";
                            ?>
                        </div>

                        <div class="breadcrumb">
                            <div class="row">
                                <!-- Left Side: Instructions -->
                                <div class="col-md-6">
                                    <h1 class="scan-title">Step-by-Step Guide</h1>
                                    
                                    <p class="instructions">Instructions:</p>
                                    <ol class="instruction-list">
                                        <li>Scan the QR code below using your Gcash app.</li>
                                        <li>Make sure to send the <strong>exact amount</strong> including the shipping fee.</li>
                                        <li>If the amount is not exact, the order will be cancelled automatically.</li>
                                        <li>If the QR code isn't working, you can send the payment manually to this number: <strong>09608648358</strong>.</li>
                                    </ol>

                                    <div class="row">
                                        <div class="col-md-12 upload-section">
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <label>Upload Proof of Payment (JPEG, PNG):</label>
                                                <input type="file" name="payment_proof" accept=".jpeg,.jpg,.png" required>
                                                <!-- Pass the generated invoice_no as a hidden field -->
                                                <input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>">
                                                <button type="submit" name="confirm_payment" class="btn-submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($_POST['confirm_payment'])) {
                                        // Retrieve the invoice_no from the hidden field
                                        $invoice_no_post = mysqli_real_escape_string($con, $_POST['invoice_no']);
                                        
                                        $c_id = $customer_id; // Use the fetched customer ID
                                        $status = "pending";
                                        $method = "online";

                                        // Check for uploaded file
                                        $proof = $_FILES['payment_proof']['name'];
                                        $proof_tmp = $_FILES['payment_proof']['tmp_name'];
                                        $proof_folder = "proofs/" . basename($proof); // Use basename to prevent directory traversal

                                        // Optional: Generate a unique filename to prevent overwriting
                                        $file_extension = pathinfo($proof, PATHINFO_EXTENSION);
                                        $unique_proof_name = "proof_" . $invoice_no_post . "_" . time() . "." . $file_extension;
                                        $proof_folder = "proofs/" . $unique_proof_name;

                                        // Move uploaded file
                                        if (move_uploaded_file($proof_tmp, $proof_folder)) {
                                            // Get cart items
                                            $select_cart = "SELECT * FROM cart WHERE customer_id='$c_id'";
                                            $run_cart = mysqli_query($con, $select_cart);

                                            // Initialize shipping fee addition
                                            $shipping_added = false;

                                            while ($row_cart = mysqli_fetch_array($run_cart)) {
                                                $pro_id = $row_cart['p_id'];
                                                $pro_qty = $row_cart['qty'];
                                                $pro_roast = $row_cart['roast'];
                                                $pro_coffee = $row_cart['coffee'];
                                                $sub_total = $row_cart['p_price'] * $pro_qty;

                                                // Add shipping fee only once
                                                if (!$shipping_added) {
                                                    $due_amount = $sub_total + $shipping_fee;
                                                    $shipping_added = true;
                                                } else {
                                                    $due_amount = $sub_total;
                                                }

                                                // Insert into customer_orders
                                                $insert_customer_order = "INSERT INTO customer_orders 
                                                    (product_id, customer_id, due_amount, invoice_no, qty, roast, coffee, order_date, order_status, payment_method) 
                                                    VALUES ('$pro_id', '$c_id', '$due_amount', '$invoice_no_post', '$pro_qty', '$pro_roast', '$pro_coffee', NOW(), '$status', '$method')";
                                                $run_customer_order = mysqli_query($con, $insert_customer_order);
                                                
                                                if(!$run_customer_order){
                                                    // Handle insertion error
                                                    echo "<script>alert('Error processing your order. Please contact support.')</script>";
                                                    exit();
                                                }
                                            }

                                            // Insert payment data into payments table with due_amount
                                            $insert_payment = "INSERT INTO payments 
                                                (invoice_no, due_amount, payment_mode, payment_date, proof, payment_status) 
                                                VALUES ('$invoice_no_post', '$total_amount', '$method', NOW(), '$proof_folder', '$status')";
                                            $run_payment = mysqli_query($con, $insert_payment);

                                            if(!$run_payment){
                                                // Handle insertion error
                                                echo "<script>alert('Error processing your payment. Please contact support.')</script>";
                                                exit();
                                            }

                                            // Clear cart
                                            $delete_cart = "DELETE FROM cart WHERE customer_id='$c_id'";
                                            $run_delete = mysqli_query($con, $delete_cart);

                                            if(!$run_delete){
                                                // Handle deletion error
                                                echo "<script>alert('Error clearing your cart. Please contact support.')</script>";
                                                exit();
                                            }

                                            // Redirect to order summary
                                            echo "<script>alert('Your order has been submitted. Thank you!')</script>";
                                            echo "<script>window.open('order_summary.php?invoice_no=$invoice_no_post', '_self')</script>";
                                        } else {
                                            echo "<script>alert('Failed to upload payment proof. Please try again.')</script>";
                                        }
                                    }
                                    ?>
                                </div>

                                <!-- Right Side: QR Code Image -->
                                <div class="col-md-6">
                                    <div class="image-container">
                                        <img class="img-responsive qr-code" src="images/qrr.jpg" alt="QR code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- box-header Finish -->
                </div><!-- box Finish -->
            </div><!-- col-md-12 Finish -->
        </div><!-- container Finish -->
    </div><!-- #content Finish -->
</div>

<?php include("includes/footer.php"); ?>
