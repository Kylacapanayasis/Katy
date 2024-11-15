<!-- sales per day -->
<div class="row"><!-- row 1 begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <ol class="breadcrumb"><!-- breadcrumb begin -->
            <li class="active"><!-- active begin -->
                <i class="fa fa-dashboard"></i> Dashboard / Sales
            </li><!-- active finish -->
        </ol><!-- breadcrumb finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row 1 finish -->

<div class="row"><!-- row begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <div class="panel panel-default"><!-- panel panel-default begin -->
            <div class="panel-heading"><!-- panel-heading begin -->
                <h3 class="panel-title"><!-- panel-title begin -->
                    <i class="fa fa-tags"></i> View Sales per Day
                </h3><!-- panel-title finish -->
            </div><!-- panel-heading finish -->

            <form method="post" action="">
                <div class="input-group"><!-- input-group Begin -->
                    <input type="number" class="form-control" placeholder="Search" name="date">
                    <button type="submit" name="search" value="Search" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div><!-- input-group Finish -->
            </form>

            <?php
            if (isset($_POST['search'])) {
                $selectedDate = $_POST['date'];
                
                global $con;

                $query = "SELECT * FROM payments WHERE DAY(payment_date) = '$selectedDate'";
                $result = mysqli_query($con, $query);
                
                if(mysqli_num_rows($result) > 0) {
            ?>
            <div class="panel-body"><!-- panel-body begin -->
                <div class="table-responsive"><!-- table-responsive begin -->
                    <table class="table table-striped table-bordered table-hover"><!-- table table-striped table-bordered table-hover begin -->
                        <thead><!-- thead begin -->
                            <tr><!-- tr begin -->
                                <th> Payment ID: </th>
                                <th> Invoice No: </th>
                                <th> Method: </th>
                                <th> Reference No: </th>
                                <th> Payment Date: </th>
                                <th> Amount Paid: </th>
                                <th> Product Amount: </th>
                            </tr><!-- tr finish -->
                        </thead><!-- thead finish -->
                        <tbody><!-- tbody begin -->
                            <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $payment_id = $row['payment_id'];
                                    $invoice_no = $row['invoice_no'];
                                    $amount = $row['amount'];
                                    $payment = $row['payment_mode'];
                                    $ref = $row['ref_no'];
                                    $payment_date = $row['payment_date'];

                                    $due_amount_query = "SELECT due_amount FROM payments WHERE invoice_no = '$invoice_no'";
                                    $due_amount_result = mysqli_query($con, $due_amount_query);
                                    $due_amount_row = mysqli_fetch_assoc($due_amount_result);
                                    $due_amount = $due_amount_row['due_amount'];

                                    echo "<tr>";
                                    echo "<td>$payment_id</td>";
                                    echo "<td>$invoice_no</td>";
                                    echo "<td>$payment</td>";
                                    echo "<td>$ref</td>";
                                    echo "<td>$payment_date</td>";
                                    echo "<td>$amount</td>";
                                    echo "<td>$due_amount</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody><!-- tbody finish -->
>
                        <tfoot>
                    <tr>
                        <th colspan="6">Total Sales per Day:</th>
                        <th>
                            <?php
                            $total_sales_query = "SELECT SUM(due_amount) AS total_sales FROM payments WHERE DAY(payment_date) = '$selectedDate'";
                            $total_sales_result = mysqli_query($con, $total_sales_query);

                            // Check if the query was successful
                            if ($total_sales_result) {
                                // Fetch the result
                                $total_sales_row = mysqli_fetch_assoc($total_sales_result);

                                // Output the result
                                echo $total_sales_row['total_sales'];
                            } else {
                                // Handle the case where the query fails
                                echo "Error fetching total sales";
                            }
                            ?>
                        </th>
                    </tr>
                </tfoot>
                        </tbody><!-- tbody finish -->

                        
                    </table><!-- table table-striped table-bordered table-hover finish -->
                </div><!-- table-responsive finish -->
            </div><!-- panel-body finish -->
            <?php
                } else {
                    echo "<div class='alert alert-warning'>No data found for the selected date.</div>";
                }
            }
            ?>
        </div><!-- panel panel-default finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row finish -->

