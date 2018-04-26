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
    $update=mysqli_query($con,"UPDATE `fainin_orders` SET `message`='".$message."' WHERE `id`='".$id."'");
    header("location:order_details.php?orderid=".$id);
}
?>
<?php

  if($_REQUEST['orderid'])
    {

  $id=$_REQUEST['orderid'];
$sql="select * from `fainin_orders` where `id`='$id'";


$res=mysqli_query($con,$sql);
$row8=mysqli_fetch_array($res);



 $tt=mysqli_query($con,"select * from `fainin_billing` where `billing_id`='".$row8['billing_id']."'");
   $row11=mysqli_fetch_array($tt);
   
   
$tt1=mysqli_query($con,"select * from `fainin_user` where `id`='".$row8['user_id']."'");
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


$rowOrderDetails = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `fainin_orders` WHERE `id`=".mysqli_real_escape_string($con,$_REQUEST['orderid'])." "));


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

<?php

$rowOrderDetails = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_transactions` WHERE `id`=".mysqli_real_escape_string($con,$_REQUEST['id'])." "));

$owner_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`=".$rowOrderDetails['owner_id']." "));

$provider_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`=".$rowOrderDetails['provider_id']." "));

$pet_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_pets` WHERE `id`=".$rowOrderDetails['pet_id']." "));

$booking_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_bookings` WHERE `id`=".$rowOrderDetails['booking_id']." "));
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
                   <h3 class="page-title">  Details </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Details View</a>                           
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
                                <h4><i class="icon-reorder"></i> Payment Details </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Invoice Number #</th>
                                        <th>Invoice Date & Time</th>
                                        <th>Invoice Terms</th>
                                        <th>Invoice Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $rowOrderDetails['invoice_number'];?></td>
                                        <td><?php echo $rowOrderDetails['add_date'];?></td>
                                        <td><?php echo $rowOrderDetails['invoice_terms'];?></td>
                                        <td><?php echo $rowOrderDetails['invoice_total'];?></td>
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
                                <h4><i class="icon-reorder"></i> Owner Information </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Reg. Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $owner_details['fname'] ?>&nbsp;<?php echo $owner_details['lname'] ?></td>
                                        <td><?php echo $owner_details['email'] ?></td>
                                        <td><?php echo $owner_details['phone'] ?></td>
                                        <td><?php echo $owner_details['add_date'] ?></td>
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
                                <h4><i class="icon-reorder"></i> Provider Information </h4>
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
                                  $x="select * from fainin_billing where orderid='".$id."'";
                                          $rs=mysqli_query($con,$x);
                                         $row_r=mysqli_fetch_object($rs);
                                        //  {

                                       //   $pro_price = $row_r->price;
                                       //   $product_image=mysqli_fetch_object(mysqli_query($con,"SELECT * FROM `fainin_items` WHERE `id`='".$row_r->productid."'"));
                                          //$product_moreimage=mysqli_fetch_object(mysqli_query($con,"SELECT * FROM `makeoffer_moreimage` WHERE `pro_id`='".$product_image->id."'"));

                                          //echo "SELECT * FROM `fainin_items` WHERE `id`='".$row_r->productid."'"
                                    ?>    
                                        
                                        
                                    <tr>
                                        <td><?php echo $provider_details['fname']." ".$provider_details['lname']?></td>
                                        
                                        
                                        
                                      
                                        
                                        
                                        <td><?php echo $provider_details['phone'];?></td>
                                          <td><?php echo $provider_details['email'];?></td>
                                       <td><?php echo $provider_details['address'];?></td>
                                        
                                      
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
                                <h4><i class="icon-reorder"></i> Pet Details </h4>
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
                                        <th> Image  </th>
                                        <th> Age  </th>
                                        <th> Breed  </th>
                                        <th> Type  </th>
                                        <th> Status </th>
                                        <th> Added Date </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <tr>
                                        <td><?php echo $pet_details['name'];?></td>
                                        
                                         <?php 
                                        if($pet_details['image']=='')
                                        {
                                            $imgage= '../upload/no.png';
                                        }
                                        else {
                                          $imgage= '../upload/pets_image/'.$pet_details['image'];  
                                        }
                                          ?>
                                        
                                        
                                        <td><img src=<?php echo $imgage ?> width="100" height="100"  border="0" align="center" alt="" /></td>
                                          <td><?php echo $pet_details['age']." years";?></td>
                                      <td><?php echo $pet_details['breed'];?></td>

                                       <td><?php echo $pet_details['animal_type'];?></td>
                                       <td><?php if($pet_details['pets_status']=='1'){
                                          echo "Adopted";
                                        }else if($pet_details['pets_status']=='2'){
                                          echo "Lost";
                                        }else if($pet_details['pets_status']=='3'){
                                          echo "Found";
                                        }else {
                                          echo "New";
                                        }?></td>  
                                      
                                       <td><?php echo $pet_details['add_date'];?></td>
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
                        <div class="widget blue">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Trip Details </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                            </div>
                            <div class="widget-body">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th> Pickup Location </th>
                                        <th> Drop Location  </th>
                                        <th> Pickup Time  </th>
                                        <th> Drop Time  </th>
                                        <th> Distance Travelled(in km.)  </th>
                                        <th> Status </th>
                                        <th> Booking Date </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <tr>
                                        <td><?php echo $booking_details['pickup_location'];?></td>

                                         <td><?php echo $booking_details['drop_location'];?></td>

                                          <td><?php echo $booking_details['pickup_time'];?></td>

                                           <td><?php echo $booking_details['drop_time'];?></td>

                                             <td><?php echo $booking_details['distance'];?></td>

                                                
                                       <td><?php if($booking_details['ride_status']=='0'){
                                          echo "Pending";
                                        }else if($pet_details['ride_status']=='1'){
                                          echo "On Trip";
                                        }else {
                                          echo "Completed";
                                        }?></td>  

                                               <td><?php echo $booking_details['booking_date'];?></td>
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