<?php 
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php

if(isset($_REQUEST['submit']))
{

  $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
  $user_id1 = implode(',', $user_id);

  

	 $fields = array(
    'user_id' => mysqli_real_escape_string($con,$user_id1),
          
	 	);

	 $fieldsList =array();
	 foreach($fields as $field => $value){
	 	$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

	 } 
         
         //if($_REQUEST['action']=='edit')
	 // {		  
	$editQuery = "UPDATE `webshop_subscription` SET " . implode(', ', $fieldsList)
			. " WHERE `type` = 'O'";
         //exit;

		if (mysqli_query($con,$editQuery)) {
		$_SESSION['msg'] = "Subscription Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occured while updating Subscription";
		}

		//header('Location:add_user_offer.php');
		//exit();
          }
          
//}


//if($_REQUEST['action']=='edit')
//{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subscription` WHERE `type`='O' limit 1"));

//}

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
                   Special Subscription <small>Add Special Subscription</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Special Subscription</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span>Add Special Subscription</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Special Subscribers</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post">
         

                                <div class="control-group">
                                    <label class="control-label">Users</label>
                                    <div class="controls">
                                       <?php
                                        $users = mysqli_query($con, "select * from webshop_user where type=2 ");
                                        
                                        $i = 0;
                                        if (empty($categoryRowset)) {
                                            while ($user_array = mysqli_fetch_array($users)) {
                                                
                                                if ($i > 2) {
                                                    echo "</br>";
                                                    echo "</br>";
                                                    $i = 0;
                                                }
                                                ?>
                                                <input class="form-check-input" type="checkbox"  name="user_id[]" value="<?php echo $user_array['id']; ?>"  >&nbsp<?php echo ($user_array['fname'].' '. $user_array['lname']); ?>&nbsp;&nbsp&nbsp;
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            $edit_user = explode(',', $categoryRowset['user_id']);
                                            while ($user_array = mysqli_fetch_array($users)) {
                                                if ($i > 2) {
                                                    echo "</br>";
                                                    echo "</br>";
                                                    $i = 0;
                                                }
                                                ?>
                                                <input class="form-check-input" type="checkbox"  name="user_id[]" value="<?php echo $user_array['id']; ?>" <?php
                                                if (in_array($user_array['id'], $edit_user)) {
                                                    echo 'checked';
                                                }
                                                ?>  >&nbsp<?php echo ($user_array['fname'].' '. $user_array['lname']); ?>&nbsp;&nbsp&nbsp;
                                                       <?php
                                                       $i++;
                                                   }
                                               }
                                               ?>
                                        
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
