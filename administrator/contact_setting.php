<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


     //$pid=$_REQUEST['id'];
    $sql2="SELECT * FROM `webshop_contact_info` where id='1'"; 
    $res=mysqli_query($con,$sql2);
    $row=mysqli_fetch_array($res);

    if(isset($_REQUEST['submit']))
  {
  
   
   $address = isset($_POST['address']) ? $_POST['address'] : '';
   $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   
   
   $fields = array('address' => mysqli_real_escape_string($con,$address),
       'phone' => mysqli_real_escape_string($con,$phone),
       'email' => mysqli_real_escape_string($con,$email)
                  );
     $fieldsList = array();
    foreach ($fields as $field => $value) {
      $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
   // print_r($fieldsList);exit;
   $editQuery = "UPDATE `webshop_contact_info` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '1'";

    if (mysqli_query($con,$editQuery)) {
      $_SESSION['msg'] = "Contact info Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating contact info";
    }

    header('Location: contact_setting.php');
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
                     Contact Information settings
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Contact Information settings</a>
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
                            <h4><i class="icon-reorder"></i>Contact Information Settings</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form action="contact_setting.php" class="form-horizontal" method="post"  enctype="multipart/form-data">

                           
                           
                                
                                <div class="control-group">
                                <label class="control-label">Address</label>
                                <div class="controls">
                                    <textarea class="form-control" placeholder="Enter address" name="address" ><?php echo $row['address'];?></textarea>
                                </div>
                                </div>
                              
                              <div class="control-group">
                                <label class="control-label">Phone</label>
                                <div class="controls">
                                <input type="text" class="form-control" placeholder="Enter phone no" value="<?php echo $row['phone'];?>" name="phone" >
                                </div>
                                </div>
                              
                              <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                <input type="email" class="form-control" placeholder="Enter email" value="<?php echo $row['email'];?>" name="email" >
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
