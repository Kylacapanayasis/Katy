<?php 

$active = 'Account';
include("includes/header.php");

?>

<div id="content"><!-- #content Begin -->
    <div class="container"><!-- container Begin -->
        <div class="col-md-12"><!-- col-md-12 Begin -->
            

            
        </div><!-- col-md-12 Finish -->
        
        <div class="col-md-12"><!-- col-md-12 Begin -->
        
            <?php 
            
            if(!isset($_SESSION['customer_email'])){
                include("customer/customer_login.php");
            } else {
                
                // Check if "Buy Now" session item exists
                if(isset($_SESSION['buy_now_item'])){
                    // "Buy Now" mode for a single item checkout
                    include("payment_options.php");
                } else {
                    // Standard cart checkout
                    include("payment_options.php");
                }
                
            }
            
            ?>
        
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
