

<?php 
    
    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>
<?php
// Query for pending customer approvals
$get_pending_approvals = "SELECT * FROM customers WHERE status='pending'";
$run_pending_approvals = mysqli_query($con, $get_pending_approvals);

// Check if the query executed successfully
if (!$run_pending_approvals) {
    die('Query failed: ' . mysqli_error($con));
}

// Query for new orders
$get_new_orders = "SELECT * FROM customer_orders WHERE order_status='pending'";
$run_new_orders = mysqli_query($con, $get_new_orders);

// Check if the query executed successfully
if (!$run_new_orders) {
    die('Query failed: ' . mysqli_error($con));
}

// Get the number of pending approvals and new orders
$pending_approvals = mysqli_num_rows($run_pending_approvals);
$new_orders = mysqli_num_rows($run_new_orders);
$total_notifications = $pending_approvals + $new_orders;
?>
   
<nav class="navbar navbar-inverse navbar-fixed-top"><!-- navbar navbar-inverse navbar-fixed-top begin -->
    <div class="navbar-header"><!-- navbar-header begin -->
        
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><!-- navbar-toggle begin -->
            
            <span class="sr-only">Toggle Navigation</span>
            
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            
        </button><!-- navbar-toggle finish -->
        
        <a href="index.php?dashboard" class="navbar-brand">Admin Area</a>
        
    </div><!-- navbar-header finish -->
    
    <ul class="nav navbar-right top-nav"><!-- nav navbar-right top-nav begin -->
    <li class="dropdown"><!-- dropdown begin -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><!-- dropdown-toggle begin -->
            <i class="fa fa-bell"></i> Notifications
            <?php if ($total_notifications > 0): ?>
                <span class="badge" style="background-color: red;"><?php echo $total_notifications; ?></span>
            <?php endif; ?>
            <b class="caret"></b>
        </a><!-- dropdown-toggle finish -->

        <ul class="dropdown-menu" style="max-width: 300px; max-height: 400px; overflow-y: auto; overflow-x: hidden;"><!-- dropdown-menu begin -->
            <!-- Pending Approvals Section -->
            <li><!-- li begin -->
                <a href="index.php?view_customers"><!-- a href begin -->
                    <i class="fa fa-fw fa-user"></i> Pending Approvals
                    <span class="badge"><?php echo $pending_approvals; ?> </span>
                </a><!-- a href finish -->
                <!-- List Pending Customers -->
                <ul>
                    <?php while ($row = mysqli_fetch_array($run_pending_approvals)): ?>
                        <li>
                            <a href="index.php?view_customers">
                                <?php echo $row['customer_name']; ?> needs approval
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li><!-- li finish -->

            <!-- Pending Orders Section -->
            <li><!-- li begin -->
                <a href="index.php?view_orders"><!-- a href begin -->
                    <i class="fa fa-fw fa-book"></i> Pending Orders
                    <span class="badge"><?php echo mysqli_num_rows($run_new_orders); ?></span>
                </a><!-- a href finish -->
                <!-- List Pending Orders -->
                <ul>
                    <?php while ($order = mysqli_fetch_array($run_new_orders)): ?>
                        <li>
                            <a href="index.php?view_orders">
                                Order ID: <?php echo $order['order_id']; ?> - Invoice No: <?php echo $order['invoice_no']; ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li><!-- li finish -->
        </ul><!-- dropdown-menu finish -->
    </li><!-- dropdown finish -->
</ul><!-- nav navbar-right top-nav finish -->



</ul><!-- dropdown-menu finish -->

        
    </li><!-- dropdown finish -->
