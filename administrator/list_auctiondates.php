<?php
include_once("./includes/session.php");
include_once("./includes/config.php");

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    echo $sqldel = "delete from  webshop_auctiondates where date='" . $item_id . "'";
    mysqli_query($con, $sqldel);
    header('Location:list_auctiondates.php');
    exit();
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_auctiondates`"));
}
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_auctiondates.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_auctiondates.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "list_auctiondates.php?cid=" + aa + "&action=active";
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
                    <h3 class="page-title">Auction Date list</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Auction Date list</a>

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
                                        <th> Slno</th>
                                        <th> Date</th>
                                        <th> Time</th>
                                        <!--<th>  Time</th>--> 
                                        <th>Quick Links</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetch_subscription = mysqli_query($con, "select *,@a:=@a+1 serial_number from webshop_auctiondates,(SELECT @a:= 0) AS a group by (date)");
                                    $num = mysqli_num_rows($fetch_subscription);
                                    if ($num > 0) {
                                        while ($subscription = mysqli_fetch_array($fetch_subscription)) {
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo stripslashes($subscription['serial_number']); ?>
                                                </td>

                                                <td>
                                                    <?php echo stripslashes($subscription['date']); ?>
                                                </td>
                                                <?php 
                                               // echo "select * from webshop_auctiondates where date=".$subscription['date'];
                                                $fetch_subscription1 = mysqli_query($con, "select * from webshop_auctiondates where date='".$subscription['date']."'");
                                                while ($subscription1 = mysqli_fetch_array($fetch_subscription1)) {
                                                    $strtime = explode(' ',$subscription1['start_time']);
                                                    $endtime = explode(' ',$subscription1['end_time']);
                                                    $time[] = ' '.$strtime[1].'-'.$endtime[1].' ';
                                                    // $subscription1['start_time'].'-'.$subscription1['end_time'];
                                                }
                                                $timestring = implode(",",$time);
                                                
                                                ?>
                                                   <td>
                                                    <?php echo stripslashes($timestring); ?>
                                                </td>                     <!--                                                <td>
                                                <?php echo stripslashes($subscription['start_time']); ?>
                                                                                                                        </td>-->



                                                <td>
                                                    <a  href="edit_auctiondates.php?date=<?php echo $subscription['date'] ?>&action=edit">
                                                        <i class="icon-edit"></i></a>
                                                    <a onClick="javascript:del('<?php echo $subscription['date']; ?>')">
                                                        <i class="icon-trash"></i></a>
                                                </td>




                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6">Sorry, no record found.</td>
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
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
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
