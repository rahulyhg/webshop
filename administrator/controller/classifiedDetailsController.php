<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');


if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_classfied_details where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location: list_classified_details.php');
	exit();
}

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update makeoffer_classified_details set status='0' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: list_classified_details.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_classified_details set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: list_classified_details.php');
	exit();
}


if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_classfied_details  where 1";
 

$record=mysqli_query($con,$sql);


}



if (isset($_REQUEST['submit'])) {



		$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
		$subcat = isset($_POST['subcat']) ? $_POST['subcat'] : '';
		$title= isset($_POST['title']) ? $_POST['title'] : '';
		$phone= isset($_POST['phone']) ? $_POST['phone'] : '';
		$zip= isset($_POST['zip']) ? $_POST['zip'] : '';
		$city= isset($_POST['city']) ? $_POST['city'] : '';
		$address= isset($_POST['address']) ? $_POST['address'] : '';
		$establish_on= isset($_POST['establish_on']) ? $_POST['establish_on'] : '';
		$price= isset($_POST['price']) ? $_POST['price'] : '';
		$description= isset($_POST['description']) ? $_POST['description'] : '';
		$datee=date('d-m-y');
		 $action = isset($_POST['action']) ? $_POST['action'] : '';
		$fields = array(
		'cat_id' => mysqli_real_escape_string($con,$cat_id),
		'sub_cat_id' => mysqli_real_escape_string($con,$subcat),
		'name' => mysqli_real_escape_string($con,$title),
		'zip' => mysqli_real_escape_string($con,$zip),
		'city' => mysqli_real_escape_string($con,$city),
		'price' => mysqli_real_escape_string($con,$price),
		'description' => mysqli_real_escape_string($con,$description),
		'address' => mysqli_real_escape_string($con,$address),
		'establish_on' => mysqli_real_escape_string($con,$establish_on),
		'phone' => mysqli_real_escape_string($con,$phone),
		'date' => mysqli_real_escape_string($con,$datee),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
		$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
		
		
		if ($action == 'add' || $action == '') {
		
			 $addQuery = "INSERT INTO `makeoffer_classfied_details` (`" . implode('`,`', array_keys($fields)) . "`)"
				. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
				//exit;
			mysqli_query($con,$addQuery);
			$last_id=mysqli_insert_id($con);
			
			 if ($last_id != "" || $last_id != 0) {
        
        
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {


 if ($_FILES['images']['tmp_name'][$i] != '') {
        $target_path = "../upload/product/";
      $userfile_name = $_FILES['images']['name'][$i];
       
        $store_logo_image = $_FILES['images']['name'][$i];
        $userfile_tmp = $_FILES['images']['tmp_name'][$i];
        $store_logo = time().$userfile_name;
        $img = $target_path .$store_logo;
        move_uploaded_file($userfile_tmp, $img);
        
           $video_link = basename($inv_video);
                $date_added = date('y-m-d h:i:s');



               $query_image = "INSERT INTO `makeoffer_moreimage` 
				  (pro_id,image)  
				  VALUES ('" . $last_id . "','" . $store_logo . "')";

                $res_image = mysqli_query($con,$query_image);
        
        
        
				} 



			}





		$_SESSION['msg'] = "Details Insertded Successfully";
           header("location:list_classified_details.php");
           
            exit();
        } else {
        
        $_SESSION['msg'] = "Details Not Insertded Successfully";
           header("location:list_classified_details.php");
           
            exit();
        }
		
		}
		else if($action == 'edit'){
		$last_id = $_REQUEST['id'];
		$editQuery = "UPDATE `makeoffer_product` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";

		$res = mysqli_query($con,$editQuery);
        if ($res) {
        
               for ($i = 0; $i < count($_FILES['images']['name']); $i++) {


 if ($_FILES['images']['tmp_name'][$i] != '') {
        $target_path = "../upload/product/";
      $userfile_name = $_FILES['images']['name'][$i];
       
        $store_logo_image = $_FILES['images']['name'][$i];
        $userfile_tmp = $_FILES['images']['tmp_name'][$i];
        $store_logo = time().$userfile_name;
        $img = $target_path .$store_logo;
        move_uploaded_file($userfile_tmp, $img);
        
           $video_link = basename($inv_video);
                $date_added = date('y-m-d h:i:s');



               $query_image = "INSERT INTO `makeoffer_moreimage` 
				  (pro_id,image)  
				  VALUES ('" . $last_id . "','" . $store_logo . "')";

                $res_image = mysqli_query($con,$query_image);
        
        
        
				} 



			}
			
			$_SESSION['msg'] = "Details Updated Successfully";
           header("location:list_classified_details.php");
           
            exit();
        
        }
		
		else {
        $_SESSION['msg'] = "Details Not Updated Successfully";
           header("location:list_classified_details.php");
           
            exit();
         
		
		}
		
		}
		
   
         
    }
    


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM  `makeoffer_classfied_details` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Classified have been deleted successfully.';
        
        //die();
        
        header("Location:list_classified_details.php");
    }




if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_product` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}




?>
