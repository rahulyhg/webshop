<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
 <?php
if(isset($_REQUEST['submit']))

{



  $alt_text = isset($_POST['alt_text']) ? $_POST['alt_text'] : '';  



  $fields = array(

    'alt_text' => mysqli_real_escape_string($con,$alt_text)

    );



    $fieldsList = array();

    foreach ($fields as $field => $value) {

      $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

    }

           



        

    $editQuery = "UPDATE `webshop_sitesettings` SET " . implode(', ', $fieldsList)

      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";



    if (mysqli_query($con,$editQuery)) {

    

    if($_FILES['image']['tmp_name']!='')

    {

    $target_path="../upload/site_logo/";

    $userfile_name = $_FILES['image']['name'];

    $userfile_tmp = $_FILES['image']['tmp_name'];

    $img_name =time().$userfile_name;

    $img=$target_path.$img_name;

    move_uploaded_file($userfile_tmp, $img);

    

    $image =mysqli_query($con,"UPDATE `webshop_sitesettings` SET `sitelogo`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");

    }
    else{
     $img_name=$_REQUEST['hid_logo']; 
      
    }

    

    

      $_SESSION['msg'] = "Category Updated Successfully";

    }

    else {

      $_SESSION['msg'] = "Error occuried while updating Category";

    }



    header('Location:site_logo.php');

    exit();

  

   

    

}



$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_sitesettings` WHERE `id`='1'"));




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
                     Manage Logo
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
                       <li class="active">
                           Manage Logo
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
                            <h4><i class="icon-reorder"></i>     Manage Logo</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form class="form-horizontal" method="post" action="site_logo.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                            <input type="hidden" name="id" value="1" />
                            <input type="hidden" name="hid_logo" value="<?php echo $categoryRowset['sitelogo'];?>">
                            <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                <div class="control-group">
                                    <label class="control-label">Logo</label>
                                    <!-- <div class="controls" style="background: -webkit-linear-gradient(#ef640b, #ea4912); width: 23%;"> -->
                                     <div class="controls" style="background:#ccc; width: 23%;">
                                       <img src="../upload/site_logo/<?php echo $categoryRowset['sitelogo'];?>"  align="image">
                                      
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Alt Image Text</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['alt_text'];?>" name="alt_text" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                        <input type="file" name="image" class=" btn blue"  >
                                        
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

   <!-- Footer End -->
 <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
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