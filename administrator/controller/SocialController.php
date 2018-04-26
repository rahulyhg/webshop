<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_REQUEST['submit']))

{



	$name = isset($_POST['name']) ? $_POST['name'] : '';

	$link = isset($_POST['link']) ? $_POST['link'] : '';

	



	$fields = array(

		'name' => mysqli_real_escape_string($con,$name),

		'link' => mysqli_real_escape_string($con,$link),

		);



		$fieldsList = array();

		foreach ($fields as $field => $value) {

			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

		}

					 

	 if($_REQUEST['action']=='edit')

	  {		  

	  $editQuery = "UPDATE `webshop_social` SET " . implode(', ', $fieldsList)

			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";



		if (mysqli_query($con,$editQuery)) {

		$_SESSION['msg'] = "Category Updated Successfully";

		}

		else {

			$_SESSION['msg'] = "Error occuried while updating Category";

		}



		header('Location:social.php');

		exit();

	

	 }

	 else

	 {

	 

	 $addQuery = "INSERT INTO `webshop_social` (`" . implode('`,`', array_keys($fields)) . "`)"

			. " VALUES ('" . implode("','", array_values($fields)) . "')";

			

			//exit;

		mysqli_query($con,$addQuery);



		header('Location:list_category.php');

		exit();

	

	 }

				

				

}



if($_REQUEST['action']=='edit')

{

$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_social` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));



}
?>
<?php
if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from webshop_social  where id<>''";
                                                        

 

$record=mysqli_query($con,$sql);


}
?>