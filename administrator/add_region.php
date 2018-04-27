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
	mysqli_query($con,"delete from  webshop_region where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_region.php');
	exit();
}

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update webshop_region set status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_region.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update webshop_region set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_region.php');
	exit();
}

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from webshop_region";
                                                        

 

$record=mysqli_query($con,$sql);


}

if(isset($_REQUEST['submit']))
{

	//$name = isset($_POST['name']) ? $_POST['name'] : '';
	//$description = isset($_POST['description']) ? $_POST['description'] : '';
    $usergrpcat = isset($_POST['usergrpcat']) ? $_POST['usergrpcat'] : '';
    $userstate = isset($_POST['userstate']) ? $_POST['userstate'] : '';
    $usercity = isset($_POST['usercity']) ? $_POST['usercity'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';

   $sqlcontry = mysqli_query($con,"SELECT * FROM countries WHERE `id`='".$usergrpcat."'");
        $result11 = mysqli_fetch_assoc($sqlcontry);
       // echo $result11["countries_name"];
        
        $sqlstate = mysqli_query($con,"SELECT * FROM webshop_state WHERE `id`='".$userstate."'");
        $result22 = mysqli_fetch_assoc($sqlstate);
       //  echo $result22["name"];
        
        $sqlcity = mysqli_query($con,"SELECT * FROM webshop_city WHERE `id`='".$usercity."'");
        $result33 = mysqli_fetch_assoc($sqlcity);
       //  echo $result33["name"];

        $fulladdress = $name.", ".$result33["name"].", ".$result22["name"].", ".$result11["countries_name"];
	       $city_region = $name.", ".$result33["name"];

	$fields = array(
		//'name' => mysqli_real_escape_string($con,$name),
		//'description' => mysqli_real_escape_string($con,$description),
            'country_id' => mysqli_real_escape_string($con,$usergrpcat),
            'state_id' => mysqli_real_escape_string($con,$userstate),
            'city_id' => mysqli_real_escape_string($con,$usercity),
            'name' => mysqli_real_escape_string($con,strtolower($name)),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `webshop_region` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

            $sql11 =mysqli_query($con,"UPDATE `webshop_region` SET `full_address`='".$fulladdress."', `city_region`='".$city_region."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");







		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/categoryimage/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_region` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "City Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating State";
		}

		header('Location:list_region.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `webshop_region` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
			//exit;
		mysqli_query($con,$addQuery);
		echo $last_id=mysqli_insert_id($con); 
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/categoryimage/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_region` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}

      //echo "UPDATE `webshop_region` SET `full_address`='".$fulladdress."' WHERE `id` = '" . $last_id . "'"; exit;

        $sql11 =mysqli_query($con,"UPDATE `webshop_region` SET `full_address`='".$fulladdress."',`city_region`='".$city_region."' WHERE `id` = '" . $last_id . "'");
		 
/*		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:list_region.php');
		exit();
	
	 }
				
				
}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_region` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'City have been deleted successfully.';
        
        //die();
        
        header("Location:list_region.php");
    }

if($_REQUEST['action']=='edit')
{
$categoryRowset =mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_region` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                <?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Region
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                        <li>
                           <a href="#"> Add Region</a>
                           <span class="divider">/</span>
                       </li>

                      
                     <li>
            <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Region </span>
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
                            <h4><i class="fa fa-gift"></i><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Region</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                       <form class="form-horizontal" method="post" action="add_region.php" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                
                                     
                                     
                        <div class="control-group">
                            <label class="control-label">Choose Country</label>
                            <div class="controls">

                            <?php
                            $sql = "SELECT * FROM countries";
                            $result = mysqli_query($con,$sql);
                            ?>
                            <select name="usergrpcat" required="" id="usergrpcat">
                                    <?php 
                               
                            while ($row = mysqli_fetch_array($result)) {?>
                                    <option value="<?php echo $row['id'];?>" <?php if($categoryRowset['country_id']==$row['id']){?> selected="selected"<?php }?>> <?php echo $row['countries_name'];?></option>
                                <?php 
                            }?>
                            </select>                            
                           
                            </div>
                        </div>
                                     
                                     
                        <div class="control-group">
                            <label class="control-label">Choose State</label>
                            <div class="controls">
                                
                            <?php    
                              if($_REQUEST['action']=='edit')
                            {   
                            $result=  mysqli_query($con,"SELECT * FROM `webshop_state` WHERE `country_id`='".mysqli_real_escape_string($con,$categoryRowset['country_id'])."'");  
                                
                            ?>
                            
                         <select name="userstate" required="" id="userstate">
                            <?php 

                            while ($row = mysqli_fetch_array($result)) {?>
                                    <option value="<?php echo $row['id'];?>" <?php if($categoryRowset['state_id']==$row['id']){?> selected="selected"<?php }?>> <?php echo $row['name'];?></option>
                            <?php 
                            }?>
                    </select>
                           
                                
                                
                                
                            <?php }else{?> 
                                
                                
                                <select name="userstate" required="" id="userstate" class="form-control">
                                        <option value="">Choose State</option>    
                                    </select>    
                                   <?php }?> 

                            </div>
                        </div>
                                     
                                     
                                     
                                     
                                     
                                     
                    
                    <div class="control-group">
                            <label class="control-label">Choose City</label>
                            <div class="controls">
                                
                            <?php    
                              if($_REQUEST['action']=='edit')
                            {   
                            $result=  mysqli_query($con,"SELECT * FROM `webshop_city` WHERE `country_id`='".mysqli_real_escape_string($con,$categoryRowset['country_id'])."'");  
                                
                            ?>
                            
                         <select name="usercity" required="" id="usercity">
                            <?php 

                            while ($row = mysqli_fetch_array($result)) {?>
                                    <option value="<?php echo $row['id'];?>" <?php if($categoryRowset['city_id']==$row['id']){?> selected="selected"<?php }?>> <?php echo $row['name'];?></option>
                            <?php 
                            }?>
                    </select>
                           
                                
                                
                                
                            <?php }else{?> 
                                
                                
                                <select name="usercity" required="" id="usercity" class="form-control">
                                        <option value="">Choose City</option>    
                                    </select>    
                                   <?php }?> 

                            </div>
                    </div>
                                     
                                     
                                     
                        <!--<div class="control-group">
                            <label class="control-label">Choose State</label>
                            <div class="controls">

                            <?php
                            $sqllog = "SELECT * FROM webshop_state";
                            $resultlog = mysqli_query($con,$sqllog);
                            ?>
                            <select name="userstate" id="userstate">
                                    <?php 
                            while ($row = mysqli_fetch_array($resultlog)) {?>
                                    <option value="<?php echo $row['id'];?>" <?php if($categoryRowset['state_id']==$row['id']){?> selected="selected"<?php }?>> <?php echo $row['name'];?></option>
                                <?php 
                            }?>
                            </select>


                            </div>
                        </div>-->  
                                     
                                     
                                     
                                <div class="control-group">
                                    <label class="control-label">Region Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text"  value="<?php echo $categoryRowset['name'];?>" name="name" required>
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
   
   
   <script>
    $(document).ready(function(){
    $("#usergrpcat").change(function(){       
     $.get("ajax.php?action=populate_subcat&id="+this.value,function(out){
     $("#userstate").html(out);     
     });    
    })
    
    
    
    $("#userstate").change(function(){       
     $.get("ajax.php?action=populate_subcity&id="+this.value,function(out){
     $("#usercity").html(out);     
     });    
    })
    
    
    
    
    })   
   </script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>