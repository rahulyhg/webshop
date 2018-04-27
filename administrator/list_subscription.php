<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_subscription where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_subscription.php');
  exit();
}



if (isset($_REQUEST['submit'])) {


   $name = isset($_POST['name']) ? $_POST['name'] : '';
   $price = isset($_POST['price']) ? $_POST['price'] : '';
   $slots = isset($_POST['slots']) ? $_POST['slots'] : '';
   $duration = isset($_POST['duration']) ? $_POST['duration'] : '';

    $fields = array(
        'name' => mysqli_real_escape_string($con,$name),
        'price' => mysqli_real_escape_string($con,$price),
        'slots' => mysqli_real_escape_string($con,$slots),
        'duration' => mysqli_real_escape_string($con,$duration),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
  
       
       
       echo $addQuery = "INSERT INTO `webshop_subscription` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
           header("location:list_subscription.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `webshop_subscription` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_subscription.php");
            $_SESSION['MSG'] = 1;
            exit();
        } else {
           header("location:add_new_admin.php?id=" . $last_id . "&action=edit");
            $_SESSION['MSG'] = 2;
            exit();
        }
        
         
    }
    

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_subscription` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Subscription have been deleted successfully.';
        
        //die();
        
        header("Location:list_subscription.php");
    }

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	mysqli_query($con,"update webshop_subscription set status='0' where id='".$item_id."'");
         header('Location:list_subscription.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	 $item_id=$_GET['cid'];
	mysqli_query($con,"update webshop_subscription set status='1' where id='".$item_id."'");
         header('Location:list_subscription.php');
	exit();
}



if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subscription`"));

}



?>









<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_subscription.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_subscription.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_subscription.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Subscription list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Subscription list</a>
                        
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
                                                          
                <th> Name</th>
               <th> Price</th> 
                <th> Slots</th> 
                <th> Duration</th> 
                <th> Type</th> 
                <th>Quick Links</th>
                <th>Status</th>
              </tr>
            </thead>
        <tbody>
                            <?php
                                                        $fetch_subscription=mysqli_query($con,"select * from webshop_subscription");
                                                        $num=mysqli_num_rows($fetch_subscription);
                                                        if($num>0)
                                                        {
                                                        while($subscription=mysqli_fetch_array($fetch_subscription))
                                                        {
                                                           

                                                        ?>
              
              <tr>
                                                       
                
                <td>
                  <?php echo stripslashes($subscription['name']);?>
                </td>
                
                <td>
                  <?php echo stripslashes($subscription['price']);?>
                </td>
                

                 <td>
                  <?php echo stripslashes($subscription['slots']);?>
                </td>

                 <td>
                  <?php echo stripslashes($subscription['duration']).' Days';?>
                </td>
                
                <td>
                  <?php if($subscription['type']=='N'){echo 'Normal';}else{echo 'Offer';};?>
                </td>
                <td>
                  <a  href="add_subscription.php?id=<?php echo $subscription['id'] ?>&action=edit">
                  <i class="icon-edit"></i></a>
                   <a onClick="javascript:del('<?php echo $subscription['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td>
                
                
               
                 <td>
                  <?php if($subscription['status']=='0'){?>
                    <a  onClick="javascript:active('<?php echo $subscription['id'];?>');">Click to Activate</a>
                    <?php } else {?>
                    <a  onClick="javascript:inactive('<?php echo$subscription['id'];?>');">Click to deactivate</a>
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
                    <td colspan="6">Sorry, no record found.</td>
                  </tr>
                                                        
                                                        <?php
                                                        }
                                                       ?>

                                     </tbody>
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
   <!--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
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
