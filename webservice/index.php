

<?php

//error_reporting(1);
require_once("class/class.phpmailer.php");
require 'vendor/autoload.php';

require 'config.php';
include('routs.php');
include('crud.php');
//include('Stripe.php');
//spandan
date_default_timezone_set('UTC');

/* function get_lat_long($address) {
  $array = array();
  $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');

  // We convert the JSON to an array
  $geo = json_decode($geo, true);

  // If everything is cool
  if ($geo['status'] = 'OK') {
  $latitude = $geo['results'][0]['geometry']['location']['lat'];
  $longitude = $geo['results'][0]['geometry']['location']['lng'];
  $array = array('lat' => $latitude, 'lng' => $longitude);
  }

  return $array;
  } */

function userSignup() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $fname = isset($body->fname) ? $body->fname : '';
    $lname = isset($body->lname) ? $body->lname : '';
    $email = isset($body->email) ? $body->email : '';
    $password = isset($body->password) ? $body->password : '';
    $device_type = isset($body->devicetype) ? $body->devicetype : '';
    $device_token_id = isset($body->devicetoken) ? $body->devicetoken : '';
    $address = isset($body->address) ? $body->address : '';
    $lat = isset($body->lat) ? $body->lat : '';
    $long = isset($body->long) ? $body->long : '';
    $phone = isset($body->phone) ? $body->phone : '';
    $city = isset($body->city) ? $body->city : '';
    $city = isset($body->city) ? $body->city : '';
    $type = isset($body->type) ? $body->type : '';
    $country = isset($body->country) ? $body->country : '';
    $add_date = date('Y-m-d');
    $db = getConnection();

    $sql = "SELECT * FROM  webshop_user WHERE  email=:email OR phone=:phone";
    $stmt = $db->prepare($sql);

    $stmt->bindParam("email", $email);
    $stmt->bindParam("phone", $phone);
    $stmt->execute();
    $usersCount = $stmt->rowCount();
    $smsotopcode=mt_rand(1111,9999);
    if ($usersCount == 0) {

        $newpass = md5($password);
       $is_mobile_verified =  0;
       $sms_verify_number = $smsotopcode;
//$status=1;

        $sql = "INSERT INTO  webshop_user (fname,lname, email, password, type, device_type, device_token_id, add_date, address, my_latitude,my_longitude,city,phone,is_mobile_verified,country,sms_verify_number) VALUES (:fname,:lname, :email, :password, :type, :device_type, :device_token_id, :add_date, :address, :my_latitude, :my_longitude, :city, :phone,:is_mobile_verified,:country,:sms_verify_number)";
        try {

            $stmt = $db->prepare($sql);
            $stmt->bindParam("fname", $fname);
            $stmt->bindParam("lname", $lname);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("password", $newpass);
            $stmt->bindParam("type", $type);
            $stmt->bindParam("device_type", $device_type);
            $stmt->bindParam("device_token_id", $device_token_id);
            $stmt->bindParam("add_date", $add_date);
            $stmt->bindParam("is_mobile_verified", $is_mobile_verified);
             $stmt->bindParam("country", $country);
            $stmt->bindParam("sms_verify_number", $sms_verify_number);
// $stmt->bindParam("status", $status);
            $stmt->bindParam("address", $address);
            $stmt->bindParam("my_latitude", $lat);
            $stmt->bindParam("my_longitude", $long);
            $stmt->bindParam("city", $city);
            $stmt->bindParam("phone", $phone);
            $stmt->execute();


            $lastID = $db->lastInsertId();
            
            
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Registered Successfully...';
          


            $sql = "SELECT * FROM  webshop_user WHERE id=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $lastID);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = SITE_URL . 'upload/nouser.jpg';
            }

            $to_adminid = '0';
            $notificationtype = '';

            if ($getUserdetails->type == '2' AND $getUserdetails->top_user_vendor == '1') {
                $notificationtype = 'Certified Vendor Approval Request';
            } else if ($getUserdetails->type == '2' AND $getUserdetails->top_user_vendor == '0') {
                $notificationtype = 'Normal Vendor Approval Request';
            }

            $is_read = '0';
            $last_id = '0';
            $notification_msg = $getUserdetails->fname . " " . $getUserdetails->lname . " " . $notificationtype . " .Please approve the account.";
            $notificationsql = "INSERT INTO  webshop_notification(from_id,to_id, type, msg, date, is_read, last_id) VALUES (:from_id,:to_id, :type, :msg, :date, :is_read, :last_id)";
            $stmt2 = $db->prepare($notificationsql);
            $stmt2->bindParam("from_id", $lastID);
            $stmt2->bindParam("to_id", $to_adminid);
            $stmt2->bindParam("type", $notificationtype);
            $stmt2->bindParam("msg", $notification_msg);
            $stmt2->bindParam("date", $add_date);
            $stmt2->bindParam("is_read", $is_read);
            $stmt2->bindParam("last_id", $last_id);
            $stmt2->execute();

            $data['UserDetails'] = array(
                "user_id" => stripslashes($getUserdetails->id),
                "fname" => stripslashes($getUserdetails->fname),
                "type" => stripslashes($getUserdetails->type),
                "lname" => stripslashes($getUserdetails->lname),
                "email" => stripslashes($getUserdetails->email),
                "address" => stripslashes($getUserdetails->address),
                "my_latitude" => stripslashes($getUserdetails->my_latitude),
                "my_longitude" => stripslashes($getUserdetails->my_longitude),
                "city" => stripslashes($getUserdetails->city),
                "phone" => stripslashes($getUserdetails->phone),
                "add_date" => stripslashes($getUserdetails->add_date),
                "profile_image" => stripslashes($profile_image));


            /* mailt to user or vendor start */
            $MailTo = $email;
          
            $actual_link = SITE_URL . "#/emailverify/" . $lastID;
            $MailFrom = 'webshop.com';
            $subject = "webshop.com- Thank you for registering";

            $TemplateMessage = "Welcome and thank you for registering at webshop.com!<br />";
            $TemplateMessage .= "Your account has now been created and you can login using your email address and password by visiting our App<br />";
            $TemplateMessage .= "<br/>Click this link to verify your email <a href='" . $actual_link . "'> Click here</a><br/>";
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "webshop.com<br />";


            $mail = new PHPMailer(true);

            $IsMailType = 'SMTP';

            $MailFrom = 'mail@natitsolved.com';    //  Your email password

            $MailFromName = 'Webshop';
            $MailToName = '';

            $YourEamilPassword = "Natit#2019";   //Your email password from which email you send.
// If you use SMTP. Please configure the bellow settings.

            $SmtpHost = "smtp.gmail.com"; // sets the SMTP server
            $SmtpDebug = 0;                     // enables SMTP debug information (for testing)
            $SmtpAuthentication = true;                  // enable SMTP authentication
            $SmtpPort = 587;                    // set the SMTP port for the GMAIL server
            $SmtpUsername = $MailFrom; // SMTP account username
            $SmtpPassword = $YourEamilPassword;        // SMTP account password

            $mail->IsSMTP();  // telling the class to use SMTP
            $mail->SMTPDebug = $SmtpDebug;
            $mail->SMTPAuth = $SmtpAuthentication;     // enable SMTP authentication
            $mail->Port = $SmtpPort;             // set the SMTP port
            $mail->Host = $SmtpHost;           // SMTP server
            $mail->Username = $SmtpUsername; // SMTP account username
            $mail->Password = $SmtpPassword; // SMTP account password

            if ($MailFromName != '') {
                $mail->AddReplyTo($MailFrom, $MailFromName);
                $mail->From = $MailFrom;
                $mail->FromName = $MailFromName;
            } else {
                $mail->AddReplyTo($MailFrom);
                $mail->From = $MailFrom;
                $mail->FromName = $MailFrom;
            }

            if ($MailToName != '') {
                $mail->AddAddress($MailTo, $MailToName);
            } else {
                $mail->AddAddress($MailTo);
            }

            $mail->SMTPSecure = 'tls';
            $mail->Subject = $subject;

            $mail->MsgHTML($TemplateMessage);

            try {
                $mail->Send();
            } catch (phpmailerException $e) {
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
            }
            

       
            /* mail to user or vendor ends here */

          if ($getUserdetails->type == '2') {
                

                $adminsql = "SELECT * FROM  webshop_tbladmin WHERE id= '1' ";
                $adminstmt = $db->prepare($adminsql);
                $adminstmt->execute();
                $getAdmindetails = $adminstmt->fetchObject();

                $MailTo = $getAdmindetails->email;

                if ($MailTo != $getUserdetails->email) {

                    $MailFrom = 'webshop.com';
                    $subject = "webshop.com- Vendor Registered";

                    $TemplateMessage = "Hello Admin,<br />";
                    $TemplateMessage .= "Vendor named " . $getUserdetails->fname . " " . $getUserdetails->lname . " has successfully signed the account.Please login and activate the account.<br />";

                    $TemplateMessage .= "Thanks,<br />";
                    $TemplateMessage .= "webshop.com<br />";


                    $mail = new PHPMailer(true);

                    $IsMailType = 'SMTP';

                    $MailFrom = 'mail@natitsolved.com';    //  Your email password

                    $MailFromName = 'Webshop';
                    $MailToName = '';

                    $YourEamilPassword = "Natit#2019";   //Your email password from which email you send.
// If you use SMTP. Please configure the bellow settings.

                    $SmtpHost = "smtp.gmail.com"; // sets the SMTP server
                    $SmtpDebug = 0;                     // enables SMTP debug information (for testing)
                    $SmtpAuthentication = true;                  // enable SMTP authentication
                    $SmtpPort = 587;                    // set the SMTP port for the GMAIL server
                    $SmtpUsername = $MailFrom; // SMTP account username
                    $SmtpPassword = $YourEamilPassword;        // SMTP account password

                    $mail->IsSMTP();  // telling the class to use SMTP
                    $mail->SMTPDebug = $SmtpDebug;
                    $mail->SMTPAuth = $SmtpAuthentication;     // enable SMTP authentication
                    $mail->Port = $SmtpPort;             // set the SMTP port
                    $mail->Host = $SmtpHost;           // SMTP server
                    $mail->Username = $SmtpUsername; // SMTP account username
                    $mail->Password = $SmtpPassword; // SMTP account password

                    if ($MailFromName != '') {
                        $mail->AddReplyTo($MailFrom, $MailFromName);
                        $mail->From = $MailFrom;
                        $mail->FromName = $MailFromName;
                    } else {
                        $mail->AddReplyTo($MailFrom);
                        $mail->From = $MailFrom;
                        $mail->FromName = $MailFrom;
                    }

                    if ($MailToName != '') {
                        $mail->AddAddress($MailTo, $MailToName);
                    } else {
                        $mail->AddAddress($MailTo);
                    }

                    $mail->SMTPSecure = 'tls';
                    $mail->Subject = $subject;

                    $mail->MsgHTML($TemplateMessage);

                    try {
                        $mail->Send();
                    } catch (phpmailerException $e) {
                        echo $e->errorMessage(); //Pretty error messages from PHPMailer
                    }
                    
                } 
            }
          //  echo $lastID;
            //exit;
            
        
        $country_id= $country;
        
             $sqlcountrycode = "SELECT * FROM webshop_countries WHERE id='$country_id'";
        $stmtcountrycode = $db->prepare($sqlcountrycode);
        $stmtcountrycode->execute();
        $getCode = $stmtcountrycode->fetchObject();
        $country_code = $getCode->phonecode;
       $smsphoneno = $getCode->phonecode.$phone;
       $smsphoneno = (int)$smsphoneno;
            $otpverifylink = "#/mobileverify/" .  base64_encode($lastID);
       $mobilemessage= "Your+Mobile+Verification+Code+Is:+$smsotopcode";
        $smslink ='http://www.kwtsms.com/API/send/?username=gmt24&password=aljassar&sender=KWT-MESSAGE&mobile='.$smsphoneno.'&lang=2&message='.$mobilemessage;
       //$data['smslink']=$smslink;
          
       $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,$smslink);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        
        if (empty($buffer)){
            $data['smsstatus']='0';
        }
        else{
             $data['smsstatus'] ='1';
        }
       
       
            
            $data['Ack'] = '1';
            $data['smslink'] =$otpverifylink;
            $app->response->setStatus(200);

            $db = null;
        } catch (PDOException $e) {

            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = $e->getMessage();

            $app->response->setStatus(401);
        }
    } else {
        $data['user_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Emailid or phone no already exists';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function userlogin() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $email = isset($body->email) ? $body->email : '';
    $password = isset($body->password) ? $body->password : '';
    $password = md5($password);
    $status = 1;
    $is_admin_approved = '1';
    $email_verified = '1';


    $sql = "SELECT * FROM webshop_user WHERE email='" . $email . "' AND password='" . $password . "' AND status='" . $status . "' AND is_admin_approved ='" . $is_admin_approved . "' AND email_verified='" . $email_verified . "'";

    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $userCount = $stmt->rowCount();

        if ($userCount == 0) {
            $data['Ack'] = '0';
            $data['msg'] = 'Username Or Password Is Invalid !!!';
            $app->response->setStatus(200);
        } else {

            if ($user->status == 0) {
                $data['Ack'] = '0';
                $data['msg'] = 'Account Is Not Activated yet';
                $app->response->setStatus(200);
            } else {

                $data['Ack'] = '1';
                $data['msg'] = 'Loggedin Successfully';


                if ($user->image != '') {
                    $user_image = SITE_URL . 'upload/user_image/' . $user->image;
                } else {
                    $user_image = SITE_URL . 'webservice/no-user.png';
                }


                $data['UserDetails'] = array(
                    "user_id" => stripslashes($user->id),
                    "email" => stripslashes($user->email),
                    "fname" => stripslashes($user->fname),
                    "lname" => stripslashes($user->lname),
                    "user_type" => stripslashes($user->type),
                    "user_image" => stripslashes($user_image),
                    "country" => stripslashes($user->country),
                    "state" => stripslashes($user->state),
                    "city" => stripslashes($user->city),
                );
                $app->response->setStatus(200);
            }
        }

        $db = null;
    } catch (PDOException $e) {
        print_r($e);
        $data['Ack'] = '0';
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function forgetpassword() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $email = $body->email;


    $byeamil = findByConditionArray(array('email' => $email), ' webshop_user');
    if (!empty($byeamil)) {

        $sql = "SELECT * FROM  webshop_user WHERE email=:email ";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        $to = $email;
        $password = rand(1111, 9999);
        $forgot_pass_otp = md5($password);

        $sql = "UPDATE  webshop_user SET password=:password WHERE email=:email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("password", $forgot_pass_otp);
        $stmt->bindParam("email", $email);
        $stmt->execute();

        $MailTo = $email;
        $MailFrom = 'info@webshop.com';
        $subject = "webshop.com- Your Password Request";
        $TemplateMessage = "Hello " . $getUserdetails->fname . "<br /><br / >";
        $TemplateMessage .= "You have asked for your new password. Your Password is OTP below :<br />";
        $TemplateMessage .= "<br />Password :" . $password;
        $TemplateMessage .= "<br /><br />Thanks,<br />";
        $TemplateMessage .= "webshop.com<br />";
        $mail = new PHPMailer(true);
        $IsMailType = 'SMTP';
        $MailFrom = 'mail@natitsolved.com';  
        $MailFromName = 'Webshop';
        $MailToName = '';
        $YourEamilPassword = "Natit#2019"; 
        $SmtpHost = "smtp.gmail.com"; // sets the SMTP server
        $SmtpDebug = 0;                     // enables SMTP debug information (for testing)
        $SmtpAuthentication = true;                  // enable SMTP authentication
        $SmtpPort = 587;                    // set the SMTP port for the GMAIL server
        $SmtpUsername = $MailFrom; // SMTP account username
        $SmtpPassword = $YourEamilPassword;        // SMTP account password
        $mail->IsSMTP();  // telling the class to use SMTP
        $mail->SMTPDebug = $SmtpDebug;
        $mail->SMTPAuth = $SmtpAuthentication;     // enable SMTP authentication
        $mail->Port = $SmtpPort;             // set the SMTP port
        $mail->Host = $SmtpHost;           // SMTP server
        $mail->Username = $SmtpUsername; // SMTP account username
        $mail->Password = $SmtpPassword; // SMTP account password

        if ($MailFromName != '') {
            $mail->AddReplyTo($MailFrom, $MailFromName);
            $mail->From = $MailFrom;
            $mail->FromName = $MailFromName;
        } else {
            $mail->AddReplyTo($MailFrom);
            $mail->From = $MailFrom;
            $mail->FromName = $MailFrom;
        }

        if ($MailToName != '') {
            $mail->AddAddress($MailTo, $MailToName);
        } else {
            $mail->AddAddress($MailTo);
        }

        $mail->SMTPSecure = 'tls';
        $mail->Subject = $subject;

        $mail->MsgHTML($TemplateMessage);

        try {
            $mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        }

        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Mail Send Successfully';
        $app->response->setStatus(200);
    } else {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Email not found in our database';
        $app->response->setStatus(200);
    }


    $app->response->write(json_encode($data));
}

function changepassword() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $password = isset($body->password) ? $body->password : '';
    $password = md5($password);
    $sql = "UPDATE webshop_user SET password=:password WHERE id=:user_id";
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam("password", $password);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $data['Ack'] = 1;
        $data['msg'] = 'Password updated successfully';
        $app->response->setStatus(200);
    } catch (PDOException $e) {
        $data['Ack'] = 0;
        $data['msg'] = 'Password updation error';
        $app->response->setStatus(200);
    }
    $app->response->write(json_encode($data));
}

function updateProfile() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());

    $user_id = $body["user_id"];
    $fname = isset($body["fname"]) ? $body["fname"] : '';
    $lname = isset($body["lname"]) ? $body["lname"] : '';
    $address = isset($body["address"]) ? $body["address"] : '';
    $phone = isset($body["phone"]) ? $body["phone"] : '';
    $email = isset($body["email"]) ? $body["email"] : '';
    $business_type = isset($body["business_type"]) ? $body["business_type"] : '';
    $gender = isset($body["gender"]) ? $body["gender"] : '';
    $secret_key = isset($body["secret_key"]) ? $body["secret_key"] : '';
    $publish_key = isset($body["publish_key"]) ? $body["publish_key"] : '';
    $bankname = isset($body["bankname"]) ? $body["bankname"] : '';
    $ibanno = isset($body["ibanno"]) ? $body["ibanno"] : '';
    $language_preference = isset($body["language_preference"]) ? $body["language_preference"] : '';
    $country = isset($body["country"]) ? $body["country"] : '';
    $state = isset($body["state"]) ? $body["state"] : '';
    $city = isset($body["city"]) ? $body["city"] : '';
    $country_preference = isset($body["country_preference"]) ? $body["country_preference"] : '';

    $currency_preference = isset($body["currency_preference"]) ? $body["currency_preference"] : '';

    $lat = isset($body["my_latitude"]) ? $body["my_latitude"] : '';
    $lang = isset($body["my_longitude"]) ? $body["my_longitude"] : '';

    /* if (get_lat_long($address)) {
      $latlang = get_lat_long($address);
      $val = implode(',', $latlang);
      $value = explode(',', $val);
      $lat = $value[0];
      $lang = $value[1];
      } else {
      $latlang = '';
      $val = '';
      $value = '';
      $lat = '';
      $lang = '';
      } */


    $latlang = '';
    $val = '';
    $value = '';
   // $lat = '';
   // $lang = '';


//print_r($latlang);
// $lat;
// echo $lang;
// exit;
// $dob = date("Y-m-d", strtotime($dob));


    $date = date('Y-m-d');


    $sql = "UPDATE webshop_user set fname=:fname,lname=:lname ,secret_key=:secret_key,publish_key=:publish_key,email=:email,address=:address,phone=:phone,gender=:gender,business_type=:business_type,my_latitude=:lat,my_longitude=:lang,bankname=:bankname,ibanno=:ibanno,language_preference=:language_preference,country=:country,state=:state,city=:city,country_preference=:country_preference,currency_preference=:currency_preference WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fname", $fname);
        $stmt->bindParam("lname", $lname);
        $stmt->bindParam("phone", $phone);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("business_type", $business_type);
        $stmt->bindParam("address", $address);
        $stmt->bindParam("gender", $gender);
        $stmt->bindParam("publish_key", $publish_key);
        $stmt->bindParam("secret_key", $secret_key);
        $stmt->bindParam("lat", $lat);
        $stmt->bindParam("lang", $lang);

        $stmt->bindParam("bankname", $bankname);
        $stmt->bindParam("ibanno", $ibanno);
        $stmt->bindParam("language_preference", $language_preference);
        $stmt->bindParam("country", $country);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("city", $city);
        $stmt->bindParam("country_preference", $country_preference);
        $stmt->bindParam("currency_preference", $currency_preference);
        $stmt->bindParam("id", $user_id);
       // $lastID = $db->lastInsertId();
        $stmt->execute();

//        if (!empty($_FILES['civilid1'])) {
//
//            if ($_FILES['civilid1']['tmp_name'] != '') {
//
//                $target_path = "../upload/user_image/";
//
//                $usercivilid1_name = $_FILES['civilid1']['name'];
//
//                $userfile_tmp = $_FILES['civilid1']['tmp_name'];
//
//                $img = $target_path . $usercivilid1_name;
//
//                move_uploaded_file($userfile_tmp, $img);
//
//                $sqlimgcivilid1 = "UPDATE webshop_user SET civilid1=:image WHERE id=$user_id";
//
//                $stmtcivilid1 = $db->prepare($sqlimgcivilid1);
//                $stmtcivilid1->bindParam("image", $usercivilid1_name);
//                $stmtcivilid1->execute();
//            }
//        }
//
//        if (!empty($_FILES['civilid2'])) {
//
//            if ($_FILES['civilid2']['tmp_name'] != '') {
//
//                $target_path = "../upload/user_image/";
//
//                $usercivilid2_name = $_FILES['civilid2']['name'];
//
//                $userfile_tmp = $_FILES['civilid2']['tmp_name'];
//
//                $img = $target_path . $usercivilid2_name;
//
//                move_uploaded_file($userfile_tmp, $img);
//
//                $sqlimgcivilid2 = "UPDATE webshop_user SET civilid2=:image WHERE id=$user_id";
//
//                $stmtcivilid2 = $db->prepare($sqlimgcivilid2);
//                $stmtcivilid2->bindParam("image", $usercivilid2_name);
//                $stmtcivilid2->execute();
//            }
//        }

        
         if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                                foreach ($_FILES['image']['name'] as $key1 => $file) {



                                    if ($_FILES['image']['tmp_name'][$key1] != '') {

                                        $target_path = "../upload/user_image/";

                                        $userfile_name = $_FILES['image']['name'][$key1];

                                        $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                                        $img = $target_path . $userfile_name;
                                        move_uploaded_file($userfile_tmp, $img);

                                        $sqlimg = "UPDATE webshop_user SET civilid1=:civilid1 WHERE id=$user_id";
                                        $stmt1 = $db->prepare($sqlimg);
                                        $stmt1->bindParam("civilid1", $_FILES['image']['name'][0]);
                                        $stmt1->execute();


                                        $sqlimg = "UPDATE webshop_user SET civilid2=:civilid2 WHERE id=$user_id";
                                        $stmt1 = $db->prepare($sqlimg);
                                        $stmt1->bindParam("civilid2", $_FILES['image']['name'][1]);
                                        $stmt1->execute();
                                    }
                                }
                            }


        if (@$_FILES['profile_image']['tmp_name'] != '') {
//  $id = $request->post("user_id");

            $target_path = "../upload/user_image/";

//  $target_path = "user_images/";
            $userfile_name = $_FILES['profile_image']['name'];
            $userfile_tmp = $_FILES['profile_image']['tmp_name'];
            $image = time() . $userfile_name;
            $img = $target_path . $image;
            move_uploaded_file($userfile_tmp, $img);

            $sqlimg = "UPDATE webshop_user SET image=:image WHERE id=:id";
            $stmt1 = $db->prepare($sqlimg);
            $stmt1->bindParam("id", $user_id);
            $stmt1->bindParam("image", $image);
            $stmt1->execute();
        }



        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Profile Updated Successfully...';


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error !!!';
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function userprofile() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
$images =array();
// $email = $body['email'];
    $user_id = $body->user_id;

    try {
        $db = getConnection();


        $sql = "SELECT * FROM  webshop_user WHERE id=:id ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        if ($getUserdetails->image != '') {
            $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
        } else {
            $profile_image = SITE_URL . 'webservice/no-user.png';
        }

        if ($getUserdetails->civilid1 != '') {
            $images[] = SITE_URL . 'upload/user_image/' . $getUserdetails->civilid1;
        } else {
            $images[] = '';
        }

        if ($getUserdetails->civilid2 != '') {
            $images[] = SITE_URL . 'upload/user_image/' . $getUserdetails->civilid2;
        } else {
            $images[] = '';
        }



        $data['UserDetails'] = array(
            "user_id" => stripslashes($getUserdetails->id),
            "fname" => stripslashes($getUserdetails->fname),
            "lname" => stripslashes($getUserdetails->lname),
            "description" => strip_tags(stripslashes($getUserdetails->description)),
            "gender" => stripslashes($getUserdetails->gender),
            "user_type" => stripslashes($getUserdetails->type),
            "business_type" => stripslashes($getUserdetails->business_type),
            "email" => stripslashes($getUserdetails->email),
            "address" => stripslashes($getUserdetails->address),
            "secret_key" => stripslashes($getUserdetails->secret_key),
            "publish_key" => stripslashes($getUserdetails->publish_key),
            "phone" => stripslashes($getUserdetails->phone),
            "dob" => stripslashes($getUserdetails->dob),
            "profile_image" => stripslashes($profile_image),
            "device_type" => stripslashes($getUserdetails->device_type),
            "device_token_id" => stripslashes($getUserdetails->device_token_id),
            "my_latitude" => stripslashes($getUserdetails->my_latitude),
            "my_longitude" => stripslashes($getUserdetails->my_longitude),
            "sale_notify" => stripslashes($getUserdetails->sale_notify),
            "new_message_notify" => stripslashes($getUserdetails->new_message_notify),
            "review_notify" => stripslashes($getUserdetails->review_notify),
            "subscription_notify" => stripslashes($getUserdetails->subscription_notify),
            "ibanno" => stripslashes($getUserdetails->ibanno),
            "bankname" => stripslashes($getUserdetails->bankname),
            "language_preference" => stripslashes($getUserdetails->language_preference),
           // "civilid1" => stripslashes($civilid1),
           // "civilid2" => stripslashes($civilid2),
            "add_date" => stripslashes($getUserdetails->add_date),
            "country" => stripslashes($getUserdetails->country),
            "state" => stripslashes($getUserdetails->state),
            "city" => stripslashes($getUserdetails->city),
            "country_preference" => stripslashes($getUserdetails->country_preference),
            'images'=>$images,
            "currency_preference" => stripslashes($getUserdetails->currency_preference));


        $data['Ack'] = '1';
        $data['msg'] = 'Success';
        $app->response->setStatus(200);


        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function listProducts() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $brand = isset($body->brand) ? $body->brand : '';

    $sql = "SELECT * from  webshop_products where status=1";

    if ($brand != '' AND $brand != 'undefined') {
        $sql .= " AND `brands`='" . $brand . "'";
    }

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {


                if ($product->image != '') {
                    $image = SITE_URL . 'upload/product_image/' . $product->image;
                } else {
                    $image = SITE_URL . 'webservice/not-available.jpg';
                }


                $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam("id", $product->cat_id);
                $stmt2->execute();
                $getcategory = $stmt2->fetchObject();
                if (!empty($getcategory)) {
                    $categoryname = $getcategory->name;
                }



                $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam("id", $product->subcat_id);
                $stmt3->execute();
                $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }


//Seller Information

                $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("id", $product->uploader_id);
                $stmt1->execute();
                $getUserdetails = $stmt1->fetchObject();

                if (!empty($getUserdetails)) {
                    $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                    $seller_address = $getUserdetails->address;
                    $seller_phone = $getUserdetails->phone;
                    $email = $getUserdetails->email;

                    if ($getUserdetails->image != '') {
                        $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                    } else {
                        $profile_image = SITE_URL . 'webservice/no-user.png';
                    }
                } else {
                    $profile_image = '';
                }

                $data['productList'][] = array(
                    "id" => stripslashes($product->id),
                    "image" => stripslashes($image),
                    "price" => stripslashes($product->price),
                    "description" => strip_tags(stripslashes($product->description)),
                    "category_name" => $categoryname,
                    "subcategory_name" => $subcategoryname,
                    "seller_id" => stripslashes($product->uploader_id),
                    "seller_image" => $profile_image,
                    "seller_name" => stripslashes($seller_name),
                    "seller_address" => stripslashes($seller_address),
                    "seller_phone" => stripslashes($seller_phone),
                    "productname" => ''
                );
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['productList'] = array();
            $data['Ack'] = '0';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {


        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function ProductsDetails() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $product_id = isset($body->product_id) ? $body->product_id : '';
     $product_id = urldecode ( base64_decode($product_id) ) ;
    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_products WHERE id=:id ";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $product_id);
    $stmt->execute();
    $product = $stmt->fetchObject();

    $sqlinterest = "SELECT * from  webshop_interested WHERE userid=:userid and productid='" . $product_id . "'";

    $stmtinterest = $db->prepare($sqlinterest);
    $stmtinterest->bindParam("userid", $user_id);
    $stmtinterest->execute();
    $interest = $stmtinterest->fetchObject();
    $interested = '';
    if (!empty($interest)) {
        $interested = $interest->interested;
    } else {
        $interested = 0;
    }

    $sqltotallike = "SELECT * from  webshop_favourite WHERE product_id=:product_id";

    $stmttotallike = $db->prepare($sqltotallike);
    $stmttotallike->bindParam("product_id", $product_id);
    $stmttotallike->execute();
    $totallike = $stmttotallike->rowCount();


    $sql_userlike = "SELECT * from  webshop_like WHERE product_id=:product_id AND user_id=:user_id";

    $stmt_userlike = $db->prepare($sql_userlike);
    $stmt_userlike->bindParam("product_id", $product_id);
    $stmt_userlike->bindParam("user_id", $user_id);
    $stmt_userlike->execute();
    $userlike = $stmt_userlike->rowCount();


    $userlike = 0;
    
    $sql_userlike = "SELECT * from  webshop_like WHERE product_id=:product_id AND user_id=:user_id";
    $stmt_userlike = $db->prepare($sql_userlike);
    $stmt_userlike->bindParam("product_id", $product_id);
    $stmt_userlike->bindParam("user_id", $user_id);
    $stmt_userlike->execute();
    $userlike = $stmt_userlike->rowCount();
    
    $sqlavgr = "SELECT avg(rating) as avgr FROM  webshop_reviews WHERE product_id=:id ";
    $stmtavgr = $db->prepare($sqlavgr);
    $stmtavgr->bindParam("id", $product_id);
    $stmtavgr->execute();
    $avgrating = $stmtavgr->fetchObject();
    if (!empty($avgrating)) {
        $averagerating = $avgrating->avgr;
    }else{
        $averagerating=0;
    }
    
    
    

    if (!empty($product)) {

       /* if ($product->image != '') {
            $image = SITE_URL . 'upload/product_image/' . $product->image;
        } else {
            $image = SITE_URL . 'webservice/not-available.jpg';
        } */
        $price = $product->price;
       if($user_id){
                              
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                           // echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                    }else{
                        $price = $product->price;
                    } 
        
        
        $sqlproduct_imaget = "SELECT * FROM  webshop_product_image WHERE product_id=:product_id ";
        $stmtproduct_imaget = $db->prepare($sqlproduct_imaget);
        $stmtproduct_imaget->bindParam("product_id", $product->id);
        $stmtproduct_imaget->execute();
        $get_product_imaget = $stmtproduct_imaget->fetchAll(PDO::FETCH_OBJ);
        if (!empty($get_product_imaget)) {
           foreach($get_product_imaget as $img){
              $image[]=array(
                  'src'=>SITE_URL . 'upload/product_image/' .$img->image,
                  'desc'=>$img->image,
              ); 
           }
            
        }else{
            $image = SITE_URL . 'webservice/not-available.jpg';
        }
        
        
        $sqlbracelet = "SELECT * FROM  webshop_bracelet WHERE id=:id ";
        $stmtbracelet = $db->prepare($sqlbracelet);
        $stmtbracelet->bindParam("id", $product->breslet_type);
        $stmtbracelet->execute();
        $getbracelet = $stmtbracelet->fetchObject();
        if (!empty($getbracelet)) {
            $braceletname = $getbracelet->type;
        }else{
            $braceletname = '';
        }
        
        
        
        
        

        $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("id", $product->cat_id);
        $stmt2->execute();
        $getcategory = $stmt2->fetchObject();
        if (!empty($getcategory)) {
            $categoryname = $getcategory->name;
        }



        $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
        $stmt3 = $db->prepare($sql3);
        $stmt3->bindParam("id", $product->subcat_id);
        $stmt3->execute();
        $getsubcategory = $stmt3->fetchObject();
//        if (!empty($getsubcategory)) {
//            $subcategoryname = $getsubcategory->name;
//        }
//Seller Information

        $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("id", $product->uploader_id);
        $stmt1->execute();
        $getUserdetails = $stmt1->fetchObject();

        if (!empty($getUserdetails)) {
            $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
            $seller_address = $getUserdetails->address;
            $seller_phone = $getUserdetails->phone;
            $email = $getUserdetails->email;

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = SITE_URL . 'webservice/no-user.png';
            }
        } else {
            $profile_image = '';
        }

        $sqlfav = "SELECT * FROM  webshop_favourite WHERE product_id=:id and user_id=:user_id and status=1 ";
        $stmtfav = $db->prepare($sqlfav);
        $stmtfav->bindParam("id", $product_id);
        $stmtfav->bindParam("user_id", $user_id);
        $stmtfav->execute();
        $getfav = $stmtfav->fetchObject();
        if (!empty($getfav)) {
            $is_fav = 1;
        } else {
            $is_fav = 0;
        }
        $sqlcart = "SELECT * FROM webshop_cart WHERE user_id=:userid AND product_id=:productid";

        $stmtcart = $db->prepare($sqlcart);
        $stmtcart->bindParam("userid", $user_id);
        $stmtcart->bindParam("productid", $product_id);

        $stmtcart->execute();
        $productcart = $stmtcart->fetchObject();

        if (!empty($productcart)) {
            $quantity = $productcart->quantity;
//$count = $stmtcart->rowCount();
//if($count > 0)
//{
            $new_quantity = $quantity + 1;
        } else {
            $new_quantity = 1;
        }

        $sqlproduct = "SELECT * FROM webshop_biddetails WHERE  productid=:productid";
        $stmtproduct = $db->prepare($sqlproduct);
        $stmtproduct->bindParam("productid", $product_id);
        $stmtproduct->execute();
        $count = $stmtproduct->rowCount();

        $sqlproduct12 = "SELECT * FROM webshop_biddetails WHERE  productid=:productid group by userid";
        $stmtproduct12 = $db->prepare($sqlproduct12);
        $stmtproduct12->bindParam("productid", $product_id);
        $stmtproduct12->execute();
        $countuniquebids = $stmtproduct12->rowCount();


        $sqlbid = "SELECT MAX(bidprice) as maxbid FROM webshop_biddetails WHERE userid=:userid AND productid=:productid";
        $stmtbid = $db->prepare($sqlbid);
        $stmtbid->bindParam("userid", $user_id);
        $stmtbid->bindParam("productid", $product_id);
        $stmtbid->execute();
        $naxbid = $stmtbid->fetchObject();
//$count = $stmtproduct->rowCount();
//print_r($naxbid);
        $yourmaxbid = '';
        if ($naxbid->maxbid != '') {
            $yourmaxbid = $naxbid->maxbid;
// echo 'hi';
        }


        $sqlbidmax = "SELECT * FROM webshop_biddetails WHERE bidprice=$product->lastbidvalue AND productid=:productid";

        $stmtbidmax = $db->prepare($sqlbidmax);
        $stmtbidmax->bindParam("productid", $product_id);
        $stmtbidmax->execute();
        $naxbidmax = $stmtbidmax->fetchObject();
        $higestbiddername = '';
        $higestbidderbid = '';
//print_r($naxbidmax);
        if (!empty($naxbidmax)) {
            if ($naxbidmax->id != '') {
                $sqlmaxbidder = "SELECT * FROM webshop_user WHERE id=$naxbidmax->userid ";
                $stmtmaxbidder = $db->prepare($sqlmaxbidder);
//echo 'hi';
// exit;
                $stmtmaxbidder->execute();
                $getUserdetailmaxbidder = $stmtmaxbidder->fetchObject();
                $higestbiddername = $getUserdetailmaxbidder->fname . " " . $getUserdetailmaxbidder->lname;
                $higestbidderbid = $naxbidmax->bidprice;
            } else {
                $higestbiddername = '';
            }
        }
//echo $higestbiddername;exit;
        $sqlbrand = "SELECT *  FROM webshop_brands WHERE id=:brand_id";
        $stmtbrand = $db->prepare($sqlbrand);
        $stmtbrand->bindParam("brand_id", $product->brands);

        $stmtbrand->execute();
        $naxbrand = $stmtbrand->fetchObject();

        $sqlcat_id = "SELECT *  FROM webshop_category WHERE id=:cat_id";
        $stmtcat_id = $db->prepare($sqlcat_id);
        $stmtcat_id->bindParam("cat_id", $product->cat_id);
        $stmtcat_id->execute();
        $naxcat = $stmtcat_id->fetchObject();







        $starttime = '';
        $time = '';
        $action_date = '';
        $action_time = '';

        if ($product->type == '2') {
            $sqltime_slot_id = "SELECT *  FROM webshop_auctiondates WHERE id=:time_slot_id";
            $stmttime_slot_id = $db->prepare($sqltime_slot_id);
            $stmttime_slot_id->bindParam("time_slot_id", $product->time_slot_id);
            $stmttime_slot_id->execute();
            $naxtime_slot_id = $stmttime_slot_id->fetchObject();
            $time = $naxtime_slot_id->end_time;
            $starttime = $naxtime_slot_id->start_time;
            $auctiondate = explode(' ', $naxtime_slot_id->start_time);
            $action_date = $auctiondate[0];
            $action_time = $auctiondate[1];
//$action_time = date('H:i', strtotime($action_time));
        } else {
            $starttime = '';

            $time = '';
            $action_date = '';
            $action_time = '';
        }
        $time_now = '';
        $ctime = '';

        if ($product->type == '2') {
            $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));

            $ctime = date('Y-m-d H:i:s', $time_now);
        } else {
            $time_now = '';
            $ctime = '';
        }


        $sqlbidhistory = "SELECT w.fname,w.lname,wb.bidprice FROM webshop_biddetails as wb inner join webshop_user as w on w.id=wb.userid WHERE wb.productid=:productid order by wb.id desc limit 0,4";
        $stmtbidhistory = $db->prepare($sqlbidhistory);
        $stmtbidhistory->bindParam("productid", $product_id);
        $stmtbidhistory->execute();
        $bidhistory = $stmtbidhistory->fetchAll(PDO::FETCH_OBJ);
        if (!empty($bidhistory)) {
            foreach ($bidhistory as $history) {


                $allhistory[] = array(
                    "bidprice" => stripslashes($history->bidprice),
                    "name" => stripslashes($history->fname . " " . $history->lname)
                );
            }
        } else {
            $allhistory = array();
        }
        $baseauctionprice = $product->baseauctionprice;
        $thresholdprice = $product->thresholdprice;
        $bidincrement = $product->bidincrement;
         $nextbidprice = $product->nextbidprice;
         $lastbidvalue = $product->lastbidvalue;
        
        if($product->type == 2){
            if($user_id){
                              
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                                $currency['currency_rate_to_usd'].'<br>';
                                $currency['currency_code'].'<br>';
                            $baseauctionprice = $product->baseauctionprice * $currency['currency_rate_to_usd'];
                            $thresholdprice = $product->thresholdprice * $currency['currency_rate_to_usd'];
                            $bidincrement = $product->bidincrement * $currency['currency_rate_to_usd'];
                            $nextbidprice = $product->nextbidprice * $currency['currency_rate_to_usd'];
                            $lastbidvalue = $product->lastbidvalue * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $baseauctionprice = $product->baseauctionprice;
                            $thresholdprice = $product->thresholdprice;
                            $bidincrement = $product->bidincrement;
                             $nextbidprice = $product->nextbidprice;
                             $lastbidvalue = $product->lastbidvalue;
                           // echo 'NO';
                        }
                              
                            
                        } else {
                           $baseauctionprice = $product->baseauctionprice;
                           $thresholdprice = $product->thresholdprice;
                           $bidincrement = $product->bidincrement;
                            $nextbidprice = $product->nextbidprice;
                            $lastbidvalue = $product->lastbidvalue;
                        }
                    }else{
                        $baseauctionprice = $product->baseauctionprice;
                        $thresholdprice = $product->thresholdprice;
                        $thresholdprice = $product->bidincrement;
                         $nextbidprice = $product->nextbidprice;
                         $lastbidvalue = $product->lastbidvalue;
                    }
        }
        
        
        //echo $price;exit;
//$aucshowtime=
//$count = $stmtproduct->rowCount();
//$date_purchase = $product->date_purchase;
$date_purchase = date('dS M,Y', strtotime($product->date_purchase));
        $data['productList'] = array(
            "id" => stripslashes($product->id),
            "image" => $image,
            "price" => stripslashes($price),
            "is_fav" => stripslashes($is_fav),
            "description" => strip_tags(stripslashes($product->description)),
            "category_name" => stripslashes($categoryname),
            // "subcategory_name" => stripslashes($subcategoryname),
            "seller_id" => stripslashes($product->uploader_id),
            "currency_code" => stripslashes($product->currency_code),
            "quantity" => stripslashes($product->quantity),
            "cartquantity" => stripslashes($new_quantity),
            "seller_image" => $profile_image,
            "seller_name" => stripslashes($seller_name),
            "seller_address" => stripslashes($seller_address),
            "seller_phone" => stripslashes($seller_phone),
            "productname" => '',
            "baseauctionprice" => stripslashes($baseauctionprice),
            "thresholdprice" => intval($thresholdprice),
            "bidincrement" => stripslashes($bidincrement),
            "nextbidprice" => stripslashes($nextbidprice),
            "lastbidvalue" => intval($lastbidvalue),
            "uploader_id" => stripslashes($product->uploader_id),
            "type" => stripslashes($product->type),
            //"preferred_date" => stripslashes($product->preferred_date),
            "preferred_date" => $time,
            "bidcount" => $count,
            "category" => stripslashes($naxcat->name),
            "brands" => $naxbrand->name,
            "gender" => stripslashes($product->gender),
            "maxbid" => $yourmaxbid,
            "start_time" => $starttime,
            "ctime" => $ctime,
            "countuniquebids" => $countuniquebids,
            'action_date' => $action_date,
            'action_time' => date('h:i A', strtotime($action_time)),
            'interest' => $interested,
            'totallike' => $totallike,
            'userlike' => $userlike,
            'is_fav' => $is_fav,
            'maxbiddername' => $higestbiddername,
            'higestbidderbid' => $higestbidderbid,
            'bidhistory' => $allhistory,
            'breslet_type' => stripslashes($braceletname),
            'model_year' => stripslashes($product->model_year),
            'movement' => stripslashes($product->movement),
            'status_watch' => stripslashes($product->status_watch),
            'size' => stripslashes($product->size),
            'date_purchase' => stripslashes($date_purchase),
            'owner_number' => stripslashes($product->owner_number),
            'averagerating' => number_format($averagerating,1)
        );



        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['productList'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function addFavoriteProduct() {

    $data = array();
    $getuserdetails = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();


    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $product_id = isset($body->product_id) ? $body->product_id : '';
    $seller_id = isset($body->seller_id) ? $body->seller_id : '';

//$pro_id = $body->pro_id;
    $status = 1;
    $date = date('Y-m-d');
    $db = getConnection();


    $sql = "SELECT * FROM  webshop_favourite WHERE product_id=:product_id AND user_id=:user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("product_id", $product_id);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $contactdetails = $stmt->fetchObject();
    $count = $stmt->rowCount();

    if ($count == 0) {

//    echo $paramValue = $app->request->post('fname');
        $sql = "INSERT INTO  webshop_favourite (product_id, user_id,seller_id, status, date) VALUES (:product_id, :user_id,:seller_id, :status, :date)";



        try {


//$resturant_id = $resturantDetails->id;

            $stmt = $db->prepare($sql);
            $stmt->bindParam("product_id", $product_id);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("seller_id", $seller_id);
            $stmt->bindParam("status", $status);
            $stmt->bindParam("date", $date);

            $stmt->execute();
//   

            $sql2 = "SELECT * FROM  webshop_user WHERE id='" . $user_id . "'";
            $stmtcat = $db->prepare($sql2);
            $stmtcat->execute();
            $getUserdetails = $stmtcat->fetchObject();

            $full_name = $getUserdetails->fname . " " . $getUserdetails->lname;

// $stmt2->execute();

            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Added Successfully...';





            $app->response->setStatus(200);

            $db = null;
//echo json_encode($user);
        } catch (PDOException $e) {
//error_log($e->getMessage(), 3, '/var/tmp/php.log');
            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = $e->getMessage();
//echo '{"error":{"text":'. $e->getMessage() .'}}';
            $app->response->setStatus(401);
        }
    } else {
        $sqldeletefab = " DELETE FROM  webshop_favourite WHERE product_id=:product_id AND user_id=:user_id";
        $stmtdeletefab = $db->prepare($sqldeletefab);
        $stmtdeletefab->bindParam("product_id", $product_id);
        $stmtdeletefab->bindParam("user_id", $user_id);
        $stmtdeletefab->execute();
// $contactdetails = $stmt->fetchObject();
// $count = $stmt->rowCount();
    }



    $app->response->write(json_encode($data));
}

function myFavoriteProduct() {
    $data = array();
    $favouriteUserDetails = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $status = 1;


    $favorite_sql = "SELECT * from webshop_favourite WHERE user_id =:user_id AND status =:status";
    $db = getConnection();
    $stmt = $db->prepare($favorite_sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->bindParam("status", $status);
    $stmt->execute();

//echo $favorite_sql;
//exit;

    $getFavouriteListing = $stmt->fetchAll(PDO::FETCH_OBJ);

//print_r($getFavouriteListing);
//exit;

    if (!empty($getFavouriteListing)) {
        foreach ($getFavouriteListing as $favourites) {

// $sqlUserDetails = "SELECT * FROM doori_user WHERE id='".$favourites->pro_id."'";
            $sqlUserDetails = "SELECT * FROM webshop_user WHERE id='" . $favourites->user_id . "'";
//echo $sqlUserDetails;
//exit;
            $stmt = $db->prepare($sqlUserDetails);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

//if (!empty($getUserdetails)) {



            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = SITE_URL . 'webservice/no-user.png';
            }


            $sqlproductDetails = "SELECT * FROM webshop_products WHERE id='" . $favourites->product_id . "'";
//echo $sqlUserDetails;
//exit;
            $stmt1 = $db->prepare($sqlproductDetails);
            $stmt1->execute();
            $productdetails = $stmt1->fetchObject();

            if ($productdetails->image != '') {
                $pro_image = SITE_URL . 'upload/product_image/' . $productdetails->image;
            } else {
                $pro_image = SITE_URL . 'webservice/not-available.jpg';
            }


            $favouriteProductList[] = array(
//"clinic_id" => stripslashes($favourites->favorite_clinicid),
                "user_id" => stripslashes($favourites->user_id),
                "favourite_pro_id" => stripslashes($favourites->product_id),
                "fullname" => stripslashes($getUserdetails->fname) . " " . stripslashes($getUserdetails->lname),
                "pro_name" => '',
                "product_description" => strip_tags(stripslashes($productdetails->description)),
                "id" => stripslashes($favourites->id),
                "pro_price" => stripslashes($productdetails->price),
                "quantity" => stripslashes($productdetails->quantity),
                "product_id" => stripslashes($productdetails->id),
                "user_image" => $profile_image,
                "pro_image" => $pro_image
            );
        }



        $data['favouriteProductList'] = $favouriteProductList;
        $data['Ack'] = 1;
        $data['msg'] = "Record Found";
        $app->response->setStatus(200);
//  }
    } else {
        $data['favouriteProductList'] = array();
        $data['Ack'] = 0;
        $data['msg'] = "Record Not Found";
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function updateProfilePhoto() {


    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());

    $user_id = $body["user_id"];


    try {
        $db = getConnection();


        if (@$_FILES['profile_image']['tmp_name'] != '') {


            $target_path = "../upload/user_image/";

            $userfile_name = $_FILES['profile_image']['name'];
            $userfile_tmp = $_FILES['profile_image']['tmp_name'];
            $image = time() . $userfile_name;
            $img = $target_path . $image;
            move_uploaded_file($userfile_tmp, $img);

            $sqlimg = "UPDATE webshop_user SET image=:image WHERE id=:id";
            $stmt1 = $db->prepare($sqlimg);
            $stmt1->bindParam("id", $user_id);
            $stmt1->bindParam("image", $image);
            $stmt1->execute();

            $sql = "SELECT * FROM webshop_user WHERE id=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $user_id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = SITE_URL . 'webservice/no-user.png';
            }
        }


        $data['last_id'] = $user_id;
        $data['image'] = $profile_image;
        $data['Ack'] = '1';
        $data['msg'] = 'User Image Updated Successfully.';


        $app->response->setStatus(200);

        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error !!!';
        $app->response->setStatus(401);
    }


    $app->response->write(json_encode($data));
}

// function addProduct() {
//     $data = array();
//     $app = \Slim\Slim::getInstance();
//     $request = $app->request();
//     $body = ($request->post());
//    $user_id = isset($body["user_id"]) ? $body["user_id"] : '';
//    $category =isset($body["cat_id"]) ? $body["cat_id"] : '';
//     $subcategory =isset($body["subcat_id"]) ? $body["subcat_id"] : '';
//     $name =isset($body["name"]) ? $body["name"] : '';
//     $description =isset($body["description"]) ? $body["description"] : '';
//     $currency =isset($body["currency"]) ? $body["currency"] : '';
//     $type = '1';
//     $price =isset($body["price"]) ? $body["price"] : '';
//      $quantity =isset($body["quantity"]) ? $body["quantity"] : '';
//      $brand =isset($body["brand"]) ? $body["brand"] : '';
//     $date = date("Y-m-d");
//    $db = getConnection();
//         $sql = "INSERT INTO webshop_products (uploader_id, cat_id, subcat_id,currency_code,type,name, description, price, add_date,quantity,brands) VALUES (:user_id, :cat_id, :subcat_id, :currency_code, :type,:name, :description, :price, :add_date,:quantity,:brand)";
//         try {
//             $db = getConnection();
//             $stmt = $db->prepare($sql);
//             $stmt->bindParam("user_id", $user_id);
//             $stmt->bindParam("cat_id", $category);
//              $stmt->bindParam("subcat_id", $subcategory);
//             $stmt->bindParam("name", $name);
//             $stmt->bindParam("description", $description);
//             $stmt->bindParam("currency_code", $currency);
//             $stmt->bindParam("type", $type);
//             $stmt->bindParam("price", $price);
//             $stmt->bindParam("quantity", $quantity);
//             $stmt->bindParam("add_date", $date);
//               $stmt->bindParam("brand", $brand);
//             $stmt->execute();
//             $lastID = $db->lastInsertId();
//             if(!empty($_FILES['image'])) {
//                 if ($_FILES['image']['tmp_name'] != '') {
//                 $target_path = "../upload/product_image/";
//                 $userfile_name = $_FILES['image']['name'];
//                 $userfile_tmp = $_FILES['image']['tmp_name'];
//                 $img = $target_path . $userfile_name;
//                 move_uploaded_file($userfile_tmp, $img);
//                 $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
//                 $stmt1 = $db->prepare($sqlimg);
//                 $stmt1->bindParam("image", $userfile_name);
//                 $stmt1->execute();
//                 }
//             }
//             $data['last_id'] = $lastID;
//             $data['Ack'] = 1;
//             $data['msg'] = 'Product added successfully.';
//             $app->response->setStatus(200);
//             $db = null;
//         } catch (PDOException $e) {
//             $data['user_id'] = '';
//             $data['Ack'] = 0;
//             $data['msg']='error';
//             $app->response->setStatus(401);
//         }
//     $app->response->write(json_encode($data));
// }

function homeSettings() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $sql = "SELECT * from  webshop_brands order by id";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $getAllBrands = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($getAllBrands)) {
        foreach ($getAllBrands as $brand) {


            if ($brand->image != '') {
                $brand_image = SITE_URL . 'upload/brand_image/' . $brand->image;
            } else {
                $brand_image = SITE_URL . 'webservice/not-available.jpg';
            }

            $brandList[] = array(
                "brand_id" => stripslashes($brand->id),
                "brand_name" => stripslashes($brand->name),
                "brand_image" => stripslashes($brand_image),
            );
        }
    }

    $sql2 = "SELECT * from  webshop_products where auctioned = 1 order by id";

    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();
    $auctionedProducts = $stmt2->fetchAll(PDO::FETCH_OBJ);

    if (!empty($auctionedProducts)) {
        foreach ($auctionedProducts as $auctioned) {


            if ($auctioned->image != '') {
                $product_image = SITE_URL . 'upload/product_image/' . $auctioned->image;
            } else {
                $product_image = SITE_URL . 'webservice/not-available.jpg';
            }

            $productList[] = array(
                "product_id" => stripslashes($auctioned->id),
                "product_name" => '',
                "product_description" => strip_tags(stripslashes($auctioned->description)),
                "product_image" => stripslashes($product_image),
            );
        }
    }

   $sqltopmodel = "SELECT * from  webshop_top_model where status= '1' ";

    $stmtsqltopmodel = $db->prepare($sqltopmodel);
    $stmtsqltopmodel->execute();
    $auctionedProductstopmodel = $stmtsqltopmodel->fetchAll(PDO::FETCH_OBJ);
    $categoryname ='';
    if (!empty($auctionedProductstopmodel)) {
        foreach ($auctionedProductstopmodel as $auctionedtopmodel) {


            if ($auctionedtopmodel->image != '') {
                $product_image_topmodel = SITE_URL . 'upload/product_image/' . $auctionedtopmodel->image;
            } else {
                $product_image_topmodel = SITE_URL . 'webservice/not-available.jpg';
            }
            
           
            
            $topproductList[] = array(
                "product_id" => stripslashes($auctionedtopmodel->id),
                "product_name" => stripslashes($auctionedtopmodel->name),
                "product_image" => stripslashes($product_image_topmodel),
            );
        }
       
    }
    
    $sql3 = "SELECT * from  webshop_products where launched = 1 order by id";

    $stmt3 = $db->prepare($sql3);
    $stmt3->execute();
    $launchedProducts = $stmt3->fetchAll(PDO::FETCH_OBJ);

    if (!empty($launchedProducts)) {
        foreach ($launchedProducts as $launched) {


            if ($launched->image != '') {
                $launchedproduct_image = SITE_URL . 'upload/product_image/' . $launched->image;
            } else {
                $launchedproduct_image = SITE_URL . 'webservice/not-available.jpg';
            }
            
            $top_product_name = $categoryname.'/'.$brand;
            $launchedproductList[] = array(
                "product_id" => stripslashes($launched->id),
                "product_name" => '',
                "product_description" => strip_tags(stripslashes($launched->description)),
                "product_price" => stripslashes($launched->price),
                "product_image" => stripslashes($launchedproduct_image),
            );
        }
    }



    if (!empty($brandList)) {
        $data['brandList'] = $brandList;
    } else {
        $data['brandList'] = array();
    }
    if (!empty($productList)) {
        $data['productList'] = $productList;
    } else {
        $data['productList'] = array();
    }
    
    if (!empty($topproductList)) {
        $data['topmodellist'] = $topproductList;
    } else {
        $data['topmodellist'] = array();
    }
    
    if (!empty($launchedproductList)) {
        $data['launchedproductList'] = $launchedproductList;
    } else {
        $data['launchedproductList'] = array();
    }
    $data['Ack'] = '1';
    $app->response->setStatus(200);

    $app->response->write(json_encode($data));
}

function listmyProducts() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_products WHERE uploader_id=:user_id and type = '1' order by id desc";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($getAllProducts)) {
        foreach ($getAllProducts as $product) {


            if ($product->image != '') {
                $image = SITE_URL . 'upload/product_image/' . $product->image;
            } else {
                $image = SITE_URL . 'webservice/not-available.jpg';
            }


            $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam("id", $product->cat_id);
            $stmt2->execute();
            $getcategory = $stmt2->fetchObject();
            if (!empty($getcategory)) {
                $categoryname = $getcategory->name;
            }

            
            $sql21 = "SELECT * FROM  webshop_brands WHERE id=:id ";
            $stmt21 = $db->prepare($sql21);
            $stmt21->bindParam("id", $product->brands);
            $stmt21->execute();
            $getbrand = $stmt21->fetchObject();
            if (!empty($getbrand)) {
                $brand = $getbrand->name;
            }
            
            

            $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam("id", $product->subcat_id);
            $stmt3->execute();
            $getsubcategory = $stmt3->fetchObject();
//            if (!empty($getsubcategory)) {
//                $subcategoryname = $getsubcategory->name;
//            }
//Seller Information


            if ($product->subscription_id != 0) {
                $sql4 = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                $stmt4 = $db->prepare($sql4);
                $stmt4->bindParam("id", $product->subscription_id);
                $stmt4->execute();
                $getexpiry = $stmt4->fetchObject();
                if (!empty($getexpiry)) {
                    $expirydate = date('dS M,Y', strtotime($getexpiry->expiry_date));
                }
            } else {
                $expirydate = "Free product";
            }


            $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("id", $product->uploader_id);
            $stmt1->execute();
            $getUserdetails = $stmt1->fetchObject();

            if (!empty($getUserdetails)) {
                $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                $seller_address = $getUserdetails->address;
                $seller_phone = $getUserdetails->phone;
                $email = $getUserdetails->email;

                if ($getUserdetails->image != '') {
                    $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                } else {
                    $profile_image = SITE_URL . 'webservice/no-user.png';
                }
            } else {
                $profile_image = '';
            }
            $id = urlencode ( base64_encode($product->id));
            $data['productList'][] = array(
                "id" => stripslashes($id),
                "image" => stripslashes($image),
                "price" => stripslashes($product->price),
                "description" => strip_tags(stripslashes(substr($product->description, 0, 50))),
                "category_name" => $categoryname,
                "brand_name" => $brand,
                //"subcategory_name" => $subcategoryname,
                "seller_id" => stripslashes($product->uploader_id),
                "seller_image" => $profile_image,
                "seller_name" => stripslashes($seller_name),
                "seller_address" => stripslashes($seller_address),
                "seller_phone" => stripslashes($seller_phone),
                "productname" => '',
                "product_status" => stripslashes($product->product_status),
                "approved" => $product->approved,
                "live_status" => $product->status,
                "expiry_date" => $expirydate,
                "top_product" => $product->top_product
            );
        }


        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['productList'] = array();
        $data['Ack'] = '0';
        $data['msg'] = 'Sorry! No record found.';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function deleteProduct() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $product_id = isset($body->product_id) ? $body->product_id : '';

    $status = 0;

    $db = getConnection();

    $sql = "DELETE from webshop_products WHERE id=:product_id and uploader_id=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("product_id", $product_id);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();

        $data['product_id'] = $product_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Product deleted successfully';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {

        $data['product_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Deletion Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function editProduct() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body["user_id"]) ? $body["user_id"] : '';
    $product_id = isset($body["product_id"]) ? $body["product_id"] : '';
    $category = isset($body["cat_id"]) ? $body["cat_id"] : '';
    $subcategory = isset($body["subcat_id"]) ? $body["subcat_id"] : '';
    $name = isset($body["name"]) ? $body["name"] : '';
    $description = isset($body["description"]) ? $body["description"] : '';
    $currency = isset($body["currency"]) ? $body["currency"] : '';
    $price = isset($body["price"]) ? $body["price"] : '';


    $db = getConnection();

    $sql = "SELECT * from webshop_products WHERE id=:product_id and uploader_id=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("product_id", $product_id);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();

        $sql2 = "UPDATE  webshop_products SET cat_id=:cat_id, subcat_id=:subcat_id, name=:name, description=:description, currency_code=:currency_code, price=:price, WHERE id=:product_id and uploader_id=:uploader_id";
        $db = getConnection();
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("cat_id", $category);
        $stmt2->bindParam("subcat_id", $subcategory);
        $stmt2->bindParam("name", $name);
        $stmt2->bindParam("description", $description);
        $stmt2->bindParam("currency_code", $currency);
        $stmt2->bindParam("price", $price);
        $stmt->bindParam("product_id", $product_id);
        $stmt->bindParam("uploader_id", $user_id);
        $stmt2->execute();

        $data['Ack'] = '1';
        $data['msg'] = 'Product Updated Successfully';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {

        $data['product_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Updation Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listCategory() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_category where status=1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getCategory = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count1 = $stmt->rowCount();
        foreach ($getCategory as $category) {

            $allcategory[] = array(
                "id" => stripslashes($category->id),
                "name" => stripslashes($category->name)
            );
        }

        $data['categorylist'] = $allcategory;
         $data['count1'] = $count1;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listSubcategory() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $cat_id = isset($body->cat_id) ? $body->cat_id : '';

    try {

        $sql = "SELECT * from webshop_category where brand_id = '" . $cat_id . "' and status=1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubcategory = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubcategory as $subcategory) {


            $allsubcategory[] = array(
                "brand_id" => stripslashes($subcategory->brand_id),
                "id" => stripslashes($subcategory->id),
                "name" => stripslashes($subcategory->name)
            );
        }
        if (!empty($allsubcategory)) {
            $data['subcategorylist'] = $allsubcategory;
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {

            $data['subcategorylist'] = '';
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listCurrency() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_currency";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getCurrency = $stmt->fetchAll(PDO::FETCH_OBJ);
//print_r($getCurrency);exit;
        foreach ($getCurrency as $currency) {

            $allcurrency[] = array(
                "id" => stripslashes($currency->id),
                "name" => stripslashes($currency->name),
                "code" => stripslashes($currency->code),
                //"symbol" => stripslashes($currency->symbol),
            );
        }

        $data['currencylist'] = $allcurrency;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getCms() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $id = isset($body->id) ? $body->id : '';

    $sql = "SELECT * from webshop_cms WHERE id=:id";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $cmdetails = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($cmdetails)) {
        foreach ($cmdetails as $cms) {

            $data['cmsdetails'] = array(
                "id" => stripslashes($cms->id),
                "pagename" => stripslashes($cms->pagename),
                "title" => stripslashes($cms->title),
                "pagedetails" => strip_tags(stripslashes($cms->pagedetail)));
        }


        $data['Ack'] = 1;
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['Ack'] = 0;
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function addToCart() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $userid = isset($body->userid) ? $body->userid : '';
    $productid = isset($body->productid) ? $body->productid : '';

    $quantity = isset($body->quantity) ? $body->quantity : '';
    $datetoday = date('Y-m-d H:i:s');
    try {





        $sql = "SELECT * FROM  webshop_cart WHERE user_id=:userid AND product_id=:productid ORDER BY id DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userid", $userid);
        $stmt->bindParam("productid", $productid);

        $stmt->execute();
        $product = $stmt->fetchObject();

        $count = $stmt->rowCount();
        if ($count == 0) {


            $sqlcart = "SELECT * FROM  webshop_cart WHERE user_id=:userid order by id desc limit 1";
            $db = getConnection();
            $stmtcart = $db->prepare($sqlcart);
            $stmtcart->bindParam("userid", $userid);

            $stmtcart->execute();
            $cartdetails = $stmtcart->fetchObject();

            $countcart = $stmtcart->rowCount();
            if ($countcart != 0) {

                $old_product = $cartdetails->product_id;


                $sqlproduct = "SELECT * FROM webshop_products WHERE id=:product_id";
                $db = getConnection();
                $stmtproduct = $db->prepare($sqlproduct);
                $stmtproduct->bindParam("product_id", $old_product);

                $stmtproduct->execute();
                $oldproductdetails = $stmtproduct->fetchObject();

                $old_product_seller = $oldproductdetails->uploader_id;


                $sqlproduct_new = "SELECT * FROM webshop_products WHERE id=:new_product_id";
                $db = getConnection();
                $stmtproductnew = $db->prepare($sqlproduct_new);
                $stmtproductnew->bindParam("new_product_id", $productid);

                $stmtproductnew->execute();
                $newproductdetails = $stmtproductnew->fetchObject();

                $new_product_seller = $newproductdetails->uploader_id;
//exit;


                if ($old_product_seller == $new_product_seller) {




                    $sqlChkProduct = "SELECT * FROM webshop_products where id = '" . $productid . "'";
                    $stmtProduct = $db->query($sqlChkProduct);
                    $getProducts = $stmtProduct->fetchObject();
                    $db_quantity = $getProducts->quantity;
                    if ($db_quantity >= $quantity) {

                        $sql = "INSERT INTO  webshop_cart (user_id, product_id, quantity,date) VALUES (:userid, :productid, :quantity, :datetoday)";
                        $db = getConnection();
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam("userid", $userid);
                        $stmt->bindParam("productid", $productid);

                        $stmt->bindParam("quantity", $quantity);
                        $stmt->bindParam("datetoday", $datetoday);

                        $stmt->execute();
                        $data['last_id'] = $db->lastInsertId();
                        $data['Ack'] = '1';

                        $app->response->setStatus(200);
                        $data['msg'] = 'Product Added To Cart';
                    } else {

                        $data['Ack'] = '3';

                        $app->response->setStatus(200);
                        $data['msg'] = 'Quantity cannot be more than ' . $db_quantity;
                    }
                } else {
                    $data['Ack'] = '4';

                    $app->response->setStatus(200);
                    $data['msg'] = 'Cannot buy from multiple seller.';
                }
            } else {


                $sqlChkProduct = "SELECT * FROM webshop_products where id = '" . $productid . "'";
                $stmtProduct = $db->query($sqlChkProduct);
                $getProducts = $stmtProduct->fetchObject();
                $db_quantity = $getProducts->quantity;
                if ($db_quantity >= $quantity) {

                    $sql = "INSERT INTO  webshop_cart (user_id, product_id, quantity,date) VALUES (:userid, :productid, :quantity, :datetoday)";
                    $db = getConnection();
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam("userid", $userid);
                    $stmt->bindParam("productid", $productid);

                    $stmt->bindParam("quantity", $quantity);
                    $stmt->bindParam("datetoday", $datetoday);

                    $stmt->execute();
                    $data['last_id'] = $db->lastInsertId();
                    $data['Ack'] = '1';

                    $app->response->setStatus(200);
                    $data['msg'] = 'Product Added To Cart';
                } else {

                    $data['Ack'] = '3';

                    $app->response->setStatus(200);
                    $data['msg'] = 'Quantity cannot be more than ' . $db_quantity;
                }
            }
        } else {

            if ($quantity == 0) {
                $sql = "DELETE FROM  webshop_cart WHERE user_id=:userid AND product_id=:productid";
//$db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("userid", $userid);
                $stmt->bindParam("productid", $productid);

                $stmt->execute();
                $data['last_id'] = '';
                $data['Ack'] = '1';
                $app->response->setStatus(200);
                $data['msg'] = 'Cart Updated';
            } else {



                $sqlcart = "SELECT * FROM  webshop_cart WHERE user_id=:userid order by id desc limit 1";
                $db = getConnection();
                $stmtcart = $db->prepare($sqlcart);
                $stmtcart->bindParam("userid", $userid);

                $stmtcart->execute();
                $cartdetails = $stmtcart->fetchObject();

                $old_product = $cartdetails->product_id;


                $sqlproduct = "SELECT * FROM webshop_products WHERE id=:product_id";
                $db = getConnection();
                $stmtproduct = $db->prepare($sqlproduct);
                $stmtproduct->bindParam("product_id", $old_product);

                $stmtproduct->execute();
                $oldproductdetails = $stmtproduct->fetchObject();

                $old_product_seller = $oldproductdetails->uploader_id;


                $sqlproduct_new = "SELECT * FROM webshop_products WHERE id=:new_product_id";
                $db = getConnection();
                $stmtproductnew = $db->prepare($sqlproduct_new);
                $stmtproductnew->bindParam("new_product_id", $productid);

                $stmtproductnew->execute();
                $newproductdetails = $stmtproductnew->fetchObject();

                $new_product_seller = $newproductdetails->uploader_id;



                if ($old_product_seller == $new_product_seller) {
                    $status = 0;

                    $sqlChkProduct = "SELECT * FROM webshop_products where id = '" . $productid . "'";
                    $stmtProduct = $db->query($sqlChkProduct);
                    $getProducts = $stmtProduct->fetchObject();
                    $db_quantity = $getProducts->quantity;


                    if ($db_quantity >= $quantity) {
                        $sqlChkCart = "SELECT * FROM  webshop_cart WHERE user_id='" . $userid . "' AND product_id='" . $productid . "'";
                        $stmtCart = $db->query($sqlChkCart);
                        $getCart = $stmtCart->fetchObject();
//$oldquan=$getCart->quantity;
//$quantity=$oldquan+1;                
                        $sql = "UPDATE  webshop_cart SET quantity=:quantity WHERE user_id=:userid AND product_id=:productid";
                        $db = getConnection();
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam("userid", $userid);
                        $stmt->bindParam("productid", $productid);
                        $stmt->bindParam("quantity", $quantity);

                        $stmt->execute();

                        $data['last_id'] = '';
                        $data['Ack'] = '2';
                        $app->response->setStatus(200);
                        $data['msg'] = 'Product Updated Successfully';
                    } else {

                        $data['Ack'] = '3';

                        $app->response->setStatus(200);
                        $data['msg'] = 'Quantity cannot be more than' . $db_quantity;
                    }
                } else {


                    $data['Ack'] = '4';

                    $app->response->setStatus(200);
                    $data['msg'] = 'Cannot buy from multiple seller.';
                }
            }
        }
        $db = null;
//echo json_encode($user);
    } catch (PDOException $e) {

        print_r($e);
        exit;
        $data['Ack'] = 0;
        $app->response->setStatus(401);
        $data['msg'] = 'Password updation error';
    }

    $app->response->write(json_encode($data));
}

function ListOrderSeller() {
    $data = array();
    $allorders = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $sellerid = isset($body->sellerid) ? $body->sellerid : '';
//$type = $body->type;

    try {

        $sql = "SELECT * FROM webshop_order WHERE seller_id=:seller_id order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("seller_id", $sellerid);
//$stmt->bindParam("type", $type);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $orders) {





                $sql1 = "SELECT * FROM  webshop_bookings WHERE orderid='" . $orders->id . "' ORDER BY id ASC LIMIT 1";
                $stmt1 = $db->prepare($sql1);
                $stmt1->execute();
                $orderlst = $stmt1->fetchObject();

//print_r($orderlst);
//echo $orderlst->product_id;

                $sql2 = "SELECT * FROM webshop_products WHERE id='" . $orderlst->product_id . "'";
                $stmt2 = $db->prepare($sql2);
                $stmt2->execute();
                $prolst = $stmt2->fetchObject();


//print_r($prolst);
                if ($prolst->image != '') {
                    $pro_image = SITE_URL . 'upload/product_image/' . $prolst->image;
                } else {
                    $pro_image = SITE_URL . 'webservice/not-available.jpg';
                }



                $sql3 = "SELECT * FROM  webshop_bookings WHERE orderid='" . $orders->id . "'";
                $stmt3 = $db->prepare($sql3);
                $stmt3->execute();
                $orderlst = $stmt3->fetchObject();
                $count = $stmt3->rowCount();






                $allorders[] = array(
                    "id" => stripslashes($orders->id),
                    "order_id" => stripslashes($orders->unique_id),
                    //"product_id" => stripslashes($orders->product_id),
                    "total_price" => stripslashes($orders->total_price),
                    "order_date" => stripslashes($orders->date),
                    "shipping_name" => stripslashes($orders->shipping_name),
                    "shipping_address" => stripslashes($orders->shipping_address),
                    "transaction_id" => stripslashes($orders->transaction_id),
                    "product_image" => $pro_image,
                    "total_product" => $count
                );
            }
            $data['allorders'] = $allorders;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        } else {
            $data['allorders'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['allorders'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function ListOrderBuyer() {
    $data = array();
    $allorders = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $userid = isset($body->userid) ? $body->userid : '';

    try {

        $sql = "SELECT * FROM webshop_auction_winner WHERE user_id=:user_id  order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $userid);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $orders) {


                $sql2 = "SELECT * FROM webshop_products WHERE id='" . $orders->product_id . "'";
                $stmt2 = $db->prepare($sql2);
                $stmt2->execute();
                $prolst = $stmt2->fetchObject();


                if ($prolst->image != '') {
                    $pro_image = SITE_URL . 'upload/product_image/' . $prolst->image;
                } else {
                    $pro_image = SITE_URL . 'webservice/not-available.jpg';
                }



                $sql3 = "SELECT * FROM webshop_biddetails WHERE productid='" . $orders->product_id . "' and userid = '" . $userid . "' order by id desc limit 0,1";
                $stmt3 = $db->prepare($sql3);
                $stmt3->execute();
                $orderlst = $stmt3->fetchObject();
                $count = $stmt3->rowCount();



                $allorders[] = array(
                    "id" => stripslashes($orders->product_id),
                    "total_price" => stripslashes($orderlst->bidprice),
                    "date" => date('dS M Y', strtotime($orders->date)),
                    "status" => $orders->is_paid,
                    "product_image" => $pro_image,
                        //"total_product" => $count
                );
            }
            $data['allorders'] = $allorders;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        } else {
            $data['allorders'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['allorders'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function checkout() {
    $data = array();


    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $stripe_api_sk_key = "sk_test_5K401tpKS27cCLjkYe3LTXCv";
    $stripe_api_pk_key = "pk_test_avhCsvHAaou7xWu7SxVCzptC";

    $user_id = $body->user_id;

    $total_amount = $body->total_amount;
    $shipping_name = $body->shipping_name;


    $shipping_address = $body->shipping_address;


//$tokenID = $body->tokenID;
    $order_id = time();
    $order_date = date('Y-m-d H:i:s');


    $db = getConnection();









    $sql_delivery = "SELECT * FROM  webshop_tbladmin where id = '1'";
    $stmt_delivery = $db->query($sql_delivery);
    $getDeliveryCharge = $stmt_delivery->fetchObject();

    $delivery_amount = $getDeliveryCharge->service_percent;


    $order_status = 'P';
//  exit;
    $sql = "INSERT INTO webshop_order (unique_id, user_id,total_price,date,delivery_amount,status,shipping_name,shipping_address) VALUES (:unique_id, :user_id, :total_amount, :order_date,:delivery_amount,:order_status,:shipping_name,:shipping_address)";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("unique_id", $order_id);
    $stmt->bindParam("user_id", $user_id);
    $stmt->bindParam("shipping_name", $shipping_name);
    $stmt->bindParam("shipping_address", $shipping_address);
    $stmt->bindParam("total_amount", $total_amount);
    $stmt->bindParam("order_date", $order_date);



    $stmt->bindParam("order_status", $order_status);
    $stmt->bindParam("delivery_amount", $delivery_amount);
    $stmt->execute();
// $stmt->debugDumpParams();
    $orderID = $db->lastInsertId();














// END OF INSERTION FOR WALLET =======================================


    $sql = "SELECT * FROM webshop_cart WHERE user_id=:userid";
//    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("userid", $user_id);
    $stmt->execute();
    $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

    $count = $stmt->rowCount();
    if ($count > 0) {
        foreach ($getproducts as $products) {

            $productDetails = "select * FROM  webshop_products WHERE id='" . $products->product_id . "'";
            $stmtProductDetails = $db->query($productDetails);
            $productData = $stmtProductDetails->fetchObject();
            $previous_quantity = $productData->quantity;
            $product_id = $products->product_id;
            $price = $productData->price;
            $quantity = $products->quantity;
            $amount = ($price * $products->quantity);
            $seller_id = $productData->uploader_id;
//echo '<br>';
            $category_id = $productData->cat_id;
            $subcategory_id = $productData->subcat_id;
            $shipping_cost = 0;



//$total = $shipping_cost + $amount;
            $order_date = gmdate('Y-m-d H:i:s');


            $insertOrderDetails = "insert into webshop_bookings (orderid, product_id,buyer_id,seller_id, total_price, quantity, category_id,subcategory_id,booking_date) values(:order_id,:product_id,:buyer_id,:seller_id,:amount,:quantity,:category_id,:subcategory_id,:order_date)";

            $stmt = $db->prepare($insertOrderDetails);
            $stmt->bindParam("order_id", $orderID);
            $stmt->bindParam("product_id", $product_id);
            $stmt->bindParam("buyer_id", $user_id);
            $stmt->bindParam("seller_id", $seller_id);

            $stmt->bindParam("quantity", $quantity);

            $stmt->bindParam("subcategory_id", $subcategory_id);
            $stmt->bindParam("category_id", $category_id);
            $stmt->bindParam("amount", $amount);
            $stmt->bindParam("order_date", $order_date);
            $stmt->execute();
            $orderDetailsID = $db->lastInsertId();

            $new_quantity = $previous_quantity - $quantity;

            $sql22 = "SELECT * FROM webshop_user WHERE id='" . $user_id . "'";
            $stmt2 = $db->query($sql22);
            $stmt2->execute();
            $getUser = $stmt2->fetchObject();

            $user_type = $getUser->type;

            if ($user_type == 1) {
                $sqlproduct = "UPDATE webshop_products SET quantity=:quantity WHERE id=:productid";
//   $db = getConnection();
                $stmtproduct = $db->prepare($sqlproduct);
//$stmtproduct->bindParam("userid", $userid);
                $stmtproduct->bindParam("productid", $product_id);
                $stmtproduct->bindParam("quantity", $new_quantity);
                $stmtproduct->execute();
            }
            $is_read = 0;
            $date = date("Y-m-d");



            $sql222 = "SELECT * FROM webshop_products WHERE id='" . $product_id . "'";
            $stmt22 = $db->query($sql222);
            $stmt22->execute();
            $getProduct = $stmt22->fetchObject();
            $product_name = $getProduct->name;

            if (!empty($getUser)) {
                $full_name = $getUser->fname;
                $message = $full_name . ' purchased your product ' . $product_name;
                $type = 'Product Purchase';
                $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, date, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :date, :is_read,:last_id)";

                $stmtt = $db->prepare($sqlFriend);
                $stmtt->bindParam("from_id", $user_id);
                $stmtt->bindParam("to_id", $seller_id);
                $stmtt->bindParam("type", $type);
                $stmtt->bindParam("msg", $message);
                $stmtt->bindParam("date", $date);
                $stmtt->bindParam("last_id", $orderDetailsID);
                $stmtt->bindParam("is_read", $is_read);
                $stmtt->execute();
            }

            $sqlproduct = "UPDATE webshop_order SET seller_id=:seller_id WHERE id=:id";
//   $db = getConnection();
            $stmtproduct = $db->prepare($sqlproduct);
//$stmtproduct->bindParam("userid", $userid);
            $stmtproduct->bindParam("id", $orderID);
            $stmtproduct->bindParam("seller_id", $seller_id);
            $stmtproduct->execute();
        }





// MAKING CART EMPTY

        $sql = "DELETE FROM webshop_cart WHERE user_id=:userid";
        $stmtEmptyCarts = $db->prepare($sql);
        $stmtEmptyCarts->bindParam("userid", $user_id);
        $stmtEmptyCarts->execute();

// ============================================================================================





        $data['orderID'] = $orderID;
//$data['Ack'] = 1;



        $data['Ack'] = '1';
        $data['msg'] = 'Interest Shown Successfully.';






        $db = null;
        $app->response->setStatus(200);
    }



    $app->response->write(json_encode($data));
}

function cartCount() {

    $data = array();

    $app = \Slim\Slim::getInstance();

    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from webshop_cart WHERE user_id=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);

        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();

        $getChats = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();

        $data['Ack'] = '1';
        $data['count'] = $count;

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['count'] = 'Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function OrderDetails() {
    $data = array();
    $allorders = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $orderid = isset($body->orderid) ? $body->orderid : '';
    $totalprice = 0;
//$type = $body->type;

    try {

        $sql = "SELECT * FROM webshop_bookings WHERE orderid=:order_id  order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("order_id", $orderid);
//$stmt->bindParam("type", $type);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $orders) {


                $sql = "SELECT * FROM webshop_user WHERE id=:id ";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("id", $orders->buyer_id);
                $stmt->execute();
                $getUserdetails = $stmt->fetchObject();

                $full_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;

                if ($getUserdetails->image != '') {
                    $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                } else {
                    $profile_image = '';
                }

                $sqlproduct = "SELECT * FROM webshop_products WHERE id=:id ";
                $stmtproduct = $db->prepare($sqlproduct);
                $stmtproduct->bindParam("id", $orders->product_id);
                $stmtproduct->execute();
                $getProductdetails = $stmtproduct->fetchObject();

                if ($getProductdetails->image != '') {
                    $product_image = SITE_URL . 'upload/product_image/' . $getProductdetails->image;
                } else {
                    $product_image = '';
                }






                $allorders[] = array(
                    "id_details" => stripslashes($orders->id),
                    "full_name" => stripslashes($full_name),
                    "product_id" => stripslashes($orders->product_id),
                    "profile_image" => stripslashes($profile_image),
                    "product_name" => stripslashes($getProductdetails->name),
                    "product_image" => stripslashes($product_image),
                    "total_price" => stripslashes($orders->total_price),
                    "quantity" => stripslashes($orders->quantity),
                    "product_price" => stripslashes($getProductdetails->price),
                    "order_date" => stripslashes($orders->booking_date));

                $totalprice = $totalprice + $orders->total_price;
            }
            $subtotal = $totalprice;

            $totalsub = $sqlorder = "SELECT * FROM  webshop_order WHERE id=:id ";
            $stmtorder = $db->prepare($sqlorder);
            $stmtorder->bindParam("id", $orderid);
            $stmtorder->execute();
            $getorderdetails = $stmtorder->fetchObject();

            $sqll = "SELECT * FROM webshop_user WHERE id=:id ";
            $stmtt = $db->prepare($sqll);
            $stmtt->bindParam("id", $getorderdetails->user_id);
            $stmtt->execute();
            $getUserdetailss = $stmtt->fetchObject();

            $full_name = $getUserdetailss->fname . ' ' . $getUserdetails->lname;
            $user_email = $getUserdetailss->email;
            $user_phone = $getUserdetailss->phone;

            if ($getUserdetailss->image != '') {
                $profile_imagee = SITE_URL . 'upload/user_image/' . $getUserdetailss->image;
            } else {
                $profile_imagee = '';
            }



            $sqlvendor = "SELECT * FROM webshop_user WHERE id=:id ";
            $stmtvendor = $db->prepare($sqlvendor);
            $stmtvendor->bindParam("id", $getorderdetails->seller_id);
            $stmtvendor->execute();
            $getVendordetails = $stmtvendor->fetchObject();

            $full_name_vendor = $getVendordetails->fname . ' ' . $getVendordetails->lname;
            $vendor_email = $getVendordetails->email;
            $vendor_phone = $getVendordetails->phone;
            $vendor_address = $getVendordetails->address;
            $vendor_lat = $getVendordetails->my_latitude;
            $vendor_long = $getVendordetails->my_longitude;

            if ($getVendordetails->image != '') {
                $profile_image_vendor = SITE_URL . 'upload/user_image/' . $getVendordetails->image;
            } else {
                $profile_image_vendor = '';
            }


            $sql_delivery = "SELECT * FROM webshop_tbladmin where id = '1'";
            $stmt_delivery = $db->query($sql_delivery);
            $getDeliveryCharge = $stmt_delivery->fetchObject();

            $service_charge = $getDeliveryCharge->service_percent;


            $orders = array(
                "id" => stripslashes($getorderdetails->id),
                "order_date" => stripslashes($getorderdetails->date),
                "service_percent" => stripslashes($service_charge),
                "customer_name" => stripslashes($full_name),
                "customer_email" => stripslashes($user_email),
                "customer_phone" => stripslashes($user_phone),
                "customer_image" => stripslashes($profile_imagee),
                "vendor_name" => stripslashes($full_name_vendor),
                "vendor_email" => stripslashes($vendor_email),
                "vendor_phone" => stripslashes($vendor_phone),
                "vendor_address" => stripslashes($vendor_address),
                "vendor_image" => stripslashes($profile_image_vendor),
                "vendor_lattitude" => stripslashes($vendor_lat),
                "vendor_longitude" => stripslashes($vendor_long),
                "sub_total" => stripslashes($subtotal),
                "grand_total" => stripslashes($getorderdetails->total_price),
                "unique_id" => stripslashes($getorderdetails->unique_id),
                "shipping_name" => stripslashes($getorderdetails->shipping_name),
                "shipping_address" => stripslashes($getorderdetails->shipping_address),
            );

            $data['allorders'] = $allorders;
            $data['orders'] = $orders;

            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        } else {
            $data['allorders'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['allorders'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function getCart() {
    $data = array();
    $allproducts = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;


    try {

        $sql = "SELECT * FROM webshop_cart WHERE user_id=:userid";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userid", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        $finalPriceSubTotal = 0;
        $totalfinalquantity = 0;
        if ($count > 0) {
            foreach ($getproducts as $products) {

                $productDetails = "select * FROM  webshop_products WHERE `id`='" . $products->product_id . "'";
                $stmtProductDetails = $db->query($productDetails);
                $productData = $stmtProductDetails->fetchObject();


                if ($productData->image == '') {
                    $image_url = SITE_URL . 'upload/no.png';
                } else {
                    $image_url = SITE_URL . 'upload/product_image/' . $productData->image;
                }


                $finalPrice = ($productData->price * $products->quantity);
                $finalPriceSubTotal = $finalPriceSubTotal + ($productData->price * $products->quantity);
                $totalfinalquantity = $products->quantity + $totalfinalquantity;

//$restaurant_id=$products->restaurant_id;

                $allproducts[] = array(
                    "cart_id" => stripslashes($products->id),
                    "id" => stripslashes($productData->id),
                    "name" => stripslashes($productData->name),
                    "quantity" => stripslashes($products->quantity),
                    "seller_price" => stripslashes($productData->price),
                    "total_price" => $finalPrice,
                    "itemImage" => stripslashes($image_url));
            }

            $sql_delivery = "SELECT * FROM webshop_tbladmin where id = '1'";
            $stmt_delivery = $db->query($sql_delivery);
            $getDeliveryCharge = $stmt_delivery->fetchObject();

            $service_charge = $getDeliveryCharge->service_percent;
            $pricepercentprice = ($service_charge / 100) * $finalPriceSubTotal;

            $data['admin_percent'] = $service_charge;
            $data['all_cart_products'] = $allproducts;
            $data['final_quantity'] = $totalfinalquantity;
            $data['sub_total'] = $finalPriceSubTotal;
            $data['grand_total'] = floor($finalPriceSubTotal + $pricepercentprice);
// $data['grand_total'] = $finalPriceSubTotal;


            $data['Ack'] = 1;
            $app->response->setStatus(200);
        } else {

            $data['all_cart_products'] = array();
            $data['sub_total'] = '0';
            $data['grand_total'] = '0';

            $data['Ack'] = 0;
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {

        $data['all_cart_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function removeProductFromCart() {
//$userid, $productid
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $cartid = isset($body->cart_id) ? $body->cart_id : '';

    try {
        $sql_exists = "SELECT * FROM webshop_cart WHERE id=:id";
        $db = getConnection();
        $stmtexists = $db->prepare($sql_exists);
//$stmtexists->bindParam("userid", $userid);
        $stmtexists->bindParam("id", $cartid);
        $stmtexists->execute();

        if ($stmtexists->rowCount() > 0) {
            $sql = "DELETE FROM webshop_cart WHERE id=:id";

            $stmt = $db->prepare($sql);
//$stmt->bindParam("userid", $userid);
            $stmt->bindParam("id", $cartid);
            $stmt->execute();
            $db = null;
            $app->response->setStatus(200);
            $data['Ack'] = '1';
            $data['msg'] = 'Item Removed Successfully';
        } else {
            $data['Ack'] = '0';
            $data['msg'] = 'Item Not Exists';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
//print_r($e);
//error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error!!!';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

// function ListNotification() {
//     $data = array();            
//     $app = \Slim\Slim::getInstance();
//     $request = $app->request();
//     $body2 = $app->request->getBody();
//     $body = json_decode($body2);
//     $user_id = isset($body->user_id) ? $body->user_id : '';   
//     $sql = "SELECT * FROM `webshop_notification` WHERE `to_id` = '".$user_id."' ORDER BY `id` DESC";
//         $db = getConnection();
//         $stmt = $db->prepare($sql);
//         $stmt->execute();
//         $notificationUserdetailsAll = $stmt->fetchAll(PDO::FETCH_OBJ);
//         $notification_count = $stmt->rowCount();
//         if (!empty($notificationUserdetailsAll)) {
//     foreach ($notificationUserdetailsAll as $notificationUserdetails) {
//      $userDetails = array();
//     $sql2 = "SELECT * FROM webshop_user WHERE id=:from_id";
//     $statement = $db->prepare($sql2);
//     $statement->bindParam("from_id", $notificationUserdetails->from_id);
//     $statement->execute();
//     $getFromUserdetails = $statement->fetchObject();
//     if ($getFromUserdetails->image != '') {
//             $profile_image = SITE_URL . 'upload/user_image/' . $getFromUserdetails->image;
//         } else {
//           $profile_image =  SITE_URL . 'webservice/no-user.png';
//         }
//     $sql3 = "SELECT * FROM webshop_user WHERE id=:to_id";
//     $statement = $db->prepare($sql3);
//     $statement->bindParam("to_id", $notificationUserdetails->to_id);
//     $statement->execute();
//     $getToUserdetails = $statement->fetchObject();
//     $sql4 = "UPDATE webshop_notification SET is_read=1 WHERE to_id=:user_id";
//         $stmt4 = $db->prepare($sql4);
//         $stmt4->bindParam("user_id", $user_id);
//         $stmt4->execute();
//     $all_notifications[] = array(
//         "id" => stripslashes($notificationUserdetails->id),
//         "from_id" => stripslashes($notificationUserdetails->from_id),
//          "from_userimg" => $profile_image,
//        "fromName" => stripslashes($getFromUserdetails->fname)." ".stripslashes($getFromUserdetails->lname),
//         "to_id" => stripslashes($notificationUserdetails->to_id),
//         "toName" => stripslashes($getToUserdetails->fname)." ".stripslashes($getToUserdetails->fname),
//         "message" => stripslashes($notificationUserdetails->msg),
//         "type" => stripslashes($notificationUserdetails->type),
//         "date" => stripslashes($notificationUserdetails->date),
//         );
//     }
//     $data['noti_count'] = $notification_count;
//     $data['all_notifications']=$all_notifications;
//     $data['Ack'] = '1';
//     $data['msg'] = 'List Notification Found';
//     $app->response->setStatus(200);
//     } else {
//         $data['Ack'] = '0';
//         $app->response->setStatus(200);
//         $data['msg'] = 'No Records Found';
//         }
//    $app->response->write(json_encode($data));
// }

function ListNotification() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * FROM `webshop_notification` WHERE `to_id` = '" . $user_id . "' ORDER BY `id` DESC";

    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $notificationUserdetailsAll = $stmt->fetchAll(PDO::FETCH_OBJ);
    $notification_count = $stmt->rowCount();

    if (!empty($notificationUserdetailsAll)) {
        foreach ($notificationUserdetailsAll as $notificationUserdetails) {

            $userDetails = array();

            if ($notificationUserdetails->from_id == '0') {

                $sql2 = "SELECT * FROM webshop_tbladmin WHERE id= '1'";
                $statement = $db->prepare($sql2);
                $statement->execute();
                $getFromUserdetails = $statement->fetchObject();


                $profile_image = SITE_URL . 'webservice/Admin.png';

                $get_name = $getFromUserdetails->name . " " . $getFromUserdetails->lname;
            } else {

                $sql2 = "SELECT * FROM webshop_user WHERE id=:from_id";
                $statement = $db->prepare($sql2);
                $statement->bindParam("from_id", $notificationUserdetails->from_id);
                $statement->execute();
                $getFromUserdetails = $statement->fetchObject();

                if (!empty($getFromUserdetails)) {
                    if ($getFromUserdetails->image != '') {
                        $profile_image = SITE_URL . 'upload/user_image/' . $getFromUserdetails->image;
                    } else {
                        $profile_image = SITE_URL . 'webservice/no-user.png';
                    }

                    $get_name = $getFromUserdetails->fname . " " . $getFromUserdetails->lname;
                }
            }



// if ($getFromUserdetails->image != '') {
//         $profile_image = SITE_URL . 'upload/user_image/' . $getFromUserdetails->image;
//     } else {
//       $profile_image =  SITE_URL . 'webservice/no-user.png';
//     }


            $sql3 = "SELECT * FROM webshop_user WHERE id=:to_id";
            $statement = $db->prepare($sql3);
            $statement->bindParam("to_id", $notificationUserdetails->to_id);
            $statement->execute();
            $getToUserdetails = $statement->fetchObject();

            $sql4 = "UPDATE webshop_notification SET is_read=1 WHERE to_id=:user_id";
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam("user_id", $user_id);
            $stmt4->execute();
            $datenoti = explode(' ', $notificationUserdetails->date);
            $all_notifications[] = array(
                "id" => stripslashes($notificationUserdetails->id),
                "from_id" => stripslashes($notificationUserdetails->from_id),
                "from_userimg" => $profile_image,
                //"fromName" => stripslashes($getFromUserdetails->fname)." ".stripslashes($getFromUserdetails->lname),
                "fromName" => stripslashes($get_name),
                "to_id" => stripslashes($notificationUserdetails->to_id),
                "toName" => stripslashes($getToUserdetails->fname) . " " . stripslashes($getToUserdetails->fname),
                "message" => stripslashes($notificationUserdetails->msg),
                "type" => stripslashes($notificationUserdetails->type),
                "last_id" => stripslashes($notificationUserdetails->last_id),
                "date" => stripslashes($datenoti[0]),
                "dateformat" => date('dS M Y', strtotime($datenoti[0])),
            );
        }

        $data['noti_count'] = $notification_count;
        $data['all_notifications'] = $all_notifications;
        $data['Ack'] = '1';
        $data['msg'] = 'List Notification Found';
        $app->response->setStatus(200);
    } else {
        $data['Ack'] = '0';
        $app->response->setStatus(200);
        $data['msg'] = 'No Records Found';
    }

    $app->response->write(json_encode($data));
}

function notiount() {

    $data = array();

    $app = \Slim\Slim::getInstance();

    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $to_id = isset($body->user_id) ? $body->user_id : '';
    $is_read = 0;


    $sql = "SELECT * from webshop_notification WHERE to_id=:to_id AND is_read=:is_read";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);

        $stmt->bindParam("to_id", $to_id);
        $stmt->bindParam("is_read", $is_read);
        $stmt->execute();


        $getChats = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();


        $data['Ack'] = '1';
        $data['count'] = $count;

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['count'] = 'Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listbrand() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_brands where 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        foreach ($getBrand as $brand) {

            $allbrand[] = array(
                "id" => stripslashes($brand->id),
                "name" => stripslashes($brand->name)
            );
        }

        $data['brandlist'] = $allbrand;
        $data['count']=$count;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function notifysettings() {

    $data = array();

    $app = \Slim\Slim::getInstance();

    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $sale_notify = isset($body->sale_notify) ? $body->sale_notify : '';
    $new_message_notify = isset($body->new_message_notify) ? $body->new_message_notify : '';
    $review_notify = isset($body->review_notify) ? $body->review_notify : '';
    $subscription_notify = isset($body->subscription_notify) ? $body->subscription_notify : '';

    $sql = "UPDATE webshop_user set sale_notify=:sale_notify ,new_message_notify=:new_message_notify , review_notify=:review_notify, subscription_notify=:subscription_notify WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sale_notify", $sale_notify);
        $stmt->bindParam("new_message_notify", $new_message_notify);
        $stmt->bindParam("review_notify", $review_notify);
        $stmt->bindParam("subscription_notify", $subscription_notify);
        $stmt->bindParam("id", $user_id);


        $stmt->execute();

        $data['Ack'] = '1';
        $data['msg'] = 'Notification Setting Updated Successfully';


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error !!!';
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function addProductNew() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());

    $user_id = isset($body["user_id"]) ? $body["user_id"] : '';

    $category = isset($body["cat_id"]) ? $body["cat_id"] : '';

    $name = isset($body["name"]) ? $body["name"] : '';
    $description = isset($body["description"]) ? $body["description"] : '';
    $currency = isset($body["currency"]) ? $body["currency"] : '';
    $price = isset($body["price"]) ? $body["price"] : '';
    $quantity = isset($body["quantity"]) ? $body["quantity"] : '';
    $brand = isset($body["brand"]) ? $body["brand"] : '';
    $type = isset($body["type"]) ? $body["type"] : '';
    $preferred_date2 = isset($body["preferred_date"]) ? $body["preferred_date"] : '';
    $movement = isset($body["movement"]) ? $body["movement"] : '';
    $gender = isset($body["gender"]) ? $body["gender"] : '';
    $reference = isset($body["reference"]) ? $body["reference"] : '';
    $date_of_purchase2 = isset($body["date_of_purchase"]) ? $body["date_of_purchase"] : '';
    $status_watch = isset($body["status"]) ? $body["status"] : '';
    $owner_number = isset($body["owner_number"]) ? $body["owner_number"] : '';
    $country = isset($body["country"]) ? $body["country"] : '';
    $size = isset($body["size"]) ? $body["size"] : '';
    $location = isset($body["location"]) ? $body["location"] : '';
    $work_hours = isset($body["work_hours"]) ? $body["work_hours"] : '';
    $model_year = isset($body["model_year"]) ? $body["model_year"] : '';
    $breslet_type = isset($body["breslet_type"]) ? $body["breslet_type"] : '';
    $time_slot_id = isset($body["time_slot_id"]) ? $body["time_slot_id"] : '';

    $state = isset($body["state"]) ? $body["state"] : '';
    $city = isset($body["city"]) ? $body["city"] : '';
    $get_status = '0';
    $status = 0;
    $quantity = 1;
    $nextbidprice = $price;
    
    $db = getConnection();
    $sqlusd = "SELECT * from webshop_currency_rates where currency_code='$currency'";
    $stmtusd = $db->prepare($sqlusd);
    //$stmtusd->bindParam("user_id", $user_id);
    $stmtusd->execute();
    $getusd = $stmtusd->fetchObject();
    $price = $price / $getusd->currency_rate_to_usd;
// $baseauctionprice = isset($body["baseauctionprice"]) ? $body["baseauctionprice"] : '';
//$thresholdprice = isset($body["thresholdprice"]) ? $body["thresholdprice"] : '';

    /* conversion of date format starts */

    $date_of_purchase1 = str_replace('/', '-', $date_of_purchase2);
    $date_of_purchase = date('Y-m-d', strtotime($date_of_purchase1 . "+1 days"));
    $preferred_date1 = str_replace('/', '-', $preferred_date2);

    $preferred_date = $preferred_date2;

    /* conversion of date format ends */

    $date = date("Y-m-d");

    


    $sqlsubscription = "SELECT ws.id as sid,wu.id,wu.type,ws.expiry_date,wu.slot_no FROM webshop_subscribers as ws inner join webshop_user as wu on wu.id=ws.user_id where ws.user_id=:user_id order by ws.id desc limit 1";
    $stmt = $db->prepare($sqlsubscription);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getUserDetails = $stmt->fetchObject();
    $getUserDetailscount = $stmt->rowCount();

    $sqltype = "SELECT * from webshop_user where id=:user_id";
    $stmtty = $db->prepare($sqltype);
    $stmtty->bindParam("user_id", $user_id);
    $stmtty->execute();
    $gettype = $stmtty->fetchObject();
    
    


    if ($gettype->type == 2) {
        if ($type == '1') {
            if ($getUserDetailscount > 0) {
                if ($getUserDetails->expiry_date >= $date) {
                    if ($getUserDetails->slot_no > 0) {

                        $sid = $getUserDetails->sid;


                        $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,status,size,location,work_hours,subscription_id,state,city,approved,breslet_type,model_year) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:status,:size,:location,:work_hours,:subscription_id,:state,:city,:approved,:breslet_type,:model_year)";



                        $sqlcheckcertifieduser = "SELECT * FROM webshop_user WHERE id =:user_id AND top_user_vendor='1'";
// $db = getConnection();
                        $stmtcheck = $db->prepare($sqlcheckcertifieduser);
                        $stmtcheck->bindParam("user_id", $user_id);
                        $stmtcheck->execute();
                        $count = $stmtcheck->rowCount();

                        $approved = "0";

                        if ($count > 0) {
                            $approved = "1";
//
                        }

                        $get_status = "1";

                        try {

                            $db = getConnection();
                            $stmt = $db->prepare($sql);

                            $stmt->bindParam("user_id", $user_id);
                            $stmt->bindParam("cat_id", $category);
                            $stmt->bindParam("name", $brand);
                            $stmt->bindParam("description", $description);
                            $stmt->bindParam("currency_code", $currency);
                            $stmt->bindParam("type", $type);
                            $stmt->bindParam("price", $price);
                            $stmt->bindParam("quantity", $quantity);
                            $stmt->bindParam("add_date", $date);
                            $stmt->bindParam("brand", $brand);
                            $stmt->bindParam("movement", $movement);
                            $stmt->bindParam("gender", $gender);
                            $stmt->bindParam("reference_number", $reference);
                            $stmt->bindParam("date_purchase", $date_of_purchase);
                            $stmt->bindParam("status_watch", $status_watch);
                            $stmt->bindParam("owner_number", $owner_number);
                            $stmt->bindParam("country", $country);
                            $stmt->bindParam("size", $size);
                            $stmt->bindParam("subscription_id", $sid);
                            $stmt->bindParam("state", $state);
                            $stmt->bindParam("city", $city);
                            $stmt->bindParam("location", $location);
                            $stmt->bindParam("work_hours", $work_hours);
                            $stmt->bindParam("status", $get_status);
                            $stmt->bindParam("approved", $approved);
                            $stmt->bindParam("breslet_type", $breslet_type);
                            $stmt->bindParam("model_year", $model_year);
                            $stmt->execute();
                            $lastID = $db->lastInsertId();

                            $rest_slot = (($getUserDetails->slot_no) - 1);
                            $sqlslotupdate = "UPDATE webshop_user SET slot_no=:slot WHERE id=:user_id";
                            $stmtslot = $db->prepare($sqlslotupdate);
                            $stmtslot->bindParam("slot", $rest_slot);
                            $stmtslot->bindParam("user_id", $user_id);
                            $stmtslot->execute();



                            if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                                foreach ($_FILES['image']['name'] as $key1 => $file) {



                                    if ($_FILES['image']['tmp_name'][$key1] != '') {

                                        $target_path = "../upload/product_image/";

                                        $userfile_name = $_FILES['image']['name'][$key1];

                                        $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                                        $img = $target_path . $userfile_name;
                                        move_uploaded_file($userfile_tmp, $img);

                                        $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam("image", $userfile_name);
                                        $stmt->bindParam("product_id", $lastID);
                                        $stmt->execute();


                                        $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                                        $stmt1 = $db->prepare($sqlimg);
                                        $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                                        $stmt1->execute();
                                    }
                                }
                            }

                            $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

                            $stmtttadmin = $db->prepare($sqladmin);
                            $stmtttadmin->execute();
                            $getadmin = $stmtttadmin->fetchObject();
                            if ($getadmin->product_upload_notification == 1) {
                                $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

                                $is_read = '0';
                                $last_id = '0';
                                $from_id = '0';
                                $message = 'New Product added';
//$type = '2';
                                $stmttt = $db->prepare($sqlFriend);
                                $stmttt->bindParam("from_id", $user_id);
                                $stmttt->bindParam("to_id", $from_id);
                                $stmttt->bindParam("type", $type);
                                $stmttt->bindParam("msg", $message);

                                $stmttt->bindParam("last_id", $last_id);
                                $stmttt->bindParam("is_read", $is_read);
                                $stmttt->execute();
                            }

                            $data['Ack'] = 1;
                            $data['msg'] = 'Product added successfully.';
                            $data['type'] = $type;
                            $data['utype'] = 2;

                            $app->response->setStatus(200);
                            $db = null;
                        } catch (PDOException $e) {
                            $data['user_id'] = '';
                            $data['Ack'] = 0;
                            $data['msg'] = 'error';
                            $app->response->setStatus(401);
                        }
                    } else {
                        $data['Ack'] = 0;
                        $data['msg'] = 'You have no slot to post this. Please subscribe our package to get this benifit.';
                        $app->response->setStatus(200);
                    }
                } else {
                    $data['Ack'] = 0;
                    $data['msg'] = 'You have no active subscription. Please subscribe our package to get this benifit.';
                    $app->response->setStatus(200);
                }
            } else {
                $data['Ack'] = 0;
                $data['msg'] = 'You have no subscription. Please subscribe our package to get this benifit.';
                $app->response->setStatus(200);
            }
        } else {
            
            
            $sqlsetting = "SELECT * FROM webshop_sitesettings WHERE id=1";
            $db = getConnection();
            $stmtsetting = $db->prepare($sqlsetting);
            $stmtsetting->execute();
            $getsetting = $stmtsetting->fetchObject();

            $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,preferred_date,location,work_hours,status,breslet_type,model_year,time_slot_id,thresholdprice,state,city,approved,auction_fee) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:preferred_date,:location,:work_hours,:status,:breslet_type,:model_year,:time_slot_id,:thresholdprice,:state,:city,:approved,:auction_fee)";
            
            $approved=1;
            $payment_amount = ceil(($price * $getsetting->threshold_price_percent) / 100);
            
            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
                $stmt->bindParam("name", $brand);
                $stmt->bindParam("description", $description);
                $stmt->bindParam("currency_code", $currency);
                $stmt->bindParam("type", $type);
                $stmt->bindParam("price", $price);
                $stmt->bindParam("quantity", $quantity);
                $stmt->bindParam("add_date", $date);
                $stmt->bindParam("brand", $brand);
                $stmt->bindParam("movement", $movement);
                $stmt->bindParam("gender", $gender);
                $stmt->bindParam("reference_number", $reference);
                $stmt->bindParam("date_purchase", $date_of_purchase);
                $stmt->bindParam("status_watch", $status_watch);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);

                $stmt->bindParam("preferred_date", $preferred_date);
                $stmt->bindParam("breslet_type", $breslet_type);
                $stmt->bindParam("model_year", $model_year);
                $stmt->bindParam("time_slot_id", $time_slot_id);
                $stmt->bindParam("thresholdprice", $price);
                $stmt->bindParam("state", $state);
                $stmt->bindParam("city", $city);

                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("status", $get_status);
                $stmt->bindParam("approved", $approved);
                $stmt->bindParam("auction_fee", $payment_amount);
                $stmt->execute();

                $lastID = $db->lastInsertId();




                /*  if (!empty($_FILES['image'])) {

                  if ($_FILES['image']['tmp_name'] != '') {

                  $target_path = "../upload/product_image/";

                  $userfile_name = $_FILES['image']['name'];

                  $userfile_tmp = $_FILES['image']['tmp_name'];

                  $img = $target_path . $userfile_name;

                  move_uploaded_file($userfile_tmp, $img);

                  $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";

                  $stmt1 = $db->prepare($sqlimg);
                  $stmt1->bindParam("image", $userfile_name);
                  $stmt1->execute();
                  }
                  } */

                if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                    foreach ($_FILES['image']['name'] as $key1 => $file) {



                        if ($_FILES['image']['tmp_name'][$key1] != '') {

                            $target_path = "../upload/product_image/";

                            $userfile_name = $_FILES['image']['name'][$key1];

                            $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                            $img = $target_path . $userfile_name;
                            move_uploaded_file($userfile_tmp, $img);

                            $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam("image", $userfile_name);
                            $stmt->bindParam("product_id", $lastID);
                            $stmt->execute();


                            $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                            $stmt1 = $db->prepare($sqlimg);
                            $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                            $stmt1->execute();
                        }
                    }
                }
                $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

                $stmtttadmin = $db->prepare($sqladmin);
                $stmtttadmin->execute();
                $getadmin = $stmtttadmin->fetchObject();
                if ($getadmin->auction_notification == 1) {
                    $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

                    $is_read = '0';
                    $last_id = '0';
                    $from_id = '0';
                    $message = 'New auction added';
//$type = '2';
                    $stmttt = $db->prepare($sqlFriend);
                    $stmttt->bindParam("from_id", $user_id);
                    $stmttt->bindParam("to_id", $from_id);
                    $stmttt->bindParam("type", $type);
                    $stmttt->bindParam("msg", $message);

                    $stmttt->bindParam("last_id", $last_id);
                    $stmttt->bindParam("is_read", $is_read);
                    $stmttt->execute();
                }

                $data['Ack'] = 1;
                $data['msg'] = 'Auction added successfully.';
                $data['type'] = $type;
                $data['utype'] = 2;
                $app->response->setStatus(200);
                $db = null;
            } catch (PDOException $e) {
                $data['user_id'] = '';
                $data['Ack'] = 0;
                $data['msg'] = 'error';
                $app->response->setStatus(401);
            }
        }
    } else {

        if ($type == '1') {


            $sqladminfree_no = "SELECT * FROM webshop_sitesettings WHERE id =1 ";
            $db = getConnection();
            $stmtfreeno = $db->prepare($sqladminfree_no);
            $stmtfreeno->execute();
            $getfree_no = $stmtfreeno->fetchObject();
            $free_no = $getfree_no->free_bid;
            $free_status = $getfree_no->free_bid_status;

            $sqluserpay_product = "SELECT * FROM webshop_products WHERE uploader_id=:user_id and type=1 and status=1 and user_free_product='P'";
            $db = getConnection();
            $stmtpayno = $db->prepare($sqluserpay_product);
            $stmtpayno->bindParam("user_id", $user_id);
            $stmtpayno->execute();
            $pcount = $stmtpayno->rowCount();



            $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,location,work_hours,approved,state,city,status,breslet_type,model_year) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:location,:work_hours,:approved,:state,:city,:status,:breslet_type,:model_year)";




            $sqlcheckcertifieduser = "SELECT * FROM webshop_user WHERE id =:user_id AND top_user_vendor='1'";
            $db = getConnection();
            $stmtcheck = $db->prepare($sqlcheckcertifieduser);
            $stmtcheck->bindParam("user_id", $user_id);
            $stmtcheck->execute();
            $count = $stmtcheck->rowCount();


            if ($pcount >= $free_no && $free_status==1 && $free_no > 0) {

                $payment_status = "1";
            } else {

                $payment_status = "0";
            }

            if ($count > 0) {
                $get_status = "1";
            } else {

                $get_status = "0";
            }

            if ($count > 0) {
                $certified_user = "1";
            } else {

                $certified_user = "0";
            }

            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
                $stmt->bindParam("name", $brand);
                $stmt->bindParam("description", $description);
                $stmt->bindParam("currency_code", $currency);
                $stmt->bindParam("type", $type);
                $stmt->bindParam("price", $price);
                $stmt->bindParam("quantity", $quantity);
                $stmt->bindParam("add_date", $date);
                $stmt->bindParam("brand", $brand);
                $stmt->bindParam("movement", $movement);
                $stmt->bindParam("gender", $gender);
                $stmt->bindParam("reference_number", $reference);
                $stmt->bindParam("date_purchase", $date_of_purchase);
                $stmt->bindParam("status_watch", $status_watch);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);
                $stmt->bindParam("state", $state);
                $stmt->bindParam("city", $city);
                $stmt->bindParam("breslet_type", $breslet_type);
                $stmt->bindParam("model_year", $model_year);

                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("approved", $get_status);
                $stmt->bindParam("status", $payment_status);
                $stmt->execute();
                $lastID = $db->lastInsertId();



                if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                    foreach ($_FILES['image']['name'] as $key1 => $file) {

                        if ($_FILES['image']['tmp_name'][$key1] != '') {

                            $target_path = "../upload/product_image/";

                            $userfile_name = $_FILES['image']['name'][$key1];

                            $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                            $img = $target_path . $userfile_name;
                            move_uploaded_file($userfile_tmp, $img);

                            $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam("image", $userfile_name);
                            $stmt->bindParam("product_id", $lastID);
                            $stmt->execute();

                            $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                            $stmt1 = $db->prepare($sqlimg);
                            $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                            $stmt1->execute();
                        }
                    }
                }

                if ($payment_status == 1) {

                    $sqlupdatefree = "UPDATE webshop_products SET user_free_product='F' WHERE type=1 and status=1 and uploader_id=$user_id ";
                    $stmtupdatefree = $db->prepare($sqlupdatefree);
                    $stmtupdatefree->execute();
                }



                if ($payment_status == 0) {
                    if ($certified_user == 1) {
                        $data['Ack'] = 1;
                        $data['msg'] = 'Product added successfully. To get product live please make payment.';
                        $data['type'] = $type;
                        $data['utype'] = 1;
                        $data['lastid'] = $lastID;
                        $data['certified_user'] = $certified_user;
                        $app->response->setStatus(200);
                        $db = null;
                    } else {

                        $data['Ack'] = 1;
                        $data['msg'] = 'Product added successfully. Wait for admin approval to pay and live this product.';
                        $data['type'] = $type;
                        $data['utype'] = 1;
                        $data['lastid'] = $lastID;
                        $data['certified_user'] = $certified_user;
                    }
                } else {

                    $data['Ack'] = 1;
                    $data['msg'] = 'Congrats Product added successfully. It Was free.';
                    $data['type'] = $type;
                    $data['lastid'] = $lastID;
                }
            } catch (PDOException $e) {
                $data['user_id'] = '';
                $data['Ack'] = 0;
                $data['msg'] = 'error';
                $app->response->setStatus(401);
            }
        } else {
            
            $sqlsetting = "SELECT * FROM webshop_sitesettings WHERE id=1";
            $db = getConnection();
            $stmtsetting = $db->prepare($sqlsetting);
            $stmtsetting->execute();
            $getsetting = $stmtsetting->fetchObject();

            $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,preferred_date,location,work_hours,status,breslet_type,model_year,time_slot_id,thresholdprice,state,city,approved,auction_fee) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:preferred_date,:location,:work_hours,:status,:breslet_type,:model_year,:time_slot_id,:thresholdprice,:state,:city,:approved,:auction_fee)";

            $approved= 1;
            $payment_amount = ceil(($price * $getsetting->threshold_price_percent) / 100);
            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
//$stmt->bindParam("subcat_id", $subcategory);
                $stmt->bindParam("name", $brand);
                $stmt->bindParam("description", $description);
                $stmt->bindParam("currency_code", $currency);
                $stmt->bindParam("type", $type);
                $stmt->bindParam("price", $price);
                $stmt->bindParam("quantity", $quantity);
                $stmt->bindParam("add_date", $date);
                $stmt->bindParam("brand", $brand);
                $stmt->bindParam("movement", $movement);
                $stmt->bindParam("gender", $gender);
                $stmt->bindParam("reference_number", $reference);
                $stmt->bindParam("date_purchase", $date_of_purchase);
                $stmt->bindParam("status_watch", $status_watch);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);



                $stmt->bindParam("preferred_date", $preferred_date);
                $stmt->bindParam("breslet_type", $breslet_type);
                $stmt->bindParam("model_year", $model_year);
                $stmt->bindParam("time_slot_id", $time_slot_id);
                $stmt->bindParam("thresholdprice", $price);
                $stmt->bindParam("state", $state);
                $stmt->bindParam("city", $city);
                $stmt->bindParam("approved", $approved);
                $stmt->bindParam("auction_fee", $payment_amount);

                $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

                $is_read = '0';
                $last_id = '0';
                $from_id = '0';
                $message = 'New auction added';
//$type = '2';
                $stmttt = $db->prepare($sqlFriend);
                $stmttt->bindParam("from_id", $user_id);
                $stmttt->bindParam("to_id", $from_id);
                $stmttt->bindParam("type", $type);
                $stmttt->bindParam("msg", $message);

                $stmttt->bindParam("last_id", $last_id);
                $stmttt->bindParam("is_read", $is_read);
                $stmttt->execute();


                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("status", $get_status);
                $stmt->execute();

                $lastID = $db->lastInsertId();




                /* if (!empty($_FILES['image'])) {

                  if ($_FILES['image']['tmp_name'] != '') {

                  $target_path = "../upload/product_image/";

                  $userfile_name = $_FILES['image']['name'];

                  $userfile_tmp = $_FILES['image']['tmp_name'];


                  $img = $target_path . $userfile_name;
                  move_uploaded_file($userfile_tmp, $img);


                  $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";

                  $stmt1 = $db->prepare($sqlimg);
                  $stmt1->bindParam("image", $userfile_name);
                  $stmt1->execute();
                  }
                  } */
                if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                    foreach ($_FILES['image']['name'] as $key1 => $file) {

                        if ($_FILES['image']['tmp_name'][$key1] != '') {

                            $target_path = "../upload/product_image/";

                            $userfile_name = $_FILES['image']['name'][$key1];

                            $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                            $img = $target_path . $userfile_name;
                            move_uploaded_file($userfile_tmp, $img);

                            $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam("image", $userfile_name);
                            $stmt->bindParam("product_id", $lastID);
                            $stmt->execute();

                            $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                            $stmt1 = $db->prepare($sqlimg);
                            $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                            $stmt1->execute();
                        }
                    }
                }

                $data['Ack'] = 1;
                $data['msg'] = 'Auction added successfully.';
                $data['type'] = $type;
                $data['utype'] = 1;
                $app->response->setStatus(200);
                $db = null;
            } catch (PDOException $e) {
                $data['user_id'] = '';
                $data['Ack'] = 0;
                $data['msg'] = 'error';
                $app->response->setStatus(401);
            }
        }
    }


    $app->response->write(json_encode($data));
}

function addAuction() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());


    $user_id = isset($body["user_id"]) ? $body["user_id"] : '';

    $category = isset($body["cat_id"]) ? $body["cat_id"] : '';
    $subcategory = isset($body["subcat_id"]) ? $body["subcat_id"] : '';
    $name = isset($body["name"]) ? $body["name"] : '';
    $description = isset($body["description"]) ? $body["description"] : '';
    $currency = isset($body["currency"]) ? $body["currency"] : '';
    $price = isset($body["price"]) ? $body["price"] : '';
    $quantity = isset($body["quantity"]) ? $body["quantity"] : '';
    $brand = isset($body["brand"]) ? $body["brand"] : '';
    $type = '2';
//$special_price =  isset($body["special_price"]) ? $body["special_price"] : '';
    $preferred_date2 = isset($body["preferred_date"]) ? $body["preferred_date"] : '';
// $auction_start_date2 = isset($body["auction_start_date"]) ? $body["auction_start_date"] : '';
// $auction_end_date2 = isset($body["auction_end_date"]) ? $body["auction_end_date"] : '';


    $movement = isset($body["movement"]) ? $body["movement"] : '';
    $gender = isset($body["gender"]) ? $body["gender"] : '';
    $reference = isset($body["reference"]) ? $body["reference"] : '';
    $date_of_purchase2 = isset($body["date_of_purchase"]) ? $body["date_of_purchase"] : '';
    $status = isset($body["status"]) ? $body["status"] : '';
    $owner_number = isset($body["owner_number"]) ? $body["owner_number"] : '';
    $country = isset($body["country"]) ? $body["country"] : '';
    $size = isset($body["size"]) ? $body["size"] : '';
    $location = isset($body["location"]) ? $body["location"] : '';
    $work_hours = isset($body["work_hours"]) ? $body["work_hours"] : '';
    $get_status = '0';


    /* conversion of date format starts */

// $auction_start_date1 = str_replace('/', '-', $auction_start_date2);
// $auction_start_date = date('Y-m-d', strtotime($auction_start_date1."+1 days"));
// $auction_end_date1 = str_replace('/', '-', $auction_end_date2);
// $auction_end_date = date('Y-m-d', strtotime($auction_end_date1."+1 days"));
    $date_of_purchase1 = str_replace('/', '-', $date_of_purchase2);
    $date_of_purchase = date('Y-m-d', strtotime($date_of_purchase1 . "+1 days"));
    $preferred_date1 = str_replace('/', '-', $preferred_date2);
    $preferred_date = date('Y-m-d', strtotime($preferred_date1 . "+1 days"));

// echo "pp".$preferred_date;
// exit;
    /* conversion of date format ends */

    $date = date("Y-m-d");

    $db = getConnection();

    $sql = "INSERT INTO webshop_products (uploader_id, cat_id, subcat_id,currency_code,type,name, description, price, add_date,quantity,brands) VALUES (:user_id, :cat_id, :subcat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand)";

    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);

        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("cat_id", $category);
        $stmt->bindParam("subcat_id", $subcategory);
        $stmt->bindParam("name", $name);
        $stmt->bindParam("description", $description);
        $stmt->bindParam("currency_code", $currency);
        $stmt->bindParam("type", $type);
        $stmt->bindParam("price", $price);
        $stmt->bindParam("quantity", $quantity);
        $stmt->bindParam("add_date", $date);
        $stmt->bindParam("brand", $brand);
// $stmt->bindParam("special_price", $special_price);
// $stmt->bindParam("auction_start_date", $auction_start_date);
// $stmt->bindParam("auction_end_date", $auction_end_date);
        $stmt->execute();

        $lastID = $db->lastInsertId();

        if (!empty($_FILES['image'])) {

            if ($_FILES['image']['tmp_name'] != '') {

                $target_path = "../upload/product_image/";

                $userfile_name = $_FILES['image']['name'];

                $userfile_tmp = $_FILES['image']['tmp_name'];


                $img = $target_path . $userfile_name;
                move_uploaded_file($userfile_tmp, $img);


                $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";

                $stmt1 = $db->prepare($sqlimg);
                $stmt1->bindParam("image", $userfile_name);
                $stmt1->execute();
            }
        }

        $brandsql = "SELECT * from  webshop_brands WHERE id=:id";
        $stmt3 = $db->prepare($brandsql);
        $stmt3->bindParam("id", $brand);
        $stmt3->execute();
        $getbrand = $stmt3->fetchObject();

// echo "pptest ".$preferred_date;
// exit;

        $auctionsql = "INSERT INTO webshop_auction (user_id, product_id,price, movement,gender,brand,reference_number, date_purchase, status_watch, owner_number,country,size,preferred_date,location,work_hours,status) VALUES (:user_id, :product_id, :price, :movement,:gender,:brand,:reference_number, :date_purchase, :status_watch, :owner_number,:country,:size,:preferred_date,:location,:work_hours,:status)";
        $stmt2 = $db->prepare($auctionsql);

        $stmt2->bindParam("user_id", $user_id);
        $stmt2->bindParam("product_id", $lastID);
        $stmt2->bindParam("price", $price);
        $stmt2->bindParam("movement", $movement);
        $stmt2->bindParam("gender", $gender);
        $stmt2->bindParam("brand", $getbrand->name);
        $stmt2->bindParam("reference_number", $reference);
        $stmt2->bindParam("date_purchase", $date_of_purchase);
        $stmt2->bindParam("status_watch", $status);
        $stmt2->bindParam("owner_number", $owner_number);
        $stmt2->bindParam("country", $country);
        $stmt2->bindParam("size", $size);
        $stmt2->bindParam("preferred_date", $preferred_date);
// $stmt2->bindParam("start_date_time",$auction_start_date);
// $stmt2->bindParam("end_date_time", $auction_end_date);
        $stmt2->bindParam("location", $location);
        $stmt2->bindParam("work_hours", $work_hours);
        $stmt2->bindParam("status", $get_status);
        $stmt2->execute();

// echo $auctionsql;
// exit;

        $auctionlastID = $db->lastInsertId();

        if (!empty($_FILES['image'])) {

            if ($_FILES['image']['tmp_name'] != '') {

// $target_path = "../upload/auction_image/";
// $userfile_name = $_FILES['image']['name'];
// $userfile_tmp = $_FILES['image']['tmp_name'];
// $img = $target_path . $userfile_name;
// move_uploaded_file($userfile_tmp, $img);


                $sqlimg = "UPDATE webshop_auction SET image=:image WHERE id=$auctionlastID";

                $stmt1 = $db->prepare($sqlimg);
                $stmt1->bindParam("image", $userfile_name);
                $stmt1->execute();
            }
        }

// $data['last_id'] = $lastID;
        $data['Ack'] = 1;
        $data['msg'] = 'AUction added successfully.';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'error';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listmyAuctions() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_products WHERE uploader_id=:user_id and type='2' order by id desc";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($getAllProducts)) {
        foreach ($getAllProducts as $product) {


            if ($product->image != '') {
                $image = SITE_URL . 'upload/product_image/' . $product->image;
            } else {
                $image = SITE_URL . 'webservice/not-available.jpg';
            }


            $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam("id", $product->cat_id);
            $stmt2->execute();
            $getcategory = $stmt2->fetchObject();
            if (!empty($getcategory)) {
                $categoryname = $getcategory->name;
            }



            $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam("id", $product->subcat_id);
            $stmt3->execute();
            $getsubcategory = $stmt3->fetchObject();
//            if (!empty($getsubcategory)) {
//                $subcategoryname = $getsubcategory->name;
//            }
//Seller Information

            $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("id", $product->uploader_id);
            $stmt1->execute();
            $getUserdetails = $stmt1->fetchObject();

            if (!empty($getUserdetails)) {
                $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                $seller_address = $getUserdetails->address;
                $seller_phone = $getUserdetails->phone;
                $email = $getUserdetails->email;

                if ($getUserdetails->image != '') {
                    $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                } else {
                    $profile_image = SITE_URL . 'webservice/no-user.png';
                }
            } else {
                $profile_image = '';
            }

            $data['productList'][] = array(
                "id" => stripslashes($product->id),
                "image" => stripslashes($image),
                "price" => stripslashes($product->price),
                "description" => strip_tags(stripslashes(substr($product->description, 0, 50))),
                "category_name" => $categoryname,
                //"subcategory_name" => $subcategoryname,
                "seller_id" => stripslashes($product->uploader_id),
                "seller_image" => $profile_image,
                "seller_name" => stripslashes($seller_name),
                "seller_address" => stripslashes($seller_address),
                "seller_phone" => stripslashes($seller_phone),
                "productname" => stripslashes($product->name),
                "auction_fee_paid" => stripslashes($product->auction_fee_paid),
                "auction_fee" => stripslashes($product->auction_fee),
                "approved" => stripslashes($product->approved)
            );
        }


        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['productList'] = array();
        $data['msg'] = "Sorry! No data found.";
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

// function getBrandId() {
//  $data = array();
//     $app = \Slim\Slim::getInstance();
//     $request = $app->request();
//     $body2 = $app->request->getBody();
//     $body = json_decode($body2);
//    $brandname = isset($body->brand) ? $body->brand : '';
//        $sql = "SELECT * FROM  webshop_brands WHERE name LIKE '%" . $brandname . "%'";
//     try {
//         $db = getConnection();
//         $stmt = $db->prepare($sql);
//         $stmt->execute();
//          $getBrandDetails = $stmt->fetchAll(PDO::FETCH_OBJ);
//          if(!empty($getBrandDetails)){
//               foreach($getBrandDetails as $brand){
//                  $data['brand'][]= array("brand_id"=>stripslashes($brand->id),
//                                 "brand_name"=>stripslashes($brand->name)
//                                 );
//                   $data['Ack'] = '1';
//                   $data['msg'] = 'Get all brands';
//          }
//          }else{
//             $data['brand'] = array();
//             $data['Ack'] ='1';
//             $data['msg'] ='No Brands found';
//          }
//         $app->response->setStatus(200);
//         $db = null;
//     } catch (PDOException $e) {
//         $data['last_id'] = '';
//         $data['Ack'] = '0';
//         $data['msg'] = 'All Brands!!!';
//         echo '{"error":{"text":' . $e->getMessage() . '}}';
//         $app->response->setStatus(401);
//     }
//  $app->response->write(json_encode($data));
// } 

function getBrandIdNew() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $brandname = isset($body->brandname) ? $body->brandname : '';

    $sql = "SELECT * FROM  webshop_brands WHERE name=:name ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("name", $brandname);
    $stmt->execute();
    $getBranddetails = $stmt->fetchObject();

    if (!empty($getBranddetails)) {

        $brandDetails = array("brand_id" => stripslashes($getBranddetails->id),
            "brand_name" => stripslashes($getBranddetails->name));
    } else {
        $brandDetails = array();
    }

    $data['brand'] = $brandDetails;
    $data['Ack'] = '1';

    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function emailverified() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $email_verified = '1';
    $admin_approve = '0';
    $status = '0';
    $verified_date = date('Y-m-d');


    $sqluser = "SELECT * FROM  webshop_user WHERE id=:user_id ";
    $stmtuser = $db->prepare($sqluser);
    $stmtuser->bindParam("user_id", $user_id);
    $stmtuser->execute();
    $getUserdetails = $stmtuser->fetchObject();

    if ($getUserdetails->type == 1) {
        $admin_approve = '1';
        $status = '1';
    }


    $sql = "UPDATE webshop_user set email_verified=:email_verified,verified_date=:verified_date,is_admin_approved=:is_admin_approved,status=:status WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email_verified", $email_verified);
        $stmt->bindParam("verified_date", $verified_date);
        $stmt->bindParam("is_admin_approved", $admin_approve);
        $stmt->bindParam("status", $status);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();

        $msg = 'Email Verified Successfully.Your account is awaiting for the admin approval.You will be notified via email once activated.';
        if ($getUserdetails->type == 1) {
            $msg = 'Email Verified Successfully. You can login now.';
        }

        $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

        $stmtttadmin = $db->prepare($sqladmin);
        $stmtttadmin->execute();
        $getadmin = $stmtttadmin->fetchObject();
        if ($getadmin->signup_notification == 1) {
            $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

            $is_read = '0';
            $last_id = '0';
            $from_id = '0';
            $message = $getUserdetails->fname . ' ' . $getUserdetails->lname . ' Is Newly Registered';
            //$type = '2';
            $stmttt = $db->prepare($sqlFriend);
            $stmttt->bindParam("from_id", $user_id);
            $stmttt->bindParam("to_id", $from_id);
            $stmttt->bindParam("type", $type);
            $stmttt->bindParam("msg", $message);

            $stmttt->bindParam("last_id", $last_id);
            $stmttt->bindParam("is_read", $is_read);
            $stmttt->execute();
        }
        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = $msg;


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error!!!';
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function auctionapproval() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $product_id = isset($body->product_id) ? $body->product_id : '';
    //$bid = isset($body->bid) ? $body->bid : '';
    //$preferred_date2 = isset($body->preferred_date) ? $body->preferred_date : '';
    $comments = isset($body->comments) ? $body->comments : '';
    $time_slot_id = isset($body->time_slot_id) ? $body->time_slot_id : '';
    $breslet_type = isset($body->breslet_type) ? $body->breslet_type : '';
    $model_year = isset($body->model_year) ? $body->model_year : '';

    //$preferred_date1 = str_replace('/', '-', $preferred_date2);
    //$preferred_date = date('Y-m-d', strtotime($preferred_date1 . "+1 days"));
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';

    $type = '2';
    $sql1 = "SELECT * FROM webshop_products WHERE id=$product_id";
    $sql = "UPDATE webshop_products set type=:type,thresholdprice=:thresholdprice,preferred_date=:preferred_date,comments=:comments,breslet_type=:breslet_type,model_year=:model_year,time_slot_id=:time_slot_id,status=0,approved=0 WHERE id=:product_id";
    try {
        $db = getConnection();

        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $price = $stmt1->fetchObject();
        $price = $price->price;


        $stmt = $db->prepare($sql);
        $stmt->bindParam("type", $type);
        $stmt->bindParam("thresholdprice", $price);
        $stmt->bindParam("preferred_date", $preferred_date);
        $stmt->bindParam("comments", $comments);
        $stmt->bindParam("breslet_type", $breslet_type);
        $stmt->bindParam("model_year", $model_year);
        $stmt->bindParam("time_slot_id", $time_slot_id);

        $stmt->bindParam("product_id", $product_id);

        $stmt->execute();

        $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

        $is_read = '0';
        $last_id = '0';
        $from_id = '0';
        $message = 'New auction added';
//$type = '2';
        $stmttt = $db->prepare($sqlFriend);
        $stmttt->bindParam("from_id", $price->uploader_id);
        $stmttt->bindParam("to_id", $from_id);
        $stmttt->bindParam("type", $type);
        $stmttt->bindParam("msg", $message);

        $stmttt->bindParam("last_id", $last_id);
        $stmttt->bindParam("is_read", $is_read);
        $stmttt->execute();

        $data['Ack'] = '1';
        $data['msg'] = 'Send For Auction successfully';


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error!!!';
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function interestedEmailToVendor() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $seller_id = $body->seller_id;
    $user_id = $body->user_id;
    $product_id = $body->product_id;
    $type = $body->type;
    $messagefromuser = $body->message;
    $db = getConnection();

    $sql3 = "SELECT * FROM  webshop_products WHERE id=:id ";
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam("id", $product_id);
    $stmt3->execute();
    $getproductdetails = $stmt3->fetchObject();

    $sql2 = "SELECT * FROM  webshop_user WHERE id=:id ";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam("id", $user_id);
    $stmt2->execute();
    $getdetails = $stmt2->fetchObject();

    $user = $getdetails->fname . " " . $getdetails->lname;

    $sql = "SELECT * FROM  webshop_user WHERE id=:id ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $seller_id);
    $stmt->execute();
    $getUserdetails = $stmt->fetchObject();

    $email = $getUserdetails->email;

    $MailTo = $email;

    $MailFrom = 'info@webshop.com';
    $subject = "webshop.com- Product Interested";
    $link = SITE_URL . '#/conatctuser/' . $getdetails->id . '/' . $getproductdetails->id . '/' . $getUserdetails->id;
    $TemplateMessage = "Hello " . $getUserdetails->fname . ",<br /><br / >";
    $TemplateMessage .= $user . " is interested in your product " . $getproductdetails->name . " <br />";
//$TemplateMessage .= "<br/>Click this link to verify to conact user <a href='" . $link . "'>" . $link . "</a><br/>";
    $TemplateMessage .= "<br /><br />Thanks,<br />";
    $TemplateMessage .= "webshop.com<br />";


    $mail = new PHPMailer(true);

    $IsMailType = 'SMTP';

    $MailFrom = 'mail@natitsolved.com';    //  Your email password

    $MailFromName = 'Webshop';
    $MailToName = '';

    $YourEamilPassword = "Natit#2019";   //Your email password from which email you send.
// If you use SMTP. Please configure the bellow settings.

    $SmtpHost = "smtp.gmail.com"; // sets the SMTP server
    $SmtpDebug = 0;                     // enables SMTP debug information (for testing)
    $SmtpAuthentication = true;                  // enable SMTP authentication
    $SmtpPort = 587;                    // set the SMTP port for the GMAIL server
    $SmtpUsername = $MailFrom; // SMTP account username
    $SmtpPassword = $YourEamilPassword;        // SMTP account password

    $mail->IsSMTP();  // telling the class to use SMTP
    $mail->SMTPDebug = $SmtpDebug;
    $mail->SMTPAuth = $SmtpAuthentication;     // enable SMTP authentication
    $mail->Port = $SmtpPort;             // set the SMTP port
    $mail->Host = $SmtpHost;           // SMTP server
    $mail->Username = $SmtpUsername; // SMTP account username
    $mail->Password = $SmtpPassword; // SMTP account password

    if ($MailFromName != '') {
        $mail->AddReplyTo($MailFrom, $MailFromName);
        $mail->From = $MailFrom;
        $mail->FromName = $MailFromName;
    } else {
        $mail->AddReplyTo($MailFrom);
        $mail->From = $MailFrom;
        $mail->FromName = $MailFrom;
    }

    if ($MailToName != '') {
        $mail->AddAddress($MailTo, $MailToName);
    } else {
        $mail->AddAddress($MailTo);
    }

    $mail->SMTPSecure = 'tls';
    $mail->Subject = $subject;

    $mail->MsgHTML($TemplateMessage);

    try {
        $mail->Send();

        /* $sql_messageadd = "INSERT INTO  webshop_message (message,to_id,product_id,from_id,is_read,add_date) VALUES (:message,:to_id,:product_id,:from_id,:is_read,:add_date)";

          $stm_msg = $db->prepare($sql_messageadd);
          $add_date = date('Y-m-d');
          $is_read = '0';
          $stm_msg->bindParam("message", $messagefromuser);
          $stm_msg->bindParam("to_id", $seller_id);
          $stm_msg->bindParam("product_id", $product_id);
          $stm_msg->bindParam("from_id", $user_id);
          $stm_msg->bindParam("is_read", $is_read);
          $stm_msg->bindParam("add_date", $add_date);

          $stm_msg->execute(); */

        $sql_interest = "INSERT INTO  webshop_interested (userid,seller_id,productid,type,interested) VALUES (:userid,:seller_id,:product_id,:type,:interested)";

        $stm_interest = $db->prepare($sql_interest);
//$add_date = date('Y-m-d');
        $interested = 1;

        $stm_interest->bindParam("seller_id", $seller_id);
        $stm_interest->bindParam("product_id", $product_id);
        $stm_interest->bindParam("userid", $user_id);
        $stm_interest->bindParam("type", $type);
        $stm_interest->bindParam("interested", $interested);

        $stm_interest->execute();
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }

    /* Notification to the seller start */
    $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

    $stmtttadmin = $db->prepare($sqladmin);
    $stmtttadmin->execute();
    $getadmin = $stmtttadmin->fetchObject();
    if ($getadmin->interest_notification == 1) {
        $message = $user . " is interested in your product " . $getproductdetails->name . "";

        $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, msg, is_read,last_id) VALUES (:from_id, :to_id, :msg, :is_read,:last_id)";

        $is_read = '0';
        $last_id = '0';
        $from_id = '0';

        $stmttt = $db->prepare($sqlFriend);
        $stmttt->bindParam("from_id", $user_id);
        $stmttt->bindParam("to_id", $seller_id);
//$stmttt->bindParam("type", $type);
        $stmttt->bindParam("msg", $message);

        $stmttt->bindParam("last_id", $last_id);
        $stmttt->bindParam("is_read", $is_read);
        $stmttt->execute();
    }


    /* Notification to the seller end */

    /* Notification for message start */

    /* $message1 = "You have a new message from " . $user . "";

      $sqlFriendmsg = "INSERT INTO webshop_notification (from_id, to_id, msg, is_read,last_id) VALUES (:from_id, :to_id, :msg, :is_read,:last_id)";

      $is_read = '0';
      $last_id = '0';
      $from_id = '0';

      $stmtttmsg = $db->prepare($sqlFriendmsg);
      $stmtttmsg->bindParam("from_id", $user_id);
      $stmtttmsg->bindParam("to_id", $seller_id);
      //$stmttt->bindParam("type", $type);
      $stmtttmsg->bindParam("msg", $messagefromuser);
      $stmtttmsg->bindParam("last_id", $last_id);
      $stmtttmsg->bindParam("is_read", $is_read);
      $stmtttmsg->execute(); */


    /* Notification for message end */
    $db = null;
    $data['Ack'] = '1';
    $data['msg'] = 'Mail Send Successfully';
    $app->response->setStatus(200);



    $app->response->write(json_encode($data));
}

function auctionFeesAdvancePayment() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $notificationType = isset($body->notificationType) ? $body->notificationType : '';
    $array = explode('_', $body->auctionId);
    $auctionId = $array[0];
    $loyalty_point = isset($array[1]) ? $array[1] : 0;
    $auction_fee_paid = '1';

    $verified_date = date('Y-m-d');


    $sql = "UPDATE webshop_products set auction_fee_paid=:auction_fee_paid WHERE id=:auctionId";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("auctionId", $auctionId);
        $stmt->bindParam("auction_fee_paid", $auction_fee_paid);
        $stmt->execute();

        $sql7 = "SELECT * from webshop_products where id=:auctionId ";
        $stmt7 = $db->prepare($sql7);
        $stmt7->bindParam("auctionId", $auctionId);
        $stmt7->execute();
        $productdetails = $stmt7->fetchObject();


        $sql6 = "SELECT * from webshop_user where id=:user_id ";
        $stmt6 = $db->prepare($sql6);
        $stmt6->bindParam("user_id", $user_id);
        $stmt6->execute();
        $is_user = $stmt6->fetchObject();


        if ($loyalty_point != 0) {
            $total_loyalty = ($is_user->total_loyalty - $loyalty_point);
        } else {
            $total_loyalty = 0;
        }

        $sql1 = "UPDATE  webshop_user SET total_loyalty = :loyalty WHERE id=:user_id ";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("loyalty", $total_loyalty);
        $stmt1->bindParam("user_id", $user_id);
        $stmt1->execute();

        if ($loyalty_point != 0) {
            $date = date('Y-m-d');
            $type = 1;
            $sql = "INSERT INTO  webshop_user_loyaliety (pay_amount, user_id,point,add_date,type) VALUES (:pay_amount, :user_id,:point,:date,:type)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("pay_amount", $productdetails->auction_fee);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("point", $loyalty_point);
            $stmt->bindParam("date", $date);
            $stmt->bindParam("type", $type);
            $stmt->execute();
        }




        $data['Ack'] = '1';
        $data['msg'] = 'Payment has been paid successfully.Wait for the admin to make your auctio GO LIVE.';


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error !!!';
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listSubscriptions() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = isset($body->user_id) ? $body->user_id : '';

    $db = getConnection();

    $sql1 = "SELECT * from webshop_user where id='" . $user_id . "'";
    $stmt1 = $db->prepare($sql1);
    $stmt1->execute();
    $getDetails = $stmt1->fetchObject();

//$user_array = explode(',', $getDetails->user_id);
    $existsuser = $getDetails->special_package_id;

    if ($existsuser) {
        $sql = "SELECT * from webshop_subscription where status = 1 and subscription_for=2 and type='N' or id='" . $getDetails->special_package_id . "'";
    } else {
        $sql = "SELECT * from webshop_subscription where status = 1 and type='N' and subscription_for=2";
    }

    try {


        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubscriptions = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubscriptions as $subscription) {

            $allsubscriptions[] = array(
                "id" => stripslashes($subscription->id),
                "name" => stripslashes($subscription->name),
                "price" => stripslashes($subscription->price),
                "slots" => stripslashes($subscription->slots),
                "duration" => stripslashes($subscription->duration),
                "type" => stripslashes($subscription->type),
            );
        }

        $data['subscriptionlist'] = $allsubscriptions;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

//spandan


function listSubscribed() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = isset($body->user_id) ? $body->user_id : '';

    $db = getConnection();


    try {

        $sqluser = "SELECT * from webshop_user where id=:user_id";
        $stmtuser = $db->prepare($sqluser);
        $stmtuser->bindParam("user_id", $user_id);
        $stmtuser->execute();
        $getuser = $stmtuser->fetchObject();

        $active = $getuser->current_subscription_id;
        $slotremain = $getuser->slot_no;

        $sql = "SELECT w.id,w.name,w.slots,ws.price,ws.subscription_date,ws.expiry_date,ws.id as sid from webshop_subscribers as ws inner join webshop_subscription as w on w.id=ws.subscription_id where ws.user_id=:user_id order by ws.id desc";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getSubscriptions = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubscriptions as $subscription) {

            $allsubscriptions[] = array(
                "id" => stripslashes($subscription->id),
                "name" => stripslashes($subscription->name),
                "price" => stripslashes($subscription->price),
                "slots" => stripslashes($subscription->slots),
                "subscription_date" => date('d M, Y', strtotime($subscription->subscription_date)),
                "expiry_date" => date('d M, Y', strtotime($subscription->expiry_date)),
                "subscribed_id" => $subscription->sid,
                "active" => $active,
                "slot_remain" => $slotremain,
            );
        }

        $data['subscribedLists'] = $allsubscriptions;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

//spandan 03_05



/* function addUserSubscription() {

  $data = array();

  $app = \Slim\Slim::getInstance();
  $request = $app->request();
  $body = ($request->post());
  $body2 = $app->request->getBody();
  $body = json_decode($body2);

  $db = getConnection();

  $user_id = isset($body->user_id) ? $body->user_id : '';
  $subscription_id = isset($body->subscription_id) ? $body->subscription_id : '';


  $name = isset($body->name) ? $body->name : '';
  $email = isset($body->email) ? $body->email : '';
  $phone = isset($body->phone) ? $body->phone : '';



  $sql2 = "SELECT * from webshop_user where id =:user_id";
  $stmt2 = $db->prepare($sql2);
  $stmt2->bindParam("user_id", $user_id);
  $stmt2->execute();
  $getSubscriptionValue = $stmt2->fetchObject();

  if ($getSubscriptionValue->subscription_id == '0') {
  $data['new_subscriber'] = '0'; // for new subscriber
  } else {
  $data['new_subscriber'] = '1'; // for old subscriber
  }



  $sql3 = "SELECT * from webshop_subscription where id =:subscription_id";
  $stmt3 = $db->prepare($sql3);
  $stmt3->bindParam("subscription_id", $subscription_id);
  $stmt3->execute();
  $getSubscriptionDetails = $stmt3->fetchObject();



  $sql4 = "INSERT INTO  webshop_subscribers (user_id,subscription_id,price,subscription_date,expiry_date,transaction_id) VALUES (:user_id,:subscription_id,:price,:subscription_date,:expiry_date,:transaction_id)";


  $days = $getSubscriptionDetails->duration;
  $date = date('Y-m-d');
  $cdate = date_create($date);
  date_add($cdate, date_interval_create_from_date_string("$days days"));
  $expiry_date = date_format($cdate, "Y-m-d");
  $transaction_id = "pay-12376";


  $stmt4 = $db->prepare($sql4);
  $stmt4->bindParam("user_id", $user_id);
  $stmt4->bindParam("subscription_id", $subscription_id);
  $stmt4->bindParam("price", $getSubscriptionDetails->price);
  $stmt4->bindParam("subscription_date", $date);
  $stmt4->bindParam("expiry_date", $expiry_date);
  $stmt4->bindParam("transaction_id", $transaction_id);
  $stmt4->execute();



  $sql = "UPDATE  webshop_user SET subscription_id=:subscription_id,slot_no=:slot_no,total_slot=:slot_no WHERE id=:user_id";
  $slot = $getSubscriptionDetails->slots;
  $stmt = $db->prepare($sql);
  $stmt->bindParam("subscription_id", $subscription_id);
  $stmt->bindParam("slot_no", $slot);
  $stmt->bindParam("user_id", $user_id);
  $stmt->execute();


  $data['subscription_id'] = $subscription_id;
  $data['Ack'] = 1;
  $data['msg'] = 'Your Subscription completed successfully.';
  $app->response->setStatus(200);


  $app->response->write(json_encode($data));
  } */

function getAuctionDates() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_auctiondates";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $allAuctionDates = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($allAuctionDates as $auctionDates) {

            $getAllAuctionDates[] = array(
                "id" => stripslashes($auctionDates->id),
                "date" => stripslashes($auctionDates->date),
                "start_time" => stripslashes($auctionDates->start_time),
                "end_time" => stripslashes($auctionDates->end_time),
            );
        }

        $data['auctionList'] = $getAllAuctionDates;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function auctionListSearch() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $brand = isset($body->brand) ? $body->brand : '';
    
    $brandListing = isset($body->brandList) ? $body->brandList : '';
    $sellerListing = isset($body->sellerList) ? $body->sellerList : '';
    $selected_value = isset($body->selected_value) ? $body->selected_value : '';
    $amount_min = isset($body->amount_min) ? $body->amount_min : '';
    $amount_max = isset($body->amount_max) ? $body->amount_max : '';

    $gender = isset($body->gender) ? $body->gender : '';
    $breslettype = isset($body->breslettype) ? $body->breslettype : '';
    $year = isset($body->year) ? $body->year : '';
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';

    $country_id = isset($body->country_id) ? $body->country_id : '';
    $state_id = isset($body->state_id) ? $body->state_id : '';
    $city_id = isset($body->city_id) ? $body->city_id : '';
    $category = isset($body->categorylisting) ? $body->categorylisting : '';
    $movement = isset($body->movement) ? $body->movement : '';
    
    $size_amount_max = isset($body->size_amount_max) ? $body->size_amount_max : '';
    $size_amount_min = isset($body->size_amount_min) ? $body->size_amount_min : '';
//print_r($body);exit;

    $productIds = array();

    if ($selected_value == '4') {

        $new_sql = "SELECT * from webshop_reviews order by rating desc";
        $stmt2 = $db->prepare($new_sql);
        $stmt2->execute();
        $total_rows = $stmt2->rowCount();
        $getIds = $stmt2->fetchAll(PDO::FETCH_OBJ);


        if ($total_rows > 0) {

            foreach ($getIds as $product) {

                array_push($productIds, $product->product_id);
            }
        }

        $productIds = array_unique($productIds);

// print_r($productIds);
// exit;

        $productIds = implode(",", $productIds);


        $sql = "SELECT * from webshop_products where status = 1 and type='2' and auctioned ='0' and id IN(" . $productIds . ")";
    } else {


        $sql = "SELECT * from  webshop_products where status=1 and type='2' and auctioned ='0'";
    }

    if ($amount_min != '' && $amount_max != '') {

        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min == '' && $amount_max != '') {
        $amount_min = 0.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min != '' && $amount_max == '') {
        $amount_max = 10000.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    }

    if ($size_amount_min != '' && $size_amount_max != '') {

        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    } else if ($size_amount_min == '' && $size_amount_max != '') {
        $size_amount_min = 0.00;
        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    } else if ($size_amount_min != '' && $size_amount_max == '') {
        $size_amount_max = 1000.00;
        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    }
    if ($brandListing != '') {

        $sql .= " AND `brands` IN (" . $brandListing . ")";
    }
    
    if ($movement != '') {

        $sql .= " AND `movement` IN (" . $movement . ")";
    }
    if ($sellerListing != '') {

        $sql .= " AND `uploader_id` IN (" . $sellerListing . ")";
    }


//spandan
if ($category != '') {

       // $sql .= " AND `cat_id` = '" . $category . "'";
         $sql .= " AND `cat_id` IN (" . $category . ")";
    }
    if ($gender != '') {

        $sql .= " AND `gender`='" . $gender . "' ";
    }

    if ($brand != '') {

       $sql .= " AND `brands` = '" . $brand . "'";
    }
    
    if ($breslettype != '') {

        $sql .= " AND `breslet_type` = '" . $breslettype . "'";
    }
    if ($year != '') {

        $sql .= " AND model_year = '" . $year . "'";
    }
    if ($preferred_date != '') {

        $sql .= " AND preferred_date = '" . $preferred_date . "'";
    }

    if ($country_id != '') {

        $sql .= " AND country = '" . $country_id . "'";
    }
    if ($state_id != '') {

        $sql .= " AND state = '" . $state_id . "'";
    }
    if ($city_id != '') {

        $sql .= " AND city = '" . $city_id . "'";
    }



//spandan end

    if ($selected_value == '1') {

        $sql .= " ORDER BY price ASC";
    }
    if ($selected_value == '2') {

        $sql .= " ORDER BY price DESC";
    }
    if ($selected_value == '3') {

        $sql .= " ORDER BY add_date DESC";
    }


//echo $sql;exit;


    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);


        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {
                 $price =$product->price;
                if ($product->image != '') {
                    $image = SITE_URL . 'upload/product_image/' . $product->image;
                } else {
                    $image = SITE_URL . 'webservice/not-available.jpg';
                }


                $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam("id", $product->cat_id);
                $stmt2->execute();
                $getcategory = $stmt2->fetchObject();
                if (!empty($getcategory)) {
                    $categoryname = $getcategory->name;
                }



                $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam("id", $product->brands);
                $stmt3->execute();
                $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }
//Seller Information

                $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("id", $product->uploader_id);
                $stmt1->execute();
                $getUserdetails = $stmt1->fetchObject();
               // $price='';
                if (!empty($getUserdetails)) {
                    $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                    $seller_address = $getUserdetails->address;
                    $seller_phone = $getUserdetails->phone;
                    $email = $getUserdetails->email;
                    $top = $getUserdetails->top_user_vendor;
                    if ($getUserdetails->image != '') {
                        $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                    } else {
                        $profile_image = SITE_URL . 'webservice/no-user.png';
                    }
                    
                    
                     
                } else {
                    $profile_image = '';
                }
                
                if($user_id){
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                            //echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                    }else{
                        $price = $product->price;
                    }
                $product_encoded_id =  urlencode ( base64_encode($product->id));
                $data['productList'][] = array(
                    "id" => stripslashes($product_encoded_id),
                    "image" => stripslashes($image),
                    "price" => stripslashes($price),
                    "description" => strip_tags(stripslashes($product->description)),
                    "category_name" => $categoryname,
                    "brand_name" => $subcategoryname,
// "preferred_date" => $product->preferred_date,
                    "currency" => stripslashes($product->currency_code),
                    "seller_id" => stripslashes($product->uploader_id),
                    "seller_image" => $profile_image,
                    "seller_name" => stripslashes($seller_name),
                    "seller_address" => stripslashes($seller_address),
                    "seller_phone" => stripslashes($seller_phone),
                    "productname" => stripslashes($product->name),
                    "top" => stripslashes($top)
                );
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['productList'] = array();
            $data['Ack'] = '0';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
//print_r($data['productList']);exit;
    $app->response->write(json_encode($data));
}

function listshops() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    //$user_id = isset($body->user_id) ? $body->user_id : '';


    try {

       

            $sql = "SELECT * from webshop_user where type = '2' AND status='1' AND email_verified='1' AND is_admin_approved='1'";
       


        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getShops = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getShops as $shopOwner) {

            $Ownershop[] = array(
                "id" => stripslashes($shopOwner->id),
                "name" => stripslashes($shopOwner->fname . " " . $shopOwner->lname)
            );
        }

        $data['shopOwners'] = $Ownershop;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getYears() {

    $data = array();

    $allYears = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $last_year = date("Y");

    for ($year = $last_year; $year >= 2000; $year--) {

        array_push($allYears, $year);
    }

    $data['Ack'] = '1';
    $data['Years'] = $allYears;

    $app->response->write(json_encode($data));
}

function bidsubmit() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $date = date('Y-m-d');
    $userid = isset($body->userid) ? $body->userid : '';
    $productid = isset($body->productid) ? $body->productid : '';
    $bidprice = isset($body->bidprice) ? $body->bidprice : '';
    $nextbidprice = isset($body->nextbidprice) ? $body->nextbidprice : '';
    $uploaderid = isset($body->uploaderid) ? $body->uploaderid : '';
 $db = getConnection();
    if($userid){
                              
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$userid ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $bidprice = $bidprice / $currency['currency_rate_to_usd'];
                            $nextbidprice = $nextbidprice / $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }
                              
                            
                        } 
                    }
    
    
    
    $sql = "INSERT INTO  webshop_biddetails (userid,productid,bidprice,nextbidprice,uploaderid,date) VALUES (:userid,:productid,:bidprice,:nextbidprice,:uploaderid,:date)";
   
    $stmt = $db->prepare($sql);
    $stmt->bindParam("userid", $userid);
    $stmt->bindParam("productid", $productid);
    $stmt->bindParam("bidprice", $bidprice);
    $stmt->bindParam("nextbidprice", $nextbidprice);
    $stmt->bindParam("uploaderid", $uploaderid);
    $stmt->bindParam("date", $date);
    $stmt->execute();
    $data['Ack'] = '1';
    $data['Years'] = 'hello';
    $sql1 = "UPDATE  webshop_products SET nextbidprice=:nextbidprice,lastbidvalue=:lastbidvalue,lastbidderid=:lastbidderid WHERE id=:productid";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("nextbidprice", $nextbidprice);
    $stmt1->bindParam("lastbidvalue", $bidprice);
    $stmt1->bindParam("lastbidderid", $userid);
    $stmt1->bindParam("productid", $productid);
    $stmt1->execute();
    $app->response->write(json_encode($data));
}

function listAuctionDtates() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_auctiondates";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getDate = $stmt->fetchAll(PDO::FETCH_OBJ);
        $allbrand = array();

        foreach ($getDate as $brand) {
            $date = explode('-', stripslashes($brand->date));
            $datefordatepicker = $date[0] . '/' . $date[1] . '/' . $date[2];
            $current_date = date('Y-m-d');
            $currnt_date = strtotime($current_date);
            $datepickerdate = strtotime($datefordatepicker);
            if ($datepickerdate >= $currnt_date) {
                $allbrand[] = array(
                    stripslashes($datefordatepicker)
                );
            }
        }

        $data['listAuctionDtates'] = $allbrand;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

//spandan 25_04_2018

function getTimeslot() {
// echo 's';
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    

    $acutondate = isset($body->getdate) ? $body->getdate : '';
// $productid = isset($body->productid) ? $body->productid : '';



    $sql = "SELECT * FROM  webshop_auctiondates WHERE  date =:acutondate";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("acutondate", $acutondate);
    $stmt->execute();
    $getauctiondate = $stmt->fetchAll(PDO::FETCH_OBJ);

// print_r($getauctiondate);



    if (!empty($getauctiondate)) {
        foreach ($getauctiondate as $auction) {

            $sqlexsits = "SELECT * FROM  webshop_products WHERE  time_slot_id =:time_slot_id";
            $db = getConnection();
            $stmt1 = $db->prepare($sqlexsits);
            $stmt1->bindParam("time_slot_id", $auction->id);

            $stmt1->execute();
            $bookeddatetime = $stmt1->fetchAll(PDO::FETCH_OBJ);

//            $tim = '';
//            if (!empty($bookeddatetime)) {
//                foreach ($bookeddatetime as $btime) {
//                    echo 'hi';
//                    $tim = (stripslashes($btime->time_slot_id));
//                }
//            } else {
//                $tim = '';
//            }


            if (!empty($bookeddatetime)) {

                $data['time'][] = array(
                    'start_time' => date('h:i A', strtotime($auction->start_time)),
                    'end_time' => date('h:i A', strtotime($auction->end_time)),
                    'id' => stripslashes($auction->id),
                    "status" => 1,
                );
            } else {

                $data['time'][] = array(
                    'start_time' => date('h:i A', strtotime($auction->start_time)),
                    'end_time' => date('h:i A', strtotime($auction->end_time)),
                    'id' => stripslashes($auction->id),
                    "status" => 0,
                );
            }
//print_r($data);
//exit;
        }
    }
// print_r($data);
//exit;


    $data['Ack'] = '1';
//$data['Years'] = 'hello';

    $app->response->write(json_encode($data));
}

/* function getTimeslot() {
  // echo 's';
  $data = array();

  $app = \Slim\Slim::getInstance();
  $request = $app->request();
  $body2 = $app->request->getBody();
  $body = json_decode($body2);
  //print_r($body);
  $acutondate = isset($body->getdate) ? $body->getdate : '';
  // $productid = isset($body->productid) ? $body->productid : '';



  $sql = "SELECT * FROM  webshop_auctiondates WHERE  date =:acutondate";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("acutondate", $acutondate);


  $stmt->execute();
  $getauctiondate = $stmt->fetchAll(PDO::FETCH_OBJ);


  if (!empty($getauctiondate)) {
  foreach ($getauctiondate as $auction) {


  $time = stripslashes($auction->time);
  }
  }

  $time = explode(',', $time);
  if ($time) {
  foreach ($time as $key => $val) {
  $sql1 = "SELECT * FROM  webshop_auctiontimes WHERE  id =:timeid";
  $stmt23 = $db->prepare($sql1);
  $stmt23->bindParam("timeid", $val);
  $stmt23->execute();
  $gettime = $stmt23->fetchAll(PDO::FETCH_OBJ);

  foreach ($gettime as $time) {
  $data['time'][] = array(
  "id" => stripslashes($time->id),
  "start_time" => stripslashes($time->start_time),
  "end_time" => stripslashes($time->end_time),
  );
  //echo $i++;
  }
  }
  }
  // $i=0;
  //count($gettime);





  $data['Ack'] = '1';
  //$data['Years'] = 'hello';

  $app->response->write(json_encode($data));
  } */

function getauctiondetails() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $userid = isset($body->userid) ? $body->userid : '';
    $productid = isset($body->productid) ? $body->productid : '';



    $sql = "SELECT * FROM  webshop_biddetails WHERE  productid=:productid AND uploaderid=:userid ORDER BY id DESC";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("userid", $userid);
    $stmt->bindParam("productid", $productid);

    $stmt->execute();
    $getauctiondetails = $stmt->fetchAll(PDO::FETCH_OBJ);

//  print_r($getauctiondetails);
// exit;

    if (!empty($getauctiondetails)) {
        foreach ($getauctiondetails as $auction) {

            $sql2 = "SELECT * FROM  webshop_user WHERE id=:id";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam("id", $auction->userid);
            $stmt2->execute();
            $getUserdetails = $stmt2->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = SITE_URL . 'webservice/no-user.png';
            }

            $data['UserDetails'][] = array(
                "userid" => stripslashes($auction->userid),
                "productid" => stripslashes($auction->productid),
                "bidprice" => stripslashes($auction->bidprice),
                "uploaderid" => stripslashes($auction->uploaderid),
                "date" => stripslashes($auction->date),
                "user_name" => stripslashes($getUserdetails->fname),
                "image" => stripslashes($profile_image),
            );
        }
    }




    $data['Ack'] = '1';
    $data['Years'] = 'hello';

    $app->response->write(json_encode($data));
}

function listcuntry() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_countries";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getCountry = $stmt->fetchAll(PDO::FETCH_OBJ);


        foreach ($getCountry as $country) {
// $date = explode('-', stripslashes($brand->date));
// $datefordatepicker = $date[0] . '/' . $date[1] . '/' . $date[2];

            $allcountry[] = array(
                'name' => stripslashes($country->name),
                'id' => stripslashes($country->id),
            );
        }
//print_r($data);

        $data['countrylist'] = $allcountry;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function liststatus() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_watchstatus";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);


        foreach ($getStatus as $status) {
// $date = explode('-', stripslashes($brand->date));
// $datefordatepicker = $date[0] . '/' . $date[1] . '/' . $date[2];

            $allstatus[] = array(
                'name' => stripslashes($status->status),
                'id' => stripslashes($status->id),
                'rating'=>stripslashes($status->rating),
            );
        }
//print_r($data);

        $data['statuslist'] = $allstatus;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getproductdetailsforedit() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_products WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $body->id);
        $stmt->execute();
        $getProductdetails = $stmt->fetchObject();
        $stmt->execute();
        $getProduct = $stmt->fetchAll(PDO::FETCH_OBJ);

//$allproduct='';
        foreach ($getProduct as $pro) {
// $date = explode('-', stripslashes($brand->date));
// $datefordatepicker = $date[0] . '/' . $date[1] . '/' . $date[2];

            $allproduct = array(
                'uploader_id' => stripslashes($pro->uploader_id),
                'cat_id' => stripslashes($pro->cat_id),
                'brands' => stripslashes($pro->brands),
                'currency_code' => stripslashes($pro->currency_code),
                'type' => stripslashes($pro->type),
                'name' => stripslashes($pro->name),
                'description' => stripslashes($pro->description),
                'price' => stripslashes($pro->price),
                'quantity' => stripslashes($pro->quantity),
                'movement' => stripslashes($pro->movement),
                'gender' => stripslashes($pro->gender),
                'reference_number' => stripslashes($pro->reference_number),
                'date_purchase' => stripslashes($pro->date_purchase),
                'status_watch' => stripslashes($pro->status_watch),
                'owner_number' => stripslashes($pro->owner_number),
                'country' => stripslashes($pro->country),
                'size' => stripslashes($pro->size),
                'location' => stripslashes($pro->location),
                'work_hours' => stripslashes($pro->work_hours),
                'image' => stripslashes($pro->image),
                    //'preferred_date'=>stripslashes($pro->preferred_date),
            );
        }


        $sqlimage = "SELECT * from webshop_product_image WHERE product_id=:product_id";
        $stmtimage = $db->prepare($sqlimage);
        $stmtimage->bindParam("product_id", $body->id);

        $stmtimage->execute();
        $getimage = $stmtimage->fetchAll(PDO::FETCH_OBJ);
        foreach ($getimage as $pro) {
// $date = explode('-', stripslashes($brand->date));
// $datefordatepicker = $date[0] . '/' . $date[1] . '/' . $date[2];

            $allimage[] = array(
                'image' => stripslashes($pro->image),
                    //'preferred_date'=>stripslashes($pro->preferred_date),
            );
        }

        $data['allproduct'] = $allproduct;
        $data['allimage'] = $allimage;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function newsleterRegister() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $email = isset($body->email) ? $body->email : '';
    $sql = "SELECT * FROM  webshop_newsletter WHERE  email=:email";
    $db = getConnection();
    $stmt = $db->prepare($sql);

    $stmt->bindParam("email", $email);
    $stmt->execute();
    $usersCount = $stmt->rowCount();

    $sql1 = "INSERT INTO  webshop_newsletter (email) VALUES (:email)";

    if ($usersCount == 0) {
        try {
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("email", $email);

            $stmt1->execute();
            $data['Ack'] = '1';
        } catch (PDOException $e) {

            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = $e->getMessage();

            $app->response->setStatus(401);
        }
    } else {
        $data['user_id'] = '';
        $data['Ack'] = '2';
        $data['message'] = 'Email already exists';
    }
    $app->response->write(json_encode($data));
}

function ProductListSearch() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $brand = isset($body->brand) ? $body->brand : '';
    $brandListing = isset($body->brandList) ? $body->brandList : '';
    $sellerListing = isset($body->sellerList) ? $body->sellerList : '';
    $selected_value = isset($body->selected_value) ? $body->selected_value : '';
    $amount_min = isset($body->amount_min) ? $body->amount_min : '';
    $amount_max = isset($body->amount_max) ? $body->amount_max : '';

    $gender = isset($body->gender) ? $body->gender : '';
    $breslettype = isset($body->breslettype) ? $body->breslettype : '';
    $year = isset($body->year) ? $body->year : '';
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';

    $country_id = isset($body->country_id) ? $body->country_id : '';
    $state_id = isset($body->state_id) ? $body->state_id : '';
    $city_id = isset($body->city_id) ? $body->city_id : '';
    $keyword = isset($body->keyword) ? $body->keyword : '';
    $category = isset($body->category) ? $body->category : '';
    $movement = isset($body->movement) ? $body->movement : '';
    $size_amount_max = isset($body->size_amount_max) ? $body->size_amount_max : '';
    $size_amount_min = isset($body->size_amount_min) ? $body->size_amount_min : '';
    $top_product = isset($body->top_product) ? $body->top_product : '';
//print_r($body);
//-----------------------------------------------------------
    $productIds = array();

    if ($selected_value == '4') {

        $new_sql = "SELECT * from webshop_reviews order by rating desc";
        $stmt2 = $db->prepare($new_sql);
        $stmt2->execute();
        $total_rows = $stmt2->rowCount();
        $getIds = $stmt2->fetchAll(PDO::FETCH_OBJ);


        if ($total_rows > 0) {

            foreach ($getIds as $product) {

                array_push($productIds, $product->product_id);
            }
        }

        $productIds = array_unique($productIds);

// print_r($productIds);
// exit;

        $productIds = implode(",", $productIds);
        $sql = "SELECT * from webshop_products where status = 1 and approved='1' and type='1' and is_discard='0' and id IN(" . $productIds . ")";
    } else {


        $sql = "SELECT * from  webshop_products where status=1 and approved='1' and type='1' and is_discard='0' ";
    }

    if ($amount_min != '' && $amount_max != '') {

        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min == '' && $amount_max != '') {
        $amount_min = 0.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min != '' && $amount_max == '') {
        $amount_max = 10000.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    }
//size
    if ($size_amount_min != '' && $size_amount_max != '') {

        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    } else if ($size_amount_min == '' && $size_amount_max != '') {
        $size_amount_min = 0.00;
        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    } else if ($size_amount_min != '' && $size_amount_max == '') {
        $size_amount_max = 1000.00;
        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    }
    if ($brandListing != '') {

        $sql .= " AND `brands` IN (" . $brandListing . ")";
    }
    if ($sellerListing != '') {

        $sql .= " AND `uploader_id` IN (" . $sellerListing . ")";
    }

if ($movement != '') {

        $sql .= " AND `movement` IN ('" . $movement . "')";
    }
//spandan

    if ($category != '') {

       // $sql .= " AND `cat_id` = '" . $category . "'";
         $sql .= " AND `cat_id` IN (" . $category . ")";
    }
    if ($gender != '') {

        $sql .= " AND `gender`='" . $gender . "' ";
    }
   if ($top_product != '') {

        $sql .= " AND `top_product_status`='" . $top_product . "' ";
    }

    if ($breslettype != '') {

        $sql .= " AND `breslet_type` = '" . $breslettype . "'";
    }

    if ($year != '') {

        $sql .= " AND model_year = '" . $year . "'";
    }
    //echo $sql;
   if ($keyword != '') {

        $keywordbrand = "SELECT * FROM webshop_brands WHERE id ='$keyword' OR name='$keyword'";
        $stmt2 = $db->prepare($keywordbrand);

        $stmt2->execute();
        $getkeywordbrand = $stmt2->fetchObject();
        if(!empty($getkeywordbrand)){
           $keybrandid = $getkeywordbrand->id; 
        }else{
            $keybrandid = '';
        }
        //print_r($getkeywordbrand->id);
    }
if ($keyword != '') {

        $keywordcategory = "SELECT * FROM webshop_category WHERE id ='$keyword' OR name='$keyword'";
        $stmtcategory = $db->prepare($keywordcategory);

        $stmtcategory->execute();
        $getkeywordcategory = $stmtcategory->fetchObject();
         if(!empty($getkeywordcategory)){
           $keycatid = $getkeywordcategory->id; 
        }else{
            $keycatid = '';
        }
    }

   // exit;
    if ($keyword != '') {

        $sql .= " AND `model_year` LIKE '%" . $keyword . "%' OR `gender` LIKE '" . $keyword . "%' OR `preferred_date` LIKE '%" . $keyword . "%' OR `brands` LIKE '" . $keybrandid . "' OR `name` LIKE '" . $keyword . "' OR `description` LIKE '" . $keyword . "' OR `price` LIKE '" . $keyword . "' OR `movement` LIKE '" . $keyword . "' OR `reference_number` LIKE '" . $keyword . "' OR `owner_number` LIKE '" . $keyword . "' OR `cat_id` LIKE '" . $keycatid . "' AND type=1 ";
    }
     //exit;
    /* if ($year == '' && $keyword != '') {

      $sql .= " AND `model_year` LIKE '%" . $keyword . "%'";
      }
      if ($year != '' && $keyword != '') {

      $sql .= " AND model_year = '" . $year . "'OR `model_year` LIKE '%" . $keyword . "%'";
      } */
    //exit;
    /* if ($preferred_date != '' && $keyword != '') {

      $sql .= " AND preferred_date = '" . $preferred_date . "'OR `preferred_date` LIKE '%" . $keyword . "%'";
      } */
    if ($preferred_date != '') {

        $sql .= " AND preferred_date = '" . $preferred_date . "'";
    }
    /* if ($preferred_date == '' && $keyword != '') {

      $sql .= " OR  `preferred_date` LIKE '%" . $keyword . "%'";
      } */


    if ($country_id != '') {

        $sql .= " AND country = '" . $country_id . "'";
    }
    if ($state_id != '') {

        $sql .= " AND state = '" . $state_id . "'";
    }
    if ($city_id != '') {

        $sql .= " AND city = '" . $city_id . "'";
    }


//spandan end

    if ($selected_value == '1') {

        $sql .= " ORDER BY price ASC";
    }
    if ($selected_value == '2') {

        $sql .= " ORDER BY price DESC";
    }
    if ($selected_value == '3') {

        $sql .= " ORDER BY add_date DESC";
    }



//    echo $sql;
//    exit;

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);


        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {
                $sid = $product->subscription_id;
                $price =$product->price;
                $topsid=$product->top_product;
                
                
                if ($sid != 0) {
                    
                    
                    $sqlsubs = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs = $db->prepare($sqlsubs);
                    $stmtsubs->bindParam("id", $sid);
                    $stmtsubs->execute();
                    $getsubs = $stmtsubs->fetchObject();

                    $cdate = date('Y-m-d');

                    if ($getsubs->expiry_date >= $cdate) {
                        
                        
                    if($topsid!= 0){    
                    $sqlsubs_top = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs_top = $db->prepare($sqlsubs_top);
                    $stmtsubs_top->bindParam("id", $topsid);
                    $stmtsubs_top->execute();
                    $getsubs_top = $stmtsubs_top->fetchObject();

                       if ($getsubs_top->expiry_date >= $cdate) {
                           
                          $top_product_status =1;
                           
                       }else{
                           
                            $top_product_status =0;
                       } 
                        
                    } else{
                           
                            $top_product_status =0;
                       }   
                        
                        
                        

                        if ($product->image != '') {
                            $image = SITE_URL . 'upload/product_image/' . $product->image;
                        } else {
                            $image = SITE_URL . 'webservice/not-available.jpg';
                        }


                        $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                        $stmt2 = $db->prepare($sql2);
                        $stmt2->bindParam("id", $product->cat_id);
                        $stmt2->execute();
                        $getcategory = $stmt2->fetchObject();
                        if (!empty($getcategory)) {
                            $categoryname = $getcategory->name;
                        }



                        $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                        $stmt3 = $db->prepare($sql3);
                        $stmt3->bindParam("id", $product->brands);
                        $stmt3->execute();
                        $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }
//Seller Information

                        $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                        $stmt1 = $db->prepare($sql1);
                        $stmt1->bindParam("id", $product->uploader_id);
                        $stmt1->execute();
                        $getUserdetails = $stmt1->fetchObject();
                        $userselected_currency='';
                        
                        if (!empty($getUserdetails)) {
                            $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                            $seller_address = $getUserdetails->address;
                            $seller_phone = $getUserdetails->phone;
                            $email = $getUserdetails->email;
                            $top = $getUserdetails->top_user_vendor;

                            if ($getUserdetails->image != '') {
                                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                            } else {
                                $profile_image = SITE_URL . 'webservice/no-user.png';
                            }
                            
                            
                        } else {
                            $profile_image = '';
                        }
                         if($user_id){
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                            //echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                    }else{
                        $price = $product->price;
                    }
                    $product_encoded_id =  urlencode ( base64_encode($product->id));
                        $data['productList'][] = array(
                            "id" => stripslashes($product_encoded_id),
                            "image" => stripslashes($image),
                            "price" => stripslashes($price),
                            "description" => strip_tags(stripslashes($product->description)),
                            "category_name" => $categoryname,
                             "brands" => $subcategoryname,
                            "seller_id" => stripslashes($product->uploader_id),
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            "seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($seller_phone),
                            "productname" => '',
                            "currency_code" => stripslashes($product->currency_code),
                            
                            "top" => stripslashes($top),
                            "top_product" => stripslashes($top_product_status),
                        );
                    }
                } else {



                    if ($product->image != '') {
                        $image = SITE_URL . 'upload/product_image/' . $product->image;
                    } else {
                        $image = SITE_URL . 'webservice/not-available.jpg';
                    }


                    $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam("id", $product->cat_id);
                    $stmt2->execute();
                    $getcategory = $stmt2->fetchObject();
                    if (!empty($getcategory)) {
                        $categoryname = $getcategory->name;
                    }
                    
                    
                    if($topsid!= 0){    
                    $sqlsubs_top = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs_top = $db->prepare($sqlsubs_top);
                    $stmtsubs_top->bindParam("id", $topsid);
                    $stmtsubs_top->execute();
                    $getsubs_top = $stmtsubs_top->fetchObject();

                       if ($getsubs_top->expiry_date >= $cdate) {
                           
                          $top_product_status =1;
                           
                       }else{
                           
                            $top_product_status =0;
                       } 
                        
                    } else{
                           
                            $top_product_status =0;
                       } 



                        $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                        $stmt3 = $db->prepare($sql3);
                        $stmt3->bindParam("id", $product->brands);
                        $stmt3->execute();
                        $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }


                    $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("id", $product->uploader_id);
                    $stmt1->execute();
                    $getUserdetails = $stmt1->fetchObject();
                       // $price ='';
                    if (!empty($getUserdetails)) {
                        $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                        $seller_address = $getUserdetails->address;
                        $seller_phone = $getUserdetails->phone;
                        $email = $getUserdetails->email;
                        $top = $getUserdetails->top_user_vendor;
                        if ($getUserdetails->image != '') {
                            $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                        } else {
                            $profile_image = SITE_URL . 'webservice/no-user.png';
                        }
                        
                        
                        
                    } else {
                        $profile_image = '';
                    }
                    if($user_id){
                    $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                            //echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                }
                $product_encoded_id =  urlencode ( base64_encode($product->id));
                    $data['productList'][] = array(
                            "id" => stripslashes($product_encoded_id),
                            "image" => stripslashes($image),
                            "price" => stripslashes($price),
                            "description" => strip_tags(stripslashes($product->description)),
                            "category_name" => $categoryname,
                             "brands" => $subcategoryname,
                            "seller_id" => stripslashes($product->uploader_id),
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            "seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($seller_phone),
                            "productname" => '',
                            "currency_code" => stripslashes($product->currency_code),
                            
                            "top" => stripslashes($top),
                            "top_product" => stripslashes($top_product_status),    
                        );
                }
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['productList'] = array();
            $data['Ack'] = '0';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listproductMessages() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
//print_r($body);
//exit;
    $db = getConnection();
    $to_id = isset($body->user_id) ? $body->user_id : '';
    if ($to_id != 0) {
//    exit;
        try {

            $sql = "SELECT *, (r.from_id + r.to_id) AS dist FROM (SELECT * FROM `webshop_message` as t WHERE ( (t.from_id =:to_id OR t.to_id =:to_id) and product_id!= 0 and to_id!= 0 and from_id!= 0 ) ORDER BY t.add_date ASC) as r GROUP  ORDER BY r.add_date ASC ";
// $sql = "SELECT * from webshop_message WHERE to_id=:to_id or from_id=:to_id ";


            $stmt = $db->prepare($sql);
            $stmt->bindParam("to_id", $to_id);
            $stmt->execute();
            $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);


            $image = '';
            $productname = '';
            if (!empty($getStatus)) {
                foreach ($getStatus as $status) {
                    $sql1 = "SELECT * from webshop_products WHERE id=:product_id ";
                    $product_id = $status->product_id;
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("product_id", $product_id);
                    $stmt1->execute();
                    $getStatus1 = $stmt1->fetchAll(PDO::FETCH_OBJ);
                    if (!empty($getStatus1)) {
                        if ($getStatus1[0]->image != '') {
                            $image = SITE_URL . 'upload/product_image/' . $getStatus1[0]->image;
                        } else {
                            $image = SITE_URL . 'webservice/not-available.jpg';
                        }
                    }
                    $today = date_create(date('Y-m-d'));
                    $add_date = date_create($status->add_date);
                    $diff = date_diff($add_date, $today);
                    $date_diff = $diff->format("%a days");
                    $allmeaage[] = array(
                        'message' => stripslashes($status->message),
                        'to_id' => stripslashes($status->to_id),
                        'from_id' => stripslashes($status->from_id),
                        'product_id' => stripslashes($status->product_id),
                        'id' => stripslashes($status->id),
                        'image' => stripslashes($image),
                        'productname' => '',
                        'date_diff' => $date_diff,
                    );
                }
            }
// print_r($allstatus);
//exit;
            $data['message'] = $allmeaage;
            $data['Ack'] = '1';
// print_r($data);
//exit;
            $app->response->setStatus(200);
        } catch (PDOException $e) {

            $data['Ack'] = 0;
            $data['msg'] = $e->getMessage();
            $app->response->setStatus(401);
        }
    }
    $app->response->write(json_encode($data));
}

function getusercontact() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
//print_r($body);
//exit;
    $db = getConnection();
    $to_id = isset($body->to_id) ? $body->to_id : '';
//    exit;
    try {

        $sql = "SELECT * from webshop_user WHERE id=:to_id ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("to_id", $to_id);
        $stmt->execute();
        $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);
//print_r($getStatus);


        foreach ($getStatus as $status) {


            $allmeaage = array(
                'name' => stripslashes($status->fname),
                'id' => stripslashes($status->id),
            );
        }
// print_r($allstatus);
//exit;
        $data['userdetails'] = $allmeaage;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getProductcontact() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
//print_r($body);
//exit;
    $db = getConnection();
    $product_id = isset($body->product_id) ? $body->product_id : '';
//    exit;
    try {

        $sql = "SELECT * from webshop_products WHERE id=:product_id ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
        $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);
//print_r($getStatus);


        foreach ($getStatus as $status) {


            $allmeaage = array(
                'name' => stripslashes($status->name),
                'id' => stripslashes($status->id),
                'image' => stripslashes($status->image),
            );
        }
// print_r($allstatus);
//exit;
        $data['productdetails'] = $allmeaage;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function addmessage() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
//echo 'a';
//print_r($body);
    $message = isset($body->message) ? $body->message : '';


    $to_id = isset($body->to_id) ? $body->to_id : '';
    $product_id = isset($body->product_id) ? $body->product_id : '';
    $from_id = isset($body->from_id) ? $body->from_id : '';
    $add_date = date('Y-m-d');
    $is_read = '0';
    $last_id = '0';
    $date = date('Y-m-d h:i:s');
//exit;
    $db = getConnection();

    $sql1 = "INSERT INTO  webshop_message (message,to_id,product_id,from_id,is_read,add_date) VALUES (:message,:to_id,:product_id,:from_id,:is_read,:add_date)";
    $sqlnoti = "INSERT INTO  webshop_notification (msg,to_id,from_id,is_read,last_id,date) VALUES (:msg,:to_id,:from_id,:is_read,:last_id,:date)";
    $sqluser = "SELECT * FROM webshop_user WHERE id=:to_id";
    $stmtuser = $db->prepare($sqluser);
    $stmtuser->bindParam("to_id", $to_id);
    $stmtuser->execute();
    $getuser = $stmtuser->fetchObject();

    try {
        $sqladmin = "SELECT * FROM webshop_user WHERE id=$to_id";

        $stmtttadmin = $db->prepare($sqladmin);
        $stmtttadmin->execute();
        $getuser = $stmtttadmin->fetchObject();
        if ($getuser->new_message_notify == 1) {
            $messagefornoti = 'You have a new message from' . $getuser->fname . ' ' . $getuser->lname;
            $type = 'Customer Message';
            $stmtnoti = $db->prepare($sqlnoti);
            $stmtnoti->bindParam("msg", $messagefornoti);
            $stmtnoti->bindParam("to_id", $to_id);
            $stmtnoti->bindParam("from_id", $from_id);
            $stmtnoti->bindParam("is_read", $is_read);
            $stmtnoti->bindParam("date", $date);
            $stmtnoti->bindParam("last_id", $last_id);
            $stmtnoti->execute();
        }


        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("message", $message);
        $stmt1->bindParam("to_id", $to_id);
        $stmt1->bindParam("product_id", $product_id);
        $stmt1->bindParam("from_id", $from_id);
        $stmt1->bindParam("is_read", $is_read);
        $stmt1->bindParam("add_date", $add_date);



        $stmt1->execute();
        $data['Ack'] = '1';
    } catch (PDOException $e) {

        $data['user_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getfullMessages() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $to_id = isset($body->to_id) ? $body->to_id : '';
    $product_id = isset($body->product_id) ? $body->product_id : '';
    $from_id = isset($body->from_id) ? $body->from_id : '';
// $allmeaage = '';
//exit;
    try {

        $sql = "SELECT * from webshop_message WHERE from_id=:from_id AND to_id=:to_id OR from_id=:to_id AND to_id=:from_id AND product_id=:product_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("to_id", $from_id);
        $stmt->bindParam("from_id", $to_id);
        $stmt->bindParam("product_id", $product_id);

        $stmt->execute();
        $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);
        $categoryname = '';
        $product_name = '';
        foreach ($getStatus as $status) {

            /* user image */
            $sql11 = "SELECT * from webshop_user WHERE id=:from_id";
            $stmt11 = $db->prepare($sql11);
            $stmt11->bindParam("from_id", $status->from_id);
            $stmt11->execute();
            $getStatus11 = $stmt11->fetchAll(PDO::FETCH_OBJ);
            if (!empty($getStatus11)) {
                if ($getStatus11[0]->image != '') {
                    $profile_image = SITE_URL . 'upload/user_image/' . $getStatus11[0]->image;
                } else {
                    $profile_image = SITE_URL . 'upload/user_image/nouser.jpg';
                }
            }
            /* user image */

            /* product image */
            $sql12 = "SELECT * from webshop_products WHERE id=:product_id";
            $stmt12 = $db->prepare($sql12);
            $stmt12->bindParam("product_id", $status->product_id);
            $stmt12->execute();
            $getStatus12 = $stmt12->fetchObject();

            if (!empty($getStatus12)) {

                $sqlbrand = "SELECT *  FROM webshop_brands WHERE id=:brand_id";
                $stmtbrand = $db->prepare($sqlbrand);
                $stmtbrand->bindParam("brand_id", $getStatus12->brands);
                $stmtbrand->execute();
                $naxbrand = $stmtbrand->fetchObject();

                $sqlcategory = "SELECT * FROM  webshop_category WHERE id=:id ";
                $stmtcategory = $db->prepare($sqlcategory);
                $stmtcategory->bindParam("id", $getStatus12->cat_id);
                $stmtcategory->execute();
                $getcategory = $stmtcategory->fetchObject();
//print_r($getcategory);
                $product_name = $getcategory->name . '/' . $naxbrand->name;
                if (!empty($getcategory)) {
                    $categoryname = $getcategory->name;
                }

                if ($getStatus12->image != '') {
                    $image = SITE_URL . 'upload/product_image/' . $getStatus12->image;
                } else {
                    $image = SITE_URL . 'webservice/not-available.jpg';
                }
            }

            /* product image */

            $allmeaage[] = array(
                'message' => stripslashes($status->message),
                'to_id' => stripslashes($status->to_id),
                'from_id' => stripslashes($status->from_id),
                'id' => stripslashes($status->id),
                'image' => $profile_image,
            );
            $product_image = $image;
        }
// print_r($allstatus);
//exit;
        $data['fillmessage'] = $allmeaage;
        $data['product_image'] = $product_image;
        $data['product_name'] = $product_name;
        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

//spandan


function addUserSubscription() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $sid = base64_decode($body->subscription_id);
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $subscription_id = isset($sid) ? $sid : '';


//$name = isset($body->name) ? $body->name : '';
//$email = isset($body->email) ? $body->email : '';
//$phone = isset($body->phone) ? $body->phone : '';
//payment gateway
//end




    $sql2 = "SELECT * from webshop_user where id =:user_id";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam("user_id", $user_id);
    $stmt2->execute();
    $getSubscriptionValue = $stmt2->fetchObject();

    if ($getSubscriptionValue->subscription_id == '0') {
        $data['new_subscriber'] = '0'; // for new subscriber
    } else {
        $data['new_subscriber'] = '1'; // for old subscriber
    }


    $sql3 = "SELECT * from webshop_subscription where id =:subscription_id";
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam("subscription_id", $subscription_id);
    $stmt3->execute();
    $getSubscriptionDetails = $stmt3->fetchObject();



    $sql4 = "INSERT INTO  webshop_subscribers (user_id,subscription_id,price,subscription_date,expiry_date,transaction_id) VALUES (:user_id,:subscription_id,:price,:subscription_date,:expiry_date,:transaction_id)";


    $days = $getSubscriptionDetails->duration;
    $date = date('Y-m-d');
    $cdate = date_create($date);
    date_add($cdate, date_interval_create_from_date_string("$days days"));
    $expiry_date = date_format($cdate, "Y-m-d");
    $transaction_id = "pay-12376";


    $stmt4 = $db->prepare($sql4);
    $stmt4->bindParam("user_id", $user_id);
    $stmt4->bindParam("subscription_id", $subscription_id);
    $stmt4->bindParam("price", $getSubscriptionDetails->price);
    $stmt4->bindParam("subscription_date", $date);
    $stmt4->bindParam("expiry_date", $expiry_date);
    $stmt4->bindParam("transaction_id", $transaction_id);
    $stmt4->execute();
    $lastID = $db->lastInsertId();

    if ($getSubscriptionDetails->type == "O") {
        $sql = "UPDATE  webshop_user SET subscription_id=:subscription_id,slot_no=:slot_no,total_slot=:slot_no,special_package_id=0,current_subscription_id= '" . $lastID . "'  WHERE id=:user_id";
    } else {
        $sql = "UPDATE  webshop_user SET subscription_id=:subscription_id,slot_no=:slot_no,total_slot=:slot_no,current_subscription_id= '" . $lastID . "' WHERE id=:user_id";
    }
    $slot = $getSubscriptionDetails->slots;
    $stmt = $db->prepare($sql);
    $stmt->bindParam("subscription_id", $subscription_id);
    $stmt->bindParam("slot_no", $slot);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();


    $data['subscription_id'] = $subscription_id;
    $data['Ack'] = 1;
    $data['msg'] = 'Your Subscription completed successfully.';
    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}

function UserSubscriptionpayment() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $subscription_id = isset($body->subscription_id) ? $body->subscription_id : '';


    $paymentId = base64_encode($subscription_id);


    $name = isset($body->name) ? $body->name : '';
    $email = isset($body->email) ? $body->email : '';
    $phone = isset($body->phone) ? $body->phone : '';

    $sql = "SELECT * from webshop_subscription where id =:subscription_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("subscription_id", $subscription_id);
    $stmt->execute();
    $getSubscriptionValue = $stmt->fetchObject();

    $subscriptionname = $getSubscriptionValue->name;
    $subscriptionprice = $getSubscriptionValue->price;
//payment gateway

    $url = "https://test.myfatoorah.com/pg/PayGatewayService.asmx";

    $user = "testapi@myfatoorah.com"; // Will Be Provided by Myfatoorah
    $password = "E55D0"; // Will Be Provided by Myfatoorah
    $post_string = '<?xml version="1.0" encoding="windows-1256"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
<soap12:Body>
<PaymentRequest xmlns="http://tempuri.org/">
<req>
<CustomerDC>
<Name>' . $name . '</Name>
<Email>' . $email . '</Email>
<Mobile>' . $phone . '</Mobile>
</CustomerDC>
<MerchantDC>
<merchant_code>999999</merchant_code>
<merchant_username>testapi@myfatoorah.com</merchant_username>
<merchant_password>E55D0</merchant_password>
<merchant_ReferenceID>201454542102</merchant_ReferenceID>
<ReturnURL>' . SITE_URL . '#/success/' . $paymentId . '/</ReturnURL>
<merchant_error_url>' . SITE_URL . '#/cancel</merchant_error_url>
</MerchantDC>
<lstProductDC>
<ProductDC>
<product_name>' . $subscriptionname . '</product_name>
<unitPrice>' . $subscriptionprice . '</unitPrice>
<qty>1</qty>
</ProductDC>
</lstProductDC>
</req>
</PaymentRequest>
</soap12:Body>
</soap12:Envelope>';
    $soap_do = curl_init();
    curl_setopt($soap_do, CURLOPT_URL, $url);
    curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($soap_do, CURLOPT_POST, true);
    curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length:
' . strlen($post_string)));
    curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password); //User Name, Password To be provided by Myfatoorah
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array(
        'Content-type: text/xml'
    ));
    $result = curl_exec($soap_do);
    $err = curl_error($soap_do);
//curl_close($soap_do);
//print_r($result);exit;   
    $file_contents = htmlspecialchars(curl_exec($soap_do));
    curl_close($soap_do);
    $doc = new DOMDocument();
    $doc->loadXML(html_entity_decode($file_contents));
//echo $doc;exit;
    $ResponseCode = $doc->getElementsByTagName("ResponseCode");
    $ResponseCode = $ResponseCode->item(0)->nodeValue;
//echo $ResponseCode;exit;
    $ResponseMessage = $doc->getElementsByTagName("ResponseMessage");
    $ResponseMessage = $ResponseMessage->item(0)->nodeValue;
//echo $ResponseMessage;exit;
    if ($ResponseCode == 0) {
        $paymentUrl = $doc->getElementsByTagName("paymentURL");
        $paymentUrl = $paymentUrl->item(0)->nodeValue;
//echo $paymentUrl;exit;

        /* $OrderID = $doc->getElementsByTagName("OrderID");
          $OrderID = $OrderID->item(0)->nodeValue;
          $Paymode = $doc->getElementsByTagName("Paymode");
          $Paymode = $Paymode->item(0)->nodeValue;
          $PayTxnID = $doc->getElementsByTagName("PayTxnID");
          $PayTxnID = $PayTxnID->item(0)->nodeValue;
         */
    }
//end

    $data['url'] = $paymentUrl;
    $data['Ack'] = 1;

    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}

function changeLaguage() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $language_id = isset($body->language_id) ? $body->language_id : '';

// $allmeaage = '';
//    echo $language_id;
//    exit;
    try {

        $sql = "SELECT * from webshop_language WHERE language_id=:language_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("language_id", $language_id);

// print_r($stmt);
        $stmt->execute();
        $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);
//print_r($getStatus);
// print_r($stmt);
//exit;

        foreach ($getStatus as $status) {

            $allmeaage[$status->actual_word] = stripslashes($status->transleted_word);
        }
// print_r($allstatus);
//exit;
        $data['languages'] = $allmeaage;

        $data['Ack'] = '1';
// print_r($data);
//exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function markProduct() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $id = isset($body->id) ? $body->id : '';

    $db = getConnection();

    try {


        $sql2 = "UPDATE  webshop_products SET product_status= 1 WHERE id=:id";
        $db = getConnection();
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("id", $id);
        $stmt2->execute();

        $data['Ack'] = '1';
        $data['msg'] = 'Product Updated Successfully';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {



        $data['Ack'] = 0;
        $data['msg'] = 'Updation Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listexpiredProducts() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';



    $sql1 = "SELECT * from  webshop_subscribers WHERE user_id=:user_id  order by id desc limit 1,1";
    $db = getConnection();
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("user_id", $user_id);
    $stmt1->execute();
    $getsubscription = $stmt1->fetchObject();

    if (!empty($getsubscription)) {
        $sid = $getsubscription->id;


        $sql = "SELECT * from  webshop_products WHERE uploader_id=:user_id and type = '1' and subscription_id=:subscription_id order by id desc";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("subscription_id", $sid);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {


                if ($product->image != '') {
                    $image = SITE_URL . 'upload/product_image/' . $product->image;
                } else {
                    $image = SITE_URL . 'webservice/not-available.jpg';
                }


                $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam("id", $product->cat_id);
                $stmt2->execute();
                $getcategory = $stmt2->fetchObject();
                if (!empty($getcategory)) {
                    $categoryname = $getcategory->name;
                }



                $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam("id", $product->subcat_id);
                $stmt3->execute();
                $getsubcategory = $stmt3->fetchObject();
//            if (!empty($getsubcategory)) {
//                $subcategoryname = $getsubcategory->name;
//            }
//Seller Information

                $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("id", $product->uploader_id);
                $stmt1->execute();
                $getUserdetails = $stmt1->fetchObject();

                if (!empty($getUserdetails)) {
                    $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                    $seller_address = $getUserdetails->address;
                    $seller_phone = $getUserdetails->phone;
                    $email = $getUserdetails->email;

                    if ($getUserdetails->image != '') {
                        $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                    } else {
                        $profile_image = SITE_URL . 'webservice/no-user.png';
                    }
                } else {
                    $profile_image = '';
                }

                $data['productList'][] = array(
                    "id" => stripslashes($product->id),
                    "image" => stripslashes($image),
                    "price" => stripslashes($product->price),
                    "description" => strip_tags(stripslashes(substr($product->description, 0, 50))),
                    "category_name" => $categoryname,
                    "seller_id" => stripslashes($product->uploader_id),
                    "seller_image" => $profile_image,
                    "seller_name" => stripslashes($seller_name),
                    "seller_address" => stripslashes($seller_address),
                    "seller_phone" => stripslashes($seller_phone),
                    "productname" => stripslashes($product->name),
                    "product_status" => stripslashes($product->product_status),
                );
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
        }
    } else {
        $data = array();
        $data['productList'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function markextension() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $id = isset($body->id) ? $body->id : '';
    $user_id = isset($body->user_id) ? $body->user_id : '';

    $db = getConnection();


    $sqlsubscription = "SELECT * from webshop_user where id=:user_id ";
    $stmts = $db->prepare($sqlsubscription);
    $stmts->bindParam("user_id", $user_id);
    $stmts->execute();
    $getUserDetails = $stmts->fetchObject();






    $sql1 = "SELECT * from  webshop_subscribers WHERE user_id=:user_id  order by id desc limit 1";
    $db = getConnection();
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("user_id", $user_id);
    $stmt1->execute();
    $getsubscription = $stmt1->fetchObject();

    $sid = $getsubscription->id;

//echo $sid;exit;

    try {


        $sql2 = "UPDATE  webshop_products SET subscription_id=:subscription_id WHERE id=:id";
        $db = getConnection();
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("subscription_id", $sid);
        $stmt2->bindParam("id", $id);
        $stmt2->execute();



        $rest_slot = (($getUserDetails->slot_no) - 1);
        $sqlslotupdate = "UPDATE webshop_user SET slot_no=:slot WHERE id=:user_id";
        $stmtslot = $db->prepare($sqlslotupdate);
        $stmtslot->bindParam("slot", $rest_slot);
        $stmtslot->bindParam("user_id", $user_id);
        $stmtslot->execute();






        $data['Ack'] = '1';
        $data['msg'] = 'Product extended Successfully';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {


        $data['Ack'] = 0;
        $data['msg'] = 'Updation Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function userpayment() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
// echo $user_id;exit;
    $db = getConnection();

    try {


        $sql2 = "select * from webshop_user  WHERE id=:id";
        $db = getConnection();
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("id", $user_id);
        $stmt2->execute();
        $getUserDetails = $stmt2->fetchObject();
//echo $getUserDetails->user_payment;exit;
        $data['Ack'] = '1';
        $data['payment'] = $getUserDetails->user_payment;

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {



        $data['Ack'] = 0;
        $data['msg'] = 'Updation Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function userpaymentforupload() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';



    $subscription_id = isset($body->sid) ? $body->sid : '';
    $product_id = isset($body->pid) ? $body->pid : '';
    $name = isset($body->name) ? $body->name : '';
    $email = isset($body->email) ? $body->email : '';
    $phone = isset($body->phone) ? $body->phone : '';
    $loyalty_redeem = isset($body->loyalty_redeem) ? $body->loyalty_redeem : 0;
    $paymentId = base64_encode($subscription_id . '_' . $product_id . '_' . $loyalty_redeem);



    $sqlloyalty = "SELECT * from webshop_user where id=:user_id";
    $stmtloyalty = $db->prepare($sqlloyalty);
    $stmtloyalty->bindParam("user_id", $user_id);
    $stmtloyalty->execute();
    $checkloyalty = $stmtloyalty->fetchObject();







    $sql = "SELECT * from webshop_subscription where id =:subscription_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("subscription_id", $subscription_id);
    $stmt->execute();
    $getSubscriptionValue = $stmt->fetchObject();

    if ($loyalty_redeem != 0) {
        $subscriptionprice = ($getSubscriptionValue->price - $loyalty_redeem);
    } else {
        $subscriptionprice = $getSubscriptionValue->price;
    }
    
//payment gateway

/*    $url = "https://test.myfatoorah.com/pg/PayGatewayService.asmx";

    $user = "testapi@myfatoorah.com"; // Will Be Provided by Myfatoorah
    $password = "E55D0"; // Will Be Provided by Myfatoorah
    $post_string = '<?xml version="1.0" encoding="windows-1256"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
<soap12:Body>
<PaymentRequest xmlns="http://tempuri.org/">
<req>
<CustomerDC>
<Name>' . $name . '</Name>
<Email>' . $email . '</Email>
<Mobile>' . $phone . '</Mobile>
</CustomerDC>
<MerchantDC>
<merchant_code>999999</merchant_code>
<merchant_username>testapi@myfatoorah.com</merchant_username>
<merchant_password>E55D0</merchant_password>
<merchant_ReferenceID>201454542102</merchant_ReferenceID>
<ReturnURL>' . SITE_URL . '#/successUserpayment/' . $paymentId . '/</ReturnURL>
<merchant_error_url>' . SITE_URL . '#/cancel</merchant_error_url>
</MerchantDC>
<lstProductDC>
<ProductDC>
<product_name>Product Upload</product_name>
<unitPrice>' . $subscriptionprice . '</unitPrice>
<qty>1</qty>
</ProductDC>
</lstProductDC>
</req>
</PaymentRequest>
</soap12:Body>
</soap12:Envelope>';
    $soap_do = curl_init();
    curl_setopt($soap_do, CURLOPT_URL, $url);
    curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($soap_do, CURLOPT_POST, true);
    curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length:
' . strlen($post_string)));
    curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password); //User Name, Password To be provided by Myfatoorah
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array(
        'Content-type: text/xml'
    ));
    $result = curl_exec($soap_do);
    $err = curl_error($soap_do);
//curl_close($soap_do);
//print_r($result);exit;   
    $file_contents = htmlspecialchars(curl_exec($soap_do));
    curl_close($soap_do);
    $doc = new DOMDocument();
    $doc->loadXML(html_entity_decode($file_contents));
//echo $doc;exit;
    $ResponseCode = $doc->getElementsByTagName("ResponseCode");
    $ResponseCode = $ResponseCode->item(0)->nodeValue;
//echo $ResponseCode;exit;
    $ResponseMessage = $doc->getElementsByTagName("ResponseMessage");
    $ResponseMessage = $ResponseMessage->item(0)->nodeValue;
//echo $ResponseMessage;exit;
    if ($ResponseCode == 0) {
        $paymentUrl = $doc->getElementsByTagName("paymentURL");
        $paymentUrl = $paymentUrl->item(0)->nodeValue;
//echo $paymentUrl;exit;

        /* $OrderID = $doc->getElementsByTagName("OrderID");
          $OrderID = $OrderID->item(0)->nodeValue;
          $Paymode = $doc->getElementsByTagName("Paymode");
          $Paymode = $Paymode->item(0)->nodeValue;
          $PayTxnID = $doc->getElementsByTagName("PayTxnID");
          $PayTxnID = $PayTxnID->item(0)->nodeValue;
         */
 /*   }*/
//end

$paymentUrl= SITE_URL . '#/successUserpayment/' . $paymentId.'/123';
    if ($loyalty_redeem > $checkloyalty->total_loyalty) {

        $data['Ack'] = 2;
    }else if($subscriptionprice == 0){
        
        $data['url'] = SITE_URL . '#/successUserpayment/' . $paymentId.'/123';
        $data['Ack'] = 1;
        
    } else {

        $data['url'] = $paymentUrl;
        $data['Ack'] = 1;
    }
    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}

function adduserpayment() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $encodeid = base64_decode($body->return_id);
    $user_id = isset($body->user_id) ? $body->user_id : '';


    $array_id = explode('_', $encodeid);


    $subscription_id = isset($array_id[0]) ? $array_id[0] : '';
    $product_id = isset($array_id[1]) ? $array_id[1] : '';
    $loyalty_point = isset($array_id[2]) ? $array_id[2] : 0;

//$name = isset($body->name) ? $body->name : '';
//$email = isset($body->email) ? $body->email : '';
//$phone = isset($body->phone) ? $body->phone : '';
//payment gateway
//end



    $sql3 = "SELECT * from webshop_subscription where id =:subscription_id";
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam("subscription_id", $subscription_id);
    $stmt3->execute();
    $getSubscriptionDetails = $stmt3->fetchObject();



    $sql4 = "INSERT INTO  webshop_subscribers (user_id,subscription_id,price,subscription_date,expiry_date,transaction_id) VALUES (:user_id,:subscription_id,:price,:subscription_date,:expiry_date,:transaction_id)";


    $days = $getSubscriptionDetails->duration;
    $date = date('Y-m-d');
    $cdate = date_create($date);
    date_add($cdate, date_interval_create_from_date_string("$days days"));
    $expiry_date = date_format($cdate, "Y-m-d");
    $transaction_id = "pay-12376";


    $stmt4 = $db->prepare($sql4);
    $stmt4->bindParam("user_id", $user_id);
    $stmt4->bindParam("subscription_id", $subscription_id);
    $stmt4->bindParam("price", $getSubscriptionDetails->price);
    $stmt4->bindParam("subscription_date", $date);
    $stmt4->bindParam("expiry_date", $expiry_date);
    $stmt4->bindParam("transaction_id", $transaction_id);
//$stmt4->bindParam("product_id", $product_id);
    $stmt4->execute();
    $lastID = $db->lastInsertId();

    $sqlproductupdate = "UPDATE webshop_products SET status=1, subscription_id=:subscription_id WHERE id=:pid";
    $stmtproduct = $db->prepare($sqlproductupdate);
    $stmtproduct->bindParam("subscription_id", $lastID);
    $stmtproduct->bindParam("pid", $product_id);
    $stmtproduct->execute();


    $sql6 = "SELECT * from webshop_user where id=:user_id ";
    $stmt6 = $db->prepare($sql6);
    $stmt6->bindParam("user_id", $user_id);
    $stmt6->execute();
    $is_user = $stmt6->fetchObject();




    if ($loyalty_point != 0) {
        $total_loyalty = ($is_user->total_loyalty - $loyalty_point);
    } else {
        $total_loyalty = 0;
    }

    $sql = "UPDATE  webshop_user SET total_loyalty = :loyalty WHERE id=:user_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("loyalty", $total_loyalty);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();

    if ($loyalty_point != 0) {
        $date = date('Y-m-d');
        $type = 1;
        $sql = "INSERT INTO  webshop_user_loyaliety (pay_amount, user_id,point,add_date,type) VALUES (:pay_amount, :user_id,:point,:date,:type)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("pay_amount", $getSubscriptionDetails->price);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("point", $loyalty_point);
        $stmt->bindParam("date", $date);
        $stmt->bindParam("type", $type);
        $stmt->execute();
    }






    $sql5 = "SELECT free_bid,free_bid_status from webshop_sitesettings where id = 1";
    $stmt5 = $db->prepare($sql5);
    $stmt5->execute();
    $getfree = $stmt5->fetchObject();

    $free_product = $getfree->free_bid;
    $free_status = $getfree->free_bid_status;

    if ($free_product != 0 && $free_status==1) {

        $msg = "Your Payment completed successfully. Your product is live now. Upload " . $free_product . "  product and get one product upload free.";
    } else {
        $msg = "Your Payment completed successfully. Your product is live now. Upload more product and get one product upload free.";
    }

    $data['subscription_id'] = $subscription_id;
    $data['Ack'] = 1;
    $data['msg'] = $msg;
    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}

function listuserSubscriptions() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $db = getConnection();

    $sql = "SELECT * from webshop_subscription where status = 1 and type='N' and subscription_for=1";


    try {


        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubscriptions = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubscriptions as $subscription) {

            $allsubscriptions[] = array(
                "id" => stripslashes($subscription->id),
                "name" => stripslashes($subscription->name),
                "price" => stripslashes($subscription->price),
                "duration" => stripslashes($subscription->duration),
            );
        }

        $data['subscriptionlist'] = $allsubscriptions;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function addreview() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $userid = isset($body->userid) ? $body->userid : '';
    $productid = isset($body->productid) ? $body->productid : '';
    $review = isset($body->review) ? $body->review : '';
    $rating = isset($body->rating) ? $body->rating : '';
    $recomend = isset($body->recomend) ? $body->recomend : '';

    $date = date('Y-m-d');

    $sql = "INSERT INTO  webshop_reviews (userid,product_id,review,rating,date,recomend) VALUES (:userid,:productid,:review,:rating,:date,:recomend)";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("userid", $userid);
    $stmt->bindParam("productid", $productid);
    $stmt->bindParam("review", $review);
    $stmt->bindParam("rating", $rating);
    $stmt->bindParam("date", $date);
    $stmt->bindParam("recomend", $recomend);
    $stmt->execute();

    $sqluser = "SELECT * FROM webshop_user WHERE id=$userid";

    $stmtttuser = $db->prepare($sqluser);
    $stmtttuser->execute();
    $getuser = $stmtttuser->fetchObject();

    $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

    $stmtttadmin = $db->prepare($sqladmin);
    $stmtttadmin->execute();
    $getadmin = $stmtttadmin->fetchObject();
    if ($getadmin->signup_notification == 1) {
        $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

        $is_read = '0';
        $last_id = '0';
        $from_id = '0';
        $type = '0';
        $message = $getuser->fname . ' ' . $getuser->lname . ' Reviewed a Product';
        //$type = '2';
        $stmttt = $db->prepare($sqlFriend);
        $stmttt->bindParam("from_id", $userid);
        $stmttt->bindParam("to_id", $from_id);
        $stmttt->bindParam("type", $type);
        $stmttt->bindParam("msg", $message);

        $stmttt->bindParam("last_id", $last_id);
        $stmttt->bindParam("is_read", $is_read);
        $stmttt->execute();
    }
    $sqlproduct = "SELECT * FROM webshop_products WHERE id=$productid";

    $stmtproduct = $db->prepare($sqlproduct);
    $stmtproduct->execute();
    $getproduct = $stmtproduct->fetchObject();

    $sqlowner = "SELECT * FROM webshop_user WHERE id=$getproduct->uploader_id";

    $stmtowner = $db->prepare($sqlowner);
    $stmtowner->execute();
    $getowner = $stmtowner->fetchObject();

    $sqlowneruser = "SELECT * FROM webshop_user WHERE id=$getproduct->uploader_id";

    $stmtowneruser = $db->prepare($sqlowneruser);
    $stmtowneruser->execute();
    $getowneruser = $stmtowneruser->fetchObject();

    if ($getowneruser->review_notify == 1) {
        $sqlFriendnotiuser = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id,date) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id,:date)";
        $date = date('Y-m-d H:i:s');
        $is_read = '0';
        $last_id = '0';
        $from_id = '0';
        $message = $getuser->fname . ' ' . $getuser->lname . ' Reviewed Your Product';
        //$type = '2';
        $stmtttnotiuser = $db->prepare($sqlFriendnotiuser);
        $stmtttnotiuser->bindParam("from_id", $userid);
        $stmtttnotiuser->bindParam("to_id", $getowneruser->id);
        $stmtttnotiuser->bindParam("type", $type);
        $stmtttnotiuser->bindParam("msg", $message);
        $stmtttnotiuser->bindParam("date", $date);
        $stmtttnotiuser->bindParam("last_id", $last_id);
        $stmtttnotiuser->bindParam("is_read", $is_read);
        $stmtttnotiuser->execute();
    }


    $data['Ack'] = '1';
    $data['Years'] = 'hello';

    $app->response->write(json_encode($data));
}

function auctionWinner() {


    $data = array();

    $app = \Slim\Slim::getInstance();
//$request = $app->request();
//$body2 = $app->request->getBody();
//$body = json_decode($body2);
//mail("spandan@natitsolved.com","GMT24 Auction","Your auction unsuccessfully end","mail@natitsolved.com");
//echo "spanda";exit;
    $db = getConnection();

    $sql = "SELECT * from webshop_products where type= 2 and approved=1 and auctioned=0";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $getAuctions = $stmt->fetchAll(PDO::FETCH_OBJ);
//print_r($getAuctions);exit;
    if (!empty($getAuctions)) {
        foreach ($getAuctions as $auction) {



            $tid = $auction->time_slot_id;


            $auction_id = $auction->id;
            $thresholdprice = $auction->thresholdprice;

            $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
            $current_datetime = date('Y-m-d H:i:s', $time_now);


            $sql1 = "SELECT * from webshop_auctiondates where id=$tid";
            $stmt1 = $db->prepare($sql1);
            $stmt1->execute();
            $getdatetimedetail = $stmt1->fetchObject();

// echo $current_datetime;exit;
//print_r($getdatetimedetail);exit;
            if ($current_datetime > $getdatetimedetail->end_time) {

                $sql2 = "UPDATE webshop_products SET `auctioned`=1 where id = $auction_id";
                $stmt2 = $db->prepare($sql2);
                $stmt2->execute();

//echo $auction_id;exit;
                $sql3 = "SELECT * FROM webshop_biddetails as wb inner join webshop_user as wu on wu.id=wb.userid WHERE wb.productid=$auction_id order by wb.bidprice desc limit 0,1";
                $stmt3 = $db->prepare($sql3);
                $stmt3->execute();
                $getbiddetail_withuser = $stmt3->fetchObject();
//print_r($getbiddetail_withuser);exit;
//echo $getbiddetail_withuser->id;exit;

                $sql4 = "SELECT * FROM webshop_biddetails as wb inner join webshop_user as wu on wu.id=wb.uploaderid WHERE wb.productid=$auction_id order by wb.bidprice desc limit 0,1";
                $stmt4 = $db->prepare($sql4);
                $stmt4->execute();
                $getbiddetail_withuploader = $stmt4->fetchObject();


                if ($getbiddetail_withuser->bidprice >= $thresholdprice) {




                    $actual_link = SITE_URL . "#/auctionpayment/" . base64_encode($auction_id);


                    send_smtpmail($getbiddetail_withuser->email, "GMT24 Auction", "You are the winner. Please pay and buy the product within 2 days. For buy <a href='" . $actual_link . "'> Click here</a>");
                    send_smtpmail($getbiddetail_withuploader->email, "GMT24 Auction", "Your auction successfully end");

//for notification

                    $is_read = '0';
                    $last_id = '0';
                    $from_id = '0';
                    $to_id = $getbiddetail_withuser->userid;
                    $notificationtype = "GMT24 Auction result";
                    $notification_msg = 'You won the auction. Please pay and buy the product within 2 days. For buy <a href="' . $actual_link . '"> Click here</a>';

                    $notificationsql = "INSERT INTO  webshop_notification(from_id,to_id, type, msg, date, is_read, last_id) VALUES (:from_id,:to_id, :type, :msg, :date, :is_read, :last_id)";
                    $stmt5 = $db->prepare($notificationsql);
                    $stmt5->bindParam("from_id", $from_id);
                    $stmt5->bindParam("to_id", $to_id);
                    $stmt5->bindParam("type", $notificationtype);
                    $stmt5->bindParam("msg", $notification_msg);
                    $stmt5->bindParam("date", $current_datetime);
                    $stmt5->bindParam("is_read", $is_read);
                    $stmt5->bindParam("last_id", $last_id);
                    $stmt5->execute();
//for notification end
//for winner table
                    $date = date('Y-m-d');
                    $cdate = date_create($date);
                    date_add($cdate, date_interval_create_from_date_string("2 days"));
                    $expiry_date = date_format($cdate, "Y-m-d");

                    $winsql = "INSERT INTO  webshop_auction_winner(user_id,product_id,date,expiry_date) VALUES (:user_id,:product_id, :date, :expiry_date)";
                    $stmt6 = $db->prepare($winsql);
                    $stmt6->bindParam("user_id", $to_id);
                    $stmt6->bindParam("product_id", $auction_id);
                    $stmt6->bindParam("date", $current_datetime);
                    $stmt6->bindParam("expiry_date", $expiry_date);
                    $stmt6->execute();
//for winner table end
                } else {

                    send_smtpmail($getbiddetail_withuploader->email, "GMT24 Auction", "Your auction unsuccessfully end");
                }
            }
        }
    }
}

function reviews() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $productid = isset($body->productid) ? $body->productid : '';

    $db = getConnection();

    $sql = "SELECT * from webshop_reviews where product_id =$productid group by id desc limit 2";


    try {


        $stmt = $db->prepare($sql);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (!empty($reviews)) {
            foreach ($reviews as $r) {

                $sql1 = "SELECT * from webshop_user where id =$r->userid";
                $stmt1 = $db->prepare($sql1);
                $stmt1->execute();
                $user_name = $stmt1->fetchAll(PDO::FETCH_OBJ);
                foreach ($user_name as $n) {
                    $name = $n->fname . " " . $n->lname;
                    if ($n->image != '') {
                        $profile_image = SITE_URL . 'upload/user_image/' . $n->image;
                    } else {
                        $profile_image = SITE_URL . 'webservice/no-user.png';
                    }
                }
                $curr_date = date_create(date('Y-m-d'));
                $review_date = date_create($r->date);
                $diff = date_diff($review_date, $curr_date);
                $date = $diff->format("%a");

                $reviewss[] = array(
                    "id" => stripslashes($r->id),
                    "review" => stripslashes($r->review),
                    "rating" => stripslashes($r->rating),
                    "date" => $date,
                    "recomend" => stripslashes($r->recomend),
                    "username" => $name,
                    "userimage" => $profile_image,
                );
            }
        } else {
            $reviewss = array();
        }
// exit;
        $data['reviews'] = $reviewss;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function send_smtpmail($MailTo, $subject, $TemplateMessage, $MailAttachment = null) {


    $mail = new PHPMailer(true);

    $IsMailType = 'SMTP';

    $MailFrom = 'mail@natitsolved.com';    //  Your email password

    $MailFromName = 'GMT24';
    $MailToName = '';

    $YourEamilPassword = "Natit#2019";   //Your email password from which email you send.
// If you use SMTP. Please configure the bellow settings.

    $SmtpHost = "smtp.gmail.com"; // sets the SMTP server
    $SmtpDebug = 0;                     // enables SMTP debug information (for testing)
    $SmtpAuthentication = true;                  // enable SMTP authentication
    $SmtpPort = 587;                    // set the SMTP port for the GMAIL server
    $SmtpUsername = $MailFrom; // SMTP account username
    $SmtpPassword = $YourEamilPassword;        // SMTP account password

    $mail->IsSMTP();  // telling the class to use SMTP
    $mail->SMTPDebug = $SmtpDebug;
    $mail->SMTPAuth = $SmtpAuthentication;     // enable SMTP authentication
    $mail->Port = $SmtpPort;             // set the SMTP port
    $mail->Host = $SmtpHost;           // SMTP server
    $mail->Username = $SmtpUsername; // SMTP account username
    $mail->Password = $SmtpPassword; // SMTP account password

    if ($MailFromName != '') {
        $mail->AddReplyTo($MailFrom, $MailFromName);
        $mail->From = $MailFrom;
        $mail->FromName = $MailFromName;
    } else {
        $mail->AddReplyTo($MailFrom);
        $mail->From = $MailFrom;
        $mail->FromName = $MailFrom;
    }

    if ($MailToName != '') {
        $mail->AddAddress($MailTo, $MailToName);
    } else {
        $mail->AddAddress($MailTo);
    }

    $mail->SMTPSecure = 'tls';
    $mail->Subject = $subject;

    $mail->MsgHTML($TemplateMessage);

    try {
        $mail->Send();
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }
}

function UserAuctionpayment() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $pid = base64_decode($body->product_id);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $loyalty_redeem = isset($body->loyalty_redeem) ? $body->loyalty_redeem : 0;
    $product_id = isset($pid) ? $pid : '';



    $sql1 = "SELECT * from webshop_auction_winner where user_id=:user_id and product_id =:product_id";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("user_id", $user_id);
    $stmt1->bindParam("product_id", $product_id);
    $stmt1->execute();
    $checkexpiry = $stmt1->fetchObject();


    $sqlloyalty = "SELECT * from webshop_user where id=:user_id";
    $stmtloyalty = $db->prepare($sqlloyalty);
    $stmtloyalty->bindParam("user_id", $user_id);
    $stmtloyalty->execute();
    $checkloyalty = $stmtloyalty->fetchObject();





    $cdate = date('Y-m-d');
    if ($cdate > $checkexpiry->expiry_date) {

        $data['Ack'] = 2;
    }if ($loyalty_redeem > $checkloyalty->total_loyalty) {

        $data['Ack'] = 3;
    } else {


        $paymentId = base64_encode($product_id . '_' . $loyalty_redeem);

        $name = isset($body->name) ? $body->name : '';
        $email = isset($body->email) ? $body->email : '';
        $phone = isset($body->phone) ? $body->phone : '';

        $sql = "SELECT * from webshop_biddetails where productid =:product_id and userid= '" . $user_id . "'order by id desc limit 0,1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
        $getProductValue = $stmt->fetchObject();


        $productprice = ($getProductValue->bidprice - $loyalty_redeem);
//payment gateway

        $url = "https://test.myfatoorah.com/pg/PayGatewayService.asmx";

        $user = "testapi@myfatoorah.com"; // Will Be Provided by Myfatoorah
        $password = "E55D0"; // Will Be Provided by Myfatoorah
        $post_string = '<?xml version="1.0" encoding="windows-1256"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
<soap12:Body>
<PaymentRequest xmlns="http://tempuri.org/">
<req>
<CustomerDC>
<Name>' . $name . '</Name>
<Email>' . $email . '</Email>
<Mobile>' . $phone . '</Mobile>
</CustomerDC>
<MerchantDC>
<merchant_code>999999</merchant_code>
<merchant_username>testapi@myfatoorah.com</merchant_username>
<merchant_password>E55D0</merchant_password>
<merchant_ReferenceID>201454542102</merchant_ReferenceID>
<ReturnURL>' . SITE_URL . '#/successAuctionpayment/' . $paymentId . '/</ReturnURL>
<merchant_error_url>' . SITE_URL . '#/cancelAuctionpayment</merchant_error_url>
</MerchantDC>
<lstProductDC>
<ProductDC>
<product_name>Auctioned Product</product_name>
<unitPrice>' . $productprice . '</unitPrice>
<qty>1</qty>
</ProductDC>
</lstProductDC>
</req>
</PaymentRequest>
</soap12:Body>
</soap12:Envelope>';
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $url);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length:
' . strlen($post_string)));
        curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password); //User Name, Password To be provided by Myfatoorah
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array(
            'Content-type: text/xml'
        ));
        $result = curl_exec($soap_do);
        $err = curl_error($soap_do);
//curl_close($soap_do);
//print_r($result);exit;   
        $file_contents = htmlspecialchars(curl_exec($soap_do));
        curl_close($soap_do);
        $doc = new DOMDocument();
        $doc->loadXML(html_entity_decode($file_contents));
//echo $doc;exit;
        $ResponseCode = $doc->getElementsByTagName("ResponseCode");
        $ResponseCode = $ResponseCode->item(0)->nodeValue;
//echo $ResponseCode;exit;
        $ResponseMessage = $doc->getElementsByTagName("ResponseMessage");
        $ResponseMessage = $ResponseMessage->item(0)->nodeValue;
//echo $ResponseMessage;exit;
        if ($ResponseCode == 0) {
            $paymentUrl = $doc->getElementsByTagName("paymentURL");
            $paymentUrl = $paymentUrl->item(0)->nodeValue;
//echo $paymentUrl;exit;

            /* $OrderID = $doc->getElementsByTagName("OrderID");
              $OrderID = $OrderID->item(0)->nodeValue;
              $Paymode = $doc->getElementsByTagName("Paymode");
              $Paymode = $Paymode->item(0)->nodeValue;
              $PayTxnID = $doc->getElementsByTagName("PayTxnID");
              $PayTxnID = $PayTxnID->item(0)->nodeValue;
             */
        }
//end
        if($productprice== 0){
            $data['url'] = SITE_URL . '#/successAuctionpayment/' . $paymentId .'/123';
            $data['Ack'] = 1;
        }else{
        $data['url'] = $paymentUrl;
        $data['Ack'] = 1;
        }
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function addwinnerpayment() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $encode_id = explode('_', base64_decode($body->product_id));
    $pid = $encode_id[0];
    $loyalty_point = $encode_id[1];
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $product_id = isset($pid) ? $pid : '';



//$name = isset($body->name) ? $body->name : '';
//$email = isset($body->email) ? $body->email : '';
//$phone = isset($body->phone) ? $body->phone : '';
//payment gateway
//end



    $sql = "UPDATE  webshop_auction_winner SET is_paid= 1 WHERE user_id=:user_id and product_id=:product_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam("product_id", $product_id);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();




    $user_type = 1;
    $sql3 = "SELECT * from webshop_user where id=:user_id and type=:type ";
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam("type", $user_type);
    $stmt3->bindParam("user_id", $user_id);
    $stmt3->execute();
    $is_user = $stmt3->fetchAll(PDO::FETCH_OBJ);


//print_r($is_user);exit;

    if (count($is_user) > 0) {




        $sql1 = "SELECT * from webshop_biddetails where userid=:user_id and productid=:product_id order by id DESC LIMIT 0,1";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("product_id", $product_id);
        $stmt1->bindParam("user_id", $user_id);
        $stmt1->execute();
        $biddetails = $stmt1->fetchAll(PDO::FETCH_OBJ);

        $bidprice = $biddetails[0]->bidprice;

        $sql2 = "SELECT * from webshop_loyalietypoint where from_price <= :bidprice AND to_price >= :bidprice";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("bidprice", $bidprice);
        $stmt2->execute();
        $biddetails = $stmt2->fetchAll(PDO::FETCH_OBJ);
//print_r($biddetails[0]->point);exit;

        if ($loyalty_point != 0) {
            $total_loyalty = (($is_user[0]->total_loyalty + $biddetails[0]->point) - $loyalty_point);
        } else {
            $total_loyalty = $is_user[0]->total_loyalty + $biddetails[0]->point;
        }
        if ($biddetails[0]->point) {
            $date = date('Y-m-d');
            $sql = "INSERT INTO  webshop_user_loyaliety (pay_amount, user_id,point,add_date) VALUES (:pay_amount, :user_id,:point,:date)";


            $stmt = $db->prepare($sql);
            $stmt->bindParam("pay_amount", $bidprice);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("point", $biddetails[0]->point);
            $stmt->bindParam("date", $date);

            $stmt->execute();
        }



        $sql = "UPDATE  webshop_user SET total_loyalty = :loyalty WHERE id=:user_id ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("loyalty", $total_loyalty);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();



        if ($loyalty_point != 0) {

            $sql = "INSERT INTO  webshop_user_loyaliety (pay_amount, user_id,point,add_date,type) VALUES (:pay_amount, :user_id,:point,:date,:type)";

            $type = 1;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("pay_amount", $bidprice);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("point", $loyalty_point);
            $stmt->bindParam("date", $date);
            $stmt->bindParam("type", $type);
            $stmt->execute();
        }
    }

    $data['Ack'] = 1;
    $data['msg'] = 'Your payment completed successfully.';
    $app->response->setStatus(200);

    $app->response->write(json_encode($data));
}

function todayauctionListSearch() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $brand = isset($body->brand) ? $body->brand : '';
    $brandListing = isset($body->brandList) ? $body->brandList : '';
    $sellerListing = isset($body->sellerList) ? $body->sellerList : '';
    $selected_value = isset($body->selected_value) ? $body->selected_value : '';
    $amount_min = isset($body->amount_min) ? $body->amount_min : '';
    $amount_max = isset($body->amount_max) ? $body->amount_max : '';

    $gender = isset($body->gender) ? $body->gender : '';
    $breslettype = isset($body->breslettype) ? $body->breslettype : '';
    $year = isset($body->year) ? $body->year : '';
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';
    $current_date = date('Y-m-d');
     $category = isset($body->category) ? $body->category : '';
     
//print_r($body);exit;

    $productIds = array();

    if ($selected_value == '4') {

        $new_sql = "SELECT * from webshop_reviews order by rating desc";
        $stmt2 = $db->prepare($new_sql);
        $stmt2->execute();
        $total_rows = $stmt2->rowCount();
        $getIds = $stmt2->fetchAll(PDO::FETCH_OBJ);


        if ($total_rows > 0) {

            foreach ($getIds as $product) {

                array_push($productIds, $product->product_id);
            }
        }

        $productIds = array_unique($productIds);

// print_r($productIds);
// exit;

        $productIds = implode(",", $productIds);


        $sql = "SELECT * from webshop_products where status = 1 and type='2' and auctioned ='0' and preferred_date = '" . $current_date . "' and uploader_id !='" . $user_id . "' and id IN(" . $productIds . ")";
    } else {


        $sql = "SELECT * from  webshop_products where status=1 and type='2' and auctioned ='0' and preferred_date = '" . $current_date . "'  and uploader_id !='" . $user_id . "'";
    }

    if ($amount_min != '' && $amount_max != '') {

        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min == '' && $amount_max != '') {
        $amount_min = 0.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min != '' && $amount_max == '') {
        $amount_max = 10000.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    }

    if ($brandListing != '') {

        $sql .= " AND `brands` IN (" . $brandListing . ")";
    }
    if ($sellerListing != '') {

        $sql .= " AND `uploader_id` IN (" . $sellerListing . ")";
    }


//spandan

    if ($category != '') {

       // $sql .= " AND `cat_id` = '" . $category . "'";
         $sql .= " AND `cat_id` IN (" . $category . ")";
    }
    if ($gender != '') {

        $sql .= " AND `gender`='" . $gender . "' ";
    }


    if ($breslettype != '') {

        $sql .= " AND `breslet_type` = '" . $breslettype . "'";
    }
    if ($year != '') {

        $sql .= " AND model_year = '" . $year . "'";
    }

//spandan end

    if ($selected_value == '1') {

        $sql .= " ORDER BY price ASC";
    }
    if ($selected_value == '2') {

        $sql .= " ORDER BY price DESC";
    }
    if ($selected_value == '3') {

        $sql .= " ORDER BY add_date DESC";
    }



//echo($sql);
// exit;

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);


        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {

                if ($product->image != '') {
                    $image = SITE_URL . 'upload/product_image/' . $product->image;
                } else {
                    $image = SITE_URL . 'webservice/not-available.jpg';
                }


                $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam("id", $product->cat_id);
                $stmt2->execute();
                $getcategory = $stmt2->fetchObject();
                if (!empty($getcategory)) {
                    $categoryname = $getcategory->name;
                }



                $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam("id", $product->subcat_id);
                $stmt3->execute();
                $getsubcategory = $stmt3->fetchObject();
//                if (!empty($getsubcategory)) {
//                    $subcategoryname = $getsubcategory->name;
//                }
//Seller Information

                $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("id", $product->uploader_id);
                $stmt1->execute();
                $getUserdetails = $stmt1->fetchObject();

                if (!empty($getUserdetails)) {
                    $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                    $seller_address = $getUserdetails->address;
                    $seller_phone = $getUserdetails->phone;
                    $email = $getUserdetails->email;

                    if ($getUserdetails->image != '') {
                        $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                    } else {
                        $profile_image = SITE_URL . 'webservice/no-user.png';
                    }
                } else {
                    $profile_image = '';
                }

                $data['productList'][] = array(
                    "id" => stripslashes($product->id),
                    "image" => stripslashes($image),
                    "price" => stripslashes($product->price),
                    "description" => strip_tags(stripslashes($product->description)),
                    "category_name" => $categoryname,
                    //"subcategory_name" => $subcategoryname,
// "preferred_date" => $product->preferred_date,
                    "seller_id" => stripslashes($product->uploader_id),
                    "seller_image" => $profile_image,
                    "seller_name" => stripslashes($seller_name),
                    "seller_address" => stripslashes($seller_address),
                    "seller_phone" => stripslashes($seller_phone),
                    "productname" => stripslashes($product->name)
                );
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['productList'] = array();
            $data['Ack'] = '0';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function interestinproduct() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_interested WHERE userid=:user_id and interested = '1' order by id desc";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

//print_r($getAllProducts);exit;

    if (!empty($getAllProducts)) {
        foreach ($getAllProducts as $product) {

            $sql1 = "SELECT * FROM webshop_products WHERE id=:id and auctioned=0";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("id", $product->productid);
            $stmt1->execute();
            $getProductdetails = $stmt1->fetchObject();



            if ($getProductdetails->image != '') {
                $image = SITE_URL . 'upload/product_image/' . $getProductdetails->image;
            } else {
                $image = SITE_URL . 'webservice/not-available.jpg';
            }




            $data['productList'][] = array(
                "id" => stripslashes($product->id),
                "image" => stripslashes($image),
                "price" => stripslashes($getProductdetails->price),
                "description" => strip_tags(stripslashes(substr($getProductdetails->description, 0, 50))),
                "seller_id" => stripslashes($product->seller_id),
                "product_id" => stripslashes($getProductdetails->id),
            );
        }


        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['productList'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function deleteInterest() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $interest_id = isset($body->interest_id) ? $body->interest_id : '';

    $db = getConnection();

    $sql = "DELETE from webshop_interested WHERE id=:interest_id and userid=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("interest_id", $interest_id);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();


        $data['Ack'] = '1';
        $data['msg'] = 'Product Removed';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {

        $data['product_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Deletion Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function interestedproduct() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_interested WHERE seller_id=:user_id and interested = '1' order by id desc";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

//print_r($getAllProducts);exit;

    if (!empty($getAllProducts)) {
        foreach ($getAllProducts as $product) {

            $sql1 = "SELECT * FROM webshop_products WHERE id=:id and auctioned=0";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("id", $product->productid);
            $stmt1->execute();
            $getProductdetails = $stmt1->fetchObject();



            if ($getProductdetails->image != '') {
                $image = SITE_URL . 'upload/product_image/' . $getProductdetails->image;
            } else {
                $image = SITE_URL . 'webservice/not-available.jpg';
            }




            $data['productList'][] = array(
                "id" => stripslashes($product->id),
                "image" => stripslashes($image),
                "price" => stripslashes($getProductdetails->price),
                "description" => strip_tags(stripslashes(substr($getProductdetails->description, 0, 50))),
                "seller_id" => stripslashes($product->seller_id),
                "product_id" => stripslashes($getProductdetails->id),
            );
        }


        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['productList'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function auctionuploapayment() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();



    $user_id = isset($body->user_id) ? $body->user_id : '';
    $product_id = isset($body->product_id) ? $body->product_id : '';
    $loyalty_redeem = isset($body->loyalty_redeem) ? $body->loyalty_redeem : 0;

    $paymentId = $product_id . '_' . $loyalty_redeem;


    $name = isset($body->name) ? $body->name : '';
    $email = isset($body->email) ? $body->email : '';
    $phone = isset($body->phone) ? $body->phone : '';


    $sql = "SELECT * from webshop_products where id =:product_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("product_id", $product_id);
    $stmt->execute();
    $getProductValue = $stmt->fetchObject();

    if ($loyalty_redeem != 0) {
        $productprice = ($getProductValue->auction_fee - $loyalty_redeem);
    } else {
        $productprice = $getProductValue->auction_fee;
    }


    $sqlloyalty = "SELECT * from webshop_user where id=:user_id";
    $stmtloyalty = $db->prepare($sqlloyalty);
    $stmtloyalty->bindParam("user_id", $user_id);
    $stmtloyalty->execute();
    $checkloyalty = $stmtloyalty->fetchObject();



//payment gateway

    $url = "https://test.myfatoorah.com/pg/PayGatewayService.asmx";

    $user = "testapi@myfatoorah.com"; // Will Be Provided by Myfatoorah
    $password = "E55D0"; // Will Be Provided by Myfatoorah
    $post_string = '<?xml version="1.0" encoding="windows-1256"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
<soap12:Body>
<PaymentRequest xmlns="http://tempuri.org/">
<req>
<CustomerDC>
<Name>' . $name . '</Name>
<Email>' . $email . '</Email>
<Mobile>' . $phone . '</Mobile>
</CustomerDC>
<MerchantDC>
<merchant_code>999999</merchant_code>
<merchant_username>testapi@myfatoorah.com</merchant_username>
<merchant_password>E55D0</merchant_password>
<merchant_ReferenceID>201454542102</merchant_ReferenceID>
<ReturnURL>' . SITE_URL . '#/successAuctionuploadpayment/' . $paymentId . '/</ReturnURL>
<merchant_error_url>' . SITE_URL . '#/cancelAuctionuploadpayment</merchant_error_url>
</MerchantDC>
<lstProductDC>
<ProductDC>
<product_name>Auction Upload</product_name>
<unitPrice>' . $productprice . '</unitPrice>
<qty>1</qty>
</ProductDC>
</lstProductDC>
</req>
</PaymentRequest>
</soap12:Body>
</soap12:Envelope>';
    $soap_do = curl_init();
    curl_setopt($soap_do, CURLOPT_URL, $url);
    curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($soap_do, CURLOPT_POST, true);
    curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length:
' . strlen($post_string)));
    curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password); //User Name, Password To be provided by Myfatoorah
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array(
        'Content-type: text/xml'
    ));
    $result = curl_exec($soap_do);
    $err = curl_error($soap_do);
//curl_close($soap_do);
//print_r($result);exit;   
    $file_contents = htmlspecialchars(curl_exec($soap_do));
    curl_close($soap_do);
    $doc = new DOMDocument();
    $doc->loadXML(html_entity_decode($file_contents));
//echo $doc;exit;
    $ResponseCode = $doc->getElementsByTagName("ResponseCode");
    $ResponseCode = $ResponseCode->item(0)->nodeValue;
//echo $ResponseCode;exit;
    $ResponseMessage = $doc->getElementsByTagName("ResponseMessage");
    $ResponseMessage = $ResponseMessage->item(0)->nodeValue;
//echo $ResponseMessage;exit;
    if ($ResponseCode == 0) {
        $paymentUrl = $doc->getElementsByTagName("paymentURL");
        $paymentUrl = $paymentUrl->item(0)->nodeValue;
//echo $paymentUrl;exit;

        /* $OrderID = $doc->getElementsByTagName("OrderID");
          $OrderID = $OrderID->item(0)->nodeValue;
          $Paymode = $doc->getElementsByTagName("Paymode");
          $Paymode = $Paymode->item(0)->nodeValue;
          $PayTxnID = $doc->getElementsByTagName("PayTxnID");
          $PayTxnID = $PayTxnID->item(0)->nodeValue;
         */
    }
//end
    if ($loyalty_redeem > $checkloyalty->total_loyalty) {

        $data['Ack'] = 2;
        
    }else if($productprice==0){
        
        $data['url'] = SITE_URL . '#/successAuctionuploadpayment/' . $paymentId . '/123';
        $data['Ack'] = 1;
        
    } else {
        $data['url'] = $paymentUrl;
        $data['Ack'] = 1;
    }
    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}

function addlike() {

    $data = array();
    $getuserdetails = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();


    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $product_id = isset($body->product_id) ? $body->product_id : '';
    $seller_id = isset($body->seller_id) ? $body->seller_id : '';

//$pro_id = $body->pro_id;
    $status = 1;
    $date = date('Y-m-d');
    $db = getConnection();


    $sql = "SELECT * FROM  webshop_like WHERE product_id=:product_id AND user_id=:user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("product_id", $product_id);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $contactdetails = $stmt->fetchObject();
    $count = $stmt->rowCount();

    if ($count == 0) {

//    echo $paramValue = $app->request->post('fname');
        $sql = "INSERT INTO  webshop_like (product_id, user_id,seller_id, status, date) VALUES (:product_id, :user_id,:seller_id, :status, :date)";



        try {


//$resturant_id = $resturantDetails->id;

            $stmt = $db->prepare($sql);
            $stmt->bindParam("product_id", $product_id);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("seller_id", $seller_id);
            $stmt->bindParam("status", $status);
            $stmt->bindParam("date", $date);

            $stmt->execute();
//   

            $sql2 = "SELECT * FROM  webshop_user WHERE id='" . $user_id . "'";
            $stmtcat = $db->prepare($sql2);
            $stmtcat->execute();
            $getUserdetails = $stmtcat->fetchObject();

            $full_name = $getUserdetails->fname . " " . $getUserdetails->lname;

// $stmt2->execute();

            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Added Successfully...';





            $app->response->setStatus(200);

            $db = null;
//echo json_encode($user);
        } catch (PDOException $e) {
//error_log($e->getMessage(), 3, '/var/tmp/php.log');
            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = $e->getMessage();
//echo '{"error":{"text":'. $e->getMessage() .'}}';
            $app->response->setStatus(401);
        }
    } else {
        $sqldel = "DELETE FROM webshop_like WHERE user_id=$user_id";
        $stmtdel = $db->prepare($sqldel);
        $stmtdel->execute();
    }



    $app->response->write(json_encode($data));
}

function sociallinks() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_social WHERE status=1";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $getAlllinks = $stmt->fetchAll(PDO::FETCH_OBJ);

//print_r($getAllProducts);exit;

    if (!empty($getAlllinks)) {
        foreach ($getAlllinks as $links) {

            $data['sociallinks'][] = array(
                "id" => stripslashes($links->id),
                "link" => stripslashes($links->link),
                "class" => stripslashes($links->class),
            );
        }

        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['sociallinks'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function checkpassword() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->userid) ? $body->userid : '';
    $password = isset($body->password) ? $body->password : '';
    $pass = md5($password);

    $sql = "SELECT * from  webshop_user WHERE password='$pass' AND id='$user_id'";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount();



    if ($count > 0) {
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {

        $data['Ack'] = '2';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function myLoyalty() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $db = getConnection();
    $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";

    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("id", $user_id);
    $stmt1->execute();
    $getUserdetails = $stmt1->fetchObject();

    if (!empty($getUserdetails)) {

        $total_loyalty = $getUserdetails->total_loyalty;
    } else {
        $total_loyalty = 0;
    }


    $sql = "SELECT * from  webshop_user_loyaliety WHERE user_id=:user_id  order by id desc";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getAllLoyalty = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($getAllLoyalty)) {
        foreach ($getAllLoyalty as $loyalty) {

            $data['loyaltyList'][] = array(
                "id" => stripslashes($loyalty->id),
                "pay_amount" => stripslashes($loyalty->pay_amount),
                "point" => stripslashes($loyalty->point),
                "add_date" => stripslashes($loyalty->add_date),
                "type" => $loyalty->type,
                "used_date" => stripslashes($loyalty->used_date),
            );
        }


        $data['Ack'] = '1';
        $data['total_loyalty'] = $total_loyalty;
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['loyaltyList'] = array();
        $data['total_loyalty'] = $total_loyalty;
        $data['Ack'] = '2';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function checkauctionvalidity() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $product_id = isset($body->product_id) ? $body->product_id : '';
     $product_id = urldecode ( base64_decode($product_id) ) ;
    $user_id = isset($body->userid) ? $body->userid : '';
    $db = getConnection();
    $sql1 = "SELECT * FROM webshop_products WHERE id=:product_id AND auctioned=0";

    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("product_id", $product_id);
    $stmt1->execute();
    $count = $stmt1->rowCount();
//exit;



    if ($count > 0) {
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {

        $sql = "SELECT * from  webshop_auction_winner WHERE user_id=:user_id AND product_id=:product_id  order by id desc";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
//$count = $stmt->rowCount();
        $getauctionwinner = $stmt->fetchAll(PDO::FETCH_OBJ);
       // print_r($getauctionwinner);exit;
        if (!empty($getauctionwinner)) {
            foreach ($getauctionwinner as $winner) {

                $data['auctionwinner'] = stripslashes($winner->user_id);


                /* $sqluser = "SELECT * from webshop_user WHERE id=:user_id";
                  $stmtuser = $db->prepare($sqluser);
                  $stmtuser->bindParam("user_id", $winner->user_id);

                  $stmtuser->execute();
                  $getuser = $stmtuser->fetchAll(PDO::FETCH_OBJ);
                  foreach ($getuser as $us) {

                  $auctionvaliditydetails = array(
                  'name'=>$us-
                  );
                  } */
            }


            $data['Ack'] = '2';

            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['auctionwinner'] = '';
            $data['Ack'] = '3';
            $app->response->setStatus(200);
        }
    }




    $app->response->write(json_encode($data));
}

function listcountry() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_countries where 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getBrand as $brand) {

            $allbrand[] = array(
                "id" => stripslashes($brand->id),
                "name" => stripslashes($brand->name)
            );
        }

        $data['countrylist'] = $allbrand;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function liststate() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $c_id = isset($body->c_id) ? $body->c_id : '';

    try {

        $sql = "SELECT * from webshop_states where country_id = '" . $c_id . "' ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubcategory = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubcategory as $subcategory) {


            $allsubcategory[] = array(
                "id" => stripslashes($subcategory->id),
                "name" => stripslashes($subcategory->name)
            );
        }
        if (!empty($allsubcategory)) {
            $data['statelist'] = $allsubcategory;
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {

            $data['statelist'] = '';
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listcity() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $s_id = isset($body->s_id) ? $body->s_id : '';

    try {

        $sql = "SELECT * from webshop_cities where state_id = '" . $s_id . "' ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubcategory = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubcategory as $subcategory) {


            $allsubcategory[] = array(
                "id" => stripslashes($subcategory->id),
                "name" => stripslashes($subcategory->name)
            );
        }
        if (!empty($allsubcategory)) {
            $data['citylist'] = $allsubcategory;
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {

            $data['citylist'] = '';
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function myproductbylocation() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $db = getConnection();
    $sqlu = "SELECT * FROM webshop_user WHERE id=:id ";

    $stmtu = $db->prepare($sqlu);
    $stmtu->bindParam("id", $user_id);
    $stmtu->execute();
    $getUserdetails = $stmtu->fetchObject();

    $prefer_country_id = $getUserdetails->country_preference;



    $sql = "SELECT * from  webshop_products WHERE uploader_id!=:user_id and type = '1' and status= '1' and is_discard='0' and country=:country order by id desc";

    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->bindParam("country", $prefer_country_id);
    $stmt->execute();
    $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

//print_r($getAllProducts);exit;

    if (!empty($getAllProducts)) {
        foreach ($getAllProducts as $product) {


            if ($product->image != '') {
                $image = SITE_URL . 'upload/product_image/' . $product->image;
            } else {
                $image = SITE_URL . 'webservice/not-available.jpg';
            }


            $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam("id", $product->cat_id);
            $stmt2->execute();
            $getcategory = $stmt2->fetchObject();
            if (!empty($getcategory)) {
                $categoryname = $getcategory->name;
            }



            $sql3 = "SELECT * FROM  webshop_subcategory WHERE id=:id ";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam("id", $product->subcat_id);
            $stmt3->execute();
            $getsubcategory = $stmt3->fetchObject();
//            if (!empty($getsubcategory)) {
//                $subcategoryname = $getsubcategory->name;
//            }
//Seller Information

            $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("id", $product->uploader_id);
            $stmt1->execute();
            $getUserdetails = $stmt1->fetchObject();

            if (!empty($getUserdetails)) {
                $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                $seller_address = $getUserdetails->address;
                $seller_phone = $getUserdetails->phone;
                $email = $getUserdetails->email;

                if ($getUserdetails->image != '') {
                    $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                } else {
                    $profile_image = SITE_URL . 'webservice/no-user.png';
                }
            } else {
                $profile_image = '';
            }

            $data['productList'][] = array(
                "id" => stripslashes($product->id),
                "image" => stripslashes($image),
                "price" => stripslashes($product->price),
                "description" => strip_tags(stripslashes(substr($product->description, 0, 50))),
                "category_name" => $categoryname,
                //"subcategory_name" => $subcategoryname,
                "seller_id" => stripslashes($product->uploader_id),
                "seller_image" => $profile_image,
                "seller_name" => stripslashes($seller_name),
                "seller_address" => stripslashes($seller_address),
                "seller_phone" => stripslashes($seller_phone),
                "productname" => '',
                "product_status" => stripslashes($product->product_status),
                "approved" => $product->approved,
                "live_status" => $product->status
            );
        }


        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['productList'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function checkauctionvaliditybeforeaddbid() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $product_id = isset($body->product_id) ? $body->product_id : '';
    $user_id = isset($body->userid) ? $body->userid : '';
    $db = getConnection();
    $sql1 = "SELECT * FROM webshop_products WHERE id=:product_id AND auctioned=0";

    $stmt1 = $db->prepare($sql1);
    $stmt1->bindParam("product_id", $product_id);
    $stmt1->execute();
    $count = $stmt1->rowCount();

    /* if ($count > 0) {
      $data['Ack'] = '1';
      $app->response->setStatus(200);
      } else {
      $data = array();
      $data['auctionwinner'] = '';
      $data['Ack'] = '2';
      $app->response->setStatus(200);
      } */


    if ($count > 0) {
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {

        $sql = "SELECT * from  webshop_auction_winner WHERE user_id=:user_id AND product_id=:product_id  order by id desc";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
//$count = $stmt->rowCount();
        $getauctionwinner = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($getauctionwinner)) {
            foreach ($getauctionwinner as $winner) {

                $data['auctionwinner'] = stripslashes($winner->user_id);
            }


            $data['Ack'] = '2';

            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['auctionwinner'] = '';
            $data['Ack'] = '3';
            $app->response->setStatus(200);
        }
    }




    $app->response->write(json_encode($data));
}

function getfullAdminMessages() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $to_id = isset($body->to_id) ? $body->to_id : '';
//$product_id = isset($body->product_id) ? $body->product_id : '';
    $from_id = isset($body->from_id) ? $body->from_id : '';
    $allmeaage = '';
// exit;
    try {

        $sql = "SELECT * from webshop_message WHERE from_id=$from_id AND to_id=$to_id OR from_id=$to_id AND to_id=$from_id";

        $stmt = $db->prepare($sql);
//$stmt->bindParam("to_id", $from_id);
//$stmt->bindParam("from_id", $to_id);
//$stmt->bindParam("product_id", $product_id);

        $stmt->execute();
        $getStatus = $stmt->fetchAll(PDO::FETCH_OBJ);
// print_r($getStatus);
// exit;
        $categoryname = '';
        $product_name = '';
        $profile_image = '';
        foreach ($getStatus as $status) {




            $profile_image = SITE_URL . 'upload/user_image/nouser.jpg';






            $allmeaage[] = array(
                'message' => stripslashes($status->message),
                'to_id' => stripslashes($status->to_id),
                'from_id' => stripslashes($status->from_id),
                'id' => stripslashes($status->id),
                'image' => $profile_image
            );
//$product_image = $image;
        }

        $data['fillmessage'] = $allmeaage;
        $data['product_image'] = $profile_image;
        $data['product_name'] = '';
        $data['Ack'] = '1';
//       print_r($data);
//        exit;
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function adminaddmessage() {
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
//echo 'a';
//print_r($body);
    $message = isset($body->message) ? $body->message : '';


    $to_id = isset($body->to_id) ? $body->to_id : '';
    $product_id = 0;
    $from_id = isset($body->from_id) ? $body->from_id : '';
    $add_date = date('Y-m-d');
    $is_read = '0';
    $last_id = '0';
    $date = date('Y-m-d h:i:s');
//exit;
    $db = getConnection();

    $sql1 = "INSERT INTO  webshop_message (message,to_id,product_id,from_id,is_read,add_date) VALUES (:message,:to_id,:product_id,:from_id,:is_read,:add_date)";
    $sqlnoti = "INSERT INTO  webshop_notification (msg,to_id,from_id,is_read,last_id,date) VALUES (:msg,:to_id,:from_id,:is_read,:last_id,:date)";


    try {
        $messagefornoti = 'You have a new message from Admin';
        $type = 'Customer Message';
        $stmtnoti = $db->prepare($sqlnoti);
        $stmtnoti->bindParam("msg", $messagefornoti);
        $stmtnoti->bindParam("to_id", $to_id);
        $stmtnoti->bindParam("from_id", $from_id);
        $stmtnoti->bindParam("is_read", $is_read);
        $stmtnoti->bindParam("date", $date);
        $stmtnoti->bindParam("last_id", $last_id);
        $stmtnoti->execute();

        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("message", $message);
        $stmt1->bindParam("to_id", $to_id);
        $stmt1->bindParam("product_id", $product_id);
        $stmt1->bindParam("from_id", $from_id);
        $stmt1->bindParam("is_read", $is_read);
        $stmt1->bindParam("add_date", $add_date);



        $stmt1->execute();
        $data['Ack'] = '1';
    } catch (PDOException $e) {

        $data['user_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getallproductimages() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $s_id = isset($body->product_id) ? $body->product_id : '';

    try {

        $sql = "SELECT * from webshop_product_image where product_id = '" . $s_id . "' ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubcategory = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubcategory as $subcategory) {


            if ($subcategory->image != '') {
                $image = SITE_URL . 'upload/product_image/' . $subcategory->image;
            } else {
                $image = SITE_URL . 'webservice/not-available.jpg';
            }

            $images[] = array(
                "custom" => stripslashes($image),
                "thumbnail" => stripslashes($image),
            );
        }
        if (!empty($images)) {
            $data['imagespath'] = $images;
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {

            $data['imagespath'] = '';
            $data['Ack'] = '1';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function updateProfile_app() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $fname = isset($body->fname) ? $body->fname : '';
    $lname = isset($body->lname) ? $body->lname : '';
    $address = isset($body->address) ? $body->address : '';
    $phone = isset($body->phone) ? $body->phone : '';
    $email = isset($body->email) ? $body->email : '';
    $business_type = isset($body->business_type) ? $body->business_type : '';
    $gender = isset($body->gender) ? $body->gender : '';
    $secret_key = isset($body->secret_key) ? $body->secret_key : '';
    $publish_key = isset($body->publish_key) ? $body->publish_key : '';
    $bankname = isset($body->bankname) ? $body->bankname : '';
    $ibanno = isset($body->ibanno) ? $body->ibanno : '';
    $language_preference = isset($body->language_preference) ? $body->language_preference : '';
    $country = isset($body->country) ? $body->country : '';
    $state = isset($body->state) ? $body->state : '';
    $city = isset($body->city) ? $body->city : '';
    $country_preference = isset($body->country_preference) ? $body->country_preference : '';

    $currency_preference = isset($body->currency_preference) ? $body->currency_preference : '';




    $latlang = '';
    $val = '';
    $value = '';
    $lat = '';
    $lang = '';




    $date = date('Y-m-d');


    $sql = "UPDATE webshop_user set fname=:fname,lname=:lname ,secret_key=:secret_key,publish_key=:publish_key,email=:email,address=:address,phone=:phone,gender=:gender,business_type=:business_type,my_latitude=:lat,my_longitude=:lang,bankname=:bankname,ibanno=:ibanno,language_preference=:language_preference,country=:country,state=:state,city=:city,country_preference=:country_preference,currency_preference=:currency_preference WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fname", $fname);
        $stmt->bindParam("lname", $lname);
        $stmt->bindParam("phone", $phone);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("business_type", $business_type);
        $stmt->bindParam("address", $address);
        $stmt->bindParam("gender", $gender);
        $stmt->bindParam("publish_key", $publish_key);
        $stmt->bindParam("secret_key", $secret_key);
        $stmt->bindParam("lat", $lat);
        $stmt->bindParam("lang", $lang);

        $stmt->bindParam("bankname", $bankname);
        $stmt->bindParam("ibanno", $ibanno);
        $stmt->bindParam("language_preference", $language_preference);
        $stmt->bindParam("country", $country);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("city", $city);
        $stmt->bindParam("country_preference", $country_preference);
        $stmt->bindParam("currency_preference", $currency_preference);
        $stmt->bindParam("id", $user_id);

        $stmt->execute();



        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Profile Updated Successfully...';


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Updation Error !!!';
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}



function addProductNew_app() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';
//echo $user_id;exit;
    $category = isset($body->cat_id) ? $body->cat_id : '';

    $name = isset($body->name) ? $body->name : '';
    $description = isset($body->description) ? $body->description : '';
    $currency = isset($body->currency) ? $body->currency : '';
    $price = isset($body->price) ? $body->price : '';
    $quantity = isset($body->quantity) ? $body->quantity : '';
    $brand = isset($body->brand) ? $body->brand : '';
    $type = isset($body->type) ? $body->type : '';
    $preferred_date2 = isset($body->preferred_date) ? $body->preferred_date : '';
    $movement = isset($body->movement) ? $body->movement : '';
    $gender = isset($body->gender) ? $body->gender : '';
    $reference = isset($body->reference) ? $body->reference : '';
    $date_of_purchase2 = isset($body->date_of_purchase) ? $body->date_of_purchase : '';
    $status_watch = isset($body->status) ? $body->status : '';
    $owner_number = isset($body->owner_number) ? $body->owner_number : '';
    $country = isset($body->country) ? $body->country : '';
    $size = isset($body->size) ? $body->size : '';
    $location = isset($body->location) ? $body->location : '';
    $work_hours = isset($body->work_hours) ? $body->work_hours : '';
    $model_year = isset($body->model_year) ? $body->model_year : '';
    $breslet_type = isset($body->breslet_type) ? $body->breslet_type : '';
    $time_slot_id = isset($body->time_slot_id) ? $body->time_slot_id : '';

    $state = isset($body->state) ? $body->state : '';
    $city = isset($body->city) ? $body->city : '';
    $get_status = '0';
    $status = 0;
    $quantity = 1;
    $nextbidprice = $price;
// $baseauctionprice = isset($body["baseauctionprice"]) ? $body["baseauctionprice"] : '';
//$thresholdprice = isset($body["thresholdprice"]) ? $body["thresholdprice"] : '';

    /* conversion of date format starts */

    $date_of_purchase1 = str_replace('/', '-', $date_of_purchase2);
    $date_of_purchase = date('Y-m-d', strtotime($date_of_purchase1 . "+1 days"));
    $preferred_date1 = str_replace('/', '-', $preferred_date2);

    $preferred_date = $preferred_date2;

    /* conversion of date format ends */

    $date = date("Y-m-d");

    $db = getConnection();


    $sqlsubscription = "SELECT ws.id as sid,wu.id,wu.type,ws.expiry_date,wu.slot_no FROM webshop_subscribers as ws inner join webshop_user as wu on wu.id=ws.user_id where ws.user_id=:user_id order by ws.id desc limit 1";
    $stmt = $db->prepare($sqlsubscription);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();
    $getUserDetails = $stmt->fetchObject();
    $getUserDetailscount = $stmt->rowCount();

    $sqltype = "SELECT * from webshop_user where id=:user_id";
    $stmtty = $db->prepare($sqltype);
    $stmtty->bindParam("user_id", $user_id);
    $stmtty->execute();
    $gettype = $stmtty->fetchObject();



    if ($gettype->type == 2) {
        if ($type == '1') {
            if ($getUserDetailscount > 0) {
                if ($getUserDetails->expiry_date >= $date) {
                    if ($getUserDetails->slot_no > 0) {

                        $sid = $getUserDetails->sid;


                        $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,status,size,location,work_hours,subscription_id,state,city,approved,breslet_type,model_year) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:status,:size,:location,:work_hours,:subscription_id,:state,:city,:approved,:breslet_type,:model_year)";



                        $sqlcheckcertifieduser = "SELECT * FROM webshop_user WHERE id =:user_id AND top_user_vendor='1'";
// $db = getConnection();
                        $stmtcheck = $db->prepare($sqlcheckcertifieduser);
                        $stmtcheck->bindParam("user_id", $user_id);
                        $stmtcheck->execute();
                        $count = $stmtcheck->rowCount();

                        $approved = "0";

                        if ($count > 0) {
                            $approved = "1";
//
                        }

                        $get_status = "1";

                        try {

                            $db = getConnection();
                            $stmt = $db->prepare($sql);

                            $stmt->bindParam("user_id", $user_id);
                            $stmt->bindParam("cat_id", $category);
                            $stmt->bindParam("name", $brand);
                            $stmt->bindParam("description", $description);
                            $stmt->bindParam("currency_code", $currency);
                            $stmt->bindParam("type", $type);
                            $stmt->bindParam("price", $price);
                            $stmt->bindParam("quantity", $quantity);
                            $stmt->bindParam("add_date", $date);
                            $stmt->bindParam("brand", $brand);
                            $stmt->bindParam("movement", $movement);
                            $stmt->bindParam("gender", $gender);
                            $stmt->bindParam("reference_number", $reference);
                            $stmt->bindParam("date_purchase", $date_of_purchase);
                            $stmt->bindParam("status_watch", $status_watch);
                            $stmt->bindParam("owner_number", $owner_number);
                            $stmt->bindParam("country", $country);
                            $stmt->bindParam("size", $size);
                            $stmt->bindParam("subscription_id", $sid);
                            $stmt->bindParam("state", $state);
                            $stmt->bindParam("city", $city);
                            $stmt->bindParam("location", $location);
                            $stmt->bindParam("work_hours", $work_hours);
                            $stmt->bindParam("status", $get_status);
                            $stmt->bindParam("approved", $approved);
                            $stmt->bindParam("breslet_type", $breslet_type);
                            $stmt->bindParam("model_year", $model_year);
                            $stmt->execute();
                            $lastID = $db->lastInsertId();

                            $rest_slot = (($getUserDetails->slot_no) - 1);
                            $sqlslotupdate = "UPDATE webshop_user SET slot_no=:slot WHERE id=:user_id";
                            $stmtslot = $db->prepare($sqlslotupdate);
                            $stmtslot->bindParam("slot", $rest_slot);
                            $stmtslot->bindParam("user_id", $user_id);
                            $stmtslot->execute();



                            if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                                foreach ($_FILES['image']['name'] as $key1 => $file) {



                                    if ($_FILES['image']['tmp_name'][$key1] != '') {

                                        $target_path = "../upload/product_image/";

                                        $userfile_name = $_FILES['image']['name'][$key1];

                                        $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                                        $img = $target_path . $userfile_name;
                                        move_uploaded_file($userfile_tmp, $img);

                                        $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam("image", $userfile_name);
                                        $stmt->bindParam("product_id", $lastID);
                                        $stmt->execute();


                                        $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                                        $stmt1 = $db->prepare($sqlimg);
                                        $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                                        $stmt1->execute();
                                    }
                                }
                            }

                            $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

                            $stmtttadmin = $db->prepare($sqladmin);
                            $stmtttadmin->execute();
                            $getadmin = $stmtttadmin->fetchObject();
                            if ($getadmin->product_upload_notification == 1) {
                                $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

                                $is_read = '0';
                                $last_id = '0';
                                $from_id = '0';
                                $message = 'New Product added';
//$type = '2';
                                $stmttt = $db->prepare($sqlFriend);
                                $stmttt->bindParam("from_id", $user_id);
                                $stmttt->bindParam("to_id", $from_id);
                                $stmttt->bindParam("type", $type);
                                $stmttt->bindParam("msg", $message);

                                $stmttt->bindParam("last_id", $last_id);
                                $stmttt->bindParam("is_read", $is_read);
                                $stmttt->execute();
                            }

                            $data['Ack'] = 1;
                            $data['msg'] = 'Product added successfully.';
                            $data['type'] = $type;
                            $data['utype'] = 2;

                            $app->response->setStatus(200);
                            $db = null;
                        } catch (PDOException $e) {
                            $data['user_id'] = '';
                            $data['Ack'] = 0;
                            $data['msg'] = 'error';
                            $app->response->setStatus(401);
                        }
                    } else {
                        $data['Ack'] = 0;
                        $data['msg'] = 'You have no slot to post this. Please subscribe our package to get this benifit.';
                        $app->response->setStatus(200);
                    }
                } else {
                    $data['Ack'] = 0;
                    $data['msg'] = 'You have no active subscription. Please subscribe our package to get this benifit.';
                    $app->response->setStatus(200);
                }
            } else {
                $data['Ack'] = 0;
                $data['msg'] = 'You have no subscription. Please subscribe our package to get this benifit.';
                $app->response->setStatus(200);
            }
        } else {

            $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,preferred_date,location,work_hours,status,breslet_type,model_year,time_slot_id,thresholdprice,state,city) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:preferred_date,:location,:work_hours,:status,:breslet_type,:model_year,:time_slot_id,:thresholdprice,:state,:city)";



            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
                $stmt->bindParam("name", $brand);
                $stmt->bindParam("description", $description);
                $stmt->bindParam("currency_code", $currency);
                $stmt->bindParam("type", $type);
                $stmt->bindParam("price", $price);
                $stmt->bindParam("quantity", $quantity);
                $stmt->bindParam("add_date", $date);
                $stmt->bindParam("brand", $brand);
                $stmt->bindParam("movement", $movement);
                $stmt->bindParam("gender", $gender);
                $stmt->bindParam("reference_number", $reference);
                $stmt->bindParam("date_purchase", $date_of_purchase);
                $stmt->bindParam("status_watch", $status_watch);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);

                $stmt->bindParam("preferred_date", $preferred_date);
                $stmt->bindParam("breslet_type", $breslet_type);
                $stmt->bindParam("model_year", $model_year);
                $stmt->bindParam("time_slot_id", $time_slot_id);
                $stmt->bindParam("thresholdprice", $price);
                $stmt->bindParam("state", $state);
                $stmt->bindParam("city", $city);

                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("status", $get_status);
                $stmt->execute();

                $lastID = $db->lastInsertId();




                /*  if (!empty($_FILES['image'])) {

                  if ($_FILES['image']['tmp_name'] != '') {

                  $target_path = "../upload/product_image/";

                  $userfile_name = $_FILES['image']['name'];

                  $userfile_tmp = $_FILES['image']['tmp_name'];

                  $img = $target_path . $userfile_name;

                  move_uploaded_file($userfile_tmp, $img);

                  $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";

                  $stmt1 = $db->prepare($sqlimg);
                  $stmt1->bindParam("image", $userfile_name);
                  $stmt1->execute();
                  }
                  } */

                if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                    foreach ($_FILES['image']['name'] as $key1 => $file) {



                        if ($_FILES['image']['tmp_name'][$key1] != '') {

                            $target_path = "../upload/product_image/";

                            $userfile_name = $_FILES['image']['name'][$key1];

                            $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                            $img = $target_path . $userfile_name;
                            move_uploaded_file($userfile_tmp, $img);

                            $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam("image", $userfile_name);
                            $stmt->bindParam("product_id", $lastID);
                            $stmt->execute();


                            $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                            $stmt1 = $db->prepare($sqlimg);
                            $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                            $stmt1->execute();
                        }
                    }
                }
                $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

                $stmtttadmin = $db->prepare($sqladmin);
                $stmtttadmin->execute();
                $getadmin = $stmtttadmin->fetchObject();
                if ($getadmin->auction_notification == 1) {
                    $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

                    $is_read = '0';
                    $last_id = '0';
                    $from_id = '0';
                    $message = 'New auction added';
//$type = '2';
                    $stmttt = $db->prepare($sqlFriend);
                    $stmttt->bindParam("from_id", $user_id);
                    $stmttt->bindParam("to_id", $from_id);
                    $stmttt->bindParam("type", $type);
                    $stmttt->bindParam("msg", $message);

                    $stmttt->bindParam("last_id", $last_id);
                    $stmttt->bindParam("is_read", $is_read);
                    $stmttt->execute();
                }

                $data['Ack'] = 1;
                $data['msg'] = 'Auction added successfully.';
                $data['type'] = $type;
                $data['utype'] = 2;
                $app->response->setStatus(200);
                $db = null;
            } catch (PDOException $e) {
                $data['user_id'] = '';
                $data['Ack'] = 0;
                $data['msg'] = 'error';
                $app->response->setStatus(401);
            }
        }
    } else {

        if ($type == '1') {


            $sqladminfree_no = "SELECT * FROM webshop_sitesettings WHERE id =1 ";
            $db = getConnection();
            $stmtfreeno = $db->prepare($sqladminfree_no);
            $stmtfreeno->execute();
            $getfree_no = $stmtfreeno->fetchObject();
            $free_no = $getfree_no->free_bid;

            $sqluserpay_product = "SELECT * FROM webshop_products WHERE uploader_id=:user_id and type=1 and status=1 and user_free_product='P'";
            $db = getConnection();
            $stmtpayno = $db->prepare($sqluserpay_product);
            $stmtpayno->bindParam("user_id", $user_id);
            $stmtpayno->execute();
            $pcount = $stmtpayno->rowCount();



            $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,location,work_hours,approved,state,city,status,breslet_type,model_year) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:location,:work_hours,:approved,:state,:city,:status,:breslet_type,:model_year)";




            $sqlcheckcertifieduser = "SELECT * FROM webshop_user WHERE id =:user_id AND top_user_vendor='1'";
            $db = getConnection();
            $stmtcheck = $db->prepare($sqlcheckcertifieduser);
            $stmtcheck->bindParam("user_id", $user_id);
            $stmtcheck->execute();
            $count = $stmtcheck->rowCount();


            if ($pcount == $free_no) {

                $payment_status = "1";
            } else {

                $payment_status = "0";
            }

            if ($count > 0) {
                $get_status = "1";
            } else {

                $get_status = "0";
            }

            if ($count > 0) {
                $certified_user = "1";
            } else {

                $certified_user = "0";
            }

            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
                $stmt->bindParam("name", $brand);
                $stmt->bindParam("description", $description);
                $stmt->bindParam("currency_code", $currency);
                $stmt->bindParam("type", $type);
                $stmt->bindParam("price", $price);
                $stmt->bindParam("quantity", $quantity);
                $stmt->bindParam("add_date", $date);
                $stmt->bindParam("brand", $brand);
                $stmt->bindParam("movement", $movement);
                $stmt->bindParam("gender", $gender);
                $stmt->bindParam("reference_number", $reference);
                $stmt->bindParam("date_purchase", $date_of_purchase);
                $stmt->bindParam("status_watch", $status_watch);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);
                $stmt->bindParam("state", $state);
                $stmt->bindParam("city", $city);
                $stmt->bindParam("breslet_type", $breslet_type);
                $stmt->bindParam("model_year", $model_year);

                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("approved", $get_status);
                $stmt->bindParam("status", $payment_status);
                $stmt->execute();
                $lastID = $db->lastInsertId();



                if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                    foreach ($_FILES['image']['name'] as $key1 => $file) {

                        if ($_FILES['image']['tmp_name'][$key1] != '') {

                            $target_path = "../upload/product_image/";

                            $userfile_name = $_FILES['image']['name'][$key1];

                            $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                            $img = $target_path . $userfile_name;
                            move_uploaded_file($userfile_tmp, $img);

                            $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam("image", $userfile_name);
                            $stmt->bindParam("product_id", $lastID);
                            $stmt->execute();

                            $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                            $stmt1 = $db->prepare($sqlimg);
                            $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                            $stmt1->execute();
                        }
                    }
                }

                if ($payment_status == 1) {

                    $sqlupdatefree = "UPDATE webshop_products SET user_free_product='F' WHERE type=1 and status=1 and uploader_id=$user_id ";
                    $stmtupdatefree = $db->prepare($sqlupdatefree);
                    $stmtupdatefree->execute();
                }



                if ($payment_status == 0) {
                    if ($certified_user == 1) {
                        $data['Ack'] = 1;
                        $data['msg'] = 'Product added successfully. To get product live please make payment.';
                        $data['type'] = $type;
                        $data['utype'] = 1;
                        $data['lastid'] = $lastID;
                        $data['certified_user'] = $certified_user;
                        $app->response->setStatus(200);
                        $db = null;
                    } else {

                        $data['Ack'] = 1;
                        $data['msg'] = 'Product added successfully. Wait for admin approval to pay and live this product.';
                        $data['type'] = $type;
                        $data['utype'] = 1;
                        $data['lastid'] = $lastID;
                        $data['certified_user'] = $certified_user;
                    }
                } else {

                    $data['Ack'] = 1;
                    $data['msg'] = 'Congrats Product added successfully. It Was free.';
                    $data['type'] = $type;
                    $data['lastid'] = $lastID;
                }
            } catch (PDOException $e) {
                $data['user_id'] = '';
                $data['Ack'] = 0;
                $data['msg'] = 'error';
                $app->response->setStatus(401);
            }
        } else {

            $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,preferred_date,location,work_hours,status,breslet_type,model_year,time_slot_id,thresholdprice,state,city) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:preferred_date,:location,:work_hours,:status,:breslet_type,:model_year,:time_slot_id,:thresholdprice,:state,:city)";



            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
//$stmt->bindParam("subcat_id", $subcategory);
                $stmt->bindParam("name", $brand);
                $stmt->bindParam("description", $description);
                $stmt->bindParam("currency_code", $currency);
                $stmt->bindParam("type", $type);
                $stmt->bindParam("price", $price);
                $stmt->bindParam("quantity", $quantity);
                $stmt->bindParam("add_date", $date);
                $stmt->bindParam("brand", $brand);
                $stmt->bindParam("movement", $movement);
                $stmt->bindParam("gender", $gender);
                $stmt->bindParam("reference_number", $reference);
                $stmt->bindParam("date_purchase", $date_of_purchase);
                $stmt->bindParam("status_watch", $status_watch);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);



                $stmt->bindParam("preferred_date", $preferred_date);
                $stmt->bindParam("breslet_type", $breslet_type);
                $stmt->bindParam("model_year", $model_year);
                $stmt->bindParam("time_slot_id", $time_slot_id);
                $stmt->bindParam("thresholdprice", $price);
                $stmt->bindParam("state", $state);
                $stmt->bindParam("city", $city);

                $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, type, msg, is_read,last_id) VALUES (:from_id, :to_id, :type, :msg, :is_read,:last_id)";

                $is_read = '0';
                $last_id = '0';
                $from_id = '0';
                $message = 'New auction added';
//$type = '2';
                $stmttt = $db->prepare($sqlFriend);
                $stmttt->bindParam("from_id", $user_id);
                $stmttt->bindParam("to_id", $from_id);
                $stmttt->bindParam("type", $type);
                $stmttt->bindParam("msg", $message);

                $stmttt->bindParam("last_id", $last_id);
                $stmttt->bindParam("is_read", $is_read);
                $stmttt->execute();


                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("status", $get_status);
                $stmt->execute();

                $lastID = $db->lastInsertId();




                /* if (!empty($_FILES['image'])) {

                  if ($_FILES['image']['tmp_name'] != '') {

                  $target_path = "../upload/product_image/";

                  $userfile_name = $_FILES['image']['name'];

                  $userfile_tmp = $_FILES['image']['tmp_name'];


                  $img = $target_path . $userfile_name;
                  move_uploaded_file($userfile_tmp, $img);


                  $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";

                  $stmt1 = $db->prepare($sqlimg);
                  $stmt1->bindParam("image", $userfile_name);
                  $stmt1->execute();
                  }
                  } */
                if (!empty($_FILES['image'])) {

//print_r($_FILES['image']);exit;
                    foreach ($_FILES['image']['name'] as $key1 => $file) {

                        if ($_FILES['image']['tmp_name'][$key1] != '') {

                            $target_path = "../upload/product_image/";

                            $userfile_name = $_FILES['image']['name'][$key1];

                            $userfile_tmp = $_FILES['image']['tmp_name'][$key1];


                            $img = $target_path . $userfile_name;
                            move_uploaded_file($userfile_tmp, $img);

                            $sql = "INSERT INTO webshop_product_image (image,product_id) VALUES (:image,:product_id)";

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam("image", $userfile_name);
                            $stmt->bindParam("product_id", $lastID);
                            $stmt->execute();

                            $sqlimg = "UPDATE webshop_products SET image=:image WHERE id=$lastID";
                            $stmt1 = $db->prepare($sqlimg);
                            $stmt1->bindParam("image", $_FILES['image']['name'][0]);
                            $stmt1->execute();
                        }
                    }
                }

                $data['Ack'] = 1;
                $data['msg'] = 'Auction added successfully.';
                $data['type'] = $type;
                $data['utype'] = 1;
                $app->response->setStatus(200);
                $db = null;
            } catch (PDOException $e) {
                $data['user_id'] = '';
                $data['Ack'] = 0;
                $data['msg'] = 'error';
                $app->response->setStatus(401);
            }
        }
    }


    $app->response->write(json_encode($data));
}

function getTimeslot_app() {

   
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    
   
   
    $acutondate = isset($body->getdate) ? $body->getdate : '';

    $sql = "SELECT * FROM  webshop_auctiondates WHERE  date =:acutondate";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("acutondate", $acutondate);
    $stmt->execute();
    $getauctiondate = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($getauctiondate)) {
        foreach ($getauctiondate as $auction) {

            $sqlexsits = "SELECT * FROM  webshop_products WHERE  time_slot_id =:time_slot_id";
            $db = getConnection();
            $stmt1 = $db->prepare($sqlexsits);
            $stmt1->bindParam("time_slot_id", $auction->id);

            $stmt1->execute();
            $bookeddatetime = $stmt1->fetchAll(PDO::FETCH_OBJ);


            if (!empty($bookeddatetime)) {

                $data['time'][] = array(
                    'start_time' => date('h:i A', strtotime($auction->start_time)),
                    'end_time' => date('h:i A', strtotime($auction->end_time)),
                    'id' => stripslashes($auction->id),
                    "status" => 1,
                );
            } else {

                $data['time'][] = array(
                    'start_time' => date('h:i A', strtotime($auction->start_time)),
                    'end_time' => date('h:i A', strtotime($auction->end_time)),
                    'id' => stripslashes($auction->id),
                    "status" => 0,
                );
            }

        }
    }

    $data['Ack'] = '1';

    $app->response->write(json_encode($data));
}


function imageinsert_app() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());



    try {

       

        if (!empty($_FILES['file'])) {

                  if ($_FILES['file']['tmp_name'] != '') {

                  $target_path = "../upload/product_image/";
                  $userfile_name = $_FILES['file']['name'];
                  $userfile_tmp = $_FILES['file']['tmp_name'];
                  $img = $target_path . $userfile_name;
                  move_uploaded_file($userfile_tmp, $img);

                  }
                  }

        $image = SITE_URL . 'upload/product_image/' . $userfile_name;
        $data['Ack'] = 1;
        $data['name'] = $userfile_name;
        $data['link'] = $image;
        $data['msg'] = 'image added successfully.';

        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        
        $data['Ack'] = 0;
        $data['msg'] = 'error';
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getmaxprice() {

    
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $type = isset($body->type) ? $body->type : '';
    $db = getConnection();

    

    try {

        $sqlmin = "SELECT MIN(price) from webshop_products WHERE `type` =$type";
        $stmtmin = $db->prepare($sqlmin);
        $stmtmin->execute();
        $getminprice = $stmtmin->fetchAll();
        
        $sqlmax = "SELECT MAX(price) from webshop_products WHERE `type` =$type";
        $stmtmax = $db->prepare($sqlmax);
        $stmtmax->execute();
        $getmaxprice = $stmtmax->fetchAll();

        
        if (!empty($getminprice)) {
            $minprice = $getminprice[0][0];
            
            //$data['Ack'] = '1';
           // $app->response->setStatus(200);
        }else{
            $minprice ='';
        }
        if(!empty($getmaxprice)){
          // $data['minprice'] = $getminprice[0][0];
            $maxprice = $getmaxprice[0][0]; 
        }else{
            $maxprice ='';
        } 
       
            $data['minprice']=$minprice;
            $data['maxprice']=$maxprice;
            
            $data['Ack'] = '1';
            $app->response->setStatus(200);
       
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function listbracelet() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_bracelet where status=1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getBrand as $brand) {

            $allbrand[] = array(
                "id" => stripslashes($brand->id),
                "type" => stripslashes($brand->type)
            );
        }

        $data['braceletlist'] = $allbrand;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}


function shopDetails() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

// $email = $body['email'];
    $shop_id = $body->shop_id;

    try {
        $db = getConnection();



        $sql = "SELECT * FROM  webshop_user WHERE id=:id ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $shop_id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        if ($getUserdetails->image != '') {
            $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
        } else {
            $profile_image = SITE_URL . 'webservice/no-user.png';
        }

       
        $name = $getUserdetails->fname.' '.$getUserdetails->lname;
        $countryname='No prefered country added';
        if($getUserdetails->country_preference != ''){
           $sqlcountry =  "SELECT * FROM  webshop_countries WHERE `id`='$getUserdetails->country_preference'"; 
           
           $stmtcountry = $db->prepare($sqlcountry);
       
        $stmtcountry->execute();
        $getcountry = $stmtcountry->fetchObject();
        if (!empty($getcountry)) {
            $countryname = $getcountry->name;
        }else{
            $countryname='NA';
        }
        }else{
            $countryname='NA';
        }
       
        if($getUserdetails->currency_preference != ''){
           $sqlcurrency_preference =  "SELECT * FROM  webshop_currency WHERE `code`='$getUserdetails->currency_preference'"; 
           
           $stmtcurrency_preference = $db->prepare($sqlcurrency_preference);
       
        $stmtcurrency_preference->execute();
        $getcurrency_preference = $stmtcurrency_preference->fetchObject();
        if (!empty($getcurrency_preference)) {
            $currency_preferencename = $getcurrency_preference->name;
        }else{
            $currency_preferencename='NA';
        }
        }else{
            $currency_preferencename='NA';
        }
         
         if($getUserdetails->country != ''){
           $sqlusercountry =  "SELECT * FROM  webshop_countries WHERE `id`='$getUserdetails->country'"; 
           
           $stmtusercountry = $db->prepare($sqlusercountry);
       
        $stmtusercountry->execute();
        $getusercountry = $stmtusercountry->fetchObject();
        if (!empty($getusercountry)) {
            $usercountry = $getusercountry->name;
        }else{
            $usercountry='NA';
        }
        }else{
            $usercountry='NA'; 
        }
      
         if($getUserdetails->state != ''){
           $sqlstate =  "SELECT * FROM  webshop_states WHERE `id`='$getUserdetails->state'"; 
           
           $stmtstate = $db->prepare($sqlstate);
       
        $stmtstate->execute();
        $getstate = $stmtstate->fetchObject();
        if (!empty($getstate)) {
            $state = $getstate->name;
        }else{
            $state='NA';
        }
        }else{
            $state='NA';
        }
     
         

        $data['UserDetails'] = array(
            "user_id" => stripslashes($getUserdetails->id),
            "name" => stripslashes($name),
            "description" => strip_tags(stripslashes($getUserdetails->description)),
            "gender" => stripslashes($getUserdetails->gender),
           "country_preference"=>stripslashes($countryname),
            "currency_preference"=>stripslashes($currency_preferencename),
            "email" => stripslashes($getUserdetails->email),
            "language_preference" => stripslashes($getUserdetails->language_preference),
            "phone" => stripslashes($getUserdetails->phone),
            "dob" => stripslashes($getUserdetails->dob),
            "profile_image" => stripslashes($profile_image),
            
            "language_preference" => stripslashes($getUserdetails->language_preference),
            
          
            "country" => stripslashes($usercountry),
            "state" => stripslashes($state),
           
           
            "currency_preference" => stripslashes($getUserdetails->currency_preference));


        $data['Ack'] = '1';
        $data['msg'] = 'Success';
        $app->response->setStatus(200);


        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function packagedetails() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $package_id = isset($body->package_id) ? $body->package_id : '';
    
    $sql = "SELECT * from  webshop_subscription WHERE id=:id ";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $package_id);
    $stmt->execute();
    $product = $stmt->fetchObject();

    if (!empty($product)) {

       
        $data['packagedetails'] = array(
            "id" => stripslashes($product->id),
            "price" => stripslashes($product->price),
          
        );

        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['packagedetails'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function myauctionpayamount() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $product_id = base64_decode($body->product_id);
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $db = getConnection();
    $sql = "SELECT * from webshop_biddetails where productid =:product_id and userid= '" . $user_id . "'order by id desc limit 0,1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
        $getProductValue = $stmt->fetchObject();

    if (!empty($getProductValue)) {

       
        $data['amountdetails'] = array(
            //"id" => stripslashes($getProductValue->id),
            "price" => stripslashes($getProductValue->bidprice),
          
        );

        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['amountdetails'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function getmaxprice2() {

    
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $type = isset($body->type) ? $body->type : '';
    $db = getConnection();

    

    try {

        $sqlmin = "SELECT MIN(price) from webshop_products";
        $stmtmin = $db->prepare($sqlmin);
        $stmtmin->execute();
        $getminprice = $stmtmin->fetchAll();
        
        $sqlmax = "SELECT MAX(price) from webshop_products";
        $stmtmax = $db->prepare($sqlmax);
        $stmtmax->execute();
        $getmaxprice = $stmtmax->fetchAll();

        
        if (!empty($getminprice)) {
            $minprice = $getminprice[0][0];
            
            //$data['Ack'] = '1';
           // $app->response->setStatus(200);
        }else{
            $minprice ='';
        }
        if(!empty($getmaxprice)){
          // $data['minprice'] = $getminprice[0][0];
            $maxprice = $getmaxprice[0][0]; 
        }else{
            $maxprice ='';
        } 
       
            $data['minprice']=$minprice;
            $data['maxprice']=$maxprice;
            
            $data['Ack'] = '1';
            $app->response->setStatus(200);
       
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function contactinfo() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_contact_info WHERE id=1";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $getAlllinks = $stmt->fetchObject();

//print_r($getAllProducts);exit;

    if (!empty($getAlllinks)) {
       

            $data['contactinfo'] = array(
                "id" => stripslashes($getAlllinks->id),
                "address" => stripslashes($getAlllinks->address),
                "phone" => stripslashes($getAlllinks->phone),
                "email" => stripslashes($getAlllinks->email),
            );
        

        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['contactinfo'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function searchproductListinglatest() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $brand = isset($body->brand) ? $body->brand : '';
    $brandListing = isset($body->brandList) ? $body->brandList : '';
    $sellerListing = isset($body->sellerList) ? $body->sellerList : '';
    $selected_value = isset($body->selected_value) ? $body->selected_value : '';
    $amount_min = isset($body->amount_min) ? $body->amount_min : '';
    $amount_max = isset($body->amount_max) ? $body->amount_max : '';

    $gender = isset($body->gender) ? $body->gender : '';
    $breslettype = isset($body->breslettype) ? $body->breslettype : '';
    $year = isset($body->year) ? $body->year : '';
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';

    $country_id = isset($body->country_id) ? $body->country_id : '';
    $state_id = isset($body->state_id) ? $body->state_id : '';
    $city_id = isset($body->city_id) ? $body->city_id : '';
    
$category = isset($body->category) ? $body->category : '';
$movement = isset($body->movement) ? $body->movement : '';

$size_amount_max = isset($body->size_amount_max) ? $body->size_amount_max : '';
    $size_amount_min = isset($body->size_amount_min) ? $body->size_amount_min : '';
//print_r($body);
//-----------------------------------------------------------
    $productIds = array();

    if ($selected_value == '4') {

        $new_sql = "SELECT * from webshop_reviews order by rating desc";
        $stmt2 = $db->prepare($new_sql);
        $stmt2->execute();
        $total_rows = $stmt2->rowCount();
        $getIds = $stmt2->fetchAll(PDO::FETCH_OBJ);


        if ($total_rows > 0) {

            foreach ($getIds as $product) {

                array_push($productIds, $product->product_id);
            }
        }

        $productIds = array_unique($productIds);

// print_r($productIds);
// exit;

        $productIds = implode(",", $productIds);
        $sql = "SELECT * from webshop_products where status = 1 and is_leatest_deal='1' and approved='1' and type='1' and is_discard='0' and id IN(" . $productIds . ")";
    } else {


        $sql = "SELECT * from  webshop_products where status=1 and is_leatest_deal='1' and approved='1' and type='1' and is_discard='0'";
    }

    if ($amount_min != '' && $amount_max != '') {

        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min == '' && $amount_max != '') {
        $amount_min = 0.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min != '' && $amount_max == '') {
        $amount_max = 10000.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    }

    if ($size_amount_min != '' && $size_amount_max != '') {

        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    } else if ($size_amount_min == '' && $size_amount_max != '') {
        $size_amount_min = 0.00;
        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    } else if ($size_amount_min != '' && $size_amount_max == '') {
        $size_amount_max = 1000.00;
        $sql .= " AND `size` BETWEEN " . $size_amount_min . " " . "AND" . " " . $size_amount_max . "";
    }
    if ($brandListing != '') {

        $sql .= " AND `brands` IN (" . $brandListing . ")";
    }
    if ($sellerListing != '') {

        $sql .= " AND `uploader_id` IN (" . $sellerListing . ")";
    }

if ($movement != '') {

        $sql .= " AND `movement` IN ('" . $movement . "')";
    }
//spandan
   

    if ($category != '') {

       // $sql .= " AND `cat_id` = '" . $category . "'";
         $sql .= " AND `cat_id` IN (" . $category . ")";
    }
//    if ($gender != '') {
//
//        $sql .= " AND `gender`='" . $gender . "' ";
//    }
   

    if ($brand != '') {

        $sql .= " AND `brands` = '" . $brand . "'";
    }
    if ($breslettype != '') {

        $sql .= " AND `breslet_type` = '" . $breslettype . "'";
    }

    if ($year != '') {

        $sql .= " AND model_year = '" . $year . "'";
    }
   
    if ($preferred_date != '') {

        $sql .= " AND preferred_date = '" . $preferred_date . "'";
    }



    if ($country_id != '') {

        $sql .= " AND country = '" . $country_id . "'";
    }
    if ($state_id != '') {

        $sql .= " AND state = '" . $state_id . "'";
    }
    if ($city_id != '') {

        $sql .= " AND city = '" . $city_id . "'";
    }


//spandan end

    if ($selected_value == '1') {

        $sql .= " ORDER BY price ASC";
    }
    if ($selected_value == '2') {

        $sql .= " ORDER BY price DESC";
    }
    if ($selected_value == '3') {

        $sql .= " ORDER BY add_date DESC";
    }

if ($gender != '') {

       // $sql .= " AND `cat_id` = '" . $category . "'";
         $sql .= " AND `gender` IN (" . $gender . ")";
    }

    

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);


        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {
                $sid = $product->subscription_id;
                 $price =$product->price;
                 $topsid=$product->top_product;
                if ($sid != 0) {
                    $sqlsubs = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs = $db->prepare($sqlsubs);
                    $stmtsubs->bindParam("id", $sid);
                    $stmtsubs->execute();
                    $getsubs = $stmtsubs->fetchObject();

                    $cdate = date('Y-m-d');

                    if ($getsubs->expiry_date >= $cdate) {
                        
                        
                        
                        
                        if($topsid!= 0){    
                    $sqlsubs_top = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs_top = $db->prepare($sqlsubs_top);
                    $stmtsubs_top->bindParam("id", $topsid);
                    $stmtsubs_top->execute();
                    $getsubs_top = $stmtsubs_top->fetchObject();

                       if ($getsubs_top->expiry_date >= $cdate) {
                           
                          $top_product_status =1;
                           
                       }else{
                           
                            $top_product_status =0;
                       } 
                        
                    } else{
                           
                            $top_product_status =0;
                       }
                        
                        
                        
                        
                        
                        
                        
                        

                        if ($product->image != '') {
                            $image = SITE_URL . 'upload/product_image/' . $product->image;
                        } else {
                            $image = SITE_URL . 'webservice/not-available.jpg';
                        }


                        $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                        $stmt2 = $db->prepare($sql2);
                        $stmt2->bindParam("id", $product->cat_id);
                        $stmt2->execute();
                        $getcategory = $stmt2->fetchObject();
                        if (!empty($getcategory)) {
                            $categoryname = $getcategory->name;
                        }



                        $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                        $stmt3 = $db->prepare($sql3);
                        $stmt3->bindParam("id", $product->brands);
                        $stmt3->execute();
                        $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }
//Seller Information

                        $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                        $stmt1 = $db->prepare($sql1);
                        $stmt1->bindParam("id", $product->uploader_id);
                        $stmt1->execute();
                        $getUserdetails = $stmt1->fetchObject();
                        
                        //$price ='';
                                               
                        if (!empty($getUserdetails)) {
                            $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                            $seller_address = $getUserdetails->address;
                            $seller_phone = $getUserdetails->phone;
                            $email = $getUserdetails->email;
                            $top = $getUserdetails->top_user_vendor;

                            if ($getUserdetails->image != '') {
                                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                            } else {
                                $profile_image = SITE_URL . 'webservice/no-user.png';
                            }
                            
                        } else {
                            $profile_image = '';
                        }
                       
                           if($user_id){
                              
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                           // echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                    }else{
                        $price = $product->price;
                    }
                       
                        


                        $product_encoded_id =  urlencode ( base64_encode($product->id));
                        $data['productList'][] = array(
                            "id" => stripslashes($product_encoded_id),
                            "image" => stripslashes($image),
                            "price" => stripslashes($price),
                            "description" => strip_tags(stripslashes($product->description)),
                            "category_name" => $categoryname,
                             "brands" => $subcategoryname,
                            "seller_id" => stripslashes($product->uploader_id),
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            "seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($seller_phone),
                            "productname" => '',
                            "currency_code" => stripslashes($product->currency_code),
                            
                            "top" => stripslashes($top),
                            "top_product" => stripslashes($top_product_status),
                        );
                    }
                    //print_r($data['productList']);exit;
                } else {
    
                    
                    if($topsid!= 0){    
                    $sqlsubs_top = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs_top = $db->prepare($sqlsubs_top);
                    $stmtsubs_top->bindParam("id", $topsid);
                    $stmtsubs_top->execute();
                    $getsubs_top = $stmtsubs_top->fetchObject();

                       if ($getsubs_top->expiry_date >= $cdate) {
                           
                          $top_product_status =1;
                           
                       }else{
                           
                            $top_product_status =0;
                       } 
                        
                    } else{
                           
                            $top_product_status =0;
                       }

                    if ($product->image != '') {
                        $image = SITE_URL . 'upload/product_image/' . $product->image;
                    } else {
                        $image = SITE_URL . 'webservice/not-available.jpg';
                    }


                    $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam("id", $product->cat_id);
                    $stmt2->execute();
                    $getcategory = $stmt2->fetchObject();
                    
                    if (!empty($getcategory)) {
                        $categoryname = $getcategory->name;
                    }



                        $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                        $stmt3 = $db->prepare($sql3);
                        $stmt3->bindParam("id", $product->brands);
                        $stmt3->execute();
                        $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }


                    $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("id", $product->uploader_id);
                    $stmt1->execute();
                    $getUserdetails = $stmt1->fetchObject();
                    //print_r($getUserdetails);
                    //$price ='';
                    if (!empty($getUserdetails)) {
                        $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                        $seller_address = $getUserdetails->address;
                        $seller_phone = $getUserdetails->phone;
                        $email = $getUserdetails->email;
                        $top = $getUserdetails->top_user_vendor;
                        if ($getUserdetails->image != '') {
                            $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                        } else {
                            $profile_image = SITE_URL . 'webservice/no-user.png';
                        }
                        
                    } else {
                        $profile_image = '';
                    }
                    
                   if($user_id){
                              
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                           // echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                    }else{
                        $price = $product->price;
                    }
                   // exit;
                    $product_encoded_id =  urlencode ( base64_encode($product->id));
                    $data['productList'][] = array(
                            "id" => stripslashes($product_encoded_id),
                            "image" => stripslashes($image),
                            "price" => stripslashes($price),
                            "description" => strip_tags(stripslashes($product->description)),
                            "category_name" => $categoryname,
                             "brands" => $subcategoryname,
                            "seller_id" => stripslashes($product->uploader_id),
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            "seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($seller_phone),
                            "productname" => '',
                            "currency_code" => stripslashes($product->currency_code),
                            
                            "top" => stripslashes($top),
                            "top_product" => stripslashes($top_product_status),
                        );
                }
            }

            
            $data['Ack'] = '1';
            $app->response->setStatus(200);
            
       } else {
            $data = array();
            $data['productList'] = array();
            $data['Ack'] = '0';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    //exit; 
    $app->response->write(json_encode($data));
}



function banner() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);


    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_banner WHERE id=1";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $getAlllinks = $stmt->fetchObject();

//print_r($getAllProducts);exit;

    if (!empty($getAlllinks)) {
        
       if ($getAlllinks->image != '') {
                            $image = SITE_URL . 'upload/banner/' . $getAlllinks->image;
                        } else {
                            $image = SITE_URL . 'webservice/not-available.jpg';
                        }

            $data['banner'] = array(
                "id" => stripslashes($getAlllinks->id),
                "name" => stripslashes($getAlllinks->name),
                "description" => stripslashes($getAlllinks->description),
                "image" => $image,
                
            );
        

        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } else {
        $data = array();
        $data['banner'] = array();
        $data['Ack'] = '0';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}


function getmovement() {

    $data = array();
$app = \Slim\Slim::getInstance();
        $a[1] = 'Automatic Movement';
        $a[2] = 'Quartz Movement';
        $a[3] = 'Other Movement';
        
        for ($i=1;$i<=3;$i++) {
            
            $allbrand[] = array(
                'id' => stripslashes($i),
                "name" => $a[$i],
                
            );
        }

        $data['movementlist'] = $allbrand;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    

    $app->response->write(json_encode($data));
}

function ShopListSearch() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $brand = isset($body->brand) ? $body->brand : '';
    $brandListing = isset($body->brandList) ? $body->brandList : '';
    $sellerListing = isset($body->sellerList) ? $body->sellerList : '';
    $selected_value = isset($body->selected_value) ? $body->selected_value : '';
    $amount_min = isset($body->amount_min) ? $body->amount_min : '';
    $amount_max = isset($body->amount_max) ? $body->amount_max : '';

    $gender = isset($body->gender) ? $body->gender : '';
    $breslettype = isset($body->breslettype) ? $body->breslettype : '';
    $year = isset($body->year) ? $body->year : '';
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';

    $country_id = isset($body->country_id) ? $body->country_id : '';
    $state_id = isset($body->state_id) ? $body->state_id : '';
    $city_id = isset($body->city_id) ? $body->city_id : '';
    $keyword = isset($body->keyword) ? $body->keyword : '';
$category = isset($body->category) ? $body->category : '';
$movement = isset($body->movement) ? $body->movement : '';
$shop_id = isset($body->shop_id) ? $body->shop_id : '';
//print_r($body);
//-----------------------------------------------------------
    $productIds = array();

    if ($selected_value == '4') {

        $new_sql = "SELECT * from webshop_reviews order by rating desc";
        $stmt2 = $db->prepare($new_sql);
        $stmt2->execute();
        $total_rows = $stmt2->rowCount();
        $getIds = $stmt2->fetchAll(PDO::FETCH_OBJ);


        if ($total_rows > 0) {

            foreach ($getIds as $product) {

                array_push($productIds, $product->product_id);
            }
        }

        $productIds = array_unique($productIds);

        $productIds = implode(",", $productIds);
        $sql = "SELECT * from webshop_products where status = 1 and approved='1' and type='1' and is_discard='0' and id IN(" . $productIds . ")";
    } else {


        $sql = "SELECT * from  webshop_products where status=1 and approved='1' and type='1' and is_discard='0' ";
    }

    if ($amount_min != '' && $amount_max != '') {

        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min == '' && $amount_max != '') {
        $amount_min = 0.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    } else if ($amount_min != '' && $amount_max == '') {
        $amount_max = 10000.00;
        $sql .= " AND `price` BETWEEN " . $amount_min . " " . "AND" . " " . $amount_max . "";
    }

    if ($brandListing != '') {

        $sql .= " AND `brands` IN (" . $brandListing . ")";
    }
    if ($sellerListing != '') {

        $sql .= " AND `uploader_id` IN (" . $sellerListing . ")";
    }

if ($movement != '') {

        $sql .= " AND `movement` IN ('" . $movement . "')";
    }
    
    if ($shop_id != '') {

        $sql .= " AND `uploader_id` IN ('" . $shop_id . "')";
    }

    if ($category != '') {

         $sql .= " AND `cat_id` IN (" . $category . ")";
    }
    if ($gender != '') {

        $sql .= " AND `gender`='" . $gender . "' ";
    }
   
    if ($breslettype != '') {

        $sql .= " AND `breslet_type` = '" . $breslettype . "'";
    }

    if ($year != '') {

        $sql .= " AND model_year = '" . $year . "'";
    }
    
   // exit;
    if ($keyword != '') {

        $sql .= " AND `model_year` LIKE '%" . $keyword . "%' OR `gender` LIKE '" . $keyword . "%' OR `preferred_date` LIKE '%" . $keyword . "%' OR `brands` LIKE '" . $keybrandid . "' OR `name` LIKE '" . $keyword . "' OR `description` LIKE '" . $keyword . "' OR `price` LIKE '" . $keyword . "' OR `movement` LIKE '" . $keyword . "' OR `reference_number` LIKE '" . $keyword . "' OR `owner_number` LIKE '" . $keyword . "' OR `cat_id` LIKE '" . $keycatid . "' AND type=1 ";
    }
    
    if ($preferred_date != '') {

        $sql .= " AND preferred_date = '" . $preferred_date . "'";
    }
   


    if ($country_id != '') {

        $sql .= " AND country = '" . $country_id . "'";
    }
    if ($state_id != '') {

        $sql .= " AND state = '" . $state_id . "'";
    }
    if ($city_id != '') {

        $sql .= " AND city = '" . $city_id . "'";
    }

//spandan end

    if ($selected_value == '1') {

        $sql .= " ORDER BY price ASC";
    }
    if ($selected_value == '2') {

        $sql .= " ORDER BY price DESC";
    }
    if ($selected_value == '3') {

        $sql .= " ORDER BY add_date DESC";
    }




    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllProducts = $stmt->fetchAll(PDO::FETCH_OBJ);


        if (!empty($getAllProducts)) {
            foreach ($getAllProducts as $product) {
                $sid = $product->subscription_id;
                 $price =$product->price;
                if ($sid != 0) {
                    $sqlsubs = "SELECT * FROM  webshop_subscribers WHERE id=:id ";
                    $stmtsubs = $db->prepare($sqlsubs);
                    $stmtsubs->bindParam("id", $sid);
                    $stmtsubs->execute();
                    $getsubs = $stmtsubs->fetchObject();

                    $cdate = date('Y-m-d');

                    if ($getsubs->expiry_date >= $cdate) {

                        if ($product->image != '') {
                            $image = SITE_URL . 'upload/product_image/' . $product->image;
                        } else {
                            $image = SITE_URL . 'webservice/not-available.jpg';
                        }


                        $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                        $stmt2 = $db->prepare($sql2);
                        $stmt2->bindParam("id", $product->cat_id);
                        $stmt2->execute();
                        $getcategory = $stmt2->fetchObject();
                        if (!empty($getcategory)) {
                            $categoryname = $getcategory->name;
                        }



                        $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                        $stmt3 = $db->prepare($sql3);
                        $stmt3->bindParam("id", $product->brands);
                        $stmt3->execute();
                        $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }
//Seller Information

                        $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                        $stmt1 = $db->prepare($sql1);
                        $stmt1->bindParam("id", $product->uploader_id);
                        $stmt1->execute();
                        $getUserdetails = $stmt1->fetchObject();
                           // $price ='';
                        if (!empty($getUserdetails)) {
                            $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                            $seller_address = $getUserdetails->address;
                            $seller_phone = $getUserdetails->phone;
                            $email = $getUserdetails->email;
                            $top = $getUserdetails->top_user_vendor;

                            if ($getUserdetails->image != '') {
                                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                            } else {
                                $profile_image = SITE_URL . 'webservice/no-user.png';
                            }
                            
                            
                            
                        } else {
                            $profile_image = '';
                        }
                        if($user_id){
                        $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                            //echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                    }else{
                        $price = $product->price;
                    }
                        $product_encoded_id =  urlencode ( base64_encode($product->id));
                        $data['productList'][] = array(
                            "id" => stripslashes($product_encoded_id),
                            "image" => stripslashes($image),
                            "price" => stripslashes($price),
                            "description" => strip_tags(stripslashes($product->description)),
                            "category_name" => $categoryname,
                             "brands" => $subcategoryname,
                            "seller_id" => stripslashes($product->uploader_id),
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            "seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($seller_phone),
                            "productname" => '',
                            "currency_code" => stripslashes($product->currency_code),
                            
                            "top" => stripslashes($top),
                        );
                    }
                } else {



                    if ($product->image != '') {
                        $image = SITE_URL . 'upload/product_image/' . $product->image;
                    } else {
                        $image = SITE_URL . 'webservice/not-available.jpg';
                    }


                    $sql2 = "SELECT * FROM  webshop_category WHERE id=:id ";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam("id", $product->cat_id);
                    $stmt2->execute();
                    $getcategory = $stmt2->fetchObject();
                    if (!empty($getcategory)) {
                        $categoryname = $getcategory->name;
                    }



                        $sql3 = "SELECT * FROM  webshop_brands WHERE id=:id ";
                        $stmt3 = $db->prepare($sql3);
                        $stmt3->bindParam("id", $product->brands);
                        $stmt3->execute();
                        $getsubcategory = $stmt3->fetchObject();
                if (!empty($getsubcategory)) {
                    $subcategoryname = $getsubcategory->name;
                }


                    $sql1 = "SELECT * FROM webshop_user WHERE id=:id ";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("id", $product->uploader_id);
                    $stmt1->execute();
                    $getUserdetails = $stmt1->fetchObject();
                   // $$price ='';
                    if (!empty($getUserdetails)) {
                        $seller_name = $getUserdetails->fname . ' ' . $getUserdetails->lname;
                        $seller_address = $getUserdetails->address;
                        $seller_phone = $getUserdetails->phone;
                        $email = $getUserdetails->email;
                        $top = $getUserdetails->top_user_vendor;
                        if ($getUserdetails->image != '') {
                            $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
                        } else {
                            $profile_image = SITE_URL . 'webservice/no-user.png';
                        }
                        
                        
                    } else {
                        $profile_image = '';
                    }
                    
                    $sqlnewuser = "SELECT * FROM webshop_user WHERE id=$user_id ";
                        $stmtnewuser = $db->prepare($sqlnewuser);
                        //$stmt1->bindParam("id", $product->uploader_id);
                        $stmtnewuser->execute();
                        $getUserdetails1 = $stmtnewuser->fetchObject();
                        
                        if (!empty($getUserdetails1)) {
                             
                                $userselected_currency = $getUserdetails1->currency_preference;
                            $sqlcurrency = "SELECT * FROM webshop_currency_rates WHERE currency_code != 'USD' AND currency_code ='$getUserdetails1->currency_preference' ";
                        $stmtcurrency = $db->prepare($sqlcurrency);
                       // $stmt1->bindParam("id", $product->uploader_id);
                        $stmtcurrency->execute();
                        $getallcurrency = $stmtcurrency->fetchall();
                        //print_r($getallcurrency);exit;
                        if(!empty($getallcurrency)){
                           foreach($getallcurrency as $currency){
                            $price = $product->price * $currency['currency_rate_to_usd'];
                            //echo 'yes';
                        }  
                        }else{
                            $price = $product->price;
                            //echo 'NO';
                        }
                              
                            
                        } else {
                           $price = $product->price;
                        }
                            $product_encoded_id =  urlencode ( base64_encode($product->id));
                    $data['productList'][] = array(
                            "id" => stripslashes($product_encoded_id),
                            "image" => stripslashes($image),
                            "price" => stripslashes($price),
                            "description" => strip_tags(stripslashes($product->description)),
                            "category_name" => $categoryname,
                             "brands" => $subcategoryname,
                            "seller_id" => stripslashes($product->uploader_id),
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            "seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($seller_phone),
                            "productname" => '',
                            "currency_code" => stripslashes($product->currency_code),
                            
                            "top" => stripslashes($top),
                        );
                }
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
        } else {
            $data = array();
            $data['productList'] = array();
            $data['Ack'] = '0';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}


function allShopListing() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';

    $brand = isset($body->brand) ? $body->brand : '';
    $brandListing = isset($body->brandList) ? $body->brandList : '';
    $sellerListing = isset($body->sellerList) ? $body->sellerList : '';
    $selected_value = isset($body->selected_value) ? $body->selected_value : '';
    $amount_min = isset($body->amount_min) ? $body->amount_min : '';
    $amount_max = isset($body->amount_max) ? $body->amount_max : '';

    $gender = isset($body->gender) ? $body->gender : '';
    $breslettype = isset($body->breslettype) ? $body->breslettype : '';
    $year = isset($body->year) ? $body->year : '';
    $preferred_date = isset($body->preferred_date) ? $body->preferred_date : '';

    $country_id = isset($body->country_id) ? $body->country_id : '';
    $state_id = isset($body->state_id) ? $body->state_id : '';
    $city_id = isset($body->city_id) ? $body->city_id : '';
    $keyword = isset($body->keyword) ? $body->keyword : '';
$category = isset($body->category) ? $body->category : '';
$movement = isset($body->movement) ? $body->movement : '';
$shop_id = isset($body->shop_id) ? $body->shop_id : '';
//print_r($body);
//-----------------------------------------------------------

  


        $sql = "SELECT * from webshop_user where type = '2' AND status='1' AND email_verified='1' AND is_admin_approved='1'";
 

   
   
    if ($gender != '') {

        $sql .= " AND `gender`='" . $gender . "' ";
    }
   


    if ($country_id != '') {

        $sql .= " AND country = '" . $country_id . "'";
    }
    if ($state_id != '') {

        $sql .= " AND state = '" . $state_id . "'";
    }
    if ($city_id != '') {

        $sql .= " AND city = '" . $city_id . "'";
    }




    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllshop = $stmt->fetchAll(PDO::FETCH_OBJ);
        //print_r($getAllProducts);exit;

        if (!empty($getAllshop)) {
            foreach ($getAllshop as $shops) {



                        if (!empty($shops)) {
                            

                            if ($shops->image != '') {
                                $profile_image = SITE_URL . 'upload/user_image/' . $shops->image;
                            } else {
                                $profile_image = SITE_URL . 'webservice/no-user.png';
                            }
                        } else {
                            $profile_image = '';
                        }
                        $seller_name = $shops->fname.' '.$shops->lname;
                        $data['allshoplist'][] = array(
                            "id" => stripslashes($shops->id),
                            
                     
                            "seller_image" => $profile_image,
                            "seller_name" => stripslashes($seller_name),
                            //"seller_address" => stripslashes($seller_address),
                            "seller_phone" => stripslashes($shops->phone),
                            "gender" => stripslashes($shops->gender),
                            
                            
                           // "top" => stripslashes($top),
                        );
                    }
                   
        
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
       
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}


function deleteimage() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $filename = isset($body->filename) ? $body->filename : '';

    //$table_name = isset($body->table_name) ? $body->table_name : '';
    $link = $filename;
    $link_array = explode('/',$link);
     $actual_filename = end($link_array);
//echo '<br>';
         $sql = "SELECT * from webshop_user where civilid1 = '$actual_filename' OR civilid2='$actual_filename'";
 
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getAllshop = $stmt->fetchAll();
//        echo '<pre>';
//       print_r($getAllshop);exit;
$sqldelete='';
        if (!empty($getAllshop)) {
            if($getAllshop[0]['civilid1'] == $actual_filename){
               $sqldelete = "UPDATE webshop_user SET civilid1 = ''"; 
            }
            if($getAllshop[0]['civilid2'] == $actual_filename){
               $sqldelete = "UPDATE webshop_user SET civilid2 = ''"; 
            }
            if($sqldelete !=''){
              $stmt1 = $db->prepare($sqldelete);
            $stmt1->execute();  
            }
               
             
            }


            $data['Ack'] = '1';
            $app->response->setStatus(200);
       
    } catch (PDOException $e) {
        print_r($e);
        exit;

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function getgender() {

    $data = array();
$app = \Slim\Slim::getInstance();
        $a[1] = 'Male';
        $a[2] = 'Female';
        $a[3] = 'Unisex';
        
        
        for ($i=1;$i<=3;$i++) {
            
            $allbrand[] = array(
                'id' => stripslashes($i),
                "name" => $a[$i],
                
            );
        }

        $data['genderlist'] = $allbrand;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    

    $app->response->write(json_encode($data));
}

function get_total_normaluser() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sql = "SELECT * FROM webshop_user WHERE type='1' and status = '1' and email_verified='1'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
       // $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);

       $count = $stmt->rowCount();
       if($count > 0){

        $data['normaluserlist'] = $count;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
       }else{
          $data['normaluserlist'] = 0;
        $data['Ack'] = '1';
        $app->response->setStatus(200); 
       }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function get_total_reviews() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $db = getConnection();

    try {

        $sql = "SELECT * FROM webshop_reviews WHERE userid='$user_id' ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
       // $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);

       $count = $stmt->rowCount();
       if($count > 0){

        $data['reviewlist'] = $count;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
       }else{
          $data['reviewlist'] = 0;
        $data['Ack'] = '1';
        $app->response->setStatus(200); 
       }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function get_total_product() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $db = getConnection();

    try {

        $sql = "SELECT * FROM webshop_products WHERE uploader_id='$user_id' and type='1' ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
       // $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);

       $count = $stmt->rowCount();
       if($count > 0){

        $data['productlist'] = $count;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
       }else{
          $data['productlist'] = 0;
        $data['Ack'] = '1';
        $app->response->setStatus(200); 
       }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function get_total_auctioned_product() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = isset($body->user_id) ? $body->user_id : '';
    $db = getConnection();

    try {

        $sql = "SELECT * FROM webshop_products WHERE uploader_id='$user_id' and type='2'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
       // $getBrand = $stmt->fetchAll(PDO::FETCH_OBJ);

       $count = $stmt->rowCount();
       if($count > 0){

        $data['auctionlist'] = $count;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
       }else{
          $data['auctionlist'] = 0;
        $data['Ack'] = '1';
        $app->response->setStatus(200); 
       }
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function tomobileverifying() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $otp = isset($body->otp) ? $body->otp : '';
    $user_id=base64_decode($user_id);
    $is_mobile_verified = '1';
    $admin_approve = '0';
    $status = '0';
    $verified_date = date('Y-m-d');


    $sqluser = "SELECT * FROM  webshop_user WHERE id=:user_id ";
    $stmtuser = $db->prepare($sqluser);
    $stmtuser->bindParam("user_id", $user_id);
    $stmtuser->execute();
    $getUserdetails = $stmtuser->fetchObject();

    //$data['Ack'] = 0;
if(!empty($getUserdetails)){
    if($getUserdetails->sms_verify_number == $otp)
    {
    $sql = "UPDATE webshop_user set is_mobile_verified=:is_mobile_verified,verified_date=:verified_date,is_admin_approved=:is_admin_approved,status=:status WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("is_mobile_verified", $is_mobile_verified);
        $stmt->bindParam("verified_date", $verified_date);
        $stmt->bindParam("is_admin_approved", $admin_approve);
        $stmt->bindParam("status", $status);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();

       // $msg = 'Mobile+no+Verified+Successfully.Your+account+is+awaiting+for+the+admin+approval.You+will+be+notified+via+email+once+activated.';
        

       // $sqladmin = "SELECT * FROM webshop_tbladmin WHERE id=1";

       // $stmtttadmin = $db->prepare($sqladmin);
       // $stmtttadmin->execute();
       // $getadmin = $stmtttadmin->fetchObject();
       
        
        $data['Ack'] = '1';
        //$data['msg'] = $msg;


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
       
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }
    
}else{
    $data['Ack'] = '0';
$app->response->setStatus(200);
}
}else{
    $data['Ack'] = '0';
$app->response->setStatus(200);
}

    $app->response->write(json_encode($data));
}

function resend() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
   // $otp = isset($body->otp) ? $body->otp : '';
    $user_id=base64_decode($user_id);
  
    $is_mobile_verified = '1';
    $admin_approve = '0';
    $status = '0';
    $verified_date = date('Y-m-d');


    $sqluser = "SELECT * FROM  webshop_user WHERE id=:user_id ";
    $stmtuser = $db->prepare($sqluser);
    $stmtuser->bindParam("user_id", $user_id);
    $stmtuser->execute();
    $getUserdetails = $stmtuser->fetchObject();
 
    //$data['Ack'] = 0;
if(!empty($getUserdetails)){
    
    
    $country_id= $getUserdetails->country;
        $phone = $getUserdetails->phone;
             $sqlcountrycode = "SELECT * FROM webshop_countries WHERE id='$country_id'";
        $stmtcountrycode = $db->prepare($sqlcountrycode);
        $stmtcountrycode->execute();
        $getCode = $stmtcountrycode->fetchObject();
        $country_code = $getCode->phonecode;
       $smsphoneno = $getCode->phonecode.$phone;
       $smsphoneno = (int)$smsphoneno;
       $smsotopcode=mt_rand(1111,9999);

           // $otpverifylink = "#/mobileverify/" .  base64_encode($lastID);
       $mobilemessage= "Your+Mobile+Verification+Code+Is:+$smsotopcode";
        $smslink ='http://www.kwtsms.com/API/send/?username=gmt24&password=aljassar&sender=KWT-MESSAGE&mobile='.$smsphoneno.'&lang=2&message='.$mobilemessage;
       //$data['smslink']=$smslink;
          
       $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,$smslink);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        
        if (empty($buffer)){
            $data['smsstatus']='0';
        }
        else{
             $data['smsstatus'] ='1';
        }
    $sms_verify_number = $smsotopcode;
    $sql = "UPDATE webshop_user set sms_verify_number=:sms_verify_number WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sms_verify_number", $sms_verify_number);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();

       
        
        $data['Ack'] = '1';
        //$data['msg'] = $msg;


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
       
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }
    

}else{
   
    $data['Ack'] = '0';
$app->response->setStatus(200);
}

    $app->response->write(json_encode($data));
}

function resend1() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
        $phoneno = isset($body->phoneno) ? $body->phoneno : '';

   // $otp = isset($body->otp) ? $body->otp : '';
    //$user_id=base64_decode($user_id);
  
    $is_mobile_verified = '1';
    $admin_approve = '0';
    $status = '0';
    $verified_date = date('Y-m-d');


    $sqluser = "SELECT * FROM  webshop_user WHERE id=:user_id ";
    $stmtuser = $db->prepare($sqluser);
    $stmtuser->bindParam("user_id", $user_id);
    $stmtuser->execute();
    $getUserdetails = $stmtuser->fetchObject();
 
    //$data['Ack'] = 0;
if(!empty($getUserdetails)){
    
    
    $country_id= $getUserdetails->country;
        $phone = $phoneno;
             $sqlcountrycode = "SELECT * FROM webshop_countries WHERE id='$country_id'";
        $stmtcountrycode = $db->prepare($sqlcountrycode);
        $stmtcountrycode->execute();
        $getCode = $stmtcountrycode->fetchObject();
        $country_code = $getCode->phonecode;
       $smsphoneno = $getCode->phonecode.$phone;
       $smsphoneno = (int)$smsphoneno;
       $smsotopcode=mt_rand(1111,9999);

           // $otpverifylink = "#/mobileverify/" .  base64_encode($lastID);
       $mobilemessage= "Your+Mobile+Verification+Code+Is:+$smsotopcode";
        $smslink ='http://www.kwtsms.com/API/send/?username=gmt24&password=aljassar&sender=KWT-MESSAGE&mobile='.$smsphoneno.'&lang=2&message='.$mobilemessage;
       //$data['smslink']=$smslink;
          
       $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,$smslink);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        
        if (empty($buffer)){
            $data['smsstatus']='0';
        }
        else{
             $data['smsstatus'] ='1';
        }
    $sms_verify_number = $smsotopcode;
    $sql = "UPDATE webshop_user set sms_verify_number=:sms_verify_number WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sms_verify_number", $sms_verify_number);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();

       
        
        $data['Ack'] = '1';
        //$data['msg'] = $msg;


        $app->response->setStatus(200);
        $db = null;
    } catch (PDOException $e) {
        $data['last_id'] = '';
        $data['Ack'] = '0';
       
        echo '{"error":{"text":' . $e->getMessage() . '}}';
        $app->response->setStatus(401);
    }
    

}else{
   
    $data['Ack'] = '0';
$app->response->setStatus(200);
}

    $app->response->write(json_encode($data));
}



function userpaymentfortop() {


    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';



    $subscription_id = isset($body->sid) ? $body->sid : '';
    $product_id = isset($body->pid) ? $body->pid : '';
    $name = isset($body->name) ? $body->name : '';
    $email = isset($body->email) ? $body->email : '';
    $phone = isset($body->phone) ? $body->phone : '';
    $loyalty_redeem = isset($body->loyalty_redeem) ? $body->loyalty_redeem : 0;
    $paymentId = base64_encode($subscription_id . '_' . $product_id . '_' . $loyalty_redeem);



    $sqlloyalty = "SELECT * from webshop_user where id=:user_id";
    $stmtloyalty = $db->prepare($sqlloyalty);
    $stmtloyalty->bindParam("user_id", $user_id);
    $stmtloyalty->execute();
    $checkloyalty = $stmtloyalty->fetchObject();







    $sql = "SELECT * from webshop_subscription where id =:subscription_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("subscription_id", $subscription_id);
    $stmt->execute();
    $getSubscriptionValue = $stmt->fetchObject();

    if ($loyalty_redeem != 0) {
        $subscriptionprice = ($getSubscriptionValue->price - $loyalty_redeem);
    } else {
        $subscriptionprice = $getSubscriptionValue->price;
    }
    
//payment gateway

/*    $url = "https://test.myfatoorah.com/pg/PayGatewayService.asmx";

    $user = "testapi@myfatoorah.com"; // Will Be Provided by Myfatoorah
    $password = "E55D0"; // Will Be Provided by Myfatoorah
    $post_string = '<?xml version="1.0" encoding="windows-1256"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
<soap12:Body>
<PaymentRequest xmlns="http://tempuri.org/">
<req>
<CustomerDC>
<Name>' . $name . '</Name>
<Email>' . $email . '</Email>
<Mobile>' . $phone . '</Mobile>
</CustomerDC>
<MerchantDC>
<merchant_code>999999</merchant_code>
<merchant_username>testapi@myfatoorah.com</merchant_username>
<merchant_password>E55D0</merchant_password>
<merchant_ReferenceID>201454542102</merchant_ReferenceID>
<ReturnURL>' . SITE_URL . '#/successUserpaymentTop/' . $paymentId . '/</ReturnURL>
<merchant_error_url>' . SITE_URL . '#/cancel</merchant_error_url>
</MerchantDC>
<lstProductDC>
<ProductDC>
<product_name>Product Upload</product_name>
<unitPrice>' . $subscriptionprice . '</unitPrice>
<qty>1</qty>
</ProductDC>
</lstProductDC>
</req>
</PaymentRequest>
</soap12:Body>
</soap12:Envelope>';
    $soap_do = curl_init();
    curl_setopt($soap_do, CURLOPT_URL, $url);
    curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($soap_do, CURLOPT_POST, true);
    curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length:
' . strlen($post_string)));
    curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password); //User Name, Password To be provided by Myfatoorah
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, array(
        'Content-type: text/xml'
    ));
    $result = curl_exec($soap_do);
    $err = curl_error($soap_do);
//curl_close($soap_do);
//print_r($result);exit;   
    $file_contents = htmlspecialchars(curl_exec($soap_do));
    curl_close($soap_do);
    $doc = new DOMDocument();
    $doc->loadXML(html_entity_decode($file_contents));
//echo $doc;exit;
    $ResponseCode = $doc->getElementsByTagName("ResponseCode");
    $ResponseCode = $ResponseCode->item(0)->nodeValue;
//echo $ResponseCode;exit;
    $ResponseMessage = $doc->getElementsByTagName("ResponseMessage");
    $ResponseMessage = $ResponseMessage->item(0)->nodeValue;
//echo $ResponseMessage;exit;
    if ($ResponseCode == 0) {
        $paymentUrl = $doc->getElementsByTagName("paymentURL");
        $paymentUrl = $paymentUrl->item(0)->nodeValue;
//echo $paymentUrl;exit;

        /* $OrderID = $doc->getElementsByTagName("OrderID");
          $OrderID = $OrderID->item(0)->nodeValue;
          $Paymode = $doc->getElementsByTagName("Paymode");
          $Paymode = $Paymode->item(0)->nodeValue;
          $PayTxnID = $doc->getElementsByTagName("PayTxnID");
          $PayTxnID = $PayTxnID->item(0)->nodeValue;
         */
 /*   }*/
//end

    $paymentUrl= SITE_URL . '#/successUserpaymentTop/' . $paymentId.'/123';
    if ($loyalty_redeem > $checkloyalty->total_loyalty) {

        $data['Ack'] = 2;
    }else if($subscriptionprice == 0){
        
        $data['url'] = SITE_URL . '#/successUserpaymentTop/' . $paymentId.'/123';
        $data['Ack'] = 1;
        
    } else {

        $data['url'] = $paymentUrl;
        $data['Ack'] = 1;
    }
    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}


function adduserproducttop() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();
    $encodeid = base64_decode($body->return_id);
    $user_id = isset($body->user_id) ? $body->user_id : '';


    $array_id = explode('_', $encodeid);


    $subscription_id = isset($array_id[0]) ? $array_id[0] : '';
    $product_id = isset($array_id[1]) ? $array_id[1] : '';
    $loyalty_point = isset($array_id[2]) ? $array_id[2] : 0;

//$name = isset($body->name) ? $body->name : '';
//$email = isset($body->email) ? $body->email : '';
//$phone = isset($body->phone) ? $body->phone : '';
//payment gateway
//end



    $sql3 = "SELECT * from webshop_subscription where id =:subscription_id";
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam("subscription_id", $subscription_id);
    $stmt3->execute();
    $getSubscriptionDetails = $stmt3->fetchObject();



    $sql4 = "INSERT INTO  webshop_subscribers (user_id,subscription_id,price,subscription_date,expiry_date,transaction_id) VALUES (:user_id,:subscription_id,:price,:subscription_date,:expiry_date,:transaction_id)";


    $days = $getSubscriptionDetails->duration;
    $date = date('Y-m-d');
    $cdate = date_create($date);
    date_add($cdate, date_interval_create_from_date_string("$days days"));
    $expiry_date = date_format($cdate, "Y-m-d");
    $transaction_id = "pay-12376";


    $stmt4 = $db->prepare($sql4);
    $stmt4->bindParam("user_id", $user_id);
    $stmt4->bindParam("subscription_id", $subscription_id);
    $stmt4->bindParam("price", $getSubscriptionDetails->price);
    $stmt4->bindParam("subscription_date", $date);
    $stmt4->bindParam("expiry_date", $expiry_date);
    $stmt4->bindParam("transaction_id", $transaction_id);
//$stmt4->bindParam("product_id", $product_id);
    $stmt4->execute();
    $lastID = $db->lastInsertId();

    $sqlproductupdate = "UPDATE webshop_products SET status=1, top_product=:subscription_id,top_product_status=1 WHERE id=:pid";
    $stmtproduct = $db->prepare($sqlproductupdate);
    $stmtproduct->bindParam("subscription_id", $lastID);
    $stmtproduct->bindParam("pid", $product_id);
    $stmtproduct->execute();


    $sql6 = "SELECT * from webshop_user where id=:user_id ";
    $stmt6 = $db->prepare($sql6);
    $stmt6->bindParam("user_id", $user_id);
    $stmt6->execute();
    $is_user = $stmt6->fetchObject();




    if ($loyalty_point != 0) {
        $total_loyalty = ($is_user->total_loyalty - $loyalty_point);
    } else {
        $total_loyalty = 0;
    }

    $sql = "UPDATE  webshop_user SET total_loyalty = :loyalty WHERE id=:user_id ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("loyalty", $total_loyalty);
    $stmt->bindParam("user_id", $user_id);
    $stmt->execute();

    if ($loyalty_point != 0) {
        $date = date('Y-m-d');
        $type = 1;
        $sql = "INSERT INTO  webshop_user_loyaliety (pay_amount, user_id,point,add_date,type) VALUES (:pay_amount, :user_id,:point,:date,:type)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("pay_amount", $getSubscriptionDetails->price);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("point", $loyalty_point);
        $stmt->bindParam("date", $date);
        $stmt->bindParam("type", $type);
        $stmt->execute();
    }






   /* $sql5 = "SELECT free_bid,free_bid_status from webshop_sitesettings where id = 1";
    $stmt5 = $db->prepare($sql5);
    $stmt5->execute();
    $getfree = $stmt5->fetchObject();

    $free_product = $getfree->free_bid;
    $free_status = $getfree->free_bid_status;*/

   // if ($free_product != 0 && $free_status==1) {

        //$msg = "Your Payment completed successfully. Your product is live now. Upload " . $free_product . "  product and get one product upload free.";
   // } else {
        $msg = "Your Payment completed successfully. Your product is Top product now.";
    //}

    $data['subscription_id'] = $subscription_id;
    $data['Ack'] = 1;
    $data['msg'] = $msg;
    $app->response->setStatus(200);


    $app->response->write(json_encode($data));
}


function currency_rates() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $sqluser = "SELECT * FROM  webshop_currency";
    $stmtuser = $db->prepare($sqluser);
    $stmtuser->execute();
    $getCurrencydetails = $stmtuser->fetchAll(PDO::FETCH_OBJ);
 
    //$data['Ack'] = 0;
if(!empty($getCurrencydetails)){
    
  
        foreach($getCurrencydetails as $currency){
            $smslink ='http://free.currencyconverterapi.com/api/v5/convert?q=USD_'.$currency->code.'&compact=y';
            $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,$smslink);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $amount = curl_exec($curl_handle);
        curl_close($curl_handle);
        
        if (empty($amount)){
           $sql = "UPDATE webshop_currency_rates set currency_rate_to_usd='$amount' WHERE currency_code='$currency->code'";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute();
        } 
        
    

}else{
   
    $data['Ack'] = '0';
$app->response->setStatus(200);
}

    $app->response->write(json_encode($data));
}

function getproductpictures() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    try {

        $sqlspecialauction = "SELECT * from webshop_products where is_special_auction = '1' ORDER BY RAND() LIMIT 1";
        $stmtspecialauction = $db->prepare($sqlspecialauction);
        $stmtspecialauction->execute();
        $getSpecialauction = $stmtspecialauction->fetchObject();
           if(!empty($getSpecialauction)){
              
                   if ($getSpecialauction->image != '') {
                    $imageSpecialauction = SITE_URL . 'upload/product_image/' . $getSpecialauction->image;
                } else {
                    $imageSpecialauction = SITE_URL . 'app/assets/images/new-collection/itm1.png';
                } 
              
              
           } else {
                    $imageSpecialauction = SITE_URL . 'app/assets/images/new-collection/itm1.png';
                }
             
        
        $sqltopmodel = "SELECT * from webshop_products where is_top_model = '1' ORDER BY RAND() LIMIT 1";
        $stmttopmodel = $db->prepare($sqltopmodel);
        $stmttopmodel->execute();
        $getTopmodel = $stmttopmodel->fetchObject();
        //print_r($getTopmodel);exit;
        if(!empty($getTopmodel)){
               
                  if ($getTopmodel->image != '') {
                    $imagetopmodel = SITE_URL . 'upload/product_image/' . $getTopmodel->image;
                } else {
                    $imagetopmodel = SITE_URL . 'app/assets/images/new-collection/itm3.png';
                } 
              
              
           }else {
                    $imagetopmodel = SITE_URL . 'app/assets/images/new-collection/itm3.png';
                } 
       
        
        $sqlwomenwatch = "SELECT * from webshop_products where gender = 'Female' ORDER BY RAND() LIMIT 1";
        $stmtwomenwatch = $db->prepare($sqlwomenwatch);
        $stmtwomenwatch->execute();
        $getWomenwatch = $stmtwomenwatch->fetchObject();
        if(!empty($getWomenwatch)){
               
                   if ($getWomenwatch->image != '') {
                    $imageWomenwatch = SITE_URL . 'upload/product_image/' . $getWomenwatch->image;
                } else {
                    $imageWomenwatch = SITE_URL . 'app/assets/images/new-collection/itm4.png';
                } 
               
              
           }else {
                    $imageWomenwatch = SITE_URL . 'app/assets/images/new-collection/itm4.png';
                } 
        
        $sqlcertifieduser = "SELECT * from webshop_user where top_user_vendor = '1'";
        $stmtcertifieduser = $db->prepare($sqlcertifieduser);
        $stmtcertifieduser->execute();
        $getCertifieduser = $stmtcertifieduser->fetchObject();
        
       
        $sqlcertifieduserimage = "SELECT * from webshop_products where uploader_id = '$getCertifieduser->id'";
        $stmtcertifieduserimage = $db->prepare($sqlcertifieduserimage);
        $stmtcertifieduserimage->execute();
        $certifieduserimage = $stmtcertifieduserimage->fetchObject();
          if(!empty($certifieduserimage)){
               
                   if ($certifieduserimage->image != '') {
                    $imageCertifiedwatch = SITE_URL . 'upload/product_image/' . $certifieduserimage->image;
                } else {
                    $imageCertifiedwatch = SITE_URL . 'app/assets/images/new-collection/itm4.png';
                } 
               
              
           }else {
                    $imageCertifiedwatch = SITE_URL . 'app/assets/images/new-collection/itm4.png';
                } 

        $data['imageSpecialauction'] = $imageSpecialauction;
        $data['imagetopmodel'] = $imagetopmodel;
        $data['imageWomenwatch'] = $imageWomenwatch;
        $data['imageCertifiedwatch'] = $imageCertifiedwatch;
        $data['Ack'] = '1';
        $app->response->setStatus(200);
    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['imageSpecialauction'] = '';
        $data['imagetopmodel'] = '';
        $data['imageWomenwatch'] = '';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}







$app->run();
?>