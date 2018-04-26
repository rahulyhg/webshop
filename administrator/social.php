<?php 
include_once("controller/SocialController.php");
?>


<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="social.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="social.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="social.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">
                    Manage Social Media 
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Site settings</a>
                           <span class="divider">/</span>
                       </li>
                        <li>
                           <a href="#">Manage Social Media </a>
                        
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
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>Social Media</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                     <thead>
                                    <tr>
                <th>
                  Name
                </th>
                <th>
                   Link
                </th>
                <th>Image</th>
                 <th>Edit</th>
                 <th>Status</th>
              
                
              </tr>
                                     </thead>
                                     <tbody>
                                    <?php
                                                       //$sql="select * from makeoffer_social  where id<>''";
                                                        

 if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_social where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:social.php');
  exit();
}

//$record=mysqli_query($con,$sql);
if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_social set status='0' where id='".$item_id."'");
         header('Location:social.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_social set status='1' where id='".$item_id."'");
         header('Location:social.php');
  exit();
}

if(mysqli_num_rows($record)==0)

{?>

                  <tr>

                    <td colspan="3">Sorry, no record found.</td>

                  </tr>

                  <?php 

}

else

{

$count=1;

  while($row=mysqli_fetch_object($record))

  {

 if($row->image==''){
  $img='../upload/noimage.Jpeg';
  }else{
  $img='../upload/social_image/'.$row->image;
  }
  

?>

              
              <tr>
                <td>
                  <?php echo stripslashes($row->name);?>
                </td>
                
                
                <td>
                  <?php echo stripslashes($row->link);?>
                </td>

                 <td>
                  <img src="<?php echo stripslashes($img);?>" height="70" width="70" style="border:1px solid #666666" />
                </td>

                <td>
                  <a onClick="window.location.href='add_social.php?id=<?php echo $row->id ?>&action=edit'"><i class="icon-edit"></i></a>
                   <a onClick="javascript:del('<?php echo $row->id; ?>')">
                  <i class="icon-trash"></i> </a>
                </td>
                <td>
                  <?php if($row->status=='0'){?>
                    <a  onClick="javascript:active('<?php echo $row->id;?>');">Click to Activate</a>
                    <?php } else {?>
                    <a  onClick="javascript:inactive('<?php echo $row->id;?>');">Click to deactivate</a>
                  <?php }?>
                </td>
              </tr>
                                                       <?php
                                                        }
}
                                                       ?>
                                     </tbody>
                                 </table>
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
