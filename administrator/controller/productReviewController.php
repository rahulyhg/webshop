<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');


if(isset($_REQUEST['submit']))
{
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $review = isset($_POST['review']) ? $_POST['review'] : '';
        $rate = isset($_POST['rate']) ? $_POST['rate'] : '';
	

	$fields = array(
                 'title' => mysqli_real_escape_string($con,$title),
                'review' => mysqli_real_escape_string($con,$review),
		'rate' => mysqli_real_escape_string($con,$rate),
		

		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `makeoffer_rate_review` SET " . implode(', ', $fieldsList)
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
		
		$image =mysqli_query($con,"UPDATE `makeoffer_rate_review` SET `store_photo`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Review Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Review";
		}

		header('Location:list_review_product.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `makeoffer_rate_review` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
			//exit;
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/storelogo/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_rate_review` SET `store_photo`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
     
		header('Location:list_review_product.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_rate_review` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}

if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_rate_review where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location: list_review_product.php');
	exit();
}


if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_rate_review  where id<>0  order by id desc ";
                                                        

 

$record=mysqli_query($con,$sql);


}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_rate_review`  WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Review have been deleted successfully.';
        
        //die();
        
        header("Location:list_review_product.php");
    }


?>
