<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/bootstrap-337.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
        integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
</head>

<body>

    <?php
    $customer_session = $_SESSION['customer_email'];
    $get_customer = "SELECT * FROM customers WHERE customer_email='$customer_session'";
    $run_customer = mysqli_query($con, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $customer_id = $row_customer['customer_id'];
    $customer_name = $row_customer['customer_name'];
    $customer_address = $row_customer['customer_address'];
    $customer_email = $row_customer['customer_email'];
    $customer_contact = $row_customer['customer_contact'];
    ?>

<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-15"><span
                                    class="badge bg-success font-size-12 ms-2"></span></h4>
                            <div class="mb-4">
                                <h2 class="mb-1 text-muted">Katy's Coffee Farm</h2>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1"> Barangay Tipacan, Lipa City, Philippines</p>
                                <p><i class="uil uil-phone me-1"></i> 0917-894-7253</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2"><?php echo $customer_name; ?></h5>
                                    <p class="mb-1"><?php echo $customer_address; ?></p>
                                    <p class="mb-1"><?php echo $customer_email; ?> </p>
                                    <p><?php echo $customer_contact; ?></p>
                                </div>
                            </div>
                            <!-- end col -->
                            <!-- <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                        <p>#<?php echo $invoice_no; ?></p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p><?php echo $order_date; ?></p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Order No:</h5>
                                        <p>#</p>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Product Title</th>
                                            <th>Product total amount</th>
                                            <th>Invoice no.</th>
                                            <th>Quantity</th>
                                            <th>Order Date</th>
                                            <th> Paid / Unpaid: </th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        $get_orders = "SELECT * FROM customer_orders WHERE customer_id='$customer_id' AND order_status='Complete'";
                                        $run_orders = mysqli_query($con, $get_orders);

                                        $i = 0;
                                        $total_due_amount = 0;

                                        while ($row_orders = mysqli_fetch_array($run_orders)) {
                                            $invoice_no = $row_orders['invoice_no'];
                                            $product_id = $row_orders['product_id'];
                                            $order_id = $row_orders['order_id'];
                                            $due_amount = $row_orders['due_amount'];
                                            $qty = $row_orders['qty'];
                                            $method = $row_orders['payment_method'];
                                            $order_date = substr($row_orders['order_date'], 0, 11);
                                            $order_status = $row_orders['order_status'];

                                          

                                            if ($order_status == 'pending') {
                                                $order_status = 'Unpaid';
                                            } elseif ($order_status == 'Complete') {
                                                $order_status = 'Paid';
                                            } else {
                                                $order_status = 'Cancelled';
                                            }

                                            $i++;
                                            $total_due_amount += $due_amount;
                                        ?>


                                        <?php

                                            $get_product_title = "select * from products where product_id ='$product_id'";
                                            $run_title = mysqli_query($con, $get_product_title);

                                            while ($row_title = mysqli_fetch_array($run_title)) {

                                                $title = $row_title['product_title'];
                                            }

                                        ?>

                                            <tr>
                                                <th><?php echo $i; ?></th>
                                                <td><?php echo $title; ?></td>
                                                <td>₱<?php echo $due_amount; ?> </td>
                                                <td><?php echo $invoice_no; ?></td>
                                                <td><?php echo $qty; ?></td>
                                                <td><?php echo $order_date; ?></td>
                                                <td><?php echo $order_status; ?></td>
                                            </tr>
                                            
                                        <?php
                                        } // end while loop
                                        ?>
                                        <tr>
                                            <th scope="row" colspan="6" class="text-end total-amount-header">Total amount</th>
                                            <td class="text-start total-amount-cell">P<?php echo $total_due_amount; ?></td>
                                        </tr>
                                        <style>
                                            .total-amount-header,
                                            .total-amount-cell {
                                                font-weight: bold;
                                                padding: 10px; /* Adjust padding for spacing inside the box */
                                                background-color: #f2f2f2; /* Set background color as needed */
                                            }
                                        </style>

                                        <!-- Add the total and other summary rows here -->
                                        
                                        <!-- Add other summary rows as needed -->

                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end table responsive -->

                            <div class="d-print-none mt-4">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                            class="fa fa-print"></i> Print</a>
                                   
                                    <button type="button" class="btn btn-danger" onclick="redirectToorders()" data-mdb-ripple-init>Go back to orders</button>

                                    <script>
                                        function redirectToorders() {
                                            window.location.href = 'my_account.php?my_orders.php';
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>


</body>

</html>
