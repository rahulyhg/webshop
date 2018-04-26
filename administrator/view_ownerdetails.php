<?php
//include_once("controller/productController.php");
include_once("./includes/session.php");
include_once("./includes/config.php");

if($_REQUEST['action']=='details')

{
  

//echo "SELECT * FROM `getfitpass_users` WHERE `id`='".$_REQUEST['id']."'";
//exit;
$userRow = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$_REQUEST['id']."'"));
    
//$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `barter_product` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));

//$store_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_store` WHERE `id`='".mysql_real_escape_string($categoryRowset['store_id'])."'"));

//$category_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_category` WHERE `id`='".mysql_real_escape_string($categoryRowset['cat_id'])."'"));

//$subcategory_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_subcategory` WHERE `id`='".mysql_real_escape_string($categoryRowset['subcat'])."'"));



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
                           <a href="#">User Details</a>
                           <span class="divider">/</span>
                        
                       </li>
                     
                       
                       
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
                              
                            
                            
                          <form action="#" class="form-horizontal" method="post" action="user_update.php" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                      
                    
        <tr><button type="reset" class="btn blue" onClick="window.location.href='list_user.php'" >Back</button></tr>

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
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
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
