<?php
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php
if (isset($_REQUEST['submit'])) {
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $movement = isset($_POST['movement']) ? $_POST['movement'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
    $reference_number = isset($_POST['reference_number']) ? $_POST['reference_number'] : '';
    $date_purchase = isset($_POST['date_purchase']) ? $_POST['date_purchase'] : '';
    $status_watch = isset($_POST['status_watch']) ? $_POST['status_watch'] : '';
    $owner_number = isset($_POST['owner_number']) ? $_POST['owner_number'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
     $state = isset($_POST['state']) ? $_POST['state'] : '';
      $date_purchase = isset($_POST['date_purchase']) ? $_POST['date_purchase'] : '';
         $city = isset($_POST['city']) ? $_POST['city'] : '';
    $size = isset($_POST['size']) ? $_POST['size'] : '';
   $model_year = isset($_POST['model_year']) ? $_POST['model_year'] : '';
    $currency_code= isset($_POST['currency_code']) ? $_POST['currency_code'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';


    $fields = array(
        'price' => mysqli_real_escape_string($con, $price),
        'name' => mysqli_real_escape_string($con, $name),
        'movement' => mysqli_real_escape_string($con, $movement),
        'gender' => mysqli_real_escape_string($con, $gender),
        'brands' => mysqli_real_escape_string($con, $brand),
          'owner_number' => mysqli_real_escape_string($con, $owner_number),
        'reference_number' => mysqli_real_escape_string($con, $reference_number),
        'date_purchase' => mysqli_real_escape_string($con, $date_purchase),
        'status_watch' => mysqli_real_escape_string($con, $status_watch),
        'country' => mysqli_real_escape_string($con, $country),
        'size' => mysqli_real_escape_string($con, $size),
        'state' => mysqli_real_escape_string($con, $state),
          'date_purchase' => mysqli_real_escape_string($con, $date_purchase),
         'model_year' => mysqli_real_escape_string($con, $model_year),
         'currency_code' => mysqli_real_escape_string($con, $currency_code),
         'location' => mysqli_real_escape_string($con, $location),
        'description' => mysqli_real_escape_string($con, $description),
        'city' => mysqli_real_escape_string($con, $city),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit' && $_REQUEST['page'] == 'Request') {

        $getuploaderid = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_products where id='" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'"));
        $isFeePaid = $getuploaderid['auction_fee_paid'];


        $editQuery = "UPDATE `webshop_products` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'";


        mysqli_query($con, $editQuery);


        header('Location:list_product.php');
        exit();
    }
    
    else if ($_REQUEST['action'] == 'edit' && $_REQUEST['page'] == 'live') {

        $getuploaderid = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_products where id='" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'"));
        $isFeePaid = $getuploaderid['auction_fee_paid'];


        $editQuery = "UPDATE `webshop_products` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($con, $_REQUEST['id']) . "'";


        mysqli_query($con, $editQuery);


        header('Location:list_live_product.php');
        exit();
    }
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
                        Product <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?>  Product</small>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#"> Product</a>
                            <span class="divider">/</span>
                        </li>

                        <li>
                            <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Product</span>

                        </li>





                    </ul>
                    
                   <button onclick="goBack()">Go Back</button>
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
                            <h4><i class="icon-reorder"></i>Edit Product</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                
                                
<!--                                <div class="control-group">
                                    <label class="control-label">Name</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter name" value="<?php echo $categoryRowset['name']; ?>" name="name" readonly>
                                    </div>
                                </div>-->

                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter price" value="<?php echo $categoryRowset['price']; ?>" name="price"  readonly>
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
                                        <input type="text" class="form-control" placeholder="Enter movement" value="<?php echo $categoryRowset['movement']; ?>" name="movement" readonly>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <div class="controls">
                                        <input type="radio" name="gender" value="Female" <?php if ('Female' == $categoryRowset['gender']) { ?> checked <?php } ?> disabled='disabled'>Female&nbsp;
                                        <input type="radio" name="gender" value="Male" <?php if ('Male' == $categoryRowset['gender']) { ?> checked <?php } ?> disabled='disabled'>Male<br>
                                        <input type="radio" name="gender" value="Unisex" <?php if ('Unisex' == $categoryRowset['gender']) { ?> checked <?php } ?> disabled='disabled'>Unisex<br>
                                    </div>
                                </div>

                                <!--   <div class="control-group">
                                     <label class="control-label">Brand</label>
                                     <div class="controls">
                                     <input type="text" class="form-control" placeholder="Enter brand" value="<?php echo $getBrands['name']; ?>" name="brand" readonly>
                                     </div>
                                 </div> -->
                                
                                <div class="control-group">
                                    <label class="control-label">Brand</label>
                                    <div class="controls">
                                        <?php
                                        $sql = "SELECT * FROM webshop_brands";
                                        $result = mysqli_query($con, $sql);
                                        ?>
                                        <select name='brand' onchange="getCategory(this.value)" disabled='disabled'>
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
                                    <label class="control-label">Category</label>
                                    <div class="controls">
                                        <?php
                                        $sql = "SELECT * FROM webshop_category";
                                        $result = mysqli_query($con, $sql);
                                        ?>
                                        <select name="category_id" id="category_id" disabled='disabled'>
                                            <option value=''> Select Category</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value='<?php echo $row['id']; ?>'  <?php if ($row['id'] == $categoryRowset['cat_id']) { ?> selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
                                            <?php }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                
                                
                                <div class="control-group">
                                    <label class="control-label">Bracelet</label>
                                    <div class="controls">
                                        <?php
                                        $sql = "SELECT * FROM webshop_bracelet";
                                        $result = mysqli_query($con, $sql);
                                        ?>
                                        <select name='breslet_type' disabled='disabled'>
                                            <option value=''> Select Bracelet</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value='<?php echo $row['id']; ?>'  <?php if ($row['id'] == $categoryRowset['breslet_type']) { ?> selected="selected"<?php } ?>><?php echo $row['type']; ?></option>
                                            <?php }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                
                                <div class="control-group">
                                    <label class="control-label">Reference Number</label>
                                    <div class="controls">
                                        <input type="text" readonly class="form-control" placeholder="Enter reference number" value="<?php echo $categoryRowset['reference_number']; ?>" name="reference_number">
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Owner Number</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter owner number" value="<?php echo $categoryRowset['owner_number']; ?>" name="owner_number" readonly>
                                    </div>
                                </div>

                             <div class="control-group">
                                    <label class="control-label">Date of Purchase</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter purchase date" value="<?php echo $categoryRowset['date_purchase']; ?>" id="datepickerpurchase" name="date_purchase" readonly>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Model Year</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter Model Year" value="<?php echo $categoryRowset['model_year']; ?>" name="model_year" readonly>
                                    </div>
                                </div>

                                 <div class="control-group">
                                     <label class="control-label">Currency Code</label>
                                     <div class="controls">
                                         <input type="text" class="form-control" placeholder="Enter currency code" value="<?php echo $categoryRowset['currency_code']; ?>" name="currency_code" readonly>
                                     </div>
                                 </div>
                                 <div class="control-group">
                                     <label class="control-label">Location</label>
                                     <div class="controls">
                                         <input type="text" class="form-control" placeholder="Enter location" value="<?php echo $categoryRowset['location']; ?>" name="location" readonly>
                                     </div>
                                 </div>
                                
                                <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                <textarea rows="4" cols="50" class="ckeditor form-control" placeholder="Enter text" name ="description" readonly><?php echo $categoryRowset['description'];?></textarea>
                                </div> 
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Country</label>
                                    <div class="controls">
                                        <?php
                                        $sql = "SELECT * FROM webshop_countries";
                                        $resultcountry = mysqli_query($con, $sql);
                                        ?>
                                        <select name='country' id="country" onchange="getState(this.value)" disabled='disabled'>
                                            <option value=''> Select Country</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($resultcountry)) {
                                                ?>
                                                <option value='<?php echo $row['id']; ?>'  <?php if ($row['id'] == $categoryRowset['country']) { ?> selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
                                            <?php }
                                            ?>

                                        </select>

                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">State</label>
                                    <div class="controls">
                                        <?php
                                        $sql = "SELECT * FROM `webshop_states`";
                                        $resultstates = mysqli_query($con, $sql);
                                        ?>
                                        <select name='state' id="state" disabled='disabled'>
                                            <option value=''> Select State</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($resultstates)) {
                                                ?>
                                                <option value='<?php echo $row['id']; ?>'  <?php if ($row['id'] == $categoryRowset['state']) { ?> selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
                                            <?php }
                                            ?>

                                        </select>

                                    </div>
                                </div>

<!--                                <div class="control-group">
                                    <label class="control-label">City</label>
                                    <div class="controls" >
                                        <?php
                                        $sql = "SELECT * FROM 	webshop_cities";
                                        $resultcities = mysqli_query($con, $sql);
                                        ?>
                                        <div id="city">
                                        <select name='city' id="city" disabled>
                                            <option value=''> Select State</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($resultcities)) {
                                                ?>
                                                <option value='<?php echo $row['id']; ?>'  <?php if ($row['id'] == $categoryRowset['city']) { ?> selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
                                            <?php }
                                            ?>

                                        </select>
                                        </div>

                                    </div>
                                </div>-->

                                <div class="control-group">
                                    <label class="control-label">Size</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" placeholder="Enter size" value="<?php echo $categoryRowset['size']; ?>" name="size" readonly>
                                    </div>
                                </div>


                                <!--    <div class="control-group">
                                       <label class="control-label">Location</label>
                                       <div class="controls">
                                           <input type="text" class="form-control" placeholder="Enter location" value="<?php echo $categoryRowset['location']; ?>" name="location" readonly>
                                       </div>
                                   </div>
   
                                   <div class="control-group">
                                       <label class="control-label">Preferred Date</label>
                                       <div class="controls">
                                           <input type="text" class="form-control" placeholder="Enter preferred_date" id="datepicker" value="<?php echo $categoryRowset['preferred_date']; ?>" name="preferred_date" readonly>
                                       </div>
                                   </div>
   
   
                                <!--   <div class="control-group">
                                      <label class="control-label">Start Date</label>
                                      <div class="controls">
                                      <input type="text" class="form-control" placeholder="Enter start date" id="datepicker" value="<?php echo $categoryRowset['start_date_time']; ?>" name="start_date_time" readonly>
                                      </div>
                                  </div>
  
                                  <div class="control-group">
                                      <label class="control-label">End Date</label>
                                      <div class="controls">
                                      <input type="text" class="form-control" placeholder="Enter end date" id="datepickerr" value="<?php echo $categoryRowset['end_date_time']; ?>" name="end_date_time" readonly>
                                      </div>
                                  </div> 

                                <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                        <input type="file" name="imagee" class=" btn blue"  ><?php if ($categoryRowset['image'] != '') { ?><br><a href="../upload/product_image/<?php echo $categoryRowset['image']; ?>" target="_blank">View</a><?php } ?>
                                    </div>
                                </div>
                                -->
<!--                                <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Save</button>
                                    <button type="reset" id="cancle_product_edit" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                </div>-->
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

<script src="js/easy-pie-chart.js"></script>
<script src="js/sparkline-chart.js"></script>
<script src="js/home-page-calender.js"></script>
<script src="js/home-chartjs.js"></script>

<script>

    jQuery(function () {

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
    
     function getState(val) {
        $.ajax({
            type: "POST",
            url: "get_state.php",
            data: 'country=' + val,
            success: function (data) {
                $("#state").html(data);
            }
        });
    }
    
    function getCategory(val) {
        $.ajax({
            type: "POST",
            url: "get_brand.php",
            data: 'brand_id=' + val,
            success: function (data) {
                $("#category_id").html(data);
            }
        });
    }
    $("#cancle_product_edit").click(function(){
    window.location.href = "list_product.php";
}); 

function goBack() {
    window.history.back()
};
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
</style>