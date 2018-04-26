<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
 mysqli_query("set symbol 'utf8'");
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_products where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_auction.php');
  exit();
}



if (isset($_REQUEST['submit'])) {


   $name = isset($_POST['name']) ? $_POST['name'] : '';
  

    $fields = array(
        'name' => mysqli_real_escape_string($con,$name),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
  
       
       
       echo $addQuery = "INSERT INTO `webshop_products` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
            
             header("location:list_auction.php");
           //header("location:list_tools.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `webshop_products` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_auction.php");
            $_SESSION['MSG'] = 1;
            exit();
        } else {
           header("location:add_new_admin.php?id=" . $last_id . "&action=edit");
            $_SESSION['MSG'] = 2;
            exit();
        }
        
         
    }
    

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_products` WHERE `status`='1'"));

}

?>


<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_auction.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_auction.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_auction.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">List Auction Requests</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">List Auction Requests</a>
                        
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
                        <h4><i class="icon-reorder"></i>List Auction Requests</h4>
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
                
                 <th>User Image</th>           
                 <th>User Name</th>
                 <th>Price</th>
                 <th>Brand</th>
                 <th>Size</th>
                 <th>Owner Number</th>
                 <th>Admin Approval</th>
                 <th>Quick Links</th>
                 <th>Details</th>
                 
              </tr>
            </thead>
        <tbody>
                            <?php
                                   

    if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_auction set approved='0' where id='".$item_id."'");
         header('Location:list_auction.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_auction set approved='1' where id='".$item_id."'");

  $get_current_date =date('Y-m-d');

  $getuploaderid = mysqli_fetch_array(mysqli_query($con,"SELECT * from webshop_auction where id='".$item_id."'"));
  $requestor_id = $getuploaderid['user_id'];

  $getProductName = mysqli_fetch_array(mysqli_query($con,"SELECT * from webshop_products where id='" .$getuploaderid['product_id']. "'"));
    $productName = $getProductName['name'];
    $getMinimumBid = $getProductName['price'];

  $getpercentage = mysqli_fetch_array(mysqli_query($con,"SELECT * from webshop_sitesettings"));
  
    $payment_amount = ceil(($getMinimumBid *$getpercentage['threshold_price_percent'])/100);

    $auctionfees =mysqli_query($con,"UPDATE `webshop_auction` SET `auction_fee`='".$payment_amount."' WHERE `id` = '" .$item_id. "'"); 

$requestor_notification = mysqli_query($con,"INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','".$requestor_id."','Product for Auction Approved','Your Product ".$productName." has been approved for auction. You need to pay  $".$payment_amount." as auction fee to make your product Go Live.','".$get_current_date."','0','".$item_id."')");
  

       $getAllUsers = mysqli_query($con,"SELECT * from webshop_user where type= '1'");
    $getrows = mysqli_num_rows($getAllUsers);
     if($getrows > 0){

      while($get_all_users = mysqli_fetch_array($getAllUsers)){

        mysqli_query($con,"INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','".$get_all_users['id']."','Product Added for Auction','A Product ".$productName." has been added for auction.','".$get_current_date."','0','0')");
      }
    }

         header('Location:list_auction.php');
  exit();
}





                                                     $fetch_tools_type=mysqli_query($con,"select * from  webshop_auction where status = 0");
                                                        $num=mysqli_num_rows($fetch_tools_type);
                                                        if($num>0)
                                                        {
                                                        while($tools_type=mysqli_fetch_array($fetch_tools_type))
                                                        {
                                                            

                                                            


$uploader = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$tools_type['user_id']."'"));


                                                           
    if($uploader['image']!='')
    {
    $image_link='../upload/user_image/'.$uploader['image'];
    }
    else {
    $image_link='../upload/no.jpg';
    }

                                                        ?>
              
              <tr>
                  
             
               
                <td>
                 <img src="<?php echo $image_link;?>" height="100" width="100" align="image">
                </td>

               <td>
                   <?php echo $uploader['fname'].$uploader['lname'];?>
                </td>

                

                <td>
                   $<?php echo stripslashes($tools_type['price']);?>
                </td>
                
                 <td>
                   <?php echo stripslashes($tools_type['brand']);?>
                </td>
                
                 <td>
                   <?php echo stripslashes($tools_type['size']);?>
                </td>
                
                <td>
                   <?php echo stripslashes($tools_type['owner_number']);?>
                </td>

                    <td>
                  <?php if($tools_type['approved']=='0'){?>
                    <a  onClick="javascript:active('<?php echo $tools_type['id'];?>');">Click to Activate</a>
                    <?php } else {?>
                    <a  onClick="javascript:inactive('<?php echo $tools_type['id'];?>');">Click to deactivate</a>
                  <?php }?>
                </td>

                   <td>
                   	<?php if($tools_type['approved']=='1'){?>
                  <a  href="add_auction.php?id=<?php echo $tools_type['id'] ?>&action=edit"  >
                  <i class="icon-edit"></i><?php } ?></a> 
                  <a onClick="javascript:del('<?php echo $tools_type['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td>
              
              <td>

                    <a  href="details_auction.php?id=<?php echo $tools_type['id'] ?>&action=details"><i class="icon-eye-open"></i></a>
                  
                </td> 

                  

              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="9">Sorry, no record found.</td>
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
   <?php if ($num>0){?>
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
