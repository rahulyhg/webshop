<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php

if(!empty($_POST['language'])) {
	$query =mysqli_query($con,"SELECT * FROM webshop_user WHERE  default_language IN('All','".$_POST['language']."') and type = 1");
?>
	<!-- <option value="">Select SubCategory</option> -->
<?php
     while($selected_customers = mysqli_fetch_array($query)){
?>
	<option value="<?php echo $selected_customers['email']; ?>"><?php echo $selected_customers['email']; ?></option>
<?php
  //print_r($subcat);
	}
}
?>