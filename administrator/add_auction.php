<?php
include_once("./includes/config.php");
include_once('includes/session.php');
?>
<?php
if (isset($_REQUEST['submit'])) {
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $movement = isset($_POST['movement']) ? $_POST['movement'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
    $reference_number = isset($_POST['reference_number']) ? $_POST['reference_number'] : '';
    $date_purchase = isset($_POST['date_purchase']) ? $_POST['date_purchase'] : '';
    $status_watch = isset($_POST['status_watch']) ? $_POST['status_watch'] : '';
    $owner_number = isset($_POST['owner_number']) ? $_POST['owner_number'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $size = isset($_POST['size']) ? $_POST['size'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $preferred_date = isset($_POST['preferred_date']) ? $_POST['preferred_date'] : '';
    $baseauctionprice = isset($_POST['baseauctionprice']) ? $_POST['baseauctionprice'] : '';
    $thresholdprice = isset($_POST['thresholdprice']) ? $_POST['thresholdprice'] : '';
    $bidincrement = isset($_POST['bidincrement']) ? $_POST['bidincrement'] : '';
    // $start_date_time = isset($_POST['start_date_time']) ? $_POST['start_date_time'] : '';
    // $end_date_time = isset($_POST['end_date_time']) ? $_POST['end_date_time'] : '';




    $fields = array(
        'price' => mysqli_real_escape_string($con, $price),
        'movement' => mysqli_real_escape_string($con, $movement),
        'gender' => mysqli_real_escape_string($con, $gender),
        'brands' => mysqli_real_escape_string($con, $brand),
        'reference_number' => mysqli_real_escape_string($con, $reference_number),
        'date_purchase' => mysqli_real_escape_string($con, $date_purchase),
        'status_watch' => mysqli_real_escape_string($con, $status_watch),
        'country' => mysqli_real_escape_string($con, $country),
        'size' => mysqli_real_escape_string($con, $size),
        'location' => mysqli_real_escape_string($con, $location),
        'preferred_date' => mysqli_real_escape_string($con, $preferred_date),
        'baseauctionprice' => mysqli_real_escape_string($con, $baseauctionprice),
        'thresholdprice' => mysqli_real_escape_string($con, $thresholdprice),
        'bidincrement' => mysqli_real_escape_string($con, $bidincrement),
        // 'start_date_time' => mysqli_real_escape_string($con,$start_date_time),
        //  'end_date_time' => mysqli_real_escape_string($con,$end_date_time),
        'owner_number' => mysqli_real_escape_string($con, $owner_number),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {

        $getuploaderid = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_products where id='" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'"));
        $isFeePaid = $getuploaderid['auction_fee_paid'];


        $editQuery = "UPDATE `webshop_products` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'";



        if (mysqli_query($con, $editQuery)) {


            if (!empty($_FILES['imagee']['tmp_name'])) {

                $target_path = "../upload/product_image/";
                $userfile_name = $_FILES['imagee']['name'];
                $userfile_tmp = $_FILES['imagee']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysqli_query($con, "UPDATE `webshop_products` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'");
                // exit;
            }



            $get_current_date = date('Y-m-d');

            //   if($preferred_date!='' && $isFeePaid == '1'  && $preferred_date >=$get_current_date)
            //   {
            //       // $auctionstatus =mysqli_query($con,"UPDATE `webshop_products` SET `status`='1' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'"); 
            //         $get_current_date =date('Y-m-d');
            // $getuploaderid = mysqli_fetch_array(mysqli_query($con,"SELECT * from webshop_products where id='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));
            // $requestor_id = $getuploaderid['uploader_id'];
            // $getProductName = mysqli_fetch_array(mysqli_query($con,"SELECT * from webshop_products where id='" .$getuploaderid['product_id']. "'"));
            //   $productName = $getProductName['name'];
            //   mysqli_query($con,"INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','".$requestor_id."','Auction Product Live','Your Product ".$productName." is Live. The Product will stay live for 24 hours.','".$get_current_date."','0','".$_REQUEST['id']."')");
            //      $getAllUsers = mysqli_query($con,"SELECT * from webshop_user where type= '1'");
            //   $getrows = mysqli_num_rows($getAllUsers);
            //    if($getrows > 0){
            //     while($get_all_users = mysqli_fetch_array($getAllUsers)){
            //       mysqli_query($con,"INSERT into webshop_notification(from_id,to_id,type,msg,date,is_read,last_id) VALUES ('0','".$get_all_users['id']."','Product Added for Auction','A Product ".$productName." has been added for auction.The Auction Date is ".$preferred_date." .The Product will stay live for 24 hours from now.','".$get_current_date."','0','0')");
            //     }
            //   }
            //   }
            $_SESSION['msg'] = "Category Updated Successfully";
        } else {
            $_SESSION['msg'] = "Error occuried while updating Category";
        }

        header('Location:list_auction.php');
        exit();
    }
    //       else
    //       {
    //  $insertQuery = "INSERT INTO `webshop_products` (`" . implode('`,`', array_keys($fields)) . "`)"
    //   . " VALUES ('" . implode("','", array_values($fields)) . "')";
    //    mysqli_query($con,$insertQuery);
    //                       $last_id=mysqli_insert_id($con);
    //                      if($_FILES['imagee']['tmp_name']!='')
    // {
    // $target_path="../upload/product_image/";
    // $userfile_name = $_FILES['imagee']['name'];
    // $userfile_tmp = $_FILES['imagee']['tmp_name'];
    // $img_name =$userfile_name;
    // $img=$target_path.$img_name;
    // move_uploaded_file($userfile_tmp, $img);
    // $image =mysqli_query($con,"UPDATE `webshop_products` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
    // }
    //    header('Location:list_auction.php');
    //    exit();
    //       }
}


if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `webshop_products` WHERE `id`='" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'"));
}


$datefordatepicker = array();
$fetch_subscription = mysqli_query($con, "select * from webshop_auctiondates");
$num = mysqli_num_rows($fetch_subscription);
if ($num > 0) {

    $i = 0;
    while ($subscription = mysqli_fetch_array($fetch_subscription)) {
        $date = explode('-', stripslashes($subscription['date']));
        $datefordatepicker[$i] = $date[2] . '-' . $date[1] . '-' . $date[0];
        $i++;
    }
}
//$result = $conn->query("SELECT * FROM webshop_auctiondates");
//echo 'hi';
//echo '<pre>';
//print_r($datefordatepicker);
//exit;
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
                        Auction <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?>  Auction</small>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#"> Auction</a>
                            <span class="divider">/</span>
                        </li>

                        <li>
                            <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Auction</span>

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
                            <h4><i class="icon-reorder"></i>Edit Auction</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" id="adminaddauction" method="post" enctype="multipart/form-data">



                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter price" value="<?php echo $categoryRowset['price']; ?>" name="price" id="price" required>

                                    </div>
                                </div>

                                <!--<div class="control-group">
                               <label class="control-label">Description</label>
                               <div class="controls">
                               <textarea rows="4" cols="50" class="ckeditor form-control" placeholder="Enter text" name ="description"><?php echo $categoryRowset['description']; ?></textarea>
                               </div>
                               </div>-->




                                <div class="control-group">
                                    <label class="control-label">Movement</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter movement" value="<?php echo $categoryRowset['movement']; ?>" name="movement" required>

                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <div class="controls">
                                        <input type="radio" name="gender" value="Female" <?php if ('Female' == $categoryRowset['gender']) { ?> checked <?php } ?>>Female&nbsp;
                                        <input type="radio" name="gender" value="Male" <?php if ('Male' == $categoryRowset['gender']) { ?> checked <?php } ?>>Male<br>

                                    </div>
                                </div>

                                <!--   <div class="control-group">
                                     <label class="control-label">Brand</label>
                                     <div class="controls">
                                     <input type="text" class="form-control" placeholder="Enter brand" value="<?php echo $getBrands['name']; ?>" name="brand" required>
                                     </div>
                                 </div> -->

                                <div class="control-group">
                                    <label class="control-label">Brand</label>
                                    <div class="controls">
                                        <?php
                                        $sql = "SELECT * FROM webshop_brands";
                                        $result = mysqli_query($con, $sql);
                                        ?>
                                        <select name='brand'>
                                            <option value=''> Select Brand</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value='<?php echo $row['id']; ?>'  <?php if ($row['id'] == $categoryRowset['brands']) { ?> selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
                                            <?php }
                                            ?>

                                        </select>

                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Reference Number</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter reference number" value="<?php echo $categoryRowset['reference_number']; ?>" name="reference_number" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Date of Purchase</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter purchase date" value="<?php echo $categoryRowset['date_purchase']; ?>" id="datepickerpurchase" name="date_purchase" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Watch Status</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter purchase date" value="<?php echo $categoryRowset['status_watch']; ?>" name="status_watch" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Owner Number</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter owner number" value="<?php echo $categoryRowset['owner_number']; ?>" name="owner_number" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Country</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter country" value="<?php echo $categoryRowset['country']; ?>" name="country" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Size</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter size" value="<?php echo $categoryRowset['size']; ?>" name="size" required>

                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Location</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter location" value="<?php echo $categoryRowset['location']; ?>" name="location">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Base Auction Price</label>
                                    <div class="controls">
                                        <input  type="number" class="form-control" placeholder="Enter base auction price" value="<?php echo $categoryRowset['baseauctionprice']; ?>" name="baseauctionprice" id="baseauctionprice" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Threshold Price</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" placeholder="Enter threshold price" value="<?php echo $categoryRowset['thresholdprice']; ?>" name="thresholdprice" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Bid Increment</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" placeholder="Enter bid increment price" value="<?php echo $categoryRowset['bidincrement']; ?>" name="bidincrement" required>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Preferred Date</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter preferred_date" id="datepicker" value="<?php echo $categoryRowset['preferred_date']; ?>"  name="preferred_date" required>

                                    </div>
                                </div>


                                <!--   <div class="control-group">
                                      <label class="control-label">Start Date</label>
                                      <div class="controls">
                                      <input type="text" class="form-control" placeholder="Enter start date" id="datepicker" value="<?php echo $categoryRowset['start_date_time']; ?>" name="start_date_time" required>
                                      </div>
                                  </div>
  
                                  <div class="control-group">
                                      <label class="control-label">End Date</label>
                                      <div class="controls">
                                      <input type="text" class="form-control" placeholder="Enter end date" id="datepickerr" value="<?php echo $categoryRowset['end_date_time']; ?>" name="end_date_time" required>
                                      </div>
                                  </div> -->

                                <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                        <input type="file" name="imagee" class=" btn blue"  ><?php if ($categoryRowset['image'] != '') { ?><br><a href="../upload/product_image/<?php echo $categoryRowset['image']; ?>" target="_blank">View</a><?php } ?>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit" onclick="return validateForm()"><i class="icon-ok"></i> Save</button>
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

<!-- ie8 fixes -->
<!--[if lt IE 9]>
<script src="js/excanvas.js"></script>
<script src="js/respond.js"></script>
<![endif]-->

<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="js/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/chart-master/Chart.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.datepicker.js"></script>
<link href="css/jquery.datepicker.css" rel="stylesheet">
<script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this page only-->

<script src=" https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>






<script src="js/easy-pie-chart.js"></script>
<script src="js/sparkline-chart.js"></script>
<script src="js/home-page-calender.js"></script>
<script src="js/home-chartjs.js"></script>

<script>

                                        jQuery(function () {
                                            //alert();
                                            var enableDays = <?php echo json_encode($datefordatepicker); ?>;
                                            function enableAllTheseDays(date) {
                                                var sdate = $.datepicker.formatDate('dd-mm-yy', date)
                                                if ($.inArray(sdate, enableDays) != -1) {
                                                    return [true, 'event'];
                                                }
                                                return [false];
                                            }

                                            $('#datepicker').datepicker({dateFormat: 'dd-mm-yy', beforeShowDay: enableAllTheseDays});
                                        })</script>
<script>
    $(document).ready(function () {
        $("#datepickerr").datepicker({dateFormat: 'yy-mm-dd'});
    });</script>
<script>
    $(document).ready(function () {
        $("#datepickerpurchase").datepicker({dateFormat: 'yy-mm-dd'});
    });</script>
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
<!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
<style>
    .event a {
        background-color: #D3D3D3 !important;
        background-image :none !important;
        color: #008000 !important;
    }
    .ui-datepicker .ui-state-default {
        color: #696969 ;
        background: ghostwhite;
    }

    .error {
        color:#FF0000;
    }
</style>
<script>

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    }, "Only Letters allowed");
    $.validator.addMethod('positiveNumber',
            function (value, element) {
                return this.optional(element) || /^(0*[0-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[0-9][0-9]*)$/.test(value);
            }, 'Only number allowed.');
    jQuery.validator.addMethod("noSpace", function (value, element) {
        return value == '' || value.trim().length != 0;
    }, "No space please and don't leave it empty");
    jQuery.validator.addMethod("lessThan", function (value, element, params) {

        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) < new Date($(params).val());
        }

        return isNaN(value) && isNaN($(params).val())
                || (Number(value) < Number($(params).val()));
    }, 'Must be less than Preffered Date.');

    $.validator.addMethod('greaterNumber', function (value, element, param) {
        return this.optional(element) || parseInt(value) > parseInt($(param).val());
    }, 'Invalid value');

    $("#adminaddauction").validate({
        rules: {
            price: {
                noSpace: true,
                positiveNumber: true,
            },
            movement: {
                noSpace: true,
                lettersonly: true,
            },
            brand: {
                required: true,
            },
            gender: {
                required: true,
            },
            preferred_date: {
                required: true,
            },
            date_purchase: {
                required: true,
                lessThan: '#datepicker',
            },
            status_watch: {
                required: true,
                lettersonly: true,
            },
            size: {
                required: true,
                positiveNumber: true,
            },
            baseauctionprice: {
                required: true,
                positiveNumber: true,
                greaterNumber: '#price',
            },
            thresholdprice: {
                required: true,
                positiveNumber: true,
                greaterNumber: '#baseauctionprice',
            },
            owner_number: {
                required: true,
                positiveNumber: true,
            },
            country: {
                required: true,
                lettersonly: true,
            },
            bidincrement: {
                required: true,
                positiveNumber: true,
            },
            reference_number: {
                required: true,
            },
        },
        messages: {
            baseauctionprice: {
                greaterNumber: 'Base auction price must be greater than price',
            },
            thresholdprice: {
                greaterNumber: 'Threshold price price must be greater than base auction price ',
            },
        }
    });
</script>