<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
function getlatlang($address)
{
   
   $data=array();
   $prepAddr=preg_replace('/\s+/', '+',$address);
   
    
    $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='. 				$prepAddr.'&sensor=false&key=AIzaSyDZ31GYS9TcL00rjdGmQiSMZMR0ywh06lA');
   $output= json_decode($geocode);
    $lat = $output->results[0]->geometry->location->lat;
    
   $long = $output->results[0]->geometry->location->lng;
   
   $data['lat']=$lat;
   $data['lang']=$long;
   return $data;
    //return $lat.'||'.$long;
}


if(isset($_REQUEST['submit']))
{
        $package_id = isset($_POST['store_package']) ? $_POST['store_package'] : '';
        $store_cat = isset($_POST['store_cat_id']) ? $_POST['store_cat_id'] : '';
	$store_title = isset($_POST['store_title']) ? $_POST['store_title'] : '';
	$store_details = isset($_POST['store_details']) ? $_POST['store_details'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $location = isset($_POST['location']) ? $_POST['location'] : '';
        $owner = isset($_POST['owner']) ? $_POST['owner'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $ntn = isset($_POST['ntn']) ? $_POST['ntn'] : '';
        $fb_link = isset($_POST['fb_link']) ? $_POST['fb_link'] : '';
        $sk_link = isset($_POST['sk_link']) ? $_POST['sk_link'] : '';
        $vb_link = isset($_POST['vb_link']) ? $_POST['vb_link'] : '';
        $tw_link = isset($_POST['tw_link']) ? $_POST['tw_link'] : '';
	$lat_long = getlatlang($address);

	$fields = array(
                 'package_id' => mysqli_real_escape_string($con,$package_id),
                'store_cat_id' => mysqli_real_escape_string($con,$store_cat),
		'store_title' => mysqli_real_escape_string($con,$store_title),
		'store_details' => mysqli_real_escape_string($con,$store_details),
                'address' => mysqli_real_escape_string($con,$address),
                'owner' => mysqli_real_escape_string($con,$owner),
                'location' => mysqli_real_escape_string($con,$location),
                'email' => mysqli_real_escape_string($con,$email),
                'phone' => mysqli_real_escape_string($con,$phone),
                'ntn' => mysqli_real_escape_string($con,$ntn),
                'fb_link' => mysqli_real_escape_string($con,$fb_link),
                'sk_link' => mysqli_real_escape_string($con,$sk_link),
                'vb_link' => mysqli_real_escape_string($con,$vb_link),
                'tw_link' => mysqli_real_escape_string($con,$tw_link),
                'lat' => $lat_long['lat'],
                'lang' => $lat_long['lang']

		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `makeoffer_store` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/storelogo/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_store` SET `store_photo`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		/*if($_FILES['image1']['tmp_name']!='')
		{
		$target_path="../upload/storebanner/";
		$userfile_name = $_FILES['image1']['name'];
		$userfile_tmp = $_FILES['image1']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_store` SET `store_banner`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}*/
		
			$_SESSION['msg'] = "Store Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_store.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `makeoffer_store` (`" . implode('`,`', array_keys($fields)) . "`) VALUES ('" . implode("','", array_values($fields)) . "')";
			
			//exit;
			
		mysqli_query($con,$addQuery);
		echo $last_id=mysqli_insert_id($con);
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/storelogo/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_store` SET `store_photo`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
                /*if($_FILES['image1']['tmp_name']!='')
		{
		$target_path="../upload/storebanner/";
		$userfile_name = $_FILES['image1']['name'];
		$userfile_tmp = $_FILES['image1']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_store` SET `store_banner`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		
		
		
		header('Location:list_store.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_store` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}


if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_store where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_store.php');
	exit();
}







if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update makeoffer_category set verification_status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_store.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_store set verification_status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_store.php');
	exit();
}



/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_store` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Stores have been deleted successfully.';
        
        //die();
        
        header("Location:list_store.php");
    }


?>
