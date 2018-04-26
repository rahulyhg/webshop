<?php
error_reporting(ALL);
ob_start();
session_start();
include_once("./includes/config.php");
require_once("includes/class.phpmailer.php");
require 'vendor/autoload.php';


function generateRandomString($length = 5) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<?php
if(isset($_REQUEST['submit']))
{
$email=$_REQUEST['email'];
 
    
$fetch=mysqli_query($con,"select * from `webshop_tbladmin` where `email`='".$email."'");
$checkk=mysqli_num_rows($fetch);
$check=mysqli_fetch_array($fetch);
$fname=$check['name'];
$emaill=$check['email'];

      if($checkk>0)
     {
          $password = generateRandomString();
          $dbpassword = md5($password);
          
          
          $update=mysqli_query($con,"update `webshop_tbladmin` set `admin_password`='".$dbpassword."',`txt_pwd`='".$password."' where `email`='".$emaill."'");
          
                               $MailTo = $emaill;        
        
	$MailFrom = 'info@webshopwatches.com';
             $subject = "webshopwatches.com- Password Reset";
             

          $TemplateMessage.="<br/><br />Hi ".$fname."," ;
				$TemplateMessage.="<br>";
				//$TemplateMessage.="<br>Welcome to Tontonuz";
				$TemplateMessage.="<br>You've requested a password reset. Please use the below password to login and then please change it";
				$TemplateMessage.="<br><br>";
				$TemplateMessage.="Your Password :" . $password;
                                $TemplateMessage.="<br><br><br/>Hope to see soon<br/>";
				$TemplateMessage.="<br><br/>Regards<br/>";
				$TemplateMessage.="Webshop Watches";
				$TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";
           
            
           /* $TemplateMessage .= "<br><br>Thanks,<br />";
            $TemplateMessage .= "baybarter.com<br />"; */


/*            $header = "From:info@baybarter.com \r\n";
            // $header .= "Cc:nits.nits.bsm@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";*/
		$mail = new PHPMailer(true);	
			
			$IsMailType='SMTP';  
	
	$MailFrom='info@natit.us';    //  Your email password

    $MailFromName='Webshop Watches';
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
        
       
                                 $_SESSION['forget']="Email has been sent with the password";
                                  header('location:forget_password.php');
                                // header("location:http://globalitservice.co.in/malik/ForgetPassword/");
                                 exit;
                              
   
    
     }
 else {
     $_SESSION['forget1']="Email Id doesnot Exists in Database";
          header('location:forget_password.php');
  // header("location:http://globalitservice.co.in/malik/ForgetPassword/");
   exit;
      }
}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Forgetpassword</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="lock">
    <div class="lock-header">
        <!-- BEGIN LOGO -->
        <!-- <a class="center" id="logo" href="index.html">
            <img class="center" alt="logo" src="img/logo.png">
        </a> -->
        <h2>Webshop Watches</h2>
        <?php
                                    if($_SESSION['forget1']!='')
                                    {
                                    ?>
                                    <span style="color:red;"><?php echo $_SESSION['forget1'] ?></span>
                                    <?php
                                    $_SESSION['forget1']='';
                                    }
                                    ?>
                                    <?php
                                    if($_SESSION['forget']!='')
                                    {
                                    ?>
                                    <span style="color:green;"><?php echo $_SESSION['forget'] ?></span>
                                    <?php
                                    $_SESSION['forget']='';
                                    }
                                    ?>
        <!-- END LOGO -->
    </div>
    <div class="login-wrap">
        <div class="metro single-size red">
            <div class="locked">
                <i class="icon-lock"></i>
                <span>Forgot Password?</span>
            </div>
        </div>
        <div class="metro double-size green">
            <form action="forget_password.php" method="post">
                <div class="input-append lock-input">
                    <input type="text" class="" name="email" placeholder="Email">
                    <br><br>
                    <span><a href="index.php" style="color:white;">Login?</a></span>
                </div>
           
        </div>
        <!--<div class="metro double-size yellow">
            
                <div class="input-append lock-input">
                    <input type="password" class="" name="pass" placeholder="Password">
                </div>
          
        </div>-->
        <div class="metro single-size terques login">
          
                <button type="submit" name="submit" class="btn login-btn">
                    Send
                    <i class=" icon-long-arrow-right"></i>
                   <!--  <a href="forgot_password.php">Forgot Password</a> -->
                </button>
            
            </form>
            
        </div>
         <!-- <div class="metro single-size red login">
        <form action = "forgot_password.php" method = "post">
        <button type="submit" name="forgot_password" class="btn login-btn">Forgot Password
            <i class=" icon-long-arrow-right"></i>
            </button>
        </form>
        </div> -->
        <?php /*
        <div class="metro double-size navy-blue ">
            <a href="index.html" class="social-link">
                <i class="icon-facebook-sign"></i>
                <span>Facebook Login</span>
            </a>
        </div>
        <div class="metro single-size deep-red">
            <a href="index.html" class="social-link">
                <i class="icon-google-plus-sign"></i>
                <span>Google Login</span>
            </a>
        </div>
        <div class="metro double-size blue">
            <a href="index.html" class="social-link">
                <i class="icon-twitter-sign"></i>
                <span>Twitter Login</span>
            </a>
        </div>
        <div class="metro single-size purple">
            <a href="index.html" class="social-link">
                <i class="icon-skype"></i>
                <span>Skype Login</span>
            </a>
        </div>
        <div class="login-footer">
            <div class="remember-hint pull-left">
                <input type="checkbox" id=""> Remember Me
            </div>
            <div class="forgot-hint pull-right">
                <a id="forget-password" class="" href="javascript:;">Forgot Password?</a>
            </div>
        </div>
        */ ?>
    </div>
</body>
<!-- END BODY -->
</html>