<!-- sales per week -->
<div class="row"><!-- row begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <div class="panel panel-default"><!-- panel panel-default begin -->
            <div class="panel-heading"><!-- panel-heading begin -->
                <h3 class="panel-title"><!-- panel-title begin -->
                    <i class="fa fa-tags"></i> View Sales per Week
                </h3><!-- panel-title finish -->
            </div><!-- panel-heading finish -->

            <form method="post" action="">
                <div class="input-group"><!-- input-group Begin -->
                    <input type="text" class="form-control" placeholder="Start Date" name="startDate">
                    <input type="text" class="form-control" placeholder="End Date" name="endDate">
                    <button type="submit" name="search2" value="Search" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div><!-- input-group Finish -->
            </form>

            <?php
            if (isset($_POST['search2'])) {
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                
                global $con;

                // Displaying sales for the selected date
                $query = "SELECT * FROM payments WHERE DATE(payment_date) BETWEEN '$startDate' AND '$endDate'";
                $result = mysqli_query($con, $query);
                
                if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="panel-body"><!-- panel-body begin -->
                <div class="table-responsive"><!-- table-responsive begin -->
                    <table class="table table-striped table-bordered table-hover"><!-- table table-striped table-bordered table-hover begin -->
                        <thead><!-- thead begin -->
                            <tr><!-- tr begin -->
                                <th> Payment ID: </th>
                                <th> Invoice No: </th>
                                <th> Method: </th>
                                <th> Reference No: </th>
                                <th> Payment Date: </th>
                                <th> Amount Paid: </th>
                                <th> Product Amount: </th>
                            </tr><!-- tr finish -->
                        </thead><!-- thead finish -->
                        <tbody><!-- tbody begin -->
                            <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // ... your existing code for displaying payment details

                                    $payment_id = $row['payment_id'];
                                    $invoice_no = $row['invoice_no'];
                                    $amount = $row['amount'];
                                    $payment = $row['payment_mode'];
                                    $ref = $row['ref_no'];
                                    $payment_date = $row['payment_date'];

                                    $due_amount_query = "SELECT due_amount FROM payments WHERE invoice_no = '$invoice_no'";
                                    $due_amount_result = mysqli_query($con, $due_amount_query);
                                    $due_amount_row = mysqli_fetch_assoc($due_amount_result);
                                    $due_amount = $due_amount_row['due_amount'];


                                    echo "<tr>";
                                    echo "<td>$payment_id</td>";
                                    echo "<td>$invoice_no</td>";
                                    echo "<td>$payment</td>";
                                    echo "<td>$ref</td>";
                                    echo "<td>$payment_date</td>";
                                    echo "<td>$amount</td>";
                                    echo "<td>$due_amount</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody><!-- tbody finish -->
                        <tfoot>
                                    <tr>
                                        <th colspan="6">Total Sales per Week:</th>
                                        <th>
                                            <?php
                                            // Displaying total sales per week
                                            $startOfWeek = date('Y-m-d', strtotime('last Monday', strtotime($startDate)));
                                            $endOfWeek = date('Y-m-d', strtotime('next Sunday', strtotime($endDate)));

                                            $total_sales_query = "SELECT SUM(due_amount) AS total_sales FROM payments WHERE payment_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
                                            $total_sales_result = mysqli_query($con, $total_sales_query);

                                            // Check if the query was successful
                                            if ($total_sales_result) {
                                                // Fetch the result
                                                $total_sales_row = mysqli_fetch_assoc($total_sales_result);

                                                // Output the result
                                                echo $total_sales_row['total_sales'];
                                            } else {
                                                // Handle the case where the query fails
                                                echo "Error fetching total sales";
                                            }
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table><!-- table table-striped table-bordered table-hover finish -->
                        </div><!-- table-responsive finish -->
                    </div><!-- panel-body finish -->
                    <?php
                } else {
                    echo "<div class='alert alert-warning'>No data found for the selected date.</div>";
                }
            }
            ?>
        </div><!-- panel panel-default finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row finish -->


