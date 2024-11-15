<?php 

    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>

<?php 

    if(isset($_GET['edit_product'])){
        
        $edit_id = $_GET['edit_product'];
        
        $get_p = "select * from products where product_id='$edit_id'";
        
        $run_edit = mysqli_query($con,$get_p);
        
        $row_edit = mysqli_fetch_array($run_edit);
        
        $p_id = $row_edit['product_id'];
        
        $p_title = $row_edit['product_title'];
        
        $p_url = $row_edit['product_url'];
        
        $p_cat = $row_edit['p_cat_id'];
        
        $cat = $row_edit['cat_id'];

        $m_id = $row_edit['manufacturer_id'];

        $date = $row_edit['expiry_date'];
        
        $p_image1 = $row_edit['product_img1'];
        
        $p_image2 = $row_edit['product_img2'];
        
        $p_image3 = $row_edit['product_img3'];
        
        $p_price = $row_edit['product_price'];
        
        $p_sale = $row_edit['product_sale'];
        
        $p_keywords = $row_edit['product_keywords'];
        
        $p_desc = $row_edit['product_desc'];
        
        $p_label = $row_edit['product_label'];

        $p_features = $row_edit['product_quan'];

        $p_video = $row_edit['product_status'];
        
    }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Insert Products </title>
</head>
<body>
    
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Edit Products
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Product
                </h3>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                    
                    <!-- Product Title and URL -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Title</label>
                        <div class="col-md-6">
                            <input name="product_title" type="text" class="form-control" required value="<?php echo $p_title; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Url</label>
                        <div class="col-md-6">
                            <input name="product_url" type="text" class="form-control" required value="<?php echo $p_url; ?>">
                            <br>
                            <p style="font-weight:bold;font-style:italic;font-size:16px;">Use Dash '-' for url. | Example: jacket-for-kids</p>
                        </div>
                    </div>

                   
                        <div class="form-group">
                            <label class="col-md-3 control-label">Expiry Date</label>
                            <div class="col-md-6">
                                <input name="expiry_date" type="text" class="form-control" value="<?php echo $date; ?>">
                            </div>
                        </div>
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Product Classification </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <select name="product_cat" class="form-control"><!-- form-control Begin -->

                              <option disabled value="Select Product Category">Select Product Classification</option>       
                              
                              <!-- <option value="<?php echo $p_cat; ?>"> <?php echo $p_cat_title; ?> </option> -->
                              
                              <?php 
                              
                              $get_p_cats = "select * from product_classifications";
                              $run_p_cats = mysqli_query($con,$get_p_cats);
                              
                              while ($row_p_cats=mysqli_fetch_array($run_p_cats)){
                                  
                                  $p_cat_id = $row_p_cats['p_cat_id'];
                                  $p_cat_title = $row_p_cats['p_cat_title'];
                                  
                                  echo "
                                  
                                  <option value='$p_cat_id'> $p_cat_title </option>
                                  
                                  ";
                                  
                              }
                              
                              ?>
                              
                          </select><!-- form-control Finish -->
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Category </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <select name="cat" class="form-control"><!-- form-control Begin -->

                              <option disabled value="Select Category">Select Category</option>
                              
                              <!-- <option value="<?php echo $cat; ?>"> <?php echo $cat_title; ?> </option> -->
                              
                              <?php 
                              
                              $get_cat = "select * from categories";
                              $run_cat = mysqli_query($con,$get_cat);
                              
                              while ($row_cat=mysqli_fetch_array($run_cat)){
                                  
                                  $cat_id = $row_cat['cat_id'];
                                  $cat_title = $row_cat['cat_title'];
                                  
                                  echo "
                                  
                                  <option value='$cat_id'> $cat_title </option>
                                  
                                  ";
                                  
                              }
                              
                              ?>
                              
                          </select><!-- form-control Finish -->
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Product Image 1 </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <input name="product_img1" type="file" class="form-control">
                          
                          <br>
                          
                          <img width="70" height="70" src="product_images/<?php echo $p_image1; ?>" alt="<?php echo $p_image1; ?>">
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Product Image 2 </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <input name="product_img2" type="file" class="form-control">
                          
                          <br>
                          
                          <img width="70" height="70" src="product_images/<?php echo $p_image2; ?>" alt="<?php echo $p_image2; ?>">
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Product Image 3 </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <input name="product_img3" type="file" class="form-control form-height-custom">
                          
                          <br>
                          
                          <img width="70" height="70" src="product_images/<?php echo $p_image3; ?>" alt="<?php echo $p_image3; ?>">
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                        <label class="col-md-3 control-label"> Product Price </label> 
                      
                            <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                                <input name="product_price" type="text" class="form-control" required value="<?php echo $p_price; ?>">
                          
                            </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Sale Price </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <input name="product_sale" type="text" class="form-control" required value="<?php echo $p_sale; ?>">
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"> Product Keywords </label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <input name="product_keywords" type="text" class="form-control" required value="<?php echo $p_keywords; ?>">
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
                   <div class="form-group">
    <label class="col-md-3 control-label"> Product Descriptions </label>
    <div class="col-md-6">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#descriptions" class="tab_link">
                    Product Descriptions
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="descriptions">
                <textarea name="product_desc" id="desc_editor" class="form-control">
                    <?php echo $p_desc; ?>
                </textarea>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label"> Product Quantity </label>
    <div class="col-md-6">
        <input name="product_quan" type="text" class="form-control" required value="0">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label"> Product Stocks </label>
    <div class="col-md-6">
        <input name="product_status" type="text" class="form-control" style="horizontal-align: top;" required value="<?php echo $p_video; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label"> Product Label </label>
    <div class="col-md-6">
        <select name="product_label">
            <option disabled>Select Label Product</option>
            <option value="<?php echo $p_label; ?>"><?php echo $p_label; ?></option>
            <option value="sale">Sale</option>
        </select>
    </div>
