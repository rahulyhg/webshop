<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
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

	 

	 $secret_key = isset($_POST['secret_key']) ? $_POST['secret_key'] : '';

	 $publishable_key = isset($_POST['publishable_key']) ? $_POST['publishable_key'] : '';

	 

	 $fields = array('secret_key' => mysqli_real_escape_string($con,$secret_key),

	 'publishable_key' => mysqli_real_escape_string($con,$publishable_key)

	 );

	   $fieldsList = array();

		foreach ($fields as $field => $value) {

			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

		}

		

	  $editQuery = "UPDATE `makeoffer_tbladmin` SET " . implode(', ', $fieldsList)

			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_SESSION['admin_id']) . "'";



		if (mysqli_query($con,$editQuery)) {

			$_SESSION['msg'] = "Updated Successfully";

		}

		else {

			$_SESSION['msg'] = "Error occuried while updating Email";

		}



		header('Location: changeaccess.php');

		exit();

		

	

	}

	
?>