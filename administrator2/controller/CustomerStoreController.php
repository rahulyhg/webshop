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
	mysqli_query($con,"delete from  makeoffer_user where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:search_user.php');
	exit();
}


if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update makeoffer_user set status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:search_user.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_user set status='1' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:search_user.php');
	exit();
} 

?>
<?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from makeoffer_tblorderdetails  where `storeid`='".$_REQUEST['id']."' ";       
		

$query=mysqli_query($con,$sql);

  $output='';

    $output .='User ID,User Name,Email,Gender,Address,Details,Joining Date, Status';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
           $fetch_user=mysqli_fetch_assoc(mysqli_query($con,"select * from `makeoffer_user` where `id`= '".$row['user_id']."'"));
           $user_ID = $fetch_user['id'];
           $user_Name = $fetch_user['name'];
           $email = $fetch_user['email'];
           $gender = $fetch_user['gender'];
           $address = $fetch_user['address'];
           $about_me = $fetch_user['about_me'];
           $add_date = $fetch_user['add_date'];
           $status = $fetch_user['status'];
          
           if($user_ID!=""){
            $output .='"'.$user_ID.'","'.$user_Name.'","'.$email.'","'.$gender.'","'.$address.'","'.$about_me.'","'.$add_date.'","'.$status.'"';
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
?>
<?php
if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

  $sql="select * from  `makeoffer_tblorderdetails`  where `storeid`='".$_REQUEST['id']."' ";        

 

$record=mysqli_query($con,$sql);


}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_user` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:search_user.php");
    }
?>