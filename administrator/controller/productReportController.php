<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='inactive')

{

	 $item_id=$_GET['cid'];

	 mysqli_query($con,"update makeoffer_product_report set status='1' where id='".$item_id."'");

	//$_SESSION['msg']=message('updated successfully',1);

	header('Location:list_report.php');

	exit();

}

if(isset($_GET['action']) && $_GET['action']=='active')

{

	$item_id=$_GET['cid'];

	mysqli_query($con,"update makeoffer_product_report set status='0' where id='".$item_id."'");

	//$_SESSION['msg']=message('updated successfully',1);

	header('Location:list_report.php');

	exit();

} 

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_product_report  where id<>0 order by id desc ";
                                                        

 

$record=mysqli_query($con,$sql);


}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
            // echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_product` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Products have been deleted successfully.';
        
        //die();
        
        header("Location:list_report.php");
    }

?>
