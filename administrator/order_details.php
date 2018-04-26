 <?php 

include_once('includes/session.php');

include_once("includes/config.php");

include_once("includes/functions.php");

?>
<?php
if($_REQUEST['submit'])
{
    $id= $_REQUEST['hid_id'];
    $message=$_REQUEST['message'];
    $update=mysqli_query($con,"UPDATE `webshop_orders` SET `message`='".$message."' WHERE `id`='".$id."'");
    header("location:order_details.php?orderid=".$id);
}
?>
<?php

  if($_REQUEST['orderid'])
    {

  $id=$_REQUEST['orderid'];
$sql="select * from `webshop_orders` where `id`='$id'";


$res=mysqli_query($con,$sql);
$row8=mysqli_fetch_array($res);



 $tt=mysqli_query($con,"select * from `webshop_billing` where `billing_id`='".$row8['billing_id']."'");
   $row11=mysqli_fetch_array($tt);
   
   
$tt1=mysqli_query($con,"select * from `webshop_user` where `id`='".$row8['user_id']."'");
   $row12=mysqli_fetch_array($tt1);
   $price=mysqli_query($con,"select * from `makeoffer_tblorderdetails` where `id`='".$id."'");
   while($fetch=mysqli_fetch_array($price))
   {
       $houid[] = $fetch['id'];
   
   }
    $happid = implode(',' , $houid);
   
    }


if($_REQUEST['orderid']!="")

