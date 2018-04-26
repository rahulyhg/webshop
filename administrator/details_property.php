<?php
//include_once("controller/productController.php");
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");

if($_REQUEST['action']=='details')

{

 $property_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_property` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

$property_type_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_property_type` WHERE `id`='".mysqli_real_escape_string($con,$property_details['property_type'])."'"));


$det = mysqli_query($con,"SELECT * FROM `webshop_amenities` where `id` IN($property_details[amenities])");

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
                   <h3 class="page-title">Property Details</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Property Details</a>
                           <span class="divider">/</span>
                        
                       </li>
                       <li> Property Details </li>
                       
                        
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

<!-- <tr>    
<td> Name </th>
<td> <?php echo $property_details['name'];?> </td>    
</tr>

<tr>    
<td> Description </th>
<td> <?php echo $property_details['description'];?> </td>    
</tr>

<tr>    
<td> Price </th>
<td> $<?php echo $property_details['price'];?> </td>    
</tr> -->

<tr>    
<td> Property Type </th>
<td> <?php echo $property_type_details['name'];?> </td>    
</tr>

<tr>    
<td> Amenities </th>
<td> <?php echo $amenities_name ;?> </td>    
</tr>

<tr>    
<td> I have </th>
<td> <?php echo $property_details['i_have'];?> </td>    
</tr>

<tr>
<td>Size and Type of Property</td>
<td> <?php echo $property_details['size'].",";?> 
<?php echo $property_type_details['name'];?> 
</td>
</tr>

<tr>    
<td> Occupants </td>
<td> <?php echo $property_details['occupants'];?> </td>    
</tr>

<tr>    
<td> PostCode of Property </td>
<td> <?php echo $property_details['property_postcode'];?> </td>    
</tr>

<tr>
<td>I am </td>
<?php
$i_am =  $property_details['i_am'];
if($i_am == '1'){ ?>
<td> <?php echo 'Live in Landlord';?> </td>    
<?php }
else if ($i_am == '2'){ ?>
  <td> <?php echo 'Live out Landlord';?> </td>  
<?php }
else if ($i_am == '3'){ ?>
 <td> <?php echo 'Current tenant/flatmate';?> </td>  
 <?php 
}
?>
</tr>

<tr>    
<td> My Email is </td>
<td> <?php echo $property_details['email'];?> </td>    
</tr>

<tr>    
<td> Area </td>
<td> <?php echo $property_details['property_area'];?> </td>    
</tr>

<tr>    
<td> Street Name </td>
<td> <?php echo $property_details['street_name'];?> </td>    
</tr>

<tr>    
<td> Post Code </td>
<td> <?php echo $property_details['property_postcode'];?> </td>    
</tr>

<tr>    
<td> Transport </td>
<td> <?php echo $property_details['transport_minutes']." minutes ";?>  
 <?php echo $property_details['transport_by']." from ";?>     
 <?php echo $property_details['transport_area'];?> </td>
</tr>

<tr>
<td>Living Room </td>
<?php
$living_room =  $property_details['living_room'];
if($living_room == '1'){ ?>
<td> <?php echo 'Yes,there is a shared living room';?> </td>    
<?php }
else if ($living_room == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php }
?>
</tr>

<tr>
<td>Cost of Room </td>
<?php
$cost_of_room =  $property_details['cost_of_room'];
if($cost_of_room == '1'){ ?>
<td> <?php echo '$ per calendar month';?> </td>    
<?php }
else if ($cost_of_room == '2'){ ?>
  <td> <?php echo '$ per week';?> </td>  
<?php }
?>
</tr>

<tr>
<td>Size of Room </td>
<?php
$size_of_room =  $property_details['size_of_room'];
if($size_of_room == '1'){ ?>
<td> <?php echo 'Single';?> </td>    
<?php }
else if ($living_room == '2'){ ?>
  <td> <?php echo 'Double';?> </td>  
<?php }
?>
</tr>

<tr>
<td>Amenities Facilities</td>
<?php
$amenities_facility =  $property_details['amenities_facility'];
if($amenities_facility == '1'){ ?>
<td> <?php echo 'Ensuite(room has own toilet and/or bath/shower)';?> </td>    
<?php }
else if ($amenities_facility == '2'){ ?>
  <td> <?php echo 'Furnished';?> </td>  
<?php }
?>
</tr>

<tr>    
<td> Security Deposit </td>
<td> <?php echo $property_details['security_amount'];?></td>
</tr>

<tr>    
<td> Available from </td>
<td> <?php echo $property_details['available_from'];?> </td>    
</tr>

<tr>    
<td> Minimum Stay </td>
<td> <?php echo $property_details['minimum_stay'];?> </td>    
</tr>

<tr>    
<td> Maximum Stay </td>
<td> <?php echo $property_details['maximum_stay'];?> </td>    
</tr>

<tr>
<td>Short Term Lets Considered?<br>(i.e. 1 week to 3 months)</td>
<?php
$short_term =  $property_details['short_term'];
if($short_term == '1'){ ?>
<td> <?php echo 'Yes';?> </td>    
<?php }
else if ($short_term == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php }
?>
</tr>

<tr>
<td>Days Available</td>
<?php
$days_available =  $property_details['days_available'];
if($days_available == '1'){ ?>
<td> <?php echo 'Yes';?> </td>    
<?php }
else if ($days_available == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php }
?>
</tr>

<tr>
<td>References required</td>
<?php
$reference =  $property_details['reference'];
if($reference == '1'){ ?>
<td> <?php echo 'Yes';?> </td>    
<?php }
else if ($reference == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php }
?>
</tr>

<tr>
<td>Bills Included </td>
<?php
$bills =  $property_details['bills'];
if($bills == '1'){ ?>
<td> <?php echo 'Yes';?> </td>    
<?php }
else if ($bills == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php }
else if ($bills == '2'){ ?>
 <td> <?php echo 'Some';?> </td>  
 <?php 
}
?>
</tr>

<tr>
<td>Broadband included</td>
<?php
$broadband =  $property_details['broadband'];
if($broadband == '1'){ ?>
<td> <?php echo 'Yes';?> </td>    
<?php }
else if ($broadband == '0'){ ?>
  <td> <?php echo 'No';?> </td>  
<?php }
?>
</tr>


<td> Image </td>
<?php
$moreimage1 = mysqli_query($con,"SELECT * FROM `webshop_property` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'");
while($moreimage=mysqli_fetch_array($moreimage1))
{


if($moreimage['image']!="")
{
$image_link='../upload/property/'.$moreimage['image'];
}
else
{
$image_link='../upload/no.png';
}
?>
<td><img src="<?php echo stripslashes($image_link);?>" height="70" width="70" style="border:1px solid #666666" /></td>
<?php
}
?>
</tr>

                    
<tr><button type="reset" class="btn blue" onClick="window.location.href='list_product.php'" >Back</button></tr>

	
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
