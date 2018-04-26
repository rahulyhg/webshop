<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');


if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_product  where `product_type`='P'";
 

$fetch_product=mysqli_query($con,$sql);


}
?>
<?php
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_product` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Product have been deleted successfully.';
        
        //die();
        
        header("Location:product_deal.php");
    }
    ?>




