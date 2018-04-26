<?php 
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


if(isset($_REQUEST['submit']))
{
  echo $_REQUEST['id'];
  echo "<br>";
echo $_REQUEST['action']; die;
  
        echo $fname= isset($_POST['fname']) ? $_POST['fname'] : ''; 
        $lname= isset($_POST['lname']) ? $_POST['lname'] : '';
       
        $email= isset($_POST['email']) ? $_POST['email'] : '';
      /*   $landline= isset($_POST['landline']) ? $_POST['landline'] : '';
        $email_secondary= isset($_POST['email_secondary']) ? $_POST['email_secondary'] : '';
        $phone= isset($_POST['phone']) ? $_POST['phone'] : '';
        $address= isset($_POST['address']) ? $_POST['address'] : '';
        $city= isset($_POST['city']) ? $_POST['city'] : '';
         $country= isset($_POST['country']) ? $_POST['country'] : '';
         $state= isset($_POST['state']) ? $_POST['state'] : '';
         $zip= isset($_POST['zip']) ? $_POST['zip'] : '';
        $skype_id= isset($_POST['skype_id']) ? $_POST['skype_id'] : '';
         $gender= isset($_POST['gender']) ? $_POST['gender'] : '';
          $com_sin= isset($_POST['com_sin']) ? $_POST['com_sin'] : '';
          $com_name= isset($_POST['com_name']) ? $_POST['com_name'] : '';
           $company_add1= isset($_POST['company_add1']) ? $_POST['company_add1'] : '';
            $company_add2= isset($_POST['company_add2']) ? $_POST['company_add2'] : ''; */
  $fields = array(
    'fname' => mysqli_real_escape_string($con,$fname),
                'lname' => mysqli_real_escape_string($con,$lname),
                 'email' => mysqli_real_escape_string($con,$email),
               // 'mname' => mysqli_real_escape_string($con,$mname),
           // 'gender' => mysqli_real_escape_string($con,$gender),
               
            /*'email_secondary' => mysqli_real_escape_string($con,$email_secondary),
             'phone' => mysqli_real_escape_string($con,$phone),
            'landline' => mysqli_real_escape_string($con,$landline),
            'address' => mysqli_real_escape_string($con,$address),
             'city' => mysqli_real_escape_string($con,$city),
            'country' => mysqli_real_escape_string($con,$country),
            'state' => mysqli_real_escape_string($con,$state),
            'zip' => mysqli_real_escape_string($con,$zip),
             'com_sin' => mysqli_real_escape_string($con,$com_sin),
            'com_name' => mysqli_real_escape_string($con,$com_name),
            'company_add1' => mysqli_real_escape_string($con,$company_add1),
            'company_add2' => mysqli_real_escape_string($con,$company_add2), */
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
      $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
           
   if($_REQUEST['action']=='edit')
    {     
      echo "aa"; die;
    echo $editQuery = "UPDATE `makeoffer_user` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
      die;
          //exit;

    if (mysqli_query($con,$editQuery)) {
    
    if($_FILES['image']['tmp_name']!='')
    {
    $target_path="../upload/userimage/";
    $userfile_name = $_FILES['image']['name'];
    $userfile_tmp = $_FILES['image']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `makeoffer_user` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
    }
    
    
      $_SESSION['msg'] = "Category Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating Category";
    }

    header('Location:search_user.php');
    exit();
  
   }
   else
   {
   
    $addQuery = "INSERT INTO `makeoffer_directory` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
      
     
    mysqli_query($con,$addQuery);
    $last_id=mysqli_insert_id($con);
    if($_FILES['image']['tmp_name']!='')
    {
    $target_path="../upload/directory/";
    $userfile_name = $_FILES['image']['name'];
    $userfile_tmp = $_FILES['image']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `makeoffer_directory` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
    }
     
/*    if (mysqli_query($con,$addQuery)) {
    
      $_SESSION['msg'] = "Category Added Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while adding Category";
    }
    */
    header('Location:search_user.php');
    exit();
  
   }
        
        
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_user` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                   Faq <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> User</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Faq</a>
                          
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
                            <h4><i class="fa fa-gift"></i>Add Faq</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form action="add_user_type.php" class="form-horizontal" method="post"  enctype="multipart/form-data">

                           
                           
                                
                                <div class="control-group">
                                    <label class="control-label">First Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter Title"  value="<?php echo $categoryRowset['fname']; ?>" name="fname" required>

                                    </div>
                                </div>

                                 <div class="control-group">
                                    <label class="control-label">Last Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter Title"  value="<?php echo $categoryRowset['lname']; ?>" name="lname" required>

                                    </div>
                                </div>


                                 <div class="control-group">
                                    <label class="control-label">Email</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter Title"  value="<?php echo $categoryRowset['email']; ?>" name="email" required>

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
