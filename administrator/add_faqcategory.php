<?php
//include_once("controller/categoryController.php");
include_once("./includes/session.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if($_REQUEST['submit'])
{
    extract($_REQUEST);
    if($_FILES['image']['tmp_name']!='')
        {
            
            $pathpart=pathinfo($_FILES['image']['name']);
            $ext=$pathpart['extension'];
            $extensionValid = array('jpg','jpeg','png','gif');
	    if(in_array(strtolower($ext),$extensionValid)){
            $target_path="../upload/faqcat/";
            $userfile_name = $_FILES['image']['name'];
            $userfile_tmp = $_FILES['image']['tmp_name'];
            $img_name = uniqid().'.'.$ext;
            $img=$target_path.$img_name;
            move_uploaded_file($userfile_tmp, $img);
            
            }  
       }
       else
       {
           $img_name=$_REQUEST['hideimage'];
       }
    
    
    $fields = array(
		'name' => mysqli_real_escape_string($con,$name),
		'parent_id' => mysqli_real_escape_string($con,$parent_id),
		'image' => mysqli_real_escape_string($con,$img_name),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
                
                
    if(!empty($_REQUEST['id']))
	  {		  
	  $editQuery = "UPDATE `makeoffer_faqcategories` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

		if (mysqli_query($con,$editQuery)) {
                    header('Location:list_faq_category.php');
                    exit();
                    }
		

		
	
	 }
	 else
	 {
	 
	  $addQuery = "INSERT INTO `makeoffer_faqcategories` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
		header('Location:list_faq_category.php');
		exit();
	
	 }            
    
}

$sql=mysqli_query($con,"select * from `makeoffer_faqcategories` WHERE parent_id=0");
$categoryRowset=mysqli_fetch_assoc(mysqli_query($con,"select * from `makeoffer_faqcategories` where id='".$_REQUEST['id']."'"));
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
                Faq Category
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                        <li>
                           <a href="#"> Faq Category</a>
                           <span class="divider">/</span>
                       </li>

                      
                     <li>
            <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Faq Category</span>
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
                            <h4><i class="fa fa-gift"></i><?php echo $_REQUEST['id']=='edit'?"Edit":"Add";?> Faq Category</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                       <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                            <input type="hidden" name="hideimage" value="<?php echo $categoryRowset['image'];?>" />
                                <div class="control-group">
                                    <label class="control-label">Category Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text"  value="<?php echo $categoryRowset['name'];?>" name="name" required>
                                    </div>
                                </div>

                                  <div class="control-group">
                                    <label class="control-label">Parent</label>
                                    <div class="controls">
                                        <select class="form-control" name="parent_id">
                                        <option value="">Choose Parent</option>    
                                        <?php
                                        while($parents=mysqli_fetch_assoc($sql))
                                        {
                                        ?>
                                        <option value="<?php  echo $parents['id'] ?>" <?php echo $parents['id']==$categoryRowset['parent_id']?'selected':'' ?>  ><?php  echo $parents['name'] ?></option>    
                                        <?php }?>    
                                        </select>   
                                    </div>
                                </div>
                               <div class="control-group">
                                    <label class="control-label">Image</label>
                                    <div class="controls">
                                    <input type="file" class="form-control"  name="image">
                                    </div>
                                </div>
                            <div class="control-group" style=" display:<?php echo empty($categoryRowset['image'])?'none':''?>;">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <img src="../upload/faqcat/<?php echo $categoryRowset['image'];?>" style=" height:100px; width:100px">    
                                    </div>
                                </div>
                              
                                <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit" value="submit"><i class="icon-ok"></i> Save</button>
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