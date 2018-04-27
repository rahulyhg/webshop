<?php

//error_reporting(1);
require_once("class/class.phpmailer.php");
require 'vendor/autoload.php';

require 'config.php';
include('routs.php');
include('crud.php');
//include('Stripe.php');

date_default_timezone_set('UTC');

function get_lat_long($address) {
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
}

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
    $type = isset($body->type) ? $body->type : '';
    $add_date = date('Y-m-d');


    $db = getConnection();

    $sql = "SELECT * FROM  webshop_user WHERE  email=:email OR phone=:phone";
    $stmt = $db->prepare($sql);

    $stmt->bindParam("email", $email);
    $stmt->bindParam("phone", $phone);
    $stmt->execute();
    $usersCount = $stmt->rowCount();

    if ($usersCount == 0) {

        $newpass = md5($password);
        //$status=1;

        $sql = "INSERT INTO  webshop_user (fname,lname, email, password, type, device_type, device_token_id, add_date, address, my_latitude,my_longitude,city,phone) VALUES (:fname,:lname, :email, :password, :type, :device_type, :device_token_id, :add_date, :address, :my_latitude, :my_longitude, :city, :phone)";
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

            $actual_link = "http://111.93.169.90/team1/webshop/#/emailverify/" . $lastID;
            $MailFrom = 'webshop.com';
            $subject = "webshop.com- Thank you for registering";

            $TemplateMessage = "Welcome and thank you for registering at webshop.com!<br />";
            $TemplateMessage .= "Your account has now been created and you can login using your email address and password by visiting our App<br />";
            $TemplateMessage .= "<br/>Click this link to verify your email <a href='" . $actual_link . "'>" . $actual_link . "</a><br/>";
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "webshop.com<br />";


            $mail = new PHPMailer(true);

            $IsMailType = 'SMTP';

            $MailFrom = 'palashsaharana@gmail.com';    //  Your email password

            $MailFromName = 'Webshop';
            $MailToName = '';

            $YourEamilPassword = "lsnspyrcimuffblr";   //Your email password from which email you send.
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
                /* mail to admin start */

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

                    $MailFrom = 'palashsaharana@gmail.com';    //  Your email password

                    $MailFromName = 'Webshop';
                    $MailToName = '';

                    $YourEamilPassword = "lsnspyrcimuffblr";   //Your email password from which email you send.
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
                    /* mail to admin ends here */
                }
            }

            $data['Ack'] = '1';
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
                    "user_image" => stripslashes($user_image)
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

        $MailFrom = 'palashsaharana@gmail.com';    //  Your email password

        $MailFromName = 'Webshop';
        $MailToName = '';

        $YourEamilPassword = "lsnspyrcimuffblr";   //Your email password from which email you send.
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
        $app->response->setStatus(200);
        $data['msg'] = 'Password updated successfully';
    } catch (PDOException $e) {
        $data['Ack'] = 0;
        $app->response->setStatus(200);
        $data['msg'] = 'Password updation error';
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


    $latlang = get_lat_long($address);
    //print_r($latlang);
    $val = implode(',', $latlang);
    $value = explode(',', $val);
    $lat = $value[0];
    $lang = $value[1];

    // $lat;
    // echo $lang;
    // exit;
    // $dob = date("Y-m-d", strtotime($dob));


    $date = date('Y-m-d');


    $sql = "UPDATE webshop_user set fname=:fname,lname=:lname ,secret_key=:secret_key,publish_key=:publish_key,email=:email,address=:address,phone=:phone,gender=:gender,business_type=:business_type,my_latitude=:lat,my_longitude=:lang WHERE id=:id";
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

        $stmt->bindParam("id", $user_id);

        $stmt->execute();





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
            "add_date" => stripslashes($getUserdetails->add_date));


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
    $user_id = isset($body->user_id) ? $body->user_id : '';

    $sql = "SELECT * from  webshop_products WHERE id=:id order by id desc";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $product_id);
    $stmt->execute();
    $product = $stmt->fetchObject();

    if (!empty($product)) {



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


        $sqlbid = "SELECT MAX(bidprice) as maxbid FROM webshop_biddetails WHERE userid=:userid AND productid=:productid";
        $stmtbid = $db->prepare($sqlbid);
        $stmtbid->bindParam("userid", $user_id);
        $stmtbid->bindParam("productid", $product_id);
        $stmtbid->execute();
        $naxbid = $stmtbid->fetchObject();
        $count = $stmtproduct->rowCount();


        $data['productList'] = array(
            "id" => stripslashes($product->id),
            "image" => stripslashes($image),
            "price" => stripslashes($product->price),
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
            "productname" => stripslashes($product->name),
            "baseauctionprice" => stripslashes($product->baseauctionprice),
            "thresholdprice" => stripslashes($product->thresholdprice),
            "nextbidprice" => stripslashes($product->nextbidprice),
            "lastbidvalue" => stripslashes($product->lastbidvalue),
            "uploader_id" => stripslashes($product->uploader_id),
            "type" => stripslashes($product->type),
            "preferred_date" => stripslashes($product->preferred_date),
            "bidcount" => $count,
            "maxbid" => $naxbid->maxbid
                // "special_price"=>stripslashes($product->special_price),
                // "auction_start_date"=>stripslashes($product->auction_start_date),
                // "auction_end_date"=>stripslashes($product->auction_end_date)
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
        $data['Ack'] = '0';
        $data['msg'] = 'Already Added in your wishlist';
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
                "pro_name" => stripslashes($productdetails->name),
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
                "product_name" => stripslashes($auctioned->name),
                "product_description" => strip_tags(stripslashes($auctioned->description)),
                "product_image" => stripslashes($product_image),
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

            $launchedproductList[] = array(
                "product_id" => stripslashes($launched->id),
                "product_name" => stripslashes($launched->name),
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

        foreach ($getCategory as $category) {

            $allcategory[] = array(
                "id" => stripslashes($category->id),
                "name" => stripslashes($category->name)
            );
        }

        $data['categorylist'] = $allcategory;
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

        $sql = "SELECT * from webshop_subcategory where category_type = '" . $cat_id . "' and status=1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getSubcategory = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getSubcategory as $subcategory) {


            $allsubcategory[] = array(
                "cat_id" => stripslashes($subcategory->category_type),
                "subcat_id" => stripslashes($subcategory->id),
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

        $sql = "SELECT * from webshop_currency where 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getCurrency = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getCurrency as $currency) {

            $allcurrency[] = array(
                "id" => stripslashes($currency->id),
                "name" => stripslashes($currency->name),
                "code" => stripslashes($currency->code),
                "symbol" => stripslashes($currency->symbol),
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
    //$type = $body->type;

    try {

        $sql = "SELECT * FROM webshop_order WHERE user_id=:user_id  order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $userid);
        //$stmt->bindParam("type", $type);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $orders) {




                /* 15 feb 2018 kalyan start */

                $sql1 = "SELECT * FROM webshop_bookings WHERE orderid='" . $orders->id . "' ORDER BY id ASC LIMIT 1";
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




                // $prolist[] = array(
                // "pro_id" => stripslashes($prolst->id),
                // "pro_name" => stripslashes($prolst->name),
                // "pro_image" => $pro_image,
                // "full_name" => stripslashes($usrlst->full_name),
                // "email" => stripslashes($usrlst->email),
                // "image" => stripslashes($user_image),
                // "address" => stripslashes($usrlst->address),
                // "phone" => stripslashes($usrlst->phone),
                // "status" => stripslashes($usrlst->status),
                // 
                //);

                $sql3 = "SELECT * FROM webshop_bookings WHERE orderid='" . $orders->id . "'";
                $stmt3 = $db->prepare($sql3);
                $stmt3->execute();
                $orderlst = $stmt3->fetchObject();
                $count = $stmt3->rowCount();



                /* 15 feb 2018 kalyan end  */

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




    //}

    /* else{

      $data['Ack'] = 2;
      $data['msg'] = 'No Driver Available';
      $app->response->setStatus(200);

      } */






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


                if ($getFromUserdetails->image != '') {
                    $profile_image = SITE_URL . 'upload/user_image/' . $getFromUserdetails->image;
                } else {
                    $profile_image = SITE_URL . 'webservice/no-user.png';
                }

                $get_name = $getFromUserdetails->fname . " " . $getFromUserdetails->lname;
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
                "date" => stripslashes($notificationUserdetails->date),
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

        foreach ($getBrand as $brand) {

            $allbrand[] = array(
                "id" => stripslashes($brand->id),
                "name" => stripslashes($brand->name)
            );
        }

        $data['brandlist'] = $allbrand;
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
    //$subcategory = isset($body["subcat_id"]) ? $body["subcat_id"] : '';
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
    $status = isset($body["status"]) ? $body["status"] : '';
    $owner_number = isset($body["owner_number"]) ? $body["owner_number"] : '';
    $country = isset($body["country"]) ? $body["country"] : '';
    $size = isset($body["size"]) ? $body["size"] : '';
    $location = isset($body["location"]) ? $body["location"] : '';
    $work_hours = isset($body["work_hours"]) ? $body["work_hours"] : '';
    $model_year = isset($body["model_year"]) ? $body["model_year"] : '';
    $breslet_type = isset($body["breslet_type"]) ? $body["breslet_type"] : '';
    $time_slot_id = isset($body["time_slot_id"]) ? $body["time_slot_id"] : '';
    $get_status = '0';
    // $baseauctionprice = isset($body["baseauctionprice"]) ? $body["baseauctionprice"] : '';
    //$thresholdprice = isset($body["thresholdprice"]) ? $body["thresholdprice"] : '';

    /* conversion of date format starts */

    $date_of_purchase1 = str_replace('/', '-', $date_of_purchase2);
    $date_of_purchase = date('Y-m-d', strtotime($date_of_purchase1 . "+1 days"));
    $preferred_date1 = str_replace('/', '-', $preferred_date2);
    // $preferred_date = date('Y-m-d', strtotime($preferred_date1 . "+1 days"));
    $preferred_date = $preferred_date2;
    //print_r($body);
    //exit;
    /* conversion of date format ends */

    $date = date("Y-m-d");

    $db = getConnection();



    $sqlsubscription = "SELECT ws.id,wu.id,ws.expiry_date,wu.slot_no FROM webshop_subscribers as ws inner join webshop_user as wu on wu.id=ws.user_id where ws.user_id=:user_id order by ws.id desc limit 1";
    $stmt = $db->prepare($sqlsubscription);
    $stmt->bindParam("user_id", $user_id);
    //$stmt->bindParam("current_date", $date);
    $stmt->execute();
    $getUserDetails = $stmt->fetchObject();


    if ($getUserDetails->expiry_date >= $date) {

        if ($getUserDetails->slot_no > 0) {

            if ($type == '1') {

                $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,location,work_hours,status) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:location,:work_hours,:status)";
            } else {

                $sql = "INSERT INTO webshop_products (uploader_id, cat_id,currency_code,type,name, description, price, add_date,quantity,brands,movement,gender,reference_number,date_purchase,status_watch,owner_number,country,size,preferred_date,location,work_hours,status,breslet_type,model_year,time_slot_id) VALUES (:user_id, :cat_id, :currency_code, :type, :name, :description, :price, :add_date,:quantity,:brand,:movement,:gender,:reference_number,:date_purchase,:status_watch,:owner_number,:country,:size,:preferred_date,:location,:work_hours,:status,:breslet_type,:model_year,:time_slot_id)";
            }



            try {

                $db = getConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("cat_id", $category);
                //$stmt->bindParam("subcat_id", $subcategory);
                $stmt->bindParam("name", $name);
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
                $stmt->bindParam("status_watch", $status);
                $stmt->bindParam("owner_number", $owner_number);
                $stmt->bindParam("country", $country);
                $stmt->bindParam("size", $size);
                if ($type == '2') {

                    $stmt->bindParam("preferred_date", $preferred_date);
                    $stmt->bindParam("breslet_type", $breslet_type);
                    $stmt->bindParam("model_year", $model_year);
                    $stmt->bindParam("time_slot_id", $time_slot_id);
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

                $stmt->bindParam("location", $location);
                $stmt->bindParam("work_hours", $work_hours);
                $stmt->bindParam("status", $get_status);
                $stmt->execute();

                $lastID = $db->lastInsertId();


                $rest_slot = (($getUserDetails->slot_no) - 1);
                $sqlslotupdate = "UPDATE webshop_user SET slot_no=:slot WHERE id=:user_id";
                $stmtslot = $db->prepare($sqlslotupdate);
                $stmtslot->bindParam("slot", $rest_slot);
                $stmtslot->bindParam("user_id", $user_id);
                $stmtslot->execute();

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


                $data['Ack'] = 1;
                $data['msg'] = 'Product added successfully.';
                $data['type'] = $type;
                //print_r($data);
                //exit;
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


    $verified_date = date('Y-m-d');


    $sql = "UPDATE webshop_user set email_verified=:email_verified,verified_date=:verified_date WHERE id=:id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email_verified", $email_verified);
        $stmt->bindParam("verified_date", $verified_date);
        $stmt->bindParam("id", $user_id);

        $stmt->execute();


        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Email Verified Successfully.Your account is awaiting for the admin approval.You will be notified via email once activated.';


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

function auctionapproval() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $product_id = isset($body->product_id) ? $body->product_id : '';
    $bid = isset($body->bid) ? $body->bid : '';
    $preferred_date2 = isset($body->preferred_date) ? $body->preferred_date : '';
    $comments = isset($body->comments) ? $body->comments : '';

    $preferred_date1 = str_replace('/', '-', $preferred_date2);
    $preferred_date = date('Y-m-d', strtotime($preferred_date1 . "+1 days"));

    $type = '2';

    $sql = "UPDATE webshop_products set type=:type,minimum_bid=:minimum_bid,preferred_date=:preferred_date,comments=:comments WHERE id=:product_id";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("type", $type);
        $stmt->bindParam("minimum_bid", $bid);
        $stmt->bindParam("preferred_date", $preferred_date);
        $stmt->bindParam("comments", $comments);
        $stmt->bindParam("product_id", $product_id);

        $stmt->execute();


        $data['Ack'] = '1';
        $data['msg'] = 'Send For Auction successfully';


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

function interestedEmailToVendor() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $seller_id = $body->seller_id;
    $user_id = $body->user_id;
    $product_id = $body->product_id;

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

    $TemplateMessage = "Hello " . $getUserdetails->fname . ",<br /><br / >";
    $TemplateMessage .= $user . " is interested in your product " . $getproductdetails->name . " <br />";

    $TemplateMessage .= "<br /><br />Thanks,<br />";
    $TemplateMessage .= "webshop.com<br />";


    $mail = new PHPMailer(true);

    $IsMailType = 'SMTP';

    $MailFrom = 'palashsaharana@gmail.com';    //  Your email password

    $MailFromName = 'Webshop';
    $MailToName = '';

    $YourEamilPassword = "lsnspyrcimuffblr";   //Your email password from which email you send.
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

    /* Notification to the seller start */
    $message = $user . " is interested in your product " . $getproductdetails->name . "";
    $sqlFriend = "INSERT INTO webshop_notification (from_id, to_id, msg, is_read,last_id) VALUES (:from_id, :to_id, :msg, :is_read,:last_id)";

    $is_read = '0';
    $last_id = '0';
    $from_id = '0';
    //$message = 'New auction added';
    //$type = '2';
    $stmttt = $db->prepare($sqlFriend);
    $stmttt->bindParam("from_id", $user_id);
    $stmttt->bindParam("to_id", $seller_id);
    //$stmttt->bindParam("type", $type);
    $stmttt->bindParam("msg", $message);

    $stmttt->bindParam("last_id", $last_id);
    $stmttt->bindParam("is_read", $is_read);
    $stmttt->execute();
    /* Notification to the seller end */

    $db = null;
    $data['Ack'] = '1';
    $data['msg'] = 'Mail Send Successfully';
    $app->response->setStatus(200);



    $app->response->write(json_encode($data));
}

function auctionFeesAdvancePayment() {
    // echo "Hello Puja";
    // exit;
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $notificationType = isset($body->notificationType) ? $body->notificationType : '';
    $auctionId = isset($body->auctionId) ? $body->auctionId : '';
    $auction_fee_paid = '1';

    $verified_date = date('Y-m-d');


    $sql = "UPDATE webshop_products set auction_fee_paid=:auction_fee_paid WHERE id=:auctionId";
    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("auctionId", $auctionId);
        $stmt->bindParam("auction_fee_paid", $auction_fee_paid);
        $stmt->execute();

        $data['Ack'] = '1';
        $data['msg'] = 'Payment has been paid successfully.Wait for the admin to make your product GO LIVE.';


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

    $db = getConnection();

    try {

        $sql = "SELECT * from webshop_subscription where status = 1";
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

function addUserSubscription() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = ($request->post());
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';
    $subscription_id = isset($body->subscription_id) ? $body->subscription_id : '';

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



    $sql = "UPDATE  webshop_user SET subscription_id=:subscription_id,slot_no=:slot_no WHERE id=:user_id";
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

    //print_r($body);

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


        $sql = "SELECT * from webshop_products where status = 1 and type='2' and uploader_id !='" . $user_id . "' and id IN(" . $productIds . ")";
    } else {


        $sql = "SELECT * from  webshop_products where status=1 and type='2'  and uploader_id !='" . $user_id . "'";
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

function listshops() {

    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $db = getConnection();

    $user_id = isset($body->user_id) ? $body->user_id : '';


    try {

        if ($user_id == '' || $user_id == 'undefined') {

            $sql = "SELECT * from webshop_user where business_type = '2'";
        } else {
            $sql = "SELECT * from webshop_user where business_type = '2' and id!='" . $user_id . "'";
        }


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

    $userid = isset($body->userid) ? $body->userid : '';
    $productid = isset($body->productid) ? $body->productid : '';
    $bidprice = isset($body->bidprice) ? $body->bidprice : '';
    $nextbidprice = isset($body->nextbidprice) ? $body->nextbidprice : '';
    $uploaderid = isset($body->uploaderid) ? $body->uploaderid : '';

    $sql = "INSERT INTO  webshop_biddetails (userid,productid,bidprice,nextbidprice,uploaderid) VALUES (:userid,:productid,:bidprice,:nextbidprice,:uploaderid)";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("userid", $userid);
    $stmt->bindParam("productid", $productid);
    $stmt->bindParam("bidprice", $bidprice);
    $stmt->bindParam("nextbidprice", $nextbidprice);
    $stmt->bindParam("uploaderid", $uploaderid);
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


        foreach ($getDate as $brand) {
            $date = explode('-', stripslashes($brand->date));
            $datefordatepicker = $date[0] . '/' . $date[1] . '/' . $date[2];

            $allbrand[] = array(
                stripslashes($datefordatepicker)
            );
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



            $sqlexsits = "SELECT * FROM  webshop_products WHERE  preferred_date =:acutondate and time_slot_id=:time";
            $db = getConnection();
            $stmt = $db->prepare($sqlexsits);
            $stmt->bindParam("acutondate", $acutondate);
            $stmt->bindParam("time", $val);
            $stmt->execute();
            $bookeddatetime = $stmt->fetchAll(PDO::FETCH_OBJ);


            foreach ($bookeddatetime as $btime) {
                $data['btime'][] = (stripslashes($btime->time_slot_id));
            }






            $sql1 = "SELECT * FROM  webshop_auctiontimes WHERE  id =:timeid";
            $stmt23 = $db->prepare($sql1);
            $stmt23->bindParam("timeid", $val);
            $stmt23->execute();
            $gettime = $stmt23->fetchAll(PDO::FETCH_OBJ);

            foreach ($gettime as $time) {

                if (!empty($data['btime'])) {
                    $date = in_array($time->id, $data['btime']);
                    if ($date) {
                        $data['time'][] = array(
                            "id" => stripslashes($time->id),
                            "start_time" => date('h:s:i A', strtotime($time->start_time)),
                            "end_time" => date('h:s:i A', strtotime($time->end_time)),
                            "status" => 1,
                        );
                    } else {

                        $data['time'][] = array(
                            "id" => stripslashes($time->id),
                            "start_time" => date('h:s:i A', strtotime($time->start_time)),
                            "end_time" => date('h:s:i A', strtotime($time->end_time)),
                            "status" => 0,
                        );
                    }
                } else {
                    $data['time'][] = array(
                        "id" => stripslashes($time->id),
                        "start_time" => date('h:s:i A', strtotime($time->start_time)),
                        "end_time" => date('h:s:i A', strtotime($time->end_time)),
                        "status" => 0,
                    );
                }
            }
        }
    }



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

            $data['UserDetails'][] = array(
                "userid" => stripslashes($auction->userid),
                "productid" => stripslashes($auction->productid),
                "bidprice" => stripslashes($auction->bidprice),
                "uploaderid" => stripslashes($auction->uploaderid),
                "user_name" => stripslashes($getUserdetails->fname)
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
        //print_r($data);

        $data['allproduct'] = $allproduct;
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

$app->run();
?>