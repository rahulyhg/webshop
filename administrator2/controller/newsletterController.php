<?php 
include_once("./includes/session.php");
include_once("./includes/config.php");
include_once("./includes/functions.php");
include('./includes/class.phpmailer.php');

$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$target_path="../news_image/";
	
if(isset($_REQUEST['submit']))
{
$title=$_POST['title'];
$file=$_FILES['file']['name'];	
$uploadFolder = "attachment";
$uploadPath =$uploadFolder;	
$full_image_path = $uploadPath . '/' . $file;
move_uploaded_file($_FILES['file']['tmp_name'],$full_image_path);
if(! empty($_REQUEST['email']))
{
$email=implode(',',$_REQUEST['email']);
}
else{
 $SQL ="SELECT * FROM `makeoffer_newsletter`";
                                            $result = mysqli_query($con,$SQL);
                                            
                                            while($row1=mysqli_fetch_array($result))
                                            {
											 $emailarray[]=	$row1['email']; 
											}
											$email=implode(',',$emailarray);

}
$new_email=explode(',',$email);
foreach($new_email as $email_id)
{
$TemplateMessage='';
	
$SQL ="SELECT * FROM `makeoffer_newsletter` where email='".$email_id."'";
$result = mysqli_query($con,$SQL);	
$row1=mysqli_fetch_array($result);
 //$TemplateMessage.="<br/><br />Hi ".$row1['fname'].",";
		$TemplateMessage.="<br><br>";

		$TemplateMessage.="<br>".$title."<br><br>";

		$TemplateMessage.=" ".mysqli_real_escape_string($con,$_REQUEST['description'])."";


		$TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";

		$TemplateMessage.="Your Local Search Engine";

		

		$mail1 = new PHPMailer;

		$mail1->FromName = "Your Local Search Engine";

		$mail1->From    = "emarket.com";

		$mail1->Subject = $_REQUEST['title'];
	    $mail1->AddAttachment($full_image_path,$file);
		$mail1->Body    = stripslashes($TemplateMessage);

		$mail1->AltBody = stripslashes($TemplateMessage);

		$mail1->IsHTML(true);

		$mail1->AddAddress($email_id,"emarket.com");//info@salaryleak.com

		$mail1->Send();	
		//unlink($full_image_path);
		
		
}
if(empty($_REQUEST['email']))
		{
		$email='All';
		}

}



?>
