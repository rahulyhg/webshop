<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
//echo $_SESSION['myy'];

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

 $sql="select * from webshop_tbladmin  where id<>''";
                                                        

 

$record=mysqli_query($con,$sql);


}

if(isset($_REQUEST['submit']))
{
  
    $fname = isset($_POST['name']) ? $_POST['name'] : '';
      $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
	$name = isset($_POST['admin_username']) ? $_POST['admin_username'] : '';
	$pass = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';
        $mail = isset($_POST['email']) ? $_POST['email'] : '';        
        $prevname_string = implode(', ', $_POST['userprevname']);
        
        
        //$grpevnt_string = implode(', ', $_POST['userevntname']);
        
        $pass1 = md5($pass);
	

	$fields = array(
    'name' => mysqli_real_escape_string($con,$fname),
    'lname' => mysqli_real_escape_string($con,$lname),
		'admin_username' => mysqli_real_escape_string($con,$name),
		'admin_password' => mysqli_real_escape_string($con,$pass1),
                'txt_pwd' => mysqli_real_escape_string($con,$pass),
                'email' => mysqli_real_escape_string($con,$mail),                
                'privilege_name' => mysqli_real_escape_string($con,$prevname_string),
            
                //'user_event_name' => mysqli_real_escape_string($con,$grpevnt_string),
            
		);

 


//print_r($fields);
		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}

    				 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `webshop_tbladmin` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";


      mysqli_query($con,$editQuery_user);

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/banner/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_tbladmin` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_admin.php');
		exit();
	
	 }





	 else
	 {
	 
	 $addQuery = "INSERT INTO `webshop_tbladmin` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
  mysqli_query($con,$addQuery);
   $last_id=mysqli_insert_id($con);



//$last_id_user=mysqli_insert_id($con);


			
			//exit;
	
   
	
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/banner/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_tbladmin` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
/*		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:list_admin.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_tbladmin` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_banner` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM`webshop_tbladmin` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_admin.php");
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
                   Admin <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Admin</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Admin</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Admin</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Admin</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_new_admin.php" enctype="multipart/form-data">

                          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                          <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />  
                           
                           <div class="control-group">
                                    <label class="control-label">First Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name'];?>" name="name" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Last Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['lname'];?>" name="lname" required>
                                    </div>
                                </div>


                                
                                <div class="control-group">
                                    <label class="control-label">User Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['admin_username'];?>" name="admin_username" required>
                                    </div>
                                </div>
                          
                                <div class="control-group">
                                    <label class="control-label">User Password</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['txt_pwd'];?>" name="admin_password" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">User Email</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['email'];?>" name="email" required>
                                    </div>
                                </div>
                          
                          
                          
                          
                          
                        
<div class="control-group">
<label class="control-label">Select Menu List</label>
    <div class="controls">
        
        <?php
        $allselectedcat=explode(',',$categoryRowset['privilege_name']);	

        $sql = "SELECT * FROM webshop_previlege";
        $result = mysqli_query($con,$sql);
        ?>
        <select name='userprevname[]' multiple>
           <?php 
           while ($row = mysqli_fetch_array($result)) {
                                               ?>
       <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedcat)){?> selected="selected"<?php }?>><?php echo $row['privilege_name'];?></option>
               <?php 
           }?>

        </select>
        
        
        

    </div>
</div>
                          
                          
                          
                          
                        
                          
                        <!--<div class="control-group">
                            <label class="control-label">Select Event List</label>
                            <div class="controls">


                                <?php
                                $allselectedcat=explode(',',$categoryRowset['user_event_name']);	

                                $sql = "SELECT * FROM wave_event";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='userevntname[]' multiple>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedcat)){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                                    <?php 
                                }?>

                             </select>


                            </div>
                        </div>-->
                                

                                
                              
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