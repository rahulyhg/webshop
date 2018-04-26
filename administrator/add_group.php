<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  webshop_group where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_group.php');
	exit();
}

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update webshop_group set status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_group.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update webshop_group set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_group.php');
	exit();
}

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from webshop_group  where `is_category`=1";
                                                        

 

$record=mysqli_query($con,$sql);


}

if(isset($_REQUEST['submit']))
{
        
		//$grpct = isset($_POST['usergrpcat']) ? $_POST['usergrpcat'] : '';
		$name = isset($_POST['prname']) ? $_POST['prname'] : '';
		$description = isset($_POST['ppdescription']) ? $_POST['ppdescription'] : '';
                $feature_home = isset($_POST['feature_home']) ? $_POST['feature_home'] : '';
                $feature_group = isset($_POST['feature_group']) ? $_POST['feature_group'] : '';
                $discover_group = isset($_POST['discover_group']) ? $_POST['discover_group'] : '';
		
		$user_string = implode(',', $_POST['us']);
                
                $prodcat_string = implode(',', $_POST['product_cat']);       
                
                $group_cat = implode(',', $_POST['group_cat']);
                
                $grp_tag = isset($_POST['grp_tag']) ? $_POST['grp_tag'] : '';
                $tag_results = strtolower(preg_replace('/[\s,]+/', ',', $grp_tag));
                
                
                
                
                
        
        //$price = isset($_POST['pprc']) ? $_POST['pprc'] : '';
	

	$fields = array(
		'name' => mysqli_real_escape_string($con,$name),
		'description' => mysqli_real_escape_string($con,$description),                
                'user_list' => mysqli_real_escape_string($con,$user_string),
                
                'product_cat' => mysqli_real_escape_string($con,$prodcat_string),
            
            
                'group_cat' => mysqli_real_escape_string($con,$group_cat),
                'grp_tag' => mysqli_real_escape_string($con,$tag_results),
                
                'feature_home' => mysqli_real_escape_string($con,$feature_home),
                'feature_group' => mysqli_real_escape_string($con,$feature_group),
                'discover_group' => mysqli_real_escape_string($con,$discover_group),
                //'regular_price' => mysqli_real_escape_string($con,$price),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `webshop_group` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
			
		//	exit;

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/group/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_group` SET `img`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Group Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_group.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `webshop_group` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
         
         
         
			//exit;
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
                
                
//$sql = "INSERT INTO webshop_group_members(group_id,user_id) VALUES ('$last_id',$user_string)";
//$result = mysqli_query($con,$sql);
                
                
                
                
                
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/group/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_group` SET `img`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
/*		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:list_group.php');
		exit();
                
                
                
                
        
                
                
	
	 }
				
				
}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_group` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Group have been deleted successfully.';
        
        //die();
        
        header("Location:list_group.php");
    }

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_group` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                New Group
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                        <li>
                           <a href="#"> New Group</a>
                           <span class="divider">/</span>
                       </li>

                      
                     <li>
            <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Group</span>
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
                            <h4><i class="fa fa-gift"></i><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Group</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                       <form class="form-horizontal" method="post" action="add_group.php" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                
                                
                                     
                               <!--<div class="control-group">
                                    <label class="control-label">Select Group Category</label>
                                    <div class="controls">
                                    
                                    <?php
                                    $sql = "SELECT * FROM webshop_grpcategory";
                                    $result = mysqli_query($con,$sql);
                                    ?>
                                        <select name='usergrpcat'>
                                            <?php 
                                    while ($row = mysqli_fetch_array($result)) {?>
                                            <option value="<?php echo $row['id'];?>" <?php if($categoryRowset['group_cat']==$row['id']){?> selected="selected"<?php }?>> <?php echo $row['name'];?></option>
                                        <?php 
                                    }?>
                                  </select>
                                      
                                        
                                    </div>
                                </div>-->
                                     
                            
                                     
                                     
                        <div class="control-group">
                            <label class="control-label">Select Product Category</label>
                            <div class="controls">


                                <?php
                              $allselectedcat=explode(',',$categoryRowset['product_cat']);	

                                $sql = "SELECT * FROM webshop_category";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='product_cat[]' multiple>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedcat)){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                                    <?php 
                                }?>

                             </select>


                            </div>
                        </div>
                               
                               
                                     
                                     
                                <div class="control-group">
                                    <label class="control-label">Group Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" name="prname" value="<?php echo $categoryRowset['name'] ?>" required>
                                    </div>
                                </div>
                                     

                                  <div class="control-group">
                                    <label class="control-label">Group Description</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" name="ppdescription" value="<?php echo $categoryRowset['description'] ?>" required>
                                    </div>
                                </div>
                                     
                                     
                                <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                   <input type="file" name="image" class=" btn blue"  ><?php if($categoryRowset['img']!=''){?><br><a href="../upload/group/<?php echo $categoryRowset['img'];?>" target="_blank">View</a><?php }?>
                                    </div>
                                </div>
                                     
                                     
                                     
            <!--<div class="control-group">
                <label class="control-label">User List</label>
                <div class="controls">
                                        
                                        
                <?php
                $allselectedList=explode(',',$categoryRowset['user_list']);	

                $sql = "SELECT * FROM webshop_user";
                $result = mysqli_query($con,$sql);
                ?>
                <select name='us[]' multiple>
                    <?php 
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedList)){?> selected="selected"<?php } ?>><?php echo $row['fname'];?></option>
                    <?php } ?>
                </select>


                </div>
            </div>-->
                               
                         
                               
                               
                               
                               
                               
                               
                               
                               
                <!--<div class="control-group">
                    <label class="control-label">Tags name</label>
                    <div class="controls">
                               
                           
                <textarea name="grp_tag"><?php echo $categoryRowset['grp_tag']; ?></textarea>
                        
                        
                        
                                     
                    </div>
                </div>-->
                                     
                
                
                
                <?php 
          
          if($_SESSION['status'] == '1'){ ?>
                
                
                
                
                    <div class="control-group">
                    <label class="control-label">Group Category List</label>
                    <div class="controls">


                    <?php
                       $allselectedList=explode(',',$categoryRowset['group_cat']);	

                    $sql = "SELECT * FROM webshop_grpcategory WHERE status=''";
                    $result = mysqli_query($con,$sql);
                    ?>
                 <select name='group_cat[]' multiple>
                    <?php 
                    while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedList)){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                        <?php 
                    }?>

                  </select>


                    </div>
                    </div>
                    
                
                
                
                
                
                
                
                
                
                <?php }else{ ?>
                
                
                
                    <div class="control-group">
                    <label class="control-label">Group Category List</label>
                    <div class="controls">


                    <?php
                       $allselectedList=explode(',',$categoryRowset['group_cat']);	

                    $sql = "SELECT * FROM webshop_grpcategory WHERE status=''";
                    $result = mysqli_query($con,$sql);
                    ?>
                 <select name='group_cat[]' multiple>
                    <?php 
                    while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedList)){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                        <?php 
                    }?>

                  </select>


                    </div>
                    </div>
                
                
                
                
                <?php } ?>
                
                               
                               
                               
                               
                               
                               
                               
                                     
                                     
                                     
                    <!--<div class="control-group">
                        <label class="control-label">Featured for home page</label>
                        <div class="controls">

<input type="checkbox"  name="feature_home"  value="Yes" <?php if($categoryRowset['feature_home']=='Yes') { ?> checked="checked" <?php } ?> >
                        
                        </div>
                    </div>
                          
                                     
                                     
                                     
                    <div class="control-group">
                        <label class="control-label">Featured for group page</label>
                        <div class="controls">

                        <input type="checkbox"  name="feature_group"  value="Yes" <?php if($categoryRowset['feature_group']=='Yes') { ?> checked="checked" <?php } ?> >
                        
                        </div>
                    </div>
                                     
                                     
                                     
                    <div class="control-group">
                        <label class="control-label">Discover Group for group page</label>
                        <div class="controls">

                        <input type="checkbox"  name="discover_group"  value="Yes" <?php if($categoryRowset['discover_group']=='Yes') { ?> checked="checked" <?php } ?> >
                        
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