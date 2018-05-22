<?php
ob_start();
session_start();
include_once("./includes/config.php");

if(isset($_POST['submit']))
{
	$un=stripslashes(trim($_REQUEST['un']));
	
	$pass=$_REQUEST['pass'];
	
	$sql="SELECT * FROM `malik_tbladmin` WHERE `admin_username`='".mysqli_real_escape_string($con,$_REQUEST['un'])."' and `admin_password`='".mysqli_real_escape_string($con,$pass)."'";
	
	$rs=mysqli_query($con,$sql) or die(mysql_error());
	if($row=mysqli_fetch_object($rs))
	{
		
		$_SESSION['username']=$row->admin_username;
		$_SESSION['admin_id']=$row->id;
		$_SESSION['myy']=$row->id;
		header("location:dashboard.php");
	}
	else
	{
		$msg="Invalid Username or Password.";
	}
}

?>
