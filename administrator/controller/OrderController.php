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

	 mysqli_query($con,"update makeoffer_orders set status='0' where id='".$item_id."'");

	$_SESSION['msg']=message('updated successfully',1);

	header('Location:search_order.php');

	exit();

}

if(isset($_GET['action']) && $_GET['action']=='active')

{

	$item_id=$_GET['cid'];

	mysqli_query($con,"update `makeoffer_tblorderdetails` set order_status='1' where orderid='".$item_id."'");
        mysqli_query($con,"update `makeoffer_tblorders` set status='1' where orderid='".$item_id."'");

	$_SESSION['msg']=message('updated successfully',1);

	header('Location:search_order.php');

	exit();

} 

//csv download
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="SELECT * from `makeoffer_tblorders`";
   
    
		

$query=mysqli_query($con,$sql);

  $output='';

    $output .='Order ID,User Name,Order Date,Order Amount';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            $fetch_user=mysqli_fetch_assoc(mysqli_query($con,"select * from `makeoffer_user` where `id`='".$result['order_user_id']."'"));
           $order_ID = $result['new_order_id'];
           $user_fname = $fetch_user['fname'];
           $user_lname = $fetch_user['lname'];
           $user_Name=$user_fname.' '.$user_lname;
           $order_date = $result['orderdate'];
           $order_amount = $result['orderamount'];
           
          
           if($order_ID!=""){
            $output .='"'.$order_ID.'","'.$user_Name.'","'.$order_date.'","'.$order_amount.'"';
            $output .="\n";
            }
        }
    }



    $filename = "myFile".time().".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename='.$filename);



    echo $output;

    //echo'<pre>';

    //print_r($result);

    exit;
	
	
}


//-----------------------------Data Manage----------------------------

$query="SELECT * FROM makeoffer_tblorders ";
if(isset($_REQUEST['transId']) && $_REQUEST['transId']!="")
{
	$transId=$_REQUEST['transId'];
	
	$query .=" where new_order_id=".trim($transId);
}
if(isset($_REQUEST['store']) && $_REQUEST['store']!="")
{
    $query .=" where `storeid`=".$_REQUEST['store'];
}
$query.= "  order by `orderid` DESC ";
$res=mysqli_query($con,$query);
$num=mysqli_num_rows($res);


//-----------------------------/Data Manage----------------------------


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
            //echo "UPDATE `makeoffer_tblorders` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM  `makeoffer_tblorders` WHERE orderid=".$id);
        }
        $_SESSION['success_msg'] = 'Orders have been deleted successfully.';
        
        //die();
        
        header("Location:search_order.php");
    }


?>

   