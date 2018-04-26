<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_REQUEST['submit']))
{
  $title = isset($_POST['title']) ? $_POST['title'] : '';
  $question = isset($_POST['question']) ? $_POST['question'] : '';
  $answer = isset($_POST['answer']) ? $_POST['answer'] : '';   
  $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';   
  $subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';   
  $date=date('Y-m-d');
  $fields = array(
            'title' => mysqli_real_escape_string($con,$title),
            'question' => mysqli_real_escape_string($con,$question),
            'answer' => mysqli_real_escape_string($con,$answer),
            'category_id' => mysqli_real_escape_string($con,$category_id),    
            'subcategory_id' => mysqli_real_escape_string($con,$subcategory_id),    
            'date' => $date,
    
    );
    $fieldsList = array();
    foreach ($fields as $field => $value) {
      $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
           
   if($_REQUEST['action']=='edit')
    {     
    $editQuery = "UPDATE `makeoffer_faq` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

    if (mysqli_query($con,$editQuery)) {
    
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating Category";
    }

    header('Location:list_faq.php');
    exit();
  
   }
   else
   {
   
   $addQuery = "INSERT INTO `makeoffer_faq` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
      
      //exit;
    mysqli_query($con,$addQuery);
    $last_id=mysqli_insert_id($con);
    header('Location:list_faq.php');
    exit();
  
   }
        
        
}
if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_faq` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}
$sql_parents=mysqli_query($con,"select * from makeoffer_faqcategories where parent_id=0");



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
                   Faq <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Faq</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Faq</a>
                          
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
                            <h4><i class="fa fa-gift"></i>Add Faq</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form action="add_faq.php" class="form-horizontal" method="post"  enctype="multipart/form-data">
                              <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>">
                              <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
                              <div class="control-group">
                                    <label class="control-label">Category</label>
                                    <div class="controls">
                                        <select name="category_id" required="" id="category_id" class="form-control">
                                        <option value="">Choose Category</option>    
                                        <?php
                                        while($parents=mysqli_fetch_assoc($sql_parents))
                                        {
                                        ?>
                                        <option value="<?php echo $parents['id']?>" <?php echo $parents["id"]==$categoryRowset['category_id']?'selected':''?>  ><?php echo $parents['name']?></option>
                                        <?php }?>
                                    
                                    </select>

                                    </div>
                                </div>
                                <?php
                               
                                ?>
                                <div class="control-group">
                                    <label class="control-label">Sub Category</label>
                                    <div class="controls">
                                    <?php    
                                      if($_REQUEST['action']=='edit')
                                    { 
                                    ?>      
                                        <select name="subcategory_id" required="" id="subcategory_id" class="form-control">
                                        <option value="">Choose Sub Category</option>    
                                        <?php
                                        $sql_parents=mysqli_query($con,"select * from `makeoffer_faqcategories` where parent_id='".$categoryRowset['category_id']."'");
                                        while($parents=mysqli_fetch_assoc($sql_parents))
                                        {
                                        ?>
                                        <option value="<?php echo $parents['id']?>" <?php echo $parents["id"]==$categoryRowset['subcategory_id']?'selected':''?>  ><?php echo $parents['name']?></option>
                                    <?php }?> 
                                    
                                    </select>
                                   <?php }else{?>    
   
                                        <select name="subcategory_id" required="" id="subcategory_id" class="form-control">
                                        <option value="">Choose Sub Category</option>    
                                    </select>    
                                   <?php }?>     
                                    </div>
                                </div>
                              
                              
                                
                                <div class="control-group">
                                    <label class="control-label">Title</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter Title"  value="<?php echo $categoryRowset['title']; ?>" name="title" required>

                                    </div>
                                </div>

                                  <div class="control-group">
                                    <label class="control-label">Question</label>
                                    <div class="controls">
                                     <input type="text" class="form-control" placeholder="Enter Question"  value="<?php echo $categoryRowset['question']; ?>" name="question" required>
                                    </div>
                                </div>

                                  <div class="control-group">
                                    <label class="control-label">Answer</label>
                                    <div class="controls">
                                        <textarea name="answer" required="" class="form-control" style=" height:100px; width:30%;"><?php echo $categoryRowset['answer']; ?></textarea>
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
   <script>
    $(document).ready(function(){
    $("#category_id").change(function(){
     $.get("ajax.php?action=populate_subcat&id="+this.value,function(out){
     $("#subcategory_id").html(out);     
     });    
    })    
    })   
   </script>  
   <style>
       input{ width:30%;}
       select{ width:31%;}
   </style>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
