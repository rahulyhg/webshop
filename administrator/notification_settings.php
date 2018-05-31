<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
$sql2 = "SELECT * FROM `webshop_tbladmin` where id='" . $_SESSION['admin_id'] . "'";
$res = mysqli_query($con, $sql2);
$row = mysqli_fetch_array($res);

if (isset($_REQUEST['submit'])) {
    //$email=$_REQUEST['email'];

    $auction_notification = isset($_POST['auction_notification']) ? $_POST['auction_notification'] : '';
    $product_upload_notification = isset($_POST['product_upload_notification']) ? $_POST['product_upload_notification'] : '';
    $payment_notification = isset($_POST['payment_notification']) ? $_POST['payment_notification'] : '';
    $review_notification = isset($_POST['review_notification']) ? $_POST['review_notification'] : '';
    $signup_notification = isset($_POST['signup_notification']) ? $_POST['signup_notification'] : '';
    $request_brand = isset($_POST['request_brand']) ? $_POST['request_brand'] : '';

    $fields = array('auction_notification' => mysqli_real_escape_string($con, $auction_notification),
        'product_upload_notification' => mysqli_real_escape_string($con, $product_upload_notification),
        'payment_notification' => mysqli_real_escape_string($con, $payment_notification),
        'review_notification' => mysqli_real_escape_string($con, $review_notification),
        'signup_notification' => mysqli_real_escape_string($con, $signup_notification),
        'request_brand' => mysqli_real_escape_string($con, $request_brand),
    );
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    $editQuery = "UPDATE `webshop_tbladmin` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = '" . mysqli_real_escape_string($con, $_SESSION['admin_id']) . "'";

    if (mysqli_query($con, $editQuery)) {
        $_SESSION['msg'] = "Email Updated Successfully";
    } else {
        $_SESSION['msg'] = "Error occuried while updating Email";
    }

    header('Location: notification_settings.php');
    exit();
}
?>






<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_membership.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_auction.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "list_auction.php?cid=" + aa + "&action=active";
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
                        Notification settings
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Notification settings</a>
                            <span class="divider">/</span>
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
                            <h4><i class="icon-reorder"></i>Notification Settings</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form action="notification_settings.php" class="form-horizontal" method="post"  enctype="multipart/form-data">

                                <div class="control-group">
                                    <label class="control-label">Auction Notification</label>
                                    <div class="controls">
                                        <input type="radio" name="auction_notification" value="1" <?php if ('1' == $row['auction_notification']) { ?> checked <?php } ?>>Yes&nbsp;
                                        <input type="radio" name="auction_notification" value="0" <?php if ('0' == $row['auction_notification']) { ?> checked <?php } ?>>No<br>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Product Upload Notification</label>
                                    <div class="controls">
                                        <input type="radio" name="product_upload_notification" value="1" <?php if ('1' == $row['product_upload_notification']) { ?> checked <?php } ?>>Yes&nbsp;
                                        <input type="radio" name="product_upload_notification" value="0" <?php if ('0' == $row['product_upload_notification']) { ?> checked <?php } ?>>No<br>
                                    </div>
                                </div>


                                <!--                                <div class="control-group">
                                                                    <label class="control-label">Payment Notification</label>
                                                                    <div class="controls">
                                                                        <input type="radio" name="payment_notification" value="1" <?php if ('1' == $row['payment_notification']) { ?> checked <?php } ?>>Yes&nbsp;
                                                                        <input type="radio" name="payment_notification" value="0" <?php if ('0' == $row['payment_notification']) { ?> checked <?php } ?>>No<br>
                                                                    </div>
                                                                </div>-->

                                <div class="control-group">
                                    <label class="control-label">Review Notification</label>
                                    <div class="controls">
                                        <input type="radio" name="review_notification" value="1" <?php if ('1' == $row['review_notification']) { ?> checked <?php } ?>>Yes&nbsp;
                                        <input type="radio" name="review_notification" value="0" <?php if ('0' == $row['review_notification']) { ?> checked <?php } ?>>No<br>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Signup Notification</label>
                                    <div class="controls">
                                        <input type="radio" name="signup_notification" value="1" <?php if ('1' == $row['signup_notification']) { ?> checked <?php } ?>>Yes&nbsp;
                                        <input type="radio" name="signup_notification" value="0" <?php if ('0' == $row['signup_notification']) { ?> checked <?php } ?>>No<br>
                                    </div>
                                </div>

                                <!--                                <div class="control-group">
                                                                    <label class="control-label">Request Brand</label>
                                                                    <div class="controls">
                                                                        <input type="radio" name="request_brand" value="1" <?php if ('1' == $row['request_brand']) { ?> checked <?php } ?>>Yes&nbsp;
                                                                        <input type="radio" name="request_brand" value="0" <?php if ('0' == $row['request_brand']) { ?> checked <?php } ?>>No<br>
                                                                    </div>
                                                                </div>-->

                                <div class="control-group">
                                    <label class="control-label">Interest Notification</label>
                                    <div class="controls">
                                        <input type="radio" name="request_brand" value="1" <?php if ('1' == $row['request_brand']) { ?> checked <?php } ?>>Yes&nbsp;
                                        <input type="radio" name="request_brand" value="0" <?php if ('0' == $row['request_brand']) { ?> checked <?php } ?>>No<br>
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
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="js/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/chart-master/Chart.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>

</body>
<!-- END BODY -->
</html>
