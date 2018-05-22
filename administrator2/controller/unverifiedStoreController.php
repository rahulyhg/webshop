<?php 
include_once("./includes/session.php");

include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');

	  					

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

 $sql="select * from makeoffer_store  where id<>'' and verification_status=0";

$record=mysqli_query($con,$sql);


}

if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_store where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_store.php');
	exit();
}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_store` SET status='0' WHERE id=".$id;
           mysqli_query($con,"DELETE FROM `makeoffer_store` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Stores have been deleted successfully.';
        
        //die();
        
        header("Location:list_not_verified_store.php");
    }

?>
