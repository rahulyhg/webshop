<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
$query="SELECT `id`, `status` FROM `makeoffer_maintanance_status` WHERE 1 order by id desc limit 0,1";
$res=mysqli_query($con,$query);
$num_rows=mysqli_num_rows($res);
$row=mysqli_fetch_assoc($res);
$rowStatus=$row['status'];

if($num_rows > 0)
{
	$_REQUEST['action']='edit';
	$_REQUEST['id']=$row['id'];
	
	
}
else
{
	$_REQUEST['action']='add';
}



if(isset($_REQUEST['submit']))

{





	$checkbox = isset($_POST['checkbox']) ? $_POST['checkbox'] : '';
	if($checkbox!='')
	{
	$status='Y';
	}
	else
	{
	$status='N';
	}

	
	$fields = array(

		'status' => mysqli_real_escape_string($con,$status),


		);



		$fieldsList = array();

		foreach ($fields as $field => $value) {

			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

		}
		
		
		
		
		
	
		
		
		

					 

	 if($_REQUEST['action']=='edit')

	  {		  



	  $editQuery = "UPDATE `makeoffer_maintanance_status` SET " . implode(', ', $fieldsList)

			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";



		if (mysqli_query($con,$editQuery)) {

		$_SESSION['msg'] = "Details Updated Successfully";

		}

		else {

			$_SESSION['msg'] = "Error occuried while updating Details";

		}



		header('Location:site_maintanance.php');

		exit();

	

	 }

	 else  if($_REQUEST['action']=='add')

	 {

	 

	 $addQuery = "INSERT INTO `makeoffer_maintanance_status` (`" . implode('`,`', array_keys($fields)) . "`)"

			. " VALUES ('" . implode("','", array_values($fields)) . "')";

			

			//exit;

		mysqli_query($con,$addQuery);



		header('Location:site_maintanance.php');

		exit();

	

	 }

				

				

}

?>

