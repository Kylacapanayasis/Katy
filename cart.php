<?php 

    $active='Cart';
    include("includes/header.php");
    $shipping_fee = 45; // Add the shipping fee variable here
?>
   
   <div id="content"><!-- #content Begin -->
       <div class="container"><!-- container Begin -->
           <div class="invisible"><!-- col-md-12 Begin -->
               
               <ul class="breadcrumb"><!-- breadcrumb Begin -->
                   <li>
                       <a href="index.php">Home</a>
                   </li>
                   <li>
                       Cart
                   </li>
               </ul><!-- breadcrumb Finish -->
               
           </div><!-- col-md-12 Finish -->
           
           <div id="cart" class="col-md-9"><!-- col-md-9 Begin -->
               
               <div class="box"><!-- box Begin -->
                   
                   <form action="cart.php" method="post" enctype="multipart/form-data"><!-- form Begin -->
                       
                       <h1>Shopping Cart</h1>
                       
                       <?php 
                       
                       $c_id = getCustomerDetails();
                       
                       $select_cart = "select * from cart where customer_id='$c_id'";
                       
                       $run_cart = mysqli_query($con,$select_cart);
                       
                       $count = mysqli_num_rows($run_cart);
                       
                       ?>
                       
                       <p class="text-muted">You currently have <?php echo $count; ?> item(s) in your cart</p>
                       
                       <div class="table-responsive"><!-- table-responsive Begin -->
                           
                           <table class="table"><!-- table Begin -->
                               
                               <thead><!-- thead Begin -->
                                   
                                   <tr><!-- tr Begin -->
                                       
                                       <th colspan="2">Product</th>
                                       <th>Quantity</th>
                                      

                                       <th>Roast Type</th>

                                       <th>Coffee Beans</th>
                                       <th>Unit Price</th>
                                       
                                       <th colspan="1">Delete</th>
                                       <th colspan="2">Sub-Total</th>
                                       
                                   </tr><!-- tr Finish -->
                                   
                               </thead><!-- thead Finish -->
                               
                               <tbody><!-- tbody Begin -->
                                  
                                  <?php 
                                   
                                   $total = 0;
                                   
                                   while($row_cart = mysqli_fetch_array($run_cart)){
                                       
                                     $pro_id = $row_cart['p_id'];
                                       
                                     $pro_qty = $row_cart['qty'];

                                           // Make sure this field is 'kilo' in your table if it's missing
                                    $pro_roast = $row_cart['roast'];    // Verify roast type is saved in this column
                                    $pro_coffee = $row_cart['coffee'];  // Ensure coffee beans type is saved correctly
 

                                     $pro_sale = $row_cart['p_price'];
                                       
                                       $get_products = "select * from products where product_id='$pro_id'";
                                       
                                       $run_products = mysqli_query($con,$get_products);
                                       
                                       while($row_products = mysqli_fetch_array($run_products)){
                                           
                                           $product_title = $row_products['product_title'];
                                           
                                           $product_img1 = $row_products['product_img1'];
                                           
                                           $only_price = $row_products['product_price'];
                                           
                                           $pro_url = $row_products['product_url'];
                                           
                                           $sub_total = $pro_sale*$pro_qty;

                                           $_SESSION['pro_qty'] = $pro_qty;
                                           
                                           $total += $sub_total;
                                           
                                   ?>
                                   
                                   <tr><!-- tr Begin -->
                                       
                                       <td>
                                           
                                           <img class="img-responsive" src="admin_area/product_images/<?php echo $product_img1; ?>" alt="Product 3a">
                                           
                                       </td>
                                       
                                       <td>
                                           
                                           <a href="<?php echo $pro_url; ?>"> <?php echo $product_title; ?> </a>
                                           
                                       </td>
                                       
                                       <td>
                                          
                                           <input type="text" name="quantity" data-product_id="<?php echo $pro_id; ?>" value="<?php echo $_SESSION['pro_qty']; ?>" class="quantity form-control">
                                           
                                       </td>

                                       

                                        <td>

                                            <?php echo $pro_roast; ?>

                                        </td>

                                        <td>

                                            <?php echo $pro_coffee; ?>

                                        </td>
                                       
                                       <td>
                                           
                                           <?php echo $pro_sale; ?>
                                           
                                       </td>
                                       <td>
                                           
                                           <input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>">
                                           
                                       </td>
                                       
                                       <td>
                                           
                                       ₱<?php echo $sub_total; ?>
                                           
                                       </td>
                                       
                                   </tr><!-- tr Finish -->
                                   
                                   <?php } } ?>
                                   
                               </tbody><!-- tbody Finish -->
                               
                               <tfoot><!-- tfoot Begin -->
                                   
                                   <tr><!-- tr Begin -->
                                       
                                       <th colspan="5">Total</th>
                                       <th colspan="2">₱<?php echo $total+$shipping_fee; ?></th>
                                       
                                   </tr><!-- tr Finish -->
                                   
                               </tfoot><!-- tfoot Finish -->
                               
                           </table><!-- table Finish -->

                          
                       </div><!-- table-responsive Finish -->
                       
                       <div class="box-footer"><!-- box-footer Begin -->
                           
                           <div class="pull-left"><!-- pull-left Begin -->
                               
                               <a href="index.php" class="btn btn-default"><!-- btn btn-default Begin -->
                                   
                                   <i class="fa fa-chevron-left"></i> Continue Shopping
                                   
                               </a><!-- btn btn-default Finish -->
                               
                           </div><!-- pull-left Finish -->
                           
                           <div class="pull-right"><!-- pull-right Begin -->
                               
                               <button type="submit" name="update" value="Update Cart" class="btn btn-default"><!-- btn btn-default Begin -->
                                   
                                   <i class="fa fa-refresh"></i> Update Cart
                                   
                               </button><!-- btn btn-default Finish -->
                               
                               <a href="checkout.php" class="btn btn-primary">
                                   
                                   Proceed Checkout <i class="fa fa-chevron-right"></i>
                                   
                               </a>
                               
                           </div><!-- pull-right Finish -->
                           
                       </div><!-- box-footer Finish -->
                       
                   </form><!-- form Finish -->
                   
               </div><!-- box Finish -->

              
               
               <?php 
               function update_cart(){
                global $con;
            
                if(isset($_POST['update'])){
                    // Check if there are items to remove
                    if(isset($_POST['remove']) && is_array($_POST['remove'])){
                        foreach($_POST['remove'] as $remove_id){
                            $delete_product = "DELETE FROM cart WHERE p_id='$remove_id' AND customer_id='".getCustomerDetails()."'";
                            $run_delete = mysqli_query($con,$delete_product);
                        }
                    }
                    echo "<script>window.open('cart.php','_self')</script>"; // Reload the cart page after updating
                }
            }
            
               
               echo @$up_cart = update_cart();
               
               ?>
               
               <div id="row same-heigh-row"><!-- #row same-heigh-row Begin -->
                   <div class="col-md-3 col-sm-6"><!-- col-md-3 col-sm-6 Begin -->
                       <div class="box same-height headline"><!-- box same-height headline Begin -->
                           <h3 class="text-center">Products You Maybe Like</h3>
                       </div><!-- box same-height headline Finish -->
                   </div><!-- col-md-3 col-sm-6 Finish -->
                   
                   <?php 
                   
                   $get_products = "select * from products order by rand() LIMIT 0,3";
                   
                   $run_products = mysqli_query($con,$get_products);
                   
                   while($row_products=mysqli_fetch_array($run_products)){
                       
                    $pro_id = $row_products['product_id'];
        
                    $pro_title = $row_products['product_title'];
                    
                    $pro_price = $row_products['product_price'];
            
                    $pro_sale_price = $row_products['product_sale'];

                    $pro_url = $row_products['product_url'];
                    
                    $pro_img1 = $row_products['product_img1'];
                    
                    $pro_label = $row_products['product_label'];
                    
                   
            
                    if($pro_label == "sale"){
            
                        $product_price = " <del> ₱ $pro_price </del> ";
            
                        $product_sale_price = "/ ₱ $pro_sale_price ";
            
                    }else{
            
                        $product_price = "  ₱ $pro_price  ";
            
                        $product_sale_price = "";
            
                    }
            
                    if($pro_label == ""){
            
                    }else{
            
                        $product_label = "
                        
                            <a href='#' class='label $pro_label'>
                            
                                <div class='theLabel'> $pro_label </div>
                                <div class='labelBackground'>  </div>
                            
                            </a>
                        
                        ";
            
                    }
                    
                    echo "
                    
                    <div class='col-md-3 col-sm-6 center-responsive'>
                    
                        <div class='product'>
                        
                            <a href='$pro_url'>
                            
                                <img class='img-responsive' src='admin_area/product_images/$pro_img1'>
                            
                            </a>
                            
                            <div class='text'>
            
                        
                            
                                <h3>
                        
                                    <a href='$pro_url'>
            
                                        $pro_title
            
                                    </a>
                                
                                </h3>
                                
                                <p class='price'>
                                
                                $product_price &nbsp;$product_sale_price
                                
                                </p>
                                
                                <p class='button'>
                                
                                    <a class='btn btn-default' href='$pro_url'>
            
                                        View Details
            
                                    </a>
                                
                                    <a class='btn btn-primary' href='$pro_url'>
            
                                        <i class='fa fa-shopping-cart'></i> Add to Cart
            
                                    </a>
                                
                                </p>
                            
                            </div>
            
                            $product_label
                        
                        </div>
                    
                    </div>
                    
                    ";
                       
                   }
                   
                   ?>
                   
               </div><!-- #row same-heigh-row Finish -->
               
           </div><!-- col-md-9 Finish -->
           
           <div class="col-md-3"><!-- col-md-3 Begin -->
               
           <div id="order-summary" class="box">
    <div class="box-header">
        <h3>Order Summary</h3>
    </div>
    <p class="text-muted">
        Shipping and additional costs are calculated based on value you have entered
    </p>
    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td>Order All Sub-Total</td>
                    <th>₱<?php echo $total; ?></th> <!-- The current subtotal -->
                </tr>
                <tr>
                    <td>Shipping and Handling</td>
                    <td>₱<?php echo $shipping_fee; ?></td> <!-- Add this line for shipping -->
                </tr>
                <tr class="total">
                    <td>Total</td>
                    <th>₱<?php echo $total + $shipping_fee; ?></th> <!-- Adjust total to include shipping -->
                </tr>
            </tbody>
        </table>
    </div>
</div>

           
       </div><!-- container Finish -->
   </div><!-- #content Finish -->
   
   <?php 
    
    include("includes/footer.php");
    
    ?>
    
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>

    <script>
    
       $(document).ready(function(data){

           $(document).on('keyup','.quantity',function(){

                var id = $ (this).data("product_id");
                var quantity = $(this).val();

                if(quantity !=''){

                    $.ajax({

                        url: "change.php",
                        method: "POST",
                        data:{id:id, quantity:quantity},

                        success:function(){
                            $("body").load("cart_body.php");
                        }

                    });

                }

           });

       });
    
    </script>
    
    
</body>
</html>