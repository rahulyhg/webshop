<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
//echo $_SESSION['myy'];

CRYPT_BLOWFISH or die ('No Blowfish found.');




if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

 $sql="select * from webshop_property  where id<>''";
 

$record=mysqli_query($con,$sql);


}

if(isset($_REQUEST['submit']))
{
    
  
  //$name = isset($_POST['name']) ? $_POST['name'] : '';
  //$description= isset($_POST['description']) ? $_POST['description'] : '';
	//$price = isset($_POST['price']) ? $_POST['price'] : '';
	$property_type = isset($_POST['property_type']) ? $_POST['property_type'] : '';
  $amenities_string = implode(', ', $_POST['amenities']);
  $property_postcode = isset($_POST['property_postcode']) ? $_POST['property_postcode'] : '';
  $i_have = isset($_POST['i_have']) ? $_POST['i_have'] : '';
  $i_am = isset($_POST['i_am']) ? $_POST['i_am'] : '';
  $size = isset($_POST['size']) ? $_POST['size'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $street_name = isset($_POST['street_name']) ? $_POST['street_name'] : '';
  $occupants = isset($_POST['occupants']) ? $_POST['occupants'] : '';
  $transport_minutes = isset($_POST['transport_minutes']) ? $_POST['transport_minutes'] : '';
  $transport_by = isset($_POST['transport_by']) ? $_POST['transport_by'] : '';
  $transport_area = isset($_POST['transport_area']) ? $_POST['transport_area'] : '';
  $property_area = isset($_POST['property_area']) ? $_POST['property_area'] : '';
  $post_code = isset($_POST['post_code']) ? $_POST['post_code'] : '';
  $minimum_stay = isset($_POST['minimum_stay']) ? $_POST['minimum_stay'] : '';
  $maximum_stay = isset($_POST['maximum_stay']) ? $_POST['maximum_stay'] : '';
  $living_room = isset($_POST['living_room']) ? $_POST['living_room'] : '';
  $cost_of_room = isset($_POST['cost_of_room']) ? $_POST['cost_of_room'] : '';
  $size_of_room = isset($_POST['size_of_room']) ? $_POST['size_of_room'] : '';
  $amenities_facility = isset($_POST['amenities_facility']) ? $_POST['amenities_facility'] : '';
  $security_amount = isset($_POST['security_amount']) ? $_POST['security_amount'] : '';
  $short_term = isset($_POST['short_term']) ? $_POST['short_term'] : '';
  $days_available = isset($_POST['days_available']) ? $_POST['days_available'] : '';
  $reference = isset($_POST['reference']) ? $_POST['reference'] : '';
  $bills = isset($_POST['bills']) ? $_POST['bills'] : '';
  $broadband = isset($_POST['broadband']) ? $_POST['broadband'] : '';
  $day= isset($_POST['date']) ? $_POST['date'] : '';
  $month = isset($_POST['month']) ? $_POST['month'] : '';
  $year = isset($_POST['year']) ? $_POST['year'] : '';

  $date = $year."-".$month."-".$day;
  $available_date = $date;

  $available_from = $available_date;
       // $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : '';
        
       // $type_string = implode(', ', $_POST['property_type']);
        
        
        //$pass1 = md5($pass);
        
        
 
        

	$fields = array(
    //'name' => mysqli_real_escape_string($con,$name),
    //'description' => mysqli_real_escape_string($con,$description),
		//'price' => mysqli_real_escape_string($con,$price),
    'property_type' => mysqli_real_escape_string($con,$property_type),
    'amenities' => mysqli_real_escape_string($con,$amenities_string),
    'property_postcode' => mysqli_real_escape_string($con,$property_postcode),
    'i_have' => mysqli_real_escape_string($con,$i_have),
    'i_am' => mysqli_real_escape_string($con,$i_am),
    'size' => mysqli_real_escape_string($con,$size),
    'email' => mysqli_real_escape_string($con,$email),
    'street_name' => mysqli_real_escape_string($con,$street_name),
    'occupants' => mysqli_real_escape_string($con,$occupants),
    'transport_minutes' => mysqli_real_escape_string($con,$transport_minutes),
    'transport_by' => mysqli_real_escape_string($con,$transport_by),
    'transport_area' => mysqli_real_escape_string($con,$transport_area),
    'property_area' => mysqli_real_escape_string($con,$property_area),
    'post_code' => mysqli_real_escape_string($con,$post_code),
    'minimum_stay' => mysqli_real_escape_string($con,$minimum_stay),
    'maximum_stay' => mysqli_real_escape_string($con,$maximum_stay),
    'living_room' => mysqli_real_escape_string($con,$living_room),
    'cost_of_room' => mysqli_real_escape_string($con,$cost_of_room),
    'size_of_room' => mysqli_real_escape_string($con,$size_of_room),
    'amenities_facility' => mysqli_real_escape_string($con,$amenities_facility),
    'security_amount' => mysqli_real_escape_string($con,$security_amount),
    'short_term' => mysqli_real_escape_string($con,$short_term),
    'days_available' => mysqli_real_escape_string($con,$days_available),
    'available_from' => mysqli_real_escape_string($con,$available_from),
    'reference' => mysqli_real_escape_string($con,$reference),
    'bills' => mysqli_real_escape_string($con,$bills),
    'broadband' => mysqli_real_escape_string($con,$broadband),
            
		);

 

//print_r($fields);
		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}

    
    

    
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `webshop_property` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

    

      mysqli_query($con,$editQuery_user);

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/property/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_property` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_property.php');
		exit();
	
	 }





	 else
	 {
	 
	$addQuery = "INSERT INTO `webshop_property` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
      //  exit;
  mysqli_query($con,$addQuery);
   $last_id=mysqli_insert_id($con);



//$last_id_user=mysqli_insert_id($con);


			
			//exit;
	
   
	
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/property/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_property` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
/*		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:list_property.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_property` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));
$orderdate = explode('-', $categoryRowset['available_from']);
$year_exploded  = $orderdate[0];
$month_exploded = $orderdate[1];
$day_exploded   = $orderdate[2];
}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_banner` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM`webshop_property` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_property.php");
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
                   Property <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Property</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Property</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Property</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Property</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_property.php" enctype="multipart/form-data">

                          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                          <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />  
                           
                           <!--<div class="control-group">
                                    <label class="control-label">Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name'];?>" name="name" required>
                                    </div>
                                </div>-->
                           <div class="control-group">
                            <label class="control-label">I have</label>
                            <div class="controls">


                                
                             <select name='i_have'>
                                 <option value=''>Please Select</option>
                                 <option value='1 room for rent' <?php if('1 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>1 room for rent</option>
                                 <option value='2 room for rent' <?php if('2 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>2 room for rent</option>
                                 <option value='3 room for rent' <?php if('3 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>3 room for rent</option>
                                 <option value='4 room for rent' <?php if('4 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>4 room for rent</option>
                                 <option value='5 room for rent' <?php if('5 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>5 room for rent</option>
                                 <option value='6 room for rent' <?php if('6 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>6 room for rent</option>
                                 <option value='7 room for rent' <?php if('7 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>7 room for rent</option>
                                 <option value='8 room for rent' <?php if('8 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>8 room for rent</option>
                                 <option value='9 room for rent' <?php if('9 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>9 room for rent</option>
                                 <option value='10 room for rent' <?php if('10 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>10 room for rent</option>
                                 <option value='11 room for rent' <?php if('11 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>11 room for rent</option>
                                 <option value='12 room for rent' <?php if('12 room for rent'==$categoryRowset['i_have']){?> selected="selected" <?php } ?>>12 room for rent</option>
                             </select>
                          </div>
                        </div>

                               <div class="control-group">
                                    <label class="control-label">Size & Type of Property</label>
                                    <div class="controls">
                                   <select name='size'>
                                 <option value=''> Select Size</option>
                                 <option value='2 Bed' <?php if('2 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>2 Bed</option>
                                 <option value='3 Bed' <?php if('3 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>3 Bed</option>
                                 <option value='4 Bed' <?php if('4 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>4 Bed</option>
                                 <option value='5 Bed' <?php if('5 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>5 Bed</option>
                                 <option value='6 Bed' <?php if('6 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>6 Bed</option>
                                 <option value='7 Bed' <?php if('7 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>7 Bed</option>
                                 <option value='8 Bed' <?php if('8 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>8 Bed</option>
                                 <option value='9 Bed' <?php if('9 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>9 Bed</option>
                                 <option value='10 Bed' <?php if('10 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>10 Bed</option>
                                 <option value='11 Bed' <?php if('11 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>11 Bed</option>
                                 <option value='12 Bed' <?php if('12 Bed'==$categoryRowset['size']){?> selected="selected" <?php } ?>>12 Bed</option>
                             </select>
                                        &nbsp;&nbsp;
                                        <?php
                              	

                                $sql = "SELECT * FROM webshop_property_type";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='property_type'>
                                  <option value=''> Select Property Type</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if($row['id']== $categoryRowset['property_type']){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    </div>
                                </div>


                                
                                <div class="control-group">
                                    <label class="control-label">There are already</label>
                                    <div class="controls">
                                    <select name='occupants'>
                                 <option value=''> Select Occupants</option>
                          <option value='1' <?php if(1==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>1</option> 
                          <option value='2' <?php if(2==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>2</option> 
                          <option value='3' <?php if(3==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>3</option> 
                          <option value='4' <?php if(4==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>4</option> 
                          <option value='5' <?php if(5==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>5</option> 
                          <option value='6' <?php if(6==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>6</option> 
                          <option value='7' <?php if(7==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>7</option> 
                          <option value='8' <?php if(8==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>8</option> 
                          <option value='9' <?php if(9==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>9</option> 
                          <option value='10' <?php if(10==$categoryRowset['occupants']){?> selected="selected" <?php } ?>>10</option> 
                             </select> occupants in the property.
                                    </div>
                                </div>
                           
                           
                          <div class="control-group">
                                    <label class="control-label">Postcode of property</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['property_postcode'];?>" name="property_postcode" required>
                                    </div>
                                </div>
                           
                           <div class="control-group">
                                    <label class="control-label">I am</label>
                                    <div class="controls"> 
                                    <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['i_am']){?> checked="checked" <?php } ?> name="i_am">Live in Landlord
                                    <input type="radio" class="form-control"  value="2" <?php if(2==$categoryRowset['i_am']){?> checked="checked" <?php } ?> name="i_am">Live out Landlord
                                    <input type="radio" class="form-control"  value="3" <?php if(3==$categoryRowset['i_am']){?> checked="checked" <?php } ?> name="i_am">Current tenant/flatmate 
                                    </div>
                                </div>
                                
                           
                           <div class="control-group">
                                    <label class="control-label">My Email is</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['email'];?>" name="email" required>
                                    </div>
                                </div>
                          
                          
                          <div class="control-group">
                                    <label class="control-label">Area</label>
                                    <div class="controls">
                                        <?php
                                

                                $sql = "SELECT * FROM webshop_property_area";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='property_area'>
                                  <option value=''> Select Area</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['area_name'];?>'  <?php if($row['area_name']== $categoryRowset['property_area']){?> selected="selected"<?php }?>><?php echo $row['area_name'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    </div>
                                </div>
                          
                          
                        
                        <div class="control-group">
                                    <label class="control-label">Street Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter Street Name" value="<?php echo $categoryRowset['street_name'];?>" name="street_name" required>
                                    </div>
                                </div>
                          
                          <div class="control-group">
                                    <label class="control-label">Post Code</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter Post Code" value="<?php echo $categoryRowset['post_code'];?>" name="post_code" required>
                                    </div>
                                </div>
                          
                          
                          <div class="control-group">
                                    <label class="control-label">Transport</label>
                                    <div class="controls">
                                   <select name='transport_minutes'>
                                 <option value=''> Select...</option>
                                 <option value='0-5' <?php if('0-5'==$categoryRowset['transport_minutes']){?> selected="selected" <?php } ?>>0-5</option>
                                 <option value='5-10' <?php if('5-10'==$categoryRowset['transport_minutes']){?> selected="selected" <?php } ?>>5-10</option>
                                 <option value='10-15' <?php if('10-15'==$categoryRowset['transport_minutes']){?> selected="selected" <?php } ?>>10-15</option>
                                 <option value='15-20' <?php if('15-20'==$categoryRowset['transport_minutes']){?> selected="selected" <?php } ?>>15-20</option>
                                 <option value='20-25' <?php if('20-25'==$categoryRowset['transport_minutes']){?> selected="selected" <?php } ?>>20-25</option>
                                 <option value='25+' <?php if('25+'==$categoryRowset['transport_minutes']){?> selected="selected" <?php } ?>>25+</option>
                           </select>minutes
                             
                                       <select name='transport_by'>
                                 <option value=''> Select...</option>
                                  <option value='walk' <?php if('walk'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>walk</option> 
                                  <option value='by car' <?php if('by car'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>by car</option>
                                  <option value='by bus' <?php if('by bus'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>by bus</option>
                                  <option value='by tram' <?php if('by tram'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>by tram</option>                                    
                             </select>from
                                                                     <?php
                                

                                $sql = "SELECT * FROM webshop_property_area";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='transport_area'>
                                  <option value=''> Select...</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['area_name'];?>'  <?php if($row['area_name']== $categoryRowset['transport_area']){?> selected="selected"<?php }?>><?php echo $row['area_name'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    </div>
                                </div>
                       <div class="control-group">
                                    <label class="control-label">Living Room?</label>
                                    <div class="controls">
                                    <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['living_room']){?> checked="checked" <?php } ?> name="living_room">Yes,there is a shared living room 
                                     <input type="radio" class="form-control"  value="0"  <?php if(0==$categoryRowset['living_room']){?> checked="checked" <?php } ?> name="living_room">No
                                    
                                    </div>
                                </div>
                          
                        <!-- <div class="control-group">
                            <label class="control-label">Select amenities</label>
                            <div class="controls">


                                <?php
                                $allselectedcat=explode(',',$categoryRowset['amenities']);	

                                $sql = "SELECT * FROM webshop_amenities";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='amenities[]' multiple>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedcat)){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                                    <?php 
                                }?>

                             </select>


                            </div>
                        </div> -->

                         <div class="control-group">
                            <label class="control-label">Select amenities</label>
                            <div class="controls">


                                <?php
                                $allselectedcat=explode(',',$categoryRowset['amenities']);  

                                $sql = "SELECT * FROM webshop_amenities";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='amenities[]' multiple>
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
                                    <label class="control-label">Cost of Room</label>
                                    <div class="controls">
                                    $
                                    <input type="radio" class="form-control"  value="2"  <?php if(2==$categoryRowset['cost_of_room']){?> checked="checked" <?php } ?> name="cost_of_room">per week
                                     <input type="radio" class="form-control"  value="1"  <?php if(1==$categoryRowset['cost_of_room']){?> checked="checked" <?php } ?> name="cost_of_room">per calendar month
                                    
                                    </div>
                                </div>

                          <div class="control-group">
                                    <label class="control-label">Size of Room</label>
                                    <div class="controls">
                                    <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['size_of_room']){?> checked="checked" <?php } ?> name="size_of_room">Single
                                     <input type="radio" class="form-control"  value="2" <?php if(2==$categoryRowset['size_of_room']){?> checked="checked" <?php } ?> name="size_of_room">Double
                                    
                                    </div>
                                </div>

                          <div class="control-group">
                                    <label class="control-label">Amenties</label>
                                    <div class="controls">
                                    <input type="checkbox" class="form-control"  value="1" <?php if(1==$categoryRowset['amenities_facility']){?> checked="checked" <?php } ?> name="amenities_facility">Ensuite(tick if room has own toilet and/or bath/shower)<br>
                                     <input type="checkbox" class="form-control"  value="2" <?php if(2==$categoryRowset['amenities_facility']){?> checked="checked" <?php } ?> name="amenities_facility">Furnished
                                    
                                    </div>
                                </div>
                          
                          <div class="control-group">
                                    <label class="control-label">Security Deposit</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter amount" value="<?php echo $categoryRowset['security_amount'];?>" name="security_amount" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Available from</label>
                                    <div class="controls">
                                   <select name='date'>
                                 <option value=''> Select Date</option>
                                 <?php
                                 for($i=1;$i<=31;$i++)
                                 { ?>
                             	 <option value=<?php echo $i; ?> <?php if($i==$day_exploded){?> selected="selected" <?php } ?>><?php echo $i; ?></option> 
                                 <?php 
                             }
                                 ?>
                            
                                     
                                    
                                    
                            </select>&nbsp;&nbsp;
                             
                             <select name='month'>
                                 <option value=''> Select...</option>
                                  <option value='01' <?php if('01'==$month_exploded){?> selected="selected" <?php } ?>>Jan</option> 
                                   <option value='02' <?php if('02'==$month_exploded){?> selected="selected" <?php } ?>>Feb</option> 
                                    <option value='03' <?php if('03'==$month_exploded){?> selected="selected" <?php } ?>>Mar</option> 
                                     <option value='04' <?php if('04'==$month_exploded){?> selected="selected" <?php } ?>>Apr</option> 
                                      <option value='05' <?php if('05'==$month_exploded){?> selected="selected" <?php } ?>>May</option> 
                                       <option value='06' <?php if('06'==$month_exploded){?> selected="selected" <?php } ?>>Jun</option> 
                                        <option value='07' <?php if('07'==$month_exploded){?> selected="selected" <?php } ?>>July</option> 
                                         <option value='08' <?php if('08'==$month_exploded){?> selected="selected" <?php } ?>>Aug</option> 
                                          <option value='09' <?php if('09'==$month_exploded){?> selected="selected" <?php } ?>>Sept</option> 
                                           <option value='10' <?php if('10'==$month_exploded){?> selected="selected" <?php } ?>>Oct</option> 
                                            <option value='11' <?php if('11'==$month_exploded){?> selected="selected" <?php } ?>>Nov</option> 
                                             <option value='12' <?php if('12'==$month_exploded){?> selected="selected" <?php } ?>>Dec</option> 
                                 <!--  <option value='by car' <?php if('by car'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>by car</option>
                                  <option value='by bus' <?php if('by bus'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>by bus</option>
                                  <option value='by tram' <?php if('by tram'==$categoryRowset['transport_by']){?> selected="selected" <?php } ?>>by tram</option>  -->                                   
                             </select>
                                      <!--  <?php
                                
                                $sql = "SELECT * FROM webshop_month";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='month'>
                                  <option value=''> Select Month</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if($row['id']== $categoryRowset['month']){?> selected="selected"<?php }?>><?php echo $row['month'];?></option>
                                    <?php 
                                } ?>

                             </select> -->

                             <!-- <select name='year'>
                                 <option value=''> Select Year</option>
                                  <option value='2018'>2018</option>
                                 <option value='2017'>2017</option>
                                                                  
                                    
                                    

                             </select>
                                           --> 
                                           <select name='year'>
                                 <option value=''> Select...</option>
                                  <option value='2018' <?php if('2018'==$year_exploded){?> selected="selected" <?php } ?>>2018</option> 
                                  <option value='2017' <?php if('2017'==$year_exploded){?> selected="selected" <?php } ?>>2017</option>
                                  
                             </select>

                              </div>
                                </div>


                               <div class="control-group">
                                    <label class="control-label">Minimum Stay</label>
                                    <div class="controls">
                                   <?php
                                

                                $sql = "SELECT * FROM webshop_stay";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='minimum_stay'>
                                  <option value=''> No Minimum</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['months'];?>'  <?php if($row['months']== $categoryRowset['minimum_stay']){?> selected="selected"<?php }?>><?php echo $row['months'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Maximum Stay</label>
                                    <div class="controls">
                                   <?php
                                

                                $sql = "SELECT * FROM webshop_stay";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='maximum_stay'>
                                  <option value=''> No Maximum</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['months'];?>'  <?php if($row['months']== $categoryRowset['maximum_stay']){?> selected="selected"<?php }?>><?php echo $row['months'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Short Term Lets Considered?</label>(i.e. 1 week to 3 months)
                                    <div class="controls">
                                    <input type="checkbox" class="form-control"  value="1" <?php if(1==$categoryRowset['short_term']){?> checked="checked" <?php } ?> name="short_term">Tick for Yes(You may wish to specify rent differences in the description further down)
                                    </div>
                                </div>

                                 <div class="control-group">
                                    <label class="control-label">Days Available</label><br>
                                    <div class="controls">
                                    <input type="checkbox" class="form-control"  value="1" <?php if(1==$categoryRowset['days_available']){?> checked="checked" <?php } ?> name="days_available">Tick for Yes(You may wish to specify rent differences in the description further down)
                                    </div>
                                </div>

                                  <div class="control-group">
                                    <label class="control-label">References required?</label>
                                    <div class="controls">
                                    <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['reference']){?> checked="checked" <?php } ?> name="reference">Yes
                                     <input type="radio" class="form-control"  value="0" <?php if(0==$categoryRowset['reference']){?> checked="checked" <?php } ?> name="reference">No
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Bills included </label>
                                    <div class="controls">
                                    <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['bills']){?> checked="checked" <?php } ?> name="bills">Yes
                                     <input type="radio" class="form-control"  value="0" <?php if(0==$categoryRowset['bills']){?> checked="checked" <?php } ?> name="bills">No
                                     <input type="radio" class="form-control"  value="2" <?php if(2==$categoryRowset['bills']){?> checked="checked" <?php } ?> name="bills">Some
                                    </div>
                                </div>

                                 <div class="control-group">
                                    <label class="control-label">Broadband included?</label>
                                    <div class="controls">
                                    <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['broadband']){?> checked="checked" <?php } ?> name="broadband">Yes
                                     <input type="radio" class="form-control"  value="0" <?php if(0==$categoryRowset['broadband']){?> checked="checked" <?php } ?> name="broadband">No
                                    </div>
                                </div>

                                <!-- <div class="control-group">
                                    <label class="control-label">Smoking</label>
                                    <div class="controls">
                                   <select name='smoking'>
                                 <option value=''> Select </option>
                            <option value='Yes'>Yes</option>
                              <option value='No'>No</option>
                              </select>
                                    
                                 
                                    </div>
                                </div>

                                 <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <div class="controls">
                                   <select name='smoking'>
                                 <option value=''> Select Gender</option>
                            <option value='Male'>Male</option>
                              <option value='Female'>Female</option>
                              </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Occupation</label>
                                    <div class="controls">
                                  <?php
                                

                                $sql = "SELECT * FROM webshop_occupation";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='occupation'>
                                  <option value=''> Select</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if($row['id']== $categoryRowset['occupation']){?> selected="selected"<?php }?>><?php echo $row['occupation'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Pets</label>
                                    <div class="controls">
                                   <select name='pets'>
                                 <option value=''> Select </option>
                            <option value='No'>No</option>
                              <option value='Yes'>Yes</option>
                              </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Age</label>
                                    <div class="controls">
                                   <select name='age'>
                                 <option value=''> Select </option>
                            <option value='16'>16</option>
                              <option value='17'>17</option>
                              <option value='18'>18</option>
                              <option value='19'>19</option>
                              <option value='20'>20</option>
                              </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Language</label>
                                    <div class="controls">
                                                                    <?php
                                

                                $sql = "SELECT * FROM webshop_language";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='language'>
                                  <option value=''> Select...</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if($row['id']== $categoryRowset['language']){?> selected="selected"<?php }?>><?php echo $row['language'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Nationality</label>
                                    <div class="controls">
                                   <?php
                                

                                $sql = "SELECT * FROM webshop_nationality";
                                $result = mysqli_query($con,$sql);
                                ?>
                             <select name='nationality'>
                                  <option value=''> Select...</option>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if($row['id']== $categoryRowset['nationality']){?> selected="selected"<?php }?>><?php echo $row['nationality'];?></option>
                                    <?php 
                                } ?>

                             </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Sexual Orientation</label>
                                    <div class="controls">
                                   <select name='sex_orientation'>
                                 <option value=''> Select </option>
                            <option value='Not disclosed'>Not disclosed</option>
                              <option value='Straight'>Straight</option>
                              <option value='Mixed Share'>Mixed Share</option>
                              <option value='Gay/Lesbian'>Gay/Lesbian</option>
                              <option value='Bi-Sexual'>Bi-Sexual</option>
                              </select>
                                    
                                 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                    <input type="checkbox" class="form-control"  value="1" name="living_room">Yes,I would like my orientation to form part of my advert,search criteria and allow others to search on this field.
                                   
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Interests</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter interests" value="<?php echo $categoryRowset['interests'];?>" name="interests" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Couples Welcome?</label>
                                    <div class="controls">
                                    <input type="radio" class="form-control"  value="1" name="couples">No
                                     <input type="radio" class="form-control"  value="1" name="couples">Yes
                                     </div>
                                     *specify rent adjustments in your ad description on next page
                                </div> -->

                           <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                        <input type="file" name="image" class=" btn blue"  >
                                        
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
