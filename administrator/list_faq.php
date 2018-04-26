<?php
session_start();

include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  makeoffer_faq where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_faq.php');
  exit();
}

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
   mysqli_query($con,"update makeoffer_faq set status='0' where id='".$item_id."'");
  //$_SESSION['msg']=message('updated successfully',1);
  header('Location:list_faq.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"update makeoffer_faq set status='1' where id='".$item_id."'");
  $_SESSION['msg']=message('updated successfully',1);
  header('Location:list_faq.php');
  exit();
}

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_faq  where 1";
                                                        

 

$record=mysqli_query($con,$sql);


}

?>

<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_faq.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_faq.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "list_faq.php?cid=" + aa + "&action=active";
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
                    Faq
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Faq</a>
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
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>List Faq</h4>
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
                                            Title
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Sub Category
                                        </th>
                                        
                                        <th>
                                            Question
                                        </th>
                                        <th>
                                          Answer
                                        </th>
                                        <th>
                                        Date
                                        </th>
                                        
                                        <th>
                                            Edit
                                        </th>

                                        <th>
                                            Delete
                                        </th>
                                        
                                        <th>
                                            Status
                                        </th>
              
                
              </tr>
                                     </thead>
                                     <tbody>
                                 <?php
//  $sql="select * from makeoffer_project_category  where 1";
//$record=mysqli_query($con,$sql);

                                    if (mysqli_num_rows($record) == 0) {
                                        ?>

                                        <tr>

                                            <td colspan="7">Sorry, no record found.</td>

                                        </tr>

                                        <?php
                                    } else {

                                        $count = 1;

                                        while ($row = mysqli_fetch_object($record)) {
                                            
                                            
                                            
                                            $category=mysqli_fetch_assoc(mysqli_query($con,"select * from `makeoffer_faqcategories` where id='".$row->category_id."'"));
                                            
                                            
                                            $Subcategory=mysqli_fetch_assoc(mysqli_query($con,"select * from `makeoffer_faqcategories` where id='".$row->subcategory_id."'"));
                                            
                                            ?>


                                            <tr>
                                                <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id; ?>"/></td> -->  
                                                <td>
                                                    <?php echo stripslashes($row->title); ?>
                                                </td>
                                                <td>
                                                    <?php echo stripslashes($category['name']); ?>
                                                </td>
                                                <td>
                                                    <?php echo stripslashes($Subcategory['name']); ?>
                                                </td>
                                                <td>
                                                    <?php echo stripslashes($row->question); ?>
                                                </td>


                                               <td><?php echo substr($row->answer,0,50); ?></td>
                                                                <td>
                                                <?php echo $row->date; ?>
                                                                </td>
                                                               
                                                <td>
                                                   
                                                        <a onClick="window.location.href = 'add_faq.php?id=<?php echo $row->id ?>&action=edit'">Edit</a>
                                                   
                                                </td>
                                                <td>
                                                   
                                                        <a onClick="javascript:del('<?php echo $row->id; ?>')">Delete</a>
                                                   
                                                </td>
                                                
                                                <td>
                                                    <?php if ($row->status == '0') { ?>
                                                        <a  onClick="javascript:active('<?php echo $row->id; ?>');">Activate</a>
                                                    <?php } else { ?>
                                                        <a onClick="javascript:inactive('<?php echo $row->id; ?>');">Deactivate</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
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
