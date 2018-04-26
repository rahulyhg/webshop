<?php 
require_once("includes/class.phpmailer.php");
require 'vendor/autoload.php';


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
	mysqli_query($con,"update webshop_user set status='2' where id='".$item_id."'");
         
  
         
        $sql = "SELECT * from webshop_user WHERE id='".$item_id."'";
		$result=mysqli_query($con, $sql);
		
         
  while($row=mysqli_fetch_object($result))
  {      
         
         $MailTo = $row->email;        
        
	$MailFrom = 'info@baybarter.com';
             $subject = "baybarter.com- Account Deactivate Alert";
             

           $TemplateMessage = "Your account has been deactivated temporarily by a Barterbay Admin due to suspicious activities. Our team will investigate and notify you once your account is activated again.<br /><br />";
           
            
           /* $TemplateMessage .= "<br><br>Thanks,<br />";
            $TemplateMessage .= "baybarter.com<br />"; */


/*            $header = "From:info@baybarter.com \r\n";
            // $header .= "Cc:nits.nits.bsm@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";*/
		$mail = new PHPMailer(true);	
			
			$IsMailType='SMTP';  
	
	$MailFrom='info@natit.us';    //  Your email password

    $MailFromName='Baybarter';
	$MailToName='';

    $YourEamilPassword="Natit2016";   //Your email password from which email you send.

 
	// If you use SMTP. Please configure the bellow settings.
	
	$SmtpHost             = "smtp.gmail.com"; // sets the SMTP server
	$SmtpDebug            = 0;                     // enables SMTP debug information (for testing)
	$SmtpAuthentication   = true;                  // enable SMTP authentication
	$SmtpPort             = 587;                    // set the SMTP port for the GMAIL server
	$SmtpUsername       = $MailFrom; // SMTP account username
	$SmtpPassword       = $YourEamilPassword;        // SMTP account password
	
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->SMTPDebug  = $SmtpDebug;
	$mail->SMTPAuth   =  $SmtpAuthentication;     // enable SMTP authentication
	$mail->Port       = $SmtpPort;             // set the SMTP port
	$mail->Host       = $SmtpHost;           // SMTP server
	$mail->Username   =  $SmtpUsername; // SMTP account username
	$mail->Password   = $SmtpPassword; // SMTP account password
	
	if ( $MailFromName != '' ) {
	$mail->AddReplyTo($MailFrom,$MailFromName);
	$mail->From       = $MailFrom;
	$mail->FromName   = $MailFromName;
	} else {
	$mail->AddReplyTo($MailFrom);
	$mail->From       = $MailFrom;
	$mail->FromName   = $MailFrom;
	}
	
	if ( $MailToName != '' ) {
	$mail->AddAddress($MailTo,$MailToName);
	} else {
	$mail->AddAddress($MailTo);
	}
	
	$mail->SMTPSecure = 'tls';
	$mail->Subject  = $subject;	
	
	$mail->MsgHTML($TemplateMessage);
        $mail->Send();
        
        header('Location:search_user.php');
	exit();
        
}
         
	//$_SESSION['msg']=message('updated successfully',1);
	
}

if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update webshop_user set status='1' where id='".$item_id."'");
        
        
        
        
        
        $sql = "SELECT * from webshop_user WHERE id='".$item_id."'";
		$result=mysqli_query($con, $sql);
		
         
  while($row=mysqli_fetch_object($result))
  {      
         
         $MailTo = $row->email;        
        
	$MailFrom = 'info@baybarter.com';
             $subject = "baybarter.com- Account Activation Alert";
             

           $TemplateMessage = "Your account has been activated by a Barterbay Admin.<br /><br />";
           
            
           /* $TemplateMessage .= "<br><br>Thanks,<br />";
            $TemplateMessage .= "baybarter.com<br />"; */


/*            $header = "From:info@baybarter.com \r\n";
            // $header .= "Cc:nits.nits.bsm@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";*/
		$mail = new PHPMailer(true);	
			
			$IsMailType='SMTP';  
	
	$MailFrom='info@natit.us';    //  Your email password

    $MailFromName='Baybarter';
	$MailToName='';

    $YourEamilPassword="Natit2016";   //Your email password from which email you send.

 
	// If you use SMTP. Please configure the bellow settings.
	
	$SmtpHost             = "smtp.gmail.com"; // sets the SMTP server
	$SmtpDebug            = 0;                     // enables SMTP debug information (for testing)
	$SmtpAuthentication   = true;                  // enable SMTP authentication
	$SmtpPort             = 587;                    // set the SMTP port for the GMAIL server
	$SmtpUsername       = $MailFrom; // SMTP account username
	$SmtpPassword       = $YourEamilPassword;        // SMTP account password
	
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->SMTPDebug  = $SmtpDebug;
	$mail->SMTPAuth   =  $SmtpAuthentication;     // enable SMTP authentication
	$mail->Port       = $SmtpPort;             // set the SMTP port
	$mail->Host       = $SmtpHost;           // SMTP server
	$mail->Username   =  $SmtpUsername; // SMTP account username
	$mail->Password   = $SmtpPassword; // SMTP account password
	
	if ( $MailFromName != '' ) {
	$mail->AddReplyTo($MailFrom,$MailFromName);
	$mail->From       = $MailFrom;
	$mail->FromName   = $MailFromName;
	} else {
	$mail->AddReplyTo($MailFrom);
	$mail->From       = $MailFrom;
	$mail->FromName   = $MailFrom;
	}
	
	if ( $MailToName != '' ) {
	$mail->AddAddress($MailTo,$MailToName);
	} else {
	$mail->AddAddress($MailTo);
	}
	
	$mail->SMTPSecure = 'tls';
	$mail->Subject  = $subject;	
	
	$mail->MsgHTML($TemplateMessage);
        $mail->Send();
        
        
        header('Location:search_user.php');
	exit();
        
  }    
        
        
	//$_SESSION['msg']=message('updated successfully',1);
	
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


