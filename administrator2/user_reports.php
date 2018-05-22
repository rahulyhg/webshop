<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<!-- <script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="user_reports.php?cid="+ aa +"&action=delete"
      }  
   } 
   </script> -->
<?php


if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{
 
 //$sql="select * from webshop_report ORDER BY id DESC";
                                                        

 

$record=mysqli_query($con,$sql);



}

if(isset($_REQUEST['submit']))
{

  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $description = isset($_POST['description']) ? $_POST['description'] : '';
  

  $fields = array(
    'name' => mysqli_real_escape_string($con,$name),
    'description' => mysqli_real_escape_string($con,$description),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
      $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
           
   if($_REQUEST['action']=='edit')
    {     
    $editQuery = "UPDATE `webshop_report` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

    if (mysqli_query($con,$editQuery)) {
    
    if($_FILES['image']['tmp_name']!='')
    {
    $target_path="../upload/banner/";
    $userfile_name = $_FILES['image']['name'];
    $userfile_tmp = $_FILES['image']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `webshop_report` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
    }
    
    
      $_SESSION['msg'] = "Report Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating Report";
    }

    header('Location:user_reports.php');
    exit();
  
   }

/* if(isset($_GET['action']) && $_GET['action']=='delete')
{
  echo $item_id=$_GET['id']; 
  mysqli_query($con,"delete from  makeoffer_banner where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:user_reports.php');
  exit();
}  */


   else
   {
   
   $addQuery = "INSERT INTO `webshop_report` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
      
      //exit;
    mysqli_query($con,$addQuery);
    $last_id=mysqli_insert_id($con);
    if($_FILES['image']['tmp_name']!='')
    {
    $target_path="../upload/banner/";
    $userfile_name = $_FILES['image']['name'];
    $userfile_tmp = $_FILES['image']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `webshop_report` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
    }
     
/*    if (mysqli_query($con,$addQuery)) {
    
      $_SESSION['msg'] = "Category Added Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while adding Category";
    }
    */
    header('Location:user_reports.php');
    exit();
  
   }
        
        
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_report` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_banner` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM`webshop_report` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:user_reports.php");
    }
?>
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
                    User Reports List
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">user report list</a>
                           <span class="divider">/</span>
                       </li>
                        <li>
                           <a href="#">View report list </a>
                        
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
                            <h4><i class="icon-reorder"></i>User Reports List</h4>
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
               <th>User Name</th>               
             <!--  <th>Reported User</th> -->
               <th>Reported Product Name</th>
               <th>Reason of Report</th>
               <th>Other Report</th>
              <!-- <th>Message</th> -->
              <th>Date</th>
             <!--   <th>Edit</th>          -->   
                
              </tr>
                                     </thead>
                                     <tbody>
                                    <?php
  $sql="select * from webshop_report ORDER BY id DESC";
                                                        

 

$record=mysqli_query($con,$sql);

if(mysqli_num_rows($record)==0)

{?>

                  <tr>

                    <td colspan="3">Sorry, no record found.</td>

                  </tr>

                  <?php 

}

else

{

while($row=mysqli_fetch_object($record))
  {


    
  $proRowset = mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".mysqli_real_escape_string($con,$row->user_id)."'");
  $result = mysqli_fetch_assoc ($proRowset);
  
  $reportuserRowset = mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".mysqli_real_escape_string($con,$row->report_to_user)."'");
  $result1 = mysqli_fetch_assoc ($reportuserRowset);
  
  $reportprodRowset = mysqli_query($con,"SELECT * FROM `webshop_product` WHERE `id`='".mysqli_real_escape_string($con,$row->product_id)."'");
  $result12 = mysqli_fetch_assoc ($reportprodRowset);
  
    
  if($row->image==''){
  $img='../upload/noimage.Jpeg';
  }else{
  $img='../upload/banner/'.$row->image;
  }

  

?>

     <?php //echo $row->id ; ?>         
            <tr>
                                                         <!-- <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id ; ?>"/></td> -->
                <td>
                  <?php echo $result['fname'] ;?> <?php echo $result['lname'] ;?>
                </td>

                
                <td>
                  <?php echo stripslashes($result12['name']);?>
                </td>
                
                
                <td>
                  <?php echo stripslashes($row->offer_report_id);?>
                </td>
                
                
                <td>
                  <?php echo stripslashes($row->other_report);?>
                </td>
                
                
                <td>
                  <?php // echo stripslashes($row->message);?>
                   <?php echo stripslashes($row->date);?>
                </td>
                
              <!--  <td> -->
                 <!--  <a  href="add_reports.php?id=<?php echo $row->id ?>&action=edit">
                  Edit </a> -->
                
                  <!--<a  href="user_reports.php?id=<?php echo $row->id ?>&action=delete"" class="delete">
                  Delete </a>-->
                <!-- </td> -->
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


   <script type="text/javascript">
function deleteConfirm(){
    var result = confirm("Are you sure to delete banner?");
    if(result){
        return true;
    }else{
        return false;
    }
}

$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length)
        {
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
    
 

</script>
<script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</body>
<!-- END BODY -->
</html>
