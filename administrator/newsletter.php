<?php 
include_once("./includes/config.php");
?>
<!-- 
<?php

if(isset($_REQUEST['submit']))
{
   
     $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
     $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
     $address = isset($_POST['address']) ? $_POST['address'] : '';
     $email = isset($_POST['email']) ? $_POST['email'] : '';
     $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    



     $fields = array(
        'fname' => mysqli_real_escape_string($con,$fname),
        'lname' => mysqli_real_escape_string($con,$lname),
        'address' => mysqli_real_escape_string($con,$address),
        'email' => mysqli_real_escape_string($con,$email),
        'phone' => mysqli_real_escape_string($con,$phone),
        );

     $fieldsList =array();
     foreach($fields as $field => $value){
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

     } 
         
         if($_REQUEST['action']=='edit')
      {       
    $editQuery = "UPDATE `webshop_landlord` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
         //exit;

        if (mysqli_query($con,$editQuery)) {
        $_SESSION['msg'] = "Category Updated Successfully";
        }
        else {
            $_SESSION['msg'] = "Error occuried while updating Category";
        }

        header('Location:list_landlord.php');
        exit();
          }
          else
          {
  
     $insertQuery = "INSERT INTO `webshop_landlord` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')";
    
             mysqli_query($con,$insertQuery);

       header('Location:list_landlord.php');
       exit();
          }
}


if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_landlord` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}

?> -->

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
                   Landlord <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Landlord</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Landlord</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Landlord</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Landlord</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">              
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" />

                                <div class="form-body">

                                    


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Subject</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="subject" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Message</label>
                                        <div class="col-md-4">
                                            <textarea id="editor1" class="form-control" name="description" cols="55" rows="10" style="height:120px;width:450px;"></textarea>
                                        </div>
                                    </div>


                                    <!--                                        <div class="form-actions">
                                                                              <button name="submit" type="submit" class="btn btn-primary">Send</button>
                                                                             
                                                                            </div>-->
                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" value="Send" class="btn blue">
                                            <!--                                            <button type="submit" class="btn blue"  name="submit">Submit</button>-->
                                            <!-- <button type="button" class="btn default" onClick="location.href = 'javascript:void(0);'">Cancel</button> -->
                                        </div>
                                    </div>
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
