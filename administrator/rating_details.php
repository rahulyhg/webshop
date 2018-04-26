<?php
include_once("controller/productController.php");


if($_REQUEST['action']=='details')

{

//$userRow = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_ratings`"));
    
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_product` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

$store_id = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_store` WHERE `id`='".mysqli_real_escape_string($con,$categoryRowset['store_id'])."'"));

$category_id = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_category` WHERE `id`='".mysqli_real_escape_string($con,$categoryRowset['cat_id'])."'"));

$subcategory_id = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subcategory` WHERE `id`='".mysqli_real_escape_string($con,$categoryRowset['subcat'])."'"));



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
                   <h3 class="page-title">Rating & Feedback Management</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Rating & Feedback Management</a>
                           <span class="divider">/</span>
                        
                       </li>
                       <li> Rating & Feedback Management </li>
                       
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
<?php


            
?>            
            
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
                              
<?php
$userRow = mysqli_query($con,"SELECT * FROM `webshop_ratings`");

$result = mysqli_query($con,$userRow);

while ($row = mysqli_fetch_array($result))

{

        if ($result)

        {

        $rate = $row['rating'];

        $feed = $row['feddback'];

        

        }

}




?>

                            
                            
                          <form action="#" class="form-horizontal" method="post" action="user_update.php" enctype="multipart/form-data">
										 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                      
										
										
<table class="table table-striped table-hover table-bordered" id="editable-sample" style="width: 999px !important;">

<tr>    
<td>Ratings </th>
<td><?php echo $rate; ?></td>
</tr>

<tr>
<td>Feedback</th>
<td><?php echo $feed;?></td>
</tr>


                    
<tr><button type="reset" class="btn blue" onClick="window.location.href='search_user.php'" >Back</button></tr>

	
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
