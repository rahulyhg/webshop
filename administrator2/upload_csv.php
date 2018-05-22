<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php

if(isset($_POST['submit']))
{
    
   //echo 'san'; 
   //exit;
   
   
    
    
   
									 					 
	ini_set('auto_detect_line_endings', true);
	
    
    
	if($_FILES['file_image']['tmp_name']!='')
    {
		$target_path="../upload/csv/";
		$userfile_name = $_FILES['file_image']['name'];
		$userfile_tmp = $_FILES['file_image']['tmp_name'];
		$img_name =time().$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
    }
   
   
   //echo '<pre>';
    $handle = fopen($target_path.$img_name,"r"); 
   // print_r($handle);
    
    
    
    
    $i=1;
    while($data = fgetcsv($handle,0,",","'"))
    {
		
		if($i>1)
		{
			
			
			
			
			//$product_id =$data[0];
			$Product_Name =trim($data[0]);
			
			
			$Product_Name=preg_replace('/\s+/', ' ',$Product_Name);
			
			  
			$parent_id=0;
                        $status=1;
			   $url = $data[1];
            $imageName = end(explode('/', $url));
            $img = '../upload/category_image/' . $imageName;
            file_put_contents($img, file_get_contents($url));
		    
			
			 
			
			 if($Product_Name!="" )
            {
            
            	   $fields = array(
                'name' => $Product_Name,
                'status' => $status,
                 'parent_id' => $parent_id,
                
               );


		        $fieldsList = array();
		        foreach ($fields as $field => $value) {
		            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		        }
		        
		        
		        $addQuery = "INSERT INTO `webshop_category` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";
				    			
				 
				    mysqli_query($con,$addQuery);
                                  
				   $last_id = mysqli_insert_id($con);
                                   //echo $last_id;
                                  //echo "UPDATE `webshop_category` SET `image`='".$imageName."' WHERE `id` = '" . $last_id . "'";
                                 // exit;
                                  $imagee =mysqli_query($con,"UPDATE `webshop_category` SET `image`='".$imageName."' WHERE `id` = '" . $last_id . "'");
                                 
				   
				  //$instmoreiamge = "insert into `alibabademo_moreimage`(`id`,`pro_id`,`image`) values('','" . $last_id . "','" . $imageName . "')";
				  
				 
				   // mysql_query($instmoreiamge);
            
           
            }   
         
		    
		      
		 
		  
	 
		    }
			

       
	   $i++;
    }
	
	 
	
    fclose($handle);
    
    
	  header("location:upload_csv.php");
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
                   Category <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Category</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Category</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Category</span>
                          
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
                        <a style="float:right;" class="btn blue" href="sampledownload.csv">Download Sample</a>
                            <h4><i class="icon-reorder"></i>Add Category</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="upload_csv.php" enctype="multipart/form-data">

                          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                          <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />  
                           
                           <!--<div class="control-group">
                                    <label class="control-label">Category Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name'];?>" name="name" required>
                                    </div>
                                </div>-->

                                 <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                        <input type="file" name="file_image" class=" btn blue"  >
                                        
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
    <script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
