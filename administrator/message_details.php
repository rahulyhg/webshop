<?php
error_reporting(E_ALL);
//include_once("controller/productController.php");
include_once("./includes/session.php");
include_once("./includes/config.php");

//if($_REQUEST['action']=='details')
//
//{
  

//echo "SELECT * FROM `getfitpass_users` WHERE `id`='".$_REQUEST['id']."'";
//exit;
//$userRow = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$_REQUEST['id']."'"));
    
//$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `barter_product` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));

//$store_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_store` WHERE `id`='".mysql_real_escape_string($categoryRowset['store_id'])."'"));

//$category_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_category` WHERE `id`='".mysql_real_escape_string($categoryRowset['cat_id'])."'"));

//$subcategory_id = mysql_fetch_array(mysql_query("SELECT * FROM `barter_subcategory` WHERE `id`='".mysql_real_escape_string($categoryRowset['subcat'])."'"));


//}


?>


<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_product.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_product.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_product.php?cid="+aa+"&action=active";
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
              
                   <!--<h3 class="page-title">Details of <?php echo $userRow['fname']." ".$userRow['lname'] ;?></h3>-->
                  <h3 class="page-title">Message</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Message Details</a>
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
                        <div class="widget-body">
                            <!-- BEGIN Table-->
                              
                            


                            
<!--//////////////////////////////////////////////// Message Details Section /////////////////////////////////////////////////-->                   




<div class="messageDetail mt-5 pt-5">
	<div class="">
		<div class="">
			<div class="">
<?php 




/*

$get_read= mysqli_query($con, "SELECT * from webshop_message where to_id='".$_REQUEST['id']."' and is_read = 0");


while($check_readstatus = mysqli_fetch_array($get_read)){
$update_readstatus = mysqli_fetch_array(mysqli_query($con, "UPDATE webshop_message SET read_status = 1 where to_id ='0' AND from_id='".$_REQUEST['id']."'"));

} */



if(isset($_REQUEST['Send'])){
$message = isset($_POST['sendingMessage']) ? $_POST['sendingMessage'] : '';
$add_date = date('Y-m-d');

$insert_message = mysqli_query($con, "INSERT into webshop_message(from_id,to_id,message,add_date) VALUES ('0','".$_REQUEST['id']."','".$message."','".$add_date."')");
//$_SESSION['question_msg'] = 'Question posted successfully';
 header("Location:message_details.php?id=".$_REQUEST['id']);
  exit();
}




$all_messages2 = mysqli_query($con, "SELECT * from webshop_message where (from_id='0' AND to_id ='".$_REQUEST['id']."') OR (from_id='".$_REQUEST['id']."' AND to_id ='0') order by id");

while($chatsData = mysqli_fetch_array($all_messages2)){

$senderDetails = mysqli_fetch_array(mysqli_query($con, "SELECT * from webshop_user where id='".$chatsData['from_id']."'"));
	if($chatsData['from_id']=='0'){
?>			
				
				<div class="messageTop mb-5">
					<div class="msg-row">
						<div class="col-msg-text">
							<div class="messageBody messageBodySecond">
								<p class="mb-0"><?php echo $chatsData['message']; ?></p>
							</div>
						</div>
						<div class="col-msg-img">
						<!-- <div class="msg-pic" style="background-image: url('upload/user_image/<?php echo $user_name['image'];?>')">
                              </div> -->
							<div class="image" style="background-image: url('https://visualpharm.com/assets/314/Admin-595b40b65ba036ed117d36fe.svg')" no-repeat;">
							</div>
						</div>
						
					</div>
				</div>
                            
                            
				<?php } else { ?>
                            
                            
				<div class="messageTop mb-5">
					<div class="msg-row msg-me-row">
						<div class=" col-msg-img">
							<div class="image" style="background-image: url('../upload/user_image/<?php echo $senderDetails['image'];?>')" no-repeat;">
							</div>
						</div>
						<div class="col-msg-text">
							<div class="messageBody">
								<p class="mb-0"><?php echo $chatsData['message']; ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			
                            
                            <?php } ?>
                        
                            
                            
                        
				<form method="post">
				<div class="form-group">
                                    <textarea class="form-control" name="sendingMessage" rows="3" required style="width:100%;"></textarea>
				</div>
				 <input type="submit" class="btn btn-primary mt-2" name="Send" value="Send">
				<!-- <button type="button" class="btn btn-primary mt-2">Submit</button> -->
				</form>
			</div>
		</div>
	</div>
</div>

<!--/////////////////////////////////////////////// Message Details Section //////////////////////////////////////////////////-->  

                            
                            
                            
                            

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
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
   <style>
       .msg-row{
           overflow: hidden;
           margin-bottom: 20px;
       }
       .col-msg-img{
           float: left;
            width: 5%;
            margin-right: 3%;
            text-align: right;
       }
       .col-msg-img .image{           background-size: cover !important;
            width: 60px;
            height: 60px;
            border-radius: 100% !important;
       }
       .col-msg-text{width: 92%; float: left;}
       .msg-me-row .col-msg-img{
           
       }
   </style>
</body>
<!-- END BODY -->
</html>
