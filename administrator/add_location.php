<?php 
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php

if(isset($_REQUEST['submit']))
{
   
   $country_id = isset($_POST['country_list']) ? $_POST['country_list'] : '';
   $state_id = isset($_POST['states_list']) ? $_POST['states_list'] : '';
   $city_id = isset($_POST['city_list']) ? $_POST['city_list'] : '';

   $fields = array(
    'country_id' => mysqli_real_escape_string($con,$country_id),
    'state_id' => mysqli_real_escape_string($con,$state_id),
    'city_id' => mysqli_real_escape_string($con,$city_id)
    );

   $fieldsList =array();
   foreach($fields as $field => $value){
    $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

   } 
         
         if($_REQUEST['action']=='edit')
    {     
     $editQuery = "UPDATE `webshop_locations` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
          mysqli_query($con,$editQuery);

    header('Location:manage_location.php');
    exit();
          }
          else
          {
  
     $insertQuery = "INSERT INTO `webshop_locations` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
    
       mysqli_query($con,$insertQuery);

       header('Location:manage_location.php');
       exit();
          }
}


if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_locations` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                    Location <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?>  Location</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#"> Location</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Location</span>
                          
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
                            <h4><i class="icon-reorder"></i>Edit Location</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
         

                             <div class="control-group">
                                    <label class="control-label">Country</label>
                                    <div class="controls">
                                        <?php
                                

                                $sql = "SELECT * FROM webshop_countries";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='country_list' id="country_list" onChange="getStateList(this.value);" required>
                                  <option value=''> Select Country</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if($row['id']== $categoryRowset['country_id']){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">State</label>
                                    <div class="controls">
                                    
                             <select name='states_list' id= 'states_list' onChange="getCityList(this.value);">
                             </select>
                                    </div>
                                </div>

                               <div class="control-group">
                                    <label class="control-label">City</label>
                                    <div class="controls">
                                    
                             <select name='city_list' id= 'city_list'>
                                 
                             </select>
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
    <script>
   function getStateList(val) {
  $.ajax({
  type: "POST",
  url: "get_states.php",
  data:'country_id='+val,
  success: function(data){
    $("#states_list").html(data);
  }
  });
}
   </script>
<script>
   function getCityList(val) {
  $.ajax({
  type: "POST",
  url: "get_states.php",
  data:'state_id='+val,
  success: function(data){
    $("#city_list").html(data);
  }
  });
}
   </script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
