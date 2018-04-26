<?php
header('Content-Type: text/html; charset=utf-8');

include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
/* Bulk Category Delete */
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_products.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_products.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "list_products.php?cid=" + aa + "&action=active";
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
                    <h3 class="page-title">Newsletter  list</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="#">Newsletter  list</a>

                        </li>







                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>List Newsletter</h4>
                            <form action="" method="post" >
                                                               <!--<i class="fa fa-edit"></i>Editable Table-->
                                <!--  <button type="submit"   name="ExportCsv"> Download Tools List</button> -->
                            </form>

                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->

                            <!--   <div class="control-group">
                                   <label class="control-label">Search by Product Name</label>
                                   <div class="controls">
                                  <input type="text" class="form-control" placeholder="Enter product name"  name="product_name" onkeyup="getProductName(this.value);">
                                   </div>
                               </div> -->
                            <input type="text" id="search" placeholder="search by name"></input>

                            <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>           
                                        <th>Name</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetch_tools_type = mysqli_query($con, "select * from webshop_newsletter ");
                                    $num = mysqli_num_rows($fetch_tools_type);
                                    if ($num > 0) {
                                        $i = 1;
                                        while ($tools_type = mysqli_fetch_array($fetch_tools_type)) {
                                            ?>

                                            <tr>


                                                <td>
                                                    <?php echo $i; ?>
                                                </td>

                                                <td>
                                                    <?php echo $tools_type['email'] ?>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7">Sorry, no record found.</td>
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

                                    var table = $('#editable-sample').DataTable();

                                    $('#search-date').on('change', function () {

                                        table
                                                .column(1)
                                                .search(this.value)
                                                .draw();

                                    });

                                });
</script>
<script type="text/javascript">

    function getProductName(productname) {

        var product = productname;
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {product_name: product},
            url: "get_productsname.php",
            success: function (data) {
                data1 = JSON.parse(data);
                console.log(data1.result);
            }
        });
    }

    $("#search").on("keyup", function () {
        var value = $(this).val();

        $("table tr").each(function (index) {
            if (index !== 0) {

                $row = $(this);

                var id = $.map($row.find('td'), function (element) {
                    return $(element).text()
                }).join(' ');

                if (id.indexOf(value) < 0) {
                    $row.hide();
                } else {
                    $row.show();
                }
            }
        });
    });
</script>

</body>
<!-- END BODY -->
</html>