{


$rowOrderDetails = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_orders` WHERE `id`=".mysqli_real_escape_string($con,$_REQUEST['orderid'])." "));


/*
$query_user="SELECT id,fb_user_id,concat(fname,' ',lname) as name,email,phone,add_date from makeoffer_user where id=".$rowOrderDetails['order_user_id']." ";
$res_user=mysqli_query($con,$query_user);
$row_user=mysqli_fetch_assoc($res_user);

$query_billing="select * from makeoffer_billing where billing_id =".$rowOrderDetails['billingid']."";
$res_billing=mysqli_query($con,$query_billing);
$row_billing=mysqli_fetch_assoc($res_billing);

$query_order_details="select id,productid,quantity,price from makeoffer_tblorderdetails where orderid=".mysqli_real_escape_string($con,$_REQUEST['orderid'])."";
$res_order_details=mysqli_query($con,$query_order_details);
$num_order_details=mysqli_num_rows($res_order_details);*/

}
?>
 <!-- Header Start -->
<?php include ("includes/header.php"); ?>
<!-- Header End -->
   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->


    <?php include("includes/left_sidebar.php"); ?>


      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                   <!-- BEGIN THEME CUSTOMIZER-->
                   <div id="theme-change" class="hidden-phone">
                       <i class="icon-cogs"></i>
                        <span class="settings">
                            <span class="text">Theme Color:</span>
                            <span class="colors">
                                <span class="color-default" data-style="default"></span>
                                <span class="color-green" data-style="green"></span>
                                <span class="color-gray" data-style="gray"></span>
                                <span class="color-purple" data-style="purple"></span>
                                <span class="color-red" data-style="red"></span>
                            </span>
                        </span>
                   </div>
                   <!-- END THEME CUSTOMIZER-->
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title"> Order Details </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Order View</a>                           
                       </li>
                      
                       <li class="pull-right search-wrap">
                           <form action="search_result.html" class="hidden-phone">
                               <div class="input-append search-input-area">
                                   <input class="" id="appendedInputButton" type="text">
                                   <button class="btn" type="button"><i class="icon-search"></i> </button>
                               </div>
                           </form>
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->

            <div id="page-wraper">
                <div class="row-fluid">
                    <div class="span6">
                        <!-- BEGIN BASIC PORTLET-->
                        <div class="widget purple">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Order Details </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Order Date & Time</th>
                                        <th>Order Type</th>
                                        <th>Grand Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $rowOrderDetails['unique_trans_id'];?></td>
                                        <td><?php echo $rowOrderDetails['date'];?></td>
                                        <td><?php echo $rowOrderDetails['type'];?></td>
                                        <td><?php echo $rowOrderDetails['price'];?></td>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET-->
                    </div>
                    <div class="span6">
                        <!-- BEGIN BASIC PORTLET-->
                        <div class="widget red">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Customer Information </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Reg. Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row12['fname'] ?>&nbsp;<?php echo $row12['lname'] ?></td>
                                        <td><?php echo $row12['email'] ?></td>
                                        <td><?php echo $row12['phone'] ?></td>
                                        <td><?php echo $row12['add_date'] ?></td>
                                    </tr>                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET-->
                    </div>
                </div>
                
               
               <!-- <div class="row-fluid">
                    <div class="span6">
                        <!-- BEGIN BASIC PORTLET
                        <div class="widget green">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Billing Address </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Zip</th>
                                        <th>State</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row11['billing_add']?></td>
                                        <td><?php echo $row11['billing_city']?></td>
                                        <td><?php echo $row11['billing_zip']?></td>
                                        <td><?php echo $row11['billing_state']?></td>
                                        <td><?php echo $row11['billing_ephone']?></td>
                                        <td><?php echo $row11['email']?></td>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET
                    </div>
                    
                    
                    <div class="span6">
                        <!-- BEGIN BASIC PORTLET
                        <div class="widget green">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Shipping Address </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Zip</th>
                                        <th>State</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row11['shiping_add']?></td>
                                        <td><?php echo $row11['shiping_city']?></td>
                                        <td><?php echo $row11['shiping_zip']?></td>
                                        <td><?php echo $row11['shiping_state']?></td>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET
                    </div>
                    
                    
                </div>-->
                
               
                    <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN BASIC PORTLET-->
                        <div class="widget green">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Shipping Address </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Phone  </th>
                                        <th> Email  </th>
                                        <th> Address </th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php 
                                    $sum=0;
                                  $x="select * from webshop_billing where orderid='".$id."'";
                                          $rs=mysqli_query($con,$x);
                                         $row_r=mysqli_fetch_object($rs);
                                        //  {

                                       //   $pro_price = $row_r->price;
                                       //   $product_image=mysqli_fetch_object(mysqli_query($con,"SELECT * FROM `webshop_items` WHERE `id`='".$row_r->productid."'"));
                                          //$product_moreimage=mysqli_fetch_object(mysqli_query($con,"SELECT * FROM `makeoffer_moreimage` WHERE `pro_id`='".$product_image->id."'"));

                                          //echo "SELECT * FROM `webshop_items` WHERE `id`='".$row_r->productid."'"
                                    ?>    
                                        
                                        
                                    <tr>
                                        <td><a href="#"><?php echo $row_r->shiping_fname." ".$row_r->shiping_lname;?></a></td>
                                        
                                        
                                        
                                      
                                        
                                        
                                        <td><?php echo $row_r->shiping_ephone;?></td>
                                          <td><?php echo $row_r->email1;?></td>
                                       <td><?php echo $row_r->shiping_add;?></td>
                                        
                                      
                                    </tr>
                                    
                                    
                                    </tbody>
                                    
                                    <?php 
                                    
                                   //  $sum=$sum+$rowOrderDetails['price'];
                                      //  }
                                       ?>
                                    
                                
                                </table>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET-->
                    </div>
                </div>   
                
                
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN BASIC PORTLET-->
                        <div class="widget orange">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Product Details </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th> Item Name </th>
                                        <th> Image </th>
                                        <th> Quantity </th>
                                        <th> Price </th>   
                                          <th>Total Price </th>   
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php 
                                    $sum=0;
                                    $x="select * from webshop_tblorderdetails where orderid='".$id."'";
                                          $rs=mysqli_query($con,$x);
                                          while($row_r=mysqli_fetch_object($rs))
                                          {

                                          $pro_price = $row_r->price;
                                          $product_image=mysqli_fetch_object(mysqli_query($con,"SELECT * FROM `webshop_items` WHERE `id`='".$row_r->productid."'"));
                                          //$product_moreimage=mysqli_fetch_object(mysqli_query($con,"SELECT * FROM `makeoffer_moreimage` WHERE `pro_id`='".$product_image->id."'"));

                                          //echo "SELECT * FROM `webshop_items` WHERE `id`='".$row_r->productid."'"
                                    ?>    
                                        
                                        
                                    <tr>
                                        <td><a href="#"><?php echo $product_image->title;?></a></td>
                                        
                                        
                                        
                                        <?php $im=$product_image->img;
                                        if($product_image->photos_videos=='')
                                        {
                                            $imgage= '../upload/no.png';
                                        }
                                        else {
                                          $imgage= '../upload/items/'.$product_image->photos_videos;  
                                        }
                                          ?>
                                        
                                        
                                        <td><img src=<?php echo $imgage ?> width="100" height="100"  border="0" align="center" alt="" /></td>
                                        <td><?php echo $row_r->quantity;?></td>
                                        <td>
                                            <?php echo $rowOrderDetails['price']?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $row_r->quantity * $rowOrderDetails['price'];?>
                                        </td>
                                    </tr>
                                    
                                    
                                    </tbody>
                                    
                                    <?php 
                                    
                                     $sum=$sum+$rowOrderDetails['price'];
                                        } ?>
                                    
                                    <tr style="">
															<th colspan="4">Total  Price</th>
															
															<th colspan="1">$ <?php echo $sum;?></th>
															</tr>
                                </table>
                            </div>
                        </div>
                        <!-- END BASIC PORTLET-->
                    </div>
                </div>

            </div>

            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

    <!-- Footer Start -->

   <?php include("includes/footer.php"); ?>

   <!-- Footer End -->

   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>

   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>