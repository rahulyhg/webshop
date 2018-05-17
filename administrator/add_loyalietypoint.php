<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
//echo $_SESSION['myy'];

CRYPT_BLOWFISH or die('No Blowfish found.');

$sqlbrands = "select * from webshop_loyalietypoint";
$brands = mysqli_query($con, $sqlbrands);

if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

    $sql = "select * from webshop_loyalietypoint  where id<>''";


    $record = mysqli_query($con, $sql);
}

if (isset($_REQUEST['submit'])) {


    $from_price = isset($_POST['from_price']) ? $_POST['from_price'] : '';
    $to_price = isset($_POST['to_price']) ? $_POST['to_price'] : '';
    $point = isset($_POST['point']) ? $_POST['point'] : '';


    $fields = array(
        //'user_id' => mysqli_real_escape_string($con,$user_id),
        'from_price' => mysqli_real_escape_string($con, $from_price),
        'to_price' => mysqli_real_escape_string($con, $to_price),
        'point' => mysqli_real_escape_string($con, $point)
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
//print_r($fieldsList);exit;
    if ($_REQUEST['action'] == 'edit') {
        $editQuery = "UPDATE `webshop_loyalietypoint` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'";



        mysqli_query($con, $editQuery_user);

        if (mysqli_query($con, $editQuery)) {

            


            $_SESSION['msg'] = "Loyaliety point Updated Successfully";
        } else {
            $_SESSION['msg'] = "Error occurred while updating Loyaliety Point";
        }

        header('Location:list_loyalietypoint.php');
        exit();
    } else {

        $addQuery = "INSERT INTO `webshop_loyalietypoint` (`" . implode('`,`', array_keys($fields)) . "`)"
                . " VALUES ('" . implode("','", array_values($fields)) . "')";
        //exit;

        mysqli_query($con, $addQuery);
        $last_id = mysqli_insert_id($con);


        header('Location:list_loyalietypoint.php');
        exit();
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_loyalietypoint` WHERE `id`='" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'"));
}


/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {



    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        //echo "UPDATE `makeoffer_banner` SET status='0' WHERE id=".$id;
        mysqli_query($con, "DELETE FROM`webshop_category` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Tools have been deleted successfully.';

    //die();

    header("Location:list_loyalietypoint.php");
}
?>




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
                        loyaliety Point <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Loyaliety Point</small>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Loyaliety Point</a>
                            <span class="divider">/</span>
                        </li>

                        <li>
                            <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Loyaliety Point</span>

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
                            <h4><i class="icon-reorder"></i>Add Loyaliety Point</h4>
                            <!-- <a style="float:right;" class="btn blue" href="sampledownload.csv">Download Sample</a> -->
                            <!--   <a style="float:right;" class="btn blue" href="upload_csv.php">Upload Csv</a> -->
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_loyalietypoint.php" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />  
                                <div class="control-group">
                                    <label class="control-label">From price</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['from_price']; ?>" name="from_price" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">To Price</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['to_price']; ?>" name="to_price" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Point</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['point']; ?>" name="point" required>
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
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
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
