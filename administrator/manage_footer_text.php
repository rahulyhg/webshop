<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


     //$pid=$_REQUEST['id'];
    $sql2="SELECT * FROM `webshop_footer_text_management` where id='1'"; 
    $res=mysqli_query($con,$sql2);
    $row=mysqli_fetch_array($res);

    if(isset($_REQUEST['submit']))
  {
  
  // $sub_heading_english = isset($_POST['sub_heading_english']) ? $_POST['sub_heading_english'] : '';
   $sub_heading_english = isset($_POST['sub_heading_english']) ? $_POST['sub_heading_english'] : '';
   $sub_heading_arabic = isset($_POST['sub_heading_arabic']) ? $_POST['sub_heading_arabic'] : '';
   $text_english = isset($_POST['text_english']) ? $_POST['text_english'] : '';
   $text_arabic = isset($_POST['text_arabic']) ? $_POST['text_arabic'] : '';
   
   
   $fields = array('sub_heading_english' => mysqli_real_escape_string($con,$address),
       'sub_heading_english' => mysqli_real_escape_string($con,$sub_heading_english),
       'sub_heading_arabic' => mysqli_real_escape_string($con,$sub_heading_arabic),
       'text_english' => mysqli_real_escape_string($con,$text_english),
       'text_arabic' => mysqli_real_escape_string($con,$text_arabic)
                  );
     $fieldsList = array();
    foreach ($fields as $field => $value) {
      $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
   // print_r($fieldsList);exit;
   $editQuery = "UPDATE `webshop_footer_text_management` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '1'";

    if (mysqli_query($con,$editQuery)) {
      $_SESSION['msg'] = "Contact info Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating contact info";
    }

    header('Location: manage_footer_text.php');
    exit();
    
  
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
                     Footer Text Management
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Footer Text Management</a>
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
                            <h4><i class="icon-reorder"></i>Footer Text Management</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form action="manage_footer_text.php" class="form-horizontal" method="post"  enctype="multipart/form-data">

                           
                           
                                <div class="control-group">
                                <label class="control-label">Heading</label>
                                <div class="controls">
                                <input type="text" class="form-control" placeholder="" value="<?php echo $row['heading'];?>">
                                </div>
                                </div>
                              
                                <div class="control-group">
                                <label class="control-label">Sub Header(English)</label>
                                <div class="controls">
                                <input type="text" class="form-control" placeholder="Sub Header(English)" value="<?php echo $row['sub_heading_english'];?>" name="sub_heading_english" >
                                </div>
                                </div>
                              
                              <div class="control-group">
                                <label class="control-label">Sub Header(Arabic)</label>
                                <div class="controls">
                                <input type="text" class="form-control" placeholder="Sub Header(Arabic)" value="<?php echo $row['sub_heading_arabic'];?>" name="sub_heading_arabic" >
                                </div>
                                </div>
                              
                                <div class="control-group">
                                <label class="control-label">Content(English)</label>
                                <div class="controls">
                                    <textarea class="form-control" placeholder="Sub Heading(English)" name="text_english" ><?php echo $row['text_english'];?></textarea>
                                </div>
                                </div>
                              
                              <div class="control-group">
                                <label class="control-label">Content(Arabic)</label>
                                <div class="controls">
                                <input type="text" class="form-control" placeholder="Sub Heading(Arabi)" value="<?php echo $row['text_arabic'];?>" name="text_arabic" >
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
