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
    $update=mysqli_query($con,"UPDATE `makeoffer_orders` SET `message`='".$message."' WHERE `id`='".$id."'");
    header("location:order_details.php?orderid=".$id);
}
?>
<?php

  if($_REQUEST['orderid'])
    {

  $id=$_REQUEST['orderid'];
$sql="select * from `makeoffer_orders` where `id`='$id'";


$res=mysqli_query($con,$sql);
$row8=mysqli_fetch_array($res);



 $tt=mysqli_query($con,"select * from `makeoffer_billing` where `billing_id`='".$row8['billing_id']."'");
   $row11=mysqli_fetch_array($tt);
   
   
$tt1=mysqli_query($con,"select * from `makeoffer_user` where `id`='".$row8['user_id']."'");
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


$rowOrderDetails = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_orders` WHERE `id`=".mysqli_real_escape_string($con,$_REQUEST['orderid'])." "));


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
                   <h3 class="page-title"> Promote </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Promote</a>                           
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
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                           <h4><i class="icon-reorder"></i>Promoted Product List</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
    <div class="widget-body">
        
        
                            <!-- BEGIN Table-->
        <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
          
        
        
        <table class="table table-striped table-hover table-bordered" id="editable-sample">
            
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Payment Status</th>
                <th>Pay By</th>
                <th>Promoted Date</th>
            </tr>
            </thead>
        
    <?php
    $promo=mysqli_query($con,"SELECT makeoffer_promotedproducts.payment_status, makeoffer_promotedproducts.pay_by, makeoffer_promotedproducts.date, makeoffer_product.name, makeoffer_product.description FROM makeoffer_promotedproducts INNER JOIN makeoffer_product ON makeoffer_promotedproducts.pid = makeoffer_product.id;");    
    //$row111=mysqli_fetch_array($promo);
    
    $num=mysqli_num_rows($promo);
    if($num>0)
    {
    
    while($prodo=mysqli_fetch_array($promo))
            {
    
    ?>    
              
             <tbody>
                <tr>
                <td> <?php echo $prodo['name'];?> </td>
                <td> <?php echo $prodo['description'];?> </td>
                <td> <?php echo $prodo['payment_status'];?> </td>
                <td> <?php echo $prodo['pay_by'];?> </td>
                <td> <?php echo $prodo['date'];?> </td>
                </tr>
             </tbody> 
          <?php 
    }
    } 
    ?>    
                                     
          </table>
            
        
        
        </form>
                            
                            
    

                            <!-- END Table-->
    </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
                
                
                
                
            <div class="row-fluid">
                <div class="span12">
                   
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