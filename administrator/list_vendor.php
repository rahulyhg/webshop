<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
require_once("includes/class.phpmailer.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($con, "delete from  webshop_user where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:list_vendor.php');
    exit();
}



if (isset($_REQUEST['submit'])) {


    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';
    $password = md5($pass);


    $fields = array(
        'fname' => mysqli_real_escape_string($con, $fname),
        'lname' => mysqli_real_escape_string($con, $lname),
        'address' => mysqli_real_escape_string($con, $address),
        'email' => mysqli_real_escape_string($con, $email),
        'city' => mysqli_real_escape_string($con, $city),
        'password' => mysqli_real_escape_string($con, $password),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }


    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action == 'add' || $action == '') {







        echo $addQuery = "INSERT INTO `hiretools_general_user` (`" . implode('`,`', array_keys($fields)) . "`)"
        . " VALUES ('" . implode("','", array_values($fields)) . "')";



        $res = mysqli_query($con, $addQuery);
        echo $last_id = mysqli_insert_id($con);




        if ($last_id != "" || $last_id != 0) {

            header("location:list_user.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
            // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
        $editQuery = "UPDATE `hiretools_general_user` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $last_id) . "'";


        $res = mysqli_query($con, $editQuery);
        if ($res) {
            
        }



        header("location:list_admin.php");
        $_SESSION['MSG'] = 1;
        exit();
    } else {
        header("location:add_new_admin.php?id=" . $last_id . "&action=edit");
        $_SESSION['MSG'] = 2;
        exit();
    }
}


/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {



    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
        mysqli_query($con, "DELETE FROM `hiretools_general_user` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'General User have been deleted successfully.';

    //die();

    header("Location:list_vendor.php");
}





if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_user` WHERE `type`='1'"));
}
?>
<!-- <?php
if (isset($_POST['ExportCsv'])) {


    $sql = "select * from webshop_user WHERE `type`='1' order by id desc";




    $query = mysqli_query($con, $sql);

    $output = '';

    $output .='UserId,First Name,Last Name,City,Address,Email,Contact Number,Status';

    $output .="\n";

    if (mysqli_num_rows($query) > 0) {
        while ($result = mysqli_fetch_assoc($query)) {

            if ($result['status'] == 1) {
                $status = 'Active';
            } else {
                $status = 'Deactive';
            }


            $user_id = $result['id'];
            $first_name = $result['fname'];
            $last_name = $result['lname'];
            $city = $result['city'];
            $address = $result['address'];
            $email = $result['email'];
            $contact_number = $result['phone'];


            if ($user_id != "") {
                $output .='"' . $user_id . '","' . $first_name . '","' . $last_name . '","' . $city . '","' . $address . '","' . $email . '","' . $contact_number . '","' . $status . '"';
                $output .="\n";
            }
        }
    }



    $filename = "GeneralUserList" . time() . ".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename=' . $filename);



    echo $output;

    //echo'<pre>';
    //print_r($result);

    exit;
}
?>

-->







<script type="text/javascript">
    function top1(aa)
    {
        location.href = "list_vendor.php?cid=" + aa + "&action=top1"

    }
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_vendor.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_vendor.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "list_vendor.php?cid=" + aa + "&action=active";
    }

    function disable(aa)
    {
        location.href = "list_vendor.php?cid=" + aa + "&action=disable"

    }
    function enable(aa)
    {
        location.href = "list_vendor.php?cid=" + aa + "&action=enable";
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
                    <h3 class="page-title">Normal Vendor list</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Normal Vendor list</a>

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
                            <h4><i class="icon-reorder"></i>List Normal Vendor</h4>
                            <form action="" method="post">
               <!--<i class="fa fa-edit"></i>Editable Table-->
                                <!-- <button type="submit"   name="ExportCsv"> Download General User List</button> -->
                            </form>
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
                                  <!--   <th>Webshop Id</th> -->
                                        <th>Normal Vendor</th>
                                        <th>Image</th>

                                        <th>Name</th>
                                        <th>Products Uploaded</th>
                                        <th> Details</th>
                                          <!--  <th> View Pets</th> -->
                                   <!--      <th> View Bookings</th> -->
                                     <!--   <th>Quick Links</th> -->
                                        <th>Status</th>
                                        <th>Approve/Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_user set status='0' where id='" . $item_id . "'");
                                        header('Location:list_vendor.php');
                                        exit();
                                    }
                                    if (isset($_GET['action']) && $_GET['action'] == 'active') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_user set status='1',is_admin_approved='1' where id='" . $item_id . "'");

                                        $user = mysqli_fetch_array(mysqli_query($con, "select * from webshop_user where id='" . $item_id . "'"));


                                        $MailTo = $user['email'];

                                        $subject = "webshop.com- Login Approved";

                                        $TemplateMessage.="<br/><br />Hi " . $user['fname'] . ",";
                                        $TemplateMessage.="<br>";
                                        $TemplateMessage.="<br>Your account has been activated.";
                                        $TemplateMessage.="<br>You can login now with your email and password.";
                                        $TemplateMessage.="<br><br>";
                                        $TemplateMessage.="<br><br/>Regards<br/>";
                                        $TemplateMessage.="Webshop";
                                        $TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";

                                        //echo $TemplateMessage;
                                        //exit;

                                        $mail = new PHPMailer(true);


                                        $IsMailType = 'SMTP';

                                        // $MailFrom='info@natit.us';    //  Your email password
                                        $MailFrom = 'palashsaharana@gmail.com';
                                        $MailFromName = 'Webshop';
                                        $MailToName = '';

                                        //$YourEamilPassword="Natit2016";   //Your email password from which email you send.
                                        $YourEamilPassword = "lsnspyrcimuffblr";

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

                                        header('Location:list_vendor.php');
                                        exit();
                                    }

                                    if (isset($_GET['action']) && $_GET['action'] == 'disable') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_user set is_admin_approved='2' where id='" . $item_id . "'");
                                        header('Location:list_vendor.php');
                                        exit();
                                    }
                                    if (isset($_GET['action']) && $_GET['action'] == 'enable') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_user set status='1', is_admin_approved='1' where id='" . $item_id . "'");
                                        header('Location:list_vendor.php');
                                        exit();
                                    }

                                    if (isset($_GET['action']) && $_GET['action'] == 'top1') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_user set top_user_vendor='1' where id='" . $item_id . "'");
                                        header('Location:list_vendor.php');
                                        exit();
                                    }


                                    $fetch_landlord = mysqli_query($con, "select * from webshop_user WHERE `type`='2' and top_user_vendor =0");
                                    $num = mysqli_num_rows($fetch_landlord);
                                    if ($num > 0) {
                                        while ($landlord = mysqli_fetch_array($fetch_landlord)) {

                                            if ($landlord['image'] != '') {
                                                $image_link = '../upload/user_image/' . $landlord['image'];
                                            } else {
                                                $image_link = '../upload/user_image/nouser.jpg';
                                            }
                                            ?>

                                            <tr>

                <!--       <td>
                                                <?php echo stripslashes($landlord['webshop_id']); ?>
                </td> -->

                                                <td>
                                                    <?php if ($landlord['status'] == '1' AND $landlord['is_admin_approved'] == '1') { ?>
                                                        <input type="checkbox" onClick="javascript:top1('<?php echo $landlord['id']; ?>');" /> 
                                                        <?php
                                                        echo "<br/>(Check for Certified Vendor)";
                                                    } else {
                                                        echo '<span style="color:#f44336;text-align:center;">Please activate the account</span>';
                                                    }
                                                    ?>
                                                </td> 

                                                <td>
                                                    <img src="<?php echo $image_link; ?>" height="100" width="100" align="image">
                                                </td>



                                                <td>
                                                    <?php echo stripslashes($landlord['fname'] . " " . $landlord['lname']); ?>
                                                </td> 

                                                <td>
                                                    <a  href="normalvendor_products.php?id=<?php echo $landlord['id'] ?>&action=details">
                                                        List Products</a>
                                                </td>


                                                <td>
                                                    <a  href="view_vendordetails.php?id=<?php echo $landlord['id'] ?>&action=details">
                                                        Details</a> |
                                                    <a  href="view_reviews.php?id=<?php echo $landlord['id'] ?>&action=details">
                                                        Reviews</a>
                                                </td>

                             <!--     <td>
                                  <a  href="view_pets.php?id=<?php echo $landlord['id'] ?>&action=details">
                                  View  Pets</a>
                                </td> -->


                             <!--     <td>
                                  <a  href="view_user.php?id=<?php echo $landlord['id'] ?>&action=details">
                                  View  Details</a>
                                </td>

                                  <td>
                                  <a  href="listUserBookings.php?id=<?php echo $landlord['id'] ?>&action=details">
                                  View  Bookings</a>
                                </td>
                                                -->
                                                             <!--   <td>
                                                                 <a  href="add_owner.php?id=<?php echo $landlord['id'] ?>&action=edit">
                                                                 <i class="icon-edit"></i> </a> 
                                                                  
                                                                 <a onClick="javascript:del('<?php echo $landlord['id']; ?>')">
                                                                 <i class="icon-trash"></i></a>
                                                               </td> -->

                                                <td>
                                                    <?php if ($landlord['status'] == '0') { ?>
                                                        <a  onClick="javascript:active('<?php echo $landlord['id']; ?>');">Click to Activate</a>
                                                    <?php } else { ?>
                                                        <a  onClick="javascript:inactive('<?php echo $landlord['id']; ?>');">Click to deactivate</a>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($landlord['is_admin_approved'] == '0') {

                                                        echo '<span style="color:#b94a48;text-align:center;">Awaiting</span>';
                                                        ?>
                                                        <a  onClick="javascript:enable('<?php echo $landlord['id']; ?>');">
                                                            <br>
                                                            Click to Approve</a>
                                                        <?php
                                                    } else if ($landlord['is_admin_approved'] == '1') {

                                                        echo '<span style="color:#468847;text-align:center;">Approved</span>';
                                                        ?>
                                                        <a  onClick="javascript:disable('<?php echo $landlord['id']; ?>');">
                                                            <br>
                                                            Click to Reject</a>
                                                        <?php
                                                    } else if ($landlord['is_admin_approved'] == '2') {
                                                        echo '<span style="color:#f44336;text-align:center;">Rejected</span>';
                                                        ?>
                                                        <a  onClick="javascript:enable('<?php echo $landlord['id']; ?>');">
                                                            <br>
                                                            Click to Approve</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">Sorry, no record found.</td>
                                        </tr>

                                        <?php
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
<!--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.blockui.js"></script>
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->
<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
<?php if ($num > 0) { ?>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
<?php } ?>
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>


<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this page only-->
<script src="js/editable-table.js"></script>

<!-- END JAVASCRIPTS -->
<script>
                                                jQuery(document).ready(function () {
                                                    EditableTable.init();
                                                });
</script>
</body>
<!-- END BODY -->
</html>
