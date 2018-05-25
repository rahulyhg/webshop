<?php
include_once("./includes/session.php");
include_once("./includes/class.phpmailer.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
mysqli_query("set symbol 'utf8'");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($con, "delete from  webshop_products where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:list_auction.php');
    exit();
}



if (isset($_REQUEST['submit'])) {


    $name = isset($_POST['name']) ? $_POST['name'] : '';


    $fields = array(
        'name' => mysqli_real_escape_string($con, $name),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }


    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action == 'add' || $action == '') {







        echo $addQuery = "INSERT INTO `webshop_products` (`" . implode('`,`', array_keys($fields)) . "`)"
        . " VALUES ('" . implode("','", array_values($fields)) . "')";



        $res = mysqli_query($con, $addQuery);
        echo $last_id = mysqli_insert_id($con);




        if ($last_id != "" || $last_id != 0) {

            header("location:list_auction.php");
            //header("location:list_tools.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
            // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
        $editQuery = "UPDATE `webshop_products` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $last_id) . "'";


        $res = mysqli_query($con, $editQuery);
        if ($res) {
            
        }



        header("location:list_auction.php");
        $_SESSION['MSG'] = 1;
        exit();
    } else {
        header("location:add_new_admin.php?id=" . $last_id . "&action=edit");
        $_SESSION['MSG'] = 2;
        exit();
    }
}


if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_products` WHERE `status`='1'"));
}
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_auction.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_auction.php?cid=" + aa + "&action=inactive"

    }
    function active(aa, name, email)
    {
        location.href = "list_auction.php?cid=" + aa + "&action=active" + "&name=" + name + "&email=" + email;
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
                    <h3 class="page-title">List Auction Requests</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">List Auction Requests</a>

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
                            <h4><i class="icon-reorder"></i>List Auction Requests</h4>
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

                                        <th>Product Images</th>           
                                        <th>User Name</th>
                                        <th>Price</th>
                                        <th>Brand</th>
                                        <th>email</th>
                                       <!-- <th>Owner Number</th>-->
                                        <th>Admin Approval</th>
                                        <th>Payment Status</th>
                                        <th>Quick Links</th>
                                        <th>Details</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_products set approved='0' where id='" . $item_id . "'");
                                        header('Location:list_auction.php');
                                        exit();
                                    }
                                    if (isset($_GET['action']) && $_GET['action'] == 'active') {
                                        $item_id = $_GET['cid'];


                                        mysqli_query($con, "update webshop_products set approved='1' where id='" . $item_id . "'");

                                        test_mail($_GET['email'], $_GET['name']);
                                        // mail("arunavaguha@natitsolved.com", "My subject", 'hello');

                                        $get_current_date = date('Y-m-d');

                                        $getuploaderid = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_products where id='" . $item_id . "'"));
                                        $requestor_id = $getuploaderid['uploader_id'];

                                        $getProductName = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_products where id='" . $getuploaderid['id'] . "'"));
                                        $productName = $getProductName['name'];
                                        $getMinimumBid = $getProductName['price'];

                                        $getpercentage = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_sitesettings"));

                                        $payment_amount = ceil(($getMinimumBid * $getpercentage['threshold_price_percent']) / 100);

                                        $auctionfees = mysqli_query($con, "UPDATE `webshop_products` SET `auction_fee`='" . $payment_amount . "' WHERE `id` = '" . $item_id . "'");

                                        $requestor_notification = mysqli_query($con, "INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','" . $requestor_id . "','Product for Auction Approved','Your Product has been approved for auction. You need to pay  KWD " . $payment_amount . " as auction fee to make your product Go Live.','" . $get_current_date . "','0','" . $item_id . "')");


                                        header('Location:list_auction.php');
                                        exit();
                                    }





// $fetch_tools_type=mysqli_query($con,"select * from  webshop_auction where status = 0");
                                    $fetch_tools_type = mysqli_query($con, "select * from  webshop_products where status = '0' and type = '2' order by id desc");
                                    $num = mysqli_num_rows($fetch_tools_type);
                                    if ($num > 0) {
                                        while ($tools_type = mysqli_fetch_array($fetch_tools_type)) {

                                            $uploader = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_user` WHERE `id`='" . $tools_type['uploader_id'] . "'"));


                                            $brands_name = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_brands` WHERE `id`='" . $tools_type['brands'] . "'"));



                                            if ($tools_type['image'] != '') {
                                                $image_link = '../upload/product_image/' . $tools_type['image'];
                                            } else {
                                                $image_link = '../upload/no.jpg';
                                            }
                                            ?>

                                            <tr>


                                                <td>
                                                    <img src="<?php echo $image_link; ?>" height="100" width="100" align="image">
                                                </td>

                                                <td>
                                                    <?php echo $uploader['fname'] . $uploader['lname']; ?>
                                                </td>



                                                <td>
                                                    $<?php echo stripslashes($tools_type['price']); ?>
                                                </td>

                                                <td>
                                                    <?php echo stripslashes($brands_name['name']); ?>
                                                </td>

                                                <td>
                                                    <?php echo stripslashes($uploader['email']); ?>
                                                </td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <!--  <td>
                                                <?php echo stripslashes($tools_type['owner_number']); ?>
                                                                                                                              </td>-->

                                                <td>
                                                    <?php
                                                    if ($tools_type['approved'] == '0') {

                                                        if ($tools_type['is_edited'] == 1) {
                                                            ?>
                                                            <a  onClick="javascript:active('<?php echo $tools_type['id']; ?>', '<?php echo $uploader['fname']; ?>', '<?php echo $uploader['email']; ?>');">Click to Activate</a>
                                                        <?php } else {
                                                            ?>
                                                            <a  href="javascript:void(0)" onclick="edit_alert()">Click to Activate</a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a  onClick="javascript:inactive('<?php echo $tools_type['id']; ?>');">Click to deactivate</a>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($tools_type['approved'] == '1' && $tools_type['auction_fee_paid'] == '0') {
                                                        echo '<span style="color:#b00;text-align:center;">Payment Pending</span>';
                                                    } else if ($tools_type['approved'] == '1' && $tools_type['auction_fee_paid'] == '1') {
                                                        echo '<span style="color:#468847;text-align:center;">Payment Done</span>';
                                                    } else {
                                                        echo '<span style="color:#b94a48;text-align:center;">Admin Approval Required</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <td>

                                                    <a  href="add_auction.php?id=<?php echo $tools_type['id'] ?>&action=edit"  >

                                                        <i class="icon-edit"></i></a> 
                                                    <a onClick="javascript:del('<?php echo $tools_type['id']; ?>')">
                                                        <i class="icon-trash"></i></a>
                                                </td>

                                                <td>
                                                    <?php
                                                    $link = "";

                                                    if ($tools_type['is_edited'] == 0) {
                                                        $link = "javascript:void(0)";
                                                    } else {
                                                        $link = "details_auction.php?id=" . $tools_type['id'] . "&action=details";
                                                    }
                                                    ?>
        <!--                                                    <a  href="details_auction.php?id=<?php echo $tools_type['id'] ?>&action=details"><i class="icon-eye-open"></i></a>-->
                                                    <a  href="<?php echo $link ?>"><i class="icon-eye-open"></i></a>


                                                </td> 



                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="9">Sorry, no record found.</td>
                                        </tr>

                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
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

<script>

    function edit_alert() {

        alert('Please edit auction first.');
    }

</script>
</body>
<!-- END BODY -->
</html>
<?php

//-------------------------------------------------------------------------


function test_mail($to, $firstname) {
    $MailTo = $to;


    $subject = "GMT24- Auction activation";

    $TemplateMessage = "Hello " . $firstname . ",<br /><br / >";
    $TemplateMessage .= "Your auction is activated by the admin " . " <br />";

    $TemplateMessage .= "<br /><br />Thanks,<br />";
    $TemplateMessage .= "GMT24<br />";


    $mail = new PHPMailer(true);

    $IsMailType = 'SMTP';

    $MailFrom = 'palashsaharana@gmail.com';    //  Your email password

    $MailFromName = 'GMT24';
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
}

//---------------------------------------------------------------------------
?>

