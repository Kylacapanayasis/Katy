<?php 
    if(!isset($_SESSION['admin_email'])){
        echo "<script>window.open('login.php','_self')</script>";
    } else {

?>

<div class="row"><!-- row 1 begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <ol class="breadcrumb"><!-- breadcrumb begin -->
            <li class="active"><!-- active begin -->
                <i class="fa fa-dashboard"></i> Dashboard / View Customers
            </li><!-- active finish -->
        </ol><!-- breadcrumb finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row 1 finish -->

<div class="row"><!-- row 2 begin -->
    <div class="col-lg-12"><!-- col-lg-12 begin -->
        <div class="panel panel-default"><!-- panel panel-default begin -->
            <div class="panel-heading"><!-- panel-heading begin -->
               <h3 class="panel-title"><!-- panel-title begin -->
                   <i class="fa fa-tags"></i> View Customers
               </h3><!-- panel-title finish --> 
            </div><!-- panel-heading finish -->
            
            <div class="panel-body"><!-- panel-body begin -->
                <div class="table-responsive"><!-- table-responsive begin -->
                    <table class="table table-striped table-bordered table-hover"><!-- table table-striped table-bordered table-hover begin -->
                        
                        <thead><!-- thead begin -->
                            <tr><!-- tr begin -->
                                <th> No: </th>
                                <th> Name: </th>
                                <th> Valid Id: </th>
                                <th> E-Mail: </th>
                                <th> City: </th>
                                <th> Address: </th>
                                <th> Contact: </th>
                                <th> Status: </th>
                                <th> Approve / Disapprove: </th>
                                <th> Action: </th>
                            </tr><!-- tr finish -->
                        </thead><!-- thead finish -->
                        
                        <tbody><!-- tbody begin -->
                             <?php 
                                $i=0;
                                $get_c = "SELECT * FROM customers";
                                $run_c = mysqli_query($con, $get_c);
                                
                                while($row_c=mysqli_fetch_array($run_c)){
                                    $c_id = $row_c['customer_id'];
                                    $c_name = $row_c['customer_name'];
                                    $c_img = $row_c['customer_image'];
                                    $c_email = $row_c['customer_email'];
                                    $c_city = $row_c['customer_city'];
                                    $c_address = $row_c['customer_address'];
                                    $c_contact = $row_c['customer_contact'];
                                    $c_status = $row_c['status'];  // Get status
                                    $i++;
                             ?>
                             <tr><!-- tr begin -->
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo $c_name; ?> </td>
                                <td> <img src="../customer/customer_images/<?php echo $c_img; ?>" width="60" height="60"></td>
                                <td> <?php echo $c_email; ?> </td>
                                <td> <?php echo $c_city; ?> </td>
                                <td> <?php echo $c_address ?> </td>
                                <td> <?php echo $c_contact ?> </td>
                                <td> 
                                    <?php 
                                    if($c_status == 'approved'){
                                        echo "<span class='label label-success'>Approved</span>";
                                    } elseif($c_status == 'disapproved'){
                                        echo "<span class='label label-danger'>Disapproved</span>";
                                    } else {
                                        echo "<span class='label label-warning'>Pending</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if($c_status == 'pending'){ 
                                        // If status is 'pending', show both Approve and Disapprove options
                                    ?>
                                        <a href="index.php?approve_customer=<?php echo $c_id; ?>">
                                            <i class="fa fa-check"></i> Approve
                                        </a>
                                        &nbsp;|&nbsp;
                                        <a href="index.php?disapprove_customer=<?php echo $c_id; ?>">
                                            <i class="fa fa-times"></i> Disapprove
                                        </a>
                                    <?php } elseif($c_status == 'approved'){ ?>
                                        <!-- If status is 'approved', show only Disapprove link -->
                                        <a href="index.php?disapprove_customer=<?php echo $c_id; ?>">
                                            <i class="fa fa-times"></i> Disapprove
                                        </a>
                                    <?php } elseif($c_status == 'disapproved'){ ?>
                                        <!-- If status is 'disapproved', show only Approve link -->
                                        <a href="index.php?approve_customer=<?php echo $c_id; ?>">
                                            <i class="fa fa-check"></i> Approve
                                        </a>
                                    <?php } ?>
                                </td>
                                <td> 
                                     <a href="index.php?delete_customer=<?php echo $c_id; ?>">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a> 
                                </td>
                            </tr><!-- tr finish -->
                             <?php } ?>
                        </tbody><!-- tbody finish -->
                    </table><!-- table table-striped table-bordered table-hover finish -->
                </div><!-- table-responsive finish -->
            </div><!-- panel-body finish -->
        </div><!-- panel panel-default finish -->
    </div><!-- col-lg-12 finish -->
</div><!-- row 2 finish -->

<?php } ?>

<?php
// Handle the approve and disapprove actions
if(isset($_GET['approve_customer'])){
    $approve_id = $_GET['approve_customer'];
    
    // Update status to 'approved'
    $update_status = "UPDATE customers SET status='approved' WHERE customer_id='$approve_id'";
    $run_update_status = mysqli_query($con, $update_status);
    
    // Redirect after action
    if($run_update_status){
        echo "<script>alert('Customer has been approved.');</script>";
        echo "<script>window.open('index.php?view_customer','_self');</script>";
    }
}

if(isset($_GET['disapprove_customer'])){
    $disapprove_id = $_GET['disapprove_customer'];
    
    // Update status to 'disapproved'
    $update_status = "UPDATE customers SET status='disapproved' WHERE customer_id='$disapprove_id'";
    $run_update_status = mysqli_query($con, $update_status);
    
    // Redirect after action
    if($run_update_status){
        echo "<script>alert('Customer has been disapproved.');</script>";
        echo "<script>window.open('index.php?view_customer','_self');</script>";
    }
}
?>
