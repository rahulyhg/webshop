<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php

if(!empty($_POST['product_name'])) {
	$filtered_data =mysqli_query($con,"SELECT * FROM webshop_products WHERE name = '".$_POST['product_name'] . "'");
	$filtered_rows = mysqli_num_rows($filtered_data);

	$allfiltereddata = array();

	while($get_filtered_data = mysqli_fetch_array($filtered_data)){

  array_push($allfiltereddata,$get_filtered_data['id']);

}

}

$_SESSION['filtered_rows'] = $filtered_rows;
$_SESSION['filtered_ids'] = $allfiltereddata;


?>