<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php

if(!empty($_POST['country_id'])) {
	$query =mysqli_query($con,"SELECT * FROM webshop_states WHERE country_id = '" . $_POST["country_id"] . "'");
?>
	<option value="">Select State</option>
<?php
     while($subcat = mysqli_fetch_array($query)){
?>
	<option value="<?php echo $subcat['id']; ?>"><?php echo $subcat['name']; ?></option>
<?php
  //print_r($subcat);
	}
}

if(!empty($_POST['state_id'])) {
	$query =mysqli_query($con,"SELECT * FROM webshop_cities WHERE state_id = '" . $_POST["state_id"] . "'");
?>
	<option value="">Select City</option>
<?php
     while($subcat = mysqli_fetch_array($query)){
?>
	<option value="<?php echo $subcat['id']; ?>"><?php echo $subcat['name']; ?></option>
<?php
  //print_r($subcat);
	}
}
?>