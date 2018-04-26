<?php
//error_reporting(ALL);
ob_start();
session_start();
include_once("./includes/config.php");




if(isset($_POST['submit']))
{
    
    


    
    

    $un=stripslashes(trim($_REQUEST['un']));
    
    $pass=$_REQUEST['pass'];
    
    
$sql = "SELECT * FROM webshop_tbladmin WHERE `admin_username`='".mysqli_real_escape_string($con,$_REQUEST['un'])."' OR `email`='".mysqli_real_escape_string($con,$_REQUEST['un'])."'";


$result = mysqli_query($con,$sql) or die( mysqli_error() );
$row = mysqli_fetch_assoc($result);

$hashed_pass = md5($pass);
//echo $hashed_pass;

if ($hashed_pass == $row['admin_password']) {

		$_SESSION['username']=$row['admin_username'];
		$_SESSION['admin_id']=$row['id'];
		$_SESSION['myy']=$row['id'];
		$_SESSION['status']=$row['status'];
                $_SESSION['privilege_name']=$row['privilege_name'];
 
                header("location:dashboard.php");
    
}
else{
    $msg="Invalid Username or Password.";
    $_SESSION['invalid_msg']=$msg;
    header("location:index.php");
    exit;
}
//    $rs=mysqli_query($con,$sql) or die(mysql_error());
//    if($row=mysqli_fetch_object($rs))
//    {
//        
//        $_SESSION['username']=$row->admin_username;
//        $_SESSION['admin_id']=$row->id;
//        $_SESSION['myy']=$row->id;
//        $_SESSION['status']=$row->status;
//        
//        header("location:dashboard.php");
//    }
//    else
//    {
//        $msg="Invalid Username or Password.";
//    }
}



?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Login</title>
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
        <?php if($_SESSION['invalid_msg'] !=''){ ?>
        <h2><span align="center" style ="color:red" ><?php  echo $_SESSION['invalid_msg'] ?></span></h2>
        <?php
         $_SESSION['invalid_msg'] = '';
        } ?>
        <!-- END LOGO -->
    </div>
    <div class="login-wrap">
        <div class="metro single-size red">
            <div class="locked">
                <i class="icon-lock"></i>
                <span>Login</span>
            </div>
        </div>
        <div class="metro double-size green">
            <form action="index.php" method="post">
                <div class="input-append lock-input">
                    <input type="text" class="" name="un" placeholder="Username">
                </div>
           
        </div>
        <div class="metro double-size yellow">
            
                <div class="input-append lock-input">
                    <input type="password" class="" name="pass" placeholder="Password">
                </div>
          
        </div>
        <div class="metro single-size terques login">
          
                <button type="submit" name="submit" class="btn login-btn">
                    Login
                    <i class=" icon-long-arrow-right"></i>
                   <!--  <a href="forgot_password.php">Forgot Password</a> -->
                </button>
            <a href="forget_password.php" style="color:white;">Forgot Password?</a>
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