</ul><!-- nav navbar-right top-nav finish -->
    
    <div class="collapse navbar-collapse navbar-ex1-collapse"><!-- collapse navbar-collapse navbar-ex1-collapse begin -->
        <ul class="nav navbar-nav side-nav"><!-- nav navbar-nav side-nav begin -->
            <li><!-- li begin -->
                <a href="index.php?dashboard"><!-- a href begin -->
                        
                        <i class="fa fa-fw fa-dashboard"></i> Dashboard
                        
                </a><!-- a href finish -->
                
            </li><!-- li finish -->
            
            <li><!-- li begin -->
                <a href="#" data-toggle="collapse" data-target="#products"><!-- a href begin -->
                        
                        <i class="fa fa-fw fa-tag"></i> Products
                        <i class="fa fa-fw fa-caret-down"></i>
                        
                </a><!-- a href finish -->
                
                <ul id="products" class="collapse"><!-- collapse begin -->
                    <li><!-- li begin -->
                        <a href="index.php?insert_product"> Insert Product </a>
                    </li><!-- li finish -->
                    <li><!-- li begin -->
                        <a href="index.php?view_products"> View Products </a>
                    </li><!-- li finish -->
                </ul><!-- collapse finish -->
                
            </li><!-- li finish -->
            
         <!--    <li> li begin -->
               <!--  <a href="#" data-toggle="collapse" data-target="#cat"> a href begin -->
                        
                       <!--  <i class="fa fa-fw fa-book"></i> Categories
                         <i class="fa fa-fw fa-caret-down"></i>-->
                        
                <!--</a> a href finish -->
                
               <!--  <ul id="cat" class="collapse">collapse begin -->
                  <!--   <li> li begin -->
                  <!--       <a href="index.php?insert_cat"> Insert Category </a>-->
                  <!--   </li> li finish -->
                  <!--   <li> li begin -->
                   <!--      <a href="index.php?view_cats"> View Categories </a>-->
                   <!--  </li> li finish -->
              <!--   </ul> collapse finish -->
                
           <!--  </li> li finish -->
            
            <!-- <li> li begin -->
                <!-- <a href="#" data-toggle="collapse" data-target="#slides"> a href begin -->
                        
                        <!-- i class="fa fa-fw fa-gear"></i> Slides-->
                        <!-- <i class="fa fa-fw fa-caret-down"></i>-->
                        
                <!--</a> a href finish -->
                
              <!-- <ul id="slides" class="collapse"> collapse begin -->
                   <!-- <li> li begin  -->
                       <!-- <a href="index.php?insert_slide"> Insert Slide </a> -->
                   <!-- </li> li finish -->
                   <!-- <li> li begin -->
                       <!-- <a href="index.php?view_slides"> View Slides </a>-->
                    <!--</li> li finish  -->
             <!--    </ul>collapse finish -->
                
          <!--  </li> li finish -->
            
            <li><!-- li begin -->
                <a href="#" data-toggle="collapse" data-target="#boxes"><!-- a href begin -->
                        
                        <i class="fa fa fa-comments-o"></i>  Reviews
                        <i class="fa fa-fw fa-caret-down"></i>
                        
                </a><!-- a href finish -->
                
                <ul id="boxes" class="collapse"><!-- collapse begin -->
                    <li><!-- li begin -->
                        <a href="index.php?view_boxes"> View Reviews </a>
                    </li><!-- li finish -->
                </ul><!-- collapse finish -->
                
            </li><!-- li finish -->
            


            <li>
    <a href="index.php?GIS">
        <i class="fa fa-map-marker"></i> GIS
    </a>
</li>

<li>
    <a href="index.php?process_graph">
        <i class="fas fa-chart-bar"></i> View Sales Report
    </a>
</li>






</li><!-- about us li Ends -->
            
            <li><!-- li begin -->
                <a href="#" data-toggle="collapse" data-target="#terms"><!-- a href begin -->
                        
                        <i class="fa fa-fw fa-table"></i> Terms
                        <i class="fa fa-fw fa-caret-down"></i>
                        
                </a><!-- a href finish -->
                
                <ul id="terms" class="collapse"><!-- collapse begin -->
                    <li><!-- li begin -->
                        <a href="index.php?insert_terms"> Insert Term </a>
                    </li><!-- li finish -->
                    <li><!-- li begin -->
                        <a href="index.php?view_terms"> View Terms </a>
                    </li><!-- li finish -->
                </ul><!-- collapse finish -->
                
            </li><!-- li finish -->
            
          <!--   <li> li begin 
                    <a href="index.php?view_pending_customers">  a href begin 
                         <i class="fa fa-fw fa-check-circle"></i> View Pending Customers
                    </a> a href finish 
                </li> li finish  -->

            
            <li><!-- li begin -->
                <a href="index.php?view_customers"><!-- a href begin -->
                    <i class="fa fa-fw fa-users"></i> View Customers
                </a><!-- a href finish -->
            </li><!-- li finish -->

            <li><!-- li begin -->
                <a href="index.php?view_orders"><!-- a href begin -->
                    <i class="fa fa-fw fa-book"></i> View Orders
                </a><!-- a href finish -->
            </li><!-- li finish -->
            
            <li><!-- li begin -->
                <a href="index.php?view_payments"><!-- a href begin -->
                    <i class="fa fa-fw fa-money"></i> View Payments
                </a><!-- a href finish -->
            </li><!-- li finish -->

          <!-- <li> li begin -->
                <!--<a href="index.php?edit_css"> a href begin -->
                <!--    <i class="fa fa-fw fa-pencil"></i> CSS Editor-->
              <!--  </a> a href finish -->
           <!-- </li> li finish -->
            
            <li><!-- li begin -->
                <a href="#" data-toggle="collapse" data-target="#users"><!-- a href begin -->
                        
                        <i class="fa fa-fw fa-users"></i> Users
                        <i class="fa fa-fw fa-caret-down"></i>
                        
                </a><!-- a href finish -->
                
                <ul id="users" class="collapse"><!-- collapse begin -->
                  <!--  <li> li begin -->
                       <!-- <a href="index.php?insert_user"> Insert User </a>
                    </li> li finish -->
                    <li><!-- li begin -->
                        <a href="index.php?view_users"> View Users </a>
                    </li><!-- li finish -->
                    <li><!-- li begin -->
                        <a href="index.php?user_profile=<?php echo $admin_id; ?>"> Edit User Profile </a>
                    </li><!-- li finish -->
                </ul><!-- collapse finish -->
                
            </li><!-- li finish -->
            
            <li><!-- li begin -->
                <a href="logout.php"><!-- a href begin -->
                    <i class="fa fa-fw fa-power-off"></i> Log Out
                </a><!-- a href finish -->
            </li><!-- li finish -->
            
        </ul><!-- nav navbar-nav side-nav finish -->
    </div><!-- collapse navbar-collapse navbar-ex1-collapse finish -->
    
</nav><!-- navbar navbar-inverse navbar-fixed-top finish -->


<?php } ?>