<?php
//include_once("controller/productController.php");
include_once("./includes/session.php");
include_once("./includes/config.php");

if ($_REQUEST['action'] == 'details') {


//echo "SELECT * FROM `getfitpass_users` WHERE `id`='".$_REQUEST['id']."'";
//exit;
    $userRow = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_products` WHERE `id`='" . $_REQUEST['id'] . "'"));


    $membership = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_membership` WHERE `id`='" . $userRow['membership_id'] . "'"));

    $products = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `webshop_products` WHERE `uploader_id`='" . $userRow['id'] . "'"));

    $get_brands = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_brands` WHERE `id`='" . $userRow['brands'] . "'"));

// $products2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_products` WHERE `id`='".$userRow['product_id']."'"));
//$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `barter_product` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));
//$store_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_store` WHERE `id`='".mysql_real_escape_string($categoryRowset['store_id'])."'"));
//$category_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_category` WHERE `id`='".mysql_real_escape_string($categoryRowset['cat_id'])."'"));
//$subcategory_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_subcategory` WHERE `id`='".mysql_real_escape_string($categoryRowset['subcat'])."'"));
}
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_product.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_product.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "details_auction.php?cid=" + aa + "&action=active";
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

                    <h3 class="page-title"> Details</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Auction Details</a>
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
                    <div class="widget green portlet-body form">
                        <div class="widget-title">                             
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body" style="float:left;" >
                            <!-- BEGIN Table-->



                            <form action="#" class="form-horizontal" method="post" action="user_update.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />


                                <tr><button type="reset" class="btn blue" onClick="window.location.href = 'list_auction.php'" >Back</button></tr>

                                <table class="table table-striped table-hover table-bordered" id="editable-sample" style="width: 999px !important;">

<!--<tr>    
<td> Watch Name</th>
<td><?php echo $userRow['name']; ?></td>
</tr>-->


                                    <tr>    
                                        <td>Auction Price </th>
                                        <td><?php echo "$" . $userRow['price']; ?></td>
                                    </tr>

                                    <tr>    
                                        <td> Movement </th>
                                        <td> <?php echo $userRow['movement']; ?> </td>
                                    </tr>


                                    <tr>
                                        <td> Brand </th> 
                                        <td><?php echo $get_brands['name']; ?></td>    
                                    </tr>

                                    <tr>    
                                        <td> Reference No.  </th>
                                        <td><?php echo $userRow['reference_number']; ?></td>
                                    </tr>



                                    <tr>
                                        <td> Image </td>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $item_id = $_GET['cid'];

    mysqli_query($con, "update webshop_products set status='1' , approved = '1' where id='" . $item_id . "'");

    $get_current_date = date('Y-m-d');

    $getuploaderid = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_products where id='" . $item_id . "'"));
    $isFeePaid = $getuploaderid['auction_fee_paid'];

    $preferred_date = $getuploaderid['preferred_date'];

    $productName = $getuploaderid['name'];

    $requestor_id = $getuploaderid['uploader_id'];

    if ($preferred_date != '' && $isFeePaid == '1' && $preferred_date >= $get_current_date) {



        mysqli_query($con, "INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','" . $requestor_id . "','Auction Product Live','Your Product  is Live. The Product will stay live for 24 hours.','" . $get_current_date . "','0','" . $_REQUEST['id'] . "')");

        $getAllUsers = mysqli_query($con, "SELECT * from webshop_user where type= '1'");
        $getrows = mysqli_num_rows($getAllUsers);
        if ($getrows > 0) {

            while ($get_all_users = mysqli_fetch_array($getAllUsers)) {

                mysqli_query($con, "INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','" . $get_all_users['id'] . "','Product Added for Auction','A Product  has been added for auction.The Auction Date is " . $preferred_date . " .The Product will stay live for that day .','" . $get_current_date . "','0','0')");
            }
        }
    }


    header('Location:list_live_auction.php');
    exit();
}


$country = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_countries` WHERE `id`='" .$userRow['country']. "'"));

$moreimage1 = mysqli_query($con, "SELECT * FROM `webshop_products` WHERE `id`='" . $_REQUEST['id'] . "'");
while ($moreimage = mysqli_fetch_array($moreimage1)) {

    if ($moreimage['image'] != "") {
        $image_link = '../upload/product_image/' . $moreimage['image'];
    } else {
        $image_link = '../upload/no.jpg';
    }
    ?>
                                            <td><img src="<?php echo stripslashes($image_link); ?>" height="70" width="70" style="border:1px solid #666666" /></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>

                                    <tr>    
                                        <td> Date Purchase</th>
                                        <td><?php echo $userRow['date_purchase']; ?></td>
                                    </tr>

                                    <tr>    
                                        <td> Watch Status</th>
                                        <td><?php echo $userRow['status_watch']; ?></td>
                                    </tr>

                                    <tr>    
                                        <td> Owner Number</th>
                                        <td><?php echo $userRow['owner_number']; ?></td>
                                    </tr>

<!--                                    <tr>    
                                        <td> Country</th>
                                        <td><?php echo $country['name']; ?></td>
                                    </tr>-->

                                    <tr>    
                                        <td> Size</th>
                                        <td><?php echo $userRow['size']; ?></td>
                                    </tr>

                                    <tr>    
                                        <td> Preferred Date</th>
                                        <td><?php echo $userRow['preferred_date']; ?></td>
                                    </tr>

<!-- <tr>    
<td> Start Date Time</th>
<td><?php echo $userRow['start_date_time']; ?></td>
</tr>

<tr>    
<td> End Date Time</th>
<td><?php echo $userRow['end_date_time']; ?></td>
</tr> -->


                                </table>

                                <br>
                                <button type="reset" class="btn blue" onClick="javascript:active('<?php echo $_REQUEST['id']; ?>');" center >Approve Auction</button>&nbsp;&nbsp;

                                <!--<button type="reset" class="btn blue" onClick="window.location.href = 'auction_send_notific.php'" center >Send Notification</button>-->
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
<!--  <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
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
