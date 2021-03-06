<?php
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php
if (isset($_REQUEST['submit'])) {
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';


    $mydatetime = date('Y-m-d H:i:s', strtotime($mydatetime));



    for ($k = 0; $k <= count($start_time); $k++) {
        $start_time[$k] = date('Y-m-d H:i:s', strtotime($start_time[$k]));
        $end_time[$k] = date('Y-m-d H:i:s', strtotime($end_time[$k]));

        $fields = array(
            'start_time' => mysqli_real_escape_string($con, $start_time[$k]),
            'end_time' => mysqli_real_escape_string($con, $end_time[$k]),
        );

        $fieldsList = array();
        foreach ($fields as $field => $value) {
            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
        }

        if ($_REQUEST['action'] == 'edit') {
            $editQuery = "UPDATE `webshop_auctiontimes` SET " . implode(', ', $fieldsList)
                    . " WHERE `id` = '" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'";
            // exit;

            if (mysqli_query($con, $editQuery)) {


                $_SESSION['msg'] = "Category Updated Successfully";
            } else {
                $_SESSION['msg'] = "Error occuried while updating Category";
            }

            header('Location:list_english.php');
            exit();
        } else {

            $insertQuery = "INSERT INTO `webshop_auctiontimes` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";

            mysqli_query($con, $insertQuery);
            $last_id = mysqli_insert_id($con);


            header('Location:list_english.php');
            exit();
        }
    }
}


if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_language` WHERE `id`='" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'"));
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
                        Timing <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?>  Timing</small>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#"> Timing</a>
                            <span class="divider">/</span>
                        </li>

                        <li>
                            <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Timing</span>

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
                            <h4><i class="icon-reorder"></i>Add Timing</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="input_fields_wrap">
                                    <div class="control-group">
                                        <label class="control-label">Start Time </label>
                                        <div class="controls">
                                            <input type="text" class="form-control timepicker" placeholder="Start Time" value="<?php echo $categoryRowset['start_time']; ?>" name="start_time[]" required>
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <label class="control-label">End Time</label>
                                        <div class="controls">
                                            <input type="text" class="form-control timepicker" placeholder="End Time" value="<?php echo $categoryRowset['end_time']; ?>" name="end_time[]" required>
                                        </div>
                                    </div>
                                    <button class="add_field_button">Add More Fields</button>
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
<!--  <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
<script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="js/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/chart-master/Chart.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.datepicker.js"></script>
<link href="css/jquery.datepicker.css" rel="stylesheet">

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this page only-->

<script src="js/easy-pie-chart.js"></script>
<script src="js/sparkline-chart.js"></script>
<script src="js/home-page-calender.js"></script>
<script src="js/home-chartjs.js"></script>
<script>
    $(document).ready(function () {
        $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<script>
    $(document).ready(function () {
        $("#datepickerr").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<script>
    function getSubCategory(val) {
        $.ajax({
            type: "POST",
            url: "get_subcategory.php",
            data: 'category_id=' + val,
            success: function (data) {
                $("#subcategory_list").html(data);
            }
        });
    }
</script>
<script>






    $(document).ready(function () {
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var field = '   <div><div class="control-group">  ' +
                '                                           <label class="control-label">Start Time </label>  ' +
                '                                           <div class="controls">  ' +
                '                                               <input type="text" class="form-control timepicker" placeholder="Start Time" value="<?php echo $categoryRowset["start_time"]; ?>" name="start_time[]" required>  ' +
                '                                           </div>  ' +
                '                                       </div>  ' +
                '     ' +
                '     ' +
                '                                       <div class="control-group">  ' +
                '                                           <label class="control-label">End Time</label>  ' +
                '                                           <div class="controls">  ' +
                '                                               <input type="text" class="form-control timepicker" placeholder="End Time" value="<?php echo $categoryRowset["end_time"]; ?>" name="end_time" required>  ' +
                '</div> </div><a href="#" class="remove_field">Remove</a> ';

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append(field); //add input box


            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

</script>
<!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
