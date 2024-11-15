<?php  

session_start();

$active='Cart';

include("includes/db.php");
include("functions/functions.php");

?>

<?php 
    
    $product_id = $_GET['pro_id'];
    
    $get_product = "select * from products where product_url='$product_id'";
    
    $run_product = mysqli_query($con,$get_product);

    $check_product = mysqli_num_rows($run_product);

    if($check_product == 0){

        echo "<script>window.open('index.php','_self')</script>";

    }else{
    
    $row_products = mysqli_fetch_array($run_product);
    
    $p_cat_id = $row_products['p_cat_id'];
    
    $pro_title = $row_products['product_title'];
    
    $pro_price = $row_products['product_price'];

    $pro_sale_price = $row_products['product_sale'];
    
    $pro_desc = $row_products['product_desc'];
        
    $pro_features = $row_products['product_quan'];
        
    $pro_video = $row_products['product_status'];
    
    $pro_img1 = $row_products['product_img1'];
    
    $pro_img2 = $row_products['product_img2'];
    
    $pro_img3 = $row_products['product_img3'];
        
    $pro_label = $row_products['product_label'];

    if($pro_label == ""){

    }else{

        $product_label = "
        
            <a href='#' class='label $pro_label'>
            
                <div class='theLabel'> $pro_label </div>
                <div class='labelBackground'>  </div>
            
            </a>
        
        ";

    }
    
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katy's Coffee Farm</title>
    <link rel="stylesheet" href="styles/bootstrap-337.min.css">
    <link rel="stylesheet" href="font-awsome/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div id="top"><!-- Top Begin -->
       
       <div class="container"><!-- container Begin -->
           
           <div class="col-md-6 offer"><!-- col-md-6 offer Begin -->
           
               
               <a href="#" class="btn btn-success btn-sm">
                   
                   <?php 
                   
                   if(!isset($_SESSION['customer_email'])){
                       
                       echo "Welcome: Guest";
                       
                   }else{
                       
                       echo "Welcome: " . $_SESSION['customer_email'] . "";
                       
                   }
                   
                   ?>
                   
               </a>
               <a href="../cart.php"> <?php items(); ?> Items In Your Cart | Total Price: <?php total_price(); ?> </a>
               
           </div><!-- col-md-6 offer Finish -->
           
           <div class="col-md-6"><!-- col-md-6 Begin -->
               
               <ul class="menu"><!-- cmenu Begin -->
               <li><a href="./rate.php"><i class="fa fa-heart" aria-hidden="true"></i> Rate us!</a></li>
                <li>

                       <a href="checkout.php">
                           
                           <?php 
                           
                           if(!isset($_SESSION['customer_email'])){
                       
                                echo "<a href='checkout.php'> Login </a>";

                               }else{

                                echo " <a href='customer/my_account.php?logout'> Log Out </a> ";

                               }
                           
                           ?>
                           
                       </a>
                   </li>
                   
               </ul><!-- menu Finish -->
               
           </div><!-- col-md-6 Finish -->
           
       </div><!-- container Finish -->
       
   </div><!-- Top Finish -->
   
   <div id="navbar" class="navbar navbar-default"><!-- navbar navbar-default Begin -->
       
       <div class="container"><!-- container Begin -->
           
           <div class="navbar-header"><!-- navbar-header Begin -->
               
               <a href="index.php" class="navbar-brand home"><!-- navbar-brand home Begin -->
                   
               <img src="images/logo.jpg" style="width: 60px; height: 60px;" alt="Store Logo" class="hidden-xs">
                   <img src="images/ecom-store-logo-mobile.png" alt="M-dev-Store Logo Mobile" class="visible-xs">
                   
               </a><!-- navbar-brand home Finish -->
               
               
           </div><!-- navbar-header Finish -->
           
           <div class="navbar-collapse collapse" id="navigation"><!-- navbar-collapse collapse Begin -->
               
               <div class="padding-nav"><!-- padding-nav Begin -->
                   
                   <ul class="nav navbar-nav left"><!-- nav navbar-nav left Begin -->
                       
                   <li>
                           <a href="./index.php">Home</a>
                       </li>
                       <li>
                           <a href="./shop.php">Shop</a>
                       </li>
                       <li class="active">
                           <a href="my_account.php?my_orders">My Account</a>
                       </li>
                       <li>
                           <a href="./cart.php">Shopping Cart</a>
                       </li>
                       <li>
                           <a href="./contact.php">Contact Us</a>
                       </li>
                       
                       <li class="<?php if($active=='Contact') echo"active"; ?>">
                           <a href="about_us.php">About Us</a>
                       </li>

                       <!--<li class="<?php if($active=='Cart') echo"active"; ?>">
                           <a href="cart.php">Shopping Cart</a>
                       </li> -->
                       
                   </ul><!-- nav navbar-nav left Finish -->
                   
               </div><!-- padding-nav Finish -->
               
               <a href="cart.php" class="btn navbar-btn btn-primary right"><!-- btn navbar-btn btn-primary Begin -->
                   
                   <i class="fa fa-shopping-cart"></i>
                   
                   <span><?php items(); ?> Items In Your Cart</span>
                   
               </a><!-- btn navbar-btn btn-primary Finish -->
               
              <!--  <div class="navbar-collapse collapse right"> navbar-collapse collapse right Begin -->
                   
                  <!--  <button class="btn btn-primary navbar-btn" type="button" data-toggle="collapse" data-target="#search"> btn btn-primary navbar-btn Begin -->
                       
                     <!--   <span class="sr-only">Toggle Search</span>-->
                       
                     <!--   <i class="fa fa-search"></i>-->
                       
                  <!--  </button> btn btn-primary navbar-btn Finish -->
                   
               </div><!-- navbar-collapse collapse right Finish -->
               
               <div class="collapse clearfix" id="search"><!-- collapse clearfix Begin -->
                   
                   <form method="get" action="results.php" class="navbar-form"><!-- navbar-form Begin -->
                       
                       <div class="input-group"><!-- input-group Begin -->
                           
                           <input type="text" class="form-control" placeholder="Search" name="user_query" required>
                           
                           <span class="input-group-btn"><!-- input-group-btn Begin -->
                           
                           <button type="submit" name="search" value="Search" class="btn btn-primary"><!-- btn btn-primary Begin -->
                               
                               <i class="fa fa-search"></i>
                               
                           </button><!-- btn btn-primary Finish -->
                           
                           </span><!-- input-group-btn Finish -->
                           
                       </div><!-- input-group Finish -->
                       
                   </form><!-- navbar-form Finish -->
                   
               </div><!-- collapse clearfix Finish -->
               
           </div><!-- navbar-collapse collapse Finish -->
           
       </div><!-- container Finish -->
       
   </div><!-- navbar navbar-default Finish -->
   
   <div id="content"><!-- #content Begin -->
       <div class="container"><!-- container Begin -->
           <div class="col-md-12"style="visibility: hidden;"><!-- col-md-12 Begin -->
               
               <ul class="breadcrumb"><!-- breadcrumb Begin -->
                   <li>
                       <a href="index.php">Home</a>
                   </li>
                   <li>
                       Shop
                   </li>
                   
                   
                   <li> <?php echo $pro_title; ?> </li>
               </ul><!-- breadcrumb Finish -->
               
           </div><!-- col-md-12 Finish -->
           
           <div class="col-md-12"><!-- col-md-12 Begin -->
               <div id="productMain" class="row"><!-- row Begin -->
                   <div class="col-sm-6"><!-- col-sm-6 Begin -->
                       <div id="mainImage"><!-- #mainImage Begin -->
                           <div id="myCarousel" class="carousel slide" data-ride="carousel"><!-- carousel slide Begin -->
                               <ol class="carousel-indicators"><!-- carousel-indicators Begin -->
                                   <li data-target="#myCarousel" data-slide-to="0" class="active" ></li>
                                   <li data-target="#myCarousel" data-slide-to="1"></li>
                                   <li data-target="#myCarousel" data-slide-to="2"></li>
                               </ol><!-- carousel-indicators Finish -->
                               
                               <div class="carousel-inner">
                                   <div class="item active">
                                       <center><img class="img-responsive" src="admin_area/product_images/<?php echo $pro_img1; ?>" alt="Product 3-a"></center>
                                   </div>
                                   <div class="item">
                                       <center><img class="img-responsive" src="admin_area/product_images/<?php echo $pro_img2; ?>" alt="Product 3-b"></center>
                                   </div>
                                   <div class="item">
                                       <center><img class="img-responsive" src="admin_area/product_images/<?php echo $pro_img3; ?>" alt="Product 3-c"></center>
                                   </div>
                               </div>
                               
                               <a href="#myCarousel" class="left carousel-control" data-slide="prev"><!-- left carousel-control Begin -->
                                   <span class="glyphicon glyphicon-chevron-left"></span>
                                   <span class="sr-only">Previous</span>
                               </a><!-- left carousel-control Finish -->
                               
                               <a href="#myCarousel" class="right carousel-control" data-slide="next"><!-- right carousel-control Begin -->
                                   <span class="glyphicon glyphicon-chevron-right"></span>
                                   <span class="sr-only">Next</span>
                               </a><!-- right carousel-control Finish -->
                               
                           </div><!-- carousel slide Finish -->
                       </div><!-- mainImage Finish -->

                           <?php echo $product_label; ?>

                   </div><!-- col-sm-6 Finish -->
                   
                   <?php 
// Assuming $pro_price, $pro_sale_price, and $pro_label are already defined as per the previous code
$shipping_fee = 45;  // Define the shipping fee

// Default values for total calculation
$product_qty = 1;  // Default quantity if nothing is submitted
$total = 0;  // Total price, will be calculated below

if (isset($_POST['product_qty'])) {
    $product_qty = $_POST['product_qty'];  // Get the product quantity from the form
}

// Calculate the total based on whether the product is on sale
if ($pro_label == "sale") {
    $total = ($product_qty * $pro_sale_price) + $shipping_fee;
    $product_price_display = "<del> ₱$pro_price</del><br/>SALE: ₱$pro_sale_price";
} else {
    $total = ($product_qty * $pro_price) + $shipping_fee;
    $product_price_display = "PRICE: ₱$pro_price/kg";
}

// Assuming getCustomerDetails function fetches customer ID
$c_id = getCustomerDetails();  // This should be the customer ID stored in session or somewhere

// Query to get the customer's address from the customer_address column
$query = "SELECT customer_address FROM customers WHERE customer_id = '$c_id'";
$result = mysqli_query($con, $query);

// Check if the query ran successfully
if (!$result) {
    echo "Error: " . mysqli_error($con);
    exit();  // Exit if the query fails
}

$row = mysqli_fetch_array($result);

// Check if address is fetched
if (!$row) {
    echo "No address found for this customer.";
    $existing_address = '';  // If no address, set it to empty
} else {
    $existing_address = $row['customer_address'];  // Store the address
}
?>

<div class="col-sm-6"><!-- col-sm-6 Begin -->
    <div class="box"><!-- box Begin -->
        <h1 class="text-center"> <?php echo $pro_title; ?> </h1>
        
        <form class="form-horizontal" method="post">
            <!-- Quantity Input -->
            <div class="form-group">
                <label for="" class="col-md-5 control-label">Products Quantity</label>
                <div class="col-md-7">
                    <input id="product_qty" name="product_qty" type="number" class="form-control" placeholder="Enter quantity" value="1" required>
                </div>
            </div>
            
            <!-- Roast Type Input -->
            <div class="form-group">
                <label class="col-md-5 control-label">Roast Type</label>
                <div class="col-md-7">
                    <select name="roast" class="form-control" required>
                        <option value="">Select a Roast</option>
                        <option value="Regular">Regular</option>
                        <option value="Medium roast">Medium roast</option>
                    </select>
                </div>
            </div>

            <!-- Coffee Beans Input -->
            <div class="form-group">
                <label class="col-md-5 control-label">Coffee Beans</label>
                <div class="col-md-7">
                    <select name="coffee" class="form-control" required>
                        <option value="">Select Coffee Beans</option>
                        <option value="Whole Beans">Whole Beans</option>
                        <option value="Fine Grind">Fine Grind</option>
                        <option value="Medium Grind">Medium Grind</option>
                    </select>
                </div>
            </div>

            <!-- Address Input (Pre-filled if exists) -->
            <div class="form-group">
                <label for="address" class="col-md-5 control-label">Shipping Address</label>
                <div class="col-md-7">
                    <!-- Show existing address if available -->
                    <textarea name="address" class="form-control" rows="4"><?php echo htmlspecialchars($existing_address); ?></textarea>
                </div>
            </div>

<!-- Price and Total Calculation -->
<div class="form-group">
    <label class="col-md-5 control-label" style="font-size: 16px;">Product Price</label>
    <div class="col-md-7">
        <p class="price" id="product_price_display" style="font-size: 18px; text-align: left;"><?php echo $product_price_display; ?></p>
    </div>
</div>

<div class="form-group">
    <label class="col-md-5 control-label" style="font-size: 16px;">Shipping Fee</label>
    <div class="col-md-7">
        <p class="price" id="shipping_fee" style="font-size: 18px; text-align: left;">₱ <?php echo $shipping_fee; ?></p>
    </div>
</div>

<div class="form-group">
    <label class="col-md-5 control-label" style="font-size: 16px;">Total</label>
    <div class="col-md-7">
        <p class="price" id="total_price" style="font-size: 18px; text-align: left;">₱ <?php echo number_format($total, 2); ?></p>
    </div>
</div>


            <!-- Action Buttons -->
            <p class="text-center buttons">
                <button type="submit" name="add_cart" class="btn btn-primary i fa fa-shopping-cart" onclick="return confirmAddToCart();"> Add to cart</button>
                <button type="submit" name="buy_now" class="btn btn-success i fa fa-credit-card" onclick="return confirmBuyNow();"> Buy Now</button>
                <button type="submit" name="buy_now_with_gcass" class="btn btn-warning i fa fa-mobile" onclick="return confirmBuyNowWithGCash();"> Buy Now with GCash</button>
            </p>
        </form><!-- form Finish -->
    </div><!-- box Finish -->
</div><!-- col-sm-6 Finish -->

<script>
function confirmAddToCart() {
    return confirm("Are you sure you want to add this item to your cart?");
}

function confirmBuyNow() {
    return confirm("Are you sure you want to buy this item now?");
}

function confirmBuyNowWithGCash() {
    return confirm("Are you sure you want to buy this item with GCash?");
}

// Function to update the total dynamically
function updateTotal() {
    var productQty = document.getElementById('product_qty').value;  // Get the quantity
    var productPrice = <?php echo $pro_label == "sale" ? $pro_sale_price : $pro_price; ?>;  // Use sale price or regular price
    var shippingFee = <?php echo $shipping_fee; ?>;  // Shipping fee

    // Calculate the total
    var total = (productQty * productPrice) + shippingFee;

    // Update the total price on the page
    document.getElementById('total_price').textContent = '₱ ' + total.toFixed(2);
}

// Event listener for quantity input change
document.getElementById('product_qty').addEventListener('input', updateTotal);

// Initial total update on page load
updateTotal();
</script>



<?php
if ($customer_email = $_SESSION['customer_email']) {
    // Existing Add to Cart functionality
    if (isset($_POST['add_cart'])) {
        $c_id = getCustomerDetails();
        $p_id = $row_products['product_id'];
        $product_qty = $_POST['product_qty'];
        $pro_roast = $_POST['roast'];
        $pro_coffee = $_POST['coffee'];
        
        // Get product price from the database
        $get_price = "SELECT * FROM products WHERE product_id='$p_id'";
        $run_price = mysqli_query($con, $get_price);
        $row_price = mysqli_fetch_array($run_price);

        $pro_price = $row_price['product_price'];
        $pro_sale = $row_price['product_sale'];
        $pro_label = $row_price['product_label'];

        // Determine the product price based on sale label
        $product_price = ($pro_label == "sale") ? $pro_sale : $pro_price;

        // Calculate the total price
        $total = $product_qty * $product_price;

        // Check for existing product in cart
        $check_product = "SELECT * FROM cart WHERE customer_id='$c_id' AND p_id='$p_id'";
        $run_check = mysqli_query($con, $check_product);

        // Insert into cart
        $query = "INSERT INTO cart (p_id, customer_id, qty, roast, coffee, p_price, total) 
                  VALUES ('$p_id', '$c_id', '$product_qty', '$pro_roast', '$pro_coffee', '$product_price', '$total')";
        $run_query = mysqli_query($con, $query);
        
        echo "<script>window.open('cart.php','_self')</script>";
    }

// Buy Now functionality
if (isset($_POST['buy_now'])) {
    $c_id = getCustomerDetails();
    $p_id = $row_products['product_id'];
    $product_qty = $_POST['product_qty'];
    $pro_roast = $_POST['roast'];
    $pro_coffee = $_POST['coffee'];

    // Get product price
    $get_price = "SELECT * FROM products WHERE product_id='$p_id'";
    $run_price = mysqli_query($con, $get_price);
    $row_price = mysqli_fetch_array($run_price);

    $pro_price = $row_price['product_price'];
    $pro_sale = $row_price['product_sale'];
    $pro_label = $row_price['product_label'];

    // Define shipping fee
    $shipping_fee = 45;

    // Determine the product price
    $product_price = ($pro_label == "sale") ? $pro_sale : $pro_price;

    // Calculate the due amount (product price * quantity + shipping fee)
    $due_amount = ($product_qty * $product_price) + $shipping_fee;

    // Generate a random invoice number
    do {
        $invoice_no = mt_rand();
        $check_invoice = "SELECT * FROM customer_orders WHERE invoice_no='$invoice_no'";
        $result = mysqli_query($con, $check_invoice);
    } while (mysqli_num_rows($result) > 0); // Regenerate if the invoice number exists

    // Define the order status and payment method
    $order_status = "pending";
    $payment_method = "Cash on Delivery"; // Default payment method for Buy Now

    // Insert into customer_orders table
    $query = "INSERT INTO customer_orders (product_id, customer_id, due_amount, invoice_no, qty, roast, coffee, order_date, order_status, payment_method) 
              VALUES ('$p_id', '$c_id', '$due_amount', '$invoice_no', '$product_qty', '$pro_roast', '$pro_coffee', NOW(), '$order_status', '$payment_method')";

    $run_query = mysqli_query($con, $query);

    if ($run_query) {
        echo "<script>alert('Order placed successfully!');</script>";
        // Redirect to order summary page with the invoice number
        echo "<script>window.open('order_summary.php?invoice_no=$invoice_no','_self');</script>";
    } else {
        echo "<script>alert('Error placing order, please try again.');</script>";
        echo "<script>window.open('checkout.php','_self');</script>";
    }
}

    // Buy Now with GCash functionality
    if (isset($_POST['buy_now_with_gcass'])) {
        $c_id = getCustomerDetails();
        $p_id = $row_products['product_id'];
        $product_qty = $_POST['product_qty'];
        $pro_roast = $_POST['roast'];
        $pro_coffee = $_POST['coffee'];

        // Get product price
        $get_price = "SELECT * FROM products WHERE product_id='$p_id'";
        $run_price = mysqli_query($con, $get_price);
        $row_price = mysqli_fetch_array($run_price);

        $pro_price = $row_price['product_price'];
        $pro_sale = $row_price['product_sale'];
        $pro_label = $row_price['product_label'];

        // Determine the product price
        $product_price = ($pro_label == "sale") ? $pro_sale : $pro_price;

        // Calculate the due amount
        $due_amount = ($product_qty * $product_price) + $shipping_fee;

        // Generate a random invoice number
        do {
            $invoice_no = mt_rand();
            $check_invoice = "SELECT * FROM customer_orders WHERE invoice_no='$invoice_no'";
            $result = mysqli_query($con, $check_invoice);
        } while (mysqli_num_rows($result) > 0); // Regenerate if the invoice number exists

        // Define the order status
        $order_status = "pending";

        // Insert into customer_orders
        $insert_customer_order = "INSERT INTO customer_orders 
            (product_id, customer_id, due_amount, invoice_no, qty, roast, coffee, order_date, order_status, payment_method) 
            VALUES ('$p_id', '$c_id', '$due_amount', '$invoice_no', '$product_qty', '$pro_roast', '$pro_coffee', NOW(), '$order_status', 'online')";
        $run_customer_order = mysqli_query($con, $insert_customer_order);

        // Redirect to GCash page with parameters
        echo "<script>
            window.open('BNgcash.php?invoice_no=$invoice_no&customer_id=$c_id&product_id=$p_id&due_amount=$due_amount&product_qty=$product_qty&roast=$pro_roast&coffee=$pro_coffee','_self');
        </script>";
    }

    } else {
        echo "<script>window.open('checkout.php','_self');</script>";
    }
    ?>




                           
                       </div><!-- box Finish -->
                       
                       <div class="row" id="thumbs"><!-- row Begin -->
                           
                           <div class="col-xs-4"><!-- col-xs-4 Begin -->
                               <a data-target="#myCarousel" data-slide-to="0"  href="#" class="thumb"><!-- thumb Begin -->
                                   <img src="admin_area/product_images/<?php echo $pro_img1; ?>" alt="product 1" class="img-responsive">
                               </a><!-- thumb Finish -->
                           </div><!-- col-xs-4 Finish -->
                           
                           <div class="col-xs-4"><!-- col-xs-4 Begin -->
                               <a data-target="#myCarousel" data-slide-to="1"  href="#" class="thumb"><!-- thumb Begin -->
                                   <img src="admin_area/product_images/<?php echo $pro_img2; ?>" alt="product 2" class="img-responsive">
                               </a><!-- thumb Finish -->
                           </div><!-- col-xs-4 Finish -->
                           
                           <div class="col-xs-4"><!-- col-xs-4 Begin -->
                               <a data-target="#myCarousel" data-slide-to="2"  href="#" class="thumb"><!-- thumb Begin -->
                                   <img src="admin_area/product_images/<?php echo $pro_img3; ?>" alt="product 3" class="img-responsive">
                               </a><!-- thumb Finish -->
                           </div><!-- col-xs-4 Finish -->
                           
                       </div><!-- row Finish -->
                       
                   </div><!-- col-sm-6 Finish -->
                   
                   
               </div><!-- row Finish -->
               
               <div class="box" id="details"><!-- box Begin -->
                    <!-- Tab Buttons Start -->
                    <a data-toggle="tab" href="#descriptions" class="btn btn-primary tab">
                    
                        Product Descriptions
                    
                    </a>
                    <a data-toggle="tab" href="#features" class="btn btn-primary tab">
                    
                        Product Quantity
                    
                    </a>
                    <a data-toggle="tab" href="#videos" class="btn btn-primary tab">
                    
                        Product Stocks
                    
                    </a>   
                    <!-- Tab Buttons End -->

                    <hr style="margin-top:25px;">

                    <!-- Tab Contents Start -->

                    <div class="tab-content">

                        <div class="tab-pane fade in active" id="descriptions"> <!-- Tab-pane Start -->
                        
                            <p class="product_descriptions">
                            
                                <?php echo $pro_desc; ?>
                            
                            </p>
                        
                        </div> <!-- Tab-pane End -->

                        <div class="tab-pane fade in" id="features"> <!-- Tab-pane Start -->

                            <p class="product_features">
                            
                                <?php echo $pro_features; ?>
                            
                            </p>

                        </div> <!-- Tab-pane End -->

                        <div class="tab-pane fade in" id="videos"> <!-- Tab-pane Start -->

                            <p class="product_statuss">
                            
                                <?php echo $pro_video; ?>
                            
                            </p>

                        </div> <!-- Tab-pane End -->

                    </div>

                    <!-- Tab Contents End -->

               </div><!-- box Finish -->
               
                   
                   
           <?php 
           
           $get_boxes = "select * from review_section";
           $run_boxes = mysqli_query($con,$get_boxes);

           while($run_boxes_section=mysqli_fetch_array($run_boxes)){

            $box_id = $run_boxes_section['review_id'];
            $box_name = $run_boxes_section['name'];
            $box_title = $run_boxes_section['comment'];
            $box_desc = $run_boxes_section['rating'];
           
           ?>
               
               <div class="col-sm-4"><!-- col-sm-4 Begin -->
    <div class="box same-height"><!-- box same-height Begin -->
        <div class="icon"><!-- icon Begin -->
            <i class="fa fa-heart"></i>
        </div><!-- icon Finish -->
        <p><?php echo $box_name; ?></p>
        <h3><a href="#"><?php echo $box_title; ?></a></h3>
        <p>
            <?php
            // Convert rating to star icons
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $box_desc) {
                    echo '<i class="fa fa-star"></i>';
                } else {
                    echo '<i class="fa fa-star-o"></i>';
                }
            }
            ?>
        </p>
    </div><!-- box same-height Finish -->
</div><!-- col-sm-4 Finish -->

            <?php    } ?>
               
           </div><!-- same-height-row Finish -->
           
       </div><!-- container Finish -->
       
   </div><!-- #advantages Finish -->
               
           </div><!-- col-md-12 Finish -->
           
       </div><!-- container Finish -->
   </div><!-- #content Finish -->
   
   <?php 
    
    include("includes/footer.php");
    
    ?>
    
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>
    
    
</body>
</html>
<?php } ?>