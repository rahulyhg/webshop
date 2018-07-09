<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
require_once("includes/class.phpmailer.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<script type="text/javascript">


    function inactive(aa)
    {
        //alert('inactive');
        location.href = "add_leatest_deal.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        //alert('active');
        location.href = "add_leatest_deal.php?cid=" + aa + "&action=active";
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
                    <h3 class="page-title">Model list</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Model list</a>

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
                            <h4><i class="icon-reorder"></i>List Models</h4>

                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->

                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Slno</th> 
                                        <th>Latest Deal</th>
                                        <th>Image</th>
                                        <th>Products Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_products set is_leatest_deal='0' where id='" . $item_id . "'");

                                        header('Location:add_leatest_deal.php');
                                        exit();
                                    }
                                    if (isset($_GET['action']) && $_GET['action'] == 'active') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_products set is_leatest_deal='1'  where id='" . $item_id . "'");


                                        header('Location:add_leatest_deal.php');

                                        exit();
                                    }

                                    if (isset($_GET['action']) && $_GET['action'] == 'disable') {
                                        $item_id = $_GET['cid'];
                                        mysqli_query($con, "update webshop_products set is_leatest_deal='0' where id='" . $item_id . "'");
                                        header('Location:list_topvendor.php');
                                        exit();
                                    }


                                    $fetch_landlord = mysqli_query($con, "SELECT *,@a:=@a+1 serial_number from  webshop_products,(SELECT @a:= 0) AS a where status=1 and approved='1' and type='1' and is_discard='0'");
                                    $num = mysqli_num_rows($fetch_landlord);

                                    if ($num > 0) {
                                        while ($landlord = mysqli_fetch_array($fetch_landlord)) {
                                            
                                          if($landlord['subscription_id']!=0){  
                                         $getsubscription = mysqli_query($con, "select * from webshop_subscribers where id= '".$landlord['subscription_id']."'");   
                                         $subscriptiondetails = mysqli_fetch_array($getsubscription);
                                         
                                            $cdate = date('Y-m-d');
                                           if($subscriptiondetails['expiry_date'] >= $cdate){ 
                                            

                                            if ($landlord['image'] != '') {
                                                $image_link = '../upload/product_image/' . $landlord['image'];
                                            } else {
                                                $image_link = '../upload/no.jpg';
                                            }

                                            $id = $landlord["id"];
                                            $uploader_id = $landlord['uploader_id'];
                                            $uploadename = mysqli_query($con, "select * from webshop_user where id=$uploader_id");
                                            $landlorduploadername = mysqli_fetch_array($uploadename);
                                            // $is_leatest_deal = $landlord['is_leatest_deal'];
                                            ?>

                                            <tr>

                                                <td><?php echo $landlord['serial_number'];?></td>
                                                <td>

                                                    <input type="checkbox" <?php if ($landlord['is_leatest_deal'] == '1') {
                                        echo 'checked=checked';
                                    } else {
                                        echo '';
                                    } ?> onClick="<?php if ($landlord["is_leatest_deal"] == '1') {
                                        echo 'javascript:inactive(' . $id . ')';
                                    } else {
                                        echo 'javascript:active(' . $id . ')';
                                    } ?>" />
        <?php if ($is_leatest_deal == 1) {
            echo 'uncheck to remove from latest deal';
        } else {
            echo 'check for latest deal';
        } ?>
                                                </td> 

                                                <td>
                                                    <img src="<?php echo $image_link; ?>" height="100" width="100" align="image">
                                                </td>


                                                <td>
        <?php echo $landlorduploadername['fname'] . ' ' . $landlorduploadername['lname']; ?>

                                                </td>




                                            </tr>
                                            <?php
                                           }
                                        }else{
                                            
                                            
                                            
                                          if ($landlord['image'] != '') {
                                                $image_link = '../upload/product_image/' . $landlord['image'];
                                            } else {
                                                $image_link = '../upload/no.jpg';
                                            }

                                            $id = $landlord["id"];
                                            $uploader_id = $landlord['uploader_id'];
                                            $uploadename = mysqli_query($con, "select * from webshop_user where id=$uploader_id");
                                            $landlorduploadername = mysqli_fetch_array($uploadename);
                                            // $is_leatest_deal = $landlord['is_leatest_deal'];
                                            ?>

                                            <tr>


                                                <td>

                                                    <input type="checkbox" <?php if ($landlord['is_leatest_deal'] == '1') {
                                        echo 'checked=checked';
                                    } else {
                                        echo '';
                                    } ?> onClick="<?php if ($landlord["is_leatest_deal"] == '1') {
                                        echo 'javascript:inactive(' . $id . ')';
                                    } else {
                                        echo 'javascript:active(' . $id . ')';
                                    } ?>" />
        <?php if ($is_leatest_deal == 1) {
            echo 'uncheck to remove from latest deal';
        } else {
            echo 'check for latest deal';
        } ?>
                                                </td> 

                                                <td>
                                                    <img src="<?php echo $image_link; ?>" height="100" width="100" align="image">
                                                </td>


                                                <td>
        <?php echo $landlorduploadername['fname'] . ' ' . $landlorduploadername['lname']; ?>

                                                </td>




                                            </tr>   
                                            
                                            
                                            
                                            
                                      <?php  }
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5">Sorry, no record found.</td>
                                        </tr>

                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>



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
