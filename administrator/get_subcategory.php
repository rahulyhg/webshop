<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php

if(!empty($_POST['category_id'])) {
	$query =mysqli_query($con,"SELECT * FROM webshop_subcategory WHERE category_type = '" . $_POST["category_id"] . "'");
?>
	<option value="">Select SubCategory</option>
<?php
     while($subcat = mysqli_fetch_array($query)){
?>
	<option value="<?php echo $subcat['id']; ?>"><?php echo $subcat['name']; ?></option>
<?php
  //print_r($subcat);
	}
}
?>