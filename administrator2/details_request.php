<?php
//include_once("controller/productController.php");
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");

if($_REQUEST['action']=='details')

{

 $items_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_items` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

$category_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_category` WHERE `id`='".mysqli_real_escape_string($con,$items_details['cat_id'])."'"));

$subcategory_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subcategory` WHERE `category_type`='".mysqli_real_escape_string($con,$category_details['id'])."'"));

$user_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".mysqli_real_escape_string($con,$items_details['user_id'])."'"));

$det = mysqli_query($con,"SELECT * FROM `roomrent_amenities` where `id` IN($property_details[amenities])");

while($more=mysqli_fetch_array($det))
{

$new_name[]=$more['name'];
//print_r($new_name);
//exit;

}
$amenities_name=implode(',',$new_name);
         $amenities_name;
       // exit;
}
?>


<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_property.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_property.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_property.php?cid="+aa+"&action=active";
   } 

   </script>
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
                   <h3 class="page-title">Items Details</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Items Details</a>
                           <span class="divider">/</span>
                        
                       </li>
                       <li> Items Details </li>
                       
                        
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green portlet-body form">
                        <div class="widget-title">
                             
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body" style="float:left;" >
                            <!-- BEGIN Table-->
                              
                            
                            
                          <form action="#" class="form-horizontal" method="post" action="add_social.php" enctype="multipart/form-data">
										 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                      
										
										
                                     <table class="table table-striped table-hover table-bordered" id="editable-sample" style="width: 999px !important;">


<tr>    
<td> Item Name</th>
<td> <?php echo $items_details['title'];?> </td>    
</tr>

<tr>    
<td> Category Name</th>
<td> <?php echo $category_details['name'];?> </td>    
</tr>

<tr>    
<td> Subcategory Name</th>
<td> <?php //echo $subcategory_details['name'];
echo $items_details['subcat_id'];
?> </td>    
</tr>

<tr>    
<td>Uploaded By</th>
<td> <?php echo $user_details['fname']." ".$user_details['lname'];?> </td>    
</tr>

<tr>    
<td> Decscription</th>
<td> <?php echo $items_details['description'];?> </td>    
</tr>

<tr>    
<td> Number of Items Sold</th>
<td> <?php echo $items_details['no_of_items_sold'];?> </td>    
</tr>

<tr>
<td>Is sold? </td>
<?php
$is_sold =  $items_details['is_sold'];
if($is_sold == '1'){ ?>
<td> <?php echo 'Available';?> </td>    
<?php }
else if ($is_sold == '0'){ ?>
  <td> <?php echo 'Out of Stock';?> </td>  
<?php } ?>
</tr>


<tr>
<td>State</td>
<?php /*<?php
$state =  $items_details['state'];
if($state == '1'){ ?>
<td> <?php echo 'New';?> </td>    
<?php }
else if ($state == '0'){ ?>
  <td> <?php echo 'Old';?> </td>  
<?php } ?> */ ?>
<td><?php echo $items_details['state'];?></td>
</tr>


<tr>
<td>Choose Options</td>
<?php
$choose_options =  $items_details['choose_options'];
if($choose_options == '1'){ ?>
<td> <?php echo 'For Sell';?> </td>    
<?php }
else if ($choose_options == '2'){ ?>
  <td> <?php echo 'For Lending';?> </td>  
<?php }
else if ($choose_options == '3'){ ?>
 <td> <?php echo 'For Service';?> </td>  
 <?php 
}
?>
</tr>

<tr>    
<td> Total Number of Items</th>
<td> <?php echo $items_details['no_of_items'];?> </td>    
</tr>

<tr>    
<td> Lending Start Date</th>
<td> <?php echo $items_details['lend_start_date'];?> </td>    
</tr>

<tr>    
<td> Lending End Date</th>
<td> <?php echo $items_details['lend_end_date'];?> </td>    
</tr>

<tr>    
<td> Price</th>
<td> <?php echo $items_details['price'];?> </td>    
</tr>

<tr>
<td>Price Negotiable</td>
<?php
$price_negotiate =  $items_details['price_negotiate'];
if($price_negotiate == '1'){ ?>
<td> <?php echo 'Yes';?> </td>    
<?php }
else if ($price_negotiate == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php } ?>
</tr>
<?php /*
<tr>    
<td> Pay Instalment</th>
<td> <?php echo $items_details['pay_installment'];?> </td>   
</tr>

<tr>
<td>Security Status</td>
<?php
$security_status =  $items_details['security_status'];
if($security_status == '1'){ ?>
<td> <?php echo 'Optional';?> </td>    
<?php }
else if ($security_status == '2'){ ?>
  <td> <?php echo 'Insurance';?> </td>  
<?php } ?>
</tr>

<tr>    
<td>Security Amount</td>
<td><?php echo $items_details['security_amount'];?></td>   
</tr>

*/?>

<tr>    
<td>Item Delivery</td>
<td><?php echo $items_details['itemdelivery'];?></td>   
</tr>

<tr>    
<td>Date Added</th>
<td><?php echo $items_details['add_date'];?> </td>    
</tr>

<td> Photos/Videos </td>
<?php
$moreimage1 = mysqli_query($con,"SELECT * FROM `webshop_items` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'");
while($moreimage=mysqli_fetch_array($moreimage1))
{


if($moreimage['photos_videos']!="")
{
$image_link='../upload/items/'.$moreimage['photos_videos'];
}
else
{
$image_link='../upload/no.jpg';
}
?>
<td><img src="<?php echo stripslashes($image_link);?>" height="70" width="70" style="border:1px solid #666666" /></td>
<?php
}
?>
</tr>

                    
<tr><button type="reset" class="btn blue" onClick="window.location.href='list_items.php'" >Back</button></tr>

	
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
  <!--  <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="js/editable-table.js"></script>

   <!-- END JAVASCRIPTS -->
   <script>
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
</body>
<!-- END BODY -->
</html>
