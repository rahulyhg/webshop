<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php


if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

 $sql="select * from makeoffer_banner  where id<>''";
                                                        

 

$record=mysqli_query($con,$sql);


}

if(isset($_REQUEST['submit']))
{

	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';
	

	$fields = array(
		'name' => mysqli_real_escape_string($con,$name),
		'description' => mysqli_real_escape_string($con,$description),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `makeoffer_banner` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/banner/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_banner` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_banner.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `makeoffer_banner` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
			//exit;
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/banner/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_banner` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
/*		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:list_banner.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_banner` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_banner` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM`makeoffer_banner` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_banner.php");
    }
?>