<!-- Sales per month -->
<div class="row"><!-- row begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <div class="panel panel-default"><!-- panel panel-default begin -->
            <div class="panel-heading"><!-- panel-heading begin -->
                <h3 class="panel-title"><!-- panel-title begin -->
                    <i class="fa fa-tags"></i> View Sales per Month
                </h3><!-- panel-title finish -->
            </div><!-- panel-heading finish -->

            <form method="post" action="">
                <div class="input-group"><!-- input-group Begin -->
                    <input type="text" class="form-control" placeholder="Search" name="date3">
                    <button type="submit" name="search3" value="Search" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div><!-- input-group Finish -->
            </form>

            <?php
            $monthMapping = array(
                'january' => '01',
                'february' => '02',
                'march' => '03',
                'april' => '04',
                'may' => '05',
                'june' => '06',
                'july' => '07',
                'august' => '08',
                'september' => '09',
                'october' => '10',
                'november' => '11',
                'december' => '12'
            );

            if (isset($_POST['search3'])) {
                $monthInput = strtolower($_POST['date3']);

                // Check if the input month is in the mapping
                if (isset($monthMapping[$monthInput])) {
                    // Valid month, use it in your query
                    $selectedMonth = $monthMapping[$monthInput];

                    global $con;

                    $query = "SELECT * FROM payments WHERE MONTH(payment_date) = '$selectedMonth'";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {
            ?>
                        <div class="panel-body"><!-- panel-body begin -->
                            <div class="table-responsive"><!-- table-responsive begin -->
                                <table class="table table-striped table-bordered table-hover"><!-- table table-striped table-bordered table-hover begin -->
                                    <thead><!-- thead begin -->
                                        <tr><!-- tr begin -->
                                            <th> Payment ID: </th>
                                            <th> Invoice No: </th>
                                            <th> Method: </th>
                                            <th> Reference No: </th>
                                            <th> Payment Date: </th>
                                            <th> Amount Paid: </th>
                                            <th> Product Amount: </th>
                                        </tr><!-- tr finish -->
                                    </thead><!-- thead finish -->
                                    <tbody><!-- tbody begin -->
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $payment_id = $row['payment_id'];
                                            $invoice_no = $row['invoice_no'];
                                            $amount = $row['amount'];
                                            $payment = $row['payment_mode'];
                                            $ref = $row['ref_no'];
                                            $payment_date = $row['payment_date'];

                                            $due_amount_query = "SELECT due_amount FROM payments WHERE invoice_no = '$invoice_no'";
                                            $due_amount_result = mysqli_query($con, $due_amount_query);
                                            $due_amount_row = mysqli_fetch_assoc($due_amount_result);
                                            $due_amount = $due_amount_row['due_amount'];

                                            echo "<tr>";
                                            echo "<td>$payment_id</td>";
                                            echo "<td>$invoice_no</td>";
                                            echo "<td>$payment</td>";
                                            echo "<td>$ref</td>";
                                            echo "<td>$payment_date</td>";
                                            echo "<td>$amount</td>";
                                            echo "<td>$due_amount</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody><!-- tbody finish -->

                                    <tfoot>
                                        <tr>
                                            <th colspan="6">Total Sales per Month:</th>
                                            <th>
                                                <?php
                                                $total_sales_query = "SELECT SUM(due_amount) AS total_sales FROM payments WHERE MONTH(payment_date) = '$selectedMonth'";
                                                $total_sales_result = mysqli_query($con, $total_sales_query);

                                                // Check if the query was successful
                                                if ($total_sales_result) {
                                                    // Fetch the result
                                                    $total_sales_row = mysqli_fetch_assoc($total_sales_result);

                                                    // Output the result
                                                    echo $total_sales_row['total_sales'];
                                                } else {
                                                    // Handle the case where the query fails
                                                    echo "Error fetching total sales";
                                                }
                                                ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table><!-- table table-striped table-bordered table-hover finish -->
                            </div><!-- table-responsive finish -->
                        </div><!-- panel-body finish -->
            <?php
                    } else {
                        echo "<div class='alert alert-warning'>No data found for the selected month.</div>";
                    }
                } else {
                    // Invalid month input
                    echo "<div class='alert alert-danger'>Invalid month input. Please enter a valid month name.</div>";
                }
            }
            ?>
        </div><!-- panel panel-default finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row finish -->



