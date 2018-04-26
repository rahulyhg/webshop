<?php
require_once("includes/class.phpmailer.php");
require 'vendor/autoload.php';

include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
if (isset($_REQUEST['id'])) {
    $pid = $_REQUEST['id'];
    $sql2 = "SELECT * FROM `webshop_emailtemplate` where id='" . $pid . "'";
    $res = mysqli_query($con, $sql2);
    $row12 = mysqli_fetch_array($res);
}

if (isset($_REQUEST['submit'])) {

    $default_language = isset($_POST['default_language']) ? $_POST['default_language'] : '';
    $email_content = isset($_POST['elm1']) ? $_POST['elm1'] : '';

    $send_email = mysqli_query($con, "SELECT * from webshop_user where default_language='" . $default_language . "'");


    $resultset = array();
    while ($usersAllData = mysqli_fetch_array($send_email)) {
        $resultset[] = $usersAllData;
    }



    foreach ($resultset as $result) {
        //echo $result['email'];


        $MailTo = $result['email'];

        $MailFrom = 'info@webshop.com';
        $subject = "webshop.com- Mailing Form";

        $TemplateMessage = $email_content;


        $mail = new PHPMailer(true);

        $IsMailType = 'SMTP';

        $MailFrom = 'arunavaguha@natitsolved.com';    //  Your email password

        $MailFromName = 'Webshop Watches';
        $MailToName = '';

        $YourEamilPassword = "arunavaguha@9734";   //Your email password from which email you send.
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
        $mail->Send();

        //header('Location: email_template.php?id='.$_REQUEST['pid']);




        header('Location: email_template.php?id=' . $_REQUEST['id']);
    }







//                                            $fields = array('pagedetail' => mysqli_real_escape_string($con,$pagedetail));
//
//                                                    $fieldsList = array();
//                                                    foreach ($fields as $field => $value) {
//                                                            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
//
//                                            }	   
//                                             $editQuery = "UPDATE `webshop_emailtemplate` SET " . implode(', ', $fieldsList)
//                                                            . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['pid']) . "'";
//                                                    //	exit;
//
//                                                    if (mysqli_query($con,$editQuery)) {
//                                                            $_SESSION['msg'] = "CMS Updated Successfully";
//                                                    }
//                                                    else {
//                                                            $_SESSION['msg'] = "Error occuried while updating CMS";
//                                                    }




    header('Location: email_template.php?id=' . $_REQUEST['id']);
    exit();
}
?>
<script language="javascript">
    function submitdata(val)
    {
        //alert("hh");
        document.location.href = "email_template.php?id=" + val;
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
                    <h3 class="page-title">
                        Manage Email Template
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Template settings</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Manage Email Template</a>

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
                            <h4><i class="icon-reorder"></i>Change Email Language</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />



                                <div class="control-group">
                                    <label class="control-label">Email Templates</label>
                                    <div class="controls">
                                        <select id="selectError" name="default_language" onChange="submitdata(this.value);">
                                            <option value="">Select One</option>
                                            <option value="Arabic" <?php
                                            if ($pid == 'Arabic') {
                                                echo "selected";
                                            }
                                            ?>>Arabic</option>
                                            <option value="English" <?php
                                            if ($pid == 'English') {
                                                echo "selected";
                                            }
                                            ?>>English</option>
                                            <option value="Approval" <?php
                                            if ($pid == 'Approval') {
                                                echo "selected";
                                            }
                                            ?>>Approval</option>
                                            <option value="All" <?php
                                            if ($pid == 'All') {
                                                echo "selected";
                                            }
                                            ?>>All</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Focused Input</label>
                                    <div class="controls">
                                        <textarea class="ckeditor form-control" id="editor1" name="elm1" cols="100" rows="20"></textarea>
                                    </div>
                                </div>





                                <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Save</button>
                                    <button type="reset" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                </div>
                            </form>
                            <!-- END FORM-->
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
<!--  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
<script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->

<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="js/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/chart-master/Chart.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>


<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this page only-->

<script src="js/easy-pie-chart.js"></script>
<script src="js/sparkline-chart.js"></script>
<script src="js/home-page-calender.js"></script>
<script src="js/home-chartjs.js"></script>
<script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>

<!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
