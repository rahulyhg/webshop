<?php 
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php

if(isset($_REQUEST['submit']))
{
   $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
   $price = isset($_POST['price']) ? $_POST['price'] : '';
   $slot = isset($_POST['slot']) ? $_POST['slot'] : '';
   $expire_month = isset($_POST['expire_month']) ? $_POST['expire_month'] : '';

   $fields = array(
   	 'title' => mysqli_real_escape_string($con,$title),
     'description' => mysqli_real_escape_string($con,$description),
     'price' => mysqli_real_escape_string($con,$price),
     'slot' => mysqli_real_escape_string($con,$slot),
     'expire_month' => mysqli_real_escape_string($con,$expire_month),
    );

   $fieldsList =array();
   foreach($fields as $field => $value){
    $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

   } 
         
         if($_REQUEST['action']=='edit')
    {     
     $editQuery = "UPDATE `webshop_membership` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
        // exit;

    if (mysqli_query($con,$editQuery)) {
                    
                   // echo "aa";
                   // exit;
                    
                   // echo "aa".$_FILES['imagee']['tmp_name']; exit;
                    
                    if(!empty($_FILES['imagee']['tmp_name']))
    {
                         //echo "aa";
                  // exit;
    $target_path="../upload/product_image/";
    $userfile_name = $_FILES['imagee']['name'];
    $userfile_tmp = $_FILES['imagee']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
   $image =mysqli_query($con,"UPDATE `webshop_membership` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
               // exit;
    }
    $_SESSION['msg'] = "Category Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating Category";
    }

    header('Location:list_membership.php');
    exit();
          }
          else
          {
  
     $insertQuery = "INSERT INTO `webshop_membership` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
    
       mysqli_query($con,$insertQuery);
                          $last_id=mysqli_insert_id($con);
                         
                         if($_FILES['imagee']['tmp_name']!='')
    {
    $target_path="../upload/auction_image/";
    $userfile_name = $_FILES['imagee']['name'];
    $userfile_tmp = $_FILES['imagee']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `webshop_membership` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
    }

       header('Location:list_membership.php');
       exit();
          }
}


if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_membership` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                    Membership <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?>  Membership</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#"> Membership</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Membership</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Membership</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                              <div class="control-group">
                                    <label class="control-label">Title</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter title" value="<?php echo $categoryRowset['title'];?>" name="title" required>
                                    </div>
                                </div>

                              <!--    <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                      <textarea rows="4" cols="50" class="ckeditor form-control" placeholder="Enter text" name ="description"><?php echo $categoryRowset['description'];?></textarea> 
                                    </div>
                                </div>
 -->
                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter price" value="<?php echo $categoryRowset['price'];?>" name="price" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Slots</label>
                                    <div class="controls">
                                    <input type="number" class="form-control" placeholder="Enter slot" value="<?php echo $categoryRowset['slot'];?>" name="slot" required>
                                    </div>
                                </div>

                                 <div class="control-group">
                                    <label class="control-label">Expire Month</label>
                                    <div class="controls">
                             <select name="expire_month" required>
                             <option value=''> Select Month</option>
                                <option value='1'  <?php if('1'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>1</option>
                                <option value='2'  <?php if('2'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>2</option>
                                <option value='3'  <?php if('3'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>3</option>
                                <option value='4'  <?php if('4'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>4</option>
                                <option value='5'  <?php if('5'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>5</option>
                                <option value='6'  <?php if('6'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>6</option>
                                 <option value='7'  <?php if('7'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>7</option>
                                  <option value='8'  <?php if('8'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>8</option>
                                   <option value='9'  <?php if('9'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>9</option>
                                    <option value='10'  <?php if('10'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>10</option>
                                     <option value='11'  <?php if('11'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>11</option>
                                      <option value='12'  <?php if('12'== $categoryRowset['expire_month']){?> selected="selected"<?php }?>>12</option>
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
    <script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->

   <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script src="assets/chart-master/Chart.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>
   <script src="js/jquery.datepicker.js"></script>
  <link href="css/jquery.datepicker.css" rel="stylesheet">

   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->

   <script src="js/easy-pie-chart.js"></script>
   <script src="js/sparkline-chart.js"></script>
   <script src="js/home-page-calender.js"></script>
   <script src="js/home-chartjs.js"></script>
  <script>
    $(document).ready(function () {
       $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<script>
    $(document).ready(function () {
       $("#datepickerr").datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
 <script>
   function getSubCategory(val) {
  $.ajax({
  type: "POST",
  url: "get_subcategory.php",
  data:'category_id='+val,
  success: function(data){
    $("#subcategory_list").html(data);
  }
  });
}
   </script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