<!-- Sales per Year -->
<div class="row"><!-- row begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <div class="panel panel-default"><!-- panel panel-default begin -->
            <div class="panel-heading"><!-- panel-heading begin -->
                <h3 class="panel-title"><!-- panel-title begin -->
                    <i class="fa fa-tags"></i> View Sales per Year
                </h3><!-- panel-title finish -->
            </div><!-- panel-heading finish -->

            <form method="post" action="">
                <div class="input-group"><!-- input-group Begin -->
                    <input type="number" class="form-control" placeholder="Search" name="date4">
                    <button type="submit" name="search4" value="Search" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div><!-- input-group Finish -->
            </form>

            <?php
            if (isset($_POST['search4'])) {
                $selectedyear = $_POST['date4'];
                
                global $con;

                $query = "SELECT * FROM payments WHERE YEAR(payment_date) = '$selectedyear'";
                $result = mysqli_query($con, $query);
                
                if(mysqli_num_rows($result) > 0) {
            ?>
            <div class="panel-body"><!-- panel-body begin -->
                <div class="table-responsive"><!-- table-responsive begin -->
                    <table class="table table-striped table-bordered table-hover"><!-- table table-striped table-bordered table-hover begin -->
                        <thead><!-- thead begin -->
                            <tr><!-- tr begin -->
                                <th> Payment ID: </th>
                                <th> Invoice No: </th>
                                <th> Method: </th>
                                <th> Reference No: </th>
                                <th> Payment Date: </th>
                                <th> Amount Paid: </th>
                                <th> Product Amount: </th>
                            </tr><!-- tr finish -->
                        </thead><!-- thead finish -->
                        <tbody><!-- tbody begin -->
                            <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $payment_id = $row['payment_id'];
                                    $invoice_no = $row['invoice_no'];
                                    $amount = $row['amount'];
                                    $payment = $row['payment_mode'];
                                    $ref = $row['ref_no'];
                                    $payment_date = $row['payment_date'];

                                    $due_amount_query = "SELECT due_amount FROM payments WHERE invoice_no = '$invoice_no'";
                                    $due_amount_result = mysqli_query($con, $due_amount_query);
                                    $due_amount_row = mysqli_fetch_assoc($due_amount_result);
                                    $due_amount = $due_amount_row['due_amount'];

                                    echo "<tr>";
                                    echo "<td>$payment_id</td>";
                                    echo "<td>$invoice_no</td>";
                                    echo "<td>$payment</td>";
                                    echo "<td>$ref</td>";
                                    echo "<td>$payment_date</td>";
                                    echo "<td>$amount</td>";
                                    echo "<td>$due_amount</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody><!-- tbody finish -->
>
                        <tfoot>
                    <tr>
                        <th colspan="6">Total Sales per Year:</th>
                        <th>
                            <?php
                            $total_sales_query = "SELECT SUM(due_amount) AS total_sales FROM payments WHERE YEAR(payment_date) = '$selectedyear'";
                            $total_sales_result = mysqli_query($con, $total_sales_query);

                            // Check if the query was successful
                            if ($total_sales_result) {
                                // Fetch the result
                                $total_sales_row = mysqli_fetch_assoc($total_sales_result);

                                // Output the result
                                echo $total_sales_row['total_sales'];
                            } else {
                                // Handle the case where the query fails
                                echo "Error fetching total sales";
                            }
                            ?>
                        </th>
                    </tr>
                </tfoot>
                        </tbody><!-- tbody finish -->

                        
                    </table><!-- table table-striped table-bordered table-hover finish -->
                </div><!-- table-responsive finish -->
            </div><!-- panel-body finish -->
            <?php
                } else {
                    echo "<div class='alert alert-warning'>No data found for the selected date.</div>";
                }
            }
            ?>
        </div><!-- panel panel-default finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row finish -->




    

