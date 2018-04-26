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
	mysqli_query($con,"delete from  webshop_user where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:search_user.php');
	exit();
}


if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update webshop_user set status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:search_user.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update webshop_user set status='1' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:search_user.php');
	exit();
} 

?>
<?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="SELECT
   			id,
   			concat(`fname`,' ', `lname`) as name,
   			email,
   				CASE `gender` 
   				WHEN 'M' THEN 'Male'  
				WHEN 'F' THEN 'Female'   
 
			END as 'gender',
		 	address,
		 	about_me,
		 	add_date,
		 	CASE `status` 
   				WHEN 1 THEN 'UnBlock'  
				WHEN 0 THEN 'Block'   
 
			END as 'status'
		 	FROM 
		`makeoffer_user` 
			WHERE type=0 ";
   
    
		

$query=mysqli_query($con,$sql);

  $output='';

    $output .='User ID,User Name,Email,Gender,Address,Joining Date, Status';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {	
           $user_ID = $result['id'];
           $user_Name = $result['name'];
           $email = $result['email'];
           $gender = $result['gender'];
           $address = $result['address'];
           $about_me = $result['about_me'];
           $add_date = $result['add_date'];
           $status = $result['status'];
          
           if($user_ID!=""){
            $output .='"'.$user_ID.'","'.$user_Name.'","'.$email.'","'.$gender.'","'.$address.'","'.$add_date.'","'.$status.'"';
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


$sql1 = mysqli_query($con,"SELECT DISTINCT user_id FROM webshop_orders");

while ($row=mysqli_fetch_array($sql1)) {
  echo $row['user_id'];

  $sarray[] = $row['user_id'];
}
//echo "<pre>";
//print_r($sarray);
 $buyerid = implode(",",$sarray);


$sql = "SELECT * FROM webshop_user WHERE id IN ($buyerid)";

  //$sql="select * from makeoffer_user  where `type`=0 ";        

 

$record=mysqli_query($con,$sql);


}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_user` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:search_user.php");
    }
?>