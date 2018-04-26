<?php 
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php

if(isset($_REQUEST['submit']))
{
   
   $name = isset($_POST['name']) ? $_POST['name'] : '';
   $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
   $price = isset($_POST['price']) ? $_POST['price'] : '';
   $description = isset($_POST['description']) ? $_POST['description'] : '';
   $add_date = date('Y-m-d');
   $status = 1;

   $fields = array(
    'name' => mysqli_real_escape_string($con,$name),
    'duration' => mysqli_real_escape_string($con,$duration),
    'price' => mysqli_real_escape_string($con,$price),
    'description' => mysqli_real_escape_string($con,$description),
     'add_date' => mysqli_real_escape_string($con,$add_date),
     'status'=> mysqli_real_escape_string($con,$status)
    );

   $fieldsList =array();
   foreach($fields as $field => $value){
    $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

   } 
         
         if($_REQUEST['action']=='edit')
    {     
     $editQuery = "UPDATE `webshop_advertisement` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
        // exit;

    if (mysqli_query($con,$editQuery)) {
                    
                   // echo "aa";
                   // exit;
                    
                   // echo "aa".$_FILES['imagee']['tmp_name']; exit;
                    
                    if(!empty($_FILES['video']['tmp_name']) AND ($_FILES["video"]["type"] == "video/mp4"))
    {
                         //echo "aa";
                  // exit;
    $target_path="../upload/advertisement_video/";
    $userfile_name = $_FILES['video']['name'];
    $userfile_tmp = $_FILES['video']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
   $image =mysqli_query($con,"UPDATE `webshop_advertisement` SET `video`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
               // exit;
    }
    $_SESSION['msg'] = "Category Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating Category";
    }

    header('Location:list_advertisement.php');
    exit();
          }
          else
          {
  
     $insertQuery = "INSERT INTO `webshop_advertisement` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
    
       mysqli_query($con,$insertQuery);
                          $last_id=mysqli_insert_id($con);
                         
                         if($_FILES['video']['tmp_name']!='')
    {
    $target_path="../upload/advertisement_video/";
    $userfile_name = $_FILES['video']['name'];
    $userfile_tmp = $_FILES['video']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `webshop_advertisement` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
    }

       header('Location:list_advertisement.php');
       exit();
          }
}


if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_advertisement` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                    Advertisement <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?>  Advertisement</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#"> Advertisement</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Advertisement</span>
                          
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
                            <h4><i class="icon-reorder"></i>Edit Advertisement</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                  <div class="control-group">
                                    <label class="control-label">Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter name"  name="name" value="<?php echo $categoryRowset['name'];?>" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                <textarea rows="4" cols="50" class="ckeditor form-control" placeholder="Enter text" name ="description"><?php echo $categoryRowset['description'];?></textarea>
                                </div> 
                                </div>
                             <!--    <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                    <input type="text" class="ckeditor form-control" placeholder="Enter description"  name="description" value="<?php echo $categoryRowset['description'];?>" required>
                                    </div>
                                </div> -->

                                 <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter price"  name="price" value="<?php echo $categoryRowset['price'];?>" required>
                                    </div>
                                </div>

                                  <div class="control-group">
                                    <label class="control-label">Duration</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter duration"  name="duration" value="<?php echo $categoryRowset['duration'];?>" required>
                                    </div>
                                </div>

                                   <div class="control-group">
                                    <label class="control-label">Video Upload</label>
                                    <div class="controls">
                                        <input type="file" name="video" class=" btn blue"  ><?php if($categoryRowset['video']!=''){?><br><a href="../upload/advertisement_video/<?php echo $categoryRowset['video'];?>" target="_blank">View</a><?php }?>
                                        
                                    </div>
                                </div>

         <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Save</button>
                                    <button type="reset" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                </div>
                            </form>
                            <!-- END FORM-->
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
    <script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>
   <!-- Footer End -->
    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
  <!--  <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
   <script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
   <script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>

   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->

   <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script src="assets/chart-master/Chart.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->

   <script src="js/easy-pie-chart.js"></script>
   <script src="js/sparkline-chart.js"></script>
   <script src="js/home-page-calender.js"></script>
   <script src="js/home-chartjs.js"></script>
  
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
