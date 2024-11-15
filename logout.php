<center><!-- center Begin -->
    
    <h1> Do You Really Want To Log out ? </h1>
    
    <form action="" method="post"><!-- form Begin -->
        
       <input type="submit" name="Yes" value="Yes, I Want To Logout" class="btn btn-danger"> 
        
       <input type="submit" name="No" value="No, I Dont Want To Logout" class="btn btn-primary"> 
        
    </form><!-- form Finish -->
    
</center><!-- center Finish -->




<?php 

if(isset($_POST['Yes'])){

    $delete_prod = "delete from cart";

    $run_delete = mysqli_query($con,$delete_prod);

    session_destroy();

    echo "<script>window.open('index.php','_self')</script>";

}


?>