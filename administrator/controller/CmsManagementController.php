<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_REQUEST['id']))
	{
		$pid=$_REQUEST['id'];
		$sql2="SELECT * FROM `webshop_cms` where id='".$pid."'"; 
		$res=mysqli_query($con,$sql2);
		$row12=mysqli_fetch_array($res);
	}
	
if(isset($_REQUEST['submit']))
{

	//$title=$_REQUEST['cat_name'];
	$pagedetail = isset($_POST['elm1']) ? $_POST['elm1'] : '';
	
	
	$fields = array('pagedetail' => mysqli_real_escape_string($con,$pagedetail));

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

	}	   
	 $editQuery = "UPDATE `webshop_cms` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['pid']) . "'";
		//	exit;

		if (mysqli_query($con,$editQuery)) {
			$_SESSION['msg'] = "CMS Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating CMS";
		}

		header('Location: cms.php?id='.$_REQUEST['pid']);
		exit();
	

				
}

?>