$sql = "SELECT * FROM webshop_user";

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





<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="search_user.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="search_user.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="search_user.php?cid="+aa+"&action=active";
   } 

   </script>
 <!-- Header Start -->
<?php include ("includes/header.php"); ?>
<!-- Header End -->
 <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->

    <?php include("includes/left_sidebar.php"); ?>

      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                   <!-- BEGIN THEME CUSTOMIZER-->
                   <div id="theme-change" class="hidden-phone">
                       <i class="icon-cogs"></i>
                        <span class="settings">
                            <span class="text">Theme Color:</span>
                            <span class="colors">
                                <span class="color-default" data-style="default"></span>
                                <span class="color-green" data-style="green"></span>
                                <span class="color-gray" data-style="gray"></span>
                                <span class="color-purple" data-style="purple"></span>
                                <span class="color-red" data-style="red"></span>
                            </span>
                        </span>
                   </div>
                   <!-- END THEME CUSTOMIZER-->
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title">User List</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">User List</a>                        
                       </li>
                        
                       
                     
                       

                       
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                            <!--<form action="" method="post">
                            <i class="fa fa-edit"></i>Editable Table
                            <button type="submit" class="btn btn-primary"  name="ExportCsv"> Download CSV</button>
                            </form>-->
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->
                               <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                     <thead>
                                    <tr>
            
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                                <!--<th>Edit</th>-->
                                <!--<th>Quick Links</th>-->
                                <!--<th>Delete</th>-->
                                <th>Status</th>
                
                
                
              </tr>
                </thead>
                <tbody>
                                  <?php
                                                     //$sql="select * from makeoffer_user  where `type`=0";
                                                        

 

//$record=mysqli_query($con,$sql);

if(mysqli_num_rows($record)==0)

{?>

                  <tr>

                    <td colspan="3">Sorry, no record found.</td>

                  </tr>

                  <?php 

}

else

{

$count=1;

  while($row=mysqli_fetch_object($record))

  {
            if ($row->is_loggedin==1)
            {
                $a="Online";
                
            }
       else {
           $a="Offline";
     
             }
            if($row->image!='')
               {
                $image_link='../upload/user_images/'.$row->image;
              }
              else {
                 $image_link='../upload/no.png';
              }


  

?>

              
              <tr>
                   <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id ; ?>"/></td>-->
                  
                  
                 <td>
                   <img src="<?php echo stripslashes($image_link);?>" height="70" width="70" style="border:1px solid #666666" />   
                </td>                
                
                <td>
                  <?php echo $row->fname;?> <?php echo $row->lname;?>
                </td>                
                
                <td>
                  <?php echo $row->email;?>
                </td>
                
                <!--<td>
                  <a onClick="window.location.href='add_user.php?id=<?php echo $row->id ?>&action=edit'">Edit</a>
                </td>-->
                
                <!--<td>
                  <a onClick="javascript:del('<?php echo $row->id; ?>')">Delete</a>
                </td>-->
                
                
                <td>
                  <?php if($row->status=='2'){?>
                    <a  onClick="javascript:active('<?php echo $row->id;?>');">UnBlock</a>
                    <?php } else {?>
                    <a  onClick="javascript:inactive('<?php echo $row->id;?>');">Block</a>
                  <?php }?>
                </td>
                
                
                
                                                                <!--<td>
                  <?php //echo $row->address;?>
                </td>
                                                                <td>
                  <?php //echo $a;?>
                </td>-->
                <!--<td>
                <a onClick="window.location.href='add_user_type.php?id=<?php echo $row->id ?>&action=edit'">Edit</a><br>
                <a onClick="window.location.href='add_billing_details.php?id=<?php echo $row->id ?>&action=edit'">Edit Billing Address</a><br>
                <a onClick="window.location.href='add_user.php?id=<?php echo $row->id ?>&action=edit'">Edit Shipping Address</a>
                </td>-->
                
                <!--<td>
                 <a onClick="window.location.href='user_details.php?id=<?php echo $row->id ?>&action=details'">User Details</a><br>
                 <!--<a onClick="window.location.href='my_purchase.php?id=<?php echo $row->id ?>&action=details'">Purchase History</a><br>-->
                 <!--<a onClick="window.location.href='change_password_user.php?id=<?php echo $row->id ?>&action=details'">Update Password</a>
                </td>-->
                
                
                                                                
              </tr>
                                                       <?php
                                                        }
}
                                                       ?>

                                     </tbody>
                                 </table>
                                  <?php if ($innerPrivileges->listproductcat_delete == '1') { ?>
                                <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
                            <?php } ?>
                             </form>

                            <!-- END Table-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                   
                </div>
            </div>

            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

   <!-- Footer Start -->

   <?php include("includes/footer.php"); ?>

   <!-- Footer End -->

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>   
  <!-- <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="js/editable-table.js"></script>

   <!-- END JAVASCRIPTS -->
   <script>
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
</body>
<!-- END BODY -->
</html>
