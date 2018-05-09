<?php
//include_once("controller/productController.php");
include_once("./includes/session.php");
include_once("./includes/config.php");

if($_REQUEST['action']=='details')

{
  

//echo "SELECT * FROM `getfitpass_users` WHERE `id`='".$_REQUEST['id']."'";
//exit;
$userRow = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$_REQUEST['id']."'"));

//$membership = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_membership` WHERE `id`='".$userRow['membership_id']."'"));

//$products = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `webshop_products` WHERE `uploader_id`='".$userRow['id']."'"));


$membership = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subscription` WHERE `id`='".$userRow['subscription_id']."'"));

$membershipexpiredate = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subscribers` WHERE `user_id`='".$userRow['id']."' order by id desc limit 1"));

$products = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `webshop_products` WHERE `uploader_id`='".$userRow['id']."' and `subscription_id`='".$membershipexpiredate['id']."'"));
 

$specialpackages = mysqli_query($con,"SELECT * FROM `webshop_subscription` WHERE `type`='O'");
//$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `barter_product` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));

//$store_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_store` WHERE `id`='".mysql_real_escape_string($categoryRowset['store_id'])."'"));

//$category_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_category` WHERE `id`='".mysql_real_escape_string($categoryRowset['cat_id'])."'"));

//$subcategory_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_subcategory` WHERE `id`='".mysql_real_escape_string($categoryRowset['subcat'])."'"));



}
if (isset($_REQUEST['submit'])) {
    
    
    
    $email =$userRow['email']; 
    $msg ="You have a special package. Please login and subscribe to get more benifits";
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';  
   
    $package_id = isset($_POST['package_id']) ? $_POST['package_id'] : '';
   
    
    
    
   
    $fields = array(
        //'user_id' => mysqli_real_escape_string($con, $user_id),
        'special_package_id' => mysqli_real_escape_string($con, $package_id),
        
       
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
        $editQuery = "UPDATE `webshop_user` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $user_id) . "'";
        //exit;

        if (mysqli_query($con, $editQuery)) {
            
            mail($email,"Your Special Package",$msg,'palashsaharana@gmail.com');
            
            $_SESSION['msg'] = "Special package added Successfully";
        } else {
            $_SESSION['msg'] = "Error occured while updating Package";
        }

        
       // exit();
     
}

?>


<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_product.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_product.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_product.php?cid="+aa+"&action=active";
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
              
                   <h3 class="page-title">Details of <?php echo $userRow['fname']." ".$userRow['lname'] ;?></h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Vendor Details</a>
                           <span class="divider">/</span>
                        
                       </li>
                     
                       
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
       
            <?php echo $_SESSION['msg'];?>
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
                              
                            
                            
                          <form  class="form-horizontal" method="post">
                     <input type="hidden" name="user_id" value="<?php echo $_REQUEST['id'];?>" />
                                     <!--<input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />-->
                                      
                    
        <tr><button type="reset" class="btn blue" onClick="window.location.href='list_topvendor.php'" >Back</button></tr>

                                     <table class="table table-striped table-hover table-bordered" id="editable-sample" style="width: 999px !important;">


<tr>    
<td>Full Name </th>
<td><?php echo $userRow['fname']." ".$userRow['lname'];?></td>
</tr>

<tr>    
<td> Email </th>
<td> <?php echo $userRow['email'];?> </td>
</tr>


<tr>
<td> Contact No. </th> 
<td><?php echo $userRow['phone']; ?></td>    
</tr>

<tr>    
<td> Address </th>
<td><?php echo $userRow['address']; ?></td>
</tr>



<tr>
<td> Image </td>
<?php
$moreimage1 = mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$_REQUEST['id']."'");
while($moreimage=mysqli_fetch_array($moreimage1))
{

if($moreimage['image']!="")
{
$image_link='../upload/user_image/'.$moreimage['image'];
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

<tr>    
<td> Subscription Title</th>
<td><?php echo $membership['name']; ?></td>
</tr>

<tr>    
<td> Subscription Price</th>
<td><?php if($membership['price']!=""){ echo $membership['price'].' KWD';} ?></td>
</tr>

<tr>    
<td> Subscription Slot</th>
<td><?php echo $membership['slots']; ?></td>
</tr>

<tr>    
<td> Subscription Expire</th>
<td><?php if($membership['duration']!=""){echo $membership['duration']." Days"; ?><?php echo '('.date('d F,Y',strtotime($membershipexpiredate['expiry_date'])).')';}?></td>
</tr>

<tr>    
<td> Number of Products Uploaded</th>
<td><?php echo $products; ?></td>
</tr>
  
</table><br>

                                <div class="control-group">
                                    <label class="control-label">Special Package</label>
                                    <div class="controls">
                                        
                                        <select class="form-control" name="package_id" required>
                                            <option value=""> --select package-- </option>
                                            
                                         <?php   
                                            while ($package_array = mysqli_fetch_array($specialpackages)) {?>
                                            
                                            <option value="<?php echo $package_array['id'];?>"><?php echo $package_array['name'];?></option>
                                            
                                         <?php }  ?>
                                        </select>

                                    </div>
                                </div>  
                                <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Save</button>
                                <div class="form-actions"></div>
        
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
   <!-- <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
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