</div>

                   
                   <div class="form-group"><!-- form-group Begin -->
                       
                      <label class="col-md-3 control-label"></label> 
                      
                      <div class="col-md-6"><!-- col-md-6 Begin -->
                          
                          <input name="update" value="Update Product" type="submit" class="btn btn-primary form-control">
                          
                      </div><!-- col-md-6 Finish -->
                       
                   </div><!-- form-group Finish -->
                   
               </form><!-- form-horizontal Finish -->
               
           </div><!-- panel-body Finish -->
            
        </div><!-- canel panel-default Finish -->
        
    </div><!-- col-lg-12 Finish -->
    
</div><!-- row Finish -->
   
    <script src="js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'#desc_editor, #features_editor'});</script>
</body>
</html>


<?php 

if(isset($_POST['update'])){
    
    $product_title = $_POST['product_title'];
    $product_url = $_POST['product_url'];
    $product_cat = $_POST['product_cat'];
    $cat = $_POST['cat'];
    $manufacturer_id = $_POST['manufacturer'];
    $date = $_POST['expiry_date'];
    $product_price = $_POST['product_price'];
    $product_keywords = $_POST['product_keywords'];
    $product_desc = $_POST['product_desc'];
    $new_quantity = $_POST['product_quan'];
    $product_status = $_POST['product_status'];
    $product_sale = $_POST['product_sale'];
    $product_label = $_POST['product_label'];
    
    // Retrieve current quantity from the database
    $get_quantity = "SELECT product_quan FROM products WHERE product_id='$p_id'";
    $run_quantity = mysqli_query($con, $get_quantity);
    $row_quantity = mysqli_fetch_array($run_quantity);
    $current_quantity = $row_quantity['product_quan'];

    // Calculate the updated quantity
    $updated_quantity = $current_quantity + $new_quantity;

    // Check if a new image is uploaded, and update only if it is not empty
    if (!empty($_FILES['product_img1']['name'])) {
        $product_img1 = $_FILES['product_img1']['name'];
        $temp_name1 = $_FILES['product_img1']['tmp_name'];
        move_uploaded_file($temp_name1, "product_images/$product_img1");
    }

    if (!empty($_FILES['product_img2']['name'])) {
        $product_img2 = $_FILES['product_img2']['name'];
        $temp_name2 = $_FILES['product_img2']['tmp_name'];
        move_uploaded_file($temp_name2, "product_images/$product_img2");
    }

    if (!empty($_FILES['product_img3']['name'])) {
        $product_img3 = $_FILES['product_img3']['name'];
        $temp_name3 = $_FILES['product_img3']['tmp_name'];
        move_uploaded_file($temp_name3, "product_images/$product_img3");
    }
    
    $update_product = "UPDATE products SET
        p_cat_id='$product_cat',
        cat_id='$cat',
        manufacturer_id='$manufacturer_id',
        expiry_date='$date',
        product_title='$product_title',
        product_url='$product_url',
        " . (isset($product_img1) ? "product_img1='$product_img1'," : "") . "
        " . (isset($product_img2) ? "product_img2='$product_img2'," : "") . "
        " . (isset($product_img3) ? "product_img3='$product_img3'," : "") . "
        product_price='$product_price',
        product_keywords='$product_keywords',
        product_desc='$product_desc',
        product_sale='$product_sale',
        product_label='$product_label',
        product_quan='$updated_quantity',
        product_status='$product_status'
        WHERE product_id='$p_id'";
    
    $run_product = mysqli_query($con, $update_product);
    
    if($run_product){
        
        echo "<script>alert('Product has been Updated successfully')</script>";
        echo "<script>window.open('index.php?view_products','_self')</script>";
        
    }
    
}

?>


<?php } ?>
