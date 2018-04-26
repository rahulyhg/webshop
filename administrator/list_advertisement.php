<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from webshop_advertisement where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_advertisement.php');
  exit();
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_advertisement`"));

}

?>

<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_advertisement.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_advertisement.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_advertisement.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Manage Advertisement</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Manage Advertisement</a>
                        
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
                        <h4><i class="icon-reorder"></i>All Advertisement</h4>
                             <form action="" method="post">
                <!--<i class="fa fa-edit"></i>Editable Table-->
                                 <!-- <button type="submit"   name="ExportCsv"> Download General User List</button> -->
                                                            </form>
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
                <th>Uploader Image</th>
                  <th>Uploader Name</th>
                <th>Name</th>
        <!--         <th>Description</th> -->
                <th>Video</th>
              <th>Duration</th>
               <th>Payment</th> 
                <th>Quick Links</th>
                <th>Status</th>
              </tr>
            </thead>
        <tbody>
                            <?php

    if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_advertisement set status='0' where id='".$item_id."'");
         header('Location:list_advertisement.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_advertisement set status='1' where id='".$item_id."'");
         header('Location:list_advertisement.php');
  exit();
}
                                                        $fetch_landlord=mysqli_query($con,"select * from webshop_advertisement order by id desc");
                                                        $num=mysqli_num_rows($fetch_landlord);
                                                        if($num>0)
                                                        {
                                                        while($landlord=mysqli_fetch_array($fetch_landlord))
                                                        {
                                                           

$uploader_details = mysqli_fetch_array(mysqli_query($con,"select * from webshop_user where id='".$landlord['user_id']."'"));

 if($uploader_details['image']!='')
    {
    $image_link='../upload/user_image/'.$uploader_details['image'];
    }
    else {
    $image_link='../upload/user_image/nouser.jpg';
    }
                                                        ?>
              
              <tr>
                
              <td>
                 <img src="<?php echo $image_link;?>" height="100" width="100" align="image">
                </td> 

                 <td>
                  <?php echo stripslashes($uploader_details['fname']." ".$uploader_details['lname']);?>
                </td>

                <td>
                  <?php echo stripslashes($landlord['name']);?>
                </td> 

           <!--        <td>
                  <?php echo stripslashes($landlord['description']);?>
                </td>  -->

                <!--  <td>
                  <?php echo stripslashes($landlord['video']);?>
                </td> -->

                <td>
                <a href="../upload/advertisement_video/<?php echo $landlord['video'];?>" target="_blank">Play Video</a>
                </td>

               <td>
                  <?php echo stripslashes($landlord['duration']);?>
                </td> 

                 <td>
                  <?php 
                  if($landlord['payment_status']=='0'){
                    echo "Pending";
                  }else{
                    echo "Paid";
                  }
                 ?>
                </td> 

               <!--   <td>
                  <a href ='<?php echo stripslashes($landlord['link']);?>' target="_blank"><?php echo stripslashes($landlord['link']);?></a>
                </td> --> 
                
              
                <td>
                 <a  href="videosdetails.php?id=<?php echo $landlord['id'] ?>&action=details">
                  <i class="icon-eye-open"></i></a> 
                  <a  href="add_advertisement.php?id=<?php echo $landlord['id'] ?>&action=edit">
                  <i class="icon-edit"></i></a> 
                  <a onClick="javascript:del('<?php echo $landlord['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td>

                 <td>
                  <?php if($landlord['status']=='0'){?>
                    <a  onClick="javascript:active('<?php echo $landlord['id'];?>');">Click to Activate</a>
                    <?php } else {?>
                    <a  onClick="javascript:inactive('<?php echo $landlord['id'];?>');">Click to deactivate</a>
                  <?php }?>
                </td> 
              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="5">Sorry, no record found.</td>
                  </tr>
                                                        
                                                        <?php
                                                        }
                                                       ?>

                                     </tbody>
                                 </table>
                                  <?php if ($innerPrivileges->listproductcat_delete == '1') { ?>
                                <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
                            <?php } ?>
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
   <!--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <?php if($num>0) {?>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <?php } ?>
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
