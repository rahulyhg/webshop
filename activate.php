<?php
include_once("/administrator/includes/config.php");
//echo "Testing the page";
$add_date = date('Y-m-d');

if(!empty($_GET['id'])){
	$query = mysqli_query("UPDATE webshop_user SET email_verified = '1',verified_date='".$add_date."' WHERE id='".$_GET['id']."'");
	if(!empty($query)){

		echo "Your email has been verified.Your account is waiting for admin approval.Once your account has been activated you will be sent an email.";
	}else{

		echo "Problem in verifying the email";
	}

}

?>