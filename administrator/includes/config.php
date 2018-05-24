$<?php
error_reporting(1);
include('../../lang/en.php');
define('SITE_URL', 'http://localhost/webshop1/webshop/');
define('BASE_URL', 'http://localhost/webshop1/webshop/');
define('TWILO_SID', 'AC192d5c3baa6e3d81e3dc00d759413867');
define('TWILO_TOKEN', 'ff24340d02dec1e794fde914b315a4de');
define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('BASE_URL', 'http://localhost/webshop1/webshop/');
define('CHARGE', 1.99);
define('STRIPE_CHARGE', 199);
define('TESTMODE', 'on');
define('PRIVATETESTKEY', 'sk_test_5K401tpKS27cCLjkYe3LTXCv');
define('PUBLICTESTKEY', 'pk_test_avhCsvHAaou7xWu7SxVCzptC');
define('PRIVATELIVEKEY', 'sk_live_p3BLF5YDVg8MnANEvgeoiJTl');
define('PUBLICLIVEKEY', 'pk_live_8QQZMuYIed1mZh84aFVGxOUS');

if ($_SESSION['lang'] == 'Spanish') {
    include('lang/sp.php');
} else {
    include('lang/en.php');
}


//$link = mysql_connect("localhost", "globalit_malik", "Host!@#$%^") or die("Error in Connection. Check Server Configuration.");
//mysql_select_db("globalit_malik", $link) or die("Database not Found. Please Create the Database.");
//$link = mysql_connect("localhost", "root", "Host@2017") or die("Error in Connection. Check Server Configuration.");
//mysql_select_db("roomrent", $link) or die("Database not Found. Please Create the Database.");

$con = mysqli_connect("localhost", "root", "root", "webshop");


if (mysqli_connect_errno()) {
    echo "Failed to the connect to MySQL: " . mysqli_connect_error();
}

//$site_settings = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `malik_sitesettings` WHERE id='1'"));

$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SESSION['lat'])) {
    if ($_SESSION['lat'] == '') {
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        $loc = explode(',', $details->loc);

        $_SESSION['lat'] = $loc[0];
        $_SESSION['long'] = $loc[1];
    }
} else {
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    $loc = explode(',', $details->loc);

    $_SESSION['lat'] = $loc[0];
    $_SESSION['long'] = $loc[1];
}

function get_client_ip_env() {

    $ipaddress = '';

    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');

    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');

    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');

    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');

    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');

    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';



    return $ipaddress;
}

function distance($lat1, $lng1, $lat2, $lng2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);



    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    $uid = $_SESSION['user_id'];
    $email_verified_ss = "select * from `makeoffer_user` WHERE `id`='$uid' AND `email_verified`='1'";
    $email_verified_qq = mysqli_query($con, $email_verified_ss);
    $email_verified_num = mysqli_num_rows($email_verified_qq);
    if (!$email_verified_num) {
        $pg_name = basename($_SERVER['PHP_SELF']);
        if ($pg_name != 'email-verify.php') {
            header('Location: email-verify.php?action=not_verified');
            exit();
        }
    }
}
?>