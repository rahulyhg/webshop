<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
include('class.phpmailer.php');
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_user where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:new_vendor.php');
	exit();
}

if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_user set status='1' where id='".$item_id."'");
        $fetch=mysqli_fetch_array(mysqli_query($con,"select * from `makeoffer_user` where `id`='".$item_id."'"));
        $email1=$fetch['email'];
        $fname=$fetch['fname'];
        $lname=$fetch['lname'];
         $Subject1 ="Admin Activated Your Account";

	
		$TemplateMessage.="<br/><br />Hi"." ".$fname;
		$TemplateMessage.="<br>";
		
		
		$TemplateMessage.="<br><br>Your EMARKET Account has been successfully activated by Administrator.";
		$TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";
		$TemplateMessage.="EMARKET";
		$TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored
		or answered.";
		$mail1 = new PHPMailer;
		$mail1->FromName = "EMARKET";
		$mail1->From    = "info@emarket.com";
		$mail1->Subject = $Subject1;
		
		
		
		$mail1->Body    = stripslashes($TemplateMessage);
		$mail1->AltBody = stripslashes($TemplateMessage);
		$mail1->IsHTML(true);
		$mail1->AddAddress($email1,"emarket.com");//info@salaryleak.com
		$mail1->Send();
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:new_vendor.php');
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
			WHERE type=1 and `status`=2 ";
   
    
		

$query=mysqli_query($con,$sql);

  $output='';

    $output .='User ID,User Name,Email,Gender,Address,Details,Joining Date, Status';

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

    $sql="select * from makeoffer_user  where `type`=1 and `status`=2";

 

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
        
        header("Location:new_vendor.php");
    }
?>