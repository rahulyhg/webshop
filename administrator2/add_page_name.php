<?php 
error_reporting(E_ALL);
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php


if(isset($_REQUEST['id']))
	{
		$pid=$_REQUEST['id'];
		$sql2="SELECT * FROM `webshop_cms` where id='".$pid."'"; 
		$res=mysqli_query($con,$sql2);
		$row12=mysqli_fetch_array($res);
	}
	
if(isset($_REQUEST['submit']))
{

	//$title=$_REQUEST['cat_name'];
	$pagedetail = isset($_POST['elm1']) ? $_POST['elm1'] : '';
	
	
	$fields = array('pagedetail' => mysqli_real_escape_string($con,$pagedetail));

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

	}	   
	 $editQuery = "UPDATE `webshop_cms` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['pid']) . "'";
		//	exit;

		if (mysqli_query($con,$editQuery)) {
			$_SESSION['msg'] = "CMS Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating CMS";
		}

		header('Location: add_page_name.php?id='.$_REQUEST['pid']);
		exit();
	

				
}


?>

<script language="javascript">
 function submitdata(val)
  {
  //alert("hh");
  document.location.href="add_page_name.php?id="+val;
  }
</script>


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
                 <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> CMS</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">CMS</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> CMS</span>
                          
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
                            <h4><i class="icon-reorder"></i>Cms</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post" action="add_page_name.php" enctype="multipart/form-data">

                         <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                            <input type="hidden" name="menu_id" value="<?php echo $menu_id;?>" />
                            <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                
                                  <div class="control-group">
                                    <label class="control-label">Page Names</label>
                                    <div class="controls">
                                     <select id="selectError" name="pid" onChange="submitdata(this.value);">
                      <option value="">Select One</option>
                      <?php 
                                            $SQL ="SELECT * FROM `webshop_cms` where status=1";
                                            $result = mysqli_query($con,$SQL);
                                            
                                            while($row1=mysqli_fetch_array($result))
                                            { 
                                            ?>
                                            <option value="<?php echo $row1['id']; ?>" <?php if($pid==$row1['id']) { echo "selected";}?> > <?php echo $row1['pagename']; ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                    </div>
                                </div>
                          
                          
<!--<div class="control-group">
    <label class="control-label">Listing Name</label>
    <div class="controls">
    <select name='listingname'>
                    <option value="information" <?php if($categoryRowset['listing_name']=="information") echo 'selected="selected"'; ?> > Information </option>
                    <option value="ourpolicy" <?php if($categoryRowset['listing_name']=="ourpolicy") echo 'selected="ourpolicy"'; ?> > Our Policy </option> 
            </select>
    </div>
</div>-->
                          
                          


<!--<div class="control-group">
    <label class="control-label">Page URL</label>
    <div class="controls">

        <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['title'];?>" name="title" required>
    </div>
</div>  -->                        
                          
                          
                          
                          
                          <div class="control-group">
                                <label class="control-label">Focused Input</label>
                                <div class="controls">
                                     <textarea class="ckeditor form-control" id="editor1" name="elm1" cols="100" rows="20"><?php echo stripslashes($row12['pagedetail']); ?></textarea>
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
   <!--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
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
   
   <script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
