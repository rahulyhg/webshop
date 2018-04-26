<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_REQUEST['submit']))

{



	$alt_text = isset($_POST['alt_text']) ? $_POST['alt_text'] : '';	



	$fields = array(

		'alt_text' => mysqli_real_escape_string($con,$alt_text)

		);



		$fieldsList = array();

		foreach ($fields as $field => $value) {

			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

		}

					 



			  

	  $editQuery = "UPDATE `makeoffer_sitesettings` SET " . implode(', ', $fieldsList)

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

		

		$image =mysqli_query($con,"UPDATE `makeoffer_sitesettings` SET `sitelogo`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");

		}
		else{
		 $img_name=$_REQUEST['hid_logo'];	
			
		}

		

		

			$_SESSION['msg'] = "Category Updated Successfully";

		}

		else {

			$_SESSION['msg'] = "Error occuried while updating Category";

		}



		header('Location:site_logo.php');

		exit();

	

	 

		

}



$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_sitesettings` WHERE `id`='1'"));


?>