<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_event where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location: list_event.php');
	exit();
}


if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update makeoffer_event set status='0' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: list_event.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_event set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: list_event.php');
	exit();
} 


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
   
 
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_event` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_event` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_event.php");
    }

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_event where id<>0 ";
                                                        

 

$record=mysqli_query($con,$sql);


}



?>
