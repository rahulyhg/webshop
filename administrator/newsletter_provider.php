<?php
include_once('includes/session.php');
$target_path = "../news_image/";
//include_once("includes/session.php");
include_once("includes/config.php");
include_once("includes/functions.php");
include('includes/class.phpmailer.php');



if (isset($_REQUEST['submit'])) {
    $subject = $_POST['subject'];



    if (!empty($_REQUEST['email'])) {
        $email = implode(',', $_REQUEST['email']);
    } else {
        $SQL = "SELECT * FROM `teemedup_users` where `user_type`=2 and `activation_status`=1 and `block_status`=1";
        $result = mysql_query($SQL);
        while ($row1 = mysql_fetch_array($result)) {
            $emailarray[] = $row1['email'];
        }
        $email = implode(',', $emailarray);
    }
    $new_email = explode(',', $email);
    foreach ($new_email as $email_id) {
        $TemplateMessage = '';

        $SQL = "SELECT * FROM `teemedup_users` where email='" . $email_id . "'";
        $result = mysql_query($SQL);
        $row1 = mysql_fetch_array($result);


        $Subject1 = "$subject";
        $TemplateMessage.="<br/><br />Hi Provider,";
        $TemplateMessage.="<br>";
        
        $TemplateMessage.="Subject :" . $subject;
        $TemplateMessage.="<br>";
        $TemplateMessage.="Message :" . $_REQUEST['description'];
        $TemplateMessage.="<br><br>";
        $TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";
        $TemplateMessage.="Teemedup Team";
        $TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";



        $mail1 = new PHPMailer;
        $mail1->FromName = "Teemedup";
        $mail1->From = "info@teemedup.com";
        $mail1->Subject = $Subject1;
        $mail1->Body = stripslashes($TemplateMessage);
        $mail1->AltBody = stripslashes($TemplateMessage);
        $mail1->IsHTML(true);
        $mail1->AddAddress($email_id, "teemedup.com"); //info@salaryleak.com
        $mail1->Send();
        

            
       


        //unlink($full_image_path);
    }
    if (empty($_REQUEST['email'])) {
        $email = 'All';
    }
}
?>

<?php include('includes/header.php'); ?>
<!-- END HEADER -->


<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('includes/left_panel.php'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
            <?php //include('includes/style_customize.php'); ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
              Launch campaigns and offers
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Email to Providers</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <!--					<li>
                                                                    <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Category</span>
                                                            </li>-->
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Launch campaigns and offers
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>

                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="javascript:;" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">              
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" />

                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">All</label>
                                        <div class="col-md-4">
                                            <input type="checkbox" class="form-control" id="sel_user">&nbsp;Selected Provider
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Provider</label>
                                        <div class="col-md-4">
                                            <select id="selectError" class="form-control" style="width:450px;" name="email[]" multiple disabled>
                                                <?php
                                                $SQL = "SELECT * FROM `teemedup_users` where user_type=2 and `activation_status`=1 and `block_status`=1";
                                                $result = mysql_query($SQL);

                                                while ($row1 = mysql_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row1['email']; ?>"> <?php echo $row1['email']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Subject</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="subject" required >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Message</label>
                                        <div class="col-md-4">
                                            <textarea id="editor1" class="form-control" name="description" cols="55" rows="10" style="height:120px;width:450px;"></textarea>
                                        </div>
                                    </div>


                                    <!--                                        <div class="form-actions">
                                                                              <button name="submit" type="submit" class="btn btn-primary">Send</button>
                                                                             
                                                                            </div>-->
                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" value="Send" class="btn blue">
                                            <!--                                            <button type="submit" class="btn blue"  name="submit">Submit</button>-->
                                            <!-- <button type="button" class="btn default" onClick="location.href = 'javascript:void(0);'">Cancel</button> -->
                                        </div>
                                    </div>
                                </div>   
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>



    <style>
        .thumb{
            height: 60px;
            width: 60px;
            padding-left: 5px;
            padding-bottom: 5px;
        }

    </style>

    <script>


        window.preview_this_image = function (input) {

            if (input.files && input.files[0]) {
                $(input.files).each(function () {
                    var reader = new FileReader();
                    reader.readAsDataURL(this);
                    reader.onload = function (e) {
                        $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index:999;margin-top:-34px;'></span>");
                    }
                });
            }
        }
    </script>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');  ?>
    <!-- END QUICK SIDEBAR -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php'); ?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/form-samples.js"></script>
<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function () {
            // initiate layout and plugins
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            QuickSidebar.init(); // init quick sidebar
            Demo.init(); // init demo features
            FormSamples.init();

            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    orientation: "left",
                    autoclose: true,
                    language: "xx"
                });
            }

        });

</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>
<script>
    $(document).ready(function (e) {
        $("#sel_user").click(function () {
            if ($("#sel_user").is(':checked'))
            {

                $("#selectError").attr("disabled", false);
            } else {
                $("#selectError").attr("disabled", true);
            }
        });
    });
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
