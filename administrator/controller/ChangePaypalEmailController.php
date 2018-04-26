<?php 
include_once("./includes/session.php");
include_once("./includes/config.php");
include_once("./includes/functions.php");
include('./includes/class.phpmailer.php');
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php


		 //$pid=$_REQUEST['id'];
		$sql2="SELECT * FROM `makeoffer_tbladmin` where id='".$_SESSION['admin_id']."'"; 
		$res=mysqli_query($con,$sql2);
		$row=mysqli_fetch_array($res);
//print_r($row);
if(isset($_REQUEST['submit']))
	{
	 //$email=$_REQUEST['email'];
	 
	 $paypal_email = isset($_POST['paypal_email']) ? $_POST['paypal_email'] : '';
	 
	 $fields = array('paypal_email' => mysqli_real_escape_string($con,$paypal_email));
	   $fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
		
	 $editQuery = "UPDATE `makeoffer_tbladmin` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_SESSION['admin_id']) . "'";

		if (mysqli_query($con,$editQuery)) {
			$_SESSION['msg'] = "Email Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Email";
		}

		header('Location: changepaypal_email.php');
		exit();
		
	
	}
	
?>