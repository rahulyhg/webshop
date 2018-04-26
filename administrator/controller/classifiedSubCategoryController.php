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
	mysqli_query($con,"delete from  makeoffer_classified_subcat where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location: list_classified_subcat.php');
	exit();
}

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update makeoffer_classified_subcat set status='0' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: list_classified_subcat.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_classified_subcat set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: list_classified_subcat.php');
	exit();
}




if(isset($_REQUEST['submit']))
{

	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	$title= isset($_POST['title']) ? $_POST['title'] : '';
	$description= isset($_POST['description']) ? $_POST['description'] : '';

	$fields = array(
                'cat_id' => mysqli_real_escape_string($con,$cat_id),
				'title' => mysqli_real_escape_string($con,$title),
                'description' => mysqli_real_escape_string($con,$description),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `makeoffer_classified_subcat` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/classified/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_classified_subcat` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_classified_subcat.php');
		exit();
	
	 }
	 else
	 {
	 
	  $addQuery = "INSERT INTO `makeoffer_classified_subcat` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
		
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/classified/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_classified_subcat` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 

		header('Location:list_classified_subcat.php');
		exit();
	
	 }
				
				
}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
            // echo "UPDATE `makeoffer_classified_subcat` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM  `makeoffer_classified_subcat` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Subcategory have been deleted successfully.';
        
        //die();
        
        header("Location:list_classified_subcat.php");
    }

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_classified_subcat` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}
?>
