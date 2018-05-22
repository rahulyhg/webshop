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
	$price = isset($_POST['price']) ? $_POST['price'] : '';
	$no_products = isset($_POST['no_products']) ? $_POST['no_products'] : '';
        
	

	$fields = array(
                'name' => mysqli_real_escape_string($con,$name),
		'price' => mysqli_real_escape_string($con,$price),
		'no_products' => mysqli_real_escape_string($con,$no_products),
               

		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `makeoffer_store_package` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

		if (mysqli_query($con,$editQuery)) {
		
		
		
		
			$_SESSION['msg'] = "Store Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_store_package.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `makeoffer_store_package` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
		
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
		
      
		header('Location:list_store_package.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_store_package` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}

if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from   makeoffer_store_package  where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_store_package.php');
	exit();
}







if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_store_package  where id<>''";
$record=mysqli_query($con,$sql);


}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_banner` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_store_package` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Package have been deleted successfully.';
        
        //die();
        
        header("Location:list_store_package.php");
    }

?>
